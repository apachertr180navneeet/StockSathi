<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payroll;
use App\Models\Employee;
use Carbon\Carbon;

class PayrollController extends Controller
{
    /**
     * Display all payroll records
     */
    public function AllPayroll(Request $request)
    {
        try {
            $query = Payroll::with('employee');

            if ($request->month) {
                $query->where('month', $request->month);
            }
            if ($request->year) {
                $query->where('year', $request->year);
            }

            $payrolls = $query->orderBy('year', 'desc')->orderBy('month', 'desc')->paginate(10);

            if ($request->ajax()) {
                return view('admin.backend.hr.payroll.partials.payroll_table', compact('payrolls'))->render();
            }
            return view('admin.backend.hr.payroll.all_payroll', compact('payrolls'));
        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Show create payroll form
     */
    public function AddPayroll()
    {
        $employees = Employee::where('status', 'active')->orderBy('first_name', 'asc')->get();
        return view('admin.backend.hr.payroll.add_payroll', compact('employees'));
    }

    /**
     * Store payroll record
     */
    public function StorePayroll(Request $request)
    {
        try {
            $request->validate([
                'employee_id' => 'required|exists:employees,id',
                'month' => 'required|integer|min:1|max:12',
                'year' => 'required|integer',
                'basic_salary' => 'required|numeric|min:0',
                'allowances' => 'nullable|numeric|min:0',
                'deductions' => 'nullable|numeric|min:0',
            ]);

            $net_salary = $request->basic_salary + ($request->allowances ?? 0) - ($request->deductions ?? 0);

            Payroll::updateOrCreate(
                [
                    'employee_id' => $request->employee_id,
                    'month' => $request->month,
                    'year' => $request->year,
                ],
                [
                    'basic_salary' => $request->basic_salary,
                    'allowances' => $request->allowances ?? 0,
                    'deductions' => $request->deductions ?? 0,
                    'net_salary' => $net_salary,
                    'payment_status' => $request->payment_status ?? 'Pending',
                    'payment_date' => $request->payment_date,
                    'payment_method' => $request->payment_method,
                ]
            );

            return redirect()->route('all.payroll')->with([
                'message' => 'Payroll Record Saved Successfully',
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
     * View payroll details
     */
    public function DetailsPayroll($id)
    {
        try {
            $payroll = Payroll::with('employee.department', 'employee.designation')->findOrFail($id);
            return view('admin.backend.hr.payroll.details_payroll', compact('payroll'));
        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Record not found!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Delete payroll record
     */
    public function DeletePayroll($id)
    {
        try {
            $payroll = Payroll::findOrFail($id);
            $payroll->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Payroll Deleted Successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
