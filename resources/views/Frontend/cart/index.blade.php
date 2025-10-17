<x-frontend.dashboard.layout>
    <x-slot:script>
        <script src="{{ asset('frontend/js/location.js') }}" defer></script>
    </x-slot:script>

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

                                    <x-frontend.cart.address :provinces="$provinces" />

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
                                                    <input class="radio-input" type="radio" name="customer[payment_method]"
                                                        id="{{ $payment['id'] }}">
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
                                @if($cart->isEmpty())
                                    <div class="row">
                                        <div class="col-lg-12 d-flex  justify-content-center">
                                            <span class="text-secondary fs-5">{{ __('custom.cartEmpty') }}</span>
                                        </div>
                                    </div>
                                @endif
                                <div class="row">
                                    <x-frontend.cart.item :cart="$cart" />
                                </div>
                            </div>
                        </div>

                        {{-- total price --}}
                        @if(!$cart->isEmpty())
                            <div class="cart-total pt-3 row gap-3">
                                <div class=" total-shipcost col-lg-12 d-flex justify-content-between">
                                    <span class="header-title text-uppercase fs-6 text-bold">
                                        {{ __('custom.shipfee') }}:
                                    </span>
                                    <span class="value fs-5 text-secondary">{{ __('custom.freeship') }}</span>
                                </div>
                                <div class="total-discount col-lg-12 d-flex justify-content-between">
                                    <span class="header-title text-uppercase fs-6 text-bold">
                                        {{ __('custom.totalDiscount') }}:
                                    </span>
                                    <span
                                        class="value fs-5 text-secondary">{{caculate_cart_total($cart, 'discount')}}</span>
                                </div>
                                <div class="total-grand col-lg-12 d-flex justify-content-between">
                                    <span class="header-title text-uppercase fs-6 text-bold">
                                        {{ __('custom.grandTotal') }}:
                                    </span>
                                    <span class="value fs-5 text-secondary">{{caculate_cart_total($cart, 'grand')}}</span>
                                </div>
                            </div>
                        @endif

                    </div>
                </div>
            </form>

        </div>
    </div>
</x-frontend.dashboard.layout>
