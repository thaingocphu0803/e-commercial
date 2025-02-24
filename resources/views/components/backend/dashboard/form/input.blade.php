@props([
    'inputName',
    'type',
    'labelName',
    'value' => null,
    'rowLength' => null,
    'must' => false,
    'disabled' => false,
    'tag' => null
])
<div class="col-lg-{{ $rowLength ?? 6 }}">
    <div class="form-row">
        <label for="{{$inputName}}" class="control-label text-right text-capitalize">{{{$labelName}}}
            @if ($must)
            <span class="text-danger">*</span>
            @endif

        </label>
        @if ($tag === 'textarea')
        <textarea
            type="{{$type}}"
            name="{{$inputName}}"
            id="{{$inputName}}"
            @disabled($disabled)
            class="form-control tiny-editor"
        >
            {{old($inputName, $value)}}
        </textarea>
        @else
        <input
            type="{{$type}}"
            name="{{$inputName}}"
            id="{{$inputName}}"
            value="{{old($inputName, $value)}}"
            @disabled($disabled) class="form-control"
        >
        @endif
    </div>
</div>
