<li class="dropdown navbar-profile">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
        <span class="meta">
            <span class="avatar"><img src="img/logout.jpg" class="navbar-avatar"></span>
            <span class="text hidden-xs hidden-sm text-muted">
                <?php
                    $user_nombre = explode(' ',Auth::user()->nombre);
                    $user_apellido = explode(' ',Auth::user()->apellido);
                    $users = User::whereStatus(1)->whereTiendaId(Auth::user()->tienda_id)->get();
                    echo $user_nombre[0].' '.$user_apellido[0];
                ?>
                <span class="caret"></span> 
            </span>
        </span>
    </a>
    <ul class="dropdown-menu animated flipInX">
        <li><a id="profile" href="javascript:void(0)"><i class="fa fa-user"></i>Editar Perfil Actual</a></li>
        @foreach($users as $user)
            @if($user->hasRole('User') && !$user->hasRole('Admin') && !$user->hasRole('Owner'))
                <li>
                    <a href="javascript:void(0)" onclick="setCambiarDeUsuarioAutenticado(this, {{$user->id}})">
                        <i class="fa fa-user"></i>
                        @php($nombre = explode(' ',$user->nombre))
                        @php($apellido = explode(' ',$user->apellido))
                        {{ $nombre[0] .' '. $apellido[0] }}
                    </a>
                </li>   
            @endif 
        @endforeach
    </ul> 
</li>
<li class="dropdown navbar-message">
    <a href="logout" title="Salir"><i class="fa fa-power-off" style="color:#FF0000"></i></a>
</li>