<header id="header">
    <div class="header-left">
        <div class="navbar-minimize-mobile left">
            <i class="fa fa-bars"></i>
        </div>
        <div class="navbar-header" style="text-align:left !important">
            <a class="navbar-brand" href="javascript:void(0)">
                <img class="logo" src="img/logo/logo_empresa.png" alt="brand logo"/>
            </a>
        </div>
        <div class="navbar-minimize-mobile right">
            <i class="fa fa-cog"></i>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="header-right">
        <div class="navbar navbar-toolbar navbar-dark">
            <ul class="nav navbar-nav navbar-left">
                <li class="navbar-minimize">
                    <a href="javascript:void(0);" title="Minimize sidebar">
                        <i class="fa fa-bars"></i>
                    </a>
                </li>
                <!--Inicio searchHeader -->
                @include('partials.Controles.searchHeader')
                <!--Fin searchHeader -->
            </ul>
            <ul class="nav navbar-nav navbar-right">

                @if(Auth::user()->hasRole("Owner")||Auth::user()->hasRole("Admin"))
                    <li class="dropdown navbar-message">
                        <a  href="/" class="dropdown-toggle fg-theme" data-placement="bottom"  title="ERP"  data-toggle="tooltip">ERP</a>
                    </li>
                @endif

                <li class="dropdown navbar-message">
                    <a href="javascript:void(0)" class="dropdown-toggle f_ven_op" data-placement="bottom"  title="Venta" data-toggle="tooltip"><i class="fa fa-dollar"></i></a>
                </li>
                <li class="dropdown navbar-message">
                    <a href="javascript:void(0)" class="dropdown-toggle" onclick="f_coti_op()" data-placement="bottom"  title="Cotizacion" data-toggle="tooltip"><i class="fa fa-list-ol"></i></a>
                </li>
                <li class="dropdown navbar-message">
                    <a  href="javascript:void(0)" onclick="getInventario()" class="dropdown-toggle" data-placement="bottom"  title="Inventario"  data-toggle="tooltip"><i class="fa fa-list-alt"></i></a>
                </li>
                <li class="dropdown navbar-message">
                    <a  href="/cliente" class="dropdown-toggle"  data-placement="bottom"  title="Clientes"  data-toggle="tooltip"><i class="fa fa-users"></i></a>
                </li>

                <!--Inicio userOptionHeader -->
                @include('partials.Controles.userOptionHeader')
                <!--Fin userOptionHeader -->

                <li class="navbar-setting pull-right">
                    <a href="javascript:void(0);"><i class="fa fa-cog"></i></a>
                </li>
            </ul>
        </div>
    </div>
</header>
