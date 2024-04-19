@extends('layouts.app')
@section('content')
    <form action="{{ route('languages.store') }}" method="post" id="submitForm">
        @method('post')
        @csrf
        <div class="row mb-2">
            <div class="col-md-4">
                <h4>{{ __('share.create') }} {{ __('modules/administration/language.language') }}</h4>
            </div>
            <div class="col-md-8 text-right">
                <x-datatable.save module="{{ __('modules/administration/language.language') }}"/>
            </div>
        </div>

        <div class="card mb-1">
            <div class="card-body">
                <x-form.input type="text" name="name" required="true" key="id-input" label="true" labelName="{{ __('modules/administration/language.name') }}"/>
                <x-form.input type="text" name="code" required="true" key="id-code" label="true" labelName="{{ __('modules/administration/language.code') }}"/>
            </div>
        </div>
    </form>
@endsection
