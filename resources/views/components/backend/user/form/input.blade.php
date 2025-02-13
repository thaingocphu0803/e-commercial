@props([
    'inputName',
    'type',
    'labelName',
    'value' => null,
    'rowLength' => null,
    'must' => false
])
<div class="col-lg-{{ $rowLength ?? 6 }}">
    <div class="form-row">
        <label for="{{$inputName}}" class="control-label text-right text-capitalize">{{{$labelName}}}
            @if ($must)
            <span class="text-danger">*</span>
            @endif
        </label>
        <input type="{{$type}}" name="{{$inputName}}" id="{{$inputName}}" value="{{old($inputName, $value)}}" class="form-control">
    </div>
</div>
