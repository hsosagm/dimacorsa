<table id="MasterQueries" style="text-align:center">
 
    <tr>
        <td><p>Ventas</p><img src="images/consultas/ventas.png" height=80 width=80></img>
            <div class="row">
                <div class="col-md-5 center" v-on="click: getVentasPorFecha('dia')"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getVentasPorFecha('mes')"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Compras</p><img src="images/consultas/compras.png" height=80 width=80></img>
            <div class="row">
                <div class="col-md-5 center" v-on="click: getComprasPorFecha('dia')"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getComprasPorFecha('mes')"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Descargas</p><img src="images/consultas/descargas.png" height=80 width=80></img>
             <div class="row">
                <div class="col-md-5 center" v-on="click: getDescargasPorFecha('dia')"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getDescargasPorFecha('mes')"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Egresos</p><img src="images/consultas/egresos.png" height=80 width=80></img>
             <div class="row">
                <div class="col-md-5 center" v-on="click: getEgresosPorFecha('dia')"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getEgresosPorFecha('mes')"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Gastos</p><img src="images/consultas/gastos.png" height=80 width=80></img>
             <div class="row">
                <div class="col-md-5 center" v-on="click: getGastosPorFecha('dia')"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getGastosPorFecha('mes')"><span>Fecha</span></div>
            </div>
        </td>
    </tr>

    <tr>
        <td><p>Abonos Proveedores</p><img src="images/consultas/abonos_proveedores.png" height=80 width=80></img>
             <div class="row">
                <div class="col-md-5 center" v-on="click: getAbonosProveedoresPorFecha('dia')"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getAbonosProveedoresPorFecha('mes')"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Soporte</p><img src="images/consultas/soporte.png" height=80 width=80></img>
             <div class="row">
                <div class="col-md-5 center" v-on="click: getSoportePorFecha('dia')"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getSoportePorFecha('mes')"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Abonos Clientes</p><img src="images/consultas/abonos_clientes.png" height=80 width=80></img>
             <div class="row">
                <div class="col-md-5 center" v-on="click: getAbonosClientesPorFecha('dia')"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getAbonosClientesPorFecha('mes')"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Anticipos</p><img src="images/consultas/anticipos.png" height=80 width=80></img>
             <div class="row">
                <div class="col-md-5 center" v-on="click: getAdelantosPorFecha('dia')"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getAdelantosPorFecha('mes')"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Ingresos</p><img src="images/consultas/ingresos.png" height=80 width=80></img>
             <div class="row">
                <div class="col-md-5 center" v-on="click: getIngresosPorFecha('dia')"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getIngresosPorFecha('mes')"><span>Fecha</span></div>
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
            /* inicio consultas de ventas*/
            getVentasPorFecha: function(consulta)
            {
                $.ajax({
                    url: "admin/queries/getVentasPorFecha/"+consulta,
                    type: "GET",
                    data: { fecha_inicial: '2015-05-01', fecha_final:'2015-05-15' },
                }).done(function(data) {
                    $('.dt-container').hide();
                    queries.proccesTable(data.view);
                });
            },
            /* fin consultas de ventas*/

            /* inicio consultas de compras*/
            getComprasPorFecha: function(consulta)
            {
                $.ajax({
                    url: "admin/queries/getComprasPorFecha/"+consulta,
                    type: "GET",
                    data: { fecha_inicial: '2015-05-01', fecha_final:'2015-05-15' },
                }).done(function(data) {
                    $('.dt-container').hide();
                    queries.proccesTable(data.view);
                });
            },
            /* fin consultas de compras*/

            /* inicio consultas de Descargas*/
            getDescargasPorFecha: function(consulta)
            {
                $.ajax({
                    url: "admin/queries/getDescargasPorFecha/"+consulta,
                    type: "GET",
                    data: { fecha_inicial: '2015-05-01', fecha_final:'2015-05-15' },
                }).done(function(data) {
                    $('.dt-container').hide();
                    queries.proccesTable(data.view);
                });
            },
            /* fin consultas de Descargas*/

            /* inicio consultas de Egresos*/
            getEgresosPorFecha: function(consulta)
            {
                $.ajax({
                    url: "admin/queries/getEgresosPorFecha/"+consulta,
                    type: "GET",
                    data: { fecha_inicial: '2015-05-01', fecha_final:'2015-05-15' },
                }).done(function(data) {
                    $('.dt-container').hide();
                    queries.proccesTable(data.view);
                });
            },
            /* fin consultas de Egresos*/

            /* inicio consultas de Gastos*/
            getGastosPorFecha: function(consulta)
            {
                $.ajax({
                    url: "admin/queries/getGastosPorFecha/"+consulta,
                    type: "GET",
                    data: { fecha_inicial: '2015-05-01', fecha_final:'2015-05-15' },
                }).done(function(data) {
                    $('.dt-container').hide();
                    queries.proccesTable(data.view);
                });
            },
            /* fin consultas de Gastos*/

            /* inicio consultas de AbonosProveedores*/
            getAbonosProveedoresPorFecha: function(consulta)
            {
                $.ajax({
                    url: "admin/queries/getAbonosProveedoresPorFecha/"+consulta,
                    type: "GET",
                    data: { fecha_inicial: '2015-05-01', fecha_final:'2015-05-15' },
                }).done(function(data) {
                    $('.dt-container').hide();
                    queries.proccesTable(data.view);
                });
            },
            /* fin consultas de AbonosProveedores*/

            /* inicio consultas de Soporte*/
            getSoportePorFecha: function(consulta)
            {
                $.ajax({
                    url: "admin/queries/getSoportePorFecha/"+consulta,
                    type: "GET",
                    data: { fecha_inicial: '2015-05-01', fecha_final:'2015-05-15' },
                }).done(function(data) {
                    $('.dt-container').hide();
                    queries.proccesTable(data.view);
                });
            },
            /* fin consultas de Soporte*/
            getAbonosClientesPorFecha: function(consulta)
            {
                $.ajax({
                    url: "admin/queries/getAbonosClientesPorFecha/"+consulta,
                    type: "GET",
                    data: { fecha_inicial: '2015-05-01', fecha_final:'2015-05-15' },
                }).done(function(data) {
                    $('.dt-container').hide();
                    queries.proccesTable(data.view);
                });
            },
            /* fin consultas de AbonosClientes*/

            /* inicio consultas de Adelantos*/
            getAdelantosPorFecha: function(consulta)
            {
                $.ajax({
                    url: "admin/queries/getAdelantosPorFecha/"+consulta,
                    type: "GET",
                    data: { fecha_inicial: '2015-05-01', fecha_final:'2015-05-15' },
                }).done(function(data) {
                    $('.dt-container').hide();
                    queries.proccesTable(data.view);
                });
            },
            /* fin consultas de Adelantos*/

            /* inicio consultas de Ingresos*/
            getIngresosPorFecha: function(consulta)
            {
                $.ajax({
                  url: "admin/queries/getIngresosPorFecha/"+consulta,
                  type: "GET",
                  data: { fecha_inicial: '2015-05-01', fecha_final:'2015-05-15' },
                }).done(function(data) {
                    $('.dt-container').hide();
                    queries.proccesTable(data.view);
                });
            },
            /* fin consultas de Ingresos*/

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