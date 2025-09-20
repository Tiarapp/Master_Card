<head>
  <meta charset="utf-8">
  <link rel="stylesheet" href="{{ asset('asset/plugins/summernote/summernote-bs4.min.css') }}">

  <!-- Select2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/css/select2.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.5.2/dist/select2-bootstrap4.min.css" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  {{-- <title>AdminLTE 3 | Dashboard</title> --}}


  <title>{{ config('app.name', 'Master Card') }}</title>
  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

  <!-- Styles -->
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <link rel="icon" href="{{ asset('images/logo spa 1.png') }}" type="image/icon type">


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/fontawesome-free/css/all.min.css') }}">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">

  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">
  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/jqvmap/jqvmap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('asset/dist/css/adminlte.min.css') }}">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/daterangepicker/daterangepicker.css') }}">
  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/summernote/summernote-bs4.min.css') }}">

  <!-- DataTable -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('asset/plugins/fontawesome-free/css/all.min.css') }}">

  <link rel="stylesheet" href="{{ asset('asset/plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('asset/dist/css/adminlte.min.css') }}">
  <link rel="stylesheet" href="{{ asset('asset/css/style.css') }}">


  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
  <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.6.5/css/buttons.dataTables.min.css">

  <!-- Custom CSS for sidebar fix -->
  <style>
    /* Ensure proper sidebar positioning */
    .main-sidebar {
      position: fixed !important;
      top: 0;
      left: 0;
      z-index: 1050;
      height: 100vh;
      overflow-y: auto;
      width: 250px;
      transition: margin-left 0.3s ease-in-out;
    }
    
    /* Content wrapper positioning */
    .content-wrapper {
      margin-left: 250px;
      transition: margin-left 0.3s ease-in-out;
      min-height: 100vh;
    }
    
    /* Main header positioning */
    .main-header {
      margin-left: 250px;
      transition: margin-left 0.3s ease-in-out;
    }
    
    /* Sidebar collapsed state */
    .sidebar-collapse .main-sidebar {
      margin-left: -250px;
    }
    
    .sidebar-collapse .content-wrapper {
      margin-left: 0;
    }
    
    .sidebar-collapse .main-header {
      margin-left: 0;
    }
    
    /* Mobile responsive */
    @media (max-width: 991.98px) {
      .main-sidebar {
        margin-left: -250px;
      }
      
      .content-wrapper {
        margin-left: 0 !important;
      }
      
      .main-header {
        margin-left: 0 !important;
      }
      
      body:not(.sidebar-collapse) .main-sidebar {
        margin-left: 0;
        box-shadow: 0 0 10px rgba(0,0,0,0.5);
      }
    }
    
    /* Sidebar menu styling */
    .nav-sidebar .nav-item .nav-link {
      cursor: pointer;
      padding: 0.5rem 1rem;
      color: rgba(255,255,255,.8);
      border-radius: 0.25rem;
      margin: 0.125rem 0.5rem;
    }
    
    .nav-sidebar .nav-item .nav-link:hover {
      background-color: rgba(255,255,255,.1);
      color: #fff;
    }
    
    /* Parent menu styling */
    .nav-sidebar > .nav-item > .nav-link {
      font-weight: 600;
      font-size: 0.875rem;
      padding: 0.75rem 1rem;
    }
    
    .nav-sidebar > .nav-item > .nav-link .nav-icon {
      font-size: 1rem;
      margin-right: 0.5rem;
      width: 1.5rem;
      text-align: center;
    }
    
    /* First level child (submenu) styling */
    .nav-treeview > .nav-item > .nav-link {
      padding: 0.5rem 1rem 0.5rem 2.5rem;
      font-size: 0.8125rem;
      color: rgba(255,255,255,.7);
    }
    
    .nav-treeview > .nav-item > .nav-link .nav-icon {
      font-size: 0.875rem;
      margin-right: 0.5rem;
      width: 1rem;
      text-align: center;
    }
    
    /* Second level child (nested submenu) styling */
    .nav-treeview .nav-treeview > .nav-item > .nav-link {
      padding: 0.375rem 1rem 0.375rem 4rem;
      font-size: 0.75rem;
      color: rgba(255,255,255,.6);
      position: relative;
    }
    
    .nav-treeview .nav-treeview > .nav-item > .nav-link::before {
      content: "›";
      position: absolute;
      left: 3rem;
      color: rgba(255,255,255,.4);
    }
    
    .nav-treeview .nav-treeview > .nav-item > .nav-link .nav-icon {
      font-size: 0.75rem;
      margin-right: 0.5rem;
      width: 0.875rem;
    }
    
    /* Treeview menu styling */
    .nav-treeview {
      display: none;
      background-color: rgba(0,0,0,.1);
      border-radius: 0.25rem;
      margin: 0.125rem 0.5rem;
    }
    
    .nav-item.menu-open > .nav-treeview {
      display: block;
      animation: slideDown 0.3s ease-out;
    }
    
    @keyframes slideDown {
      from {
        opacity: 0;
        max-height: 0;
      }
      to {
        opacity: 1;
        max-height: 500px;
      }
    }
    
    /* Active menu states */
    .nav-sidebar .nav-item .nav-link.active {
      background-color: #007bff !important;
      color: #fff !important;
      box-shadow: 0 2px 4px rgba(0,123,255,.3);
    }
    
    /* Parent menu open indicator */
    .nav-item.menu-open > .nav-link {
      background-color: rgba(255,255,255,.05);
      color: #fff;
    }
    
    .nav-item.menu-open > .nav-link .right {
      transform: rotate(-90deg);
      transition: transform 0.3s ease;
    }
    
    .nav-item > .nav-link .right {
      transition: transform 0.3s ease;
    }
    
    /* Hover effects with different intensity */
    .nav-sidebar > .nav-item > .nav-link:hover {
      background-color: rgba(255,255,255,.15);
      transform: translateX(2px);
      transition: all 0.2s ease;
    }
    
    .nav-treeview > .nav-item > .nav-link:hover {
      background-color: rgba(255,255,255,.1);
      color: rgba(255,255,255,.9);
      padding-left: 2.75rem;
      transition: all 0.2s ease;
    }
    
    .nav-treeview .nav-treeview > .nav-item > .nav-link:hover {
      background-color: rgba(255,255,255,.08);
      color: rgba(255,255,255,.8);
      padding-left: 4.25rem;
      transition: all 0.2s ease;
    }
    
    /* Icon colors for different levels */
    .nav-sidebar > .nav-item > .nav-link .nav-icon {
      color: #ffc107;
    }
    
    .nav-treeview > .nav-item > .nav-link .nav-icon {
      color: #17a2b8;
    }
    
    .nav-treeview .nav-treeview > .nav-item > .nav-link .nav-icon {
      color: #6c757d;
    }
    
    /* Current page indicator */
    .nav-link.current-page {
      background-color: #28a745 !important;
      color: #fff !important;
      font-weight: 600;
    }
    
    .nav-link.current-page::after {
      content: "";
      position: absolute;
      right: 1rem;
      top: 50%;
      transform: translateY(-50%);
      width: 4px;
      height: 4px;
      background-color: #fff;
      border-radius: 50%;
    }
    
    /* Ensure sidebar is always visible when not collapsed */
    body:not(.sidebar-collapse) .main-sidebar {
      margin-left: 0;
    }
    
    /* Fix for pushmenu button */
    [data-widget="pushmenu"] {
      cursor: pointer;
    }
    
    /* Loading state prevention */
    .nav-sidebar * {
      -webkit-user-select: none;
      -moz-user-select: none;
      -ms-user-select: none;
      user-select: none;
    }
  </style>
</head>