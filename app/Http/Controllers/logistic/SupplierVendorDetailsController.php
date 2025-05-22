<?php

namespace App\Http\Controllers\logistic;

use App\Helpers\UserActionLogHelper;
use App\Http\Controllers\Controller;
use App\Models\SupplierVendorDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierVendorDetailsController extends Controller
{
    public function index()
    {
        $vendors = SupplierVendorDetails::all();
        return view('logistics.vendors.index', ['vendors' => $vendors]);

    }
    public function create()
    {

        $purchaseVendor = SupplierVendorDetails::get();
        return view('logistics.vendors.create', compact('purchaseVendor'));

    }
    public function checkContact($contact_no)
    {
        $exists = SupplierVendorDetails::where('contact_no', $contact_no)->exists();
        return response()->json(['exists' => $exists]);
    }
    public function checkEmail($email)
    {
        $exists = SupplierVendorDetails::where('email', $email)->exists();
        return response()->json(['exists' => $exists]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'contact_no' => 'required|string|max:10',
            'email' => 'required|string|max:50|email|unique:supplier_vendor_details,email', // Email must be unique
            'office_address' => 'required|string|max:255',
            'status' => 'required|in:active,inactive',
            'is_tender' => 'required|in:active,inactive',
            'from_tender' => 'required|date',
            'to_tender' => 'required|date|after:from_tender', 

        ]);

        $vendor = SupplierVendorDetails::create([
            'name' => $request->name,
            'contact_no' => $request->contact_no,
            'email' => $request->email,
            'office_address' => $request->office_address,
            'status' => $request->status,
            'is_tender' => $request->is_tender,
            'from_tender' => $request->from_tender,
            'to_tender' => $request->to_tender,
            'created_by' => Auth::id(),
            'updated_by' => Auth::id(),
        ]);

        // Manage supplier vendors details create action activity lalit on 22/07/24
        $action_link = '<a href="' . url("/logistic/vendor") . '" target="_blank">' . $vendor->name . '</a>';
    UserActionLogHelper::UserActionLog('create', url("/logistic/vendor"), 'vendors', 
        "New logistic vendor " . $action_link . " has been created by " . Auth::user()->name . ".");

    // Return a JSON response for AJAX handling
    return response()->json([
        'message' => 'Vendor created successfully!',
        'redirect_url' => route('supplier.index') // Redirect after success
    ], 200);

    }

    public function edit($id)
    {
        $data = SupplierVendorDetails::findOrFail($id);
        return view('logistics.vendors.edit', compact('data'));
    }

    // Method to update the data
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'contact_no' => 'required',
            'email' => 'required|string|max:50',
            'office_address' => 'required|string|max:255',
            'status' => 'required',
            'is_tender' => 'required|in:active,inactive',
            'from_tender' => 'required|date',
            'to_tender' => 'required|date',

        ]);

        $data = SupplierVendorDetails::findOrFail($id);
        $data->name = $request->name;
        $data->contact_no = $request->contact_no;
        $data->email = $request->email;
        $data->office_address = $request->office_address;
        $data->status = $request->status;
        $data->is_tender = $request->is_tender;
        $data->from_tender = $request->from_tender;
        $data->to_tender = $request->to_tender;
        $data->save();

        // Manage supplier vendors details update action activity lalit on 22/07/24
        $action_link = '<a href="' . url("/logistic/vendor") . '" target="_blank">' . $data->name . '</a>';
        UserActionLogHelper::UserActionLog('update', url("/logistic/vendor"), 'vendors', "Logistic vendor " . $action_link . " has been updated by " . Auth::user()->name.".");

        return redirect()->route('supplier.index')->with('success', 'Data updated successfully');
    }

    // public function destroy($id)
    // {

    //     $item = SupplierVendorDetails::find($id);
    //     $item->delete();
    //     return redirect('logistic/vendor')->with('success', 'Purchase Deleted Successfully');
    // }
    public function updateStatus(Request $request, $itemId)
    {
        // dd($itemId);
        $item = SupplierVendorDetails::findOrFail($itemId);
        $status = $item->status;
        $newStatus = ($status == 'active') ? 'inactive' : 'active';
        $item->status = $newStatus;
        $item->save();
        // Manage supplier vendors details update status action activity lalit on 22/07/24
        $action_link = '<a href="' . url("/logistic/vendor") . '" target="_blank">' . $item->name . '</a>';
        UserActionLogHelper::UserActionLog('delete', url("/logistic/vendor"), 'vendors', "Logistic vendor status " . $action_link . " has been updated by " . Auth::user()->name.".");
        return response()->json(['message' => 'Status updated successfully']);
    }
}
