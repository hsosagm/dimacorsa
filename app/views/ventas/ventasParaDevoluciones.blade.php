
<div v-show="x > 0" class="panel_heading">
    <div v-show="x == 1" id="table_length2" class="pull-left"></div>

    <div class="pull-right">
        <button v-show="x > 1" v-on="click: reset" class="btn" title="Regresar"><i class="fa fa-reply"></i></button>
        <button v-on="click: close" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
    </div>
</div>
<div v-show="x == 1" id="inventarioContainer" style="min-width: 310px; height: 400px; margin: 0 auto">

    <div style="height: 60px; border: 1px solid #D6D6D6">
        <h4 style="text-align:center">Devolucion parcial o total de ventas</h4>
    </div>

    <table class="dt-table table-striped table-theme" id="example">
        <tbody style="background: #ffffff;">
            <tr>
                <td style="font-size: 14px; color:#1b7be2;" colspan="7" class="dataTables_empty">Cargando datos del servidor...</td>
            </tr>
        </tbody>
    </table>
</div>

<div v-show="x == 2" id="returnDiv"></div>

 
<script type="text/javascript">
    $(document).ready(function() {
        $("#iSearch").val("");
        $("#iSearch").unbind();
        $("#table_length2").html("");

        setTimeout(function() {
            $('#example_length').prependTo("#table_length2");
            dv.x = 1;
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
                {"sClass": "widthS",                         "sTitle": "Fecha",                        "aTargets": [0]},
                {"sClass": "widthM",                         "sTitle": "Usuario",                      "aTargets": [1]},
                {"sClass": "widthL",                         "sTitle": "Cliente",                      "aTargets": [2]},
                {"sClass": "widthS right formato_precio",    "sTitle": "Total",                        "aTargets": [3]},
                {"sClass": "widthS right formato_precio",    "sTitle": "Saldo",                        "aTargets": [4]},
                {"sClass": "widthS center font14", "orderable": false, "sTitle": "Operaciones", "aTargets": [5],

                    "mRender": function( data, type, full ) {
                        $v  = '<i onclick="showSalesDetail(this)" title="Ver detalle" class="fa fa-plus-square show_detail" style="color:#527DB5"></i>';
                        $v += '<i onclick="returnSale(this, '+full.DT_RowId+')" title="Abrir para devolucion" class="fa fa-check" style="padding-left:15px; color:#52A954"></i>';
                        $v += '<i title="Eliminar venta completa" class="fa fa-close" style="padding-left:15px; color:#FF7676"></i>';
                        return $v;
                    }

                },

            ],

            "fnDrawCallback": function( oSettings ) {
                $("td[class*='formato_precio']").each(function() {
                    $(this).html(formato_precio($(this).html()));
                });
            },

            "bJQueryUI": false,
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": "user/ventas/devoluciones/DT_ventasParaDevoluciones"
        });
    });

    var dv = new Vue({

        el: '#graph_container',

        data: {
            x: 0,
            devoluciones: {
                venta: [],
                detalle_venta: [],
                productos: []
            }
        },

        computed: {
            totalCantidadDevolucion: function ()
            {
                var total = 0;
                this.devoluciones.productos.forEach(function(q) {
                    total = total + parseInt(q.cantidad);
                });
                return total;
            },

            totalMontoDevolucion: function()
            {
                var total = 0;
                this.devoluciones.productos.forEach(function(q) {
                    total = total + (q.cantidad * q.precio);
                });
                return total;
            },

            totalVenta: function()
            {
                var total = 0;
                this.devoluciones.detalle_venta.forEach(function(q) {
                    total = total + (q.cantidad * q.precio);
                });
                return total;
            }
        },

        methods: {
            reset: function() {
                dv.x = dv.x - 1;
                if(dv.x == 1) {
                    $('#example').dataTable().fnStandingRedraw();
                }
            },

            close: function() {
                $('#graph_container').hide();
            },

            pushToDevoluciones: function(event, detalle_venta_id, producto_id, cantidad, precio)
            {
                if ( $(event.target).is(':checked') )
                {
                    this.devoluciones.productos.push({ detalle_venta_id: detalle_venta_id, producto_id: producto_id, cantidad: cantidad, precio: precio });
                }
                else
                {
                    $(event.target).closest('td').next('td').next('td').hide(); 
                    $(event.target).closest('td').next('td').show(); 
                    this.devoluciones.productos.forEach(function(q, index)
                    {
                        if( producto_id === q.producto_id) {
                            dv.devoluciones.productos.$remove(index);
                        }
                    });
                }
            },

            edit: function(event)
            {
                if ( $(event.target).closest('td').prev('td').find('input:checkbox').is(':checked') )
                {
                    $(event.target).closest('td').hide();
                    $(event.target).closest('td').next('td').show();
                    $(event.target).closest('td').next('td').find('input:text').val(event.target.textContent).focus().select();
                }
            },

            cancelEdit: function (event)
            {
                $(event.target).closest('td').hide();
                $(event.target).closest('td').prev('td').show();
            },

            onBlur: function (event)
            {
                $(event.target).closest('td').hide();
                $(event.target).closest('td').prev('td').show();
            },

            doneEdit: function (event, producto_id)
            {
                $.ajax({
                    type: "GET",
                    url: 'user/ventas/devoluciones/getCheckCantidadDevolucion',
                    data: { venta_id: this.devoluciones.venta.id, producto_id: producto_id, cantidad: event.target.value },
                }).done(function(data) {
                    if (data == 'success')
                    {
                        // coloca el valor del input al td.text y luego lo oculta para mostrat el td.text
                        $(event.target).closest('td').prev('td').text(event.target.value);
                        $(event.target).closest('td').hide();
                        $(event.target).closest('td').prev('td').show();

                        // actualiza el array que se va a enviar
                        dv.devoluciones.productos.forEach(function(q)
                        {
                            if( producto_id === q.producto_id) {
                                return q.cantidad = event.target.value;
                            }
                        });

                        // actualiza devoluciones.detalle_venta.cantidad en caso de que se le quite el check y se vuelva a poner 
                        // aga el push con el mismo valor que tiene el td.text
                        dv.devoluciones.detalle_venta.forEach(function(q)
                        {
                            if( producto_id === q.producto_id) {
                                return q.cantidad = event.target.value;
                            }
                        });

                        return;
                    }
                    msg.warning(data, 'Advertencia!');
                    $(event.target).select();
                });
            },

            getFormMetodoPagoNotaDeCredito: function(venta_id)
            {
                $.ajax({
                    type: 'GET',
                    url: 'user/notaDeCredito/getFormMetodoPagoNotaDeCredito',
                    data: { venta_id: venta_id, monto: dv.totalMontoDevolucion },
                }).done(function(data) {
                    $('.modal-body').html(data);
                    $('.modal-title').text( 'Nota de credito' );
                    $('.bs-modal').modal('show');
                });
            }
        }
    });

    function dv_compile() {
        dv.$nextTick(function() {
            dv.$compile(dv.$el);
        });
    }

    function returnSale(e, venta_id) {
        $.ajax({
            type: "GET",
            url: 'user/ventas/devoluciones/getVentaConDetalleParaDevolucion',
            data: { venta_id: venta_id },
        }).done(function(data) {
            if (data.success == true)
            {
                $('#returnDiv').html(data.table);
                dv.x = 2;
                return dv_compile();
            }
            msg.warning(data, 'Advertencia!');
        });
    };

    function enviarDevolucionParcial(descuento_sobre_saldo, monto)
    {
        var nota_credito_opcion = $('input[name="nota_credito_opcion"]:checked').val();
        var mp_nota_credito_caja = $('input[name="mp_nota_credito_caja"]:checked').val();

        $.ajax({
            type: "POST",
            url: 'user/ventas/devoluciones/postDevolucionParcial',
            data: {
                datos: dv.devoluciones.productos, venta_id: dv.devoluciones.venta.id,
                nota_credito_opcion: nota_credito_opcion, mp_nota_credito_caja: mp_nota_credito_caja,
                tienda_id: dv.devoluciones.venta.tienda_id, cliente_id: dv.devoluciones.venta.cliente_id,
                descuento_sobre_saldo: descuento_sobre_saldo, monto: monto
            },
        }).done(function(data) {
            console.log(data);
            if (data.success == true)
            {
                dv.close();
                return msg.success('Nota de credito ingresada', 'Advertencia!');;
            }
            msg.warning(data, 'Advertencia!');
        });
    }

</script>