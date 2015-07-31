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
            {"sClass": "widthM",              "sTitle": "ID",       "aTargets": [0]},
            {"sClass": "widthM",              "sTitle": "Codigo",       "aTargets": [1]},
            {"sClass": "widthM",              "sTitle": "Marca",        "aTargets": [2]},
            {"sClass": "widthL",              "sTitle": "Descripcion",  "aTargets": [3]},
            {"sClass": "right widthS", "sTitle": "Existencia", "aTargets": [4]},
            {"sClass": "right widthS mod_producto",  "sTitle": "Real",    "aTargets": [5]},
            {"sClass": "right widthS",  "sTitle": "Ajuste",    "aTargets": [6]},
            {"sClass": "right widthS Estado",  "sTitle": "Estado",    "aTargets": [7]},
            {"sClass": "right widthS",  "sTitle": "Usuario",    "aTargets": [8]},
            ],

            "fnDrawCallback": function( oSettings ) {
                $( ".DTTT" ).html("");

                if ( $.trim( $('#iSearch').val() ).length > 0 )
                {
                    if(MyTable.fnSettings().fnRecordsDisplay() == 1)
                    {
                        x = $('#example tbody tr:first td:nth-child(6)');
                        $(x).removeClass('mod_producto');
                        var id = $(x).closest('tr').children('td:first').text();
                        prod_old_value = $(x).text();
                        $(x).html('<input type="text" v-on="keyup:submit($event, '+id+') | key 13, keyup:cansel | key 27" id="editProd">');  
                        
                        $('#editProd').focus();
                        $('#editProd').select();
                        $(x).addClass('current');
                        $('#editProd').autoNumeric({aSep:'', aNeg:'-', mDec:0, mRound:'S', mNum:10, vMin:-999});
                        $('#editProd').css('text-align','right');

                        compile_inv();
                    }
                }

                $("td[class*='Estado']").each(function() {
                    if ($(this).html() == 0) {
                        $(this).html('');
                    }
                    else {
                        $(this).html('Actualizado');
                    }
                });
            },

            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "admin/inventario/dt_getInventario"
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
                            // $('.current').addClass('mod_codigo');
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
            }
        }
    });

    function compile_inv() {
        inventario.$nextTick(function() {
            inventario.$compile(inventario.$el);
        });
    }

});

</script>