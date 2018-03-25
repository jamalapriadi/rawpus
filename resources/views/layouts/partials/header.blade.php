<nav class="navbar navbar-default">
                <div class="container-fluid">
                    <div class="navbar-btn">
                        <button type="button" class="btn-toggle-fullwidth"><i class="lnr lnr-arrow-left-circle"></i></button>
                    </div>
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-menu">
                            <span class="sr-only">Toggle Navigation</span>
                            <i class="fa fa-bars icon-nav"></i>
                        </button>
                    </div>
                    <div id="navbar-menu" class="navbar-collapse collapse">
                        <form class="navbar-form navbar-left hidden-xs">
                            <div class="input-group">
                                <input type="text" value="" class="form-control" placeholder="Search dashboard...">
                                <span class="input-group-btn"><button type="button" class="btn btn-primary">Go</button></span>
                            </div>
                        </form>
                        <ul class="nav navbar-nav navbar-right">
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" style="color:#222;">
                                    <img src="{{URL::asset('klorofil/img/user.png')}}" class="img-circle" alt="Avatar"> <span>{{\Auth::user()->name}}</span> <i class="icon-submenu lnr lnr-chevron-down"></i></a>
                                <ul class="dropdown-menu">
                                    <li><a href="#"><i class="lnr lnr-user"></i> <span>My Profile</span></a></li>
                                    <li><a href="{{URL::to('home/change-password')}}"><i class="lnr lnr-cog"></i> <span>Change Password</span></a></li>
                                    <li><a href="{{ route('logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="lnr lnr-exit"></i> <span>Logout</span></a></li>
                                </ul>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    {{ csrf_field() }}
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>