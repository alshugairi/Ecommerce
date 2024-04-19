<!-- Language -->
<li class="nav-item dropdown">
    <a class="nav-link" data-toggle="dropdown" href="#">
        <i class="fa-solid fa-language"></i>
        {{ session('locale') }}
    </a>
    <ul class="dropdown-menu dropdown-menu-right">
        <li>
            <a class="dropdown-item" href="{{ route('language.switch', 'en') }}" data-language="en" data-text-direction="ltr">
                <span class="align-middle">{{ __('share.english') }}</span>
            </a>
        </li>
        <li>
            <a class="dropdown-item" href="{{ route('language.switch', 'ar') }}" data-language="ar" data-text-direction="rtl">
                <span class="align-middle">{{ __('share.arabic') }}</span>
            </a>
        </li>
    </ul>
</li>
