<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class SupplierController extends Controller
{
    // All Supplier List
    public function AllSupplier()
    {
        try {
            $supplier = Supplier::latest()->get();
            return view('admin.backend.supplier.all_supplier', compact('supplier'));

        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    // Add Supplier Page
    public function AddSupplier()
    {
        return view('admin.backend.supplier.add_supplier');
    }

    // Store Supplier
    public function StoreSupplier(Request $request)
    {
        try {
            // Validation
            $request->validate([
                'name'    => 'required|string|max:100',
                'email'   => 'required|email|unique:suppliers,email',
                'phone'   => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
            ]);

            Supplier::create([
                'name'    => $request->name,
                'email'   => $request->email,
                'phone'   => $request->phone,
                'address' => $request->address,
            ]);

            return redirect()->route('all.supplier')->with([
                'message' => 'Supplier Inserted Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            return back()->withInput()->with([
                'message' => 'Failed to insert supplier!',
                'alert-type' => 'error'
            ]);
        }
    }

    // Edit Supplier
    public function EditSupplier($id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            return view('admin.backend.supplier.edit_supplier', compact('supplier'));

        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Supplier not found!',
                'alert-type' => 'error'
            ]);
        }
    }

    // Update Supplier
    public function UpdateSupplier(Request $request)
    {
        try {
            $supp_id = $request->id;

            // Validation
            $request->validate([
                'name'    => 'required|string|max:100',
                'email'   => [
                    'required',
                    'email',
                    Rule::unique('suppliers', 'email')->ignore($supp_id),
                ],
                'phone'   => 'nullable|string|max:20',
                'address' => 'nullable|string|max:255',
            ]);

            $supplier = Supplier::findOrFail($supp_id);

            $supplier->update([
                'name'    => $request->name,
                'email'   => $request->email,
                'phone'   => $request->phone,
                'address' => $request->address,
            ]);

            return redirect()->route('all.supplier')->with([
                'message' => 'Supplier Updated Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            return back()->withInput()->with([
                'message' => 'Failed to update supplier!',
                'alert-type' => 'error'
            ]);
        }
    }

    // Delete Supplier
    public function DeleteSupplier($id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->delete();

            return redirect()->back()->with([
                'message' => 'Supplier Deleted Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Failed to delete supplier!',
                'alert-type' => 'error'
            ]);
        }
    }
}