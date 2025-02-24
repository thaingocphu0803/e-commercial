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
                        <li><a href="profile.html">Profile</a></li>
                        <li><a href="contacts.html">Contacts</a></li>
                        <li><a href="mailbox.html">Mailbox</a></li>
                        <li class="divider"></li>
                        <li><a href="{{ route('auth.logout') }}">Logout</a></li>
                    </ul>
                </div>
                <div class="logo-element">
                    IN+
                </div>
            </li>

            <x-backend.dashboard.nav.module icon='fa-user-circle-o' title="Manage Member">
                <li><a href="{{ route('user.index') }}">Members</a></li>
                <li><a href="{{ route('user.catalouge.index') }}">Member Group</a></li>
            </x-backend.dashboard.nav.module>

            <x-backend.dashboard.nav.module icon='fa-file' title="Manage Post">
                {{-- <li><a href="{{ route('post.index') }}">Post</a></li> --}}
                <li><a href="{{ route('post.catalouge.index') }}">Post Group</a></li>
            </x-backend.dashboard.nav.module>

            <x-backend.dashboard.nav.module icon='fa-cog' title='Setting'>
                <li><a href="{{ route('language.index') }}">Language</a></li>
            </x-backend.dashboard.nav.module>
        </ul>

    </div>
</nav>
