<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WareHouse;
use App\Imports\WarehousesImport;
use App\Exports\SampleWarehouseExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class WareHouseController extends Controller
{
    /**
     * Display all warehouses
     */
    public function AllWarehouse(Request $request)
    {
        try {
            $query = WareHouse::query();

            // 🔍 SEARCH (same as brand)
            if ($request->search) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%')
                    ->orWhere('city', 'like', '%' . $request->search . '%');
            }

            // 📄 PAGINATION + SORT
            $warehouse = $query->orderBy('name', 'asc')->paginate(10);

            // ✅ AJAX RESPONSE (VERY IMPORTANT)
            if ($request->ajax()) {
                return view('admin.backend.warehouse.partials.warehouse_table', compact('warehouse'))->render();
            }

            return view('admin.backend.warehouse.all_warehouse', compact('warehouse'));

        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Show add warehouse form
     */
    public function AddWarehouse()
    {
        try {
            return view('admin.backend.warehouse.add_warehouse');
        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Unable to load page!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Store new warehouse
     */
    public function StoreWarehouse(Request $request)
    {
        try {

            $validator = Validator::make($request->all(), [
                'name'  => 'required|string|max:255',
                'email' => 'required|email|max:255|unique:ware_houses,email',
                'phone' => 'nullable|string|max:20|unique:ware_houses,phone',
                'city'  => 'nullable|string|max:255',
            ], [
                'name.required'  => 'Warehouse name is required',
                'email.required' => 'Email is required',
                'email.email'    => 'Enter valid email address',
                'email.unique'   => 'This email already exists',
                'phone.unique'   => 'This phone number already exists',
            ]);

            // ✅ If validation fails → return with errors (IMPORTANT)
            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // ✅ Store data
            WareHouse::create($validator->validated());

            return redirect()->route('all.warehouse')->with([
                'message' => 'Warehouse Inserted Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {

            return back()->withInput()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Edit warehouse
     */
    public function EditWarehouse($id)
    {
        try {
            $warehouse = WareHouse::findOrFail($id);
            return view('admin.backend.warehouse.edit_warehouse', compact('warehouse'));
        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Warehouse not found!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Update warehouse
     */
    public function UpdateWarehouse(Request $request)
    {
        try {

            $ware_id = $request->id;

            $validator = Validator::make($request->all(), [
                'name'  => 'required|string|max:255',
                'email' => [
                    'required',
                    'email',
                    'max:255',
                    Rule::unique('ware_houses', 'email')->ignore($ware_id),
                ],
                'phone' => [
                    'nullable',
                    'string',
                    'max:20',
                    Rule::unique('ware_houses', 'phone')->ignore($ware_id),
                ],
                'city'  => 'nullable|string|max:255',
            ], [
                'name.required'  => 'Warehouse name is required',
                'email.required' => 'Email is required',
                'email.email'    => 'Enter valid email address',
                'email.unique'   => 'This email already exists',
                'phone.unique'   => 'This phone number already exists',
            ]);

            // ✅ Validation fail → return errors under fields
            if ($validator->fails()) {
                return back()
                    ->withErrors($validator)
                    ->withInput();
            }

            // ✅ Update data
            $warehouse = WareHouse::findOrFail($ware_id);
            $warehouse->update($validator->validated());

            return redirect()->route('all.warehouse')->with([
                'message' => 'Warehouse Updated Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {

            return back()->withInput()->with([
                'message' => 'Failed to update warehouse!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Delete warehouse
     */
    public function DeleteWarehouse($id)
    {
        try {
            $warehouse = WareHouse::findOrFail($id);

            $warehouse->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Warehouse Deleted Successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Download sample CSV for import
     */
    public function DownloadSampleWarehouse()
    {
        return Excel::download(new SampleWarehouseExport, 'sample_warehouses.xlsx');
    }

    /**
     * Import warehouses from CSV/Excel
     */
    public function ImportWarehouse(Request $request)
    {
        try {
            $request->validate([
                'import_file' => 'required|mimes:csv,xlsx,xls',
            ]);

            $import = new WarehousesImport();
            Excel::import($import, $request->file('import_file'));

            $imported = $import->imported;
            $failures = $import->failures();
            $errors = [];

            foreach ($failures as $failure) {
                $errors[] = 'Row ' . $failure->row() . ': ' . implode(', ', $failure->errors());
            }

            $msg = $imported . ' warehouse(s) imported successfully.';
            $type = 'success';

            if (!empty($errors)) {
                $msg .= ' ' . count($errors) . ' row(s) skipped: ' . implode(' | ', $errors);
                $type = 'warning';
            }

            return redirect()->route('all.warehouse')->with([
                'message' => $msg,
                'alert-type' => $type
            ]);

        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Import failed: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Show trashed warehouses
     */
    public function TrashList(Request $request)
    {
        try {
            $query = WareHouse::onlyTrashed();

            if ($request->search) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('phone', 'like', '%' . $request->search . '%')
                    ->orWhere('city', 'like', '%' . $request->search . '%');
            }

            $warehouse = $query->orderBy('deleted_at', 'desc')->paginate(20);

            if ($request->ajax()) {
                return view('admin.backend.warehouse.partials.warehouse_trash_table', compact('warehouse'))->render();
            }

            return view('admin.backend.warehouse.warehouse_trash', compact('warehouse'));

        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Restore soft deleted warehouse
     */
    public function RestoreWarehouse($id)
    {
        try {
            $warehouse = WareHouse::withTrashed()->findOrFail($id);
            $warehouse->restore();

            return response()->json([
                'status' => 'success',
                'message' => 'Warehouse Restored Successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }

    /**
     * Permanently delete warehouse
     */
    public function ParmanentDeleteWarehouse($id)
    {
        try {
            $warehouse = WareHouse::withTrashed()->findOrFail($id);
            $warehouse->forceDelete();

            return response()->json([
                'status' => 'success',
                'message' => 'Warehouse Permanently Deleted Successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}