<div class="panel panel-info" style="width:85%; margin-left:6%;">

    <div class="panel-heading">
        <div class="row">
            <div class="col-md-12">
                <h3 class="panel-title bariol-thin"><i class="fa fa-pencil"></i> Edit role</h3>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div style="height: 375px;">
            <ul class="nav nav-tabs" id="myTab">
                <li class="active"><a href="#sectionA">Section A</a></li>
                <li><a href="#permisosA">Permisos basicos</a></li>
                <li><a href="#permisosB">Permisos intermedios</a></li>
                <li><a href="#permisosC">Permisos abanzados</a></li>
                <li><a href="#permisosD">Permisos propietario</a></li>
            </ul>
            <div class="tab-content">

                <div id="sectionA" class="col-md-4 col-xs-12 tab-pane active">
                    <h4>Nombre</h4>
                    {{ Form::open(array('url' => 'role/update', 'method' =>'post', 'role'=>'form')) }}
                        {{ Form::hidden('id', @$role->id) }}
                        <div class="form-group">
                            {{ Form::text('nombre', @$role->name, array('class'=>'form-control')) }}
                        </div>
                    {{ Form::close() }}
                </div>

                <div id="permisosA" class="tab-pane">
                    <h3>Permisos A</h3>
                    <table class="table table-striped table-hover">
                        <thead> <?php $val = 1 ?>
                        @foreach ($permissions as $permission)

                            <?php  if($val === 1): ?>
                                <tr>
                            <?php endif; ?>

                            <?php  if($val === 1): ?>
                                <th class="col-md-6 hide"><input type="hidden" id="permissions[{{{ $permission['id'] }}}]" name="permissions[{{{ $permission['id'] }}}]" value="0" /></th>

                                <th class="col-md-2"><input type="checkbox" id="permissions[{{{ $permission['id'] }}}]" name="permissions[{{{ $permission['id'] }}}]" value="1"{{{ (isset($permission['checked']) && $permission['checked'] == true ? ' checked="checked"' : '')}}} /></th>

                                <th class="col-md-2">{{{ $permission['display_name'] }}}</th>
                            <?php endif; ?>

                            <?php  if($val === 2): ?>
                                <th class="col-md-6 hide"><input type="hidden" id="permissions[{{{ $permission['id'] }}}]" name="permissions[{{{ $permission['id'] }}}]" value="0" /></th>

                                <th class="col-md-2"><input type="checkbox" id="permissions[{{{ $permission['id'] }}}]" name="permissions[{{{ $permission['id'] }}}]" value="1"{{{ (isset($permission['checked']) && $permission['checked'] == true ? ' checked="checked"' : '')}}} /></th>

                                <th class="col-md-2">{{{ $permission['display_name'] }}}</th>

                                <?php $val = $val - 2 ?>
                            <?php endif; ?>
                            <?php $val = $val + 1 ?>
                            
                            <?php  if($val === 1): ?>
                                </tr>
                            <?php endif; ?>

                        @endforeach
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>

                <div id="permisosB" class="tab-pane">
                    <h3>permisos B</h3>

                </div>
                <div id="permisosC" class="tab-pane">
                    <h3>Permiso C</h3>

                </div>
                <div id="permisosD" class="tab-pane">
                    <h3>Permiso D</h3>

                </div>
            </div>
        </div>

        <div class="col-md-12" style="padding-top:20px;">
            <a class="btn btn-primary btn-lg btn-embossed pull-right margin-left-5" id="user_update_send" href="#"><span class="fa fa-save"></span> Guardar</a>
        </div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $('.divider').text("/");
        $('.bread-current').text("Roles de usuario / Editar Role");
        $('.q_cont').hide();

        $("#myTab a").click(function(e){
            e.preventDefault();
            $(this).tab('show');
        });
    });
</script>