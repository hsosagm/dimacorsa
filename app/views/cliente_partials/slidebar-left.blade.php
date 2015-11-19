<aside id="sidebar-left" class="sidebar-circle">

    <div class="sidebar-content">
        <a href="javascript:void(0);" class="close">&times;</a>
        <div class="media">
            <div class="media-body">
                <h4 class="media-heading">
                    <span>
                       {{$tienda->nombre}}
                   </span>
               </h4>
               <small>Tecnologia Moderna</small>
           </div>
       </div>
    </div>

    <ul class="sidebar-menu">
        
        <input v-model="customer_search" id="customer_search" type="text" class="form-control" spellcheck="false" placeholder="Buscar cliente...">

        <li class="sidebar-category">
            <span>Cliente</span>
            <span class="pull-right"><i class="fa fa-magic"></i></span>
            <span class="selected"></span>
        </li>

        <li v-show="cliente_id" class="submenu">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-file-o"></i></span>
                <span class="text">Consultas</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li><a href="javascript:void(0);" v-on="click: salesByCustomer">Historial de ventas</a></li>
                <li><a href="javascript:void(0);" v-on="click: devolutionsByCustomer">Historial de devoluciones</a></li>
                <li><a href="javascript:void(0);" v-on="click: getHistorialAbonos">Historial de abonos</a></li>
                <li><a href="javascript:void(0);" v-on="click: creditSalesByCustomer">Ventas al credito</a></li>
            </ul>
        </li>

        <li v-show="cliente_id" class="submenu">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-file-o"></i></span>
                <span class="text">Operaciones</span>
                <span class="arrow"></span>
            </a>
            <ul>
                @if(count($caja))
                    <li><a href="javascript:void(0);" v-on="click: getFormAbonosVentas">Abonar a deuda</a></li>
                @endif
                <li><a href="javascript:void(0);" v-on="click: editCustomer">Editar Cliente</a></li>
            </ul>
        </li>


        <li v-show="cliente_id" class="submenu">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-file-o"></i></span>
                <span class="text">Graficos</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li><a v-on="click: chartVentasPorCliente" href="javascript:void(0);">Grafico de ventas</a></li>
                <li><a v-on="click: chartComparativaPorMesPorCliente" href="javascript:void(0);">Comparativa por mes</a></li>
            </ul>
        </li>

    </ul>

    <div class="sidebar-footer hidden-xs hidden-sm hidden-md">
        <a class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Setting">
            <i class="fa fa-cog"></i>
        </a>
        <a id="fullscreen" class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Fullscreen">
            <i class="fa fa-desktop"></i>
        </a>
        <a class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Lock Screen">
            <i class="fa fa-lock"></i>
        </a>
        <a class="pull-left" href="javascript:void(0);" data-toggle="tooltip" data-placement="top" data-title="Logout">
            <i class="fa fa-power-off"></i>
        </a>
    </div>

</aside>
