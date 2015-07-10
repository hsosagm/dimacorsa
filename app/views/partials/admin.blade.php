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
        <li id="users_list"><a href="javascript:void(0);">Usuarios</a></li>

        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="text">Ventas</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li onclick="OpenTableSalesOfDay(this)"><a href="javascript:void(0);">Ventas del Dia</a></li>
                <li onclick="CreditSales(this)"><a href="javascript:void(0);">Ventas al credito</a></li>
                <li onclick="OpenTableSalesForDate(this)"><a href="javascript:void(0);">Ventas por Fechas</a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="text">Compras</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li id="OpenTablePurchaseDay"><a href="javascript:void(0);">Compras del Dia</a></li>
                <li onclick="CreditPurchases(this)"><a href="javascript:void(0);">Compras al Credito</a></li>
                <li onclick="OpenTablePurchaseForDate(this)"><a href="javascript:void(0);">Compras por Fechas</a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="text">Descargas</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li onclick="OpenTableDownloadsDay(this)"><a href="javascript:void(0);">Descargas del Dia</a></li>
                <li onclick="OpenTableDownloadsForDate(this)"><a href="javascript:void(0);">Descargas por Fechas</a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="text">Abonos</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li onclick="AbonosDelDiaClientes(this)"><a href="javascript:void(0);">clientes del Dia</a></li>
                <li onclick="AbonosPorFechaClientes(this)"><a href="javascript:void(0);">clientes por Fechas</a></li>
                <li onclick="AbonosDelDiaProveedores(this)"><a href="javascript:void(0);">Proveedores del Dia</a></li>
                <li onclick="AbonosPorFechaProveedores(this)"><a href="javascript:void(0);">Proveedores por Fechas</a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="text">Soporte</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li id="OpenTableSupportDay"><a href="javascript:void(0);">Soporte del Dia</a></li>
                <li onclick="SoportePorFecha(this)"><a href="javascript:void(0);">Soporte por Fechas</a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="text">Gastos</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li id="OpenTableExpensesDay"><a href="javascript:void(0);">Gastos del Dia</a></li>
                <li onclick="GastosPorFecha(this)"><a href="javascript:void(0);">Gastos por Fechas</a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="text">Egresos</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li id="OpenTableExpendituresDay"><a href="javascript:void(0);">Egresos del Dia</a></li>
                <li onclick="EgresosPorFecha(this)"><a href="javascript:void(0);">Egresos por Fechas</a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="text">Ingresos</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li id="OpenTableIncomeDay"><a href="javascript:void(0);">Ingresos del Dia</a></li>
                <li onclick="IngresosPorFecha(this)"><a href="javascript:void(0);">Ingresos por Fechas</a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="text">Adelantos</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li id="OpenTableAdvancesDay"><a href="javascript:void(0);">Adelantos del Dia</a></li>
                <li onclick="AdelantosPorFecha(this)"><a href="javascript:void(0);">Adelantos por Fechas</a></li>
            </ul>
        </li>
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
        <li><a href="javascript:void(0);" id="CierreDelDia">Corte del dia</a></li>
        <li><a href="javascript:void(0);" onClick="cierre();">Realizar Corte</a></li>
        <li><a href="javascript:void(0);" onClick="imprimir_cierre();">Imprimir Corte del dia</a></li>
        @if($slide_bar_left == 3)
            <li><a href="javascript:void(0);" onClick="CierreDelMes();">Corte del mes</a></li>
        @endif
            <li><a href="javascript:void(0);" onClick="CierreDelDiaPorFecha();">Corte del dia por fecha</a></li>
        @if($slide_bar_left == 3)
            <li><a href="javascript:void(0);" onClick="CierreDelMesPorFecha();">Corte del mes por fecha</a></li>
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