<x-frontend.dashboard.layout>
{{-- @dd($cart); --}}
<div class="payment-infor page-wrapper">
    <div class="cart-container">
        <div class="row my-3">
            <div class="col-lg-7 px-5">
                <form action="" method="POST">
                    @csrf
                    <div class="form-header">
                        <div class="d-flex justify-content-between">
                            <span class="header-title text-uppercase fs-5 text-bold">{{__('custom.orderInfor')}}</span>
                            <div class="header-has-account">
                                <span>{{__('custom.hasAccount')}}</span>
                                <a href="#">{{__('custom.hasAccount')}}</a>
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
