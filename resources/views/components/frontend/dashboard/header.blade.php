<div class="body-overlay-1"></div>
<div class="body-overlay-1"></div>
<div id="alert-container"></div>
<header class="header-area header-style-1 header-height-2 ">
    <div class="header-top header-top-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-xl-3 col-lg-6">
                    <div class="header-info">
                        <ul>
                            @foreach ($topMenus as $menu)
                                <li>
                                    <a href="{{write_url($menu->menuLanguage->canonical, true, true)}}" title=">{{ $menu->menuLanguage->name }}">
                                        <span>{{ $menu->menuLanguage->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="col-xl-5 d-none d-xl-block">
                    <div class="header-slogan text-center text-brand">
                        <strong> {{ $system['homepage_slogan'] }}</strong>
                    </div>
                </div>
                <div class="col-xl-4 col-lg-6">
                    <div class="header-info header-info-right">
                        <ul>
                            <li>{{ __('custom.contactTel') }}: &nbsp;<strong
                                    class="text-brand">{{ $system['contact_phone'] }}</strong>
                            </li>

                            <li>
                                @if ($currentLang = $languages->firstWhere('canonical', app()->getLocale()))
                                    <a class="language-dropdown-active" href="javascript:void(0)">
                                        <span>{{ $currentLang['name'] }}</span>
                                        <i class="fi-rs-angle-small-down"></i>
                                    </a>
                                @endif

                                <ul class="language-dropdown">
                                    @foreach ($languages as $lang)
                                        @if ($lang->canonical !== app()->getLocale())
                                            <li>
                                                <a href="{{route('language.change', $lang->canonical)}}">
                                                    <span>{{ $lang->name }}</span>
                                                </a>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="header-wrap">
                <div class="logo logo-width-1"><a href="https://nest.botble.com/vi"><img
                            src="https://nest.botble.com/storage/general/logo.png" data-bb-lazy="false"
                            class="page_speed_990213890"
                            alt="Nest - Kịch bản thương mại điện tử đa năng của Laravel"></a></div>
                <div class="header-right">
                    <div class="search-style-2">
                        <form action="https://nest.botble.com/vi/products" class="form--quick-search"
                            data-ajax-url="https://nest.botble.com/vi/ajax/search-products" method="GET">
                            <div class="form-group--icon position-relative">
                                <div class="product-cat-label">Tất cả danh mục</div><select
                                    class="product-category-select" name="categories[]" aria-label="Select category">
                                    <option value="">Tất cả danh mục</option>
                                    <option value="1">Sữa và sữa</option>
                                    <option value="2">Quần áo &amp; sắc đẹp</option>
                                    <option value="3">Đồ chơi thú cưng</option>
                                    <option value="4">Vật liệu nướng</option>
                                    <option value="5">Trái cây tươi</option>
                                    <option value="6">Rượu vang &amp; đồ uống</option>
                                    <option value="7">Hải sản tươi sống</option>
                                    <option value="8">Thức ăn nhanh</option>
                                    <option value="9">Rau</option>
                                    <option value="10">Bánh mì và nước trái cây</option>
                                    <option value="11">Bánh &amp; sữa</option>
                                    <option value="12">Cà phê &amp; trà</option>
                                    <option value="13">Thức ăn cho thú cưng</option>
                                    <option value="14">Thực phẩm ăn kiêng</option>
                                </select>
                            </div><input type="text" class="input-search-product" name="q"
                                placeholder="Tìm kiếm các mục..." value="" autocomplete="off"><button
                                class="btn" type="submit" aria-label="Gửi"><svg class="icon svg-icon-ti-ti-search"
                                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path d="M10 10m-7 0a7 7 0 1 0 14 0a7 7 0 1 0 -14 0"></path>
                                    <path d="M21 21l-6 -6"></path>
                                </svg></button>
                            <div class="panel--search-result"></div>
                        </form>
                    </div>
                    <div class="header-action-right">
                        <div class="header-action-2">
                            <div class="header-action-icon-2"><a href="https://nest.botble.com/vi/compare"><img
                                        class="svgInject" alt="So sánh"
                                        src="https://nest.botble.com/themes/nest/imgs/theme/icons/icon-compare.svg"><span
                                        class="pro-count blue compare-count">1</span></a><a
                                    href="https://nest.botble.com/vi/compare"><span class="lable">So sánh</span></a>
                            </div>
                            <div class="header-action-icon-2"><a href="https://nest.botble.com/vi/wishlist"><img
                                        class="svgInject" alt="Danh sách yêu thích"
                                        src="https://nest.botble.com/themes/nest/imgs/theme/icons/icon-heart.svg"><span
                                        class="pro-count blue wishlist-count"> 0 </span></a><a
                                    href="https://nest.botble.com/vi/wishlist"><span class="lable">Danh sách yêu
                                        thích</span></a></div>
                            <div class="header-action-icon-2"><a class="mini-cart-icon"
                                    href="https://nest.botble.com/vi/cart"><img alt="Giỏ hàng"
                                        src="https://nest.botble.com/themes/nest/imgs/theme/icons/icon-cart.svg"><span
                                        class="pro-count blue">0</span></a><a
                                    href="https://nest.botble.com/vi/cart"><span class="lable">Giỏ hàng</span></a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2 cart-dropdown-panel"><span>Không có
                                        sản phẩm nào trong giỏ.</span></div>
                            </div>
                            <div class="header-action-icon-2"><a
                                    href="https://nest.botble.com/vi/customer/overview"><img
                                        class="svgInject rounded-circle" alt="Tài khoản"
                                        src="https://nest.botble.com/themes/nest/imgs/theme/icons/icon-user.svg"></a><a
                                    href="https://nest.botble.com/vi/customer/overview"><span class="lable me-1">Tài
                                        khoản</span></a>
                                <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                    <ul>
                                        <li><a href="https://nest.botble.com/vi/login"><i
                                                    class="fi fi-rs-user mr-10"></i>Đăng nhập</a></li>
                                        <li><a href="https://nest.botble.com/vi/register"><i
                                                    class="fi fi-rs-user-add mr-10"></i>Đăng ký</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom header-bottom-bg-color">
        <div class="container">
            <div class="header-wrap header-space-between position-relative">
                <div class="logo logo-width-1 d-block d-lg-none"><a href="https://nest.botble.com/vi"><img
                            src="https://nest.botble.com/storage/general/logo.png" data-bb-lazy="false"
                            class="page_speed_990213890"
                            alt="Nest - Kịch bản thương mại điện tử đa năng của Laravel"></a></div>
                <div class="header-nav d-none d-lg-flex">
                    <div class="main-categories-wrap d-none d-lg-block"><a class="categories-button-active"
                            href="#"><span class="fi-rs-apps"></span><span class="et">Duyệt</span> Tất cả
                            danh mục <i class="fi-rs-angle-down"></i></a>
                        <div class="categories-dropdown-wrap categories-dropdown-active-large font-heading">
                            <div class="d-flex categories-dropdown-inner">
                                <ul>
                                    <li><a href="https://nest.botble.com/vi/product-categories/milks-and-dairies"><img
                                                src="https://nest.botble.com/storage/product-categories/icon-1.png"
                                                alt="Sữa và sữa" width="30" height="30"> Sữa và sữa </a></li>
                                    <li><a href="https://nest.botble.com/vi/product-categories/clothing-beauty"><img
                                                src="https://nest.botble.com/storage/product-categories/icon-2.png"
                                                alt="Quần áo &amp; sắc đẹp" width="30" height="30"> Quần áo
                                            &amp; sắc đẹp </a></li>
                                    <li><a href="https://nest.botble.com/vi/product-categories/pet-toy"><img
                                                src="https://nest.botble.com/storage/product-categories/icon-3.png"
                                                alt="Đồ chơi thú cưng" width="30" height="30"> Đồ chơi thú
                                            cưng </a></li>
                                    <li><a href="https://nest.botble.com/vi/product-categories/baking-material"><img
                                                src="https://nest.botble.com/storage/product-categories/icon-4.png"
                                                alt="Vật liệu nướng" width="30" height="30"> Vật liệu nướng
                                        </a></li>
                                    <li><a href="https://nest.botble.com/vi/product-categories/fresh-fruit"><img
                                                src="https://nest.botble.com/storage/product-categories/icon-5.png"
                                                alt="Trái cây tươi" width="30" height="30"> Trái cây tươi </a>
                                    </li>
                                </ul>
                                <ul class="end">
                                    <li><a href="https://nest.botble.com/vi/product-categories/wines-drinks"><img
                                                src="https://nest.botble.com/storage/product-categories/icon-6.png"
                                                alt="Rượu vang &amp; đồ uống" width="30" height="30"> Rượu
                                            vang &amp; đồ uống </a></li>
                                    <li><a href="https://nest.botble.com/vi/product-categories/fresh-seafood"><img
                                                src="https://nest.botble.com/storage/product-categories/icon-7.png"
                                                alt="Hải sản tươi sống" width="30" height="30"> Hải sản tươi
                                            sống </a></li>
                                    <li><a href="https://nest.botble.com/vi/product-categories/fast-food"><img
                                                src="https://nest.botble.com/storage/product-categories/icon-8.png"
                                                alt="Thức ăn nhanh" width="30" height="30"> Thức ăn nhanh </a>
                                    </li>
                                    <li><a href="https://nest.botble.com/vi/product-categories/vegetables"><img
                                                src="https://nest.botble.com/storage/product-categories/icon-9.png"
                                                alt="Rau" width="30" height="30"> Rau </a></li>
                                    <li><a href="https://nest.botble.com/vi/product-categories/bread-and-juice"><img
                                                src="https://nest.botble.com/storage/product-categories/icon-10.png"
                                                alt="Bánh mì và nước trái cây" width="30" height="30"> Bánh mì
                                            và nước trái cây </a></li>
                                </ul>
                            </div>
                            <div class="more_slide_open page_speed_648829015">
                                <div class="d-flex categories-dropdown-inner">
                                    <ul>
                                        <li><a href="https://nest.botble.com/vi/product-categories/cake-milk"><img
                                                    src="https://nest.botble.com/storage/product-categories/icon-11.png"
                                                    alt="Bánh &amp; sữa" width="30" height="30"> Bánh &amp;
                                                sữa </a></li>
                                    </ul>
                                    <ul class="end">
                                        <li><a href="https://nest.botble.com/vi/product-categories/coffee-teas"><img
                                                    src="https://nest.botble.com/storage/product-categories/icon-12.png"
                                                    alt="Cà phê &amp; trà" width="30" height="30"> Cà phê
                                                &amp; trà </a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="more_categories" data-text-show-more="Cho xem nhiều hơn..."
                                data-text-show-less="Hiện ít hơn..."><span class="icon"></span><span
                                    class="heading-sm-1">Cho xem
                                    nhiều hơn...</span></div>
                        </div>
                    </div>
                    {{--main menu --}}
                    <x-frontend.dashboard.header.mainmenu />
                </div>

                <div class="hotline d-none d-lg-flex"><img
                        src="https://nest.botble.com/themes/nest/imgs/theme/icons/icon-headphone.svg" alt="hotline">
                    <p>{{ $system['contact_phone'] }}<span>{{ __('custom.supportCenter') }}</span></p>
                </div>
                <div class="header-action-icon-2 d-block d-lg-none">
                    <div class="burger-icon burger-icon-white"><span class="burger-icon-top"></span><span
                            class="burger-icon-mid"></span><span class="burger-icon-bottom"></span></div>
                </div>
                <div class="header-action-right d-block d-lg-none">
                    <div class="header-action-2">
                        <div class="header-action-icon-2"><a href="https://nest.botble.com/vi/compare"><img
                                    alt="So sánh"
                                    src="https://nest.botble.com/themes/nest/imgs/theme/icons/icon-compare.svg"><span
                                    class="pro-count white compare-count">0</span></a></div>
                        <div class="header-action-icon-2"><a href="https://nest.botble.com/vi/wishlist"><img
                                    alt="Danh sách yêu thích"
                                    src="https://nest.botble.com/themes/nest/imgs/theme/icons/icon-heart.svg"><span
                                    class="pro-count white wishlist-count"> 0 </span></a></div>
                        <div class="header-action-icon-2"><a class="mini-cart-icon" href="#"><img
                                    alt="Giỏ hàng"
                                    src="https://nest.botble.com/themes/nest/imgs/theme/icons/icon-cart.svg"><span
                                    class="pro-count white">0</span></a>
                            <div class="cart-dropdown-wrap cart-dropdown-hm2 cart-dropdown-panel"><span>Không có sản
                                    phẩm nào trong giỏ.</span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

{{-- mobile screen --}}
<x-frontend.dashboard.mobile.header />
