<?php

namespace App\Http\Controllers;

use App\Helpers\UserActionLogHelper;
use App\Models\ApplicantUserDetail;
use App\Models\Country;
use App\Models\Designation;
use App\Models\EmployeeDetail;
use App\Models\Section;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Spatie\Permission\Models\Permission;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view user', ['only' => ['index']]);
        $this->middleware('permission:create user', ['only' => ['create', 'store']]);
        $this->middleware('permission:update user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete user', ['only' => ['destroy']]);
    }
    /*public function index()
    {
        $users = User::get();
        return view('role-permissions.user.index', ['users' => $users]);
    }*/

    public function index()
    {
        return view('role-permissions.user.indexDatatable');
    }

    /*public function getUserList(Request $request)
    {
        // Base query with necessary joins
        $query = User::query()
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select(
                'users.id',
                'users.name',
                'users.email',
                'users.status',
                'users.user_type',
                DB::raw('GROUP_CONCAT(roles.name SEPARATOR ", ") as role_names') // Aggregate role names
            )
            ->groupBy('users.id', 'users.name', 'users.email', 'users.status', 'users.user_type'); // Group by user columns

        // Columns for ordering and searching
        $columns = ['name', 'email', 'status', 'role_names'];

        // Apply searching
        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'LIKE', "%{$search}%")
                    ->orWhere('users.email', 'LIKE', "%{$search}%")
                    ->orWhere('users.status', 'LIKE', "%{$search}%")
                    ->orWhereRaw('GROUP_CONCAT(roles.name SEPARATOR ", ") LIKE ?', ["%{$search}%"]); // Search in roles
            });
        }

        // Get total records before filtering
        $totalData = User::count();

        // Get filtered data count
        $totalFiltered = $query->get()->count();

        // Apply ordering
        $orderColumnIndex = $request->input('order.0.column');
        $order = $columns[$orderColumnIndex] ?? null;
        $dir = $request->input('order.0.dir', 'asc');

        if ($order) {
            $query->orderBy($order, $dir);
        }

        // Apply pagination
        $limit = $request->input('length');
        $start = $request->input('start');
        $userData = $query->offset($start)->limit($limit)->get();

        // Prepare the data
        $data = [];
        foreach ($userData as $row) {
            $nestedData = [];

            // User details
            $nestedData['name'] = $row->name;
            $nestedData['email'] = $row->email;

            // Status column with conditional badge rendering
            $status = '';
            if (auth()->user()->can('status.user')) {
                $status = $row->status == 1
                    ? '<a href="' . route('user.status', $row->id) . '"><div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Active</div></a>'
                    : '<a href="' . route('user.status', $row->id) . '"><div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>In-Active</div></a>';
            } else {
                $status = $row->status == 1
                    ? '<div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Active</div>'
                    : '<div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>In-Active</div>';
            }
            $nestedData['status'] = $status;

            // Roles as a comma-separated list
            $nestedData['roles'] = !empty($row->role_names)
                ? '<label class="badge bg-primary mx-1">' . $row->role_names . '</label>'
                : '';

            // Actions
            $action = '<div class="d-flex gap-3">';
            if (auth()->user()->can('update user')) {
                $action .= '<a href="' . route('users/' . $row->id . '/update-user-details') . '"><button type="button" class="btn btn-primary px-5">Edit</button></a>';
            }
            if (auth()->user()->can('update.user.roles.permissions')) {
                $action .= '<a href="' . route('users/' . $row->id . '/edit') . '"><button type="button" class="btn btn-success px-5">Edit Roles / Permissions </button></a>';
            }
            if (auth()->user()->can('delete user')) {
                $action .= '<a href="' . route('users/' . $row->id . '/delete') . '"><button type="button" class="btn btn-danger px-5">Delete</button></a>';
            }
            $action .= '</div>';
            $nestedData['action'] = $action;

            $data[] = $nestedData;
        }

        // Prepare JSON response
        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        ];

        return response()->json($json_data);
    }*/

    //commented on 05/12/2024
    public function getUserList(Request $request)
    {
        $query = User::query()
            ->leftJoin('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
            ->leftJoin('roles', 'model_has_roles.role_id', '=', 'roles.id')
            ->select('users.*', 'roles.name as role_name'); // Selecting the necessary fields

        // List only actual database columns here
        $columns = ['name', 'email', 'status', 'role_name'];

        // Apply searching
        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search) {
                $q->where('users.name', 'LIKE', "%{$search}%")
                    ->orWhere('users.email', 'LIKE', "%{$search}%")
                    ->orWhere('users.status', 'LIKE', "%{$search}%")
                    ->orWhere('roles.name', 'LIKE', "%{$search}%"); // Searching in roles
            });
        }

        // Get total data and filtered data counts
        $totalData = $query->count();
        $totalFiltered = $totalData;

        // Apply ordering
        $orderColumnIndex = $request->input('order.0.column');
        $order = $columns[$orderColumnIndex] ?? null;
        $dir = $request->input('order.0.dir', 'asc');

        if ($order) {
            $query->orderBy($order, $dir);
        }

        // Apply pagination
        $limit = $request->input('length');
        $start = $request->input('start');
        $userData = $query->offset($start)->limit($limit)->get();

        $data = [];
        foreach ($userData as $row) {
            $nestedData = [];

            // Prepare data for the columns
            $nestedData['name'] = $row->name;
            $nestedData['email'] = $row->email;

            // Status column with conditional badge rendering
            $status = '';
            if (auth()->user()->can('status.user')) {
                if ($row->status == 1) {
                    $status = '<a href="' . route('user.status', $row->id) . '"><div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Active</div></a>';
                } else {
                    $status = '<a href="' . route('user.status', $row->id) . '"><div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>In-Active</div></a>';
                }
            } else {
                if ($row->status == 1) {
                    $status = '<div class="badge rounded-pill text-success bg-light-success p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>Active</div>';
                } else {
                    $status = '<div class="badge rounded-pill text-danger bg-light-danger p-2 text-uppercase px-3"><i class="bx bxs-circle me-1"></i>In-Active</div>';
                }
            }

            $nestedData['status'] = $status;

            // Prepare roles
            $roles = '';
            if (!empty($row->role_name)) {
                $roles = '<label class="badge bg-primary mx-1">' . $row->role_name . '</label>';
            }
            $nestedData['roles'] = $roles;

        
            $action = '<div class="d-flex gap-3">';
            if (auth()->user()->can('update user')) {
                $action .= '<a href="' . route('user.details.update', ['id' => $row->id]) . '">
                                <button type="button" class="btn btn-primary px-5">Edit</button>
                            </a>';
            }
            
            if (auth()->user()->can('update.user.roles.permissions')) {
                $action .= '<a href="' . route('user.edit', ['id' => $row->id]) . '">
                                <button type="button" class="btn btn-success px-5">Edit Roles / Permissions</button>
                            </a>';
            }
            
            if (auth()->user()->can('delete user')) {
                $action .= '<a href="' . route('user.delete', ['userId' => $row->id]) . '">
                                <button type="button" class="btn btn-danger px-5">Delete</button>
                            </a>';
            }            
            $action .= '</div>';
            $nestedData['action'] = $action;

            $data[] = $nestedData;
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        ];

        return response()->json($json_data);
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        $designations = Designation::all();
        $sections = Section::all();
        //Added by Lalit on Date 05/08/2024
        $empCode = 'EMP' . EmployeeDetail::max('id') + 1;
        $countries = Country::where('phonecode', '!=', 0)->orderBy('name', 'asc')->get();
        return view('role-permissions.user.create', ['roles' => $roles, 'designations' => $designations, 'sections' => $sections, 'empCode' => $empCode, 'countries' => $countries]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|max:20',
            //Changes done by lalit_tiwari on 26/07/2024
            'mobile_no' => 'required|string|max:255',
            'dob' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'emp_code' => 'required|string|max:255',
            'sub_user_type' => 'required|string|max:255',
            // 'designation_id' => 'required|string|max:255',
            // 'sections' => 'required|array', // Ensure 'sections' is an array
            // 'sections.*' => 'exists:sections,id', // Each section ID must exist
            'roles' => 'required',
        ]);

        if (isset($request->sub_user_type) && $request->sub_user_type == 'ldo') {
            $request->validate([
                'designation_id' => 'required|string|max:255',
                'sections' => 'required|array', // Ensure 'sections' is an array
                'sections.*' => 'exists:sections,id', // Each section ID must exist
            ]);
        }
        
        if (isset($request->designation_id) && isset($request->sections)) {
            // Check if any section is already assigned with the same designation added by lalit on 05/08/2024
            /*$existingMapping = DB::table('section_user')
                ->whereIn('section_id', $request->sections)
                ->where('designation_id', $request->designation_id)
                ->exists();*/
            $existingMapping = DB::table('section_user')
                ->join('users', 'section_user.user_id', '=', 'users.id') // Join users table
                ->whereIn('section_user.section_id', $request->sections)
                ->where('section_user.designation_id', $request->designation_id)
                ->where('users.status', 1) // Check if user has status = 1
                ->exists();

            if ($existingMapping) {
                return redirect()->route('users.index')->with('failure', 'This section is already assigned to a user with the same designation.');
            }
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            //Adding Country Code - Lalit (22 October)
            'country_code' => $request->countryCode,
            //Changes done by lalit_tiwari on 26/07/2024
            'mobile_no' => $request->mobile_no,
            'designation_id' => !empty($request->designation_id) ? $request->designation_id : null,
            'status'    => 1
        ]);
        //Changes done by lalit_tiwari on 26/07/2024
        if ($user->id > 0) {
            EmployeeDetail::create([
                'user_id' => $user->id,
                'user_sub_type' => $request->sub_user_type,
                'emp_code' => $request->emp_code,
                'gender' => $request->gender,
                'dob' => $request->dob,
            ]);

            //Added by lalit on 05/08/2024
            if (isset($request->sections) && count($request->sections) > 0) {
                // Attach sections with designation_id
                foreach ($request->sections as $sectionId) {
                    $user->sections()->attach($sectionId, ['designation_id' => $request->designation_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
                }
            }
            $user->syncRoles($request->roles);
            // Manage user create action activity lalit on 22/07/24
            $user_id_link = '<a href="' . url("/users/{$user->id}/edit") . '" target="_blank">' . $user->name . '</a>';
            UserActionLogHelper::UserActionLog('create', url("/users/{$user->id}/edit"), 'users', "New user " . $user_id_link . " has been created with role by " . Auth::user()->name . ".");
            return redirect()->route('users.index')->with('success', 'User created successfully with roles');
        } else {
            return redirect()->route('users.index')->with('failure', 'User not created with designation, sections & roles');
        }
    }

    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::pluck('name', 'name')->all();
        $userRoles = $user->roles->pluck('name', 'name')->all();
        // Lalit 11/07/2024 :- Get all permissions to display permission dropdown on edit page
        $permissions = Permission::all();
        return view('role-permissions.user.edit', [
            'user' => $user,
            'roles' => $roles,
            'userRoles' => $userRoles,
            'permissions' => $permissions
        ]);
    }

    public function updateUserDetails($id)
    {
        if (empty($id)) {
            return redirect()->back()->withErrors('User ID not provided.');
        }

        $user = User::findOrFail($id);  // Using findOrFail instead of find for cleaner error handling
        $roles = Role::pluck('name', 'name');
        $userRoles = $user->roles->pluck('name', 'name')->toArray(); // Directly getting an array
        $userSections = $user->sections->pluck('id')->toArray(); // Simplified fetching of section IDs
        $designations = Designation::all();
        $sections = Section::all();

        // Generating Employee Code based on max ID
        $empCode = 'EMP' . (EmployeeDetail::max('id') + 1);

        // Fetching countries with phone code
        $countries = Country::where('phonecode', '!=', 0)->orderBy('name', 'asc')->get();

        return view('role-permissions.user.update', compact('user', 'roles', 'userRoles', 'designations', 'sections', 'userSections', 'empCode', 'countries'));
    }

    public function updateUser(Request $request, $userId)
    {
        $user = User::findOrFail($userId);

        // Validate the roles and permissions input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mobile_no' => 'required|string|max:255',
            'dob' => 'required|string|max:255',
            'gender' => 'required|string|max:255',
            'sub_user_type' => 'required|string|max:255',
            'roles' => 'required',
        ]);

        if (isset($request->sub_user_type) && $request->sub_user_type == 'ldo') {
            $request->validate([
                'designation_id' => 'required|string|max:255',
                'sections' => 'required|array', // Ensure 'sections' is an array
                'sections.*' => 'exists:sections,id', // Each section ID must exist
            ]);
        }

        if (isset($request->designation_id) && isset($request->sections)) {
            // Check if any section is already assigned with the same designation added by lalit on 05/08/2024
            /*$existingMapping = DB::table('section_user')
                ->whereIn('section_id', $request->sections)
                ->where('designation_id', $request->designation_id)
                ->where('user_id','!=', $userId)
                ->exists();*/
            $existingMapping = DB::table('section_user')
                ->join('users', 'section_user.user_id', '=', 'users.id') // Join with users table
                ->whereIn('section_user.section_id', $request->sections) // Check sections
                ->where('section_user.designation_id', $request->designation_id) // Check designation
                ->where('section_user.user_id', '!=', $userId) // Exclude current user
                ->where('users.status', 1) // Only check active users (status = 1)
                ->exists();
            if ($existingMapping) {
                return redirect()->back()->with('failure', 'This section is already assigned to a user with the same designation.');
            }
        }

        // Update employee details if present
        $empDetails = EmployeeDetail::where('user_id', $userId)->first();
        if ($empDetails) {
            $empDetails->fill([
                'user_sub_type' => isset($request->sub_user_type) ? $request->sub_user_type : $empDetails->user_sub_type,
                'gender' => isset($request->gender) ? $request->gender : $empDetails->gender,
                'dob' => isset($request->dob) ? $request->dob : $empDetails->dob
            ])->save();
        }

        // Update the user model
        $user->fill([
            'name' => isset($request->name) ? $request->name : $user->name,
            'email' => isset($request->email) ? $request->email : $user->email,
            'country_code' => isset($request->countryCode) ? $request->countryCode : $user->country_code,
            'mobile_no' =>  isset($request->mobile_no) ? $request->mobile_no : $user->mobile_no,
            'designation_id' => isset($request->designation_id) ? $request->designation_id : $user->designation_id
        ])->save();

        // Sync roles if provided, otherwise revoke all roles
        if ($request->filled('roles')) {
            $user->syncRoles($request->roles);
        } else {
            $user->syncRoles([]); // Revoke all roles if none are provided
        }

        // Sync sections if provided
        if ($request->filled('sections')) {
            // Sync sections with new designation_id
            $user->sections()->sync($request->sections);

            // Update designation_id in section_user mapping
            foreach ($request->sections as $sectionId) {
                DB::table('section_user')->updateOrInsert(
                    ['user_id' => $userId, 'section_id' => $sectionId],
                    ['designation_id' => $request->designation_id],
                    ['updated_at' => Carbon::now()]
                );
            }
        } else {
            $user->sections()->detach(); // Revoke all sections if none are provided
        }

        // Manage user update action activity lalit on 22/07/24
        $user_id_link = '<a href="' . url("/users/{$user->id}/edit") . '" target="_blank">' . $user->name . '</a>';
        UserActionLogHelper::UserActionLog('update', url("/users/{$user->id}/edit"), 'users', "User " . $user_id_link . " has been updated with their role & permission by " . Auth::user()->name . ".");
        
        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }

    public function update(Request $request, User $user)
    {
        //dd($request);
        $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'nullable|string|min:8|max:20',
            'roles' => 'required'
        ]);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
        ];
        if (!empty($request->password)) {
            $data += [
                'password' => Hash::make($request->password),
            ];
        }
        $user->update($data);
        $user->syncRoles($request->roles);
        // Lalit 11/07/2024 :- Assign extra permissions to users
        $user->revokePermissionTo($user->permissions);
        // Assign new permissions (only if they exist)
        if (!empty($request->permissions)) {
            $user->givePermissionTo($request->permissions);
        }

        // Manage user update action activity lalit on 22/07/24
        $user_id_link = '<a href="' . url("/users/{$user->id}/edit") . '" target="_blank">' . $user->name . '</a>';
        UserActionLogHelper::UserActionLog('update', url("/users/{$user->id}/edit"), 'users', "User " . $user_id_link . " has been updated with their role & permission by " . Auth::user()->name . ".");
        return redirect()->route('users.index')->with('success', 'User Updated Successfully with roles');
    }
    //Update destroy function QA Raise the error getting error in some of the table where foreign key is not associate property like employee_details, applicant_user_details etc.
    // Lalit (10/Oct/2024)
    public function destroy($userId)
    {
        try {
            DB::transaction(function () use ($userId) {
                $user = User::findOrFail($userId);
                // Delete related ApplicantUserDetail and EmployeeDetail records explicitly
                ApplicantUserDetail::where('user_id', $userId)->delete();
                EmployeeDetail::where('user_id', $userId)->delete();
                // No need to manually delete related records; cascading will handle it
                $user->delete();
                // Revoke all permissions
                foreach ($user->permissions as $permission) {
                    $user->revokePermissionTo($permission);
                }
                // Log the user deletion activity
                $user_id_link = '<a href="' . url("/users/{$user->id}/edit") . '" target="_blank">' . $user->name . '</a>';
                UserActionLogHelper::UserActionLog('delete', url("/users/{$user->id}/edit"), 'users', "User " . $user_id_link . " has been deleted by " . Auth::user()->name . ".");
            });

            return redirect('/users')->with('success', 'User Deleted Successfully');
        } catch (\Exception $e) {
            Log::error("User deletion failed: " . $e->getMessage());
            return redirect()->route('users.index')->with('error', 'Failed to delete the user. Please try again later.');
        }
    }

    /*public function destroy($userId)
    {
        $user = User::findOrFail($userId);
        $user->delete();
        $user->revokePermissionTo($user->permissions);
        // Manage user destroy action activity lalit on 22/07/24
        $user_id_link = '<a href="' . url("/users/{$user->id}/edit") . '" target="_blank">' . $user->name . '</a>';
        UserActionLogHelper::UserActionLog('delete', url("/users/{$user->id}/edit"), 'users', "User " . $user_id_link . " has been deleted by " . Auth::user()->name . ".");
        return redirect('/users')->with('success', 'User Delete Successfully');
    }*/

    public function status($id)
    {
        $user = User::findOrFail($id);
        $currentStatus = $user->status;
        if ($currentStatus == 1) {
            $user->status = 0;
            // Helper function to Manage User Activity / Action Logs for User Aactive & Deactive action
            $user_link = '<a href="' . url("/users") . '" target="_blank">' . $user->name . '</a>';
            UserActionLogHelper::UserActionLog('inActive', url("/users"), 'users', "User " . $user_link . " has been in-activate by " . Auth::user()->name . ".");
        } else {
            $user->status = 1;
            // Helper function to Manage User Activity / Action Logs for User Aactive & Deactive action
            $user_link = '<a href="' . url("/users") . '" target="_blank">' . $user->name . '</a>';
            UserActionLogHelper::UserActionLog('inActive', url("/users"), 'users', "User " . $user_link . " has been activate by " . Auth::user()->name . ".");
        }

        $user->save();
        return redirect()->back()->with('success', 'User status changed successfully');
    }
}
