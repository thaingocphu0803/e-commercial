{{-- choose voucher --}}
<div class="row my-3">
    <div class="col-lg-12">
        {{-- voucher list --}}
        <div class="voucher-list d-flex gap-3 pb-20">
            {{-- voucher item --}}
            <div class="list-item d-flex justify-content-between ">
                <div class="p-2 d-flex flex-column justify-content-start">
                    <div class="item-title text-bold text-secondary text-capitalize">
                        Free ship 10km
                    </div>
                    <div class="item-desc border-top">
                        Free ship from 0₫ around 10km.
                    </div>
                </div>
                <button type="button" class="choose-voucher border-start text-capitalize">
                    {{ __('custom.apply') }}</button>
            </div>
        </div>
    </div>
</div>

{{-- apply voucher button --}}
<div class="row my-3">
    <div class="col-lg-8">
        <input type="text" class="form-control" name="order_voucher" placeholder="{{ __('custom.enterVoucher') }}">
    </div>
    <div class="col-lg-4">
        <button type="button" class="btn btn-secondary text-capitalize w-100">{{ __('custom.applyVoucher') }}
        </button>
    </div>
</div>
