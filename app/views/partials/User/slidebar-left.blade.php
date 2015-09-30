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
                <li><a href="javascript:void(0);" onclick="VentasAlCreditoUsuario(this)">Ventas al Credito </a></li>
                <li><a href="javascript:void(0);" onclick="VerTablaVentasDelDiaUsuario(this,'dia')">Mis Ventas del Dia</a></li>
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
                <li><a href="javascript:void(0);" onclick="f_adelanto(this)">Adelantos</a></li>
                <li><a href="javascript:void(0);" onclick="getFormSeleccionarTipoDeNotaDeCredito()">Generar nota de credito</a></li>

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