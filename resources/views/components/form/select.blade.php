<div class="mb-3 {{ $col ?? "col-12" }}">
    @if(isset($label) && $label ==='true')
        <label for="{{ $key }}" class="form-label">{{ $labelName }}</label>
    @endif
    @php($inputValue = $value ?? old($name))
    <select name="{{ $name }}"
            @isset($multiple)
                multiple="multiple"
            @endisset
            @isset($required) required @endisset
            @if(isset($isDisable) && $isDisable) disabled @endif
            id="{{ $key ?? '' }}"
            class="form-control form-select {{ $classes ?? '' }} @error($name) is-invalid @enderror " data-placeholder="@lang('share.select') {{ $labelName }}"
            data-control="select2">
            <option value="">@lang('share.select')</option>
            @foreach($elements as $keyValue => $valueName)
                <option value="{{ $keyValue }}" @selected($inputValue == $keyValue)>{{ $valueName }}</option>
            @endforeach
        </select>
    @error($name) <span class="text-danger fw-bold">{{  $message  }}</span> @enderror
</div>
