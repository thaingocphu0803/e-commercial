@props([
    'labelName' => null,
    'data' => [],
    'name',
    'value' => [],
    'must' => false,
    'rowLength' => null,
    'parent' => null,
    'hidden' => false
])

<div {{ $attributes->merge(['class' => 'col-lg-' . ($rowLength ?? 6)]) }} {{$hidden ? 'hidden': ''}}>
    <div class="form-row">
        <label for="{{ $name }}" class="control-label text-right text-capitalize">{{ $labelName }}
            @if ($must)
                <span class="text-danger">*</span>
            @endif
        </label>
        <select name="{{ $name }}[]" id="{{ $name }}" class="form-control select2" multiple>
            @php
            @endphp
            @if (!empty($data))
                @foreach ($data as $item)
                    @php
                        $item = (object) $item;
                        $itemId = $item->code ?? $item->id;
                        $isSelected = in_array($itemId, old($name, $value)) && $itemId != $parent;
                    @endphp

                        <option
                            value="{{ $itemId }}"
                            @selected($isSelected)
                        >
                            {{ $item->name }}
                        </option>
                @endforeach
            @endif
        </select>
    </div>
</div>
