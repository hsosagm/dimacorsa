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
        <li><a href="javascript:void(0);" id="f_soporte">Soporte</a></li>
        <li><a href="javascript:void(0);" id="f_gastos">Gastos</a></li>
        <li><a href="javascript:void(0);" id="f_egreso">Egresos</a></li>
        <li><a href="javascript:void(0);" id="f_ingreso">Ingresos</a></li>
        <li><a href="javascript:void(0);" id="f_adelanto">Adelantos</a></li>
        <li><a href="javascript:void(0);" onclick="imprimirFactura('EPSON-LQ-590')">imprimir Factura</a></li>
        <input type="button" onClick="printImage(true)" value="Print Barcode" /><br />
        <input type="button" onClick="printHTML5Page()" value="Print Barcode2" /><br />
        <input type="button" onClick="useDefaultPrinter()" value="Set Printer" /><br />
        <li><a href="javascript:void(0);" onclick="findPrinters()">Listar de impresoras</a></li>
    </ul>
</li>
<!-- Fin menu operaciones -->

<!-- inicio menu Informacion -->
{{-- <li class="submenu">
    <a href="javascript:void(0);">
        <span class="icon"><i class="fa fa-cube"></i></span>
        <span class="text">Informacion</span>
        <span class="plus"></span>
    </a>
    <ul>
        <li id="proveedores"><a href="javascript:void(0);">Proveedores</a></li>
        <li id="clientes_table"><a href="javascript:void(0);">Clientes</a></li>
    </ul>
</li> --}}
<!-- Fin menu Informacion -->

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
        <li><a href="javascript:void(0);" onClick="imprimir_cierre();">Imprimir Corte del dia</a></li>
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
        <span class="text">Codigo de Barras</span>
        <span class="plus"></span>
    </a>
    <ul>
        <li id="settings_barcode"><a href="javascript:void(0);">Configuracion</a></li>
    </ul>
</li>
<!--/ End development - components -->
