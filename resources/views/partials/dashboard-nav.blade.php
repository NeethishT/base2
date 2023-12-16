<aside class="navbar navbar-vertical navbar-expand-lg bg-website">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu">
        <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand navbar-brand-autodark">
            <a href="{{{ route('cms.users.dashboard') }}}">
                <img src="{{ asset('img/logo.svg') }}"  />
            </a>
        </h1>

        @php $rolePermission = empty(getPermissions() === false) ? getPermissions() : []; @endphp
        <div class="navbar-nav flex-row d-lg-none">
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
                    <span class="avatar avatar-sm">
                        <i class="ti ti-user-circle icon"></i>
                    </span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ Auth::user()->name }}</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                    <div class="p-2">
                        @if(empty(Auth::user()->roles) === false)
                            <b>Roles</b>
                            <ul class="list-unstyled">
                                @foreach(Auth::user()->roles as $role)
                                    <li><span class="badge badge-secondary">{{{ $role->name }}}</span></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="p-2 pop-up-flush">
                        <span>Redis Flush</span>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('cms.users.logout') }}" class="dropdown-item @if(!in_array('cms.users.logout',$rolePermission)) hidden @endif">Logout</a>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
            <ul class="navbar-nav pt-lg-3">
                <li class="nav-item @if(in_array(Route::currentRouteName(), ['cms.users.dashboard'])) active @endif">
                    @if(in_array('cms.users.dashboard',$rolePermission))
                    <a class="nav-link" href="{{ route('cms.users.dashboard') }}" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-dashboard icon"></i>
                        </span>
                        <span class="nav-link-title">
                            Dashboard
                        </span>
                    </a>
                    @endif
                </li>

                <li  class="nav-item dropdown  @if(in_array(Route::currentRouteName(), [ 'cms.aboutus.list', 'cms.aboutus.add', 'cms.aboutus.save'])) active @endif">
                    <a class="nav-link dropdown-toggle" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-file icon"></i>
                        </span>
                        <span class="nav-link-title">
                            Pages
                        </span>
                    </a>
                    <div class="dropdown-menu @if(in_array(Route::currentRouteName(), [ 'cms.aboutus.list', 'cms.aboutus.add', 'cms.aboutus.save','cms.aboutus.edit','cms.aboutus.update','cms.aboutus.delete','cms.aboutus.view','cms.aboutus.search','cms.aboutus.status'])) show @endif">
                        <div class="dropdown-menu-columns">
                            <div class="dropdown-menu-column">
                                @if(in_array('cms.aboutus.list',$rolePermission))
                                <a class="dropdown-item @if(in_array(Route::currentRouteName(), [ 'cms.aboutus.list', 'cms.aboutus.add', 'cms.aboutus.save','cms.aboutus.edit','cms.aboutus.update','cms.aboutus.delete','cms.aboutus.view','cms.aboutus.search','cms.aboutus.status'])) active @endif" href="{{ route('cms.aboutus.list') }}" >
                                    <i class="ti ti-list icon"></i> About Us
                                </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </li>

                <li class="nav-item">
                    @if(in_array('cms.users.logout',$rolePermission))
                    <a class="nav-link" href="{{ route('cms.users.logout') }}" >
                        <span class="nav-link-icon d-md-none d-lg-inline-block">
                            <i class="ti ti-logout icon"></i>
                        </span>
                        <span class="nav-link-title">
                            Logout
                        </span>
                    </a>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</aside>
<header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none">
    <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu"> <span class="navbar-toggler-icon"></span> </button>
        <div class="navbar-nav flex-row order-md-last">
            <div class="nav-item mx-2 badge badge-light">
                <b>Last Login:</b>{{ Auth::user()->last_login }}
            </div>
            <div class="nav-item dropdown">
                <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu" aria-expanded="false">
                    <span class="avatar avatar-sm">
                        <i class="ti ti-user-circle icon"></i>
                    </span>
                    <div class="d-none d-xl-block ps-2">
                        <div>{{ Auth::user()->name }}</div>
                    </div>
                </a>
                <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                   <div class="p-2">
                        @if(empty(Auth::user()->roles) === false)
                            <b>Roles</b>
                            <ul class="list-unstyled">
                                @foreach(Auth::user()->roles as $role)
                                    <li><span class="badge badge-secondary">{{{ $role->name }}}</span></li>
                                @endforeach
                            </ul>
                        @endif
                    </div>
                    <div class="dropdown-divider"></div>
                    <a href="{{ route('cms.users.logout') }}" class="dropdown-item">Logout</a>
                </div>
            </div>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
            <div>
                @section('page_action') @show
            </div>
        </div>
    </div>
</header>
