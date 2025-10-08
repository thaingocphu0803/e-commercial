<x-slot:heading>
    <link href="{{ asset('frontend/css/plugins/nice-select.css') }}" rel="stylesheet">
</x-slot:heading>

<x-slot:script>
    <script src="{{ asset('frontend/js/plugins/jquery.nice-select.js') }}"></script>
</x-slot:script>

<x-frontend.dashboard.layout>
    {{-- @dd($cart); --}}
    <div class="payment-infor page-wrapper">
        <div class="cart-container">
            <form action="" method="POST">
                @csrf
                <div class="row my-3">
                    <div class="col-lg-7 px-5">

                        <div class="d-flex flex-column gap-4">
                            <div class="row">
                                {{-- form information header --}}
                                <div class="form-header">
                                    <div class="d-flex justify-content-between">
                                        <span
                                            class="header-title text-uppercase fs-5 text-bold">{{ __('custom.orderInfor') }}</span>
                                        <div class="header-has-account">
                                            <span>{{ __('custom.hasAccount') }}</span>
                                            <a class="ms-1" href="#">{{ __('custom.logHere') }}</a>
                                        </div>
                                    </div>
                                </div>


                                {{-- form information body --}}
                                <div class="form-body mt-3 d-flex flex-column gap-3">
                                    <div class="row">
                                        {{-- form input fullname --}}
                                        <div class="col-lg-6">
                                            <input class="form-control" type="text" name="customer[fullname]"
                                                placeholder="{{ __('custom.enterFullName') }}">
                                        </div>

                                        {{-- form input phone --}}
                                        <div class="col-lg-6">
                                            <input class="form-control" type="text" name="customer[phone]"
                                                placeholder="{{ __('custom.enterPhone') }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        {{-- form input email --}}
                                        <div class="col-lg-12">
                                            <input class="form-control" type="email" name="customer[email]"
                                                placeholder="{{ __('custom.enterEmail') }}">
                                        </div>
                                    </div>

                                    <div class="row">
                                        {{-- form input city --}}
                                        <div class="col-lg-4">
                                            <select name="customer[city]" class="nice-select form-select">
                                                <option disabled selected>
                                                    {{ __('custom.chooseObject', ['attribute' => __('custom.city')]) }}
                                                </option>
                                            </select>
                                        </div>

                                        {{-- form input district --}}
                                        <div class="col-lg-4">
                                            <select name="customer[district]" class="nice-select form-select">
                                                <option disabled selected>
                                                    {{ __('custom.chooseObject', ['attribute' => __('custom.district')]) }}
                                                </option>
                                            </select>
                                        </div>

                                        {{-- form input ward --}}
                                        <div class="col-lg-4">
                                            <select name="customer[ward]" class="nice-select form-select">
                                                <option disabled selected>
                                                    {{ __('custom.chooseObject', ['attribute' => __('custom.ward')]) }}
                                                </option>

                                            </select>
                                        </div>
                                    </div>

                                    <div class="row">
                                        {{-- form input note --}}
                                        <div class="col-lg-12">
                                            <input class="form-control" type="text" name="customer[note]"
                                                placeholder="{{ __('custom.enterNote') }}">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                {{-- form payment header --}}
                                <div class="form-header">
                                    <div class="d-flex justify-content-between">
                                        <span
                                            class="header-title text-uppercase fs-5 text-bold">{{ __('custom.paymentMethod') }}</span>
                                    </div>
                                </div>

                                {{-- form payment body --}}
                                <div class="form-body mt-3">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            {{-- form payment method radio --}}
                                            @foreach (__('module.payment') as $payment)
                                                <label for="{{ $payment['id'] }}"
                                                    class="form-control d-flex align-items-center gap-4">
                                                    <input class="radio-input" type="radio"
                                                        name="customer[payment_method]" id="{{ $payment['id'] }}">
                                                    <img class="img-icon" src="{{ $payment['img'] }}"
                                                        alt="{{ __('custom.paymentMethod') }}">
                                                    <span>{{ __($payment['title']) }}</span>
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- payment button --}}
                            <div class="row mb-3">
                                <div class="col-lg-12 ">
                                    <button type="button"
                                        class="btn btn-primary w-100">{{ __('custom.payOrder') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-5 px-5">
                        <div class="row">
                            <div class="form-header">
                                <div class="d-flex justify-content-between">
                                    <span
                                        class="header-title text-uppercase fs-5 text-bold">{{ __('custom.cart') }}</span>
                                </div>
                            </div>
                            <div class="form-body">
                                <div class="row">
                                    <div class="product-cart-item col-lg-12">
                                        <div class=" py-3 d-flex align-items-center justify-content-between">
                                            <div class="d-flex  justify-content-strench gap-5">
                                                <div class="cart-item-image">
                                                    <img src="{{ config('app.general.noImage') }}"
                                                        alt="{{ __('custom.productImage') }}" class="img-cover">
                                                </div>
                                                <div
                                                    class="cart-item-infor d-flex flex-column justify-content-between align-items-center">
                                                    <span class="fs-6 text-bold text-secondary text-capitalize">samsung
                                                        galaxy</span>
                                                    <div class="cart-item-amount position-relative">
                                                        <button type="button" id="btn_decrease"
                                                            class="btn-hande-quantiy position-absolute text-bold fs-4">-</button>
                                                        <input type="text" name="product_quantity"
                                                            class="text-center text-sencondary" value="1">
                                                        <button type="button" id="btn_increase"
                                                            class="btn-hande-quantiy position-absolute text-bold fs-4">+</button>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="d-flex gap-5 align-item-center">
                                                <span class="cart-item-price fs-5">{{ price_format(1000) }}</span>
                                                <span class="text-danger cart-item-trash">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                        height="20" fill="currentColor" class="bi bi-trash"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                        <path
                                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                    </svg>
                                                </span>
                                            </div>

                                        </div>

                                        <div
                                            class=" py-3 d-flex align-items-center justify-content-between border-top">
                                            <div class="d-flex  justify-content-strench gap-5">
                                                <div class="cart-item-image">
                                                    <img src="{{ config('app.general.noImage') }}"
                                                        alt="{{ __('custom.productImage') }}" class="img-cover">
                                                </div>
                                                <div
                                                    class="cart-item-infor d-flex flex-column justify-content-between align-items-center">
                                                    <span class="fs-6 text-bold text-secondary text-capitalize">samsung
                                                        galaxy</span>
                                                    <div class="cart-item-amount position-relative">
                                                        <button type="button" id="btn_decrease"
                                                            class="btn-hande-quantiy position-absolute text-bold fs-4">-</button>
                                                        <input type="text" name="product_quantity"
                                                            class="text-center text-sencondary" value="1">
                                                        <button type="button" id="btn_increase"
                                                            class="btn-hande-quantiy position-absolute text-bold fs-4">+</button>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="d-flex gap-5 align-item-center">
                                                <span class="cart-item-price fs-5">{{ price_format(1000) }}</span>
                                                <span class="text-danger cart-item-trash">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="20"
                                                        height="20" fill="currentColor" class="bi bi-trash"
                                                        viewBox="0 0 16 16">
                                                        <path
                                                            d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z" />
                                                        <path
                                                            d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z" />
                                                    </svg>
                                                </span>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- choose voucher --}}
                        <div class="row my-3">
                            <div class="col-lg-12">
                                {{-- voucher list --}}
                                <div class="voucher-list d-flex gap-3 pb-20">
                                    {{-- voucher item --}}
                                    <div class="list-item d-flex justify-content-between ">
                                        <div class="p-2 d-flex flex-column justify-content-start">
                                            <div class="item-title text-bold text-secondary text-capitalize">
                                                samsung galaxy
                                            </div>
                                            <div class="item-desc border-top">
                                                 samsung galaxy  samsung galaxy  samsung galaxy  samsung  samsung galaxy  samsung galaxy  samsung galaxy  samsung
                                            </div>
                                        </div>
                                        <button type="button"  class="choose-voucher border-start text-capitalize"> {{__('custom.apply')}}</button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- apply voucher button --}}
                        <div class="row my-3">
                            <div class="col-lg-8">
                                <input type="text" class="form-control" name="order_voucher"
                                    placeholder="{{ __('custom.enterVoucher') }}">
                            </div>
                            <div class="col-lg-4">
                                <button type="button"
                                    class="btn btn-secondary text-capitalize w-100">{{ __('custom.applyVoucher') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</x-frontend.dashboard.layout>
