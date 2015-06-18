<!-- Start category development -->
<li class="sidebar-category">
    <span>ADMINISTRADOR</span>
    <span class="pull-right"><i class="fa fa-code"></i></span>
</li>
<!--/ End category development -->

<li class="submenu">
        <a href="/proveedor" target="_blank">
            <span class="icon"><i class="fa fa-file-o"></i></span>
            <span class="text">Proveedor</span>
            <span class=""></span>
        </a>
    </li>

<!-- Start development - components -->
<li class="submenu">
    <a href="javascript:void(0);">
        <span class="icon"><i class="fa fa-cube"></i></span>
        <span class="text">Consultas</span>
        <span class="plus"></span>
    </a>
    <ul>
        <li id="Inv_dt_open"><a href="javascript:void(0);">Inventario</a></li>
        <li id="users_list"><a href="javascript:void(0);">Usuarios</a></li>
        <li id="proveedores"><a href="javascript:void(0);">Proveedores</a></li>
        <li id="clientes_table"><a href="javascript:void(0);">Clientes</a></li>


        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="text">Ventas</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li onclick="OpenTableSalesOfDay(this)"><a href="javascript:void(0);">Ventas del Dia</a></li>
                <li onclick="CreditSales(this)"><a href="javascript:void(0);">Ventas al credito</a></li>
                <li id="OpenTableSalesForDate"><a href="javascript:void(0);">Ventas por Fechas</a></li>
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
                <li id="OpenTablePurchaseForDate"><a href="javascript:void(0);">Compras por Fechas</a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="text">Soporte</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li id="OpenTableSupportDay"><a href="javascript:void(0);">Soporte del Dia</a></li>
                <li id="OpenTableSupportForDate"><a href="javascript:void(0);">Soporte por Fechas</a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="text">Gastos</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li id="OpenTableExpensesDay"><a href="javascript:void(0);">Gastos del Dia</a></li>
                <li id="OpenTableExpensesForDate"><a href="javascript:void(0);">Gastos por Fechas</a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="text">Egresos</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li id="OpenTableExpendituresDay"><a href="javascript:void(0);">Egresos del Dia</a></li>
                <li id="OpenTableExpendituresForDate"><a href="javascript:void(0);">Egresos por Fechas</a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="text">Ingresos</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li id="OpenTableIncomeDay"><a href="javascript:void(0);">Ingresos del Dia</a></li>
                <li id="OpenTableIncomeForDate"><a href="javascript:void(0);">Ingresos por Fechas</a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="text">Adelantos</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li id="OpenTableAdvancesDay"><a href="javascript:void(0);">Adelantos del Dia</a></li>
                <li id="OpenTableAdvancesForDate"><a href="javascript:void(0);">Adelantos por Fechas</a></li>
            </ul>
        </li>

        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="text">logs</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li id=""><a href="javascript:void(0);">Productos</a></li>
                <li id=""><a href="javascript:void(0);">Usuarios</a></li>
                <li id=""><a href="javascript:void(0);">Proveedores</a></li>
            </ul>
        </li>
    </ul>
</li>

<li class="submenu">
    <a href="javascript:void(0);">
        <span class="icon"><i class="fa fa-columns"></i></span>
        <span class="text">Cierre</span>
        <span class="plus"></span>
    </a>
    <ul>
        <li><a href="javascript:void(0);" id="CierreDelDia">Movimientos del dia</a></li>
        <li><a href="javascript:void(0);" onClick="cierre();">Realizar cierre</a></li>
        <li><a href="javascript:void(0);" onClick="imprimir_cierre();">Imprimir cierre del dia</a></li>
        <li><a href="javascript:void(0);" onClick="CierreDelMes();"> cierre del mes</a></li>
    </ul>
</li>

<li class="submenu">
    <a href="javascript:void(0);">
        <span class="icon"><i class="fa fa-columns"></i></span>
        <span class="text">Producto</span>
        <span class="plus"></span>
    </a>
    <ul>
        <li id="new_producto"><a href="javascript:void(0);">Crear Producto</a></li>
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