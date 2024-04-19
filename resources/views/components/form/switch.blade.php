<div class="mb-3 {{ $col ?? "col-12" }}">
    @if(isset($label) && $label ==='true')
        <label for="{{ $key }}" class="form-label">{{ $labelName }}</label>
    @endif
        @php($inputValue = $value ?? old($name))
        @php($defaultValue = $default ?? 1)
        <div class="form-check form-switch mb-2">
            <input type="checkbox" @checked($inputValue === $defaultValue) class="form-check-input"
                   name="{{$name}}" value="{{ $defaultValue }}" id="{{ $id ?? '' }}"/>
        </div>
        @error($name) <span class="text-danger fw-bold">{{ $message }}</span> @enderror
</div>


