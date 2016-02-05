@if(Auth::user()->hasRole("Owner") || Auth::user()->hasRole("Admin") || Auth::user()->hasRole("User"))
    <aside id="sidebar-left" class="sidebar-circle">

        <!--Inicio titleSidebarLeft -->
        @include('partials.Controles.titleSidebarLeft')
        <!--Fin titleSidebarLeft -->

        <ul class="sidebar-menu">
            <!--Inicio titleDashboardSidebarLeft -->
            @include('partials.Controles.titleDashboardSidebarLeft')
            <!--Fin titleDashboardSidebarLeft -->

            <li class="sidebar-category">
                <span>USUARIO</span>
                <span class="pull-right"><i class="fa fa-code"></i></span>
            </li>
            <li class="submenu">
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-file-o"></i></span>
                    <span class="text">Consultas</span>
                    <span class="plus"></span>
                </a>
                <ul>
                    <li><a href="javascript:void(0);" onclick="VentasAlCreditoUsuario(this)">Ventas al credito </a></li>
                    <li><a href="javascript:void(0);" onclick="VerTablaVentasDelDiaUsuario(this,'dia')">Mis ventas del dia</a></li>
                    <li><a href="javascript:void(0);" onclick="misDevolucionesDelDia()">Mis devoluciones del dia</a></li>
                    <li><a href="javascript:void(0);" onclick="getMisCotizaciones(this)">Mis cotizaciones</a></li>
                    <li><a href="javascript:void(0);" onclick="getAdelantosAll(this)">Adelantos</a></li>
                    <li onclick="getConsultarSerie(this)"><a href="javascript:void(0);">Serie</a></li>
                </ul>
            </li>
            <li class="submenu">
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-columns"></i></span>
                    <span class="text">Operaciones</span>
                    <span class="plus"></span>
                </a>
                <ul>
                    <li><a href="javascript:void(0);" onclick="f_soporte(this)">Soporte</a></li>
                    <li><a href="javascript:void(0);" onclick="f_gastos(this)">Gastos</a></li>
                    <li><a href="javascript:void(0);" onclick="f_egreso(this)">Egresos</a></li>
                    <li><a href="javascript:void(0);" onclick="f_ingreso(this)">Ingresos</a></li>
                    <li><a href="javascript:void(0);" onclick="getFormSeleccionarTipoDeNotaDeCredito()">Generar nota de credito</a></li>
                </ul>
            </li>

            @if(Auth::user()->hasRole("Owner") || Auth::user()->hasRole("Admin"))
                <li class="sidebar-category">
                    <span>ADMIN</span>
                    <span class="pull-right"><i class="fa fa-code"></i></span>
                </li>
                <!--Inicio operaciones -->
                @include('partials.Controles.operaciones')
                <!--Fin operaciones -->

                <!--Inicio Consultas -->
                @include('partials.Controles.consultas')
                <!--Fin Consultas -->

                <!--Inicio Cierres -->
               @include('partials.Controles.cierres', array('opcion' => 'Owner'))
               <!--Fin Cierres -->

                <!--Inicio configuracion -->
               @include('partials.Controles.configuracion')
               <!--Fin configuracion -->

               @if(Auth::user()->hasRole("Owner"))

                    <li class="submenu">
                        <a href="javascript:void(0);">
                            <span class="icon"><i class="fa fa-bar-chart-o"></i></span>
                            <span class="text">Graficos</span>
                            <span class="plus"></span>
                        </a>
                        <ul>
                            <li>
                            <a id="graph_v" href="javascript:void(0);">
                                <span class="icon"><i class="fa fa-desktop"></i></span>
                                <span class="text">Ventas</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0);" onclick="comparativaMensual();">
                                <span class="icon"><i class="fa fa-desktop"></i></span>
                                <span class="text">Comparativa</span>
                            </a>
                        </li>

                        <li>
                            <a id="graph_g" href="javascript:void(0);">
                                <span class="icon"><i class="fa fa-group"></i></span>
                                <span class="text">Gastos</span>
                            </a>
                        </li>

                        <li>
                            <a id="graph_s" href="javascript:void(0);">
                                <span class="icon"><i class="fa fa-group"></i></span>
                                <span class="text">Soporte</span>
                            </a>
                        </li>
                        </ul>
                    </li>

                @endif
            @endif
        </ul>

        <!--Inicio footerSidebarLeft -->
        @include('partials.Controles.footerSidebarLeft')
        <!--Fin footerSidebarLeft -->
    </aside>
@endif