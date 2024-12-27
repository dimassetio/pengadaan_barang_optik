<ul class="nav nav-secondary">
  <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
    <a href="{{ route('dashboard') }}" aria-expanded="false">
      <i class="fas fa-home"></i>
      <p>Dashboard</p>
    </a>
  </li>
  <li class="nav-section">
    <span class="sidebar-mini-icon">
      <i class="fa fa-ellipsis-h"></i>
    </span>
    <h4 class="text-section">Data</h4>
  </li>
  <li class="nav-item {{ request()->routeIs('pasien.*') ? 'active' : '' }}">
    <a href="{{ route('pasien.index') }}" aria-expanded="false">
      <i class="fa fa-user"></i>
      <p>Pasien</p>
    </a>
  </li>
  <li class="nav-item {{ request()->routeIs('pesanan.*') ? 'active' : '' }}">
    <a href="{{ route('pesanan.index') }}" aria-expanded="false">
      <i class="fa fa-shopping-cart"></i>
      <p>Pesanan</p>
    </a>
  </li>
  <li class="nav-item {{ request()->routeIs('frame.*') ? 'active' : '' }}">
    <a href="{{ route('frame.index') }}" aria-expanded="false">
      <i class="fa fa-glasses"></i>
      <p>Stok Frame</p>
    </a>
  </li>
  <li class="nav-item {{ request()->routeIs('lensa.*') ? 'active' : '' }}">
    <a href="{{ route('lensa.index') }}" aria-expanded="false">
      <i class="fa fa-circle"></i>
      <p>Stok Lensa</p>
    </a>
  </li>


  @if (auth()->user()->hasRole('owner'))
    <li class="nav-section">
      <span class="sidebar-mini-icon">
        <i class="fa fa-ellipsis-h"></i>
      </span>
      <h4 class="text-section">Menu Owner</h4>
    </li>
    <li class="nav-item {{ request()->routeIs('users.*') ? 'active' : '' }}">
      <a href="{{ route('users.index') }}" aria-expanded="false">
        <i class="fas fa-users"></i>
        <p>Users</p>
      </a>
    </li>
  @endif

</ul>
