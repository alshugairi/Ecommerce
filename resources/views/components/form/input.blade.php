<div class="mb-3 {{ $col ?? "col-12" }}">
    @if(isset($label) && $label ==='true')
        <label for="{{ $key }}" class="form-label">{{ $labelName }}</label>
    @endif
    <input type="{{$type}}"
           @if(isset($name)) name="{{ $name }}" @endif
           @isset($readonly) readonly @endisset
           @isset($disabled) disabled @endisset
           @isset($required) required @endisset
           id="{{ $key ?? '' }}"
           @if($type=='number')
               min="0"
           @endif
           @isset($step)
               step="{{ $step }}"
           @endif
           placeholder="@lang('share.enter') {{ $labelName }}"
{{--           @isset($autocomplete) autocomplete="{{ $autocomplete }}" @endisset--}}
           class="form-control @error($name) is-invalid @enderror"
           @isset($multiple) multiple @endisset
           value="{{ $value ?? $default ?? old($name) }}"
    >
    @error($name) <span class="text-danger fw-bold">{{ $message }}</span> @enderror
</div>
