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
    <li class="navbar-search">           
        <form class="navbar-form" onsubmit=" return false">
            <div class="form-group has-feedback">
                <input id="customer_search" type="text" class="form-control rounded customer_search" placeholder="Buscar Cliente">
                <input type="hidden" name="cliente_id">
            </div>
        </form>
    </li>

    <li class="sidebar-category">
        <span>Cliente</span>
        <span class="pull-right"><i class="fa fa-magic"></i></span>
        <span class="selected"></span
        </li>

        <li class="submenu">
            <a href="javascript:void(0);">
                <span class="icon"><i class="fa fa-file-o"></i></span>
                <span class="text">Consultas</span>
                <span class="arrow"></span>
            </a>
            <ul>
                <li><a href="javascript:void(0);" onclick="salesByCustomer(this);">Historial de Ventas</a></li>
                <li><a href="javascript:void(0);" onclick="creditSalesByCustomer(this);">Pendientes de pago</a></li>
                <li><a href="javascript:void(0);">Historial de pagos</a></li>
                <li><a href="javascript:void(0);">Historial de abonos</a></li>
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
