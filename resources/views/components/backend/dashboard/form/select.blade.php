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
        <select name="{{ $name }}" id="{{ $name }}" class="form-control select2" {{$attributes}}>
            <option selected disabled> {{__('dashboard.choose') .' '. $labelName }}</option>
            @if (!empty($data))
                @foreach ($data as $item)
                    @php
                        $itemId = $item->code ?? $item->id;
                    @endphp
                    <option value="{{ $itemId }}" @selected($itemCodeDefault == $itemId)>{{ $item->name }}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>
