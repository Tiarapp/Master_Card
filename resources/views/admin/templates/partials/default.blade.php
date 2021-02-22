<!DOCTYPE html>
<html lang="en">

@include('admin.templates.partials._head')

<body class="hold-transition sidebar-mini layout-fixed sidebar-collapse">
<div class="wrapper">

  @include('admin.templates.partials._navbar')

  @include('admin.templates.partials._sidebar')

  @yield('content')
  
  {{-- @include('admin.templates.partials._footer') --}}

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

@include('admin.templates.partials._script')

@yield('javascripts')
</body>
</html>
