<!doctype html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>{{ config('app.name') }} - @yield('title')</title>
  @yield('meta')
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin_assets/images/favicon.png') }}">

  
  <link rel="stylesheet" href="{{asset('admin_assets/vendor/jqvmap/css/jqvmap.min.css')}}">
  <link rel="stylesheet" href="{{asset('admin_assets/css/style.css')}}">
  <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
  <!-- Not recommended: Disable integrity check -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" crossorigin="anonymous">
  <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha384-GLhlTQ8iGG9JhzCu8r+STmpOJT61S7GGD9xyA6z3fxi6gT2tYUyD4jC4QApB4EZh" crossorigin="anonymous"> -->




  @yield('head')
</head>

<body>
  <!--*******************
        Preloader start
    ********************-->
  <div id="preloader">
    <div class="sk-three-bounce">
      <div class="sk-child sk-bounce1"></div>
      <div class="sk-child sk-bounce2"></div>
      <div class="sk-child sk-bounce3"></div>
    </div>
  </div>
  <!--*******************
      Preloader end
  ********************-->


  <!--**********************************
      Main wrapper start
  ***********************************-->
  <div id="main-wrapper">

    <!--**********************************
          Nav header start
      ***********************************-->
    <div class="nav-header">
      <a href="/home" class="brand-logo">
        <img class="brand-title" src="{{asset('admin_assets/images/prayer.jpg')}}" alt="">
      </a>

      <div class="nav-control">
        <div class="hamburger">
          <span class="line"></span><span class="line"></span><span class="line"></span>
        </div>
      </div>
    </div>
    <!--**********************************
          Nav header end
      ***********************************-->
    <div>
      @include('admin.partials.sidebar')
      <div class="body-wrapper">
        @include('admin.partials.header')
        @yield('content')
      </div>
    </div>
  </div>

  <script src="{{asset('admin_assets/libs/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{asset('admin_assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('admin_assets/js/sidebarmenu.js')}}"></script>
  <script src="{{asset('admin_assets/js/app.min.js')}}"></script>
  <script src="{{asset('admin_assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
  <script src="{{asset('admin_assets/libs/simplebar/dist/simplebar.js')}}"></script>
  <script src="{{asset('admin_assets/js/dashboard.js')}}"></script>



  <!--**********************************
        Scripts
    ***********************************-->
  <!-- Required vendors -->
  <script src="{{asset('admin_assets/vendor/global/global.min.js')}}"></script>
  <script src="{{asset('admin_assets/js/quixnav-init.js')}}"></script>
  <script src="{{asset('admin_assets/js/custom.min.js')}}"></script>
  <script src="{{asset('admin_assets/js/dashboard/dashboard-1.js')}}"></script>

  @yield('scripts')
</body>

</html>