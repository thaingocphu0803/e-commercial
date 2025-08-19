@props([
    'products' => [],
])

<section class="product-tabs section-padding position-relative">
    <div class="container">
        <div class="section-title style-2 wow animate__ animate__fadeIn animated"
            style="visibility: visible; animation-name: fadeIn;">
            <div class="title">
                <h3>{{ __('custom.productList') }}</h3>
            </div>
        </div>

        <div class="row product-grid-5">
            @foreach ($products as $product)
                <div class="col-xxl-3 col-xl-3 col-lg-6 col-md-6 mb-lg-0 mb-md-5 mb-sm-5 col-6">
                    <div class="product-cart-wrap mb-30 wow animate__ animate__fadeIn animated" data-wow-delay="0.1s"
                        style="visibility: visible; animation-delay: 0.1s; animation-name: fadeIn;">
                        <div class="product-img-action-wrap">
                            <div class="product-img product-img-zoom">
                                <a href="{{write_url($product->product_canonical, true, true)}}">
                                    <img class="default-img"
                                        src="{{ (!is_null($product->image)) ? base64_decode($product->image) : config('app.general.noImage')}}"
                                        alt="{{ $product->product_name }}">
                                </a>
                            </div>
                            <div class="product-action-1">
                                <div class="product-action-wrap" style="max-width: 116px !important;">
                                    <a aria-label="{{__('custom.quickview')}}" href="#"
                                        class="action-btn hover-up"
                                        data-url="#">
                                        <i class="fi-rs-eye"></i>
                                    </a>
                                    <a aria-label="{{__('custom.addWishList')}}" href="#"
                                        class="action-btn hover-up js-add-to-wishlist-button"
                                        data-url="#">
                                        <i class="fi-rs-heart"></i>
                                    </a>
                                    <a aria-label="{{__('custom.compare')}}" href="#"
                                        class="action-btn hover-up js-add-to-compare-button"
                                        data-url="#">
                                        <i class="fi-rs-shuffle"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="product-badges product-badges-position product-badges-mrg">
                                @if ((intval($product->discountValue) !== 0))
                                    <span class="hot"> {{($product->discountType === 'percent') ? "$product->discountValue%" :  price_format($product->discount)}}</span>
                                @endif
                            </div>
                        </div>
                        <div class="product-content-wrap">
                            <div class="product-category">
                                <a href="https://nest.botble.com/vi/product-categories/vegetables">{{ $product->product_catalouge_name }}</a>
                            </div>
                            <h2 class="text-truncate">
                                <a href="https://nest.botble.com/vi/products/seeds-of-change-organic-quinoe">
                                    {{ $product->product_name }}
                                </a>
                            </h2>

                            {{-- <div class="product-rate-cover">
                                <div class="product-rate d-inline-block">
                                    <div class="product-rating" style="width: 55.555555555556%"></div>
                                </div>
                                <span class="font-small ml-5 text-muted">(9)</span>
                            </div> --}}
                            <div class="product-card-bottom d-md-flex d-block">
                                @if (intval($product->discount) === 0)
                                    <div class="product-price">
                                        <span class=""
                                            data-bb-value="product-price">{{ price_format($product->product_price)}}</span>
                                    </div>
                                @else
                                    <div class="product-price">
                                        <span class=""
                                            data-bb-value="product-price">{{ price_format($product->product_price - $product->discount) }}</span>

                                        <span class="">
                                            <small>
                                                <del class="old-price"
                                                    data-bb-value="product-original-price">{{ price_format($product->product_price)}}</del>
                                            </small>
                                        </span>
                                    </div>
                                @endif

                                <div class="add-cart">
                                    <div aria-label="{{ __('custom.addToCart') }}"
                                        class="action-btn add-to-cart-button add mt-md-0 mt-3"
                                        data-open-modal="#open_product_modal"
                                        title="{{ __('custom.addToCart') }}">
                                        <i class="fi-rs-shopping-cart mr-5"></i>
                                        <span class="d-inline-block">{{ __('custom.addToCart') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div>
            {{$products->links('pagination::bootstrap-5')}}
        </div>
    </div>
</section>
