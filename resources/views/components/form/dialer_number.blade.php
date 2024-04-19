<div class="mb-5 {{ $col ?? "col-12" }}">
    <div wire:ignore>
        @if(isset($label) && $label ==='true')
            <label for="{{ $key }}" class="fw-semibold fs-6 mb-2">{{ $labelName }}</label>
        @endif
        <div class="position-relative" id="{{ $key }}_1">
            <button type="button" @isset($dynamic) wire:click="decrease('{{ $index }} ','{{ $element }}')"
                    @else data-kt-dialer-control="decrease" @endisset
                    class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 start-0">
                <i class="fa-solid fa-square-minus" style="font-size: 20px"></i>
            </button>
            <input type="number"
                   id="{{ $key }}"
                   class="form-control form-control-solid border-0 ps-12 dialer_number"
                   data-kt-dialer-control="input"
                   name="manageBudget"
                   @if(isset($defer)) wire:model.defer="{{ $name }}"
                   @elseif(isset($lazy)) wire:model.lazy="{{ $name }}"
                   @else wire:model="{{ $name }}" @endif
                   @isset($readonly) readonly @endisset />
            <button type="button" @isset($dynamic) wire:click="increase('{{ $index }} ','{{ $element }}')"
                    @else data-kt-dialer-control="increase" @endisset
                    class="btn btn-icon btn-active-color-gray-700 position-absolute translate-middle-y top-50 end-0">
                <i class="fa-solid fa-square-plus" style="font-size: 20px"></i>
            </button>
        </div>
    </div>
    @error($name) <span class="text-danger" style="font-weight: bold">{{ $message }}</span> @enderror
</div>
@push('script')
    <script>
        $(document).ready(function () {
            $(function () {
                let dialerObject = new KTDialer(document.querySelector("#{{ $key }}_1"), {
                    min: 0,
                    step: 1,
                    @isset($decimal)
                    decimals: 2
                    @endisset
                });
                dialerObject.on('kt.dialer.changed', function () {
                @this.set('{{ $name }}', dialerObject.getValue());
                });
            })
        })
    </script>
@endpush
