<header id="header">
    <div class="header-left">
        <div class="navbar-minimize-mobile left">
            <i class="fa fa-bars"></i>
        </div>
        <div class="navbar-header" style="text-align:left !important">
            <a class="navbar-brand" href="javascript:void(0)">
                <img class="logo" src="img/logo/logo_empresa.png" alt="brand logo"/>
            </a>
        </div>
        <div class="navbar-minimize-mobile right">
            <i class="fa fa-cog"></i>
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="header-right">
        <div class="navbar navbar-toolbar navbar-dark">
            <ul class="nav navbar-nav navbar-left">
                <li class="navbar-minimize">
                    <a href="javascript:void(0);" title="Minimize sidebar">
                        <i class="fa fa-bars"></i>
                    </a>
                </li>
                <li class="navbar-search">
                    <a href="javascript:void(0)" class="trigger-search"><i class="fa fa-search"></i></a>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <!--Inicio userOptionHeader -->
                @include('partials.Controles.userOptionHeader')
                <!--Fin userOptionHeader -->
                <li class="navbar-setting pull-right">
                    <a href="javascript:void(0);"><i class="fa fa-cog"></i></a>
                </li>
            </ul>
        </div>
    </div>
</header>
