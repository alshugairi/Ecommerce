@extends('layouts.app')
@section('content')
    <form action="{{ route('products.store') }}" method="post" id="submitForm" enctype="multipart/form-data">
        @method('post')
        @csrf
        <div class="row">
            <div class="col-md-4">
                <h4>{{ __('share.create') }} {{ __('modules/product.product') }}</h4>
            </div>
            <div class="col-md-8 text-right">
                <x-datatable.save module="{{ __('modules/product.product') }}"/>
            </div>
        </div>

        <div class="card mb-1">
            <div class="card-body">
                <x-layouts.language-tabs>
                    @foreach($appLanguages as $appLanguage)
                         <div class="tab-pane fade{{ $loop->first ? ' show active' : '' }}" id="navs-top-{{ $appLanguage->id }}" role="tabpanel">
                                <div class="row">
                                    <x-form.input type="text" name="name[{{ $appLanguage->code }}]" required="true"
                                                  key="id-name-{{ $appLanguage->code }}"
                                                  value="{{ old('name.'.$appLanguage->code) }}"
                                                  label="true" labelName="{{ __('modules/product.name') }}"/>
                                    <x-form.textarea name="description[{{ $appLanguage->code }}]" required="true"
                                                  key="id-description-{{ $appLanguage->code }}"
                                                  value="{{ old('description.'.$appLanguage->code) }}"
                                                  label="true" labelName="{{ __('modules/product.description') }}"/>
                                </div>
                            </div>
                    @endforeach
                </x-layouts.language-tabs>

                <div class="row">
                    <x-form.input type="text" name="price" key="id-price" label="true" labelName="{{ __('modules/product.price') }}"/>
                    <x-form.input type="text" name="quantity" key="id-quantity" label="true" labelName="{{ __('modules/product.quantity') }}"/>
                    <x-form.select label="true" key="input-category_id" name="category_id" :elements="$categories" labelName="{{ trans('modules/product.category') }}"/>
                    <x-form.input type="file" name="image" key="input-image" label="true" labelName="{{ __('modules/product.image') }}"/>
                    <div class="clearfix"></div>
                    <div class="col-6">
                        <img id="imagePreview" class="img-fluid img-thumbnail rounded-2" style="max-height: 200px">
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('js')
    <script>
        document.getElementById('input-image').addEventListener('change', function() {
            var file = this.files[0];
            if (file) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('imagePreview').src = e.target.result;
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endpush

