<aside id="sidebar-left" class="sidebar-circle">

    <!-- Start left navigation - profile shortcut -->
    <div class="sidebar-content">
        <a href="javascript:void(0);" class="close">&times;</a>
        <div class="media">
            <div class="media-body">
                <h4 class="media-heading">
                <span>
                    {{$tienda->nombre}}
                </span></h4>
            </div>
        </div>
    </div><!-- /.sidebar-content -->
    <!--/ End left navigation -  profile shortcut -->

    <!-- Start left navigation - menu -->
    <ul class="sidebar-menu">
        <li class="navbar-search">
                    <input id="ProviderFinder" type="text" class="form-control typeahead rounded" placeholder="Buscar Proveedor">
        </li>

        <!-- Start category Usuario-->
        <li v-show="proveedor_id" class="sidebar-category">
            <span>Proveedor</span>
            <span class="pull-right"><i class="fa fa-magic"></i></span>
            <span class="selected"></span
        </li>
        <!--/ End category Usuario-->

        <!-- Start navigation - clientes -->
        <li v-show="proveedor_id" class="submenu">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-file-o"></i></span>
                <span class="text">Consultas</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li><a href="javascript:void(0);" v-on="click: getHistorialCompras">Historial de compras</a></li>
                <li><a href="javascript:void(0);" v-on="click: getComprasPendientesDePago">Cuentas por pagar</a></li>
                <!-- <li><a href="javascript:void(0);" v-on="click: getHistorialPagos">Historial de pagos</a></li> -->
                <li><a href="javascript:void(0);" v-on="click: getHistorialAbonos"> Historial de abonos</a></li>
            </ul>
        </li>

        <li v-show="proveedor_id" class="submenu">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-file-o"></i></span>
                <span class="text">Operaciones</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li><a href="javascript:void(0);" v-on="click: getFormAbonos">Abonar a deuda</a></li>
                <li><a href="javascript:void(0);" v-on="click: getEditarProveedor">Editar Proveedor</a></li>
            </ul>
        </li>

        {{--<li v-show="proveedor_id" class="submenu">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-file-o"></i></span>
                <span class="text">Graficos</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li><a v-on="click: chartComprasPorProveedor" href="javascript:void(0);">Grafico de compras</a></li>
                <li><a v-on="click: chartComparativaPorMesPorProveedor" href="javascript:void(0);">Comparativa por mes</a></li>
            </ul>
        </li> --}}

        <li v-show="proveedor_id" class="submenu">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-money"></i></span>
                <span class="text">Estado de Cuenta</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li><a v-on="click: estadoDeCuenta(false)" href="javascript:void(0);">Exportar Excel</a></li>
                <li><a v-on="click: estadoDeCuenta(true)" href="javascript:void(0);">Exportar PDF</a></li>
            </ul>
        </li>

         <!--/ End navigation - clientes -->



    </ul><!-- /.sidebar-menu -->
    <!--/ End left navigation - menu -->

    <!-- Start left navigation - footer -->
    <div class="sidebar-footer hidden-xs hidden-sm hidden-md">
        <a class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Setting"><i class="fa fa-cog"></i></a>
        <a id="fullscreen" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Fullscreen"><i class="fa fa-desktop"></i></a>
        <a class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Lock Screen"><i class="fa fa-lock"></i></a>
        <a class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Logout"><i class="fa fa-power-off"></i></a>
    </div><!-- /.sidebar-footer -->
    <!--/ End left navigation - footer -->

</aside>
