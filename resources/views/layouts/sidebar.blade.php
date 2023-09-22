
<nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-body-tertiary sidebar collapse">
    <div class="position-sticky pt-3 sidebar-sticky">
      <ul class="nav flex-column">
          @guest
          @else
          <li class="nav-item">
              <a class="nav-link " aria-current="page" href="#">
                <b>Welcome </b>{{ Auth::user()->name }} 
  
             
                
              </a>
            </li>
          @endguest
          @if(Auth::user()->role==1 ||   Auth::user()->role==2 || Auth::user()->role==3)

        <li class="nav-item">
          <a class="nav-link active" aria-current="page" href="/home">
            {{-- <span data-feather="home" class="align-text-bottom"></span> --}}
            <i class="fa fa-house p-2"></i>
            <b>Dashboard</b>
          </a>
        </li>
        @endif
        @if(Auth::user()->role==1)
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/users">
            {{-- <span data-feather="home" class="align-text-bottom"></span> --}}
            <i class="fa fa-user p-2"></i>
            Users
          </a>
        </li>
        @endif
        @if(Auth::user()->role==1 ||  Auth::user()->role==5 ||  Auth::user()->role==2)
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="/statistics">
            {{-- <span data-feather="home" class="align-text-bottom"></span> --}}
            <i class="fa fa-chart-pie p-2"></i>
            Statistics
          </a>
        </li>
        @endif

        <li class="nav-item">
          @guest
          @if (Route::has('login'))
            <a class="nav-link px-3" href="{{ route('login') }}">{{ __('Login') }}</a>
  
          @endif
  
          {{-- @if (Route::has('register'))
            <a class="nav-link px-3" href="{{ route('register') }}">{{ __('Register') }}</a>
  
          @endif --}}
      @else   
          <li class="nav-item dropdown">
              
           <a class="nav-link px-3" href="{{ route('logout') }}"
           onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
                                <i class="fa-solid fa-right-from-bracket mt-2" style="padding-left: 6px"></i>
                        <span style="margin-left: 5px">
                           {{ __('Logout') }}

                        </span> 
                        
                        </a>
  
  
           <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
               @csrf
           </form>
              <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">

                <a class="dropdown-item" href="{{ route('logout') }}"
                     onclick="event.preventDefault();
                                   document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                  </a>
  
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                      @csrf
                  </form>
              </div>
          </li>
      @endguest
  
        </li>
      </ul>        
    </div>
  </nav>