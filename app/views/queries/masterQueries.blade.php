<div id="Master">
    <table id="MasterQueries" v-if="x == 1" style="text-align:center">
        <tr>
            <td><p>Ventas</p><img src="images/consultas/ventas.png" height=80 width=80></img>
                <div class="row">
                    <div class="col-md-5 center" v-on="click: getConsultasPorFecha('dia', 'Ventas')"><span>Hoy</span></div>
                    <div class="col-md-2 center"><span>|</span></div>
                    <div class="col-md-5 center" v-on="click: getConsultasPorFecha('mes', 'Ventas')"><span>Fecha</span></div>
                </div>
            </td>
            <td><p>Compras</p><img src="images/consultas/compras.png" height=80 width=80></img>
                <div class="row">
                    <div class="col-md-5 center" v-on="click: getConsultasPorFecha('dia', 'Compras')"><span>Hoy</span></div>
                    <div class="col-md-2 center"><span>|</span></div>
                    <div class="col-md-5 center" v-on="click: getConsultasPorFecha('mes', 'Compras')"><span>Fecha</span></div>
                </div>
            </td>
            <td><p>Descargas</p><img src="images/consultas/descargas.png" height=80 width=80></img>
                 <div class="row">
                    <div class="col-md-5 center" v-on="click: getConsultasPorFecha('dia', 'Descargas')"><span>Hoy</span></div>
                    <div class="col-md-2 center"><span>|</span></div>
                    <div class="col-md-5 center" v-on="click: getConsultasPorFecha('mes', 'Descargas')"><span>Fecha</span></div>
                </div>
            </td>
            <td><p>Egresos</p><img src="images/consultas/egresos.png" height=80 width=80></img>
                 <div class="row">
                    <div class="col-md-5 center" v-on="click: getConsultasPorFecha('dia', 'Egresos')"><span>Hoy</span></div>
                    <div class="col-md-2 center"><span>|</span></div>
                    <div class="col-md-5 center" v-on="click: getConsultasPorFecha('mes', 'Egresos')"><span>Fecha</span></div>
                </div>
            </td>
            <td><p>Gastos</p><img src="images/consultas/gastos.png" height=80 width=80></img>
                 <div class="row">
                    <div class="col-md-5 center" v-on="click: getConsultasPorFecha('dia', 'Gastos')"><span>Hoy</span></div>
                    <div class="col-md-2 center"><span>|</span></div>
                    <div class="col-md-5 center" v-on="click: getConsultasPorFecha('mes', 'Gastos')"><span>Fecha</span></div>
                </div>
            </td>
        </tr>

        <tr>
            <td><p>Abonos Proveedores</p><img src="images/consultas/abonos_proveedores.png" height=80 width=80></img>
                 <div class="row">
                    <div class="col-md-5 center" v-on="click: getConsultasPorFecha('dia', 'AbonosProveedores')"><span>Hoy</span></div>
                    <div class="col-md-2 center"><span>|</span></div>
                    <div class="col-md-5 center" v-on="click: getConsultasPorFecha('mes', 'AbonosProveedores')"><span>Fecha</span></div>
                </div>
            </td>
            <td><p>Soporte</p><img src="images/consultas/soporte.png" height=80 width=80></img>
                 <div class="row">
                    <div class="col-md-5 center" v-on="click: getConsultasPorFecha('dia', 'Soporte')"><span>Hoy</span></div>
                    <div class="col-md-2 center"><span>|</span></div>
                    <div class="col-md-5 center" v-on="click: getConsultasPorFecha('mes', 'Soporte')"><span>Fecha</span></div>
                </div>
            </td>
            <td><p>Abonos Clientes</p><img src="images/consultas/abonos_clientes.png" height=80 width=80></img>
                 <div class="row">
                    <div class="col-md-5 center" v-on="click: getConsultasPorFecha('dia', 'AbonosClientes')"><span>Hoy</span></div>
                    <div class="col-md-2 center"><span>|</span></div>
                    <div class="col-md-5 center" v-on="click: getConsultasPorFecha('mes', 'AbonosClientes')"><span>Fecha</span></div>
                </div>
            </td>
            <td><p>Anticipos</p><img src="images/consultas/anticipos.png" height=80 width=80></img>
                 <div class="row">
                    <div class="col-md-5 center" v-on="click: getConsultasPorFecha('dia', 'Adelantos')"><span>Hoy</span></div>
                    <div class="col-md-2 center"><span>|</span></div>
                    <div class="col-md-5 center" v-on="click: getConsultasPorFecha('mes', 'Adelantos')"><span>Fecha</span></div>
                </div>
            </td>
            <td><p>Ingresos</p><img src="images/consultas/ingresos.png" height=80 width=80></img>
                 <div class="row">
                    <div class="col-md-5 center" v-on="click: getConsultasPorFecha('dia', 'Ingresos')"><span>Hoy</span></div>
                    <div class="col-md-2 center"><span>|</span></div>
                    <div class="col-md-5 center" v-on="click: getConsultasPorFecha('mes', 'Ingresos')"><span>Fecha</span></div>
                </div>
            </td>
        </tr>
    </table>

    <div v-show="x == 2" class="mqData"></div>
    <div v-show="x == 3" id="returnDiv"></div>
</div>

<script type="text/javascript">

    var queries = new Vue({

        el: '#Master',

        data: {
            x: 1,
            devoluciones: { 
                venta: [],
                detalle_venta: [],
                articulos: []
            }
        },

        computed: {
            totalCantidadDevolucion: function ()
            {
                var total = 0;
                this.devoluciones.articulos.forEach(function(q) {
                    total = total + q.cantidad;
                });
                return total;
            },

            totalMontoDevolucion: function()
            {
                var total = 0;
                this.devoluciones.articulos.forEach(function(q) {
                    total = total + (q.cantidad * q.precio);
                });
                return total;
            }
        },

        methods: {
            /* 
                inicio consultas
                e = this
                consulta = 'dia' , 'mes' , 'fechas'
                modelo = al modelo que desea consultar como este en la Ruta
            */
            getConsultasPorFecha: function(consulta , modelo)
            {
                $.ajax({
                    url: "admin/queries/get"+modelo+"PorFecha/"+consulta,
                    type: "GET",
                }).done(function(data) {
                    $('.dt-container').hide();
                    queries.proccesTable(data.view);
                });
            },

            getActualizarConsultasPorFecha: function(e)
            {
                e.preventDefault(); 
                var form = $(e.target).closest("form");
                $('input[type=submit]', form).prop('disabled', true);

                $.ajax({
                    type: "GET",
                    url: form.attr('action'),
                    data: form.serialize(),
                }).done(function(data) {
                    if (data.success == true)
                    {
                        return queries.proccesTable(data.view);
                    }
                    msg.warning(data, 'Advertencia!');
                    $('input[type=submit]', form).prop('disabled', false);
                });

            },
            /* fin consultas */

            proccesTable: function(data)
            {
                queries.x = 2;
                $('.mqData').html(data);
                $("#iSearch").unbind().val("").focus();
                $("#table_length").html("");
                $( ".DTTT" ).html("");
                $('.dt-panel').show();
                setTimeout(function() {
                    $('#example_length').prependTo("#table_length");
                    $('.dt-container').show();
                    $('#iSearch').keyup(function() {
                        $('#example').dataTable().fnFilter( $(this).val() );
                    });
                    queries_compile();
                }, 100);
            },

            returnToMasterQueries: function()
            {
                queries.x = 1;
            },

            get_ckbox_dev: function()
            {
                var chkArray = [];
                
                $(".ckbox-dev input:checked").each(function() {
                    chkArray.push($(this).closest('td').prev('td').text());
                });
                
                var selected;
                selected = chkArray.join(',');
                
                if(selected.length > 1){
                    alert("You have selected " + selected); 
                }else{
                    alert("Please at least one of the checkbox");   
                }
            },

            pushToDevoluciones: function(event, producto_id, cantidad, precio, index)
            {
                alert(index);
                if ( $(event.target).prop('checked') )
                {
                this.devoluciones.articulos.splice(index, 0, { producto_id: producto_id, cantidad: cantidad, precio: precio, index:index });
                }
                else
                {
                    this.devoluciones.articulos.$remove(index);
                }
            },

            enviarDevolucion: function()
            {
                $.ajax({
                    type: "get",
                    url: 'test',
                    data: { datos: queries.devoluciones },
                }).done(function(data) {
                    alert(data);
                });
            }
        }
    });

    function queries_compile() {
        queries.$nextTick(function() {
            queries.$compile(queries.$el);
        });
    };

    function returnSale(e, venta_id) {
        $.ajax({
            type: "GET",
            url: 'user/ventas/getVentaConDetalleParaDevolucion',
            data: { venta_id: venta_id },
        }).done(function(data) {
            if (data.success == true)
            {
                $('#returnDiv').html(data.table);
                queries.x = 3;
                return queries_compile();
            }
            msg.warning(data, 'Advertencia!');
        });
    };

</script>