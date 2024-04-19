<li class="nav-item dropdown">
    <a class="nav-link px-0" data-toggle="dropdown" href="#">
        <div class="avatar avatar-sm avatar-online">
            <img src="{{ asset('assets') }}/admin/img/user_avatar.jpg" alt class="rounded-circle" />
        </div>
    </a>
    <div class="dropdown-menu dropdown-menu-right">
        <a href="{{ route('profile.overview') }}" class="dropdown-item">
            <i class="fa-solid fa-user mr-2m"></i>
            <span class="align-middle">{{ __('share.profile') }}</span>
        </a>
        <a href="{{ route('cache.clear') }}" class="dropdown-item">
            <i class="fa-solid fa-broom mr-2m"></i>
            <span class="align-middle">{{ __('share.purge_cache') }}</span>
        </a>
        <a href="{{ url('/logout') }}" class="dropdown-item"
           onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">
            <i class="fa-solid fa-right-from-bracket mr-2m"></i>
            <span class="align-middle">{{ __('share.logout') }}</span>
        </a>
        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</li>

<li class="nav-item dropdown" style="display: none">
    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown">
        <div class="avatar avatar-online">
            <img src="{{ asset('assets') }}/img/avatars/1.png" alt class="h-auto rounded-circle" />
        </div>
    </a>
    <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
        <li>
            <a class="dropdown-item" href="#">
                <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                        <div class="avatar avatar-online">
                            <img src="{{ asset('assets') }}/img/avatars/1.png" alt class="h-auto rounded-circle" />
                        </div>
                    </div>
                    <div class="flex-grow-1">
                        <span class="fw-medium d-block">{{ auth()->user()->name }}</span>
                        <small class="text-muted">{{ auth()->user()->getRoleNames()->first() }}</small>
                    </div>
                </div>
            </a>
        </li>
        <li>
            <div class="dropdown-divider"></div>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('profile.overview') }}">
                <i class="ti ti-user-check me-2 ti-sm"></i>
                <span class="align-middle">{{ __('share.profile') }}</span>
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="#">
                <i class="ti ti-settings me-2 ti-sm"></i>
                <span class="align-middle">Settings</span>
            </a>
        </li>
        <li>
            <div class="dropdown-divider"></div>
        </li>
        <li>
            <a href="{{ url('/logout') }}" class="dropdown-item"
               onclick="event.preventDefault();
               document.getElementById('logout-form').submit();">
                <i class="ti ti-logout me-2 ti-sm"></i>
                <span class="align-middle">Log Out</span>
            </a>
            <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </li>
    </ul>
</li>
