<!--Sidebar-->
<div class="d-flex flex-column flex-shrink-0 p-3 bg-light" id="sidebar-wrapper">
      <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none sidebar-heading">
            <i class="fa-solid fa-house fa-xl me-2"></i>
            <span class="fs-3">{{ config('app.name', 'Laravel') }}</span>
      </a>
      <hr>

      <ul class="nav nav-pills flex-column mb-auto">
            @can('isAdmin')
            <li class="nav-item">
                  <a href="{{ route('admin.home') }}" class="nav-link {{ Route::currentRouteName() == 'admin.home' ? 'active' : 'link-dark' }}">
                        <i class="fa-solid fa-house me-2"></i>
                        Home
                  </a>
            </li>
            <li class="nav-item">
                  <a href="{{ route('admin.user_management') }}" class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.user_management') ? 'active' : 'link-dark' }}">
                        <i class="fa-solid fa-users"></i>
                        User Management
                  </a>
            </li>
            <li class="nav-item">
                  <a href="#" class="nav-link link-dark">
                        <i class="fa-solid fa-shop"></i>
                        Store
                  </a>
            </li>
            <li class="nav-item">
                  <a href="#" class="nav-link link-dark">
                        <i class="fa-solid fa-ruler-combined"></i>
                        Design
                  </a>
            </li>
            <li class="nav-item">
                  <a href="#" class="nav-link link-dark">
                        <i class="fa-solid fa-file-pen"></i>
                        Reports
                  </a>
            </li>
            <li class="nav-item">
                  <a href="{{ route('admin.settings') }}" class="nav-link {{ Illuminate\Support\Str::startsWith(Route::currentRouteName(), 'admin.settings') ? 'active' : 'link-dark' }}">
                        <i class="fa-solid fa-sliders"></i>
                        Settings
                  </a>
            </li>
            @endcan

            @can('isFoodSeller')

            @endcan
      </ul>

</div>