<nav class="main-header navbar navbar-expand navbar-dark navbar-success">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>

        {{-- <li class="nav-item d-none d-sm-inline-block"> --}}
        {{-- <a href="index3.html" class="nav-link">Home</a> --}}
        {{-- </li> --}}
        {{-- <li class="nav-item d-none d-sm-inline-block"> --}}
        {{-- <a href="#" class="nav-link">Contact</a> --}}
        {{-- </li> --}}
    </ul>

    <!-- SEARCH FORM -->
    {{-- <form class="form-inline ml-3"> --}}
    {{-- <div class="input-group input-group-sm"> --}}
    {{-- <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search"> --}}
    {{-- <div class="input-group-append"> --}}
    {{-- <button class="btn btn-navbar" type="submit"> --}}
    {{-- <i class="fas fa-search"></i> --}}
    {{-- </button> --}}
    {{-- </div> --}}
    {{-- </div> --}}
    {{-- </form> --}}

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown">
            <a href="#" class="nav-link d-block dropdown-toggle" data-toggle="dropdown">
                <img src="{{ Storage::disk('public')->exists('images/admin_profile/original_' . $user->first_name) == true ? Storage::url('images/admin_profile/original_' . $user->first_name) : asset('public/assets/images/blank-profile.jpg') }}"
                    class="rounded-circle mr-2" height="34" alt="">
                <span>{{ $user->first_name . ' ' . $user->last_name }}</span>

            </a>

            <div class="dropdown-menu dropdown-menu-right">
                <a href="{{ route('admin.dashboard') }}" class="dropdown-item"><i class="icon-user-plus"></i> My
                    profile</a>

                @if (Auth::guard('users')->check())
                    <a href="{{ route('admin.logout') }}" class="dropdown-item"><i class="icon-switch2"></i>
                        Logout</a>
                    {{-- <a href="#" class="dropdown-item"
                        onclick="event.preventDefault(); document.querySelector('#admin-logout-form').submit();"><i
                            class="icon-switch2"></i> Logout</a>
                    <form id="admin-logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form> --}}
                @endif
            </div>
        </li>
    </ul>
</nav>
