<aside id="sidebar-left" class="sidebar-circle">
    <!--Inicio titleSidebarLeft -->
    @include('partials.Controles.titleSidebarLeft')
    <!--Fin titleSidebarLeft -->

    <ul class="sidebar-menu">

        <!--Inicio titleDashboardSidebarLeft -->
        @include('partials.Controles.titleDashboardSidebarLeft')
        <!--Fin titleDashboardSidebarLeft -->

        <li class="sidebar-category">
            <span>Usuario</span>
            <span class="pull-right"><i class="fa fa-magic"></i></span>
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

                @if(count($caja))
                    <li><a href="javascript:void(0);" onclick="VentasSinFinalizar(this)">Ventas sin finalizar</a></li>
                @endif
                <li onclick="getConsultarSerie(this)"><a href="javascript:void(0);">Serie</a></li>
            </ul>
        </li>
        @if(count($caja))
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
                    {{-- <li><a href="javascript:void(0);" onclick="f_adelanto(this)">Adelanto</a></li> --}}
                </ul>
            </li>

             <li class="submenu">
                <a href="javascript:void(0);">
                    <span class="icon"><i class="fa fa-columns"></i></span>
                    <span class="text">Caja</span>
                    <span class="plus"></span>
                </a>
                <ul>
                    <li><a href="javascript:void(0);" onclick="getMovimientosDeCaja(this)">Movimientos de Caja</a></li>
                    <li><a href="javascript:void(0);" onclick="corteDeCaja(this)">Realizar corte</a></li>
                    <li><a href="javascript:void(0);" onclick="retirarEfectivoDeCaja(this)">Retirar Efectivo</a></li>
                </ul>
            </li>
        @endif
    </ul>

    <!--Inicio footerSidebarLeft -->
    @include('partials.Controles.footerSidebarLeft')
    <!--Fin footerSidebarLeft -->

</aside>
