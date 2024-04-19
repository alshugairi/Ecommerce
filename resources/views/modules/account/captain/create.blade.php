@extends('layouts.app')
@section('content')
    <form action="{{ route('captains.store') }}" method="post" id="submitForm">
        @csrf
        <div class="row mb-2">
            <div class="col-md-4">
                <h4>{{ __('share.create') }} {{ __('modules/account/captain.captain') }}</h4>
            </div>
            <div class="col-md-8 text-right">
                <x-datatable.save module="{{ __('modules/account/captain.captain') }}"/>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <x-form.input type="text" label="true" key="input-name" name="name" required="true" labelName="{{ trans('modules/account/captain.name') }}"/>
                <x-form.input type="email" label="true" key="input-email" name="email" required="true" labelName="{{ trans('modules/account/captain.email') }}"/>
                <x-form.input type="text" label="true" key="input-phone" name="phone" labelName="{{ trans('modules/account/captain.phone') }}"/>
                <x-form.input type="password" label="true" key="input-password" name="password" labelName="{{ trans('modules/account/captain.password') }}" autocomplete="new-password"/>
                <x-form.input type="password" label="true" key="input-password-confirmation" name="password-confirmation" labelName="{{ trans('modules/account/captain.confirm_password') }}"/>
            </div>
        </div>
    </form>
@endsection
