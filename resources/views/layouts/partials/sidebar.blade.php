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
                    <a href="#subMaster" data-toggle="collapse" class="collapsed"><i class="icon-book3"></i> <span>Master</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                    <div id="subMaster" class="collapse ">
                        <ul class="nav">
                            <li><a href="{{URL::to('home/status-ketenangaan')}}" class="{{ Request::path() == 'home/status-ketenangaan' ? 'active' : '' }}">Status Ketenagaan</a></li>
                            <li><a href="{{URL::to('home/jabatan')}}" class="{{ Request::path() == 'home/jabatan' ? 'active' : '' }}">Jabatan</a></li>
                            <li><a href="{{URL::to('home/diagnosa')}}" class="{{ Request::path() == 'home/diagnosa' ? 'active' : '' }}">Diagnosa</a></li>
                            <li><a href="{{URL::to('home/tenaga-medis')}}" class="{{ Request::path() == 'home/tenaga-medis' ? 'active' : '' }}">Tenaga Medis</a></li>
                            <li><a href="{{URL::to('home/pasien')}}" class="{{ Request::path() == 'home/pasien' ? 'active' : '' }}">Pasien</a></li>
                            <li><a href="{{URL::to('home/wilayah')}}" class="{{ Request::path() == 'home/wilayah' ? 'active' : '' }}">Wilayah</a></li>
                        </ul>
                    </div>
                </li>
                <li>
                    <a href="#subEntridata" data-toggle="collapse" class="collapsed"><i class="icon-profile"></i> <span>Entri Data</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                    <div id="subEntridata" class="collapse ">
                        <ul class="nav">
                            <li><a href="{{URL::to('home/pendaftaran-pasien')}}" class="{{ Request::path() == 'home/pendaftaran-pasien' ? 'active' : '' }}">Pendaftaran Pasien</a></li>
                            <li><a href="{{URL::to('home/pelayanan-pasien')}}" class="{{ Request::path() == 'home/pelayanan-pasien' ? 'active' : '' }}">Pelayanan Pasien</a></li>
                        </ul>
                    </div>
                </li>
                
                <li>
                    <a href="#subLihatdata" data-toggle="collapse" class="collapsed"><i class="icon-folder-search"></i> <span>Lihat Data</span> <i class="icon-submenu lnr lnr-chevron-left"></i></a>
                    <div id="subLihatdata" class="collapse ">
                        <ul class="nav">
                            <li><a href="{{URL::to('home/jumlah-peserta-terdaftar')}}" class="{{ Request::path() == 'home/jumlah-peserta-terdaftar' ? 'active' : '' }}">Jumlah Pasien Terdaftar</a></li>
                            <li><a href="{{URL::to('home/daftar-kunjungan-peserta-sakit')}}" class="{{ Request::path() == 'home/daftar-kunjungan-peserta-sakit' ? 'active' : '' }}">Daftar Kunjungan Peserta Sakit</a></li>
                            <li><a href="{{URL::to('home/daftar-kunjungan-peserta-sehat')}}" class="{{ Request::path() == 'home/daftar-kunjungan-peserta-sehat' ? 'active' : '' }}">Daftar Kunjungan Peserta Sehat</a></li>
                            <li><a href="{{URL::to('home/daftar-10-diagnosa-terbanyak')}}" class="{{ Request::path() == 'home/daftar-10-diagnosa-terbanyak' ? 'active' : '' }}">Daftar 10 Diagnosa Terbanyak</a></li>
                        </ul>
                    </div>
                </li>
                
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