@props([
    'labelName' => null,
    'data' => [],
    'name',
    'value' => null,
    'must' => false,
    'rowLength' => null,
])

@php
    $itemCodeDefault = !empty($value) ? $value : old($name);
@endphp

<div class="col-lg-{{ $rowLength ?? 6 }}">
    <div class="form-row">
        <label for="{{ $name }}" class="control-label text-right text-capitalize">{{ $labelName }}
            @if ($must)
                <span class="text-danger">*</span>
            @endif
        </label>
        <select name="{{ $name }}[]" id="{{ $name }}" class="form-control select2" multiple>

            @if (empty(old($name)))
                <option selected disabled>Choose {{ $labelName }}</option>
            @endif

            @if (!empty($data))
                @foreach ($data as $item)

                    @php
                        $itemId = $item->code ?? $item->id;
                    @endphp
                    <option value="{{ $itemId }}" @selected(in_array($itemId, old($name, [])))>{{ $item->name }}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>
