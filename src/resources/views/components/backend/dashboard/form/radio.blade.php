@props([
    'labelName',
    'name',
    'value' => null,
    'must' => false,
    'rowLength' => null,
    'old', null,
    'id' => null,
    'isChecked' => false
])

<div class="col-lg-{{ $rowLength ?? 6 }}">
    <div class="form-row flex flex-middle gap-10">
        <input
            type="radio"
            name="{{ $name }}"
            id="{{ $id }}"
            value="{{ $value }}"
            {{$attributes->merge(['class'])}}
            {{(($old == $value) || (is_null($old) && $isChecked )) ? 'checked' : ''}}
        >
        <label for="{{ $id }}" class="control-label text-500 text-right m-0 text-sm">{{ $labelName }}
            @if ($must)
            <span class="text-danger">*</span>
            @endif
        </label>
    </div>
</div>
