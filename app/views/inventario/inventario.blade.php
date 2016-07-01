<div class="rounded shadow">
    <div class="panel_heading">

    </div>
    <div class="no-padding table">
        <table id="example" class="display" width="100%" cellspacing="0">
            <tbody style="background: #ffffff;">
                <tr>
                    <td class="dataTables_empty">Cargando datos del servidor...</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        proccess_table('Inventario');
        var MyTable = $('#example').dataTable({
             "language": {
                "lengthMenu": "Mostrar _MENU_ archivos por pagina",
                "zeroRecords": "No se encontro ningun archivo",
                "info": "Mostrando la pagina _PAGE_ de _PAGES_",
                "infoEmpty": "No hay archivos disponibles",
                "infoFiltered": "- ( filtrado de _MAX_ archivos )"
            },
            "aoColumnDefs": [
                {"sClass": "widthS",                    "sTitle": "ID",          "aTargets": [0]},
                {"sClass": "widthS",                    "sTitle": "Codigo",      "aTargets": [1]},
                {"sClass": "widthS",                    "sTitle": "Marca",       "aTargets": [2]},
                {"sClass": "widthL",                    "sTitle": "Descripcion", "aTargets": [3]},
                {"sClass": "right widthS",              "sTitle": "Existencia",  "aTargets": [4]},
                {"sClass": "right widthS mod_producto", "sTitle": "Real",        "aTargets": [5]},
                {"sClass": "right widthS",              "sTitle": "Ajuste",      "aTargets": [6]},
                {"sClass": "right widthS Estado",       "sTitle": "Estado",      "aTargets": [7]},
                {"sClass": "right widthM",              "sTitle": "Usuario",     "aTargets": [8]},
            ],
            "fnDrawCallback": function( oSettings ) {
                $( ".DTTT" ).html("");

                if ( $.trim( $('#iSearch').val() ).length > 0 )
                {
                    if(MyTable.fnSettings().fnRecordsDisplay() == 1)
                    {
                        x = $('#example tbody tr:first td:nth-child(6)');
                        x2 = $('#example tbody tr:first td:nth-child(5)');
                        $(x).removeClass('mod_producto');
                        var id = $(x).closest('tr').children('td:first').text();
                        prod_old_value = $(x).text();
                        $(x).html('<input type="text" value="'+$(x2).text()+'" v-on="keyup:submit($event, '+id+') | key 13, keyup:cansel | key 27" id="editProd">');

                        $('#editProd').focus();
                        $('#editProd').select();
                        $(x).addClass('current');
                        $('#editProd').autoNumeric({aSep:'', aNeg:'-', mDec:0, mRound:'S', mNum:10, vMin:-999});
                        $('#editProd').css('text-align','right');

                        compile_inv();
                    }
                    else if(MyTable.fnSettings().fnRecordsDisplay() == 0)
                    {
                        $("#iSearch").focus();
                        $("#iSearch").select();
                    }
                }

                $("td[class*='Estado']").each(function() {
                    if ($(this).html() == 0)
                        $(this).html('');
                    else
                        $(this).html('Actualizado');
                });
            },
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "admin/inventario/dt_getInventario",
            "fnServerParams": function (aoData) {
                aoData.push({ "name": "opcion", "value": "{{Input::get('opcion')}}" });
            },
        });


    var inventario = new Vue({

        el: '#example',

        methods: {

           submit: function(e, id) {
                if (e.target.value == '') {
                    return;
                };

                $.ajax({
                    type: 'POST',
                    url: 'admin/inventario/setExistencia',
                    data: { id: id, cantidad: e.target.value },
                    success: function (data) {
                        if (data.success == true)
                        {
                            $('td.current').html( e.target.value );
                            $('.current').removeClass('current');
                            $("#iSearch").focus();
                            $("#iSearch").select();
                            $('#example').dataTable().fnFilter( $('#iSearch').val() );
                            $('#iSearch').val('')
                            return msg.success('Producto actualizado', 'Listo!');
                        }
                        msg.warning(data.msg, 'Advertencia!');
                    }
                });
            },

            cansel: function() {
                $('td.current').html(prod_old_value);
                $('td.current').removeClass('current');
                $(x).addClass('mod_producto');
                $("#iSearch").focus();
                $("#iSearch").select();
            }
        }
    });

    function compile_inv() {
        inventario.$nextTick(function() {
            inventario.$compile(inventario.$el);
        });
    }

});

function actualizarDatosInventario() {
    $.ajax({
        type: "Get",
        url: 'admin/inventario/',
        data: { opcion: $('input[name=optInvMens]:checked').val() }
    }).done(function(data) {
        if (data.success) {
           $('.dt-panel').html(data.table);
           return $('.dt-panel').show();
        }
        msg.warning(data, 'Advertencia!');
    });
}
</script>
