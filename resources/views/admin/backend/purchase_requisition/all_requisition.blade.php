@extends('admin.admin_master')
@section('admin')
    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">Purchase Requisitions</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <a href="{{ route('add.purchase.requisition') }}" class="btn btn-secondary">Add Requisition</a>
                    </ol>
                </div>
            </div>

            <!-- Datatables  -->
            <div class="row">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header">
                        </div><!-- end card header -->

                        <div class="card-body">
                            <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>Sl</th>
                                        <th>Req No</th>
                                        <th>Date</th>
                                        <th>Supplier</th>
                                        <th>Warehouse</th>
                                        <th>Status</th>
                                        <th>Total Amount</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allData as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item->requisition_no }}</td>
                                            <td>{{ $item->date }}</td>
                                            <td>{{ $item['supplier']['name'] ?? 'N/A' }}</td>
                                            <td>{{ $item['warehouse']['name'] ?? 'N/A' }}</td>
                                            <td>
                                                @if($item->status == 'Pending')
                                                    <span class="badge bg-warning">Pending</span>
                                                @elseif($item->status == 'Approved')
                                                    <span class="badge bg-primary">Approved</span>
                                                @elseif($item->status == 'Completed')
                                                    <span class="badge bg-success">Completed</span>
                                                @else
                                                    <span class="badge bg-danger">{{ $item->status }}</span>
                                                @endif
                                            </td>
                                            <td>₹{{ number_format($item->total_amount, 2) }}</td>
                                            <td>
                                                <a title="Details" href="{{ route('details.purchase.requisition', $item->id) }}"
                                                    class="btn btn-info btn-sm"> <span
                                                        class="mdi mdi-eye-circle mdi-18px"></span> </a>

                                                <a title="PDF Invoice" href="{{ route('invoice.purchase.requisition', $item->id) }}"
                                                    class="btn btn-primary btn-sm"> <span
                                                        class="mdi mdi-download-circle mdi-18px"></span> </a>

                                                @if($item->status != 'Completed')
                                                <a title="Edit" href="{{ route('edit.purchase.requisition', $item->id) }}"
                                                    class="btn btn-success btn-sm"> <span
                                                        class="mdi mdi-book-edit mdi-18px"></span> </a>
                                                @endif

                                                @if($item->status == 'Approved')
                                                <a title="Convert to PO" href="{{ route('convert.requisition.to.po', $item->id) }}"
                                                    class="btn btn-dark btn-sm"> <span
                                                        class="mdi mdi-file-replace mdi-18px"></span> </a>

                                                <a title="Convert to Purchase" href="{{ route('convert.purchase.requisition', $item->id) }}"
                                                    class="btn btn-warning btn-sm"> <span
                                                        class="mdi mdi-swap-horizontal mdi-18px"></span> </a>
                                                @endif

                                                <a title="Delete" href="{{ route('delete.purchase.requisition', $item->id) }}"
                                                    class="btn btn-danger btn-sm" id="delete"><span
                                                        class="mdi mdi-delete-circle  mdi-18px"></span></a>
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
