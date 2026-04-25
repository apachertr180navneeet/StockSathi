@extends('admin.admin_master')

@section('admin')
<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Edit Account</h4>
            <a href="{{ route('all.account') }}" class="btn btn-secondary btn-sm">
                Back to COA
            </a>
        </div>

        <div class="card shadow-sm border-0">
            <div class="card-body p-4">
                <form action="{{ route('update.account') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $account->id }}">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Account Code <span class="text-danger">*</span></label>
                            <input type="text" name="code" class="form-control @error('code') is-invalid @enderror" value="{{ $account->code }}" required {{ $account->is_system ? 'readonly' : '' }}>
                            @error('code') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Account Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ $account->name }}" required>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Account Type <span class="text-danger">*</span></label>
                            <select name="type" class="form-control @error('type') is-invalid @enderror" required>
                                <option value="Asset" {{ $account->type == 'Asset' ? 'selected' : '' }}>Asset</option>
                                <option value="Liability" {{ $account->type == 'Liability' ? 'selected' : '' }}>Liability</option>
                                <option value="Equity" {{ $account->type == 'Equity' ? 'selected' : '' }}>Equity</option>
                                <option value="Revenue" {{ $account->type == 'Revenue' ? 'selected' : '' }}>Revenue</option>
                                <option value="Expense" {{ $account->type == 'Expense' ? 'selected' : '' }}>Expense</option>
                            </select>
                            @error('type') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Parent Account</label>
                            <select name="parent_id" class="form-control">
                                <option value="">No Parent</option>
                                @foreach($parentAccounts as $parent)
                                <option value="{{ $parent->id }}" {{ $account->parent_id == $parent->id ? 'selected' : '' }}>{{ $parent->code }} - {{ $parent->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label">Status</label>
                            <select name="status" class="form-control">
                                <option value="Active" {{ $account->status == 'Active' ? 'selected' : '' }}>Active</option>
                                <option value="Inactive" {{ $account->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-3">
                            <label class="form-label">Description</label>
                            <textarea name="description" class="form-control" rows="3">{{ $account->description }}</textarea>
                        </div>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary">Update Account</button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
