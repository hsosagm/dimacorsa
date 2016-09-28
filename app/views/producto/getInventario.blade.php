@if( Auth::user()->ability(array('Admin', 'Owner'), array()))
    <?php $access = 1;  ?>

    <script>
        function show_pc() {
            var column = $('#example').DataTable().column(4);
            column.visible( !column.visible() );
        }
    </script>

@else
    <?php $access = 0;  ?>
@endif


<div v-show="x > 0" class="panel_heading">
    <div v-show="x == 1" id="table_length2" class="pull-left"></div>
    <div v-show="x == 1" class="DTTT btn-group">
        @if($access == 1)
            <button onclick="show_pc()" class="btn btngrey">PC</button>
        @endif

        <button id="_edit_dt" class="btn btngrey btn_edit" disabled>Editar</button>
        <button id="_print"  impresora="{{@$codigoBarra->impresora}}" class="btn btngrey btn_edit" disabled><i class="fa fa-barcode"></i> Imprimir</button>
        <button id="_view_existencias"  class="btn btngrey btn_edit" disabled><i class=""></i> Existencias</button>

        @if($access == 1)
            <button v-on="click: getConsultasPorFecha()" class="btn btngrey btn_edit" disabled><i class=""></i>Kardex</button>
        @endif
    </div>
    <div class="pull-right">
        <button v-show="x > 1" v-on="click: reset" class="btn" title="Regresar"><i class="fa fa-reply"></i></button>
        @if($access == 1)
            <i class="fa fa-file-excel-o fa-lg" v-on="click: exportarInventarioActual('xlsx')"> </i>
            {{-- <i class="fa fa-file-pdf-o fa-lg" v-on="click: exportarInventarioActual('pdf')"> </i> --}}
        @endif
        <button v-on="click: close" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
    </div>
</div>
<div v-show="x == 1" id="inventarioContainer" style="min-width: 310px; height: 400px; margin: 0 auto">
    <table class="dt-table table-striped table-theme" id="example">
        <tbody style="background: #ffffff;">
            <tr>
                <td style="font-size: 14px; color:#1b7be2;" colspan="7" class="dataTables_empty">Cargando datos del servidor...</td>
            </tr>
        </tbody>
    </table>
</div>
<div v-show="x == 2" id="kardexContainer"></div>

<script type="text/javascript">
    $(document).ready(function() {
        $("#iSearch").val("");
        $("#iSearch").unbind();
        $("#table_length2").html("");

        setTimeout(function() {
            $('#example_length').prependTo("#table_length2");
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
                {"sClass": "widthM",                                       "sTitle": "Codigo",       "aTargets": [0]},
                {"sClass": "widthM",                                       "sTitle": "Marca",        "aTargets": [1]},
                {"sClass": "widthL",                                      "sTitle": "Descripcion",  "aTargets": [2]},
                {"sClass": "widthM",                                      "sTitle": "Categoria",    "aTargets": [3]},
                {"sClass": "right widthS formato_precio","bVisible": false,"sTitle": "P costo",      "aTargets": [4]},
                {"sClass": "right widthS formato_precio",                  "sTitle": "P publico",    "aTargets": [5]},
                {"sClass": "right widthS",                                 "sTitle": "Existencias",  "aTargets": [6]},
                {"sClass": "right widthS",                                 "sTitle": "Total",        "aTargets": [7]},
            ],
            "order": [[ 7, "desc" ]],
            "fnDrawCallback": function( oSettings ) {
                $("td[class*='formato_precio']").each(function() {
                    $(this).html(formato_precio($(this).html()));
                });
            },

            "bJQueryUI": false,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "user/productos"
        });
    });

    $('.dataTable').attr('url', 'admin/productos/');

    var graph_container = new Vue({

        el: '#graph_container',

        data: {
            x: 0,
        },

        methods: {

            reset: function() {
                graph_container.x = graph_container.x - 1;
                if(graph_container.x == 1){
                    setTimeout(function() {
                        $('#example_length').prependTo("#table_length2");
                        $('#iSearch').keyup(function(){
                            $('#example').dataTable().fnFilter( $(this).val() );
                        })
                    }, 300);
                }
            },

            close: function() {
                $('#graph_container').hide();
            },

            getConsultasPorFecha: function()
            {
                $.ajax({
                    url: "admin/kardex/getKardexPorFecha/mes",
                    type: "GET",
                    data: {producto_id: $('.dataTable tbody .row_selected').attr('id')},
                }).done(function(data) {
                    $('#kardexContainer').html("");
                    $('#kardexContainer').html(data);
                    graph_container.x = 2;
                    return graph_container_compile();
                });
            },

            getActualizarConsultasPorFecha: function(e)
            {
                e.preventDefault();
                var form = $(e.target).closest("form");
                $('input[type=submit]', form).prop('disabled', true);

                $.ajax({
                    type: "GET",
                    url: "admin/kardex/getKardexPorFecha/fechas",
                    data: form.serialize(),
                }).done(function(data) {
                        $('#kardexContainer').html("");
                        graph_container.x = 2;
                        $('#kardexContainer').html(data);
                        return graph_container_compile();
                });

            },

            exportarInventarioActual: function(tipo)
            {
                window.open('admin/exportar/exportarInventarioActual/'+tipo ,'_blank');
            },

            exportarKardexExcel: function(e, producto_id, fecha_inicial, fecha_final)
            {
                window.open('admin/kardex/exportarKardex/xls?producto_id='+producto_id+'&fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&tienda_id='+$("#kardexTiendaId").val() ,'_blank');
            },

            exportarKardexPdf: function(e, producto_id, fecha_inicial, fecha_final)
            {
                window.open('admin/kardex/exportarKardex/pdf?producto_id='+producto_id+'&fecha_inicial='+fecha_inicial+'&fecha_final='+fecha_final+'&tienda_id='+$("#kardexTiendaId").val());
            }
        }
    });

    function graph_container_compile() {
        graph_container.$nextTick(function() {
            graph_container.$compile(graph_container.$el);
        });
    }
</script>
