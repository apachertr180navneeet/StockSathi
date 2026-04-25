@extends('admin.admin_master')
@section('admin')
    <div class="content">

        <!-- Start Content-->
        <div class="container-xxl">

            <div class="py-3 d-flex align-items-sm-center flex-sm-row flex-column">
                <div class="flex-grow-1">
                    <h4 class="fs-18 fw-semibold m-0">All quotations</h4>
                </div>

                <div class="text-end">
                    <ol class="breadcrumb m-0 py-0">
                        <a href="{{ route('add.quotation') }}" class="btn btn-secondary">Add quotations</a>
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
                                        <th>Customer</th>
                                        <th>WareHouse</th>
                                        <th>Status</th>
                                        <th>Grand Total</th>
                                        <th>Created</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($allData as $key => $item)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $item['customer']['name'] ?? 'N/A' }}</td>
                                            <td>{{ $item['warehouse']['name'] ?? 'N/A' }}</td>
                                            <td>
                                                @if($item->status == 'Accepted')
                                                    <span class="badge text-bg-success">{{ $item->status }}</span>
                                                @elseif($item->status == 'Rejected')
                                                    <span class="badge text-bg-danger">{{ $item->status }}</span>
                                                @else
                                                    <span class="badge text-bg-warning">{{ $item->status }}</span>
                                                @endif
                                            </td>
                                            <td>₹{{ $item->grand_total }}</td>
                                            <td>{{ \Carbon\Carbon::parse($item->created_at)->format('Y-m-d') }}</td>
                                            <td>
                                                <a title="Details" href="{{ route('details.quotation', $item->id) }}"
                                                    class="btn btn-info btn-sm"> <span class="mdi mdi-eye-circle mdi-18px"></span> </a>

                                                <a title="PDF Invoice" href="{{ route('invoice.quotation', $item->id) }}"
                                                    class="btn btn-primary btn-sm"> <span class="mdi mdi-download-circle mdi-18px"></span> </a>

                                                @if($item->status != 'Accepted')
                                                <a title="Edit" href="{{ route('edit.quotation', $item->id) }}"
                                                    class="btn btn-success btn-sm"> <span class="mdi mdi-book-edit mdi-18px"></span> </a>
                                                    
                                                <a title="Convert to Sale" href="{{ route('convert.quotation', $item->id) }}"
                                                    class="btn btn-warning btn-sm" onclick="return confirm('Are you sure you want to convert this quotation to a sale? This will deduct stock.')"> <span class="mdi mdi-cart-arrow-right mdi-18px"></span> </a>
                                                @endif

                                                <a title="Delete" href="{{ route('delete.quotation', $item->id) }}"
                                                    class="btn btn-danger btn-sm" id="delete"><span class="mdi mdi-delete-circle mdi-18px"></span></a>
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
