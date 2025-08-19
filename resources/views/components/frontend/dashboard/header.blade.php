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
                                    <a href="{{ write_url($menu->menuLanguage->canonical, true, true) }}"
                                        title=">{{ $menu->menuLanguage->name }}">
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
                                                <a href="{{ route('language.change', $lang->canonical) }}">
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
                <div class="logo logo-width-1"><a href="{{route('home.index')}}"><img
                            src="{{base64_decode($system['homepage_logo'])}}" data-bb-lazy="false" width="100px" height="100px"
                            class="page_speed_990213890"
                            alt="tpro logo"></a></div>
                <div class="header-right">
                    <div class="search-style-2">
                        <form action="https://nest.botble.com/vi/products" class="form--quick-search"
                            data-ajax-url="https://nest.botble.com/vi/ajax/search-products" method="GET">
                            <div class="form-group--icon position-relative">
                                <div class="product-cat-label">{{ __('custom.allCatalouge') }}</div>
                                <select class="product-category-select" name="categories[]"
                                    aria-label="Select category">
                                    <option value="" disabled selected>{{ __('custom.allCatalouge') }}</option>
                                    @foreach ($allCatalouge as $catalouge)
                                        <option value="{{ $catalouge->id }}">{{ $catalouge->MenuLanguage->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="text" class="input-search-product" name="q"
                                placeholder="{{ __('custom.searchForCatalouge') }}" value=""
                                autocomplete="off"><button class="btn" type="submit"
                                aria-label="{{ __('custom.send') }}">
                                <svg class="icon svg-icon-ti-ti-search" xmlns="http://www.w3.org/2000/svg"
                                    width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    stroke="currentColor" stroke-width="2" stroke-linecap="round"
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
                <div class="logo logo-width-1 d-block d-lg-none"><a href="{{route('home.index')}}"><img
                            src="{{base64_decode($system['homepage_logo'])}}" data-bb-lazy="false"  width="100px" height="100px"
                            class="page_speed_990213890"
                            alt="tpro logo"></a></div>
                <div class="header-nav d-none d-lg-flex">
                    <div class="main-categories-wrap d-none d-lg-block">
                        <a class="categories-button-active" href="#">
                            <span class="fi-rs-apps"></span>
                            <span class="et">{{ __('custom.browseAllCategory') }}<i class="fi-rs-angle-down"></i>
                        </a>
                        <div class="categories-dropdown-wrap categories-dropdown-active-large font-heading">
                            <div class="d-flex categories-dropdown-inner">
                                <ul>
                                    @foreach ($allCatalouge->take(3) as $val)
                                            <li>
                                                <a href="{{ write_url($val->MenuLanguage->canonical, true, true) }}">
                                                    {{ $val->MenuLanguage->name }}
                                                </a>
                                            </li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="more_slide_open page_speed_648829015">
                                <div class="d-flex categories-dropdown-inner">
                                    <ul>
                                        @foreach ($allCatalouge->skip(3) as $val)
                                                <li>
                                                    <a href="{{ write_url($val->MenuLanguage->canonical, true, true) }}">
                                                        {{ $val->MenuLanguage->name }}
                                                    </a>
                                                </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="more_categories" data-text-show-more="Cho xem nhiều hơn..."
                                data-text-show-less="Hiện ít hơn...">
                                <span class="icon"></span>
                                <span class="heading-sm-1">{{__('custom.seeMore')}}</span>
                            </div>
                        </div>
                    </div>
                    {{-- main menu --}}
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
<x-frontend.dashboard.mobile.header :system="$system" />
