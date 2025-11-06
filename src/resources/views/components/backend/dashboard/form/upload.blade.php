@props([
    'inputName' => 'image',
    'rowLength' => null,
    'labelName' => null,
    'value' => null,
])

<div class="col-lg-{{ $rowLength ?? 6 }}">
    <div class="form-row">
        <label for="upload_widget" class="control-label text-right text-capitalize">
            {{ $labelName }}
        </label>
        <button class="btn form-control bg-silver text-capitalize upload_widget_btn" type="button" id="upload_widget">
            {{__('custom.choose') .' '.$labelName .' '. __('custom.toUpload')}}</button>
        <input type="text" class="hidden img_input" name="{{$inputName}}" id="{{$inputName}}" value="{{ old($inputName, $value) }}">
        <p class="form-controll">
            <a href="{{ old($inputName, $value) ? base64_decode(old($inputName, $value)) : '' }}"
                target="_blank"
                class="text text-danger w-full ellipsis inline-block img_url"
            >
                {{ old($inputName, $value) ? base64_decode(old($inputName, $value)) : '' }}
            </a>
        </p>
    </div>
</div>
