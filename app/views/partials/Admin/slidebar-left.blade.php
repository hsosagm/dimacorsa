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
        @include('partials.Controles.cierres', array('opcion' => 'Admin'))
         <!--Fin Cierres -->

        <!--Inicio configuracion -->
        @include('partials.Controles.configuracion')
        <!--Fin configuracion -->

    </ul>

    <!--Inicio footerSidebarLeft -->
    @include('partials.Controles.footerSidebarLeft')
    <!--Fin footerSidebarLeft -->

</aside>
