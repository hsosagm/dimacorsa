<div class="panel-heading no-padding">
    <ul class="nav nav-tabs">
        <li class="active" id="tab-perfil-user">
            <a href="#tab-informacion" data-toggle="tab">
                <i class="fa fa-user"></i>
                <span>Informacion Personal</span>
            </a>
        </li>
        <li class="" id="tab-perfil-role">
            <a href="#tab-roles" data-toggle="tab">
                <i class="fa fa-users"></i>
                <span>Roles</span>
            </a>
        </li>
    </ul>
</div>
 
<div class="">
    <div class="tab-content" style="background: white" >
        <div class="tab-pane fade active in" id="tab-informacion" style="background:white !important">

            {{ Form::open(array('data-remote-up','data-success' => 'Perfil Actualizado','url' => 'user/profile', 'method' =>'post', 'role'=>'form', 'class' => 'form-horizontal all')) }}

            {{ Form::_select('tienda_id', Tienda::lists('nombre', 'id'),$user->tienda_id) }}

            {{ Form::hidden('id', $user->id) }}

            {{ Form::_text('username', $user->username) }}

            {{ Form::_text('nombre', $user->nombre) }}

            {{ Form::_text('apellido', $user->apellido) }}

            {{ Form::_text('email', $user->email) }}

            {{ Form::_password('password') }}

            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-4">
                    Activo: {{Form::radio('status', 1, ($user->status == 1)? true:false) }}
                </div>
                <div class="col-md-6">
                    Inactivo: {{Form::radio('status', 2, ($user->status == 2)? true:false) }}
                </div>
            </div>

            <div style="" class="modal-footer">
                <input class="btn theme-button" value="Guardar!" type="submit">
            </div>

            {{ Form::close() }}

        </div>
        <div class="tab-pane fade" id="tab-roles" style="background:white !important">

           {{ Form::open(array('url' => 'owner/user/add_role', 'method' =>'post', 'role'=>'form', 'class' => 'form-add-group')) }}

           <div class="form-group" style="margin-top: 25px !important">
            <div class="input-group">
                <span class="input-group-addon button-add-group">
                    <span id="add_user_group" class="form-button glyphicon glyphicon-plus-sign pointer"></span>
                </span>
                {{ Form::select('role_id', $no_assigned, '3', array('class'=>'form-control group_id')) }}
                {{ Form::hidden('user_id', $user->id) }}
            </div>
        </div>  
        {{ Form::close() }}

        @if (count($assigned)>0) 
        {{ Form::label('body', 'Roles Asignados:') }} 
        @endif            

        @foreach ($assigned as $roles)

        @if($roles->role_id == 1 && !Auth::user()->hasRole("Owner"))
            <div class="input-group form-roles" style="margin-bottom: 5px">
                <span class="input-group-addon form-button button-del-group" name="1">
                    <span class="glyphicon glyphicon-minus-sign"></span>
                </span>
                {{ Form::text('name', @$roles->name, array('class'=>'form-control', 'disabled')) }}
                {{ Form::hidden('user_id', @$roles->user_id) }}
                {{ Form::hidden('role_id', @$roles->role_id) }}
            </div>

        @else

            {{ Form::open(array('url' => 'owner/user/remove_role', 'method' =>'post', 'role'=>'form', 'class' => 'form-add-group')) }}
            <div class="input-group form-roles" style="margin-bottom: 5px">
                <span class="input-group-addon form-button button-del-group" name="1">
                    <span class="glyphicon glyphicon-minus-sign remove_role pointer"></span>
                </span>
                {{ Form::text('name', @$roles->name, array('class'=>'form-control', 'disabled')) }}
                {{ Form::hidden('user_id', @$roles->user_id) }}
                {{ Form::hidden('role_id', @$roles->role_id) }}
            </div>
            {{ Form::close() }}
            
        @endif

        @endforeach
    </div>
</div>
</div>

<style type="text/css">

    .modal-dialog{
        width: 550px !important;
    }

</style>