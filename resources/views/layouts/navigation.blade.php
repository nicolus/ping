<nav class="navbar navbar-expand-md navbar-light bg-white border-bottom sticky-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="/">
            <x-application-logo width="36" /> Pinger
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a @class(['nav-link', 'active' => request()->routeIs('urls.index')])>
                        {{ __('Dashboard') }}
                    </a>
                </li>
            </ul>

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ms-auto">
                <!-- Settings Dropdown -->
                @auth
                    <li class="nav-item dropdown">
                        <a id="settingsDropdown" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-end" aria-labelledby="settingsDropdown">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item px-4" type="submit">{{ __('Logout') }}</button>
                            </form>
                            <a class="dropdown-item px-4" href="{{ route('settings') }}">{{ __('Settings') }}</a>
                        </div>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
