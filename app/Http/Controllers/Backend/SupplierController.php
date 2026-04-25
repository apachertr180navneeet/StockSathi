<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;

class SupplierController extends Controller
{
    public function AllSupplier(Request $request)
    {
        try {
            $query = Supplier::query();

            // 🔍 SEARCH
            if ($request->search) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');
            }

            $supplier = $query->orderBy('name', 'asc')->paginate(8);

            // ✅ AJAX RESPONSE
            if ($request->ajax()) {
                return view('admin.backend.supplier.partials.supplier_table', compact('supplier'))->render();
            }

            return view('admin.backend.supplier.all_supplier', compact('supplier'));

        } catch (\Exception $e) {
            return back()->with([
                'message'    => 'Something went wrong!',
                'alert-type' => 'error',
            ]);
        }
    }
    // End Method

    public function AddSupplier()
    {
        return view('admin.backend.supplier.add_supplier');
    }
    // End Method

    public function StoreSupplier(Request $request)
    {
        Supplier::create([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
        ]);

        $notification = [
            'message'    => 'Supplier Inserted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.supplier')->with($notification);
    }
    // End Method

    public function EditSupplier($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.backend.supplier.edit_supplier', compact('supplier'));
    }
    // End Method

    public function UpdateSupplier(Request $request)
    {
        $supp_id = $request->id;

        Supplier::findOrFail($supp_id)->update([
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
        ]);

        $notification = [
            'message'    => 'Supplier Updated Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->route('all.supplier')->with($notification);
    }
    // End Method

    public function DeleteSupplier($id)
    {
        Supplier::findOrFail($id)->delete();

        $notification = [
            'message'    => 'Supplier Deleted Successfully',
            'alert-type' => 'success',
        ];

        return redirect()->back()->with($notification);
    }
    // End Method
}
