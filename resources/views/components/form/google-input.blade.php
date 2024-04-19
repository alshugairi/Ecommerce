<div class="mb-5 {{ $col?? "col-12" }}">
    @if(isset($label) && $label === 'true')
        <label for="{{$key}}" class="fw-semibold fs-6 mb-2">{{ $labelName }}</label>
    @endif
    <input type="{{$type}}"
           @if(!count($polygons)) disabled @endif
           id="{{$key}}" wire:model="{{ $name }}"
           @if(!count($polygons)) placeholder="Please Select City First"
           @else placeholder="@lang('share.Enter') {{ $labelName }}" @endif
           autocomplete="{{ $autocomplete ?? 'off' }}"
           @isset($disabled) disabled @endisset
           class="form-control form-control-solid mb-3 mb-lg-0 @error($name) is-invalid @enderror @if(!count($polygons)) disabled @else enabled @endif "
           @isset($multiple) multiple @endisset
           @isset($value) value="{{ $value }}" @endisset
    >
    @if(count($polygons))
        <input type="hidden" id="{{ $key }}-google-NorthEast"
               value='{!! json_encode($polygons['north_east'], JSON_THROW_ON_ERROR) !!}'>
        <input type="hidden" id="{{ $key }}-google-SouthWest"
               value='{!! json_encode($polygons['south_west'], JSON_THROW_ON_ERROR)  !!}'>
    @else
        <input type="hidden" id="{{ $key }}-google-NorthEast" value=''>
        <input type="hidden" id="{{ $key }}-google-SouthWest" value=''>
    @endif
    @error($name) <span class="text-danger" style="font-weight: bold">{{ $message }}</span> @enderror
</div>

@push('js')
    <script>
        if (!document.querySelector('script[src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBaXiL03VF9-lfV-KQn6MvGPgNlfAeHsk4&libraries=places&callback=initAutoComplete"]')) {
            function initAutoComplete() {
            }

            window.initAutoComplete = initAutoComplete;
            const script = document.createElement('script');

            script.src = 'https://maps.googleapis.com/maps/api/js?key=AIzaSyBaXiL03VF9-lfV-KQn6MvGPgNlfAeHsk4&libraries=places&callback=initAutoComplete';

            document.body.appendChild(script);
        }

        $(document).ready(function () {
            let NorthEastInput = $("#{{ $key}}-google-NorthEast").val()
            let SouthWestInput = $("#{{ $key}}-google-SouthWest").val()
            $("#{{ $key }}").click(function () {
                let input = document.getElementById('{{ $key }}');
                let NorthEastInputInside = $("#{{ $key}}-google-NorthEast").val()
                let SouthWestInputInside = $("#{{ $key}}-google-SouthWest").val()
                let NorthEastJSON = JSON.parse(NorthEastInputInside);
                let SouthWestJSON = JSON.parse(SouthWestInputInside);
                NorthEastInput = NorthEastInputInside
                SouthWestInput = SouthWestInputInside
                const defaultBounds = new google.maps.LatLngBounds(
                    new window.google.maps.LatLng(SouthWestJSON?.latitude, SouthWestJSON?.longitude),
                    new window.google.maps.LatLng(NorthEastJSON?.latitude, NorthEastJSON?.longitude),
                );
                const option = {
                    bounds: defaultBounds,
                    strictBounds: true,
                    componentRestrictions: {country: "eg"},
                }
                let autoCompleteRef = new window.google.maps.places.Autocomplete(input, option);
                autoCompleteRef.addListener('place_changed', function () {
                    const place = autoCompleteRef.getPlace()
                    if (input.value !== undefined && input.value !== null) {
                    @this.set('{{ $name }}', input.value);
                    }

                    if (!place.geometry) {
                        window.alert("No details available for input: '" + place.name + "'")
                        return
                    }
                    if (autoCompleteRef) {
                        autoCompleteRef.unbindAll();
                        window.google.maps.event.clearInstanceListeners(autoCompleteRef);
                    }
                    if (input) {
                        window.google.maps.event.clearInstanceListeners(input);
                    }

                    axios.get('https://maps.googleapis.com/maps/api/geocode/json?key=AIzaSyDZWieJJM0Sb-JNB_VcAklzs_QgY78AVaM', {
                        params: {
                            sensor: false,
                            place_id: place.place_id
                        }
                    }).then(response => {
                        const picker_lat = response.data.results[0].geometry.location.lat
                        const picker_lng = response.data.results[0].geometry.location.lng
                    @this.set('{{ $locationDetails }}', {
                        'latitude': picker_lat,
                        'longitude': picker_lng
                    });
                        @if(count($onUpdateComponenet ?? []))
                            @foreach($onUpdateComponenet as $function)
                                livewire.emit(`{{ $function }}`, [])
                            @endforeach
                        @endif
                    }).catch((error) => {
                        return false
                    })
                })

            });

        })
    </script>
    {{--    <script--}}
    {{--        src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBaXiL03VF9-lfV-KQn6MvGPgNlfAeHsk4&libraries=places&callback=initAutoComplete"></script>--}}
@endpush

