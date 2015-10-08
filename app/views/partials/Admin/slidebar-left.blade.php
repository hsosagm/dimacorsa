<aside id="sidebar-left" class="sidebar-circle">

    <div class="sidebar-content">
        <a href="javascript:void(0);" class="close">&times;</a>
        <div class="media">
            <div class="media-body">
                <h4 class="media-heading"><span>
                    {{$tienda->nombre}}
                </span></h4>
                <small>Tecnologia Moderna</small>
            </div>
        </div>
    </div>

    <ul class="sidebar-menu">

        <li class="active home">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-home"></i></span>
                <span class="text">Dashboard</span>
                <span class="selected"></span>
            </a>
        </li>

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

        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-columns"></i></span>
                <span class="text">Cierre</span>
                <span class="plus"></span>
            </a>
            <ul>
                <li><a href="javascript:void(0);" id="CierreDelDia">Movimientos del dia</a></li>
                <li><a href="javascript:void(0);" onClick="cierre();">Realizar Corte</a></li>
                <li><a href="javascript:void(0);" onClick="CierresDelMes();">Movimientos por fecha</a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-columns"></i></span>
                <span class="text">Configuracion</span>
                <span class="plus"></span>
            </a>
            <ul>
                <li onclick="configurar_impresoras()"><a href="javascript:void(0);">Impresoras</a></li>
                <li onclick="configurar_notificaciones()"><a href="javascript:void(0);">Notificaciones</a></li>
            </ul>
        </li>

    </ul>

    <div class="sidebar-footer hidden-xs hidden-sm hidden-md">
        <a class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Setting"><i class="fa fa-cog"></i></a>
        <a id="fullscreen" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Fullscreen"><i class="fa fa-desktop"></i></a>
        <a class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Lock Screen"><i class="fa fa-lock"></i></a>
        <a class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Logout"><i class="fa fa-power-off"></i></a>
    </div>

</aside>
