<div class="table-responsive">
    <table class="table table-hover align-middle table-bordered nowrap w-100 mb-0">
        <thead class="table-light">
            <tr>
                <th width="5%">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAllTrash">
                    </div>
                </th>
                <th width="5%" class="border-bottom-0">Sl</th>
                <th class="border-bottom-0">Customer Name</th>
                <th class="border-bottom-0">Email</th>
                <th class="border-bottom-0">Phone</th>
                <th class="border-bottom-0">Address</th>
                <th class="border-bottom-0">Deleted At</th>
                <th width="15%" class="border-bottom-0">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customer as $key => $item)
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input trashCheckbox" type="checkbox" value="{{ $item->id }}">
                        </div>
                    </td>
                    <td>{{ $customer->firstItem() + $key }}</td>
                    <td class="fw-medium text-dark">{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->phone }}</td>
                    <td title="{{ $item->address }}">
                        {{ \Illuminate\Support\Str::limit($item->address, 30, '...') }}
                    </td>
                    <td class="text-muted small">{{ $item->deleted_at->format('d M Y, h:i A') }}</td>
                    <td>
                        <div class="d-flex gap-2">
                            <button class="btn btn-soft-info btn-sm border-0 restoreBtn" 
                                    style="background-color: #e3f2fd; color: #0277bd; transition: all 0.2s;" data-id="{{ $item->id }}" title="Restore">
                                <i class="fas fa-undo"></i>
                            </button>
                            <button class="btn btn-soft-danger btn-sm border-0 parmanentDeleteBtn" 
                                    style="background-color: #ffebee; color: #c62828; transition: all 0.2s;" data-id="{{ $item->id }}" title="Delete Forever">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                        <div class="mb-3">
                            <i class="fas fa-trash-alt fs-1 text-light"></i>
                        </div>
                        <p class="mb-0 fw-medium text-dark">No Trashed Customers Found</p>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-0 pt-4 border-top">
    <div class="px-1">
        {!! $customer->links() !!}
    </div>
</div>
