<header class="main-header">
    <nav class="navbar navbar-static-top">
        <div class="container">
            <div class="navbar-header">
              <a href="/home" class="navbar-brand"><b>SI</b>PAKAR</a>
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                <i class="fa fa-bars"></i>
              </button>
            </div>
            <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                <ul class="nav navbar-nav">
                    <li class="@yield('home')"><a href="/home">Dashboard <span class="sr-only">(current)</span></a></li>
                    <li class="@yield('pasiens')"><a href="/pasien">Pasien</a></li>
                    <li class="@yield('gejala')"><a href="/gejala">Gejala</a></li>
                    <li class="@yield('penyakit')"><a href="/penyakit">Penyakit</a></li>
                    <li class="@yield('solusi')"><a href="/solusi">Solusi</a></li>
                    <li class="@yield('diagnosis')"><a href="/diagnosis">Diagnosis</a></li>
                    <li class="@yield('report')"><a href="/laporan">Laporan</a></li>
                </ul>
            </div>
            <div class="navbar-custom-menu">
                <ul class="nav navbar-nav">
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <img src="/assets/dist/img/user2-160x160.jpg" class="user-image" alt="User Image">
                            <span class="hidden-xs">{{Auth::user()->nama}}</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="user-header">
                                <img src="/assets/dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
                                <p>
                                    {{Auth::user()->nama}}
                                </p>
                            </li>
                            <li class="user-footer">
                                <div class="pull-right">
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-default btn-flat">Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>