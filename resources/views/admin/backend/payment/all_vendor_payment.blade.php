@extends('admin.admin_master')
@section('admin')
    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">All Vendor Payments</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <a href="{{ route('add.vendor.payment') }}" class="btn btn-secondary">Add Payment</a>
                    </ol>
                </div>
            </div>

            <!-- Datatables  -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                            <h5 class="card-title mb-0">Payment Transactions</h5>
                        </div><!-- end card header -->

                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Payment No</th>
                                        <th>Date</th>
                                        <th>Supplier</th>
                                        <th>Purchase ID</th>
                                        <th>Amount</th>
                                        <th>Method</th>
                                        <th>Ref No</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allData as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->payment_no }}</td>
                                            <td>{{ $item->payment_date }}</td>
                                            <td>{{ $item['supplier']['name'] }}</td>
                                            <td>
                                                @if($item->purchase_id)
                                                    <a href="{{ route('details.purchase', $item->purchase_id) }}">#{{ $item->purchase_id }}</a>
                                                @else
                                                    <span class="text-muted">General</span>
                                                @endif
                                            </td>
                                            <td>₹{{ number_format($item->amount, 2) }}</td>
                                            <td>{{ $item->payment_method }}</td>
                                            <td>{{ $item->reference_no ?? 'N/A' }}</td>
                                            <td>
                                                <a title="Delete" href="{{ route('delete.vendor.payment', $item->id) }}"
                                                    class="btn btn-danger btn-sm" id="delete"><span
                                                        class="mdi mdi-delete-circle mdi-18px"></span></a>
                                            </td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>

        </div> <!-- container-fluid -->

    </div> <!-- content -->
@endsection
