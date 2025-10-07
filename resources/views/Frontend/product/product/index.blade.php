<x-frontend.dashboard.layout :seo="$seo">
    <div class="product page-wrapper product-infor"
    data-model-product-id={{ $product['id'] }}
    data-product-promotion-id="{{ $product['promotion_id'] ?? null }}"
    data-product-uuid="{{ $product['variant_uuid'] ?? null }}"
    >
        <div class="container">
            <div class="product-body row my-4">
                {{-- start product image --}}
                <div class="col-lg-4">
                    <div class="d-flex">
                        <div class="modal-product-image w-100 d-flex flex-column gap-3 pe-3">
                            <div class="image-main">
                                <img src="{{ base64_decode($product['image']) }}" alt="" class="img-cover">
                            </div>
                            <div class="image-list d-flex justify-content-center gap-3">
                                <div class="list-item active">
                                    <img src="{{ base64_decode($product['image']) }}" alt="" class="img-cover">
                                </div>

                                @if (!empty($product['album']))
                                    @foreach ($product['album'] as $img)
                                        <div class="list-item">
                                            <img src="{{ $img }}" alt="" class="img-cover">
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                {{-- end product image --}}

                {{-- start product information --}}
                <div class="col-lg-5">
                    <div class="d-flex h-100 flex-column justify-content-between">
                        <div class="d-flex flex-column gap-4">
                            <div class="modal-product-title align-self-start">
                                <h3 class="title text-wrap">{{ $product['name'] }}</h3>
                            </div>

                            <div class="modal-product-price py-3 d-flex">
                                @if (!empty($product['discounted_price']))
                                    <span
                                        class="fs-3 text-infor">{{ price_format($product['discounted_price']) }}</span>
                                    <span
                                        class="old-price text-danger ms-1 fs-6">{{ price_format($product['price']) }}</span>
                                @else
                                    <span class="fs-3 text-infor">{{ price_format($product['price']) }}</span>
                                @endif
                            </div>

                            {{-- start product catalouge --}}
                            <div class="modal-product-catalouge d-flex align-items-center">
                                <span
                                    class=" me-3 fs-5 text-secondary text-capitalize">{{ __('custom.catalouge') }}:</span>
                                <div class="catalouge-list d-flex justify-content-between gap-3">
                                    @foreach ($product['catalouges'] as $catalouge)
                                        <a href="{{ write_url($catalouge['product_catalouge_canonical'], true, true) }}"
                                            class="list-item"
                                            data-catalouge-id="{{ $catalouge['product_catalouge_id'] }}">
                                            {{ $catalouge['product_catalouge_name'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            {{-- end product catalouge --}}

                            {{-- start product variant --}}
                            @if (!empty($product['attrCatalouges']))
                                <div class="modal-product-variant-box border-top border-secondary">
                                    @foreach ($product['attrCatalouges'] as $catalouge)
                                        <div class="modal-product-variant d-flex flex-column justify-items-center mt-5"
                                            data-attr-catalouge-id="{{ $catalouge['attr_catalouge_id'] }}">
                                            <span
                                                class="fs-6 text-secondary text-capitalize">{{ $catalouge['attr_catalouge_name'] }}</span>
                                            <div class="variant-list d-flex justify-content-strench gap-3">
                                                @foreach ($catalouge['attrs'] as $attr)
                                                    @if (in_array($attr['id'], $product['attrs']))
                                                        <span
                                                            class="list-item {{ in_array($attr['id'], $product['variant_codes']) ? 'active' : '' }}"
                                                            data-attr-id="{{ $attr['id'] }}">
                                                            {{ $attr['name'] }}
                                                        </span>
                                                    @endif
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            {{-- end product variant --}}

                            {{-- start product description --}}
                            <div class="border-top border-secondary text-wrap">
                                <div class="modal-product-description d-flex flex-column justify-items-center mt-5">
                                    <span
                                        class="me-3 fs-6 text-secondary text-capitalize">{{ __('custom.description') }}:</span>
                                    <div class="description-content ">
                                        {!! $product['description'] !!}
                                    </div>
                                </div>
                            </div>
                            {{-- end product description --}}
                        </div>



                        {{-- start product toolbox --}}
                        <div class="border-top border-secondary">
                            <div class="modal-product-toolbox d-flex  justify-items-between align-items-center mt-5">
                                <div
                                    class="toolbox-amount w-50  p-3 d-flex flex-column justify-item-center border-end border-secondary">
                                    <div class="input-group input-group-sm">
                                        <button class="btn fs-6 btn-outline-secondary btn-hande-quantiy" type="button"
                                            id="btn_decrease">-</button>
                                        <input type="text" class="form-control text-center" name="product_quantity"
                                            id="product_quantity" value="1" . />
                                        <button class="btn fs-6 btn-outline-secondary btn-hande-quantiy" type="button"
                                            id="btn_increase">+</button>
                                    </div>
                                </div>
                                <div class="toolbox-cart w-50 p-3 d-flex justify-content-center">
                                    <div class="btn-addToCart btn btn-outline-secondary">
                                        <div aria-label="{{ __('custom.addToCart') }}" class="mt-md-0 mt-3"
                                            title="{{ __('custom.addToCart') }}">
                                            <i class="fi-rs-shopping-cart mr-5"></i>
                                            <span class="d-inline-block">{{ __('custom.addToCart') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        {{-- end product toolbox --}}
                    </div>
                </div>
                {{-- end product information --}}

                {{-- start product catalouge --}}
                <div class="col-lg-3">
                    <div class="product-catalouge-list d-flex flex-column gap-3 justify-content-start">
                        <div class="list-title">
                            <h3 class="text-capitalize text-center fs-5">{{ __('custom.productCatalouge') }}</h3>
                        </div>

                        <div class="list-content d-flex flex-column gap-2 justify-content-start p-10">
                            @foreach ($productCategories as $productCategory)
                                <a href="{{write_url($productCategory->canonical, true, true)}}" class="content-item d-flex align-items-center gap-3">
                                    <div class="item-img">
                                        <img src="{{ base64_decode($productCategory->image) }}" alt=""
                                            class="img-cover">
                                    </div>
                                    <span class="fs-6">{{$productCategory->name}}</span>
                                </a>
                            @endforeach
                        </div>
                        <div class="mt-auto d-flex justify-content-center justify-self-end py-2">
                            {{$productCategories->links('pagination::bootstrap-4') }}
                        </div>
                    </div>
                </div>
                {{-- end product catalouge --}}
            </div>
        </div>
    </div>
</x-frontend.dashboard.layout>
