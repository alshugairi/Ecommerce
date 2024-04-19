@extends('layouts.app')
@section('content')
    <div class="row mb-2">
        <div class="col-md-4">
            <h4>{{ __('share.profile') }}</h4>
        </div>
        <div class="col-md-8 text-right">
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">{{ __('share.profile_details') }}</h5>
                <!-- Account -->
                <div class="card-body">
                    <div class="d-flex align-items-start align-items-sm-center gap-4">
                        <img
                            src="{{ asset('assets') }}/admin/img/user_avatar.jpg"
                            alt="user-avatar"
                            class="d-block w-px-100 h-px-100 rounded"
                            id="uploadedAvatar" />
                        <div class="button-wrapper mx-2">
                            <label for="upload" class="btn btn-primary me-2 mb-3" tabindex="0">
                                <span class="d-none d-sm-block">{{ __('share.upload_photo') }}</span>
                                <i class="ti ti-upload d-block d-sm-none"></i>
                                <input
                                    type="file"
                                    id="upload"
                                    class="account-file-input"
                                    hidden
                                    accept="image/png, image/jpeg" />
                            </label>
{{--                            <button type="button" class="btn btn-label-secondary account-image-reset mb-3">--}}
{{--                                <i class="ti ti-refresh-dot d-block d-sm-none"></i>--}}
{{--                                <span class="d-none d-sm-block">{{ __('share.reset') }}</span>--}}
{{--                            </button>--}}
                            {{--                                <div class="text-muted">Allowed JPG, GIF or PNG. Max size of 800K</div>--}}
                        </div>
                    </div>
                </div>
                <hr class="my-0" />
                <div class="card-body">
                    <form id="formAccountSettings" method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        <div class="row">
                            <x-form.input type="text" col="col-md-6" label="true" key="input-name" name="name" labelName="{{ trans('modules/account/user.name') }}" value="{{ $data->name }}"/>
                            <x-form.input type="email" col="col-md-6" label="true" key="input-email" name="email" disabled="disabled" labelName="{{ trans('modules/account/user.email') }}" value="{{ $data->email }}"/>
                            <x-form.input type="text" col="col-md-6" label="true" key="input-phone" name="phone" labelName="{{ trans('modules/account/user.phone') }}" value="{{ $data->phone }}"/>
                        </div>
                        <div class="mt-2">
                            <x-datatable.save module="{{ __('share.save_changes') }}"/>
                        </div>
                    </form>
                </div>
                <!-- /Account -->
            </div>
            <div class="card">
                <h5 class="card-header">{{ __('share.change_password') }}</h5>
                <div class="card-body">
                    <form id="formAccountSettings" method="POST" action="{{ route('profile.change_password') }}">
                        @csrf
                        <x-form.input type="password" label="true" key="input-password" name="password" labelName="{{ trans('modules/account/user.password') }}" autocomplete="new-password"/>
                        <x-form.input type="password" label="true" key="input-password-confirmation" name="password-confirmation" labelName="{{ trans('modules/account/user.confirm_password') }}"/>
                        <button type="submit" class="btn btn-danger deactivate-account">{{ __('share.change') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
