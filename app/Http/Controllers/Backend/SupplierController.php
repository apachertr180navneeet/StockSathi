<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Supplier;
use App\Imports\SuppliersImport;
use App\Exports\SampleSupplierExport;
use Maatwebsite\Excel\Facades\Excel;

class SupplierController extends Controller
{
    public function AllSupplier(Request $request)
    {
        try {
            $query = Supplier::query();

            if ($request->search) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');
            }

            $supplier = $query->withSum('purchases', 'due_amount')
                ->orderBy('name', 'asc')
                ->paginate(8);

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

    public function AddSupplier()
    {
        return view('admin.backend.supplier.add_supplier');
    }

    public function StoreSupplier(Request $request)
    {
        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|unique:suppliers,email',
            'phone'   => 'required|digits:10|unique:suppliers,phone',
            'address' => 'required|string',
        ]);

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

    public function EditSupplier($id)
    {
        $supplier = Supplier::findOrFail($id);
        return view('admin.backend.supplier.edit_supplier', compact('supplier'));
    }

    public function UpdateSupplier(Request $request)
    {
        $supp_id = $request->id;

        $request->validate([
            'name'    => 'required|string|max:100',
            'email'   => 'required|email|unique:suppliers,email,' . $supp_id,
            'phone'   => 'required|digits:10|unique:suppliers,phone,' . $supp_id,
            'address' => 'required|string',
        ]);

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

    public function DeleteSupplier($id)
    {
        try {
            Supplier::findOrFail($id)->delete();

            return response()->json([
                'status'  => 'success',
                'message' => 'Supplier Deleted Successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function DownloadSampleSupplier()
    {
        return Excel::download(new SampleSupplierExport, 'sample_suppliers.xlsx');
    }

    public function ImportSupplier(Request $request)
    {
        try {
            $request->validate([
                'import_file' => 'required|mimes:csv,xlsx,xls',
            ]);

            $import = new SuppliersImport();
            Excel::import($import, $request->file('import_file'));

            $imported = $import->imported;
            $failures = $import->failures();
            $errors = [];

            foreach ($failures as $failure) {
                $errors[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }

            $msg = $imported . ' supplier(s) imported successfully.';
            $type = 'success';

            if (!empty($errors)) {
                $msg .= ' ' . count($errors) . ' row(s) skipped: ' . implode(' | ', $errors);
                $type = 'warning';
            }

            return redirect()->route('all.supplier')->with([
                'message'    => $msg,
                'alert-type' => $type
            ]);

        } catch (\Exception $e) {
            return back()->with([
                'message'    => 'Import failed: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    public function TrashList(Request $request)
    {
        try {
            $query = Supplier::onlyTrashed();

            if ($request->search) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%');
            }

            $supplier = $query->orderBy('deleted_at', 'desc')->paginate(8);

            if ($request->ajax()) {
                return view('admin.backend.supplier.partials.supplier_trash_table', compact('supplier'))->render();
            }

            return view('admin.backend.supplier.supplier_trash', compact('supplier'));

        } catch (\Exception $e) {
            return back()->with([
                'message'    => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    public function RestoreSupplier($id)
    {
        try {
            $supplier = Supplier::withTrashed()->findOrFail($id);
            $supplier->restore();

            return response()->json([
                'status'  => 'success',
                'message' => 'Supplier Restored Successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function ParmanentDeleteSupplier($id)
    {
        try {
            $supplier = Supplier::withTrashed()->findOrFail($id);
            $supplier->forceDelete();

            return response()->json([
                'status'  => 'success',
                'message' => 'Supplier Permanently Deleted Successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status'  => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    public function ChangeStatus($id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->status = $supplier->status ? 0 : 1;
            $supplier->save();
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
            Supplier::whereIn('id', $ids)->delete();
            return response()->json([
                'status' => 'success',
                'message' => count($ids) . ' supplier(s) deleted successfully'
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
            Supplier::whereIn('id', $ids)->update(['status' => $status]);
            $label = $status == 1 ? 'active' : 'inactive';
            return response()->json([
                'status' => 'success',
                'message' => count($ids) . ' supplier(s) set to ' . $label
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
            Supplier::withTrashed()->whereIn('id', $ids)->restore();
            return response()->json([
                'status' => 'success',
                'message' => count($ids) . ' supplier(s) restored successfully'
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
            Supplier::withTrashed()->whereIn('id', $ids)->forceDelete();
            return response()->json([
                'status' => 'success',
                'message' => count($ids) . ' supplier(s) permanently deleted'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
