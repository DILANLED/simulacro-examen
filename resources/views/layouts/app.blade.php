<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Flexy Free Bootstrap Admin Template by WrapPixel</title>
  <link rel="shortcut icon" type="image/png" href="{{ asset('backend/assets/images/logos/favicon.png')}}" />
  <link rel="stylesheet" href="{{ asset('backend/assets/css/styles.min.css')}}" />
</head>

<body>
  <!--  Body Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!--  App Topstrip -->
    @include('layouts.navbar')

    <!-- Sidebar Start -->
    <aside class="left-sidebar">

      <!-- Sidebar scroll-->
      @include('layouts.sider')
      <!-- End Sidebar scroll-->

    </aside>
    <!--  Sidebar End -->

    <!--  Main wrapper -->
    <div class="body-wrapper">

      <div class="body-wrapper-inner">
        <div class="container-fluid">
          <!--  Row 1 -->
            @yield('content')
            
            @include('layouts.footer')
        </div>
      </div>
    </div>
  </div>
  <script src="{{ asset('backend/assets/libs/jquery/dist/jquery.min.js')}}"></script>
  <script src="{{ asset('backend/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{ asset('backend/assets/js/sidebarmenu.js')}}"></script>
  <script src="{{ asset('backend/assets/js/app.min.js')}}"></script>
  <script src="{{ asset('backend/assets/libs/apexcharts/dist/apexcharts.min.js')}}"></script>
  <script src="{{ asset('backend/assets/libs/simplebar/dist/simplebar.js')}}"></script>
  <script src="{{ asset('backend/assets/js/dashboard.js')}}"></script>
  <!-- solar icons -->
  <script src="https://cdn.jsdelivr.net/npm/iconify-icon@1.0.8/dist/iconify-icon.min.js"></script>
</body>

</html>