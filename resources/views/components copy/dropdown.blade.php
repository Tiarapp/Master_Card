@props(['active' => false])

<li class="nav-item {{ $active ? 'menu-open' : '' }}">
    <a href="#" class="nav-link {{ $active ? 'active' : '' }}">
        {{ $name }}
    </a>
    <ul class="nav nav-treeview">
        {{ $slot }}
    </ul>
</li>
