@extends('layouts.app')
@section('content')
    <form action="{{ route('roles.update', $data->id) }}" method="post" id="submitForm">
        @method('put')
        @csrf
        <div class="row mb-2">
            <div class="col-md-4">
                <h4>{{ __('share.edit') }} {{ __('modules/administration/role.role') }}</h4>
            </div>
            <div class="col-md-8 text-right">
                <x-datatable.save module="{{ __('modules/administration/role.role') }}"/>
            </div>
        </div>

        <div class="card mb-1">
            <div class="card-body">
                <x-form.input type="text" name="name" required="true" key="id-input" value="{{ $data->name }}" label="true" labelName="{{ __('modules/administration/role.name') }}"/>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                @foreach($groupedPermissions as $key => $groupedPermission)
                    <div class="mb-2">
                        <h5 class="pb-1">{{ __('share.'. $key) }}</h5>
                        <div class="row">
                            @foreach($groupedPermission as $permission)
                                <div class="col-md-3">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="{{ $permission->name }}"
                                               name="role_permissions[]" value="{{ $permission->name }}" @checked(in_array($permission->name, $rolePermissions))>
                                        <label class="form-check-label" for="{{ $permission->name }}">{{ __('share.'. $permission->action) }}</label>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
                @error('role_permissions') <span class="text-danger fw-bold">{{ $message }}</span> @enderror
            </div>
        </div>
    </form>
@endsection
