<?php

namespace App\Http\Controllers;

use App\Helpers\UserActionLogHelper;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\AdminPublicGrievance;
use App\Models\PropertySectionMapping;
use App\Models\Item; // Import the new model
use App\Models\GrievanceRemark;
use App\Services\ColonyService;
use App\Services\CommonService;
use Illuminate\Support\Facades\Log;
use App\Services\SettingsService;
use App\Services\CommunicationService;
use App\Mail\CommonMail;
use Illuminate\Support\Facades\Mail;
use App\Models\Country;
use DB;
use Crypt;
use Auth;

class AdminPublicGrievanceController extends Controller
{

    protected $communicationService;
    protected $settingsService;

    public function __construct(CommunicationService $communicationService, SettingsService $settingsService)
    {

        $this->communicationService = $communicationService;
        $this->settingsService = $settingsService;
    }

    public function create(ColonyService $colonyService)
    {
        $colonyList = $colonyService->getColonyList();
        $countries = Country::where('phonecode','!=',0)->orderBy('name','asc')->get();
        return view('admin_public_grievances.create', compact(['colonyList', 'countries']));
    }

    // Method to show the grievance list view with DataTables
    public function index(Request $request)
    {
        if (!$request->user()->can('view.grievance') && !$request->user()->can('add.grievance')) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }
        // Fetch the list of statuses with group_id = 17004
        $statuses = Item::where('group_id', 17004)
            ->orderBy('Item_order')
            ->get();

        $grievances = AdminPublicGrievance::with(['remarks.creator'])->get();

        // Pass the statuses to the view
        return view('admin_public_grievances.indexDatatable', compact('statuses', 'grievances'));
    }

    public function getGrievances(Request $request)
    {
        $columns = ['id', 'unique_id', 'name', 'mobile', 'email', 'description', 'status', 'remark', 'comm_address'];
    
        $user = auth()->user(); 
        $userRole = $user->getRoleNames()->first(); // Get the primary role of the user
    
        $query = AdminPublicGrievance::with(['colonyName', 'sectionName', 'statusItem', 'remarks.creator'])
                ->select('admin_public_grievances.*');
    
        // Apply role-based filtering
        if ($userRole == 'section-officer') {
            $sectionIds = $user->sections->pluck('id'); // Assuming you have a relationship 'sections' on your User model
            $query->whereIn('section_ids', $sectionIds); // Filter grievances by section IDs
        }
    
        // Apply status filter if provided and ensure it matches `item_code` in `Item` table
        if (!empty($request->input('status'))) {
            $query->whereHas('statusItem', function ($q) use ($request) {
                $q->where('item_code', $request->input('status'));
            });
        }
    
        // Apply search filter
        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('unique_id', 'like', "%{$search}%")
                    ->orWhere('name', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('communication_address', 'like', "%{$search}%")
                    ->orWhereHas('colonyName', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('sectionName', function ($q) use ($search) {
                        $q->where('section_code', 'like', "%{$search}%");
                    })
                    ->orWhereHas('statusItem', function ($q) use ($search) {
                        $q->where('item_name', 'like', "%{$search}%");
                    })
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $totalData = $query->count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $order = $columns[$orderColumnIndex] ?? 'unique_id';
        $dir = $request->input('order.0.dir', 'asc');

        $query->offset($start)->limit($limit)->orderBy($order, $dir);

        $grievances = $query->get();

        $statusClasses = [
            'PG_CAN' => 'badge-cancelled',
            'PG_NEW' => 'badge-new',
            'PG_PEN' => 'badge-pending',
            'PG_REO' => 'badge-reopen',
            'PG_INP' => 'badge-inprocess',
            'PG_RES' => 'badge-resolved'
        ];

        $data = [];
        foreach ($grievances as $grievance) {
            $nestedData['unique_id'] = $grievance->unique_id;
            $nestedData['name'] = $grievance->name;
            $nestedData['mobile'] = $grievance->mobile;
            $nestedData['email'] = $grievance->email;

            $nestedData['locality'] = $grievance->colonyName->name;
            $nestedData['section'] = $grievance->sectionName->section_code;
            $nestedData['description'] = $grievance->description;
            $class = $statusClasses[$grievance->statusItem->item_code] ?? 'text-secondary bg-light';

            $nestedData['status'] = '<span class="theme-badge ' . $class . '">' . ucwords($grievance->statusItem->item_name) . '</span>'; // Ensure there is a fallback if no statusItem


            $latestRemark = $grievance->remarks->sortByDesc('created_at')->first();
            if ($latestRemark) {
                $createdBy = $latestRemark->creator->name;
                $createdAt = $latestRemark->created_at->format('Y-m-d');
                $shortRemark = strlen($latestRemark->remark) > 20 ? substr($latestRemark->remark, 0, 20) . '...' : $latestRemark->remark;

                // Modified HTML for inline View More and remark alignment with styling
                $remarkInfo = '<div>'
                    . '<div style="display: flex; justify-content: space-between; align-items: center;">'
                    . '<span>' . htmlspecialchars($shortRemark) . '</span>' // Left-aligned remark
                    . '<a href="#" style="font-size: smaller; font-weight: 700;" data-bs-toggle="modal" data-bs-target="#viewMoreModal' . $grievance->id . '">View More</a></div>' // View More on the right, bold
                    . '<div style="font-size: smaller; color: #adaaaa;">('
                    .  $createdBy . ', ' . $createdAt . ')</div>' // Creator and date in grey
                    . '</div>';
            } else {
                $remarkInfo = 'No remarks';
            }
            $nestedData['remark'] = $remarkInfo;



            // Initialize action buttons
    $actionButtons = '';

    // Check for edit.grievance permission before displaying the Edit button
    if (auth()->user()->can('edit.grievance')&& in_array($grievance->statusItem->item_code, ['PG_NEW','PG_PEN', 'PG_REO'])) {
        $actionButtons .= '<a href="' . route('grievance.edit', $grievance->id) . '" class="btn btn-sm btn-primary">Edit</a>';
    }

    // when 'Add Remarks' button should be shown based on user role and grievance status
    if (
        ($userRole === 'CDN' && in_array($grievance->statusItem->item_code, ['PG_RES', 'PG_CAN'])) || // 'cdn-admin' can add remarks only for 'Resolved' or 'Cancelled' grievances
        ($userRole !== 'CDN' && !in_array($grievance->statusItem->item_code, ['PG_RES', 'PG_CAN'])) // Other users can add remarks only if status is not 'Resolved' or 'Cancelled'
    ) {
        if (auth()->user()->can('add.remark.grievance')) {
            $actionButtons .= ' <button type="button" onclick="openRemarksModal(' . $grievance->id . ')" class="btn btn-sm btn-secondary">Add Remarks</button>';
        }
    }


    $nestedData['action'] = $actionButtons;


            $nestedData['communication address'] = $grievance->communication_address;

            $data[] = $nestedData;
        }

        return response()->json([
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalData),
            "data" => $data,
        ]);
    }


    public function storeInitial(Request $request, CommonService $commonService)
    {
        // Validate the initial form data without the recording
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'countryCode' => 'required|numeric',
            'mobile' => 'required|numeric|digits:10',
            'email' => 'required|email',
            'comm_address' => 'required|string',
            'localityFill' => 'required|string',
            'property_id' => 'nullable|string',
            'description' => 'required|string|max:255'
        ]);

       // Define the status codes considered for the new request validation
        $activeStatuses = [
            getStatusName('PG_NEW'), 
            getStatusName('PG_PEN'), 
            getStatusName('PG_INP'), 
            getStatusName('PG_REO')
        ];

        // Check for existing grievance with the same email, mobile, colony and active status
        $existingGrievance = AdminPublicGrievance::where('email', $validatedData['email'])
                            ->where('mobile', $validatedData['mobile'])
                            ->where('colony', $validatedData['localityFill'])
                            ->whereIn('status', $activeStatuses)
                            ->exists();

        if ($existingGrievance) {
            return redirect()->back()->withErrors(['message' => 'A grievance with the same email, mobile, and locality is currently active and cannot create a new one.']);
        }

        // Generate unique ticket ID using CommonService
        $uniqueId = $commonService->getUniqueID(AdminPublicGrievance::class, 'TKT', 'unique_id');

        // Fetch the section_id from property_section_mappings table using colony_id
        $colonyId = $validatedData['localityFill'];
        $sectionMapping = PropertySectionMapping::where('colony_id', $colonyId)->first();

        if (!$sectionMapping) {
            return redirect()->back()->withErrors(['message' => 'No section found for the selected colony.']);
        }

        $sectionId = $sectionMapping->section_id;

        // Store the initial data in the database
        $grievance = new AdminPublicGrievance();
        $grievance->unique_id = $uniqueId;
        $grievance->name = $validatedData['name'];
        $grievance->email = $validatedData['email'];
        $grievance->country_code = $validatedData['countryCode'];
        $grievance->mobile = $validatedData['mobile'];
        $grievance->communication_address = $validatedData['comm_address'];
        $grievance->colony = $validatedData['localityFill'];
        $grievance->old_property_id = $validatedData['property_id'];
        $grievance->description = $validatedData['description'];
        $grievance->section_ids = $sectionId;
        $grievance->status = getStatusName('PG_NEW');
        $grievance->created_by = auth()->id();
        $grievance->updated_by = auth()->id();
        $grievance->save();

        // Add user action logs create grievances - Lalit (28/Oct/2024)
        $grievances_link = '<a href="' . url("/grievances") . '" target="_blank">' . $uniqueId . '</a>';
        UserActionLogHelper::UserActionLog('create', url("/grievances"), 'grievances', "New grievances ".$grievances_link." has been created by user " . Auth::user()->name . ".");

        $notificationData = [
            'name' => $grievance->name,
            'ticket_id' => $grievance->unique_id
        ];

        $action = 'N_PG_NEW';

        // Send notifications
        $this->settingsService->applyMailSettings($action);
        Mail::to($grievance->email)->send(new CommonMail($notificationData, $action));
        $this->communicationService->sendSmsMessage($notificationData, $grievance->mobile, $action);
        $this->communicationService->sendWhatsAppMessage($notificationData, $grievance->mobile, $action);

        return redirect()->route('grievance.create')
                         ->with(['grievance_id' => $grievance->id,
                                      'open_modal' => true,
                                      'ticket_id' => $grievance->unique_id 
                                     ]);
    }




    public function uploadRecording(Request $request)
    {
        $validatedData = $request->validate([
            'grievance_id' => 'required|exists:admin_public_grievances,id',
            'recording' => 'required|file|mimes:mp3,wav,m4a,ogg|max:25600',
        ]);

        try {
            $grievance = AdminPublicGrievance::findOrFail($validatedData['grievance_id']);

            // Handle the file upload
            $dateandtime = now()->format('YmdHis');
            if ($request->hasFile('recording')) {
                $fileName = "{$grievance->unique_id}_{$dateandtime}." . $request->recording->getClientOriginalExtension();
                $path = $request->recording->storeAs('recordings', $fileName, 'public');
                $grievance->recording = $path;
                $grievance->save();

                // Add user action log
                $grievances_link = '<a href="' . url("/grievances") . '" target="_blank">' . $validatedData['grievance_id'] . '</a>';
                UserActionLogHelper::UserActionLog(
                    'recording_uploaded',
                    url("/grievances"),
                    'grievances',
                    "Recording is uploaded for " . $grievances_link . " by user " . Auth::user()->name . "."
                );
            }

            return redirect()->route('grievance.index')->with('success', 'Recording uploaded successfully.');

        } catch (\Exception $e) {
            // Log the error and redirect back to the modal with an error message
            Log::error('Recording upload failed: ' . $e->getMessage());
            return redirect()->back()->withErrors(['recording' => 'Failed to upload the recording. Please try again.']);
        }
    }



    public function edit($id, ColonyService $colonyService)
    {
        $grievance = AdminPublicGrievance::findOrFail($id);
        $countries = Country::where('phonecode','!=',0)->orderBy('name','asc')->get();
        $colonyList = $colonyService->getColonyList();
        return view('admin_public_grievances.create', compact('grievance', 'colonyList', 'countries'));
    }

    public function update(Request $request, $id, CommonService $commonService)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'countryCode' => 'required|numeric',
            'mobile' => 'required|numeric|digits:10',
            'email' => 'required|email',
            'comm_address' => 'required|string',
            'localityFill' => 'required|string',
            'property_id' => 'nullable|string',
            'description' => 'required|string|max:255',
            'recording' => 'nullable|file|mimes:mp3,wav,m4a,ogg|max:25600'
        ]);

        $grievance = AdminPublicGrievance::findOrFail($id);
        $grievance->name = $validatedData['name'];
        $grievance->email = $validatedData['email'];
        $grievance->country_code = $validatedData['countryCode'];
        $grievance->mobile = $validatedData['mobile'];
        $grievance->communication_address = $validatedData['comm_address'];
        $grievance->colony = $validatedData['localityFill'];
        $grievance->old_property_id = $validatedData['property_id'];
        $grievance->description = $validatedData['description'];
        $grievance->section_ids = PropertySectionMapping::where('colony_id', $validatedData['localityFill'])->first()->section_id;


        // Handle recording file upload
        if ($request->hasFile('recording')) {
            $dateandtime = now()->format('YmdHis');
            $fileName = "{$grievance->unique_id}_{$dateandtime}." . $request->recording->getClientOriginalExtension();
            $path = $request->recording->storeAs('recordings', $fileName, 'public');
            $grievance->recording = $path; // save the new recording path
        }

        $grievance->updated_by = auth()->id();
        $grievance->save();

        // Add user action logs create grievances - Lalit (28/Oct/2024)
        $grievances_link = '<a href="' . url("/grievances") . '" target="_blank">' . $id . '</a>';
        UserActionLogHelper::UserActionLog('update', url("/grievances"), 'grievances', "grievances ".$grievances_link." has been updated by user " . Auth::user()->name . ".");

        return redirect()->route('grievance.index')->with('success', 'Grievance updated successfully.');
    }

    // public function showRemarks($id)
    // {
    //     $grievance = AdminPublicGrievance::with('statusItem')->findOrFail($id);
    //     $statuses = Item::where('group_id', 17004)->get();

    //     return view('admin_public_grievances.remarks', compact('grievance', 'statuses'));
    // }

    public function getGrievanceDetails($id)
    {
        $grievance = AdminPublicGrievance::with('statusItem')->findOrFail($id);
        $statuses = Item::where('group_id', 17004)
            ->orderBy('Item_order')
            ->get();

        // Fetch the first role of the logged-in user
        $roleName = Auth::user()->getRoleNames()->first(); // This will fetch the first assigned role

        return response()->json([
            'grievance' => $grievance,
            'statuses' => $statuses,
            'userRole' => $roleName // Add this line to pass user role
        ]);
    }


    // public function updateRemarks(Request $request, $id)
    // {
    //     $grievance = AdminPublicGrievance::with('statusItem')->findOrFail($id);
    //     $originalStatus = $grievance->statusItem->item_code;
    
    //     // Apply conditional validation: Status is not required if the original status is 'PG_NEW' or 'PG_REO'
    //     $rules = ['grievance_remark' => 'required|string|max:1024'];
    //     if (!in_array($originalStatus, ['PG_NEW', 'PG_REO', 'PG_PEN'])) {
    //         $rules['status'] = 'required|string|exists:items,item_code';
    //     }
        
    //     $validatedData = $request->validate($rules);
    //     // $status = $request->input('status');

    //     // Determine the new status based on the original status and requested status
    // $requestedStatus = $request->input('status');
    //     if (in_array($originalStatus, ['PG_NEW', 'PG_REO', 'PG_PEN'])) {
    //         if ($originalStatus === $requestedStatus) {
    //             // Enforce transition to 'PG_INP' if original and requested status are the same and fall under specified statuses
    //             $status = 'PG_INP';
    //         } else {
    //             // Save the requested status if original and requested status are different
    //             $status = $requestedStatus;
    //         }
    //     } else {
    //         // For other statuses, use the requested status
    //         $status = $requestedStatus;
    //     }
    
    
    //     // Decide the new status based on special rules
    //     // switch ($originalStatus) {
    //     //     case 'PG_NEW':
    //     //         $status = 'PG_INP'; // Force transition if currently "New"
    //     //         break;
    //     //     case 'PG_REO':
    //     //         $status = 'PG_INP'; // Force transition if currently "Reopen"
    //     //         break;
    //     //     case 'PG_PEN':
    //     //             $status = 'PG_INP'; // Force transition if currently "Pending"
    //     //             break;
    //     //     default:
    //     //         $status = $request->input('status'); // Use the provided status otherwise
    //     //         break;
    //     // }
    
    //     DB::beginTransaction();
    //     try {
    //         \Log::info("Updating Grievance ID: {$id}, Original Status: {$originalStatus}, Requested Status: {$request->input('status')}, Final Status: {$status}");
    
    //         // Update the grievance record
    //         $grievance->remark = $validatedData['grievance_remark'];
    //         $grievance->status = getStatusName($status);
    //         $grievance->save();
    
    //         // Create a new remark entry
    //         $newRemark = new GrievanceRemark([
    //             'grievance_id' => $id,
    //             'remark' => $validatedData['grievance_remark'],
    //             'status' => getStatusName($status),
    //             'created_by' => auth()->id(),
    //         ]);
    //         $newRemark->save();

    //         // Add user action logs create grievances - Lalit (28/Oct/2024)
    //         $grievances_link = '<a href="' . url("/grievances") . '" target="_blank">' . $id . '</a>';
    //         UserActionLogHelper::UserActionLog('update', url("/grievances"), 'grievances', "grievances ".$grievances_link." status ".getServiceNameById($status)." has been updated by user " . Auth::user()->name . " with remark ".$validatedData['grievance_remark'].".");   
            
    //         // Check specifically for a change from PG_NEW to PG_INP
    //         if ($originalStatus == 'PG_NEW' && $status == 'PG_INP') {
    //             $notificationData = [
    //                 'name' => $grievance->name,
    //                 'ticket_id' => $grievance->unique_id
    //             ];

    //             $this->settingsService->applyMailSettings('N_PG_INP');
    //             Mail::to($grievance->email)->send(new CommonMail($notificationData, 'N_PG_INP'));
    //             $this->communicationService->sendSmsMessage($notificationData, $grievance->mobile, 'N_PG_INP');
    //             $this->communicationService->sendWhatsAppMessage($notificationData, $grievance->mobile, 'N_PG_INP');
    //         }

    //         // Prepare notification data for other status changes
    //         $notificationData = [
    //             'name' => $grievance->name,
    //             'ticket_id' => $grievance->unique_id
    //         ];

    //         // Array of actions excluding PG_INP which is already handled above
    //         $actions = [
    //             'PG_RES' => 'N_PG_RES',
    //             'PG_CAN' => 'N_PG_CAN',
    //             'PG_REO' => 'N_PG_REO'
    //         ];

    //         // Send notifications for other status changes
    //         if (array_key_exists($status, $actions)) {
    //             $action = $actions[$status];
    //             $this->settingsService->applyMailSettings($action);
    //             Mail::to($grievance->email)->send(new CommonMail($notificationData, $action));
    //             $this->communicationService->sendSmsMessage($notificationData, $grievance->mobile, $action);
    //             $this->communicationService->sendWhatsAppMessage($notificationData, $grievance->mobile, $action);
    //         }


    //         DB::commit();
    //         // return response()->json(['success' => 'Grievance and remarks updated successfully.']);
    //         return redirect()->back()->with('success', 'Grievance updated successfully.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return response()->back()->with('error', 'Grievance updation failed.');
    //     }
    // }


    public function updateRemarks(Request $request, $id)
    {
        $grievance = AdminPublicGrievance::with('statusItem')->findOrFail($id);
        $originalStatus = $grievance->statusItem->item_code;
        $requestedStatus = $request->input('status');
        $userRole = auth()->user()->getRoleNames()->first();

        // Validation for remarks
        $rules = ['grievance_remark' => 'required|string|max:1024'];
        $request->validate($rules);

        // Enforce role-based status change restrictions
        if ($userRole === 'CDN') {
            if ($requestedStatus !== 'PG_REO') {
                return redirect()->back()->withErrors(['status' => 'Unauthorized status change for your role.']);
            }
        } elseif (in_array($userRole, ['section-officer', 'super-admin'])) {
            if (in_array($requestedStatus, ['PG_NEW', 'PG_REO', 'PG_PEN'])) {
                return redirect()->back()->withErrors(['status' => 'Cannot select this status.']);
            }
        }

        // Determine the new status based on original and requested statuses
        $status = ($originalStatus === $requestedStatus && in_array($originalStatus, ['PG_NEW', 'PG_REO', 'PG_PEN']))
            ? 'PG_INP'
            : $requestedStatus;

        DB::beginTransaction();
        try {
            // Save remark and new status in `admin_public_grievances` table
            $grievance->remark = $request->input('grievance_remark'); // Save latest remark
            $grievance->status = getStatusName($status); // Update the status
            $grievance->save();

            // Create a new entry in `grievance_remarks` table
            $newRemark = new GrievanceRemark([
                'grievance_id' => $id,
                'remark' => $request->input('grievance_remark'),
                'status' => getStatusName($status),
                'created_by' => auth()->id(),
            ]);
            $newRemark->save();

            // Log and send notifications as needed
            UserActionLogHelper::UserActionLog('update', url("/grievances"), 'grievances', "Grievance status updated to " . getServiceNameById($status) . " with remark.");

            DB::commit();
            return redirect()->back()->with('success', 'Grievance updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Grievance update failed.');
        }
    }


}
