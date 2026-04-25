<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Department;
use App\Models\Designation;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class EmployeeController extends Controller
{
    /**
     * Display all employees
     */
    public function AllEmployee(Request $request)
    {
        try {
            $query = Employee::with(['department', 'designation', 'user']);

            if ($request->search) {
                $search = $request->search;
                $query->where(function($q) use ($search) {
                    $q->where('first_name', 'like', '%' . $search . '%')
                      ->orWhere('last_name', 'like', '%' . $search . '%')
                      ->orWhere('employee_id', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
                });
            }

            if ($request->department_id) {
                $query->where('department_id', $request->department_id);
            }

            $employees = $query->orderBy('created_at', 'desc')->paginate(10);
            $departments = Department::where('status', 1)->orderBy('name', 'asc')->get();

            if ($request->ajax()) {
                return view('admin.backend.hr.employee.partials.employee_table', compact('employees'))->render();
            }
            return view('admin.backend.hr.employee.all_employee', compact('employees', 'departments'));
        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Show add employee form
     */
    public function AddEmployee()
    {
        $departments = Department::where('status', 1)->orderBy('name', 'asc')->get();
        $designations = Designation::where('status', 1)->orderBy('name', 'asc')->get();
        $users = User::orderBy('name', 'asc')->get(); // For optional linking to user account
        return view('admin.backend.hr.employee.add_employee', compact('departments', 'designations', 'users'));
    }

    /**
     * Store employee
     */
    public function StoreEmployee(Request $request)
    {
        try {
            $request->validate([
                'employee_id' => 'required|unique:employees,employee_id',
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'email' => 'required|email|unique:employees,email',
                'phone' => 'nullable|string|max:20',
                'department_id' => 'required|exists:departments,id',
                'designation_id' => 'required|exists:designations,id',
                'joining_date' => 'required|date',
                'base_salary' => 'required|numeric|min:0',
                'user_id' => 'nullable|exists:users,id',
            ]);

            Employee::create([
                'employee_id' => $request->employee_id,
                'user_id' => $request->user_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'department_id' => $request->department_id,
                'designation_id' => $request->designation_id,
                'joining_date' => $request->joining_date,
                'base_salary' => $request->base_salary,
                'status' => $request->status ?? 'active',
            ]);

            return redirect()->route('all.employee')->with([
                'message' => 'Employee Added Successfully',
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
     * Show employee details
     */
    public function DetailsEmployee($id)
    {
        try {
            $employee = Employee::with(['department', 'designation', 'user', 'attendances', 'payrolls'])->findOrFail($id);
            return view('admin.backend.hr.employee.details_employee', compact('employee'));
        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Employee not found!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Edit employee
     */
    public function EditEmployee($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $departments = Department::where('status', 1)->orderBy('name', 'asc')->get();
            $designations = Designation::where('status', 1)->orderBy('name', 'asc')->get();
            $users = User::orderBy('name', 'asc')->get();
            return view('admin.backend.hr.employee.edit_employee', compact('employee', 'departments', 'designations', 'users'));
        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Employee not found!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Update employee
     */
    public function UpdateEmployee(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:employees,id',
                'employee_id' => 'required|unique:employees,employee_id,' . $request->id,
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'email' => 'required|email|unique:employees,email,' . $request->id,
                'phone' => 'nullable|string|max:20',
                'department_id' => 'required|exists:departments,id',
                'designation_id' => 'required|exists:designations,id',
                'joining_date' => 'required|date',
                'base_salary' => 'required|numeric|min:0',
                'user_id' => 'nullable|exists:users,id',
            ]);

            $employee = Employee::findOrFail($request->id);
            $employee->update([
                'employee_id' => $request->employee_id,
                'user_id' => $request->user_id,
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'address' => $request->address,
                'department_id' => $request->department_id,
                'designation_id' => $request->designation_id,
                'joining_date' => $request->joining_date,
                'base_salary' => $request->base_salary,
                'status' => $request->status ?? 'active',
            ]);

            return redirect()->route('all.employee')->with([
                'message' => 'Employee Updated Successfully',
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
     * Delete employee
     */
    public function DeleteEmployee($id)
    {
        try {
            $employee = Employee::findOrFail($id);
            $employee->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Employee Deleted Successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
