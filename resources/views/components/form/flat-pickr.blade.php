<div class="mb-5 {{ $col ?? "col-12" }}">
    @if(isset($label) && $label === 'true')
    <label for="{{ $id }}" class="form-label">{{ $labelName }}</label>
    @endif
    <input
        @if(isset($defer)) wire:model.defer="{{ $name }}"
        @elseif(isset($lazy)) wire:model.lazy="{{ $name }}"
        @else wire:model="{{ $name }}" @endif
        @isset($readonly) readonly @endisset
        class="form-control form-control-solid"
        placeholder="{{ $labelName }}"
        id="{{ $id }}"/>
        @error($name) <span class="text-danger" style="font-weight: bold">{{  $message  }}</span> @enderror
</div>

@push('js')
<script>
    $("#{{ $id }}").flatpickr({
        @isset($dateTime)
        enableTime: true,
        dateFormat: "Y-m-d H:i",
        @endisset

    });
</script>
@endpush
