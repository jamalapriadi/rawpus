<div class="sidebar">
    <div class="brand">
        <a href="{{URL::to('home')}}">
            <img src="{{URL::asset('klorofil/img/logo.png')}}" alt="Klorofil Logo" class="img-responsive logo">
        </a>
    </div>
    <div class="sidebar-scroll">
        <nav>
            <ul class="nav">
                <li><a href="{{URL::to('home')}}" class="{{ Request::path() == 'home' ? 'active' : '' }}"><i class="lnr lnr-home"></i> <span>Dashboard</span></a></li>
                
                <li>
                    <a href="#subUser" data-toggle="collapse" class="collapsed"><i class="icon-users"></i> <span>Users</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                    <div id="subUser" class="collapse ">
                        <ul class="nav">
                            <li><a href="{{URL::to('home/user')}}" class="{{ Request::path() == 'home/user' ? 'active' : '' }}">User</a></li>
                            <li><a href="{{URL::to('home/role')}}" class="{{ Request::path() == 'home/role' ? 'active' : '' }}">Role</a></li>
                        </ul>
                    </div>
                </li>
            </ul>
        </nav>
    </div>
</div>