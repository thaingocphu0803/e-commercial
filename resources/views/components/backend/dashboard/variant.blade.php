<div class="ibox variant-box">
    <div class="ibox-title">
        <h5>{{ __('form.variant') }}</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="variant-checkbox flex gap-10 flex-middle">
                    <input class="variantCheckbox-input" type="checkbox" value="" name="accept"
                        id="variantCheckbox">
                    <label class="variantCheckbox-label"
                        for="variantCheckbox">{{ __('form.objectMoreVarian', ['attribute' => __('dashboard.product')]) }}</label>
                </div>
            </div>
        </div>
        <div id="variant-wrapper" class="hidden">
            <div class="row mt-20">
                <div class="col-lg-3">
                    <div class="attribute-title">{{ __('form.chooseAttr') }}</div>
                </div>
                <div class="col-lg-9">
                    <div class="attribute-title">{{ __('form.chooseAttrVal') }}</div>
                </div>
            </div>
            <div id="variant-body">
                {{-- variant items here --}}
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

<div class="ibox product-variant">
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
</script>
