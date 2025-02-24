@props([
        'labelName',
        'inputName',
        'tag' => null,
        'value' => null,
        'must' => false
    ])

<div class="row">
    <div class="col-lg-12">
        <div class="form-row">
            <label for="{{ $inputName }}" class="control-label tex-left w-full text-capitalize">
                <div class="flex flex-space-between">
                    <span>
                        SEO {{ $labelName }}
                        @if ($must)
                            <span class="text-danger">*</span>
                        @endif
                    </span>
                    @if($labelName != 'keyword')
                        <span class="count_meta-{{$inputName}}}}">0 character(s)</span>
                    @endif
                </div>
            </label>

            @if ($tag === 'textarea')
                <textarea
                    class="form-control tiny-editor"
                    type="text"
                    name="{{ $inputName }}"
                    id="{{ $inputName }}"
                >
                    {{ old($inputName, $value) }}
                </textarea>
            @else
                <input
                    class="form-control"
                    type="text"
                    value="{{ old($inputName, $value) }}"
                    name="{{ $inputName }}"
                    id="{{ $inputName }}">
            @endif

        </div>
    </div>
</div>
