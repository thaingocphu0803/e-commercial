<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th><input type="checkbox" class="checkAll check-table" name="input"></th>
                <th>{{ __('custom.code') }}</th>
                <th class="text-capitalize">{{ __('custom.ceateOn') }}</th>
                <th class="text-capitalize">{{ __('custom.customer') }}</th>
                <th class="text-capitalize">{{ __('custom.discount') }}</th>
                <th class="text-capitalize">{{ __('custom.shipfee') }}</th>
                <th class="text-capitalize">{{ __('custom.grandTotal') }}</th>
                <th colspan="2" class="text-capitalize">{{ __('custom.payment') }}</th>
                <th class="text-capitalize">{{ __('custom.method') }}</th>
                <th colspan="2" class="text-capitalize">{{ __('custom.delivery') }}</th>
                <th class="text-capitalize">{{ __('custom.status') }}</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($orders as $order)
                @php
                    $paymentMethod = collect(__('module.payment'));
                    $method = $paymentMethod->firstWhere('id', $order->method);
                @endphp

                <tr id="{{ $order->id }}">

                    <td>
                        <input type="checkbox" name="input" class="checkItem check-table"
                            value="{{ $order->code }}" />
                    </td>

                    {{-- code --}}
                    <td class="text-xs">
                        <a href="{{ route('order.detail', $order->code) }}">{{ $order->code }}</a>
                    </td>

                    {{-- create on --}}
                    <td class="text-xs text-muted">{{ $order->created_at->format('Y/m/d H:i:s') }}</td>

                    {{-- customer info --}}
                    <td class="text-xs">
                        <div><Strong style="min-width:1em">{{ __('custom.name') . ': ' }}</Strong> <span
                                class="ms-1">{{ $order->fullname }}</span></div>
                        <div><Strong style="min-width:1em">{{ __('custom.phone') . ': ' }}</Strong> <span
                                class="ms-1">{{ $order->phone }}</div>
                        <div><Strong style="min-width:1em">{{ __('custom.address') . ': ' }}</Strong> <span
                                class="ms-1">{{ format_address($order) }}</span>
                    </td>

                    {{-- cart discount --}}
                    <td class="text-danger text-xs">{{ price_format($order->cart['totalDiscount'] ?? 0) }}</td>

                    {{-- shipping fee --}}
                    <td class="text-center text-success text-xs">{{ price_format($order->shipping_fee) }}</td>

                    {{-- cart grand total --}}
                    <td class="text-bold text-xs">{{ price_format($order->cart['totalGrand']) }}</td>

                    {{-- payment status --}}
                    <td colspan="2">
                        @if ($order->confirm == 'cancel')
                            <span>---</span>
                        @elseif ($order->confirm == 'confirm')
                            <select
                                name="{{"payment_".$order->id}}"
                                data-code="{{$order->code}}"
                                data-old="{{$order->payment}}"
                                class="select-orders-stt select2"
                                data-field="payment"
                            >
                                @foreach (__('module.payment_stt') as $key => $val)
                                    <option value="{{ $key }}"
                                        {{ $order->payment == $key ? 'selected' : '' }}>
                                        {{ $val }}</option>
                                @endforeach
                            </select>
                        @else
                            <span class="text-xs text-danger italic">{{__('custom.confirmOrderBefore')}}</span>
                        @endif
                    </td>

                    {{-- payment method --}}
                    <td class="text-xs text-muted">{{ __($method['title']) }}</td>

                    {{-- payment delivery status --}}
                    <td colspan="2">
                        @if ($order->confirm == 'cancel')
                            <span>---</span>
                        @elseif ($order->confirm == 'confirm')
                            <select
                                name="{{"delivery_".$order->id}}"
                                data-code="{{$order->code}}"
                                data-old="{{$order->delivery}}"
                                data-field="delivery"
                                class="select-orders-stt select2"
                            >
                                @foreach (__('module.delivery_stt') as $key => $val)
                                    <option value="{{ $key }}"
                                        {{ $order->delivery == $key ? 'selected' : '' }}>{{ $val }}</option>
                                @endforeach
                            </select>
                        @else
                            <span class="text-xs text-danger italic">{{__('custom.confirmOrderBefore')}}</span>
                        @endif

                    </td>

                    {{-- payment confirm status --}}
                    <td class="text-xs text-muted">{{ __('module.confirm_stt')[$order->confirm] }}</td>

                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $orders->links('pagination::bootstrap-4') }}
</div>
