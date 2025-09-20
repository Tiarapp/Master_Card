<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/" class="nav-link">Home</a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="#" class="nav-link">Contact</a>
    </li>
  </ul>

  

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- User Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-user"></i> {{ Auth::user()->name }}
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </div>
    </li>
    
    @if (Auth::user()->divisi_id == 2)
    <!-- Notifications Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-bell"></i> Notifications 
        <span class="badge badge-danger" id="notificationCount">0</span>
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown" id="notificationList">
        <h6 class="dropdown-header">Notifications</h6>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('job.index') }}">
          <i class="fas fa-eye"></i> See All Notifications
        </a>
      </div>
    </li>
    @endif
    
    <!-- Fullscreen Button -->
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#" role="button">
        <i class="fas fa-th-large"></i>
      </a>
    </li>
  </ul>
</nav>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    fetchNotifications();

    function fetchNotifications() {
      fetch('/getnotif')
        .then(response => response.json())
        .then(data => {
          const notificationCount = document.getElementById('notificationCount');
          const notificationList = document.getElementById('notificationList');

          notificationCount.textContent = data.length;

          // Clear existing notifications except header and see all link
          const existingItems = notificationList.querySelectorAll('.notification-item');
          existingItems.forEach(item => item.remove());

          if (data.length === 0) {
            const noNotifItem = document.createElement('span');
            noNotifItem.className = 'dropdown-item-text notification-item';
            noNotifItem.textContent = 'No new notifications';
            // Insert before the divider
            const divider = notificationList.querySelector('.dropdown-divider');
            notificationList.insertBefore(noNotifItem, divider);
          } else {
            const divider = notificationList.querySelector('.dropdown-divider');
            data.forEach(notif => {
              const item = document.createElement('a');
              item.className = 'dropdown-item notification-item';
              item.href = '#';
              item.innerHTML = `
                <strong>${notif.kode}</strong><br>
                <small class="text-muted">${notif.pemohon}</small>
              `;
              notificationList.insertBefore(item, divider);
            });
          }
        })
        .catch(error => {
          console.error('Error fetching notifications:', error);
        });
    }

    // Refresh notifications every 30 seconds
    setInterval(fetchNotifications, 30000);
  });
</script>
<!-- /.navbar -->