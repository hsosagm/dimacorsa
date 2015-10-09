<li class="submenu">
    <a href="javascript:void(0);">
        <span class="icon"><i class="fa fa-columns"></i></span>
        <span class="text">Cierre</span>
        <span class="plus"></span>
    </a>
    <ul>
        <li><a href="javascript:void(0);" id="CierreDelDia">Movimientos del dia</a></li>
        <li><a href="javascript:void(0);" onClick="cierre();">Realizar Corte</a></li>
        @if($opcion == 'Owner')
            <li><a href="javascript:void(0);" onClick="CierreDelMes();">Balance General</a></li>
        @endif
        <li><a href="javascript:void(0);" onClick="CierresDelMes();">Movimientos por fecha</a></li>
        <li><a href="javascript:void(0);" onClick="cortesDeCajaPorDia()">Cortes de Caja</a></li>
    </ul>
</li>
