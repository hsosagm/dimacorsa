
<script>
    $(document).ready(function() {
        $("#iSearch").val("");
        $("#iSearch").unbind();
        $("#table_length3").html("");
        setTimeout(function() {
            $('#example_length').prependTo("#table_length3");
            graph_container.x = 1;
            $('#iSearch').keyup(function(){
                $('#example').dataTable().fnFilter( $(this).val() );
            })
        }, 300); 
        $('#example').dataTable({
            "language": {
                "lengthMenu": "Mostrar _MENU_ archivos por pagina",
                "zeroRecords": "No se encontro ningun archivo",
                "info": "Mostrando la pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No hay archivos disponibles",
                "infoFiltered": "- ( filtrado de _MAX_ archivos )"
            },
            "aoColumnDefs": [
                {"sClass": "mod_codigo hover width5",              "sTitle": "Tienda",      "aTargets": [0]},
                {"sClass": "mod_codigo hover width25",              "sTitle": "Usuario",     "aTargets": [1]},
                {"sClass": "mod_codigo hover width35S",              "sTitle": "Nota",        "aTargets": [2]},
                {"sClass": "mod_codigo hover width20",              "sTitle": "Fecha",       "aTargets": [3]},
                {"sClass": "width10 icons center",                          "sTitle": "",            "aTargets": [4],
                    "orderable": false,
                    "mRender": function() {
                        return '<i class="fa fa-plus-square btn-link theme-c" onClick="VerDetalleDelCierreDelDia(this)"></i><a href="javascript:void(0);" title="Ver Cierre" onclick="viewCierreDelDia(event)" class="fa fa-search font14" style="padding-left:10px">';
                        //<a href="javascript:void(0);" title="Imprimir Cierre" onclick="ExportarCierreDelDiaPdf(this)" class="fa fa-file-pdf-o font14" style="padding-left:15px">
                    }
                },
            ],
            "order": [[ 3, "desc" ]],
            "fnDrawCallback": function( oSettings ) {
                $( ".DTTT" ).html("");
            },
            "bJQueryUI": false,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "admin/cierre/CierresDelMes_dt?fecha={{Input::get('fecha')}}"
        });

    });

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
            },

            getAsignarInfoEnviar: function($v_model ,$v_metodo){
                cierre_model= $v_model;
                cierre_metodo_pago_id = $v_metodo;
                graph_container.getCierreConsultasPorMetodoDePago(1 , null);
            },

            getCierreConsultasPorMetodoDePago: function(page , sSearch) {
                $.ajax({
                    type: 'GET',
                    url: "admin/cierre/consultas/ConsultasPorMetodoDePago/"+cierre_model+"?page=" + page,
                    data: {sSearch: sSearch , metodo_pago_id : cierre_metodo_pago_id , fecha: cierre_fecha_enviar, grafica:"_graficas" },
                    success: function (data) {
                        if (data.success == true) {
                            graph_container.x = 3;
                            $('#cierres_dt').html(data.table);
                        }
                        else {
                            msg.warning(data, 'Advertencia!');
                        }
                    }
                });
            },

            getCierresDelMes: function(e)
            {
                $fecha = $('#start_hidden').val();

                $.ajax({
                    type: "GET",
                    url: 'admin/cierre/CierresDelMes',
                    data: { fecha: $fecha },
                }).done(function(data) {
                    if (data.success == true)
                    {
                        clean_panel();
                        $('#graph_container').show();
                        return $('#graph_container').html(data.view);
                    }
                    msg.warning(data, 'Advertencia!');
                });
            }
        }
    });

   function graph_container_compile() {
        graph_container.$nextTick(function() {
            graph_container.$compile(graph_container.$el);
        });
    }

    $(document).on('click', '.pagination_cierre_graficas a', function (e) {
        e.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        graph_container.getCierreConsultasPorMetodoDePago(page , null);
    });

    function viewCierreDelDia(e) {
        $id = $(e.target).closest('tr').attr('id');

        $.ajax({
            type: "GET",
            url: 'admin/cierre/getCierreDelDia',
            data: { cierre_id_dt:$id , grafica: true},
            success: function (data) {
                graph_container.x = 2;
                $('#cierres').html(data);
                graph_container_compile();
            }
        });
    }
</script>


<div class="panel_heading master-table short_calendar ">
    <div v-show="x == 1" id="table_length3" class="pull-left"></div>

    <div  class="pull-left" style="margin-left:20px !important">
        Fecha:
        <input type="text" id="fechaCierre" data-value="{{Input::get('fecha')}}" name="start">
        <i class="glyphicon glyphicon-repeat fg-theme" style="cursor:pointer" v-on="click: getCierresDelMes"></i>
    </div>

    <div class="pull-right">
        <button v-show="x > 1" v-on="click: reset" class="btn" title="Regresar"><i class="fa fa-reply"></i></button>
        <button v-on="click: close" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
    </div>
</div>
<div v-show="x == 1" id="container">
    <table class="dt-table table-striped table-theme" id="example">
        <tbody style="background: #ffffff;">
            <tr>
                <td style="font-size: 14px; color:#1b7be2;" colspan="7" class="dataTables_empty">Cargando datos del servidor...</td>
            </tr>
        </tbody>
    </table>
</div>
<div v-show="x == 2" id="cierres"></div>
<div v-show="x == 3" id="cierres_dt"></div>


<script>
    var counter = 2;

    var $start = $('input[name="start"]').pickadate(
    {
        selectYears: true,
        selectMonths: true,

        max: true,
        formatSubmit: 'yyyy-m-d',
        hiddenName: true,
        onSet: function() {
            if (counter == 2) {
                counter = 0;
                picker_start.set('select', picker_start.get('highlight'));
                $('.short_calendar .picker__table').css('display', 'none');
            };
            $('.short_calendar .picker__table').css('display', 'none');
            counter++;
        },
        onClose: function(element) {
          $('.short_calendar .picker__table').css('display', 'none');
        }
    });

    $('.short_calendar .picker__table').css('display', 'none');
    var picker_start = $start.pickadate('picker')
</script>
