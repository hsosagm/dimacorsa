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
                    <form class="navbar-form" onsubmit=" return false">
                        <div class="form-group has-feedback">
                           
                        </div>
                    </form>
                </li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li class="dropdown navbar-message">
                    <a  href="/cliente" class="dropdown-toggle"  data-placement="bottom"  title="Clientes"  data-toggle="tooltip"><i class="fa fa-users"></i></a>
                </li>
                <li class="dropdown navbar-profile">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="meta">
                            <span class="avatar"><img src="img/logout.jpg" class="navbar-avatar"></span>
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
                        <li><a id="profile" href="javascript:void(0)"><i class="fa fa-user"></i>View profile</a></li>
                        <li><a href="logout"><i class="fa fa-sign-out"></i>Logout</a></li>
                    </ul>
                </li>
                <li class="navbar-setting pull-right">
                    <a href="javascript:void(0);"><i class="fa fa-cog"></i></a>
                </li>
            </ul>
        </div>
    </div>
</header> 