@props([
    'labelName',
    'data' => [],
    'name',
    'value' => null,
    'must' => false,
])

@php
    $itemCodeDefault = !empty($value) ? $value : old($name)
@endphp

<div class="col-lg-6">
    <div class="form-row">
        <label for="{{$name}}" class="control-label text-right">{{$labelName}}
            @if ($must)
                <span class="text-danger">*</span>
            @endif
        </label>
        <select name="{{$name}}" id="{{$name}}" class="form-control select2">
            <option selected disabled>Choose {{$labelName}}</option>
            @if(!empty($data))
                @foreach ($data as $item)
                <option value="{{$item->code}}" @selected($itemCodeDefault == $item->code) >{{$item->name}}</option>
                @endforeach
            @endif
        </select>
    </div>
</div>
