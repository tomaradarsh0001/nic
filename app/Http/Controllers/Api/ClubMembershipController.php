<?php 

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ClubMembership;
use App\Models\ClubMembershipDgc;
use App\Models\ClubMembershipIhc;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;

class ClubMembershipController extends Controller
{
    //Post Api for submitting club memberships form on website for oth IHC and DGC by Swati Mishra on 26-01-25
    public function store(Request $request, $club_type)
    {
        if (!in_array($club_type, ['IHC', 'DGC'])) {
            return response()->json(['error' => 'Invalid club type provided'], 400);
        }
    
        // Check if the user already has a membership with the same club type
        $existingMembership = ClubMembership::where('email', $request->email)
            ->where('club_type', $club_type)
            ->exists();
    
        if ($existingMembership) {
            return response()->json(['error' => 'You have already applied for this club type'], 409);
        }
    
        // Fetch the status ID from the items table where item_code is 'CM_NEW'
        $statusItem = DB::table('items')->where('item_code', 'CM_NEW')->first();
    
        if (!$statusItem) {
            return response()->json(['error' => 'Status item not found in items table'], 500);
        }
    
        $validator = Validator::make($request->all(), [
            'category' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'designation_equivalent_to' => 'required|string|max:255',
            'department' => 'required|string|max:255',
            'mobile' => 'required|string|size:10',
            'email' => 'required|email|max:255',
            'name_of_service' => 'required|string|max:255',
            'year_of_allotment' => 'required|integer',
            'date_of_joining_central_deputation' => 'nullable|date',
            'expected_date_of_tenure_completion' => 'nullable|date',
            'date_of_superannuation' => 'required|date',
            'office_address' => 'required|string|max:255',
            'pay_scale' => 'required|string|max:255',
            'present_previous_membership_of_other_clubs' => 'nullable|string|max:255',
            'other_relevant_information' => 'nullable|string|max:255',
            'consent' => 'required|boolean',
            // 'date_of_application' => 'required|date',
        ]);
    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
    
        DB::beginTransaction();
        try {
            $membership = ClubMembership::create([
                'category' => $request->category,
                'name' => $request->name,
                'designation' => $request->designation,
                'designation_equivalent_to' => $request->designation_equivalent_to,
                'department' => $request->department,
                'mobile' => $request->mobile,
                'email' => $request->email,
                'name_of_service' => $request->name_of_service,
                'year_of_allotment' => $request->year_of_allotment,
                'club_type' => $club_type,
                'date_of_joining_central_deputation' => $request->date_of_joining_central_deputation ?? null,
                'expected_date_of_tenure_completion' => $request->expected_date_of_tenure_completion ?? null,
                'date_of_superannuation' => $request->date_of_superannuation,
                'office_address' => $request->office_address,
                'telephone_no' => $request->telephone_no ?? null,
                'pay_scale' => $request->pay_scale,
                'present_previous_membership_of_other_clubs' => $request->present_previous_membership_of_other_clubs,
                'other_relevant_information' => $request->other_relevant_information ?? null,
                'consent' => $request->consent,
                'status' => $statusItem->id, // Store the fetched status ID from items table
                'date_of_application' => now()->toDateString(),
            ]);
    
            if ($club_type === 'IHC') {
                $ihcValidator = Validator::make($request->all(), [
                    'individual_membership_date_and_remark' => 'nullable|string|max:255',
                    'dgc_tenure_start_date' => 'nullable|date',
                    'dgc_tenure_end_date' => 'nullable|date',
                ]);
    
                if ($ihcValidator->fails()) {
                    DB::rollBack();
                    return response()->json(['errors' => $ihcValidator->errors()], 422);
                }
    
                ClubMembershipIhc::create([
                    'membership_app_id' => $membership->id,
                    'individual_membership_date_and_remark' => $request->individual_membership_date_and_remark ?? null,
                    'dgc_tenure_start_date' => $request->dgc_tenure_start_date ?? null,
                    'dgc_tenure_end_date' => $request->dgc_tenure_end_date ?? null,
                ]);
            } elseif ($club_type === 'DGC') {
                $dgcValidator = Validator::make($request->all(), [
                    'is_post_under_central_staffing_scheme' => 'nullable|string|max:255',
                    'regular_membership_date_and_remark' => 'nullable|string|max:255',
                    'dgc_tenure_start_date' => 'nullable|date',
                    'dgc_tenure_end_date' => 'nullable|date',
                    'handicap_certification' => 'nullable|string|max:255',
                    'ihc_nomination_date' => 'nullable|date',
                ]);
    
                if ($dgcValidator->fails()) {
                    DB::rollBack();
                    return response()->json(['errors' => $dgcValidator->errors()], 422);
                }
    
                ClubMembershipDgc::create([
                    'membership_app_id' => $membership->id,
                    'is_post_under_central_staffing_scheme' => $request->is_post_under_central_staffing_scheme ?? null,
                    'regular_membership_date_and_remark' => $request->regular_membership_date_and_remark ?? null,
                    'dgc_tenure_start_date' => $request->dgc_tenure_start_date ?? null,
                    'dgc_tenure_end_date' => $request->dgc_tenure_end_date ?? null,
                    'handicap_certification' => $request->handicap_certification ?? null,
                    'ihc_nomination_date' => $request->ihc_nomination_date ?? null,
                ]);
            }
    
            DB::commit();
    
            return response()->json(['message' => 'Membership created successfully', 'id' => $membership->id], 201);
    
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'An error occurred while processing your request', 'details' => $e->getMessage()], 500);
        }
    }
    

//Get Api for Club Membership listings on the basis of status by Swati Mishra on 29-01-2025
    public function index($club_type, $status_name)
    {
        if (!in_array($club_type, ['IHC', 'DGC'])) {
            return response()->json(['error' => 'Invalid club type provided'], 400);
        }

        // Convert single status to an array if needed
        $statusNames = explode(',', $status_name);  // Convert CSV to array
        $statusIds = DB::table('items')
            ->whereIn('item_name', $statusNames)
            ->where('group_id', 17012)
            ->pluck('id'); // Get multiple status IDs

        if ($statusIds->isEmpty()) {
            return response()->json(['error' => 'Invalid status name provided'], 404);
        }

        // Fetch memberships for multiple statuses
        $memberships = ClubMembership::where('club_type', $club_type)
            ->whereIn('status', $statusIds)  // Updated to support multiple statuses
            ->where('category', '!=', 'Others')
            ->with($club_type === 'IHC' ? 'ihcDetails' : 'dgcDetails')
            ->get()
            ->map(function ($membership) use ($club_type) {
                $fileUploaded = $club_type === 'IHC' 
                    ? optional($membership->ihcDetails)->ihcs_doc 
                    : optional($membership->dgcDetails)->dgcs_doc;

                return array_merge($membership->toArray(), ['file_uploaded' => $fileUploaded]);
            });

        if ($memberships->isEmpty()) {
            return response()->json(['message' => 'No membership records found for this club type and status'], 404);
        }

        return response()->json(['memberships' => $memberships], 200);
    }



    //Post api for upload document of Club Membership by Swati Mishra on 02-02-2025
    public function uploadDocument(Request $request, $club_type, $membership_app_id)
    {
        if (!in_array($club_type, ['IHC', 'DGC'])) {
            return response()->json(['error' => 'Invalid club type provided'], 400);
        }

        // Validate request
        $validator = Validator::make($request->all(), [
            'document' => 'required|file|mimes:pdf|max:5120', // Max size 5MB, only PDF allowed
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Check if the membership exists
        $membership = ClubMembership::find($membership_app_id);
        if (!$membership) {
            return response()->json(['error' => 'Membership not found'], 404);
        }

        // Store the uploaded file
        if ($request->hasFile('document')) {
            $file = $request->file('document');

            // Generate a unique filename: {membership_app_id}_{club_type}_YYYYMMDD_HHMMSS.pdf
            $timestamp = now()->format('Ymd_His');
            $filename = "{$membership_app_id}_{$club_type}_{$timestamp}.pdf";

            // Store file in storage/app/public/documents/
            $path = $file->storeAs('documents', $filename);

            try {
                DB::beginTransaction();

                if ($club_type === 'IHC') {
                    $membershipDetails = ClubMembershipIhc::where('membership_app_id', $membership_app_id)->first();

                    if (!$membershipDetails) {
                        DB::rollBack();
                        return response()->json(['error' => 'IHC membership details not found'], 404);
                    }

                    // Save file path in `ihcs_doc` column
                    $membershipDetails->update(['ihcs_doc' => $path]);

                } elseif ($club_type === 'DGC') {
                    $membershipDetails = ClubMembershipDgc::where('membership_app_id', $membership_app_id)->first();

                    if (!$membershipDetails) {
                        DB::rollBack();
                        return response()->json(['error' => 'DGC membership details not found'], 404);
                    }

                    // Save file path in `dgcs_doc` column
                    $membershipDetails->update(['dgcs_doc' => $path]);
                }

                DB::commit();
                return response()->json(['message' => 'Document uploaded successfully', 'file_path' => $path], 200);
            } catch (\Exception $e) {
                DB::rollBack();
                return response()->json(['error' => 'An error occurred while uploading the document', 'details' => $e->getMessage()], 500);
            }
        }

        return response()->json(['error' => 'File not uploaded'], 400);
    }
    //Get Api for club membership table data for a particular record by Swati Mishra on 03-02-2025
    public function downloadMembershipPdf($membership_id)
    {
        // Fetch membership with club_type
        $membership = ClubMembership::find($membership_id);

        // Check if membership exists
        if (!$membership) {
            abort(404, 'Membership not found');
        }

        // Determine the correct relationship dynamically
        $relation = $membership->club_type == 'IHC' ? 'ihcDetails' : ($membership->club_type == 'DGC' ? 'dgcDetails' : null);

        if (!$relation) {
            return response()->json(['error' => 'Invalid club_type'], 400);
        }

        // Load relationship
        $membership->load($relation);

        // Generate PDF using Blade template
        $pdf = Pdf::loadView('club_membership.download_pdf', ['membership' => $membership]);

        // Generate a filename
        $filename = "Membership_{$membership_id}.pdf";

        return $pdf->download($filename);
    }

    //Post Api Category Filter Api for club membership listing by Swati Mishra on 04-02-2025
    public function filterByClubStatusCategory(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'club_type' => 'required|in:IHC,DGC',
            'status_name' => 'required|string',  // Now supports comma-separated values
            'category' => 'required|string'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $club_type = $request->club_type;
        $status_names = explode(',', $request->status_name); // Convert CSV string to array
        $category = $request->category;

        // Fetch corresponding status IDs from `items` table
        $statusIds = DB::table('items')
            ->whereIn('item_name', $status_names)
            ->where('group_id', 17012)
            ->pluck('id'); // Get multiple status IDs

        if ($statusIds->isEmpty()) {
            return response()->json(['error' => 'Invalid status name(s) provided'], 404);
        }

        // Fetch memberships based on club type, multiple statuses, and category
        $memberships = ClubMembership::where('club_type', $club_type)
            ->whereIn('status', $statusIds)  // ✅ Modified to handle multiple statuses
            ->where('category', $category)
            ->with($club_type === 'IHC' ? 'ihcDetails' : 'dgcDetails') // Dynamically include related details
            ->get()
            ->map(function ($membership) use ($club_type) {
                // Extract file upload status dynamically
                $fileUploaded = $club_type === 'IHC' 
                    ? optional($membership->ihcDetails)->ihcs_doc 
                    : optional($membership->dgcDetails)->dgcs_doc;

                // Return all membership fields dynamically + file uploaded status
                return array_merge($membership->toArray(), ['file_uploaded' => $fileUploaded]);
            });

        if ($memberships->isEmpty()) {
            return response()->json(['message' => 'No membership records found for this criteria'], 404);
        }

        return response()->json(['memberships' => $memberships], 200);
    }

    

     
}
