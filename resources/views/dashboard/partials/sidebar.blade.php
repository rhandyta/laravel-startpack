
<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
      <div class="sidebar-brand">
        <a href="index.html">Stisla</a>
      </div>
      <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">St</a>
      </div>
      <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
          
        <li class="{{Request::segment(2) == NULL ? "active" : "" }}"><a class="nav-link" href="{{route("dashboard.index")}}"><i class="fas fa-car"></i> <span>Dashboard</span></a></li>
        
        
        <li class="menu-header">Starter</li>
        
        
        <li class="{{Request::segment(2) == "kendaraan" ? "active" : "" }}"><a class="nav-link" href="{{route("kendaraan.index")}}"><i class="fas fa-car"></i> <span>Kendaraan</span></a></li>
        
        
        <li class="menu-header">Starter</li>
        <li class="dropdown">
          <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Layout</span></a>
          <ul class="dropdown-menu">
            <li><a class="nav-link" href="layout-default.html">Default Layout</a></li>
            <li><a class="nav-link" href="layout-transparent.html">Transparent Sidebar</a></li>
            <li><a class="nav-link" href="layout-top-navigation.html">Top Navigation</a></li>
          </ul>
        </li>
        <li class=active><a class="nav-link" href="blank.html"><i class="far fa-square"></i> <span>Blank Page</span></a></li>
        
        <li><a class="nav-link" href="credits.html"><i class="fas fa-pencil-ruler"></i> <span>Credits</span></a></li>
        
      </ul>

      </aside>
  </div>