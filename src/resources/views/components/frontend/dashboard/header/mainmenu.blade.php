    <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
        <nav>
            <ul>
                @foreach ($menus as $menu)
                    <li><a href="{{write_url($menu->menuLanguage->canonical, true, true)}}" target="_self">
                            <span>{{ $menu->menuLanguage->name }}</span>
                            @if (count($menu->children))
                                <i class="fi-rs-angle-down"></i>
                            @endif
                        </a>
                        @if (count($menu->children))
                            <ul class="sub-menu">
                                <x-frontend.dashboard.header.childmenu  :menus="$menu->children" />
                            </ul>
                        @endif
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
