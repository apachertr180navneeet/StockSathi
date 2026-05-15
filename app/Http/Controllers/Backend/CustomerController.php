<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function AllCustomer(Request $request)
    {
        try {
            $query = Customer::query();

            if ($request->search) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');
            }

            $customer = $query->orderBy('name', 'asc')->paginate(10);

            if ($request->ajax()) {
                return view('admin.backend.customer.partials.customer_table', compact('customer'))->render();
            }

            return view('admin.backend.customer.all_customer', compact('customer'));

        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    public function AddCustomer()
    {
        return view('admin.backend.customer.add_customer');
    }

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

        return redirect()->route('all.customer')->with([
            'message' => 'Customer Inserted Successfully',
            'alert-type' => 'success',
        ]);
    }

    public function EditCustomer($id)
    {
        $customer = Customer::findOrFail($id);
        return view('admin.backend.customer.edit_customer', compact('customer'));
    }

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

        return redirect()->route('all.customer')->with([
            'message' => 'Customer Updated Successfully',
            'alert-type' => 'success',
        ]);
    }

    public function DeleteCustomer($id)
    {
        try {
            Customer::findOrFail($id)->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Customer Deleted Successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function TrashList(Request $request)
    {
        try {
            $query = Customer::onlyTrashed();

            if ($request->search) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');
            }

            $customer = $query->orderBy('deleted_at', 'desc')->paginate(10);

            if ($request->ajax()) {
                return view('admin.backend.customer.partials.customer_trash_table', compact('customer'))->render();
            }

            return view('admin.backend.customer.customer_trash', compact('customer'));

        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    public function RestoreCustomer($id)
    {
        try {
            $customer = Customer::withTrashed()->findOrFail($id);
            $customer->restore();
            return response()->json([
                'status' => 'success',
                'message' => 'Customer Restored Successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function ParmanentDeleteCustomer($id)
    {
        try {
            $customer = Customer::withTrashed()->findOrFail($id);
            $customer->forceDelete();
            return response()->json([
                'status' => 'success',
                'message' => 'Customer Permanently Deleted Successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function ChangeStatus($id)
    {
        try {
            $customer = Customer::findOrFail($id);
            $customer->status = $customer->status ? 0 : 1;
            $customer->save();
            return response()->json([
                'status' => 'success',
                'message' => 'Status changed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function BulkDelete(Request $request)
    {
        try {
            $ids = $request->ids;
            if (!$ids || !is_array($ids)) {
                return response()->json(['status' => 'error', 'message' => 'No items selected']);
            }
            Customer::whereIn('id', $ids)->delete();
            return response()->json([
                'status' => 'success',
                'message' => count($ids) . ' customer(s) deleted successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function BulkStatusChange(Request $request)
    {
        try {
            $ids = $request->ids;
            $status = $request->status;
            if (!$ids || !is_array($ids)) {
                return response()->json(['status' => 'error', 'message' => 'No items selected']);
            }
            Customer::whereIn('id', $ids)->update(['status' => $status]);
            $label = $status == 1 ? 'active' : 'inactive';
            return response()->json([
                'status' => 'success',
                'message' => count($ids) . ' customer(s) set to ' . $label
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function BulkRestore(Request $request)
    {
        try {
            $ids = $request->ids;
            if (!$ids || !is_array($ids)) {
                return response()->json(['status' => 'error', 'message' => 'No items selected']);
            }
            Customer::withTrashed()->whereIn('id', $ids)->restore();
            return response()->json([
                'status' => 'success',
                'message' => count($ids) . ' customer(s) restored successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function BulkForceDelete(Request $request)
    {
        try {
            $ids = $request->ids;
            if (!$ids || !is_array($ids)) {
                return response()->json(['status' => 'error', 'message' => 'No items selected']);
            }
            Customer::withTrashed()->whereIn('id', $ids)->forceDelete();
            return response()->json([
                'status' => 'success',
                'message' => count($ids) . ' customer(s) permanently deleted'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
