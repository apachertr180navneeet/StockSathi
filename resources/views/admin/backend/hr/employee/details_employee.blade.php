@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body text-center">
                        <img src="{{ (!empty($employee->user->photo)) ? url('upload/admin_images/'.$employee->user->photo) : url('upload/no_image.jpg') }}" class="rounded-circle avatar-xl img-thumbnail mb-3" alt="profile-image">
                        <h4 class="mb-0">{{ $employee->first_name }} {{ $employee->last_name }}</h4>
                        <p class="text-muted">{{ $employee->designation->name ?? 'N/A' }}</p>
                        <span class="badge {{ $employee->status == 'active' ? 'bg-success' : ($employee->status == 'on_leave' ? 'bg-warning' : 'bg-danger') }} mb-3">
                            {{ ucfirst($employee->status) }}
                        </span>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h5 class="header-title mb-3">Personal Information</h5>
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2"><strong>Employee ID:</strong> {{ $employee->employee_id }}</li>
                            <li class="mb-2"><strong>Email:</strong> {{ $employee->email }}</li>
                            <li class="mb-2"><strong>Phone:</strong> {{ $employee->phone ?? 'N/A' }}</li>
                            <li class="mb-2"><strong>Address:</strong> {{ $employee->address ?? 'N/A' }}</li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-body">
                        <ul class="nav nav-tabs nav-bordered">
                            <li class="nav-item">
                                <a href="#employment" data-bs-toggle="tab" aria-expanded="false" class="nav-link active">Employment Details</a>
                            </li>
                            <li class="nav-item">
                                <a href="#attendance" data-bs-toggle="tab" aria-expanded="true" class="nav-link">Recent Attendance</a>
                            </li>
                            <li class="nav-item">
                                <a href="#payroll" data-bs-toggle="tab" aria-expanded="false" class="nav-link">Payroll History</a>
                            </li>
                        </ul>

                        <div class="tab-content">
                            <div class="tab-pane show active" id="employment">
                                <div class="row mt-3">
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Department</label>
                                        <p>{{ $employee->department->name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Designation</label>
                                        <p>{{ $employee->designation->name ?? 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Joining Date</label>
                                        <p>{{ $employee->joining_date->format('M d, Y') }}</p>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label class="form-label fw-bold">Base Salary</label>
                                        <p>{{ number_format($employee->base_salary, 2) }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane" id="attendance">
                                <table class="table table-sm mt-3">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Status</th>
                                            <th>Check In</th>
                                            <th>Check Out</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($employee->attendances()->latest()->take(10)->get() as $att)
                                        <tr>
                                            <td>{{ $att->date->format('M d, Y') }}</td>
                                            <td>{{ $att->status }}</td>
                                            <td>{{ $att->check_in_time ? $att->check_in_time->format('h:i A') : '-' }}</td>
                                            <td>{{ $att->check_out_time ? $att->check_out_time->format('h:i A') : '-' }}</td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="4" class="text-center">No recent records</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>

                            <div class="tab-pane" id="payroll">
                                <table class="table table-sm mt-3">
                                    <thead>
                                        <tr>
                                            <th>Month/Year</th>
                                            <th>Net Salary</th>
                                            <th>Status</th>
                                            <th>Date Paid</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($employee->payrolls()->latest()->take(10)->get() as $pay)
                                        <tr>
                                            <td>{{ date('F', mktime(0, 0, 0, $pay->month, 1)) }} {{ $pay->year }}</td>
                                            <td>{{ number_format($pay->net_salary, 2) }}</td>
                                            <td>{{ $pay->payment_status }}</td>
                                            <td>{{ $pay->payment_date ? $pay->payment_date->format('M d, Y') : '-' }}</td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="4" class="text-center">No payroll history</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
