
<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.layout_admin.headonly')
    @yield('css')
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    @include('admin.layout_admin.sidebar')
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      @yield('content')
      <!-- Footer -->
      @include('admin.layout_admin.footer')
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  @include('admin.layout_admin.script')
</body>

</html>