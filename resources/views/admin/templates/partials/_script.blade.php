
<!-- jQuery -->
<script src="{{ asset('asset/plugins/jquery/jquery.min.js') }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset('asset/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{ asset('asset/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- ChartJS -->
<script src="{{ asset('asset/plugins/chart.js/Chart.min.js') }}"></script>
<!-- Sparkline -->
<script src="{{ asset('asset/plugins/sparklines/sparkline.js') }}"></script>
<!-- JQVMap -->
<script src="{{ asset('asset/plugins/jqvmap/jquery.vmap.min.js') }}"></script>
<script src="{{ asset('asset/plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>
<!-- jQuery Knob Chart -->
<script src="{{ asset('asset/plugins/jquery-knob/jquery.knob.min.js') }}"></script>
<!-- daterangepicker -->
<script src="{{ asset('asset/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('asset/plugins/daterangepicker/daterangepicker.js') }}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{ asset('asset/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('asset/plugins/summernote/summernote-bs4.min.js') }}"></script>
<!-- overlayScrollbars -->
<script src="{{ asset('asset/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('asset/dist/js/adminlte.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('asset/dist/js/demo.js') }}"></script>

<!-- AdminLTE dashboard demo (Only load on dashboard page) -->
@if(request()->routeIs('admin.dashboard') || request()->is('admin') || request()->is('admin/dashboard'))
<script src="{{ asset('asset/dist/js/pages/dashboard.js') }}"></script>
@endif

<!-- Sidebar Fix Script -->
<script>
$(document).ready(function() {
    // Initialize sidebar
    initSidebar();
    setActiveMenu();
    
    function initSidebar() {
        // Handle hamburger menu toggle
        $('[data-widget="pushmenu"]').off('click.pushmenu').on('click.pushmenu', function(e) {
            e.preventDefault();
            e.stopPropagation();
            $('body').toggleClass('sidebar-collapse');
        });
        
        // Handle treeview menu
        $('.nav-sidebar .nav-item > .nav-link').off('click.treeview').on('click.treeview', function(e) {
            var $this = $(this);
            var $parent = $this.parent();
            var $treeview = $parent.find('> .nav-treeview');
            
            // If this item has children
            if ($treeview.length > 0) {
                e.preventDefault();
                e.stopPropagation();
                
                // Close other open items at same level
                $parent.siblings('.nav-item').removeClass('menu-open').find('> .nav-treeview').slideUp(300);
                
                // Toggle current item
                if ($parent.hasClass('menu-open')) {
                    $parent.removeClass('menu-open');
                    $treeview.slideUp(300);
                } else {
                    $parent.addClass('menu-open');
                    $treeview.slideDown(300);
                }
            }
        });
        
        // Handle nested treeview (level 2)
        $('.nav-treeview .nav-item > .nav-link').off('click.nestedtreeview').on('click.nestedtreeview', function(e) {
            var $this = $(this);
            var $parent = $this.parent();
            var $nestedTreeview = $parent.find('> .nav-treeview');
            
            if ($nestedTreeview.length > 0) {
                e.preventDefault();
                e.stopPropagation();
                
                // Close other nested items
                $parent.siblings('.nav-item').removeClass('menu-open').find('> .nav-treeview').slideUp(300);
                
                // Toggle current nested item
                if ($parent.hasClass('menu-open')) {
                    $parent.removeClass('menu-open');
                    $nestedTreeview.slideUp(300);
                } else {
                    $parent.addClass('menu-open');
                    $nestedTreeview.slideDown(300);
                }
            }
        });
        
        // Mobile handling
        handleMobileLayout();
        $(window).resize(handleMobileLayout);
        
        // Click outside to close on mobile
        $(document).off('click.sidebar').on('click.sidebar', function(e) {
            if ($(window).width() < 992) {
                if (!$(e.target).closest('.main-sidebar, [data-widget="pushmenu"]').length) {
                    $('body').addClass('sidebar-collapse');
                }
            }
        });
    }
    
    function setActiveMenu() {
        var currentUrl = window.location.pathname;
        var found = false;
        
        // First, check if any menu item already has 'active' class from Laravel
        var $existingActive = $('.nav-sidebar .nav-link.active');
        if ($existingActive.length > 0) {
            // Laravel has already set the active menu, respect it
            $existingActive.each(function() {
                var $link = $(this);
                var $parent = $link.closest('.nav-item');
                var $parentTreeview = $parent.closest('.nav-treeview');
                
                // If this is a submenu item, open its parent
                if ($parentTreeview.length > 0) {
                    $parentTreeview.show();
                    $parentTreeview.closest('.nav-item').addClass('menu-open');
                    
                    // If this is a nested submenu, open grandparent too
                    var $grandParentTreeview = $parentTreeview.closest('.nav-item').closest('.nav-treeview');
                    if ($grandParentTreeview.length > 0) {
                        $grandParentTreeview.show();
                        $grandParentTreeview.closest('.nav-item').addClass('menu-open');
                    }
                }
            });
            return; // Exit early, Laravel has handled the active state
        }
        
        // Only if Laravel hasn't set active class, then do JavaScript matching
        // Remove all active classes first
        $('.nav-sidebar .nav-link').removeClass('active current-page');
        $('.nav-item').removeClass('menu-open');
        $('.nav-treeview').hide();
        
        // Check each menu link for exact match first
        $('.nav-sidebar a[href]').each(function() {
            var $link = $(this);
            var href = $link.attr('href');
            
            // Skip # links
            if (href === '#' || href === '') return;
            
            // Get the path from href
            var linkPath = '';
            try {
                if (href.startsWith('http')) {
                    linkPath = new URL(href).pathname;
                } else {
                    linkPath = href;
                }
            } catch (e) {
                linkPath = href;
            }
            
            // Check for exact match
            if (currentUrl === linkPath) {
                // Mark as current page
                $link.addClass('active current-page');
                found = true;
                
                // Open parent menus
                var $parent = $link.closest('.nav-item');
                var $parentTreeview = $parent.closest('.nav-treeview');
                
                // If this is a submenu item
                if ($parentTreeview.length > 0) {
                    $parentTreeview.show();
                    $parentTreeview.closest('.nav-item').addClass('menu-open');
                    
                    // If this is a nested submenu
                    var $grandParentTreeview = $parentTreeview.closest('.nav-item').closest('.nav-treeview');
                    if ($grandParentTreeview.length > 0) {
                        $grandParentTreeview.show();
                        $grandParentTreeview.closest('.nav-item').addClass('menu-open');
                    }
                }
                
                return false; // Break the loop
            }
        });
        
        // If no exact match found, try partial matching with better logic
        if (!found) {
            var bestMatch = null;
            var bestMatchLength = 0;
            
            $('.nav-sidebar a[href]').each(function() {
                var $link = $(this);
                var href = $link.attr('href');
                
                if (href === '#' || href === '') return;
                
                var linkPath = '';
                try {
                    if (href.startsWith('http')) {
                        linkPath = new URL(href).pathname;
                    } else {
                        linkPath = href;
                    }
                } catch (e) {
                    linkPath = href;
                }
                
                // Check if current URL starts with link path and is longer than previous matches
                if (linkPath !== '/' && currentUrl.startsWith(linkPath) && linkPath.length > bestMatchLength) {
                    bestMatch = $link;
                    bestMatchLength = linkPath.length;
                }
            });
            
            if (bestMatch) {
                bestMatch.addClass('active');
                
                // Open parent menus
                var $parent = bestMatch.closest('.nav-item');
                var $parentTreeview = $parent.closest('.nav-treeview');
                
                if ($parentTreeview.length > 0) {
                    $parentTreeview.show();
                    $parentTreeview.closest('.nav-item').addClass('menu-open');
                    
                    var $grandParentTreeview = $parentTreeview.closest('.nav-item').closest('.nav-treeview');
                    if ($grandParentTreeview.length > 0) {
                        $grandParentTreeview.show();
                        $grandParentTreeview.closest('.nav-item').addClass('menu-open');
                    }
                }
            }
        }
    }
    
    function handleMobileLayout() {
        if ($(window).width() < 992) {
            $('body').addClass('sidebar-collapse');
        }
    }
    
    // Ensure AdminLTE fullscreen widget works
    $('[data-widget="fullscreen"]').off('click.fullscreen').on('click.fullscreen', function(e) {
        e.preventDefault();
        if (document.fullscreenElement) {
            document.exitFullscreen();
        } else {
            document.documentElement.requestFullscreen();
        }
    });
});
</script>

<!-- DataTables  & Plugins -->
<script src="{{ asset('asset/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('asset/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('asset/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('asset/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('asset/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>

<!-- DataTable -->
<script href="https://cdn.datatables.net/select/1.3.1/js/dataTables.select.min.js"></script>

<!-- Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0/dist/js/select2.min.js"></script>

<!-- Custom Scripts Stack -->
@stack('scripts')