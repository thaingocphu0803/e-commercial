<nav class="navbar-default navbar-static-side" role="navigation">
    <div class="sidebar-collapse">
        <ul class="nav metismenu" id="side-menu">
            <li class="nav-header">
                <div class="dropdown profile-element"> <span>
                        <img alt="image" class="img-circle" src="../../../backend/img/profile_small.jpg" />
                    </span>
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold">David
                                    Williams</strong>
                            </span> <span class="text-muted text-xs block">Art Director <b class="caret"></b></span>
                        </span> </a>
                    <ul class="dropdown-menu animated fadeInRight m-t-xs">
                        <li><a href="profile.html">{{ __('custom.profile') }}</a></li>
                        <li><a href="contacts.html">{{ __('custom.contacts') }}</a></li>
                        <li><a href="mailbox.html">{{ __('custom.mailbox') }}</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route('auth.logout') }}">{{ __('custom.logout') }}</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>

            <x-backend.dashboard.nav.module icon='fa-user-circle-o' :title="__('custom.managerObject', ['attribute' => __('custom.member')])">
                @can('modules', 'user.index')
                    <li>
                        <a class="text-capitalize" href="{{ route('user.index') }}">
                            {{ __('custom.member') }}
                        </a>
                    </li>
                @endcan

                @can('modules', 'user.catalouge.index')
                    <li>
                        <a class="text-capitalize" href="{{ route('user.catalouge.index') }}">
                            {{ __('custom.objectGroup', ['attribute' => __('custom.member')]) }}
                        </a>
                    </li>
                @endcan

                @can('modules', 'permission.index')
                    <li>
                        <a class="text-capitalize" href="{{ route('permission.index') }}">
                            {{ __('custom.permission') }}
                        </a>
                    </li>
                @endcan

            </x-backend.dashboard.nav.module>

                        <x-backend.dashboard.nav.module icon='fa-cubes' :title="__('custom.managerObject', ['attribute' => __('custom.product')])">
                @can('modules', 'product.index')
                    <li>
                        <a class="text-capitalize"
                            href="/product/index">
                            {{ __('custom.product') }}
                        </a>
                    </li>
                @endcan

                @can('modules', 'product.catalouge.index')
                    <li>
                        <a class="text-capitalize"
                            href="/product/catalouge/index">
                            {{ __('custom.objectGroup', ['attribute' => __('custom.product')]) }}
                        </a>
                    </li>
                @endcan
            </x-backend.dashboard.nav.module>
            <x-backend.dashboard.nav.module icon='fa-cubes' :title="__('custom.managerObject', ['attribute' => __('custom.attr')])">
                @can('modules', 'attr.index')
                    <li>
                        <a class="text-capitalize"
                            href="/attr/index">
                            {{ __('custom.attr') }}
                        </a>
                    </li>
                @endcan

                @can('modules', 'attr.catalouge.index')
                    <li>
                        <a class="text-capitalize"
                            href="/attr/catalouge/index">
                            {{ __('custom.objectGroup', ['attribute' => __('custom.attr')]) }}
                        </a>
                    </li>
                @endcan
            </x-backend.dashboard.nav.module>
{{-- @new-module --}}


            <x-backend.dashboard.nav.module icon='fa-file' :title="__('custom.managerObject', ['attribute' => __('custom.post')])">
                @can('modules', 'post.index')
                    <li>
                        <a class="text-capitalize" href="{{ route('post.index') }}">
                            {{ __('custom.post') }}
                        </a>
                    </li>
                @endcan

                @can('modules', 'post.catalouge.index')
                    <li>
                        <a class="text-capitalize" href="{{ route('post.catalouge.index') }}">
                            {{ __('custom.objectGroup', ['attribute' => __('custom.post')]) }}
                        </a>
                    </li>
                @endcan
            </x-backend.dashboard.nav.module>

            <x-backend.dashboard.nav.module icon='fa-cog' :title="__('custom.managerObject', ['attribute' => __('custom.setting')])">
                @can('modules', 'language.index')
                    <li>
                        <a class="text-capitalize" href="{{ route('language.index') }}">
                            {{ __('custom.language') }}
                        </a>
                    </li>
                @endcan

                @can('modules', 'generate.index')
                <li>
                    <a class="text-capitalize" href="{{ route('generate.index') }}">
                        {{ __('custom.generate') }}
                    </a>
                </li>
                @endcan
            </x-backend.dashboard.nav.module>
        </ul>
    </div>
</nav>
