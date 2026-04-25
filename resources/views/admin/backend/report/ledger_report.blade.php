@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Ledger Report: {{ $account->name }}</h4>
            <a href="{{ route('report.ledger') }}" class="btn btn-secondary btn-sm">Change Account</a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <div class="text-center mb-4">
                    <h3>General Ledger</h3>
                    <h5>Account: {{ $account->code }} - {{ $account->name }}</h5>
                    <p class="text-muted">Period: {{ \Carbon\Carbon::parse($startDate)->format('d M Y') }} to {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}</p>
                </div>

                <div class="table-responsive">
                    <table class="table table-bordered table-sm">
                        <thead class="table-light">
                            <tr>
                                <th>Date</th>
                                <th>Reference</th>
                                <th>Description</th>
                                <th class="text-end">Debit</th>
                                <th class="text-end">Credit</th>
                                <th class="text-end">Balance</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td colspan="3" class="fw-bold">Opening Balance</td>
                                <td class="text-end">-</td>
                                <td class="text-end">-</td>
                                <td class="text-end fw-bold">{{ number_format($openingBalance, 2) }}</td>
                            </tr>
                            @php $runningBalance = $openingBalance; @endphp
                            @foreach($items as $item)
                            @php
                                if (in_array($account->type, ['Asset', 'Expense'])) {
                                    $runningBalance += ($item->debit - $item->credit);
                                } else {
                                    $runningBalance += ($item->credit - $item->debit);
                                }
                            @endphp
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($item->journalEntry->entry_date)->format('d M Y') }}</td>
                                <td>{{ $item->journalEntry->reference_no }}</td>
                                <td>{{ $item->description }}</td>
                                <td class="text-end text-success">{{ $item->debit > 0 ? number_format($item->debit, 2) : '-' }}</td>
                                <td class="text-end text-danger">{{ $item->credit > 0 ? number_format($item->credit, 2) : '-' }}</td>
                                <td class="text-end fw-bold">{{ number_format($runningBalance, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="table-light fw-bold">
                            <tr>
                                <td colspan="3" class="text-end">Closing Balance</td>
                                <td class="text-end">{{ number_format($items->sum('debit'), 2) }}</td>
                                <td class="text-end">{{ number_format($items->sum('credit'), 2) }}</td>
                                <td class="text-end">{{ number_format($runningBalance, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection
