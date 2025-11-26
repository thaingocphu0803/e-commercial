@if ($momo['m2signature'] == $momo['partnerSignature'])
<div class="body-payment-status d-flex justify-content-between">
    <span class="payment-status-title text-secondary fs-6 text-bold text-capitalize">
        {{ __('custom.paymentStatus') }}:
    </span>
    @if ($momo['resultCode'] == '0')
    <span class="payment-status-value text-success fs-6">{{ __('custom.paymentSuccess') }}</span>
    @else
    <span class="payment-status-value text-danger fs-6">{{ __('custom.paymentFailed') }}</span>
    @endif
</div>

@else
<div class="body-payment-status d-flex justify-content-between">
    <span class="payment-status-title text-secondary fs-6 text-bold text-capitalize">
        {{ __('custom.paymentStatus') }}:
    </span>
    <span class="payment-status-value text-danger fs-6">{{ __('custom.momoAlert') }}</span>
</div>
@endif