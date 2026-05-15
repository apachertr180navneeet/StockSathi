<div class="table-responsive">
    <table class="table table-hover align-middle table-bordered nowrap w-100 mb-0">
        <thead class="table-light">
            <tr>
                <th width="5%">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="selectAll">
                    </div>
                </th>
                <th width="5%" class="border-bottom-0">Sl</th>
                <th class="border-bottom-0">Customer Name</th>
                <th class="border-bottom-0">Email</th>
                <th class="border-bottom-0">Phone</th>
                <th class="border-bottom-0">Address</th>
                <th width="10%" class="border-bottom-0">Status</th>
                <th width="15%" class="border-bottom-0">Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($customer as $key => $item)
                <tr>
                    <td>
                        <div class="form-check">
                            <input class="form-check-input custCheckbox" type="checkbox" value="{{ $item->id }}">
                        </div>
                    </td>
                    <td>{{ $customer->firstItem() + $key }}</td>
                    <td class="fw-medium text-dark">{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->phone }}</td>
                    <td title="{{ $item->address }}">
                        {{ \Illuminate\Support\Str::limit($item->address, 30, '...') }}
                    </td>
                    <td>
                        <div class="form-check form-switch">
                            <input class="form-check-input statusToggle" type="checkbox" data-id="{{ $item->id }}"
                                {{ $item->status == 1 ? 'checked' : '' }}>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex gap-2">
                            <a href="{{ route('edit.customer', $item->id) }}" class="btn btn-soft-success btn-sm border-0" 
                               style="background-color: #e8f5e9; color: #2e7d32; transition: all 0.2s;" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <button class="btn btn-soft-danger btn-sm border-0 deleteBtn" 
                                    style="background-color: #ffebee; color: #c62828; transition: all 0.2s;" data-id="{{ $item->id }}" title="Delete">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center text-muted py-5">
                        <div class="mb-3">
                            <i class="fas fa-folder-open fs-1 text-light"></i>
                        </div>
                        <p class="mb-0 fw-medium text-dark">No Customers Found</p>
                        <small>Try adjusting your search or add a new customer.</small>
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
