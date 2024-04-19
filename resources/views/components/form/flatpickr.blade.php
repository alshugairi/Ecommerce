<div class="mb-0 {{ $col ?? "col-12" }}">
    @if(isset($isHaveLabel) && $isHaveLabel === 'true')
        <label for="{{ $key }}" class="fw-semibold fs-6 mb-2">{{ $labelName }}</label>
    @endif
    <input
        @if(isset($isDefer))
            wire:model.defer="{{ $name }}"
        @elseif(isset($isLazy))
            wire:model.lazy="{{ $name }}"
        @else
            wire:model="{{ $name }}"
        @endif
        id="{{ $key }}"
        class="form-control form-control-solid @error($name) is-invalid @enderror"
        placeholder="{{ $placeholder ?? '' }}"
        autocomplete="off"
        @if(isset($value)) value="{{ $value }}" @endif

    />
    @error($name) <span class="text-danger" style="font-weight: bold">{{ $message }}</span> @enderror
</div>

@push("script")
    <script>
        let flatpickr{{ $key }} = {};
        flatpickr{{ $key }}.dateFormat = '{{ $dateFormat ?? "Y-m-d H:i" }}';
        @isset($enableTime)
            flatpickr{{ $key }}.enableTime = true;
        @endisset
            @isset($minDate)
            flatpickr{{ $key }}.minDate = '{{ $minDate }}';
        @endisset
            @isset($maxDate)
            flatpickr{{ $key }}.minDate = '{{ $maxDate }}';
        @endisset
        @if(count($onUpdateComponenet))
            flatpickr{{ $key }}.onClose = function (selectedDates, dateStr, instance) {
            @foreach($onUpdateComponenet as $function)
            livewire.emit(`{{ $function }}`, [])
            @endforeach
        }
        @endif

        $(document).ready(function () {
            $("#{{ $key }}").flatpickr(flatpickr{{ $key }});
        });
    </script>
@endpush
