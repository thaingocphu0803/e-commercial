@props([
    'variantAlbum' => null,
])

@php
    $defaultValue = old('variantAlbum', $variantAlbum);
    $variantAlbum = json_decode($defaultValue);
@endphp

<div class="ibox variant-box">
    <div class="ibox-title">
        <h5>{{ __('form.variant') }}</h5>
    </div>
    <div class="ibox-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="variant-checkbox flex gap-10 flex-middle">
                    <input class="variantCheckbox-input" type="checkbox" value="" name="accept"
                        id="variantCheckbox">
                    <label class="variantCheckbox-label"
                        for="variantCheckbox">{{ __('form.objectMoreVarian', ['attribute' => __('dashboard.product')]) }}</label>
                </div>
            </div>
        </div>
        <div id="variant-wrapper" class="hidden">
            <div class="row mt-20">
                <div class="col-lg-3">
                    <div class="attribute-title">{{ __('form.chooseAttr') }}</div>
                </div>
                <div class="col-lg-9">
                    <div class="attribute-title">{{ __('form.chooseAttrVal') }}</div>
                </div>
            </div>
            <div id="variant-body">
                {{-- variant items here --}}
            </div>
            <div class="mt-20">
                <button id="add-variant-btn" type="button" class="btn btn-white add-variant-btn">
                    <i class="fa fa-plus"></i>
                    <span>{{ __('form.addVariant') }}</span>
                </button>
            </div>
        </div>
    </div>
</div>

<div class="ibox product-variant">
    <div class="ibox-title">
        <h5>{{ __('form.versions') }}</h5>
    </div>
    <div class="ibox-content">
        <div class="table-responsive">
            <table class="table table-striped variant-table">
                {{-- variant table content here! --}}
            </table>

            <tr>
                <td colspan="6">
                    <div class="updateVariant ibox">
                        <div class="ibox-title">
                            <div class="flex flex-middle flex-space-between">
                                <h5>{{ __('form.updateVersions') }}</h5>
                                <div class="button-group">
                                    <div class="flex flex-middle gap-10">
                                        <button type="button"
                                            class="btn btn-danger cancel-update">{{ __('form.cancel') }}</button>
                                        <button type="button"
                                            class="btn btn-success save-update">{{ __('form.save') }}</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="ibox-content">
                            <div class="click-to-upload-variant {{ !empty($variantAlbum) ? 'hidden' : '' }}">
                                <div class="icon">
                                    <a href="#" class="upload-variant-picture">
                                        <svg width="100px" height="100px" viewBox="0 0 48 48" id="a"
                                            xmlns="http://www.w3.org/2000/svg" fill="#000000">
                                            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                                            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"
                                                stroke="#CCCCCC" stroke-width="0.9600000000000002"></g>
                                            <g id="SVGRepo_iconCarrier">
                                                <defs>
                                                    <style>
                                                        .b {
                                                            fill: none;
                                                            stroke: #d3dbe2;
                                                            stroke-linecap: round;
                                                            stroke-linejoin: round;
                                                        }
                                                    </style>
                                                </defs>
                                                <path class="b"
                                                    d="M29.4995,12.3739c.7719-.0965,1.5437,.4824,1.5437,1.2543h0l2.5085,23.8312c.0965,.7719-.4824,1.5437-1.2543,1.5437l-23.7347,2.5085c-.7719,.0965-1.5437-.4824-1.5437-1.2543h0l-2.5085-23.7347c-.0965-.7719,.4824-1.5437,1.2543-1.5437l23.7347-2.605Z">
                                                </path>
                                                <path class="b"
                                                    d="M12.9045,18.9347c-1.7367,.193-3.0874,1.7367-2.8945,3.5699,.193,1.7367,1.7367,3.0874,3.5699,2.8945,1.7367-.193,3.0874-1.7367,2.8945-3.5699s-1.8332-3.0874-3.5699-2.8945h0Zm8.7799,5.596l-4.6312,5.6925c-.193,.193-.4824,.2894-.6754,.0965h0l-1.0613-.8683c-.193-.193-.5789-.0965-.6754,.0965l-5.0171,6.1749c-.193,.193-.193,.5789,.0965,.6754-.0965,.0965,.0965,.0965,.193,.0965l19.9719-2.1226c.2894,0,.4824-.2894,.4824-.5789,0-.0965-.0965-.193-.0965-.2894l-7.8151-9.0694c-.2894-.0965-.5789-.0965-.7719,.0965h0Z">
                                                </path>
                                                <path class="b"
                                                    d="M16.2814,13.8211l.6754-6.0784c.0965-.7719,.7719-1.3508,1.5437-1.2543l23.7347,2.5085c.7719,.0965,1.3508,.7719,1.2543,1.5437h0l-2.5085,23.7347c0,.6754-.7719,1.2543-1.5437,1.2543l-6.1749-.6754">
                                                </path>
                                                <path class="b"
                                                    d="M32.7799,29.9337l5.3065,.5789c.2894,0,.4824-.193,.5789-.4824,0-.0965,0-.193-.0965-.2894l-5.789-10.5166c-.0965-.193-.4824-.2894-.6754-.193h0l-.3859,.3859">
                                                </path>
                                            </g>
                                        </svg>
                                    </a>
                                </div>
                                <div class="small-text">
                                    {{ __('dashboard.clickToUpload', ['attribute' => __('form.button')]) }}</div>
                            </div>
                            <div class="upload-list-variant {{ !empty($variantAlbum) ? '' : 'hidden' }}">
                                <div class="row">
                                    <ul id="sortable-variant" class="clearfix data-variantAlbum sortui ui-sortable">
                                        @if (!empty($variantAlbum))

                                            @foreach ($variantAlbum as $item)
                                                <li class="ui-state-default">
                                                    <div class="thumb">
                                                        <span class="span image image-scaledown">
                                                            <img class="img_album" src="{{ $item }}"
                                                                alt="variantAlbum image">
                                                        </span>
                                                        <button type="button" class="delete-image">
                                                            <i class="fa fa-trash fa-lg" aria-hidden="true"></i>
                                                        </button>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif

                                    </ul>
                                    <input type="hidden" id="variantAlbum" name="variantAlbum" value="">

                                </div>
                            </div>
                            <div class="row mt-20">
                                <div class="col-lg-2 flex flex-col flex-middle">
                                    <label for="" class="control-label">{{ __('form.manageStock') }}</label>
                                    <input type="checkbox" class="js-switch" data-target="variant-quantity">
                                </div>
                                <div class="col-lg-10">
                                    <div class="row">
                                        <div class="col-lg-3">
                                            <label for="variant-quantity"
                                                class="control-label">{{ __('form.quantity') }}</label>
                                            <input class="form-control disabled" disabled type="text" id="variant-quantity"
                                                name="quantity" value="0">
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="variant-sku" class="control-label">SKU</label>
                                            <input class="form-control" type="text" id="variant-sku"
                                                name="sku" value="0">
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="variant-price"
                                                class="control-label">{{ __('form.price') }}</label>
                                            <input class="form-control" type="text" id="variant-price"
                                                name="quantity" value="0">
                                        </div>
                                        <div class="col-lg-3">
                                            <label for="variant-barcode"
                                                class="control-label">{{ __('form.barcode') }}</label>
                                            <input class="form-control" type="text" id="variant-barcode"
                                                name="quantity" value="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-20">
                                <div class="col-lg-2 flex flex-col flex-middle">
                                    <label for="" class="control-label">{{ __('form.managefile') }}</label>
                                    <input type="checkbox" class="js-switch" data-target="disabled">
                                </div>
                                <div class="col-lg-10">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <label for="variant-file"
                                                class="control-label">{{ __('form.filename') }}</label>
                                            <input class="form-control disabled" disabled type="text" id="variant-file" name="quantity">
                                        </div>
                                        <div class="col-lg-6">
                                            <label for="variant-link"
                                                class="control-label">{{ __('form.link') }}</label>
                                            <input class="form-control disabled" disabled type="text" id="variant-link" name="sku">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        </div>
    </div>
</div>

<script>
    const lang = "{{ app()->getLocale() }}";
    const listAttr = @json($listAttr);
</script>
