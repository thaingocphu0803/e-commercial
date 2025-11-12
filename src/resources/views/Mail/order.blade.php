<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-color: #fff;
            color: #333;
            margin: 0;
            padding: 1em;
        }

        .success-container {
            width: 100%;
            max-width: 800px;
            margin: 0 auto;
        }

        .order-header,
        .customer-header {
            text-align: center;
        }

        .header-title {
            text-transform: uppercase;
            font-size: 1.25em;
            font-weight: bold;
        }

        .order-body,
        .customer-body {
            border: 1px solid #ccc;
            padding: 1em;
            border-radius: 10px;
        }

        .body-title {
            text-align: center;
        }

        .title-code {
            border: 1px solid #ccc;
            padding: 5px 1em;
            border-radius: 1em;
            text-transform: uppercase;
            font-size: 1em;
            font-weight: bold;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 1em;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 8px;
        }

        thead tr {
            background-color: #d4edda;
            text-align: center;
        }

        tbody tr {
            background-color: #f8f9fa;
        }

        .text-secondary {
            color: #666;
        }

        .text-dark {
            color: #000;
        }

        .text-bold {
            font-weight: bold;
        }

        .text-uppercase {
            text-transform: uppercase;
        }

        .text-capitalize {
            text-transform: capitalize;
        }

        .fs-5 {
            font-size: 1.25em;
        }

        .fs-6 {
            font-size: 1em;
        }

        .my-4 {
            margin: 1.5em 0;
        }
        .my-1 {
            margin: 0.5em 0;
        }

        .col-lg-6 {
            max-width: 600px;
            width: 100%;
        }

        .body-total-grand span {
            font-size: 1.25em;
            font-weight: bold;
        }

        .body-discount,
        .body-total-price,
        .body-total-discount,
        .body-shipping-fee,
        .body-total-grand,
        .body-name,
        .body-email,
        .body-address,
        .body-phone,
        .body-payment-method {
            margin: 1em 0;
            text-align: start
        }
    </style>
</head>

<body>
    @php
        $paymentMethod = collect(__('module.payment'));
        $method = $paymentMethod->firstWhere('id', $order['customer_method']);
    @endphp

    <div class="success-container">
        {{-- order infor --}}
        <div class="col-lg-6">
            {{-- order header --}}
            <div class="order-header">
                <span class="header-title">{{ __('custom.orderInfor') }}</span>
            </div>

            {{-- order body --}}
            <div class="order-body my-4">
                {{-- body title --}}
                <div class="body-title">
                    <div class="">
                        <span class="title-code">{{ __('custom.PurchaseOrder') . ' #' . $order['code'] }}</span>
                    </div>
                </div>

                {{-- order date --}}
                <div class="text-capitalize text-bold my-1">{{ __('custom.date') . ' ' . $order['created_at'] }}</div>

                {{-- table --}}
                <table>
                    <thead>
                        <tr>
                            <th colspan="8">{{ __('custom.name') }}</th>
                            <th colspan="4">{{ __('custom.qty') }}</th>
                            <th colspan="4">{{ __('custom.originalPrice') }}</th>
                            <th colspan="4">{{ __('custom.purchasePrice') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($order['products'] as $product)
                            <tr>
                                <td colspan="8">{{ $product['name'] }}</td>
                                <td colspan="4" style="text-align:center;">{{ intval($product['qty']) }}</td>
                                <td colspan="4" style="text-align:center;">
                                    {{ price_format($product['price_original']) }}</td>
                                <td colspan="4" style="text-align:center;">{{ price_format($product['price']) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="body-discount">
                    <span class="text-secondary text-bold text-capitalize">{{ __('custom.discountCode') }}:</span>
                    <span class="text-secondary">{{ $order['cart_discount_code'] }}</span>
                </div>

                <div class="body-total-price">
                    <span class="text-secondary text-bold text-capitalize">{{ __('custom.totalPrice') }}:</span>
                    <span class="text-secondary">{{ price_format($order['total_price_original']) }}</span>
                </div>

                <div class="body-total-discount">
                    <span class="text-secondary text-bold text-capitalize">{{ __('custom.totalDiscount') }}:</span>
                    <span class="text-secondary">{{ price_format($order['total_discount']) }}</span>
                </div>

                <div class="body-shipping-fee">
                    <span class="text-secondary text-bold text-capitalize">{{ __('custom.shipfee') }}:</span>
                    <span class="text-secondary">{{ price_format($order['shipping_fee']) }}</span>
                </div>

                <div class="body-total-grand">
                    <span class="text-dark text-bold text-capitalize">{{ __('custom.grandTotal') }}:</span>
                    <span class="text-dark text-bold">{{ price_format($order['total_grand']) }}</span>
                </div>
            </div>
        </div>

        {{-- customer infor --}}
        <div class="my-4 col-lg-6">
            <div class="customer-header my-4">
                <span class="header-title">{{ __('custom.customerInfor') }}</span>
            </div>

            <div class="customer-body">
                <div class="body-name">
                    <span class="text-secondary text-bold text-capitalize">{{ __('custom.customerName') }}:</span>
                    <span class="text-secondary">{{ $order['customer_name'] }}</span>
                </div>

                <div class="body-email">
                    <span class="text-secondary text-bold text-capitalize">{{ __('custom.email') }}:</span>
                    <span class="text-secondary">{{ $order['customer_email'] }}</span>
                </div>

                <div class="body-address">
                    <span class="text-secondary text-bold text-capitalize">{{ __('custom.address') }}:</span>
                    <span class="text-secondary">{{ $order['customer_address'] }}</span>
                </div>

                <div class="body-phone">
                    <span class="text-secondary text-bold text-capitalize">{{ __('custom.phone') }}:</span>
                    <span class="text-secondary">{{ $order['customer_phone'] }}</span>
                </div>

                <div class="body-payment-method">
                    <span class="text-secondary text-bold text-capitalize">{{ __('custom.paymentMethod') }}:</span>
                    <span class="text-secondary">{{ __($method['title']) }}</span>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
