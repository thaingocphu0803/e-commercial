<x-slot:heading>
    <link href="{{ asset('backend/css/plugins/switchery/switchery.css') }}" rel="stylesheet">
</x-slot:heading>

<x-slot:script>
    <script src="{{ asset('backend/js/plugins/switchery/switchery.js') }}"></script>

    <script>
        $('.js-switch').each((index, element) => {
            var switchery = new Switchery(element, {
                color: '#1AB394'
            });
        });
    </script>
</x-slot:script>

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
                <th class="text-capitalize">{{ __('custom.payment') }}</th>
                <th class="text-capitalize">{{ __('custom.method') }}</th>
                <th class="text-capitalize">{{ __('custom.delivery') }}</th>
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
                            value="{{ $order->id }}" />
                    </td>

                    {{-- code --}}
                    <td>
                        <a href="">{{ $order->code }}</a>
                    </td>

                    {{-- create on --}}
                    <td>{{ $order->created_at->format('Y/m/d H:i:s') }}</td>

                    {{-- customer info --}}
                    <td>
                        <div><Strong style="min-width:1em">N:</Strong> <span class="ms-1">{{ $order->fullname }}</span></div>
                        <div><Strong style="min-width:1em">P:</Strong> <span class="ms-1">{{ $order->phone }}</div>
                        <div><Strong style="min-width:1em">A:</Strong> <span class="ms-1">{{ format_address($order) }}</span>
                    </td>

                    {{-- cart discount --}}
                    <td class="text-danger">{{ price_format($order->cart['totalDiscount']) }}</td>

                    {{-- shipping fee --}}
                    <td class="text-center text-success">{{ price_format($order->shipping_fee) }}</td>

                    {{-- cart grand total --}}
                    <td class="text-bold">{{ price_format($order->cart['totalGrand']) }}</td>

                    {{-- payment status --}}
                    <td>{{ __('module.payment_stt')[$order->payment] }}</td>

                    {{-- payment method --}}
                    <td>{{ __($method['title']) }}</td>

                    {{-- payment delivery status --}}
                    <td>{{ __('module.delivery_stt')[$order->delivery] }}</td>

                    {{-- payment confirm status --}}
                    <td>{{ __('module.confirm_stt')[$order->confirm] }}</td>

                    {{-- <td class="text-center">
                        @can('modules', 'order.update')
                            <a href="{{ route('order.edit', $order->id) }}" class="btn btn-success">
                                <i class="fa fa-edit"></i>
                            </a>
                        @endcan
                    </td> --}}

                </tr>
            @endforeach
        </tbody>
    </table>
    {{ $orders->links('pagination::bootstrap-4') }}

</div>
