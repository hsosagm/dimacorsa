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
        <li><a id="profile" href="javascript:void(0)"><i class="fa fa-user"></i>Editar Perfil</a></li>
        <li> <a href="logout"><i class="fa fa-sign-out"></i>Logout</a></li>
    </ul> 
</li>
