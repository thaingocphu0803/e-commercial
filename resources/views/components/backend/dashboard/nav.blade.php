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
                        <li><a href="profile.html">{{__('nav.profile')}}</a></li>
                        <li><a href="contacts.html">{{__('nav.contacts')}}</a></li>
                        <li><a href="mailbox.html">{{__('nav.mailbox')}}</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route('auth.logout') }}">{{__('nav.logout')}}</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>

            <x-backend.dashboard.nav.module icon='fa-user-circle-o' :title="__('nav.managerMember')">
                <li><a href="{{ route('user.index') }}">{{__('nav.member')}}</a></li>
                <li><a href="{{ route('user.catalouge.index') }}">{{__('nav.memberGroup')}}</a></li>
            </x-backend.dashboard.nav.module>

            <x-backend.dashboard.nav.module icon='fa-file' :title="__('nav.managerPost')">
                <li><a href="{{ route('post.index') }}">{{__('nav.post')}}</a></li>
                <li><a href="{{ route('post.catalouge.index') }}">{{__('nav.postGroup')}}</a></li>
            </x-backend.dashboard.nav.module>

            <x-backend.dashboard.nav.module icon='fa-cog' :title="__('nav.managerLanguage')">
                <li><a href="{{ route('language.index') }}">{{__('nav.language')}}</a></li>
            </x-backend.dashboard.nav.module>
        </ul>

    </div>
</nav>
