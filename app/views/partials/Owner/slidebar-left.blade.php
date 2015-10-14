<aside id="sidebar-left" class="sidebar-circle">

    <!--Inicio titleSidebarLeft -->
    @include('partials.Controles.titleSidebarLeft')
    <!--Fin titleSidebarLeft -->

    <ul class="sidebar-menu">
        <!--Inicio titleDashboardSidebarLeft -->
        @include('partials.Controles.titleDashboardSidebarLeft')
        <!--Fin titleDashboardSidebarLeft -->

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

        <!--Inicio Cierres -->
       @include('partials.Controles.cierres', array('opcion' => 'Owner'))
       <!--Fin Cierres -->

        <!--Inicio configuracion -->
       @include('partials.Controles.configuracion')
       <!--Fin configuracion -->

        <li class="sidebar-category">
            <span>Graficos</span>
            <span class="pull-right"><i class="fa fa-bar-chart-o"></i></span>
        </li>

        <li>
            <a id="graph_v" href="javascript:void(0);">
                <span class="icon"><i class="fa fa-desktop"></i></span>
                <span class="text">Ventas</span>
            </a>
        </li>

        <li>
            <a href="javascript:void(0);" onclick="comparativaMensual();">
                <span class="icon"><i class="fa fa-desktop"></i></span>
                <span class="text">Comparativa</span>
            </a>
        </li>

        <li>
            <a id="graph_g" href="javascript:void(0);">
                <span class="icon"><i class="fa fa-group"></i></span>
                <span class="text">Gastos</span>
            </a>
        </li>

        <li>
            <a id="graph_s" href="javascript:void(0);">
                <span class="icon"><i class="fa fa-group"></i></span>
                <span class="text">Soporte</span>
            </a>
        </li>

    </ul>

    <!--Inicio footerSidebarLeft -->
    @include('partials.Controles.footerSidebarLeft')
    <!--Fin footerSidebarLeft -->

</aside>
