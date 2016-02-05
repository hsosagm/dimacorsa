@if(Auth::user()->hasRole("Owner") || Auth::user()->hasRole("Admin") || Auth::user()->hasRole("User"))
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

                    <!--Inicio header -->
                   
                    <li class="dropdown navbar-message">
                        <a href="javascript:void(0)" class="dropdown-toggle f_ven_op" data-placement="bottom"  title="Venta" data-toggle="tooltip"><i class="fa fa-dollar"></i></a>
                    </li>

                    @if(!Auth::user()->hasRole("Owner") && !Auth::user()->hasRole("Admin"))
                        <li class="dropdown navbar-message">
                            <a href="javascript:void(0)" class="dropdown-toggle" onclick="f_coti_op()" data-placement="bottom"  title="Cotizacion" data-toggle="tooltip"><i class="fa fa-list-ol"></i></a>
                        </li>
                    @endif

                    <li class="dropdown navbar-message">
                        <a  href="javascript:void(0)" onclick="getInventario()" class="dropdown-toggle" data-placement="bottom"  title="Inventario"  data-toggle="tooltip"><i class="fa fa-list-alt"></i></a>
                    </li>

                    <li class="dropdown navbar-message">
                        <a  href="/cliente" class="dropdown-toggle"  data-placement="bottom"  title="Clientes"  data-toggle="tooltip"><i class="fa fa-users"></i></a>
                    </li>

                    @if(Auth::user()->hasRole("Owner")||Auth::user()->hasRole("Admin"))
                        <li class="dropdown navbar-message">
                            <a  href="/proveedor" class="dropdown-toggle" data-placement="bottom"  title="Proveedores"  data-toggle="tooltip"><i class="fa fa-folder-open"></i></a>
                        </li>

                        <li class="dropdown navbar-message">
                            <a href="javascript:void(0)" onclick="chartVentasPorUsuario();" title="Graficas Ventas"><i class="fa fa-bar-chart-o"></i></a>
                    </li>
                    @endif 
                    <!--Fin header -->

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
@endif 