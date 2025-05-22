<?php

namespace App\Http\Controllers;

use App\Helpers\UserActionLogHelper;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view permission', ['only' => ['index']]);
        $this->middleware('permission:create permission', ['only' => ['create','store']]);
        $this->middleware('permission:update permission', ['only' => ['edit','update']]);
        $this->middleware('permission:delete permission', ['only' => ['destroy']]);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $permissions = Permission::get();
        return view('role-permissions.permissions.index', ['permissions' => $permissions]);
    }
    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('role-permissions.permissions.create');
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request);
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name'
            ]
            ]);

            $permission =  Permission::create([
                'name' => $request->name
            ]);

            // Manage user permission create action activity lalit on 22/07/24
            $permission_link = '<a href="' . url("/permissions") . '" target="_blank">' . $permission->name . '</a>';
            UserActionLogHelper::UserActionLog('create', url("/permissions"), 'permissions', "New permission " . $permission_link . " has been created by " . Auth::user()->name.".");

            return redirect()->route('permissions.index')->with('success','Permission Created Successfully');

    }

    public function edit(Permission $permission)
    {
        return view('role-permissions.permissions.edit', ['permission' => $permission]);
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => [
                'required',
                'string',
                'unique:permissions,name,'.$permission->id
            ]
        ]);

        $permission->update([
            'name' => $request->name
        ]);

        // Manage user permission update action activity lalit on 22/07/24
        $permission_link = '<a href="' . url("/permissions") . '" target="_blank">' . $permission->name . '</a>';
        UserActionLogHelper::UserActionLog('update', url("/permissions"), 'permissions', "Permission " . $permission_link . " has been updated by " . Auth::user()->name.".");

        return redirect()->route('permissions.index')->with('success','Permission Updated Successfully');
    }
    
    public function destroy($permissionId)
    {
        $permission = Permission::find($permissionId);
        $permission->delete();
        // Manage user permission delete action activity lalit on 22/07/24
        $permission_link = '<a href="' . url("/permissions") . '" target="_blank">' . $permission->name . '</a>';
        UserActionLogHelper::UserActionLog('delete', url("/permissions"), 'permissions', "Permission " . $permission_link . " has been deleted by " . Auth::user()->name.".");
        return redirect()->route('permissions.index')->with('success','Permission Deleted Successfully');
    }
}
