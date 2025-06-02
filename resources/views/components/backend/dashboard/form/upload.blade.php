@props([
    'rowLength' => null,
    'labelName' => null,
    'value' => null,
])

<div class="col-lg-{{ $rowLength ?? 6 }}">
    <div class="form-row">
        <label for="upload_widget" class="control-label text-right text-capitalize">
            {{ $labelName }}
        </label>
        <button class="btn form-control bg-silver text-capitalize" type="button" id="upload_widget">
            {{__('custom.choose') .' '.$labelName .' '. __('custom.toUpload')}}</button>
        <input type="text" class="hidden" name="image" id="image" value="{{ old('image', $value) }}">
        <p class="form-controll">
            <a href="{{ old('image', $value) ? base64_decode(old('image', $value)) : '' }}"
                id="img_url"
                target="_blank"
                class="text text-danger w-full ellipsis inline-block"
            >
                {{ old('image', $value) ? base64_decode(old('image', $value)) : '' }}
            </a>
        </p>
    </div>
</div>
