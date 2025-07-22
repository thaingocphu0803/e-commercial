@props([
    'inputName',
    'type',
    'labelName',
    'value' => null,
    'rowLength' => null,
    'must' => false,
    'readOnly' => false,
    'tag' => null,
    'rows' => 5,
    'inputArrName' => null,
    'disabled' => false
])

@php
    $old = $inputArrName ?? $inputName;
@endphp

<div class="col-lg-{{ $rowLength ?? 6 }}">
    <div class="form-row">
        <label for="{{$inputName}}" class="control-label text-right text-capitalize">{{{$labelName}}}
            @if ($must)
            <span class="text-danger">*</span>
            @endif

        </label>
        @if ($tag === 'textarea')
        <textarea
            rows="{{$rows}}"
            type="{{$type}}"
            name="{{$inputName}}"
            id="{{$inputName}}"
            @readonly($readOnly)
            {{$attributes->merge(['class' => 'form-control summernote'])}}
        >
            {{old($old, $value)}}
        </textarea>
        @else
        <input
            type="{{$type}}"
            name="{{$inputName}}"
            id="{{$inputName}}"
            value="{{old($old, $value)}}"
            @readonly($readOnly)
            @disabled($disabled)
            {{$attributes->merge(['class' => 'form-control'])}}
        >
        @endif
        {{$slot}}
    </div>
</div>
