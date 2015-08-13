<!-- comienzo categoria  Administrador -->
<li class="sidebar-category">
    <span>ADMIN</span>
    <span class="pull-right"><i class="fa fa-code"></i></span>
</li>

<!-- comienza menu consultas-->
<li class="submenu">
    <a href="javascript:void(0);">
        <span class="icon"><i class="fa fa-cube"></i></span>
        <span class="text">Consultas</span>
        <span class="plus"></span>
    </a>
    <ul>
        <li onclick="getMasterQueries(this)"><a href="javascript:void(0);">Queries</a></li>
        <li onclick="getTrasladosEnviados(this)"><a href="javascript:void(0);">Traslados Enviados</a></li>
        <li onclick="getTrasladosRecibidos(this)"><a href="javascript:void(0);">Traslados Recibidos</a></li>
        <li id="users_list"><a href="javascript:void(0);">Usuarios</a></li>
    </ul>
</li>
<!-- fin menu consultas-->

<!-- Inicio menu operaciones -->
<li class="submenu">
    <a href="javascript:void(0);">
        <span class="icon"><i class="fa fa-columns"></i></span>
        <span class="text">Operaciones</span>
        <span class="plus"></span>
    </a>
    <ul>
        <li><a href="javascript:void(0);" onclick="f_soporte()">Soporte</a></li>
        <li><a href="javascript:void(0);" onclick="f_gastos()">Gastos</a></li>
        <li><a href="javascript:void(0);" onclick="f_egreso()">Egresos</a></li>
        <li><a href="javascript:void(0);" onclick="f_ingreso()">Ingresos</a></li>
        <li><a href="javascript:void(0);" onclick="f_adelanto()">Adelantos</a></li>
        <li><a href="javascript:void(0);" onclick="inventario()">Ajuste de inventario</a></li>
        {{-- <li><a href="javascript:void(0);" onclick="imprimirFactura('EPSON-LQ-590')">imprimir Factura</a></li> --}}
    </ul>
</li>
<!-- Fin menu operaciones -->

<!-- inicio menu Cierre -->
<li class="submenu">
    <a href="javascript:void(0);">
        <span class="icon"><i class="fa fa-columns"></i></span>
        <span class="text">Cierre</span>
        <span class="plus"></span>
    </a>
    <ul>
        <li><a href="javascript:void(0);" id="CierreDelDia">Movimientos del dia</a></li>
        <li><a href="javascript:void(0);" onClick="cierre();">Realizar Corte</a></li>
        <li><a href="javascript:void(0);" onClick="imprimir_cierre_por_fecha('current_date')">Imprimir Corte del dia</a></li>
        @if($slide_bar_left == 3)
            <li><a href="javascript:void(0);" onClick="CierreDelMes();">Balance General</a></li>
        @endif
            <li><a href="javascript:void(0);" onClick="CierreDelDiaPorFecha();">Corte del dia por fecha</a></li>
        @if($slide_bar_left == 3)
            <li><a href="javascript:void(0);" onClick="CierreDelMesPorFecha();">Balance general por fecha</a></li>
        @endif
        <li><a href="javascript:void(0);" onClick="CierresDelMes();">Cortes del mes</a></li>
    </ul>
</li>
<!-- fin menu Cierre -->

<li class="submenu">
    <a href="javascript:void(0);">
        <span class="icon"><i class="fa fa-columns"></i></span>
        <span class="text">Producto</span>
        <span class="plus"></span>
    </a>
    <ul>
        <li id="new_marca"><a href="javascript:void(0);">Crear Marca</a></li>
        <li id="new_categoria"><a href="javascript:void(0);">Crear Categoria</a></li>
        <li id="new_sub_categoria"><a href="javascript:void(0);">Crear Sub Categoria</a></li>
    </ul>
</li>

<li class="submenu">
    <a href="javascript:void(0);">
        <span class="icon"><i class="fa fa-columns"></i></span>
        <span class="text">Configuracion</span>
        <span class="plus"></span>
    </a>
    <ul>
        <li onclick="settings_barcode()"><a href="javascript:void(0);">Codigo de Barras</a></li>
        <li onclick="configurar_impresoras()"><a href="javascript:void(0);">Impresoras</a></li>
        <li onclick="configurar_notificaciones()"><a href="javascript:void(0);">Notificaciones</a></li>
    </ul>
</li>
<!--/ End development - components -->
