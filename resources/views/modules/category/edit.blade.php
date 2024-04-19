@extends('layouts.app')
@section('content')
    <form action="{{ route('categories.update', $category->id) }}" method="post" id="submitForm">
        @method('put')
        @csrf
        <div class="row">
            <div class="col-md-4">
                <h4>{{ __('share.edit') }} {{ __('modules/category.category') }}</h4>
            </div>
            <div class="col-md-8 text-right">
                <x-datatable.save module="{{ __('modules/category.category') }}"/>
            </div>
        </div>

        <div class="card mb-1">
            <div class="card-body">
                <x-layouts.language-tabs>
                    @foreach($appLanguages as $appLanguage)
                        <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}" id="navs-top-{{ $appLanguage->id }}" role="tabpanel">
                            <div class="row">
                                <x-form.input type="text" name="name[{{ $appLanguage->code }}]" required="true"
                                              key="id-input-{{ $appLanguage->code }}"
                                              value="{{ $category->getTranslation('name', $appLanguage->code) }}"
                                              label="true" labelName="{{ __('modules/category.name') }}"/>
                            </div>
                        </div>
                    @endforeach
                </x-layouts.language-tabs>
            </div>
        </div>
    </form>
@endsection
