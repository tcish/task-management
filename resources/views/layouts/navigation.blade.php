<nav x-data="{ open: false }" class="navbar navbar-expand-lg navbar-light bg-white border-bottom sticky-top">
  <div class="container-fluid">
    <!-- Logo -->
    <a class="navbar-brand" href="{{ route("tasks.index") }}">
      <x-application-logo class="d-inline-block align-top" style="height: 36px;" alt="Logo" />
    </a>
    <h2>@yield('title', 'To-do List')</h2>

    <!-- Hamburger -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
      aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Navbar Links and Dropdown -->
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
      <ul class="navbar-nav ms-auto">
        <!-- Profile and Logout Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
            data-bs-toggle="dropdown" aria-expanded="false">
            {{ Auth::user()->name }}
          </a>
          <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
            <li>
              <a class="dropdown-item" href="{{ route("profile.edit") }}">{{ __("Profile") }}</a>
            </li>
            <li>
              <!-- Authentication -->
              <form method="POST" action="{{ route("logout") }}">
                @csrf
                <a class="dropdown-item" href="{{ route("logout") }}"
                  onclick="event.preventDefault(); this.closest('form').submit();">
                  {{ __("Log Out") }}
                </a>
              </form>
            </li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>
