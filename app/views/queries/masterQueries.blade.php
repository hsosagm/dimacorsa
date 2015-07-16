<table id="MasterQueries" style="text-align:center">

    <tr>
        <td><p>Ventas</p><img src="images/consultas/ventas.png" height=80 width=80></img>
            <div class="row">
                <div class="col-md-5 center" v-on="click: getVentasDelDia(this)"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getVentasPorFecha(this)"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Compras</p><img src="images/consultas/compras.png" height=80 width=80></img>
            <div class="row">
                <div class="col-md-5 center" v-on="click: getComprasDelDia(this)"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center" v-on="click: getComprasPorFecha(this)"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Descargas</p><img src="images/consultas/descargas.png" height=80 width=80></img>
            <div class="row">
                <div class="col-md-5 center"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Egresos</p><img src="images/consultas/egresos.png" height=80 width=80></img>
            <div class="row">
                <div class="col-md-5 center"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Gastos</p><img src="images/consultas/gastos.png" height=80 width=80></img>
            <div class="row">
                <div class="col-md-5 center"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center"><span>Fecha</span></div>
            </div>
        </td>
    </tr>

    <tr>
        <td><p>Abonos Proveedores</p><img src="images/consultas/abonos_proveedores.png" height=80 width=80></img>
            <div class="row">
                <div class="col-md-5 center"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Soporte</p><img src="images/consultas/soporte.png" height=80 width=80></img>
            <div class="row">
                <div class="col-md-5 center"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Abonos Clientes</p><img src="images/consultas/abonos_clientes.png" height=80 width=80></img>
            <div class="row">
                <div class="col-md-5 center"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Anticipos</p><img src="images/consultas/anticipos.png" height=80 width=80></img>
            <div class="row">
                <div class="col-md-5 center"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center"><span>Fecha</span></div>
            </div>
        </td>
        <td><p>Ingresos</p><img src="images/consultas/ingresos.png" height=80 width=80></img>
            <div class="row">
                <div class="col-md-5 center"><span>Hoy</span></div>
                <div class="col-md-2 center"><span>|</span></div>
                <div class="col-md-5 center"><span>Fecha</span></div>
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
            getVentasDelDia: function()
            {
                $.ajax({
                  url: "admin/queries/getVentasPorFecha/dia",
                  type: "GET"
                }).done(function(data) {
                    $('.dt-container').hide();
                    queries.proccesTable(data.view);
                });
            },
            getVentasPorFecha: function()
            {
                $.ajax({
                  url: "admin/queries/getVentasPorFecha/mes",
                  type: "GET"
                }).done(function(data) {
                    $('.dt-container').hide();
                    queries.proccesTable(data.view);
                });
            },
            getVentasPorFechas: function()
            {
                $.ajax({
                  url: "admin/queries/getVentasPorFecha/fechas",
                  type: "GET",
                  data: { fecha_inicial: '2015-05-01', fecha_final:'2015-05-15' },
                }).done(function(data) {
                    $('.dt-container').hide();
                    queries.proccesTable(data.view);
                });
            },
            /* fin consultas de ventas*/

            /* inicio consultas de compras*/
            getComprasDelDia: function()
            {
                $.ajax({
                  url: "admin/queries/getComprasPorFecha/dia",
                  type: "GET"
                }).done(function(data) {
                    $('.dt-container').hide();
                    queries.proccesTable(data.view);
                });
            },
            getComprasPorFecha: function()
            {
                $.ajax({
                  url: "admin/queries/getComprasPorFecha/mes",
                  type: "GET"
                }).done(function(data) {
                    $('.dt-container').hide();
                    queries.proccesTable(data.view);
                });
            },
            getComprasPorFechas: function()
            {
                $.ajax({
                  url: "admin/queries/getComprasPorFecha/fechas",
                  type: "GET",
                  data: { fecha_inicial: '2015-05-01', fecha_final:'2015-05-15' },
                }).done(function(data) {
                    $('.dt-container').hide();
                    queries.proccesTable(data.view);
                });
            },
            /* fin consultas de compras*/

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