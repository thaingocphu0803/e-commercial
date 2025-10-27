@props([
    'menu' => [],
])

<li class=" menu-item-has-children ">
    <span class="menu-expand">
        @if (count($menu->children))
            <i class="fi-rs-angle-down"></i>
        @endif
    </span>
    {{-- <spanv class="menu-expand"></span> --}}
        <a href="{{ write_url($menu->menuLanguage->canonical, true, true) }}" target="_self">
            {{ $menu->menuLanguage->name }}
        </a>

        @if (count($menu->children))
            <ul class="dropdown" style="display: none;">
                @foreach ($menu->children as $menu)
                    <x-frontend.dashboard.mobile.childmenu :menu="$menu" />
                @endforeach
            </ul>
        @endif
</li>
