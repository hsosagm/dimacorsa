
<script>

    var graph_container = new Vue({
        el: '#graph_container',
        data: {
            x: 1,
            datos: {{ $data['datos'] }},
        },
        filters: {
            filterCategory: function(tasks) {
                return tasks.filter(function(tasks){
                    return ! tasks.completed;
                });
            }
        },
        methods: {
            reset: function() {
                graph_container.x = graph_container.x - 1;
            },

            close: function() {
                $('#graph_container').hide();
            },

            getActualizarConsultaPorFecha: function(e) {
                e.preventDefault();
                var form = $('#formConsultasPorCriterio');
                $('input[type=submit]', form).prop('disabled', true);

                $.ajax({
                    type: "GET",
                    url: 'owner/chart/getConsultaPorCriterio',
                    data: form.serialize(),
                }).done(function(data) {
                    if (data.success == true){
                        clean_panel();
                        $('#graph_container').show();
                        return $('#graph_container').html(data.view);
                    }

                    msg.warning(data, 'Advertencia!');
                    $('input[type=submit]', form).prop('disabled', false);;
                });   
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

    function checkedCat(e){
        $name = $(e).attr('name');

        if( $(e).is(':checked') )
            return $( "input[name='"+$name+"']" ).prop( "checked", true );

        return $( "input[name='"+$name+"']" ).prop( "checked", false );
    }

</script>

<div class="panel_heading">
    <div class="DTTT btn-group"></div>
    <div class="pull-right">
        <button v-show="x > 1" v-on="click: reset" class="btn" title="Regresar"><i class="fa fa-reply"></i></button>
        <button v-on="click: close" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
    </div>
</div>
<div v-show="x == 1" id="consultasContainer" style="background: #FBFBFB !important;min-width: 310px;margin: 0 auto">
    <br>
    <div class="row">
        <div class="col-md-12">
            {{ Form::open(array('id' => 'formConsultasPorCriterio')) }}
                <table class="master-table">
                    <tr class="col-md-5">
                        <td class="col-md-4">Fecha inicial:</td>
                        <td class="col-md-6"><input type="text"  name="fecha_inicial" data-value="now()"></td>
                        <td class="col-md-2"></td>
                    </tr>
                    <tr class="col-md-5">
                        <td class="col-md-4">Fecha final:</td>
                        <td class="col-md-6"><input type="text"  name="fecha_final" data-value="now()"></td>
                        <td class="col-md-2"></td>
                    </tr>
                    <tr class="col-md-1">
                        <td>
                        <i class="glyphicon glyphicon-repeat fg-theme" v-on="click: getActualizarConsultaPorFecha" style="cursor:pointer;" > </i>
                        </td>
                    </tr>
                </table>
            {{Form::close()}}
            <br>

            <!-- inicio panel de pesta;as -->
            <div class="panel panel-tab rounded shadow">
                <div class="panel-heading no-padding">
                    <ul class="impresoras nav nav-tabs nav-pills">
                        <li class="active" width="25%">
                            <a aria-expanded="true" href="#tab1" data-toggle="tab">
                                <i class="fa fa-users"></i> <span>Usuario</span>    
                            </a>
                        </li>
                        <li width="25%">
                            <a aria-expanded="false" href="#tab2" data-toggle="tab">
                                <i class="fa fa-th-list"></i> <span>Categorias</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="tab-content divFormPayments">
                    <div class="tab-pane fade inner-all active in consultaPorCriterioTab" id="tab1">
                        <li class="dropdown filtroPorCriterioTitulo fg-theme">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" >
                                <span class="meta">
                                    <span class="text hidden-xs hidden-sm text-muted">
                                        Usuarios
                                        <i class="glyphicon glyphicon-filter"></i>
                                    </span>
                                </span>
                            </a> 
                            <ul class="dropdown-menu animated flipInX filtroPorCriterio">
                                <li>
                                    <a href="javascript:void(0)">
                                        <input type="checkbox"  onclick="checkedCat(this);" name="usuarios" checked="">
                                        <i>Todos</i>
                                    </a>
                                </li>
                                @foreach($data['user'] as $usr)
                                <li>
                                    <a href="javascript:void(0)">
                                        <input type="checkbox" name="usuarios" value="{{$usr->id}}" checked="">
                                        <i>{{ $usr->nombre}}</i>
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </li>
                    </div>

                    <div class="tab-pane fade inner-all consultaPorCriterioTab" id="tab2">
                        <div class="row">
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
                                    <ul class="dropdown-menu animated flipInX filtroPorCriterio">
                                        <li>
                                            <a href="javascript:void(0)">
                                                <input type="checkbox"  onclick="checkedCat(this);" name="categorias" checked="">
                                                <i>Todos</i>
                                            </a>
                                        </li>
                                        @foreach($data['categoria'] as $cat)
                                        <li>
                                            <a href="javascript:void(0)">
                                                <input type="checkbox"  name="categorias" value="{{$cat->id}}" checked="">
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
                                    <ul class="dropdown-menu animated flipInX filtroPorCriterio">
                                        <li>
                                            <a href="javascript:void(0)">
                                                <input type="checkbox"  onclick="checkedCat(this);" name="marcas" checked="">
                                                <i>Todos</i>
                                            </a>
                                        </li>
                                        @foreach($data['marca'] as $mr)
                                        <li>
                                            <a href="javascript:void(0)">
                                                <i> <input type="checkbox"  name="marcas" value="{{$mr->id}}" checked=""> </i>
                                                {{ $mr->nombre}}
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
            <!-- fin panel de pesta;as -->
        </div>
    </div>
</div>

<style type="text/css">
    .consultaPorCriterioTab {
        min-height: 250px !important;
    }
</style>