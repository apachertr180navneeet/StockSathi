<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WareHouse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;

class WareHouseController extends Controller
{
    /**
     * Display all warehouses
     */
    public function AllWarehouse()
    {
        try {
            $warehouse = WareHouse::latest()->get();
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
                'phone' => 'nullable|string|max:20',
                'city'  => 'nullable|string|max:255',
            ], [
                'name.required'  => 'Warehouse name is required',
                'email.required' => 'Email is required',
                'email.email'    => 'Enter valid email address',
                'email.unique'   => 'This email already exists',
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
                'phone' => 'nullable|string|max:20',
                'city'  => 'nullable|string|max:255',
            ], [
                'name.required'  => 'Warehouse name is required',
                'email.required' => 'Email is required',
                'email.email'    => 'Enter valid email address',
                'email.unique'   => 'This email already exists',
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

            return back()->with([
                'message' => 'Warehouse Deleted Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Failed to delete warehouse!',
                'alert-type' => 'error'
            ]);
        }
    }
}