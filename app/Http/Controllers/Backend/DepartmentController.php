<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;

class DepartmentController extends Controller
{
    /**
     * Display all departments
     */
    public function AllDepartment(Request $request)
    {
        try {
            $query = Department::query();

            if ($request->search) {
                $query->where('name', 'like', '%' . $request->search . '%');
            }

            $departments = $query->orderBy('name', 'asc')->paginate(10);

            if ($request->ajax()) {
                return view('admin.backend.hr.department.partials.department_table', compact('departments'))->render();
            }
            return view('admin.backend.hr.department.all_department', compact('departments'));
        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Show add department form
     */
    public function AddDepartment()
    {
        return view('admin.backend.hr.department.add_department');
    }

    /**
     * Store department
     */
    public function StoreDepartment(Request $request)
    {
        try {
            $request->validate([
                'name'  => 'required|unique:departments,name|max:100',
                'description' => 'nullable|string',
            ]);

            Department::create([
                'name'  => $request->name,
                'description' => $request->description,
                'status' => $request->status ?? 1,
            ]);

            return redirect()->route('all.department')->with([
                'message' => 'Department Created Successfully',
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
     * Edit department
     */
    public function EditDepartment($id)
    {
        try {
            $department = Department::findOrFail($id);
            return view('admin.backend.hr.department.edit_department', compact('department'));
        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Department not found!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Update department
     */
    public function UpdateDepartment(Request $request)
    {
        try {
            $request->validate([
                'id'    => 'required|exists:departments,id',
                'name'  => 'required|max:100|unique:departments,name,' . $request->id,
                'description' => 'nullable|string',
            ]);

            $department = Department::findOrFail($request->id);
            $department->update([
                'name' => $request->name,
                'description' => $request->description,
                'status' => $request->status ?? 1,
            ]);

            return redirect()->route('all.department')->with([
                'message' => 'Department Updated Successfully',
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
     * Delete department
     */
    public function DeleteDepartment($id)
    {
        try {
            $department = Department::findOrFail($id);
            $department->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Department Deleted Successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
