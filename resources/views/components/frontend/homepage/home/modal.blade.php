<!-- modal -->
<div id="open_product_modal" class="modal">
    <div class="modal-container">
        <span data-close-modal="#open_product_modal" class="close">&times;</span>
        <div class="modal-content">
            <div class="wrapper-content">
                <div class="d-flex flex-row justify-content-between">
                    <div class="modal-product-image w-50 d-flex flex-column gap-3 pe-3">
                        <div class="image-main">
                            <img src="{{ config('app.general.noImage') }}" alt="{{ __('custom.productImg') }}"
                                class="img-cover">
                        </div>
                        <div class="image-list d-flex gap-3">
                            <div class="list-item active">
                                <img src="{{ config('app.general.noImage') }}" alt="{{ __('custom.productImg') }}"
                                    class="img-cover">
                            </div>
                            <div class="list-item">
                                <img src="http://res.cloudinary.com/my-could-api/image/upload/v1752546304/album/variant/imqslgwqj86lhvlue88y.jpg"
                                    alt="{{ __('custom.productImg') }}" class="img-cover">
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-column justify-content-between w-50">
                        <div class="d-flex flex-column gap-4">
                            <div class="modal-product-title align-self-start">
                                <h3 class="title text-wrap"></h3>
                            </div>

                            <div class="modal-product-price py-3 d-flex">
                                {{-- content here !! --}}
                            </div>

                            {{-- start product catalouge --}}
                            <div class="modal-product-catalouge d-flex align-items-center">
                                <span
                                    class=" me-3 fs-5 text-secondary text-capitalize">{{ __('custom.catalouge') }}:</span>
                                <div class="catalouge-list d-flex justify-content-between gap-3">
                                    {{-- content here !! --}}
                                </div>
                            </div>
                            {{-- end product catalouge --}}

                            {{-- start product variant --}}
                            <div class="modal-product-variant-box border-top border-secondary d-none">
                                {{-- content here !! --}}
                            </div>
                            {{-- end product variant --}}

                            {{-- start product description --}}
                            <div class="border-top border-secondary text-wrap">
                                <div class="modal-product-description d-flex flex-column justify-items-center mt-5">
                                    <span
                                        class="me-3 fs-6 text-secondary text-capitalize">{{ __('custom.description') }}:</span>
                                    <div class="description-content ">
                                        <div class="list-item active">pc</div>
                                        <div class="list-item">lap</div>
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
                                        <button class="btn fs-6 btn-outline-secondary btn-hande-amount" type="button"
                                            id="btn_decrease">-</button>
                                        <input type="text" class="form-control text-center" name="product_amount"
                                            id="product_amount" value="1" . />
                                        <button class="btn fs-6 btn-outline-secondary btn-hande-amount" type="button"
                                            id="btn_increase">+</button>
                                    </div>
                                </div>
                                <div class="toolbox-cart w-50 p-3 d-flex justify-content-center">
                                    <div class=" btn btn-outline-secondary">
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
            </div>
        </div>
    </div>
</div> <!-- end modal -->
