<header id="header">
    <div class="header-left">
        <div class="navbar-minimize-mobile left">
            <i class="fa fa-bars"></i>
        </div>
        <div class="navbar-header">
            <a class="navbar-brand" href="/">
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
                <li v-show="showFilter" class="navbar-search">
                    <form class="navbar-form" onsubmit=" return false">
                        <div class="form-group has-feedback">
                            <input id="iSearch" type="text" class="form-control typeahead rounded" placeholder="Filtrar resultados">
                        </div>
                    </form>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li v-on="click: clientes_table" class="dropdown navbar-message">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-placement="bottom"  title="Clientes" data-toggle="tooltip">
                        <i class="fa fa-list-alt"></i>
                    </a>
                </li>
                <li v-on="click: getVentasPedientesDePago" class="dropdown navbar-message">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-placement="bottom"  title="Pendientes Por Cliente" data-toggle="tooltip">
                        <i class="fa fa-money"></i>
                    </a>
                </li>
                <li v-on="click: getVentasPedientesPorUsuario" class="dropdown navbar-message">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-placement="bottom"  title="Pendientes Por Usuario" data-toggle="tooltip">
                        <i class="fa fa-money"></i>
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
                    <ul class="dropdown-menu animated flipInX">
                        <li><a href="logout"><i class="fa fa-sign-out"></i>Logout</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</header>
