<div>
    <label class="form-check form-check-sm form-check-custom {{ $color?? 'form-check-solid' }} me-5 me-lg-20">
        <input type="checkbox" @isset($checked) checked @endisset class="form-check-input"
               @if(isset($defer)) wire:model.defer="{{$name}}"
               @elseif(isset($lazy)) wire:model.lazy="{{$name}}"
               @else wire:model="{{$name}}" @endif
               value="{{$value}}" id="{{$key}}">
        <span class="form-check-label">{{ $labelName }}</span>
    </label>

</div>
