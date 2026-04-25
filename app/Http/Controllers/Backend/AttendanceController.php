<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Employee;
use Carbon\Carbon;

class AttendanceController extends Controller
{
    /**
     * Display attendance records
     */
    public function AllAttendance(Request $request)
    {
        try {
            $query = Attendance::with('employee');

            if ($request->date) {
                $query->whereDate('date', $request->date);
            } else {
                $query->whereDate('date', Carbon::today());
            }

            if ($request->employee_id) {
                $query->where('employee_id', $request->employee_id);
            }

            $attendances = $query->orderBy('date', 'desc')->paginate(10);
            $employees = Employee::where('status', 'active')->orderBy('first_name', 'asc')->get();

            if ($request->ajax()) {
                return view('admin.backend.hr.attendance.partials.attendance_table', compact('attendances'))->render();
            }
            return view('admin.backend.hr.attendance.all_attendance', compact('attendances', 'employees'));
        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Show add attendance form (Batch marking)
     */
    public function AddAttendance()
    {
        $employees = Employee::where('status', 'active')->orderBy('first_name', 'asc')->get();
        return view('admin.backend.hr.attendance.add_attendance', compact('employees'));
    }

    /**
     * Store attendance (Batch)
     */
    public function StoreAttendance(Request $request)
    {
        try {
            $request->validate([
                'date' => 'required|date',
                'attendance' => 'required|array',
            ]);

            foreach ($request->attendance as $employee_id => $data) {
                Attendance::updateOrCreate(
                    [
                        'employee_id' => $employee_id,
                        'date' => $request->date,
                    ],
                    [
                        'status' => $data['status'],
                        'check_in_time' => $data['check_in_time'] ?? null,
                        'check_out_time' => $data['check_out_time'] ?? null,
                        'note' => $data['note'] ?? null,
                    ]
                );
            }

            return redirect()->route('all.attendance')->with([
                'message' => 'Attendance Updated Successfully',
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
     * Edit attendance record
     */
    public function EditAttendance($id)
    {
        try {
            $attendance = Attendance::findOrFail($id);
            return view('admin.backend.hr.attendance.edit_attendance', compact('attendance'));
        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Record not found!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Update attendance record
     */
    public function UpdateAttendance(Request $request)
    {
        try {
            $request->validate([
                'id' => 'required|exists:attendances,id',
                'status' => 'required|string',
            ]);

            $attendance = Attendance::findOrFail($request->id);
            $attendance->update([
                'status' => $request->status,
                'check_in_time' => $request->check_in_time,
                'check_out_time' => $request->check_out_time,
                'note' => $request->note,
            ]);

            return redirect()->route('all.attendance')->with([
                'message' => 'Attendance Updated Successfully',
                'alert-type' => 'success'
            ]);

        } catch (\Exception $e) {
            return back()->with([
                'message' => 'Something went wrong!',
                'alert-type' => 'error'
            ]);
        }
    }

    /**
     * Delete attendance record
     */
    public function DeleteAttendance($id)
    {
        try {
            $attendance = Attendance::findOrFail($id);
            $attendance->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Record Deleted Successfully'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ]);
        }
    }
}
