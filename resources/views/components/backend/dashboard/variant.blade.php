<div class="ibox variant-box">
    <div class="ibox-title">
        <h5>{{ __('form.variant') }}</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="variant-checkbox flex gap-10 flex-middle">
                    <input class="variantCheckbox-input" type="checkbox" value="1" name="accept" id="variantCheckbox"
                        {{ old('accept') == 1 ? 'checked' : '' }}>
                    <label class="variantCheckbox-label" for="variantCheckbox">
                        {{ __('form.objectMoreVarian', ['attribute' => __('dashboard.product')]) }}
                    </label>
                </div>
            </div>
        </div>
        <div id="variant-wrapper" class="{{ old('accept') == 1 ? '' : 'hidden' }}">
            <div class="row mt-20">
                <div class="col-lg-3">
                    <div class="attribute-title">{{ __('form.chooseAttr') }}</div>
                </div>
                <div class="col-lg-9">
                    <div class="attribute-title">{{ __('form.chooseAttrVal') }}</div>
                </div>
            </div>
            <pre>
    </pre>
            <div id="variant-body">
                @if (old('attr-catalouge'))
                    @foreach (old('attr-catalouge') as $attrId)
                        <div class="row mt-20 variant-item flex flex-middle">
                            <div class="col-lg-3">
                                <div class="attribute-catalouge">
                                    <select data-prev="0" name="attr-catalouge[]"
                                        class="choose-attribute select2-play">
                                        <option value="" disabled selected>{{ __('form.chooseAttribute') }}
                                        </option>
                                        @foreach ($listAttr as $attr)
                                            <option {{ $attrId == $attr->id ? 'selected' : '' }}
                                                value="{{ $attr->id }}">{{ $attr->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-8 ajax-select">
                                <select
                                    name="attributes[{{$attrId}}][]"
                                    class="variant-select  variant-select-{{$attrId}}"
                                    data-catid="{{$attrId}}"
                                    multiple
                                >
                                </select>
                            </div>
                            <div class="col-lg-1">
                                <button type="button" class="remove-attribute btn btn-danger b-radius-4">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
            <div class="mt-20">
                <button id="add-variant-btn" type="button" class="btn btn-white add-variant-btn">
                    <i class="fa fa-plus"></i>
                    <span>{{ __('form.addVariant') }}</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="ibox product-variant {{ old('accept') == 1 ? '' : 'hidden' }}" id="variant-setting">
    <div class="ibox-title">
        <h5>{{ __('form.versions') }}</h5>
    </div>
    <div class="ibox-content">
        <div class="table-responsive">
            <table class="table table-striped variant-table">
                {{-- variant table content here! --}}
            </table>
        </div>
    </div>
</div>

<script>
    const lang = "{{ app()->getLocale() }}";
    const listAttr = @json($listAttr);
    const attributes = @json(old('attributes'));
</script>
