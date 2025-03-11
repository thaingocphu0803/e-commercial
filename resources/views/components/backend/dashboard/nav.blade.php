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
                        <li><a href="profile.html">{{ __('dashboard.profile') }}</a></li>
                        <li><a href="contacts.html">{{ __('dashboard.contacts') }}</a></li>
                        <li><a href="mailbox.html">{{ __('dashboard.mailbox') }}</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route('auth.logout') }}">{{ __('dashboard.logout') }}</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>

            <x-backend.dashboard.nav.module icon='fa-user-circle-o' :title="__('dashboard.managerObject', ['object' => __('dashboard.member')])">
                @can('modules', 'user.index')
                    <li>
                        <a class="text-capitalize" href="{{ route('user.index') }}">
                            {{ __('dashboard.member') }}
                        </a>
                    </li>
                @endcan

                @can('modules', 'user.catalouge.index')
                    <li>
                        <a class="text-capitalize" href="{{ route('user.catalouge.index') }}">
                            {{ __('dashboard.objectGroup', ['object' => __('dashboard.member')]) }}
                        </a>
                    </li>
                @endcan

                @can('modules', 'permission.index')
                    <li>
                        <a class="text-capitalize" href="{{ route('permission.index') }}">
                            {{ __('dashboard.permission') }}
                        </a>
                    </li>
                @endcan

            </x-backend.dashboard.nav.module>

            {{-- @new-module --}}


            <x-backend.dashboard.nav.module icon='fa-file' :title="__('dashboard.managerObject', ['object' => __('dashboard.post')])">
                @can('modules', 'post.index')
                    <li>
                        <a class="text-capitalize" href="{{ route('post.index') }}">
                            {{ __('dashboard.post') }}
                        </a>
                    </li>
                @endcan

                @can('modules', 'post.catalouge.index')
                    <li>
                        <a class="text-capitalize" href="{{ route('post.catalouge.index') }}">
                            {{ __('dashboard.objectGroup', ['object' => __('dashboard.post')]) }}
                        </a>
                    </li>
                @endcan
            </x-backend.dashboard.nav.module>

            <x-backend.dashboard.nav.module icon='fa-cog' :title="__('dashboard.managerObject', ['object' => __('dashboard.language')])">
                @can('modules', 'language.index')
                    <li>
                        <a class="text-capitalize" href="{{ route('language.index') }}">
                            {{ __('dashboard.language') }}
                        </a>
                    </li>
                @endcan

                @can('modules', 'generate.index')
                <li>
                    <a class="text-capitalize" href="{{ route('generate.index') }}">
                        {{ __('dashboard.generate') }}
                    </a>
                </li>
                @endcan
            </x-backend.dashboard.nav.module>
        </ul>
    </div>
</nav>
