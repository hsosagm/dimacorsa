<table id="MasterQueries" style="text-align:center">
 
    <tr>
        <td><p>Ventas</p><img src="images/consultas/ventas.png" height=80 width=80></img>
            <div class="row">
                <div class="col-md-5 center" v-on="click: getConsultasPorFecha(this, 'dia', 'Ventas')"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getConsultasPorFecha(this, 'mes', 'Ventas')"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Compras</p><img src="images/consultas/compras.png" height=80 width=80></img>
            <div class="row">
                <div class="col-md-5 center" v-on="click: getConsultasPorFecha(this, 'dia', 'Compras')"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getConsultasPorFecha(this, 'mes', 'Compras')"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Descargas</p><img src="images/consultas/descargas.png" height=80 width=80></img>
             <div class="row">
                <div class="col-md-5 center" v-on="click: getConsultasPorFecha(this, 'dia', 'Descargas')"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getConsultasPorFecha(this, 'mes', 'Descargas')"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Egresos</p><img src="images/consultas/egresos.png" height=80 width=80></img>
             <div class="row">
                <div class="col-md-5 center" v-on="click: getConsultasPorFecha(this, 'dia', 'Egresos')"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getConsultasPorFecha(this, 'mes', 'Egresos')"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Gastos</p><img src="images/consultas/gastos.png" height=80 width=80></img>
             <div class="row">
                <div class="col-md-5 center" v-on="click: getConsultasPorFecha(this, 'dia', 'Gastos')"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getConsultasPorFecha(this, 'mes', 'Gastos')"><span>Fecha</span></div>
            </div>
        </td>
    </tr>

    <tr>
        <td><p>Abonos Proveedores</p><img src="images/consultas/abonos_proveedores.png" height=80 width=80></img>
             <div class="row">
                <div class="col-md-5 center" v-on="click: getConsultasPorFecha(this, 'dia', 'AbonosProveedores')"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getConsultasPorFecha(this, 'mes', 'AbonosProveedores')"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Soporte</p><img src="images/consultas/soporte.png" height=80 width=80></img>
             <div class="row">
                <div class="col-md-5 center" v-on="click: getConsultasPorFecha(this, 'dia', 'Soporte')"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getConsultasPorFecha(this, 'mes', 'Soporte')"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Abonos Clientes</p><img src="images/consultas/abonos_clientes.png" height=80 width=80></img>
             <div class="row">
                <div class="col-md-5 center" v-on="click: getConsultasPorFecha(this, 'dia', 'AbonosClientes')"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getConsultasPorFecha(this, 'mes', 'AbonosClientes')"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Anticipos</p><img src="images/consultas/anticipos.png" height=80 width=80></img>
             <div class="row">
                <div class="col-md-5 center" v-on="click: getConsultasPorFecha(this, 'dia', 'Adelantos')"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getConsultasPorFecha(this, 'mes', 'Adelantos')"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Ingresos</p><img src="images/consultas/ingresos.png" height=80 width=80></img>
             <div class="row">
                <div class="col-md-5 center" v-on="click: getConsultasPorFecha(this, 'dia', 'Ingresos')"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getConsultasPorFecha(this, 'mes', 'Ingresos')"><span>Fecha</span></div>
            </div>
        </td>
    </tr>

</table>


<script type="text/javascript">

    var queries = new Vue({

        el: '#MasterQueries',

        data: {
            cliente: []
        },

        methods: {
            /* 
                inicio consultas
                e = this
                consulta = 'dia' , 'mes' , 'fechas'
                modelo = al modelo que desea consultar como este en la Ruta
            */
            getConsultasPorFecha: function(e, consulta , modelo)
            {
                $.ajax({
                    url: "admin/queries/get"+modelo+"PorFecha/"+consulta,
                    type: "GET",
                    data: { fecha_inicial: '2015-05-01', fecha_final:'2015-05-15' },
                }).done(function(data) {
                    $('.dt-container').hide();
                    queries.proccesTable(data.view);
                });
            },
            /* fin consultas */

            proccesTable: function(data)
            {
                $('.table').html(data);
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
                }, 100);
            }
       }
    });

    function queries_compile() {
        app.$nextTick(function() {
            app.$compile(app.$el);
        });
    }

</script>