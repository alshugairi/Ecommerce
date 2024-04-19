@extends('layouts.app')
@section('content')
    <form action="{{ route('permissions.update', $data->id) }}" method="post" id="submitForm">
        @method('put')
        @csrf
        <div class="row mb-2">
            <div class="col-md-4">
                <h4>{{ __('share.edit') }} {{ __('modules/administration/permission.permission') }}</h4>
            </div>
            <div class="col-md-8 text-right">
                <x-datatable.save module="{{ __('modules/administration/permission.permission') }}"/>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <x-form.input type="text" name="name" required="true" key="id-input" value="{{ $data->name }}" label="true" labelName="{{ __('modules/administration/permission.name') }}"/>
            </div>
        </div>
    </form>
@endsection
