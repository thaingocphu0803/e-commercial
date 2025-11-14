<x-backend.dashboard.layout>
    <x-backend.dashboard.breadcrumb :title="__('custom.orderInfor')" />

    @php
        $paymentMethod = collect(__('module.payment'));
        $method = $paymentMethod->firstWhere('id', $order['customer_method']);
    @endphp

    <div class="row">
        <div class="order-wrapper wrapper wrapper-content animated fadeInRight">
            <div class="row">
                <div class="col-lg-8">
                    <div class="ibox">
                        <div class="ibox-title">
                            <div class="flex flex-middle flex-space-between">
                                <div class="ibox-title-left flex flex-middle gap-10">
                                    <span class="text-sm">{{ __('custom.orderdetail') }}</span>
                                    <span class="badge flex flex-middle gap-5">
                                        <div class="badge__tip"></div>
                                        <div class="badge-text text-sm text-center">Chưa giao</div>
                                    </span>
                                </div>
                                <div class="ibox-title-right text-sm">
                                    Source: Website
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="order-table flex flex-col flex-center gap-10">
                                @foreach ($order['products'] as $product)
                                    @php
                                        $totalPriceOriginal = $product['price_original'] * $product['qty'];
                                    @endphp
                                    <div
                                        class="table-item row p-10 flex gap-20 flex-middle my-10 {{ !$loop->last ? 'border-b-1' : '' }}">
                                        <div class="col-lg-7 flex gap-20 flex-middle">
                                            <div class="table-img">
                                                <img src="{{ base64_decode($product['image']) }}"
                                                    alt="{{ __('custom.productImage') }}" class="img-contain">
                                            </div>
                                            <div class="flex gap-5 align-start flex-col">
                                                <span
                                                    class="item-title text-lg text-success">{{ $product['name'] }}</span>
                                                <span
                                                    class="item-promotion text-xs text-muted">{{ __('custom.discountCode') . ': ' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 flex flex-center gap-10">
                                            <span
                                                class="item-price text-lg">{{ price_format($product['price_original']) }}</span>
                                            <span class="text-sm align-self-end">X</span>
                                            <span class="item-quantity text-lg">{{ $product['qty'] }}</span>
                                        </div>
                                        <div class="col-lg-2 flex flex-center">
                                            <span
                                                class="item-total text-lg text-bold">{{ price_format($totalPriceOriginal) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            {{-- order summary --}}
                            <div class="order-summary mt-10 pt-10 border-t-1">
                                <div class="text-xl text-capitalize mt-5 flex gap-20 flex-space-between ">
                                    <span>{{ __('custom.totalPrice') . ':' }}</span>
                                    <span>{{ price_format($order['total_price_original']) }}</span>
                                </div>
                                <div class="text-xl text-capitalize mt-5 flex gap-20 flex-space-between">
                                    <span>{{ __('custom.totalDiscount') . ':' }}</span>
                                    <span>{{ '-' . price_format($order['total_discount']) }}</span>
                                </div>
                                <div class="text-xl text-capitalize mt-5 flex gap-20 flex-space-between">
                                    <span>{{ __('custom.shipfee') . ':' }}</span>
                                    <span>{{ price_format($order['shipping_fee']) }}</span>
                                </div>
                                <div class="text-xl text-capitalize mt-5 text-bold flex gap-20 flex-space-between">
                                    <span>{{ __('custom.grandTotal') . ':' }}</span>
                                    <span>{{ price_format($order['total_grand']) }}</span>
                                </div>
                            </div>
                            {{-- order alert --}}
                            <div class="order-alert mt-10 pt-10 border-t-1 flex flex-middle flex-start gap-20">
                                <span class="alert-icon">
                                    <img src="{{ asset('backend/img/warning.webp') }}"
                                        alt="{{ __('custom.alertIcon') }}" class="img-contain">
                                </span>
                                <div class="alert-body flex flex-col">
                                    <span class="alert-title text-uppercase text-lg text-secondary">
                                        {{ __('custom.waitConfirmAttrOrder', ['attribute' => price_format($order['total_grand'])]) }}
                                    </span>
                                    <span class="text-sm text-muted">{{ __($method['title']) }}</span>
                                </div>
                                {{-- cancel btn --}}
                                <div class="alert-cancel ml-auto">
                                    <button type="button"
                                        class="btn btn-danger text-sm text-uppercase">{{ __('custom.cancel') }}</button>
                                </div>
                            </div>

                            {{-- order confirm --}}
                            <div class="order-confirm mt-10 pt-10 border-t-1 flex flex-space-between flex-middle">
                                <div class="confirm-left flex gap-20 flex-middle">
                                    <span class="left-icon"><i class="fa fa-2x fa-truck"></i></span>
                                    <span
                                        class="left-content text-lg text-muted">{{ __('custom.confirmOrder') }}</span>
                                </div>
                                {{-- confirm btn --}}
                                <div class="confirm-right">
                                    <button type="button"
                                        class="order-confirm-btn btn btn-success text-sm text-uppercase">{{ __('custom.confirm') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="order-aside col-lg-4">
                    {{-- order note --}}
                    <div class="ibox">
                        <div class="ibox-title flex flex-middle flex-space-between">
                            <span class="text-sm text-bold text-capitalize">{{ __('custom.note') }}</span>
                            <button data-target="orderNote" class="order-edit btn-sm btn-link text-sm text-capitalize" type="button">{{__('custom.edit')}}</button>
                        </div>
                        <div class="ibox-content">
                            <span class="text-muted text-sm">{{$order['note'] ?? "(".__('custom.noNot').")"}}</span>
                            <input type="text" name="order_note_input" class="hidden form-control">
                        </div>
                    </div>

                    {{-- customer infor --}}
                    <div class="ibox">
                        <div class="ibox-title flex flex-middle flex-space-between">
                            <span class="text-sm text-bold text-capitalize">{{ __('custom.customerInfor') }}</span>
                            <button data-target="customerInfor" class="order-edit btn-sm btn-link text-sm text-capitalize" type="button">{{__('custom.edit')}}</button>
                        </div>
                        <div class="ibox-content flex flex-col flex-center gap-10">
                            {{-- customer name --}}
                            <div class="text-sm text-muted">
                                <Strong>{{ __('custom.name') . ': ' }}</Strong>
                                <span class="ms-1">{{ $order['customer_name'] }}</span>
                            </div>

                            {{-- customer email --}}
                            <div class="text-sm text-muted">
                                <Strong>{{ __('custom.email') . ': ' }}</Strong>
                                <span class="ms-1">{{ $order['customer_email'] }}</span>
                            </div>

                            {{-- customer phone --}}
                            <div class="text-sm text-muted">
                                <Strong>{{ __('custom.phone') . ': ' }}</Strong>
                                <span class="ms-1">{{ $order['customer_phone'] }}</span>
                            </div>

                            {{-- customer address --}}
                            <div class="text-sm text-muted">
                                <Strong>{{ __('custom.address') . ': ' }}</Strong>
                                <span class="ms-1">{{ $order['customer_address'] }}</span>
                            </div>

                            {{-- customer ward --}}
                            {{-- <div class="text-sm text-muted">
                                <Strong>{{__('custom.ward') . ": "}}</Strong>
                                <span class="ms-1">{{ 'phu thuan' }}</span>
                            </div> --}}

                            {{-- customer district --}}
                            {{-- <div class="text-sm text-muted">
                                <Strong>{{__('custom.district') . ": "}}</Strong>
                                <span class="ms-1">{{ 'quan 7' }}</span>
                            </div> --}}

                            {{-- customer city --}}
                            {{-- <div class="text-sm text-muted">
                                <Strong>{{__('custom.city') . ": "}}</Strong>
                                <span class="ms-1">{{ 'hcm' }}</span>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- hidden order code --}}
    <input type="hidden" name="order_code" value="{{$order['code']}}">


</x-backend.dashboard.layout>
