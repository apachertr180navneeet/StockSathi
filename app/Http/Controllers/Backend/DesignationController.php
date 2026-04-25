<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Designation;
use App\Models\Department;

class DesignationController extends Controller
{
    /**
     * Display all designations
     */
    public function AllDesignation(Request $request)
    {
        try {
            $query = Designation::with('department');

            if ($request->search) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            if ($request->department_id) {
                $query->where('department_id', $request->department_id);
            }

            $designations = $query->orderBy('name', 'asc')->paginate(10);
            $departments = Department::orderBy('name', 'asc')->get();

            if ($request->ajax()) {
                return view('admin.backend.hr.designation.partials.designation_table', compact('designations'))->render();
            }
            return view('admin.backend.hr.designation.all_designation', compact('designations', 'departments'));
        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Show add designation form
     */
    public function AddDesignation()
    {
        $departments = Department::where('status', 1)->orderBy('name', 'asc')->get();
        return view('admin.backend.hr.designation.add_designation', compact('departments'));
    }

    /**
     * Store designation
     */
    public function StoreDesignation(Request $request)
    {
        try {
            $request->validate([
                'department_id' => 'required|exists:departments,id',
                'name'  => 'required|max:100',
                'description' => 'nullable|string',
            ]);

            Designation::create([
                'department_id' => $request->department_id,
                'name'  => $request->name,
                'description' => $request->description,
                'status' => $request->status ?? 1,
            ]);

            return redirect()->route('all.designation')->with([
                'message' => 'Designation Created Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return back()->withInput()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Edit designation
     */
    public function EditDesignation($id)
    {
        try {
            $designation = Designation::findOrFail($id);
            $departments = Department::where('status', 1)->orderBy('name', 'asc')->get();
            return view('admin.backend.hr.designation.edit_designation', compact('designation', 'departments'));
        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Designation not found!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Update designation
     */
    public function UpdateDesignation(Request $request)
    {
        try {
            $request->validate([
                'id'    => 'required|exists:designations,id',
                'department_id' => 'required|exists:departments,id',
                'name'  => 'required|max:100',
                'description' => 'nullable|string',
            ]);

            $designation = Designation::findOrFail($request->id);
            $designation->update([
                'department_id' => $request->department_id,
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status ?? 1,
            ]);

            return redirect()->route('all.designation')->with([
                'message' => 'Designation Updated Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return back()->withInput()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Delete designation
     */
    public function DeleteDesignation($id)
    {
        try {
            $designation = Designation::findOrFail($id);
            $designation->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Designation Deleted Successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
