@push('cs')
    <link href="{{ secure_asset('plugins/custom/prismjs/prismjs.bundle.css') }}" rel="stylesheet" type="text/css"/>
@endpush
<div class="mb-5 {{ $col?? "col-12" }}">
    <div wire:ignore>
        @if(isset($label) && $label=='true')
            <label for="{{$key}}" class="fw-semibold fs-6 mb-2">{{$labelName}}</label>
        @endif
        <textarea
            @if(isset($defer)) wire:model.defer="{{$name}}" @else wire:model="{{$name}}" @endif  id="{{$key}}"
            placeholder="@lang('share.Enter') {{$labelName}}" rows="5"
            class=" kt_docs_ckeditor_classic form-control form-control-solid mb-3 mb-lg-0">
        {{ $value ?? ''}}
    </textarea>
    </div>
    @error($name) <span class="text-danger" style="font-weight: bold">{{ $message }}</span> @enderror
</div>
@push('script')
    <script src="{{secure_asset('plugins/custom/prismjs/prismjs.bundle.js')}}"></script>
    <script src="{{secure_asset('plugins/custom/ckeditor/ckeditor-classic.bundle.js')}}"></script>
    <script>
        $(function () {
            ClassicEditor
                .create(document.querySelector('.kt_docs_ckeditor_classic'))
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                    @this.set('body', editor.getData());
                    })
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endpush
