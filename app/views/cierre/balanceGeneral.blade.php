
<script>
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

        getVentasDelMes: function (e,fecha) {
            $.ajax({
                type: "GET",
                url: 'admin/cierre/VentasDelMes',
                data: { fecha: fecha },
                success: function (data) {
                    $('#cierres').html(data);
                }
            });
        },

        getSoporteDelMes: function (e,fecha) {
            $.ajax({
                type: "GET",
                url: 'admin/cierre/SoportePorFecha',
                data: { fecha:fecha  },
                success: function (data, text) {
                    $('#cierres').html(data);
                }
            });
        },

        getGastosDelMes: function (e,fecha) {
             $.ajax({
                type: "GET",
                url: 'admin/cierre/GastosPorFecha',
                data: { fecha:fecha },
                success: function (data, text) {
                    $('#cierres').html(data);
                }
            });
        }
    }
});

function graph_container_compile() {
    graph_container.$nextTick(function() {
        graph_container.$compile(graph_container.$el);
    });
}
</script>


<div class="panel_heading">
    <div class="pull-right">
        <button v-show="x > 1" v-on="click: reset" class="btn" title="Regresar"><i class="fa fa-reply"></i></button>
        <button v-on="click: close" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
    </div>
</div>
<div v-show="x == 1" id="container"> @include('cierre.CierreMes') </div>
<div v-show="x == 2" id="cierres"></div>
<div v-show="x == 3" id="cierres_dt"></div>