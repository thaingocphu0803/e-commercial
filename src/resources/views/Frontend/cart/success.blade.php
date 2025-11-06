@php
    $paymentMethod = collect(__('module.payment'));
    $method = $paymentMethod->firstWhere('id', $order['customer_method']);
@endphp

<x-frontend.dashboard.layout>
    <div class="success-container">
        {{-- order infor --}}
        <div class="my-4 row justify-content-center">
            <div class="col-lg-6 d-flex flex-column gap-3">
                {{-- order btn --}}
                <div class="order-btn">
                    <div class="d-flex justify-content-center">
                        <a href="{{ route('home.index') }}"
                            class="fs-5 fst-italic text-bold">{{ __('custom.continueShop') }}</a>
                    </div>
                </div>

                {{-- order header --}}
                <div class="order-header">
                    <div class="d-flex justify-content-center">
                        <span class="header-title text-uppercase fs-5 text-bold">{{ __('custom.orderInfor') }}</span>
                    </div>
                </div>
                {{-- order body --}}
                <div class="order-body d-flex flex-column gap-3">
                    {{-- body title --}}
                    <div class="body-title">
                        <div class="d-flex justify-content-center">
                            <span class="title-code text-uppercase fs-6 text-bold">
                                {{ __('custom.PurchaseOrder') ." #". $order['code'] }}
                            </span>
                        </div>
                        <span
                            class="fs-6 text-secondary fst-italic text-capitalize text-bold">{{ __('custom.date') .' '. $order['created_at'] }}</span>
                    </div>

                    {{-- body  table --}}
                    <table class="table table-hover text-center">
                        <thead>
                            <tr class="table-success">
                                <th class="text-capitalize">{{ __('custom.name') }}</th>
                                <th class="text-capitalize">{{ __('custom.qty') }}</th>
                                <th class="text-capitalize">{{ __('custom.purchasePrice') }}</th>
                                <th class="text-capitalize">{{ __('custom.originalPrice') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($order['products'] as $product)
                                <tr class="table-secondary">
                                    <td>{{$product['name']}}</td>
                                    <td>{{intval($product['qty'])}}</td>
                                    <td>{{price_format($product['price'])}}</td>
                                    <td>{{price_format($product['price_original'])}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    {{-- body discount --}}
                    <div class="body-discount d-flex justify-content-between">
                        <span class="discount-title text-secondary fs-6 text-bold text-capitalize">
                            {{ __('custom.discountCode') }}:
                        </span>
                        <span class="discount-code text-secondary">{{$order['cart_discount_code']}}</span>
                    </div>

                    {{-- body total price --}}
                    <div class="body-total-price d-flex justify-content-between">
                        <span class="total-price-title text-secondary fs-6 text-bold text-capitalize">
                            {{ __('custom.totalPrice') }}:
                        </span>
                        <span class="total-price-value text-secondary">{{price_format($order['total_price_original'])}}</span>
                    </div>

                    {{-- body total-discount --}}
                    <div class="body-total-discount d-flex justify-content-between">
                        <span class="total-discount-title text-secondary fs-6 text-bold text-capitalize">
                            {{ __('custom.totalDiscount') }}:
                        </span>
                        <span class="total-discount-value text-secondary">{{price_format($order['total_discount'])}}</span>
                    </div>

                    {{-- body shipping fee --}}
                    <div class="body-shipping-fee d-flex justify-content-between">
                        <span class="shipping-fee-title text-secondary fs-6 text-bold text-capitalize">
                            {{ __('custom.shipfee') }}:
                        </span>
                        <span class="shipping-fee-value text-secondary">{{price_format($order['shipping_fee'])}}</span>
                    </div>

                    {{-- body total grand --}}
                    <div class="body-total-grand d-flex justify-content-between">
                        <span class="total-grand-title text-dark fs-5 text-bold text-capitalize">
                            {{ __('custom.grandTotal') }}:
                        </span>
                        <span class="total-grand-value text-dark fs-5 text-bold">{{price_format($order['total_grand'])}}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- customer infor --}}
        <div class="my-4 row justify-content-center">
            <div class="col-lg-6 d-flex flex-column gap-3">
                {{-- customer header --}}
                <div class="customer-header">
                    <div class="d-flex justify-content-center">
                        <span
                            class="header-title text-uppercase fs-5 text-bold">{{ __('custom.customerInfor') }}</span>
                    </div>
                </div>
                {{-- customer body --}}
                <div class="customer-body d-flex flex-column gap-3">
                    {{-- body name --}}
                    <div class="body-name d-flex justify-content-between">
                        <span class="name-title text-secondary fs-6 text-bold text-capitalize">
                            {{ __('custom.customerName') }}:
                        </span>
                        <span class="name-value text-secondary">{{$order['customer_name']}}</span>
                    </div>

                    {{-- body email --}}
                    <div class="body-email d-flex justify-content-between">
                        <span class="email-title text-secondary fs-6 text-bold text-capitalize">
                            {{ __('custom.email') }}:
                        </span>
                        <span class="email-value text-secondary">{{$order['customer_email']}}</span>
                    </div>

                    {{-- body address --}}
                    <div class="body-address d-flex justify-content-between">
                        <span class="address-title text-secondary fs-6 text-bold text-capitalize">
                            {{ __('custom.address') }}:
                        </span>
                        <span class="address-value text-secondary">{{$order['customer_address']}}</span>
                    </div>

                    {{-- body phone --}}
                    <div class="body-phone d-flex justify-content-between">
                        <span class="phone-title text-secondary fs-6 text-bold text-capitalize">
                            {{ __('custom.phone') }}:
                        </span>
                        <span class="phone-value text-secondary">{{$order['customer_phone']}}</span>
                    </div>


                    {{-- body payment-method --}}
                    <div class="body-payment-method d-flex justify-content-between">
                        <span class="payment-method-title text-secondary fs-6 text-bold text-capitalize">
                            {{ __('custom.paymentMethod') }}:
                        </span>
                        <span class="payment-method-value text-secondary fs-6">{{__($method['title'])}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend.dashboard.layout>
