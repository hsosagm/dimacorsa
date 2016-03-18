<header id="header">
    <div class="header-left">
        <div class="navbar-minimize-mobile left">
            <i class="fa fa-bars"></i>
        </div>
        <div class="navbar-header">
            <a class="navbar-brand" href="/">
                {{ getenv('LOGO_EMPRESA') }}
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
                    <form class="navbar-form" onsubmit=" return false">
                        <div class="form-group has-feedback">
                            <input id="iSearch" type="text" class="form-control typeahead rounded" placeholder="Filtrar resultados">
                        </div>
                    </form>
                </li>
            </ul> 
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown navbar-message">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-placement="bottom"  title="Proveedores" data-toggle="tooltip">
                        <i class="fa fa-list-alt" v-on="click: proveedoresListado"></i>
                    </a>
                </li>
                <li class="dropdown navbar-message">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-placement="bottom"  title="Compras Pendientes" data-toggle="tooltip">
                        <i class="fa fa-money" v-on="click: getComprasPedientesDePago"></i>
                    </a>
                </li>
                 <li class="dropdown navbar-profile" style="margin-right: 25px;">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="meta">
                            <span class="avatar"><img src="img/avatar/35/1.png" class="img-circle" alt="admin"></span>
                            <span class="text hidden-xs hidden-sm text-muted">
                                <?php 
                                $user_nombre = explode(' ',Auth::user()->nombre);
                                $user_apellido = explode(' ',Auth::user()->apellido);

                                echo $user_nombre[0].' '.$user_apellido[0];
                                ?>
                                <span class="caret"></span>
                            </span>
                        </span>
                    </a> 
                    <ul class="dropdown-menu animated flipInX" style="">
                        <li class="dropdown-header">Account</li>
                        <li><a href="logout"><i class="fa fa-sign-out"></i>Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</header>
