
<script>
 var informeContainerVue = new Vue({

    el: '#graph_container',

    data: {
        x: 1,

        contenedor:{
            titulo:"INFORMES DIARIOS",
            tituloPrincipal:  "INFORMES DIARIOS"
        }
    },

    methods: {

        reset: function() {
            informeContainerVue.x = informeContainerVue.x - 1;
            this.contenedor.titulo = this.contenedor.tituloPrincipal;
        },

        close: function() {
            $('#graph_container').hide();
        },

        informesDelMesPorFecha: function() {
            $fecha = $('#start_hidden').val();

            $.ajax({
                type: "GET",
                url: "verInformeTabla",
                data: {fecha: $fecha},
            }).done(function(data) {
                if (data.success == true) {
        			clean_panel();
        	        $('#graph_container').show();
        	        return $('#graph_container').html(data.view);
                }
                msg.warning(data, "Advertencia!");
            });
        },

        getInformePorProducto: function(e, informe_id) {
            $.ajax({
                type: "GET",
                url: "getInformePorProducto",
                data: {informe_id: informe_id},
            }).done(function(data) {
                if (data.success == true) {
        	        $('#container_consultas').html(data.table);
                    informeContainerVueCompile();
                    informeContainerVue.x = 2;
                    informeContainerVue.contenedor.titulo = data.titulo;
                    return;
                }
                msg.warning(data, "Advertencia!");
            });
        },

        getKardexInformeDelDia: function(e, informe_id) {
            $.ajax({
                type: "GET",
                url: "getKardexInformeDelDia",
                data: {informe_id: informe_id},
            }).done(function(data) {
                if (data.success == true) {
        	        $('#container_consultas').html(data.table);
                    informeContainerVueCompile();
                    informeContainerVue.x = 2;
                    informeContainerVue.contenedor.titulo = data.titulo;
                    return;
                }
                msg.warning(data, "Advertencia!");
            });
        },

        verDetalleInformeGeneral: function(e, informe_id) {
            if ($(e.target).hasClass("hide_detail")) {
                $(e.target).removeClass("hide_detail");
                $(".subtable").hide();
            }
            else {
                $(".hide_detail").removeClass("hide_detail");
                if ( $( ".subtable" ).length ) {
                    $(".subtable").fadeOut("slow", function(){
                        informeContainerVue.getDetalleInformeGeneral(e, informe_id);
                    })
                }
                else {
                    informeContainerVue.getDetalleInformeGeneral(e, informe_id);
                }
            }
        },

        getDetalleInformeGeneral: function(e, informe_id) {
            $(".subtable").remove();
            var nTr = $(e.target).parents("tr")[0];
            $(e.target).addClass("hide_detail");
            $(nTr).after('<tr class="subtable"> <td colspan="5"><div class="grid_detalle_informe"></div></td></tr>');
            $(".subtable").addClass("hide_detail");
            $.ajax({
                type: "GET",
                url: "getDetalleInformeGeneral",
                data: {informe_id: informe_id},
            }).done(function(data) {
                if (data.success == true) {
                    $(".grid_detalle_informe").html(data.table);
                    $(nTr).next(".subtable").fadeIn("slow");
                    return $(e.target).addClass("hide_detail");
                }
                msg.warning(data, "Advertencia!");
            });
        }
   }
});

function informeContainerVueCompile() {
    informeContainerVue.$nextTick(function() {
        informeContainerVue.$compile(informeContainerVue.$el);
    });
}
</script>

<div class="panel_heading master-table short_calendar ">
    <div v-show="x == 1" id="table_length3" class="pull-left"></div>
    <div v-show="x == 2" id="table_length4" class="pull-left"></div>

    <div v-show="x == 1" id="table_length3" class="pull-left" style="margin-left:20px;">
        Fecha:
        <input type="text" id="fechaCierre" data-value="{{Input::get('fecha')}}" name="start">
        <i class="glyphicon glyphicon-repeat fg-theme" style="cursor:pointer" v-on="click: informesDelMesPorFecha"></i>
    </div>

    <div class="pull-left" style="margin-left:20%; margin-top:5px; font-size:20px;">
        @{{ contenedor.titulo }}
    </div>

    <div class="pull-right">
        <button v-show="x > 1" v-on="click: reset" class="btn" title="Regresar"><i class="fa fa-reply"></i></button>
        <button v-on="click: close" class="btn btnremove" title="Cerrar"><i class="fa fa-times"></i></button>
    </div>
</div>

<div v-show="x == 1" id="container">
    <table width="100%" class="table table-theme" id="informes">
        <thead>
            <th class="center" width="23%">Fecha</th>
            <th class="center" width="23%">Inversion</th>
            <th class="center" width="23%">Ctas. X Pagar</th>
            <th class="center" width="23%">Ctas. X Cobrar</th>
            <th class="center" width="8%"></th>
        </thead>
        <tbody>
            @foreach($informes as $if)
                <tr>
                    <td class="center"> {{ $if->created_at }} </td>
                    <td class="right"> {{ f_num::get($if->inversion) }} </td>
                    <td class="right"> {{ f_num::get($if->cuentas_pagar) }} </td>
                    <td class="right"> {{ f_num::get($if->cuentas_cobrar) }} </td>
                    <td class="center">
                        <i class="fa fa-plus-square" style="margin-left:5px" v-on="click: verDetalleInformeGeneral($event, {{ $if->id }})"></i>
                        <i class="fa fa-search" title="ventas" style="margin-left:10px" v-on="click: getInformePorProducto(this, {{ $if->id }})"></i>
                        <i class="fa fa-list" title="kardex" style="margin-left:10px" v-on="click: getKardexInformeDelDia(this, {{ $if->id }})"></i>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div v-show="x == 2" id="container_consultas"></div>

<script type="text/javascript">
    $('#informes').dataTable();
    $("#table_length3").html("");
    $('#informes_length').prependTo("#table_length3");

    var counter = 2;

    var $start = $('input[name="start"]').pickadate(
    {
        selectYears: true,
        selectMonths: true,
        max: true,
        formatSubmit: 'yyyy-m-d',
        format: ' d !de mmmm !de yyyy',
        hiddenName: true,
        onSet: function() {
            if (counter == 2) {
                counter = 0;
                picker_start.set('select', picker_start.get('highlight'));
                $('.short_calendar .picker__table').css('display', 'none');
            };
            $('.short_calendar .picker__table').css('display', 'none');
            counter++;
        },
        onClose: function(element) {
          $('.short_calendar .picker__table').css('display', 'none');
        }
    });

    $('.short_calendar .picker__table').css('display', 'none');
    var picker_start = $start.pickadate('picker')
</script>
