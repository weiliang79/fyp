<nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
      <div class="container-fluid">
            <a class="navbar-brand" href="{{ Route('landing') }}">{{ config('app.name', 'Laravel') }}</a>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                  <!-- Left Side Of Navbar -->
                  <ul class="navbar-nav mr-auto">
                        <li class="nav-item">
                              <a class="nav-link" href="#">Menu</a>
                        </li>
                  </ul>

                  <!-- Right Side Of Navbar -->
                  <!-- Right Side Of Navbar -->
                  <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->

                        @Auth
                        <li class="nav-item dropdown">
                              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ auth()->user()->first_name }} {{ auth()->user()->last_name }}
                              </a>

                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}">
                                          {{ __('Logout') }}
                                    </a>

                                    {{--
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                    </form>
                                    --}}
                              </div>
                        </li>
                        @else
                        @guest('student')
                        @if(Route::has('student.login'))
                        <li class="nav-item">
                              <a class="nav-link" href="{{ route('student.login') }}">{{ __('Student Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('login'))
                        <li class="nav-item">
                              <a class="nav-link" href="{{ route('login') }}">{{ __('Admin/Food Seller Login') }}</a>
                        </li>
                        @endif

                        @if (Route::has('register'))
                        <li class="nav-item">
                              <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </li>
                        @endif
                        @else
                        <li class="nav-item dropdown">
                              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ auth('student')->user()->first_name }} {{ auth('student')->user()->last_name }}
                              </a>

                              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('student.logout') }}">
                                          {{ __('Logout') }}
                                    </a>

                                    {{--
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                    </form>
                                    --}}
                              </div>
                        </li>
                        @endguest
                        @endauth
                  </ul>
            </div>
      </div>
</nav>