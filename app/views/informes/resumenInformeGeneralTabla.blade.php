
<script>
 var informeContainerVue = new Vue({

    el: '#graph_container',

    data: {
        x: 1,

        contenedor:{
            titulo:"INFORMES DIARIOS",
            tituloPrincipal:  "INFORME DIARIO "
        },

        arrayFechas: {{ json_encode($arrayFechas) }}
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
        	        $('#informePorProducto').html(data.table);;
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
        	        $('#kardexInformeDelDia').html(data.table);
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
                if (!data.success)
                    return msg.warning(data, "Advertencia!");

                $(".grid_detalle_informe").html(data.table);
                $(nTr).next(".subtable").fadeIn("slow");
                $(e.target).addClass("hide_detail");
            });
        },

        viewInformeDelDia: function(informe_id, fecha) {
            this.contenedor.titulo = this.contenedor.tituloPrincipal+" DE "+fecha;
            $.ajax({
                type: "GET",
                url: "getDetalleInformeGeneral",
                data: {informe_id: informe_id},
            }).done(function(data) {
                if (!data.success)
                    return msg.warning(data, "Advertencia!");

                $("#detalleInformeTable").html(data.table);
                informeContainerVue.getInformePorProducto(this, informe_id);
                informeContainerVue.getKardexInformeDelDia(this, informe_id);
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
    <div class="row">
        <div class="col-md-2" style="padding-right: 1px !important">
            <div class="list-group scrolling"
                style="max-height:500px !important; min-height:677px !important;
                background: rgb(255, 255, 255) none repeat scroll 0% 0%;">
                <a href="javascript:void(0)" class="list-group-item" v-repeat="fh: arrayFechas"  v-on="click: viewInformeDelDia(fh.id, fh.fecha)">
                    @{{ fh.fecha }}
                </a>
            </div>
        </div>
        <div class="col-md-10" style="padding-left: 1px !important min-height:500px !important;"  >
    		<div  class="panel panel-tab rounded shadow">
    			<div class="panel-heading no-padding">
    				<ul class="impresoras nav nav-tabs nav-pills">
    					<li class="active" width="33%">
    						<a aria-expanded="true" href="#detalleInformeTable" data-toggle="tab">
    							<i class="fa fa-list-alt"></i> <span>Informe</span>
    						</a>
    					</li>
    					<li width="33%">
    						<a aria-expanded="false" href="#informePorProducto" data-toggle="tab">
    							<i class="fa fa-list-alt"></i> <span>Ventas</span>
    						</a>
    					</li>
    					<li width="33%">
    						<a aria-expanded="false" href="#kardexInformeDelDia" data-toggle="tab">
    							<i class="fa fa-list-alt"></i> <span>Kardex</span>
    						</a>
    					</li>
    				</ul>
    			</div>

    			<div class="tab-content divFormPayments">

    				<div class="tab-pane fade inner-all active in" id="detalleInformeTable" style="min-height: 597px ! important;" >
    					@include('informes.detalleInformeGeneral')
    				</div>

    				<div class="tab-pane fade inner-all" id="informePorProducto" style="min-height: 597px ! important;" >
                        {{-- @include('informes.informePorProducto') --}}
    				</div>

    				<div class="tab-pane fade inner-all" id="kardexInformeDelDia" style="min-height: 597px ! important;" >
                        {{-- @include('informes.kardexInformeDelDia') --}}
    				</div>
    			</div>
    		</div>
    	</div>
    </div>
</div>

<div v-show="x == 2" id="container_consultas"></div>

<script type="text/javascript">


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
