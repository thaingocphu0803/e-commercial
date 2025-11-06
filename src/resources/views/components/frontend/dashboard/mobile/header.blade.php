<div class="mobile-header-active mobile-header-wrapper-style sidebar-visible">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-top">
            <div class="mobile-header-logo"><a href="{{ route('home.index') }}"><img
                        src="{{ base64_decode($system['homepage_logo']) }}" data-bb-lazy="false" width="100px"
                        height="100px" class="page_speed_1952188303"
                        alt="{{$system['seo_title_seo']}}"></a>
            </div>
            <div class="mobile-menu-close close-style-wrap close-style-position-inherit"><button
                    class="close-style search-close"><i class="icon-top"></i><i class="icon-bottom"></i></button></div>
        </div>
        <div class="mobile-header-content-area">
            <div class="mobile-search search-style-3 mobile-header-border">
                <form action="https://nest.botble.com/vi/products" class="form--quick-search"
                    data-ajax-url="https://nest.botble.com/vi/ajax/search-products"><input type="text" name="q"
                        class="input-search-product" placeholder="{{ __('custom.searchForCatalouge') }}" value=""
                        autocomplete="off"><button type="submit"><i class="fi-rs-search"></i></button>
                    <div class="panel--search-result"></div>
                </form>
            </div>
            <div class="mobile-menu-wrap mobile-header-border">
                <div class="main-categories-wrap"><a class="categories-button-active-2" href="#"><i
                            class="fi-rs-apps"></i> {{ __('custom.allCatalouge') }} <i class="fi-rs-angle-down"></i></a>
                    <div class="categories-dropdown-wrap categories-dropdown-active-small">
                        <ul class="categories-dropdown mt-2">
                            @foreach ($allCatalouge as $catalouge)
                            <li>
                                <a href="{{ write_url($catalouge->MenuLanguage->canonical, true, true) }}">
                                   {{ $catalouge->MenuLanguage->name }}
                                </a>
                            </li>
                            @endforeach

                        </ul>
                    </div>
                </div>
            </div>
            <div class="mobile-menu-wrap mobile-header-border">
                <nav>
                    <ul class="mobile-menu">

                        @foreach ($menus as $menu)
                            <x-frontend.dashboard.mobile.childmenu :menu="$menu"/>
                        @endforeach
                        <li class="text-capitalize"><a href="#" target="_self">{{__('custom.faq')}}</a></li>
                        <li class="text-capitalize"><a href="#" target="_self"> {{__('custom.contact')}} </a></li>
                    </ul>
                </nav>
            </div>
            <div class="mobile-header-info-wrap">
                <div class="single-mobile-header-info"><a class="mobile-language-active text-capitalize" href="javascript:void(0)"><i
                            class="fi-rs-globe"></i>{{__('custom.language')}} <span><i class="fi-rs-angle-down"></i></span></a>
                    <div class="lang-curr-dropdown lang-dropdown-active">
                        <ul>
                            @foreach ($languages as $lang)
                                <li>
                                    <a href="{{ route('home.language.change', $lang->canonical) }}">
                                        <span>{{ $lang->name }}</span>
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <div class="single-mobile-header-info"><a href="#"><i
                            class="fi-rs-shopping-cart"></i> {{__('custom.cart')}}</a></div>
                <div class="single-mobile-header-info"><a href="#"><i
                            class="fi-rs-refresh"></i> {{__('custom.compare')}}</a></div>
                <div class="single-mobile-header-info"><a href="#"><i
                            class="fi-rs-user"></i> {{__('custom.account')}}</a></div>
                <div class="single-mobile-header-info"><a href="{{'tel:'. $system['contact_phone']}}"><i class="fi-rs-headphones"></i> {{$system['contact_phone']}}</a></div>
            </div>
            <div class="mobile-social-icon mb-50">
                <p class="mb-15 font-heading h6 me-2">Theo chúng tôi</p><a href="https://www.facebook.com"
                    title="Facebook"><img src="https://nest.botble.com/storage/general/facebook.png"
                        alt="Facebook"></a><a href="https://www.twitter.com" title="Twitter"><img
                        src="https://nest.botble.com/storage/general/twitter.png" alt="Twitter"></a><a
                    href="https://www.instagram.com" title="Instagram"><img
                        src="https://nest.botble.com/storage/general/instagram.png" alt="Instagram"></a><a
                    href="https://www.pinterest.com" title="Pinterest"><img
                        src="https://nest.botble.com/storage/general/pinterest.png" alt="Pinterest"></a><a
                    href="https://www.youtube.com" title="Youtube"><img
                        src="https://nest.botble.com/storage/general/youtube.png" alt="Youtube"></a>
            </div>
            <div class="site-copyright">{{ __('custom.copyrightBy', ['attribute' => $system['homepage_copyright']]) }}
            </div>
        </div>
    </div>
</div>
