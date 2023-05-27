<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>{{ config('app.name', 'Laravel') }}</title>

  {{-- BOOTSTRAP --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  
  {{-- BOOTSTRAP ICON --}}
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css" integrity="sha384-b6lVK+yci+bfDmaY1u0zE8YYJt0TZxLEAFyYSLHId4xoVvsrQu3INevFKo+Xir8e" crossorigin="anonymous">
  
  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

  {{-- DATATABLE --}}
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.2.0/css/bootstrap.min.css">

  {{-- BOXICON --}}
  <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
  
  {{-- TOASTR --}}
  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">

  <!-- SCRIPTS -->
  {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}

  <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />    
  @stack('styles')
</head>
<body id="body-pd">
  <div class="l-navbar" id="nav-bar">
      <nav class="nav">
          <div>
            <a href="{{ route('home') }}" class="nav_logo">
              <i class='bx bx-layer nav_logo-icon'></i>
              <span class="nav_logo-name">BELANJO</span>
            </a>
            <div class="nav_list">
              <a href="{{ route('home') }}" class="nav_link active">
                <i class='bx bx-grid-alt nav_icon'></i>
                <span class="nav_name">Home</span>
              </a>
              <a href="{{ route('setting') }}" class="nav_link">
                <i class='bx bx-user nav_icon'></i>
                <span class="nav_name">Setting</span>
              </a>
          </div> 
          <a href="{{ route('logout') }}" class="nav_link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            <i class='bx bx-log-out nav_icon'></i>
            <span class="nav_name">SignOut</span>
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
            @csrf
          </form>
      </nav>
  </div>

  <!--Container Main start-->
  <div class="main height-100">
      @yield('content')
  </div>
  <!--Container Main end-->

  {{-- JQUERY --}}
  <script src="https://code.jquery.com/jquery-3.5.1.js"></script>  
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
  <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
  
  {{-- BOOTSTRAP --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
  
  {{-- APEXCHART --}}
  <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
  <script>
      @if(Session::has('message'))
          toastr.options =
          {
              "closeButton" : true,
              "progressBar" : true,
              "positionClass": "toast-top-right",
          }
          toastr.success("{{ session('message') }}");
      @endif
  
      @if(Session::has('error'))
          toastr.options =
          {
              "closeButton" : true,
              "progressBar" : true,
              "positionClass": "toast-top-right",
          }
          toastr.error("{{ session('error') }}");
      @endif
  
      @if(Session::has('info'))
          toastr.options =
          {
              "closeButton" : true,
              "progressBar" : true,
              "positionClass": "toast-top-right",
          }
          toastr.info("{{ session('info') }}");
      @endif
  
      @if(Session::has('warning'))
          toastr.options =
          {
              "closeButton" : true,
              "progressBar" : true,
              "positionClass": "toast-top-right",
          }
          toastr.warning("{{ session('warning') }}");
      @endif
  </script>
  <script>
    const body = document.querySelector('#body-pd');
    const navbar = document.querySelector('#nav-bar');

    // show/hide navbar
    document.addEventListener('mousemove', function(event) {
      var cursorX = event.clientX;

      if (cursorX == 0) {
        navbar.classList.add('show-navbar');
      }

      if (cursorX > 224) {
        navbar.classList.remove('show-navbar');
      }
    });

    document.addEventListener("DOMContentLoaded", function(event) {

      const showNavbar = (toggleId, navId, bodyId, headerId) =>{
      const toggle = document.getElementById(toggleId),
      nav = document.getElementById(navId),
      bodypd = document.getElementById(bodyId),
      headerpd = document.getElementById(headerId)
      
      // Validate that all variables exist
      if (toggle && nav && bodypd && headerpd) {
        toggle.addEventListener('click', ()=>{
        // show navbar
        nav.classList.toggle('show-navbar')
        // change icon
        toggle.classList.toggle('bx-x')
        // add padding to body
        bodypd.classList.toggle('body-pd')
        // add padding to header
        headerpd.classList.toggle('body-pd')
        })
      }
    }
    
    showNavbar('header-toggle','nav-bar','body-pd','header')
    
    /*===== LINK ACTIVE =====*/
    const linkColor = document.querySelectorAll('.nav_link')
    
    function colorLink(){
      if (linkColor) {
        linkColor.forEach(l=> l.classList.remove('active'))
        this.classList.add('active')
      }
    }
    linkColor.forEach(l=> l.addEventListener('click', colorLink))
      // Your code to run since DOM is loaded and ready
    });
  </script>
  @stack('scripts')
</body>
</html>
