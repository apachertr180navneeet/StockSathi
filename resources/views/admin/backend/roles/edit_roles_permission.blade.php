@extends('admin.admin_master')

@section('admin')
<style>
    .form-check-label { text-transform: capitalize; }
</style>

<div class="content mt-3 px-3">
    <div class="container-fluid">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fs-20 fw-semibold m-0">Edit Role in Permission</h4>
        </div>

        <div class="row">
            <div class="col-lg-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body p-4">

                        <form action="{{ route('admin.roles.update', $role->id) }}" method="post" id="myForm">
                            @csrf

                            <div class="mb-3">
                                <label for="role_id" class="form-label">Role Name</label>
                                <h4>{{ $role->name }}</h4>
                            </div>

                            <div class="form-check mb-3">
                                <input class="form-check-input" type="checkbox" value="" id="checkDefaultMain">
                                <label class="form-check-label" for="checkDefaultMain">
                                    All Permission
                                </label>
                            </div>

                            <hr>

                            @foreach($permission_groups as $group)
                            <div class="row">
                                <div class="col-3">
                                    @php
                                        $permissions = App\Models\User::getpermissionByGroupName($group->group_name);
                                    @endphp

                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" {{ App\Models\User::roleHasPermissions($role, $permissions) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="flexCheckDefault">
                                            {{ $group->group_name }}
                                        </label>
                                    </div>
                                </div>

                                <div class="col-9">
                                    @foreach($permissions as $permission)
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" name="permission[]" type="checkbox" value="{{ $permission->id }}" id="checkDefault{{ $permission->id }}" {{ $role->hasPermissionTo($permission->name) ? 'checked' : '' }}>
                                        <label class="form-check-label" for="checkDefault{{ $permission->id }}">
                                            {{ $permission->name }}
                                        </label>
                                    </div>
                                    @endforeach
                                    <br>
                                </div>
                            </div>
                            @endforeach

                            <button type="submit" class="btn btn-primary mt-3">Update Changes</button>

                        </form>

                    </div>
                </div>
            </div>
        </div>

    </div>
</div>

<script>
    $('#checkDefaultMain').click(function(){
        if ($(this).is(':checked')) {
            $('input[type=checkbox]').prop('checked',true);
        } else {
            $('input[type=checkbox]').prop('checked',false);
        }
    });
</script>
@endsection
