<div class="mb-3 {{ $col ?? "col-12" }}">
    @if(isset($label) && $label ==='true')
        <label for="{{ $key }}" class="form-label">{{ $labelName }}</label>
    @endif
    <textarea
        @if(isset($name)) name="{{ $name }}" @endif
        @isset($readonly) readonly @endisset
        @isset($disabled) disabled @endisset
        @isset($required) required @endisset
        id="{{ $key ?? '' }}"
        placeholder="@lang('share.enter') {{$labelName}}" rows="5" class="form-control">@isset($value) {{ $value }} @else {{ old($name) }} @endisset</textarea>
    @error($name) <span class="text-danger fw-bold">{{ $message }}</span> @enderror
</div>
