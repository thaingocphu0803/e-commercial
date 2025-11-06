@props([
    'menus' => [],
])
@foreach ($menus as $menu)
    <li>
        <a href="{{write_url($menu->menuLanguage->canonical, true, true)}}" target="_self">
            <span>{{ $menu->menuLanguage->name }}</span>
            @if (count($menu->children))
                <i class="fi-rs-angle-right"></i>
            @endif
        </a>
        @if (count($menu->children))
            <ul class="level-menu level-menu-modify">
                <x-frontend.dashboard.header.childmenu :menus="$menu->children" />
            </ul>
        @endif
    </li>
@endforeach
