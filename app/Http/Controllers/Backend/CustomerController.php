<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    /**
     * Display all customers.
     */
    public function AllCustomer()
    {
        $customer = Customer::latest()->get();
        return view('admin.backend.customer.all_customer', compact('customer'));
    }
    // End Method

    /**
     * Show add customer form.
     */
    public function AddCustomer()
    {
        return view('admin.backend.customer.add_customer');
    }
    // End Method

    /**
     * Store a new customer.
     */
    public function StoreCustomer(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255|unique:customers,email',
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        Customer::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
        ]);

        $notification = [
            'message'    => 'Customer Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.customer')->with($notification);
    }
    // End Method

    /**
     * Show edit customer form.
     */
    public function EditCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.backend.customer.edit_customer', compact('customer'));
    }
    // End Method

    /**
     * Update an existing customer.
     */
    public function UpdateCustomer(Request $request)
    {
        $cust_id = $request->id;

        $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'nullable|email|max:255|unique:customers,email,' . $cust_id,
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
        ]);

        Customer::findOrFail($cust_id)->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
        ]);

        $notification = [
            'message'    => 'Customer Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.customer')->with($notification);
    }
    // End Method

    /**
     * Delete a customer.
     */
    public function DeleteCustomer($id)
    {
        Customer::findOrFail($id)->delete();

        $notification = [
            'message'    => 'Customer Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }
    // End Method
}
