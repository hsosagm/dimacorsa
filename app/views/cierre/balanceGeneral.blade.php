
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
       },

       cierreDelMesPorFecha: function(){
            $fecha = $('#start_hidden').val();
            $.ajax({
                type: "GET",
                url: 'admin/cierre/CierreDelMesPorFecha',
                data: { fecha: $fecha },
                contentType: 'application/x-www-form-urlencoded',
                success: function (data, text) {
                    clean_panel();
                    $('#graph_container').show();
                    $('#graph_container').html(data);
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


<div class="panel_heading master-table short_calendar ">
        <tr>
            <td>Fecha:</td>
            <td><input type="text" id="fechaCierre" data-value="{{$data['fecha_input']}}" name="start"></td>
            <i class="glyphicon glyphicon-repeat fg-theme" style="cursor:pointer" v-on="click: cierreDelMesPorFecha"></i>
        </tr>
    <div class="pull-right">
        <button v-show="x > 1" v-on="click: reset" class="btn" title="Regresar"><i class="fa fa-reply"></i></button>
        <button v-on="click: close" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
    </div>
</div>
<div v-show="x == 1" id="container"> @include('cierre.CierreMes') </div>
<div v-show="x == 2" id="cierres"></div>
<div v-show="x == 3" id="cierres_dt"></div>


<script>
    var counter = 2;

    var $start = $('input[name="start"]').pickadate(
    {
        selectYears: true,
        selectMonths: true,
        min: [<?php echo $data['dia_inicio']->year ?>, <?php echo $data['dia_inicio']->month - 1 ?>, <?php echo $data['dia_inicio']->day ?>],
        max: true,
        formatSubmit: 'yyyy-m-d',
        hiddenName: true,
        onSet: function() {
            if (counter == 2) {
                counter = 0;
                picker_start.set('select', picker_start.get('highlight'));
            };
            counter++;
        },
        onClose: function(element) {
          
        }
    });

    var picker_start = $start.pickadate('picker')
</script>