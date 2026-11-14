<style>
  @media (max-width: 767.98px) {
    .main-header {
      min-height: 56px;
      padding: 0.25rem 0.5rem;
    }

    .main-header .navbar-nav .nav-link {
      padding: 0.5rem 0.5rem;
      font-size: 0.82rem;
    }

    .main-header .navbar-nav .nav-item {
      display: flex;
      align-items: center;
    }

    .main-header .navbar-nav .dropdown-menu {
      min-width: 220px;
      font-size: 0.85rem;
    }

    .main-header .badge {
      font-size: 0.6rem;
      padding: 0.28rem 0.4rem;
    }

    .main-header .nav-user-label {
      max-width: 120px;
      overflow: hidden;
      text-overflow: ellipsis;
      white-space: nowrap;
    }

    .main-header [data-widget="pushmenu"] {
      display: none;
    }
  }
</style>

<!-- Navbar -->
<nav class="main-header navbar navbar-expand navbar-white navbar-light">
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" data-widget="pushmenu" href="#" role="button" aria-label="Toggle sidebar"><i class="fas fa-bars"></i></a>
    </li>
    <li class="nav-item d-none d-sm-inline-block">
      <a href="/admin" class="nav-link">Home</a>
    </li>
  </ul>

  <!-- Right navbar links -->
  <ul class="navbar-nav ml-auto">
    <!-- User Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle nav-user-label" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-user"></i> {{ Auth::user()->name }}
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
        <h6 class="dropdown-header">{{ Auth::user()->name }}</h6>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('profile.index') }}">
          <i class="fas fa-user-circle"></i> Profile
        </a>
        <a class="dropdown-item" href="{{ route('profile.change-password') }}">
          <i class="fas fa-key"></i> Ubah Password
        </a>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
          <i class="fas fa-sign-out-alt"></i> Logout
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </div>
    </li>

    <!-- Notifications Dropdown -->
    <li class="nav-item dropdown">
      <a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-bell"></i>
        <span class="badge badge-danger" id="notificationCount">0</span>
      </a>
      <div class="dropdown-menu dropdown-menu-right" aria-labelledby="notificationDropdown" id="notificationList">
        <h6 class="dropdown-header">Notifications</h6>
        <span class="dropdown-item-text text-danger notification-error d-none">Sebagian notifikasi tidak dapat dimuat. Coba muat ulang halaman.</span>
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('job.index') }}">
          <i class="fas fa-eye"></i> See All Notifications
        </a>
      </div>
    </li>

    <!-- Fullscreen Button -->
    <li class="nav-item">
      <a class="nav-link" data-widget="fullscreen" href="#" role="button">
        <i class="fas fa-expand-arrows-alt"></i>
      </a>
    </li>
  </ul>
</nav>
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const notificationCount = document.getElementById('notificationCount');
    const notificationList = document.getElementById('notificationList');
    const canApproveDt = @json(in_array(Auth::user()->divisi_id, [2, 5]) && hasMenuAccess('ppic.dt_approval'));
    let contractCount = 0;
    let dtCount = 0;
    let contractAvailable = false;
    let dtAvailable = !canApproveDt;

    function renderSummary() {
      notificationCount.textContent = contractCount + dtCount;
      notificationCount.title = contractAvailable && dtAvailable ? '' : 'Sebagian notifikasi tidak dapat dimuat';
      notificationList.querySelector('.notification-error').classList.toggle('d-none', contractAvailable && dtAvailable);
      const empty = notificationList.querySelector('.notification-empty');
      if (empty) empty.remove();
      if (contractAvailable && dtAvailable && contractCount + dtCount === 0) {
        const item = document.createElement('span');
        item.className = 'dropdown-item-text notification-empty';
        item.textContent = 'No new notifications';
        notificationList.insertBefore(item, notificationList.querySelector('.dropdown-divider'));
      }
    }

    function fetchContractNotifications() {
      fetch(@json(route('notif.open')))
        .then(response => {
          if (!response.ok) throw new Error('HTTP ' + response.status);
          return response.json();
        })
        .then(data => {
          contractCount = data.length;
          contractAvailable = true;
          const existingItems = notificationList.querySelectorAll('.contract-notification');
          existingItems.forEach(item => item.remove());

          const divider = notificationList.querySelector('.dropdown-divider');
          data.forEach(notif => {
            const item = document.createElement('a');
            item.className = 'dropdown-item contract-notification';
            item.href = '#';
            const code = document.createElement('strong');
            code.textContent = notif.kode || '';
            const requester = document.createElement('small');
            requester.className = 'text-muted';
            requester.textContent = notif.pemohon || '';
            item.append(code, document.createElement('br'), requester);
            notificationList.insertBefore(item, divider);
          });
          renderSummary();
        })
        .catch(error => {
          contractAvailable = false;
          renderSummary();
          console.error('Error fetching notifications:', error);
        });
    }

    function fetchDtNotifications() {
      if (!canApproveDt) return;
      fetch(@json(route('notif.dt_approval')))
        .then(response => {
          if (!response.ok) throw new Error('HTTP ' + response.status);
          return response.json();
        })
        .then(data => {
          dtCount = data.count;
          dtAvailable = true;
          const previous = notificationList.querySelector('.dt-notification');
          if (previous) previous.remove();
          if (dtCount > 0) {
            const item = document.createElement('a');
            item.className = 'dropdown-item dt-notification';
            item.href = data.url;
            item.textContent = dtCount + ' OPI menunggu approval perubahan DT';
            notificationList.insertBefore(item, notificationList.querySelector('.dropdown-divider'));
          }
          renderSummary();
        })
        .catch(error => {
          dtAvailable = false;
          renderSummary();
          console.error('Error fetching DT approval notifications:', error);
        });
    }

    function refreshNotifications() {
      fetchContractNotifications();
      fetchDtNotifications();
    }

    refreshNotifications();
    setInterval(refreshNotifications, 30000);
  });
</script>
<!-- /.navbar -->
