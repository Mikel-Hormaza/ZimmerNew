<nav class="navbar navbar-expand-lg navbar-light bg-white">
  <div class="container-fluid">
      <a class="navbar-brand fw-bold" href="/">
          <i class="fa fa-home"></i>
          <span>ZIMMER</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
              <li class="nav-item">
                  <a class="nav-link active" aria-current="page" href="/hoteles">Hotelak</a>
              </li>
          </ul>
          <div class="d-flex">
              @guest
              @if (Route::has('login'))
              <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
              @endif

              @if (Route::has('register'))
              <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
              @endif
              @else
              <div class="nav-item dropdown">
                  <a class="prof-button nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    {{ Illuminate\Support\Facades\Auth::user()->name }}
                  </a>
                  <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                      <li>
                          <a class="dropdown-item d-flex align-items-center gap-3" href="/profile">
                              <i class="fa fa-user fs-5 text-muted"></i>
                              <span>Profila</span>
                          </a>
                      </li>
                      <li>
                        <a class="dropdown-item d-flex align-items-center gap-3" href="/gogokoa">
                            <i class="fa fa-heart fs-5 text-muted"></i>
                            <span>Gogokoak</span>
                        </a>
                    </li>
                      @if (Illuminate\Support\Facades\Auth::user()->rol === 1)
                        <li>
                            <a class="dropdown-item d-flex align-items-center gap-3" href="/admin">
                                <i class="fa fa-cog fs-5 text-muted"></i>
                                <span>Admin</span>
                            </a>
                        </li>
                      @endif
                      <li>
                          <a class="dropdown-item d-flex align-items-center gap-3" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                              <i class="fa fa-sign-out fs-5 text-muted"></i>
                              <span>Saioa itxi</span>
                          </a>
                      </li>
                      <li>
                          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                              @csrf
                          </form>
                      </li>
                  </ul>
              </div>
              @endguest
              
          </div>
      </div>
  </div>
</nav>