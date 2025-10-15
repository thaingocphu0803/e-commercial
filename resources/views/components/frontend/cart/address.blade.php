@props([
    'provinces' => [],
])

<div class="row">
    {{-- form input city --}}
    <div class="col-lg-4">
        <select id="province_id" name="customer[province]"
            class="nice-select form-select">
            <option disabled selected>
                {{ __('custom.chooseObject', ['attribute' => __('custom.city')]) }}
            </option>
            @foreach ($provinces as $province)
                <option value="{{ $province->code }}">{{ $province->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- form input district --}}
    <div class="col-lg-4">
        <select id="district_id" name="customer[district]"
            class="nice-select form-select">
            <option disabled selected>
                {{ __('custom.chooseObject', ['attribute' => __('custom.district')]) }}
            </option>
        </select>
    </div>

    {{-- form input ward --}}
    <div class="col-lg-4">
        <select id="ward_id" name="customer[ward]" class="nice-select form-select">
            <option disabled selected>
                {{ __('custom.chooseObject', ['attribute' => __('custom.ward')]) }}
            </option>

        </select>
    </div>
</div>
