@extends('admin.admin_master')
@section('admin')

<div class="content d-flex flex-column flex-column-fluid">
    <div class="d-flex flex-column-fluid">
        <div class="container-fluid my-4">
            <div class="d-md-flex align-items-center justify-content-between">
                <h3 class="mb-0"> Purchase Requisition Details: {{ $requisition->requisition_no }}</h3>
                <div class="text-end my-2 mt-md-0">
                    @if($requisition->status == 'Approved')
                    <a class="btn btn-dark" href="{{ route('convert.requisition.to.po', $requisition->id) }}"><i class="mdi mdi-file-replace"></i> Convert to PO</a>
                    @endif
                    <a class="btn btn-primary" href="{{ route('invoice.purchase.requisition', $requisition->id) }}"><i class="fas fa-download"></i> Download PDF</a>
                    <a class="btn btn-outline-primary" href="{{ route('all.purchase.requisition') }}">Back</a>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-body">
                    <div class="row">
                        {{-- supplier info --}}
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm border-0 h-100" style="border-radius: 10px;">
                                <div class="card-header text-white text-center" style="background: linear-gradient(135deg, #17a2b8, #0d6efd); border-radius:10px 10px 0 0;">
                                    <h5 class="mb-0 fw-bold">Supplier Information</h5>
                                </div>
                                <div class="card-body p-4">
                                    @if($requisition->supplier)
                                    <div class="mb-2"><strong>Name:</strong> {{ $requisition->supplier->name }}</div>
                                    <div class="mb-2"><strong>Email:</strong> {{ $requisition->supplier->email }}</div>
                                    <div class="mb-2"><strong>Phone:</strong> {{ $requisition->supplier->phone }}</div>
                                    @else
                                    <div class="text-muted">No supplier specified</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Warehouse info --}}
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm border-0 h-100" style="border-radius: 10px;">
                                <div class="card-header text-white text-center" style="background: linear-gradient(135deg, #17a2b8, #0d6efd); border-radius:10px 10px 0 0;">
                                    <h5 class="mb-0 fw-bold">Warehouse Information</h5>
                                </div>
                                <div class="card-body p-4">
                                    @if($requisition->warehouse)
                                    <div class="mb-2"><strong>Name:</strong> {{ $requisition->warehouse->name }}</div>
                                    @else
                                    <div class="text-muted">No warehouse specified</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- Requisition info --}}
                        <div class="col-md-4 mb-4">
                            <div class="card shadow-sm border-0 h-100" style="border-radius: 10px;">
                                <div class="card-header text-white text-center" style="background: linear-gradient(135deg, #17a2b8, #0d6efd); border-radius:10px 10px 0 0;">
                                    <h5 class="mb-0 fw-bold">General Information</h5>
                                </div>
                                <div class="card-body p-4">
                                    <div class="mb-2"><strong>Date:</strong> {{ $requisition->date }}</div>
                                    <div class="mb-2"><strong>Status:</strong> 
                                        @if($requisition->status == 'Pending')
                                            <span class="badge bg-warning">Pending</span>
                                        @elseif($requisition->status == 'Approved')
                                            <span class="badge bg-primary">Approved</span>
                                        @elseif($requisition->status == 'Completed')
                                            <span class="badge bg-success">Completed</span>
                                        @else
                                            <span class="badge bg-danger">{{ $requisition->status }}</span>
                                        @endif
                                    </div>
                                    <div class="mb-2"><strong>Requested By:</strong> {{ $requisition->user->name ?? 'N/A' }}</div>
                                    <div class="mb-2"><strong>Grand Total:</strong> ₹{{ number_format($requisition->total_amount, 2) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card shadow-sm border-0" style="border-radius: 10px;">
                                <div class="card-header text-white text-center" style="background: linear-gradient(135deg, #17a2b8, #0d6efd); border-radius:10px 10px 0 0;">
                                    <h5 class="mb-0 fw-bold">Items Summary</h5>
                                </div>
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Estimated Unit Cost</th>
                                                <th>Subtotal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($requisition->requisitionItems as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $item->product->code }} - {{ $item->product->name }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>₹{{ number_format($item->estimated_cost, 2) }}</td>
                                                <td>₹{{ number_format($item->subtotal, 2) }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th colspan="4" class="text-end">Grand Total</th>
                                                <th>₹{{ number_format($requisition->total_amount, 2) }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

                    @if($requisition->note)
                    <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="card shadow-sm border-0" style="border-radius: 10px;">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0">Notes</h5>
                                </div>
                                <div class="card-body">
                                    {{ $requisition->note }}
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
