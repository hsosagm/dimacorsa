
<script>
   var graph_container = new Vue({

    el: '#graph_container',

    data: {
        x: 1,
    },

    methods: {

        reset: function() {
            graph_container.x = graph_container.x - 1;
        },

        close: function() {
            $('#graph_container').hide();
        }
    }
});

   function graph_container_compile() {
    graph_container.$nextTick(function() {
        graph_container.$compile(graph_container.$el);
    });
}


$('input[name="fecha_inicial"]').pickadate({ 
  max: true,
  selectYears: true,
  selectMonths: true
});
$('input[name="fecha_final"]').pickadate({ 
  max: true,
  selectYears: true,
  selectMonths: true
});
</script>

<div class="panel_heading">
    <div class="DTTT btn-group"></div>
    <div class="pull-right">
        <button v-show="x > 1" v-on="click: reset" class="btn" title="Regresar"><i class="fa fa-reply"></i></button>
        <button v-on="click: close" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
    </div>
</div>
<div v-show="x == 1" id="consultasContainer" style="min-width: 310px; height: 400px; margin: 0 auto">
    <div class="row" style="padding: 10px;">
        <div class="col-md-12">
            <input type="hidden" value="" name="producto_id">
            <table class="master-table">
                <tr class="col-md-1">
                </tr>
                <tr class="col-md-5">
                    <td class="col-md-3">Fecha inicial:</td>
                    <td class="col-md-7">
                        <input type="text"  name="fecha_inicial" data-value="now()">
                        <i class="fa fa-calendar fa-lg"></i>
                    </td>
                    <td class="col-md-1"></td>
                </tr> 
                <tr class="col-md-6">
                    <td class="col-md-1"></td>
                    <td class="col-md-3">Fecha final:</td>
                    <td class="col-md-7">
                        <input type="text"  name="fecha_final" data-value="now()">
                        <i class="fa fa-calendar fa-lg"></i>
                    </td>
                </tr>
            </table>
            <br>

            <div class="row">
                <div class="col-md-4">
                    <li class="dropdown filtroPorCriterioTitulo fg-theme">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
                            <span class="meta">
                                <span class="text hidden-xs hidden-sm text-muted">
                                    Usuarios
                                    <i class="glyphicon glyphicon-filter"></i>
                                </span>
                            </span>
                        </a> 
                        <?php 
                        $user = User::whereRaw("(select count(*) from ventas where user_id = users.id and DATE_FORMAT(ventas.created_at,'%Y-%m') = DATE_FORMAT(current_date ,'%Y-%m')) > 0 ")->where('tienda_id',Auth::user()->tienda_id)->get(); 
                        ?>
                        <ul class="dropdown-menu animated flipInX filtroPorCriterio">
                            @foreach($user as $usr)
                            <li>
                                <a href="javascript:void(0)">
                                    <input type="checkbox" name="usuarios" value="{{$usr->id}}">
                                    <i>{{ $usr->nombre}}</i>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                </div>
                <div class="col-md-4">
                    <li class="dropdown filtroPorCriterioTitulo fg-theme">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
                            <span class="meta">
                                <span class="text hidden-xs hidden-sm text-muted">
                                    Categorias
                                    <i class="glyphicon glyphicon-filter"></i>
                                </span>
                            </span>
                        </a> 
                        <?php 
                        $categoria = Categoria::all(); 
                        ?>
                        <ul class="dropdown-menu animated flipInX filtroPorCriterio">
                            @foreach($categoria as $cat)
                            <li>
                                <a href="javascript:void(0)">
                                    <input type="checkbox"  name="categorias" value="{{$cat->id}}">
                                    <i>{{ $cat->nombre}}</i>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                </div>
                <div class="col-md-4">
                    <li class="dropdown filtroPorCriterioTitulo fg-theme">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
                            <span class="meta">
                                <span class="text hidden-xs hidden-sm text-muted">
                                    Marcas
                                    <i class="glyphicon glyphicon-filter"></i>
                                </span>
                            </span>
                        </a> 
                        <?php 
                        $marca = Marca::all(); 
                        ?>
                        <ul class="dropdown-menu animated flipInX filtroPorCriterio">
                            @foreach($marca as $mr)
                            <li>
                                <a href="javascript:void(0)">
                                    <input type="checkbox"  name="marcas" value="{{$mr->id}}">
                                    <i>{{ $mr->nombre}}</i>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </li>
                </div>
            </div>
        </div>
    </div>
</div>


