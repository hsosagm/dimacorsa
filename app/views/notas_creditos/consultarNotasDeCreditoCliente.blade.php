<script>
	var graph_container = new Vue({

	    el: '#graph_container',

	    data: {

	        x: 1,

            tabla: {
                adelanto: {{ json_encode($dataAdelanto) }} ,
                devolucion: {{ json_encode($dataDevolucion) }} ,
            },

            envio: {
                notas:[]
            },

            total: 0,
	    },

	    methods: {

	        reset: function() {
	            graph_container.x = graph_container.x - 1;
	        },

	        close: function() {
	            $('#graph_container').hide();
	        },

            agregarNota: function(event, id_nota, id_foraneo, monto)
            {
                if ( $(event.target).is(':checked') )
                {
                    this.envio.notas.push({ id_nota: id_nota, id_foraneo: id_foraneo, monto: monto });
                    this.total += parseFloat(monto);
                }
                else
                {
                    this.envio.notas.forEach(function(q, index)
                    {
                        if( id_nota === q.id_nota) {
                            graph_container.envio.notas.$remove(index);
                            graph_container.total -= parseFloat(monto);
                        }
                    });
                }
            },

            eviarNotasDeCredito: function()
            {
                $.ajax({
            		type: "POST",
            		url: 'user/ventas/pagoConNotasDeCredito',
                    data: { datos: graph_container.envio.notas },
            	}).done(function(data) {
            		if (data.success == true)
            		{
						$.each( data.datos, function( key, value ) {
						  	console.log(value.id_nota + '-' + value.id_foraneo  + '-' + value.monto);
						});
            			return;
            		}
            		msg.warning(data, 'Advertencia!');
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
<div v-show="x == 1" id="container">
	@include('notas_creditos.consultas.notasDeCreditoCliente')
</div>
<div  v-show="x == 2" id="container2"> </div>
<pre>
    @{{envio.notas | json}}
</pre>
