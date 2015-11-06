<script>
	var notasCreditosVue = new Vue({

	    el: '#graph_container',

	    data: {

	        x: 1,

			datos: {{ json_encode($data) }},

            envio: {
                notas:[]
            },

			total: "",

			restanteVenta: {{ $data['saldo_restante'] }},

	    },

	    methods: {

	        reset: function() {
	            notasCreditosVue.x = notasCreditosVue.x - 1;
	        },

	        close: function() {
	            $('#graph_container').hide();
	        },

            agregarNota: function(event, id_nota,  monto)
            {
                if ( $(event.target).is(':checked') )
                {
					var restante = this.restanteVenta - this.total;
					if(restante < monto){
						return $(event.target).prop('checked', false);
					}

                    this.envio.notas.push({ id_nota: id_nota, monto: monto });
                    this.total += parseFloat(monto);
                }
                else
                {
                    this.envio.notas.forEach(function(q, index)
                    {
                        if( id_nota === q.id_nota) {
                            notasCreditosVue.envio.notas.$remove(index);
                            notasCreditosVue.total -= parseFloat(monto);
                        }
                    });
                }
            },

            eviarNotasDeCredito: function()
            {
                // $.ajax({
            	// 	type: "POST",
            	// 	url: 'user/ventas/pagoConNotasDeCredito',
                //     data: {
				// 		datos: notasCreditosVue.envio.notas,
				// 		venta_id: notasCreditosVue.datos.venta_id,
				// 		cliente_id: notasCreditosVue.datos.cliente_id,
				// 		total: notasCreditosVue.total,
				// 		metodo_pago_id: 6
				// 	},
            	// }).done(function(data) {
            	// 	if (data.success == true)
            	// 	{
            	// 		return;
            	// 	}
            	// 	msg.warning(data, 'Advertencia!');
            	// });
            },

			verificarMonto: function(event, monto)
			{
				 if ( monto > this.restanteVenta )
					return false;

				return true;
			}
	    }
    });

    function graph_container_compile() {
	    notasCreditosVue.$nextTick(function() {
	        notasCreditosVue.$compile(graph_container.$el);
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
	@include('notas_creditos.notasCreditosTable')
</div>
<div  v-show="x == 2" id="container2"> </div>
<pre class="right" style="padding-right:25px">
    <button v-on="click: eviarNotasDeCredito" v-show="total" class="btn bg-theme btn-info">Agregar</button>
</pre>

<pre>
	@{{ datos | json }}
	@{{ total | json }}
	@{{ restanteVenta | json }}
</pre>
