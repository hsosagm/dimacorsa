<aside id="sidebar-left" class="sidebar-circle">

    <!-- Start left navigation - profile shortcut -->
    <div class="sidebar-content">
        <a href="javascript:void(0);" class="close">&times;</a>
        <div class="media">
            <div class="media-body">
                <h4 class="media-heading">
                <span>
                     <?php $tienda = Tienda::find(Auth::user()->tienda_id); ?>
                    {{$tienda->nombre}}
                </span></h4>
                <small>Tecnologia Moderna</small>
            </div>
        </div>
    </div><!-- /.sidebar-content -->
    <!--/ End left navigation -  profile shortcut -->

    <!-- Start left navigation - menu -->
    <ul class="sidebar-menu">
        <li class="navbar-search">           
                <form class="navbar-form" onsubmit=" return false">
                    <div class="form-group has-feedback">
                        <input id="BuscadorClientes" type="text" class="form-control typeahead rounded" placeholder="Buscar Proveedor">
                        <input type="hidden" name="cliente_id">
                    </div>
                </form>
        </li>

        <!-- Start category Usuario-->
        <li class="sidebar-category">
            <span>Cliente</span>
            <span class="pull-right"><i class="fa fa-magic"></i></span>
            <span class="selected"></span
        </li>
        <!--/ End category Usuario-->

        <!-- Start navigation - clientes -->
        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-file-o"></i></span>
                <span class="text">Consultas</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li><a href="javascript:void(0);" id=""> Historial de Ventas</a></li>
                <li><a href="javascript:void(0);" id=""> Ventas pendientes de pago</a></li>
                <li><a href="javascript:void(0);" id=""> Historial de pagos</a></li>
                <li><a href="javascript:void(0);" id=""> Historial de abonos</a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-file-o"></i></span>
                <span class="text">Operaciones</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li><a href="javascript:void(0);" id=""> Abonar Cliente</a></li>
                <li><a href="javascript:void(0);" id=""> Editar Cliente</a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-file-o"></i></span>
                <span class="text">Graficos</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li><a href="javascript:void(0);"> Ventas anuales</a></li>
                <li><a href="javascript:void(0);"> Ventas Mensuales</a></li>
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