{{-- ================= DESKTOP TABLE ================= --}}
<div class="table-view table-responsive">
    <table class="table table-bordered align-middle">
        <thead class="table-light">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>City</th>
                <th class="text-end">Action</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($warehouse as $key => $item)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td class="fw-semibold">{{ $item->name }}</td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>{{ $item->city }}</td>

                    <td class="text-end">
                        <a href="{{ route('edit.warehouse', $item->id) }}" class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-edit"></i>
                        </a>

                        <button class="btn btn-outline-danger btn-sm deleteBtn" data-id="{{ $item->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

{{-- ================= MOBILE CARD VIEW ================= --}}
<div class="card-view">
    @foreach ($warehouse as $item)
        <div class="card mb-2 shadow-sm border-0">
            <div class="card-body p-2">

                <div class="d-flex justify-content-between align-items-center">
                    <strong>{{ $item->name }}</strong>

                    <div>
                        <a href="{{ route('edit.warehouse', $item->id) }}" class="btn btn-sm btn-outline-warning">
                            <i class="fas fa-edit"></i>
                        </a>

                        <button class="btn btn-sm btn-outline-danger deleteBtn" data-id="{{ $item->id }}">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                </div>

                <div class="mt-2 small text-muted">
                    📧 {{ $item->email }} <br>
                    📞 {{ $item->phone }} <br>
                    📍 {{ $item->city }}
                </div>

            </div>
        </div>
    @endforeach
</div>

{{-- ================= PAGINATION ================= --}}
<div class="mt-3">
    {{ $warehouse->links() }}
</div>
