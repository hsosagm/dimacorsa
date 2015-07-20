<div id="Master">

    <table id="MasterQueries" v-if="showMaster" style="text-align:center">
     
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

    <div class="mqData"></div>

</div>

<script type="text/javascript">

    var queries = new Vue({

        el: '#Master',

        data: {
            showMaster: true
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
                    success: function (data) {
                        if (data.success == true)
                        {
                            return queries.proccesTable(data.view);
                        }
                        msg.warning(data, 'Advertencia!');
                        $('input[type=submit]', form).prop('disabled', false);
                    }
                });
            },
            /* fin consultas */

            proccesTable: function(data)
            {
                queries.showMaster = false;
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
            }
       }
    });

    function queries_compile() {
        queries.$nextTick(function() {
            queries.$compile(queries.$el);
        });
    }

</script>