 <li class="submenu">
    <a href="javascript:void(0);">
        <span class="icon"><i class="fa fa-cube"></i></span>
        <span class="text">Consultas</span>
        <span class="plus"></span>
    </a>
    <ul>
        <li onclick="getMasterQueries(this)"><a href="javascript:void(0);">Consultas Generales</a></li>
        <li onclick="getTrasladosEnviados(this)"><a href="javascript:void(0);">Traslados Enviados</a></li>
        <li onclick="getTrasladosRecibidos(this)"><a href="javascript:void(0);">Traslados Recibidos</a></li>
        <li> <a href="javascript:void(0)" onclick="getTableInformeGeneral();">Informes general</a> </li>
        <li onclick="getStockMinimo(this)"><a href="javascript:void(0);">Stock minimo</a></li>
        <li onclick="getCotizaciones(this)"><a href="javascript:void(0);">Cotizaciones</a></li>
        <li onclick="devolucionesDelDia()"><a href="javascript:void(0);">Devoluciones</a></li>
        <li onclick="getAdelantosAll()"><a href="javascript:void(0);">Adelantos</a></li>
        @if (Auth::user()->tienda->cajas)
            <li onclick="getConsultarCajas(this)"><a href="javascript:void(0);">Listado de Cajas</a></li>
        @endif
        <li onclick="getConsultarSerie(this)"><a href="javascript:void(0);">Series</a></li>
        {{-- <li onclick="getConsultaPorCriterio(this)"><a href="javascript:void(0);">Consulta por criterios</a></li> --}}
        <li id="users_list"><a href="javascript:void(0);">Usuarios</a></li>
    </ul>
</li>
