<style>
    .nav-item.active .nav-link {
    color: #fff;
    background-color: #233766;
}

.collapse-item.active {
  color: #007bff; /* Change the color to blue */
  font-weight: bold; /* Make the text bold */
}

.bg-gradient-info {
    background-color: #132644 !important;
    background-size: cover;
}
.sidebar.toggled .sidebar-logo2 {
        display: block !important;
    }
    .sidebar.toggled .sidebar-logo1 {
        display: none;
    }

</style>  

<ul class="text navbar-nav bg-gradient-info sidebar sidebar-dark accordion toggled" id="accordionSidebar">
    
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{route('admin')}}">
      <img src="{{ asset('images/Group.png') }}" atl="virtuouscarat-logo" id="fullLogo" class="sidebar-logo1">
      <img src="{{ asset('images/vs.png') }}" atl="virtuouscarat-logo" id="smallLogo" class="sidebar-logo2 d-none">
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('admin') }}">
        <i class="fas fa-fw fa-tachometer-alt"></i>
        <span>Dashboard</span>
      </a>
    </li>


    {{-- Products --}}
    <li class="nav-item {{ request()->routeIs('product.index') ? 'active' : '' }}">
      <a class="nav-link collapsed" href="{{route('product.index')}}">
        <i class="fas fa-cubes"></i>
        <span>Products</span>
      </a>
  </li>

  

    <!--Orders -->
    <li class="nav-item {{ request()->routeIs('order.index') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('order.index') }}">
        <i class="fas fa-cart-plus"></i>
        <span>Orders</span>
      </a>
    </li>


 
 

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
     <!-- Heading -->
    <div class="sidebar-heading">
        General Settings
    </div>

     <!-- General settings -->
     <li class="nav-item {{ request()->routeIs('settings') ? 'active' : '' }}">
      <a class="nav-link" href="{{ route('settings') }}">
        <i class="fas fa-cog"></i>
        <span>Settings</span>
      </a>
    </li>

    <!-- Sidebar Toggler (Sidebar) -->
    {{-- <div class="text-center d-none d-md-inline">
      <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div> --}}

</ul>


