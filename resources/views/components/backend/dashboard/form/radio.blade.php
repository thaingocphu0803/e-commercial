@props([
    'labelName',
    'name',
    'value' => null,
    'must' => false,
    'rowLength' => null,
    'old', null
])

<div class="col-lg-{{ $rowLength ?? 6 }}">
    <div class="form-row flex flex-middle gap-10">
        <input type="radio" name="{{ $name }}" id="{{ $name }}" value="{{ $value }}" {{$attributes}} {{$old == $value ? 'checked' : ''}}>
        <label for="{{ $name }}" class="control-label text-500 text-right m-0 text-sm">{{ $labelName }}
            @if ($must)
            <span class="text-danger">*</span>
            @endif
        </label>
    </div>
</div>
