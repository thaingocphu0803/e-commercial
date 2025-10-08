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
            <div class="row my-3">
                <div class="col-lg-7 px-5">
                    <form action="" method="POST" class="d-flex flex-column gap-5">
                        @csrf
                        <div class="row">
                            <div class="form-header">
                                <div class="d-flex justify-content-between">
                                    <span
                                        class="header-title text-uppercase fs-5 text-bold">{{__('custom.orderInfor')}}</span>
                                    <div class="header-has-account">
                                        <span>{{__('custom.hasAccount')}}</span>
                                        <a class="ms-1" href="#">{{__('custom.logHere')}}</a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-body mt-3 d-flex flex-column gap-3">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <input class="form-control" type="text" name="customer[fullname]"
                                            placeholder="{{__('custom.enterFullName')}}">
                                    </div>
                                    <div class="col-lg-6">
                                        <input class="form-control" type="text" name="customer[phone]"
                                            placeholder="{{__('custom.enterPhone')}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="email" name="customer[email]"
                                            placeholder="{{__('custom.enterEmail')}}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-4">
                                        <select name="customer[city]" class="nice-select form-select">
                                            <option disabled selected>
                                                {{__('custom.chooseObject', ['attribute' => __('custom.city')])}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <select name="customer[district]" class="nice-select form-select">
                                            <option disabled selected>
                                                {{__('custom.chooseObject', ['attribute' => __('custom.district')])}}
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <select name="customer[ward]" class="nice-select form-select">
                                            <option disabled selected>
                                                {{__('custom.chooseObject', ['attribute' => __('custom.ward')])}}
                                            </option>

                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <input class="form-control" type="text" name="customer[note]"
                                            placeholder="{{__('custom.enterNote')}}">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-header">
                                <div class="d-flex justify-content-between">
                                    <span
                                        class="header-title text-uppercase fs-5 text-bold">{{__('custom.paymentMethod')}}</span>
                                </div>
                            </div>
                            <div class="form-body mt-3">
                                <div class="row">
                                    <div class="col-lg-12">
                                        @foreach (__('module.payment') as $payment)
                                        <label for="{{$payment['id']}}" class="form-control d-flex align-items-center gap-4">
                                            <input class="radio-input" type="radio" name="customer[payment_method]" id="{{$payment['id']}}">
                                            <img class="img-icon" src="{{$payment['img']}}" alt="{{__('custom.paymentMethod')}}">
                                            <span>{{__($payment['title'])}}</span>
                                        </label>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-lg-5 px-5">2</div>
            </div>
        </div>
    </div>
</x-frontend.dashboard.layout>