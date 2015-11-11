<script>
	var notasCreditosVue = new Vue({

	    el: '#graph_container',

	    data: {

	        x: 1,

			datos: {{ json_encode($data) }},

            envio: {
                notas:[]
            },

			total: 0.00,

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
                $.ajax({
            		type: "POST",
            		url: 'user/ventas/pagoConNotasDeCredito',
                    data: {
						notas_creditos: notasCreditosVue.envio.notas,
						info: notasCreditosVue.datos.enviar
					},
            	}).done(function(data) {
            		if (data.success == true)
            		{
						msg.success('Pago ingresado', 'Listo!');
	                    return $('.modal-body').html(data.detalle);
            		}
            		msg.warning(data, 'Advertencia!');
            	});
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
<pre style="margin: 0px 0px 0px !important;" class="row">
	<label class="col-md-4">Saldo restante: @{{ restanteVenta - total | currency ' ' }}</label> <label class="col-md-4">Total: @{{ total | currency ' ' }}</label>
</pre>
<div v-show="x == 1" id="container">
	@include('notas_creditos.notasCreditosTable')
</div>
<div  v-show="x == 2" id="container2"> </div>
<pre class="right" style="padding-right:25px">
    <button v-on="click: eviarNotasDeCredito" v-show="total" class="btn bg-theme btn-info">Agregar</button>
</pre>
