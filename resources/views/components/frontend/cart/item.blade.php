@props([
    'cart' => []
])

<div class="product-cart col-lg-12">
    @foreach ($cart as $key => $item)
        <div data-cart-id="{{$item->rowId}}" class="cart-item py-3 d-flex align-items-center justify-content-between {{($item !== $cart->first()) ? 'border-top' : ''}}">
        <div class="d-flex  justify-content-strench gap-5">
            <div class="cart-item-image">
                <img src="{{ (!is_null($item->options['image'])) ? base64_decode($item->options['image']) : config('app.general.noImage') }}"
                    alt="{{ __('custom.productImage') }}" class="img-cover">
            </div>
            <div
                class="cart-item-infor d-flex flex-column justify-content-between align-items-start">
                <span class="fs-6 text-bold text-secondary text-capitalize">
                    {{$item->name}}
                </span>
                <div class="cart-item-amount position-relative">
                    <button type="button" id="btn_decrease"
                        class="btn-hande-quantiy position-absolute text-bold fs-4">-</button>
                    <input type="text" name="product_quantity" id="cart_product_quantity"
                        class="text-center text-sencondary" value="{{$item->qty}}">
                    <button type="button" id="btn_increase"
                        class="btn-hande-quantiy position-absolute text-bold fs-4">+</button>
                </div>
            </div>

        </div>
        <div class="d-flex gap-5 align-items-center">
            <div class="d-flex flex-column gap-2">
                <span class="cart-item-price text-decoration-line-through fs-6  text-danger">
                    {{ (!empty($item->options['old_price'])) ? price_format($item->options['old_price'] * intval($item->qty)) : '' }}
                </span>
                <span class="cart-item-price fs-5 text-secondary">{{ price_format($item->price * intval($item->qty))}}</span>
            </div>
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
    @endforeach
</div>
