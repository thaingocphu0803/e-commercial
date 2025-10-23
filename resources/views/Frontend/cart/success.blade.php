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
                                {{ __('custom.PurchaseOrder') . ' #111111' }}
                            </span>
                        </div>
                        <span
                            class="fs-6 text-secondary fst-italic text-capitalize text-bold">{{ __('custom.date') . ': 2025/11/11' }}</span>
                    </div>

                    {{-- body  table --}}
                    <table class="table table-hover text-center">
                        <thead>
                            <tr class="table-success">
                                <th class="text-capitalize">name</th>
                                <th class="text-capitalize">amount</th>
                                <th class="text-capitalize">price</th>
                                <th class="text-capitalize">purchase price</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="table-secondary">
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                            </tr>
                            <tr class="table-secondary">
                                <td>1</td>
                                <td>2</td>
                                <td>3</td>
                                <td>4</td>
                            </tr>
                        </tbody>
                    </table>

                    {{-- body discount --}}
                    <div class="body-discount d-flex justify-content-between">
                        <span class="discount-title text-secondary fs-6 text-bold text-capitalize">
                            {{__('custom.discountCode')}}:
                        </span>
                        <span class="discount-code text-secondary">#SSSSSSSSSXXSS</span>
                    </div>

                    {{-- body total price --}}
                    <div class="body-total-price d-flex justify-content-between">
                        <span class="total-price-title text-secondary fs-6 text-bold text-capitalize">
                            {{__('custom.totalPrice')}}:
                        </span>
                        <span class="total-price-value text-secondary">#SSSSSSSSSXXSS</span>
                    </div>

                    {{-- body total-discount --}}
                    <div class="body-total-discount d-flex justify-content-between">
                        <span class="total-discount-title text-secondary fs-6 text-bold text-capitalize">
                            {{__('custom.totalDiscount')}}:
                        </span>
                        <span class="total-discount-value text-secondary">#SSSSSSSSSXXSS</span>
                    </div>

                    {{-- body shipping fee --}}
                    <div class="body-shipping-fee d-flex justify-content-between">
                        <span class="shipping-fee-title text-secondary fs-6 text-bold text-capitalize">
                            {{__('custom.shipfee')}}:
                        </span>
                        <span class="shipping-fee-value text-secondary">#SSSSSSSSSXXSS</span>
                    </div>


                    {{-- body total grand --}}
                    <div class="body-total-grand d-flex justify-content-between">
                        <span class="total-grand-title text-dark fs-5 text-bold text-capitalize">
                            {{__('custom.grandTotal')}}:
                        </span>
                        <span class="total-grand-value text-dark fs-5 text-bold">#SSSSSSSSSXXSS</span>
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
                        <span class="header-title text-uppercase fs-5 text-bold">{{ __('custom.customerInfor') }}</span>
                    </div>
                </div>
                {{-- customer body --}}
                <div class="customer-body d-flex flex-column gap-3">
                    {{-- body name --}}
                    <div class="body-name d-flex justify-content-between">
                        <span class="name-title text-secondary fs-6 text-bold text-capitalize">
                            {{__('custom.customerName')}}:
                        </span>
                        <span class="name-value text-secondary">#SSSSSSSSSXXSS</span>
                    </div>

                    {{-- body email --}}
                    <div class="body-email d-flex justify-content-between">
                        <span class="email-title text-secondary fs-6 text-bold text-capitalize">
                            {{__('custom.email')}}:
                        </span>
                        <span class="email-value text-secondary">#SSSSSSSSSXXSS</span>
                    </div>

                    {{-- body address --}}
                    <div class="body-address d-flex justify-content-between">
                        <span class="address-title text-secondary fs-6 text-bold text-capitalize">
                            {{__('custom.address')}}:
                        </span>
                        <span class="address-value text-secondary">#SSSSSSSSSXXSS</span>
                    </div>

                    {{-- body phone --}}
                    <div class="body-phone d-flex justify-content-between">
                        <span class="phone-title text-secondary fs-6 text-bold text-capitalize">
                            {{__('custom.phone')}}:
                        </span>
                        <span class="phone-value text-secondary">#SSSSSSSSSXXSS</span>
                    </div>


                    {{-- body payment-method --}}
                    <div class="body-payment-method d-flex justify-content-between">
                        <span class="payment-method-title text-secondary fs-6 text-bold text-capitalize">
                            {{__('custom.paymentMethod')}}:
                        </span>
                        <span class="payment-method-value text-secondary fs-6">#SSSSSSSSSXXSS</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-frontend.dashboard.layout>
