@props([
    'provinces' => [],
])

<div class="row">
    {{-- form input city --}}
    <div class="col-lg-4">
        <select id="province_id" name="province" class="nice-select form-select">
            <option disabled selected value="0">
                {{ __('custom.chooseObject', ['attribute' => __('custom.city')]) }}
            </option>
            @foreach ($provinces as $province)
                <option value="{{ $province->code }}" {{ ($province->code == old('province')) ? 'selected' : '' }}>{{ $province->name }}</option>
            @endforeach
        </select>
    </div>

    {{-- form input district --}}
    <div class="col-lg-4">
        <select id="district_id" name="district" class="nice-select form-select">
            <option disabled selected value="0">
                {{ __('custom.chooseObject', ['attribute' => __('custom.district')]) }}
            </option>
        </select>
    </div>

    {{-- form input ward --}}
    <div class="col-lg-4">
        <select id="ward_id" name="ward" class="nice-select form-select">
            <option disabled selected value="0">
                {{ __('custom.chooseObject', ['attribute' => __('custom.ward')]) }}
            </option>

        </select>
    </div>
</div>

<div class="row">
    {{-- form input address --}}
    <div class="col-lg-12">
        <input class="form-control" type="text" name="address" placeholder="123 Pham Ngu Lao" value="{{ old('address') }}">
    </div>
</div>
