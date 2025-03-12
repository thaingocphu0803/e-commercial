@props([
    'inputName',
    'type',
    'labelName',
    'value' => null,
    'rowLength' => null,
    'must' => false,
    'readOnly' => false,
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
            @readonly($readOnly)
            class="form-control tiny-editor"
            {{$attributes}}
        >
            {{old($inputName, $value)}}
        </textarea>
        @else
        <input
            type="{{$type}}"
            name="{{$inputName}}"
            id="{{$inputName}}"
            value="{{old($inputName, $value)}}"
            @readonly($readOnly)
            class="form-control"
            {{$attributes}}
        >
        @endif
    </div>
</div>
