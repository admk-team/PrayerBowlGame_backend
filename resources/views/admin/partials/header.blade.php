<div class="nav-header">
    <a href="/home" class="brand-logo">
        <img class="brand-title" src="./admin_assets/images/prayer.jpg" alt="">
    </a>

  
</div>

<div class="header">
  <div class="header-content">
      <nav class="navbar navbar-expand">
          <div class="collapse navbar-collapse justify-content-between">
              <div class="header-left">
                  <div class="search_bar dropdown">
                      <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                          <i class="mdi mdi-magnify"></i>
                      </span>
                      <div class="dropdown-menu p-0 m-0">
                          <form>
                              <input class="form-control" type="search" placeholder="Search" aria-label="Search">
                          </form>
                      </div>
                  </div>
              </div>

              <ul class="navbar-nav header-right">
                 
                  <li class="nav-item dropdown header-profile">
                      <a class="nav-link" href="" role="button" data-toggle="dropdown">
                          <i class="mdi mdi-account"></i>
                      </a>
                      <div class="dropdown-menu dropdown-menu-right">
                       
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
              </ul>
          </div>
      </nav>
  </div>
</div>
<!--**********************************
  Header end ti-comment-alt
***********************************-->
