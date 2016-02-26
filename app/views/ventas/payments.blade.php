<div id="pagosventa">
    <div v-show="x==1">
        {{ Form::open(array('url' => '/user/ventas/ModalSalesPayments', 'data-remote-sales-payment')) }}

            {{ Form::hidden('venta_id', Input::get('venta_id')) }}

            <div class="row" style="margin-left:10px">
                <div class="col-md-6"><p>Total a cancelar: @{{ TotalVenta | currency ' '}}</p></div>
                <div v-show="!vuelto" class="col-md-6"><p>Resta abonar: @{{ resta_abonar | currency ' '}}</p></div>
                <div v-show="vuelto" class="col-md-4"><p class="btn-success" style="padding-left:10px">Su vuelto es: @{{ vuelto | currency ' ' }}</p></div>
            </div>
            <div class="row" style="margin-left:20px; width:90%">
                <div class="col-md-5"><p>Monto</p></div>
                <div class="col-md-7"><p>Metodo</p></div>
            </div>
            <div class="row" style="margin-top:10px; margin-left:20px; width:90%">
                <div class="col-md-5"><input class="form-control numeric" type="text" value="{{ $resta_abonar }}" name="monto"></div>
                <div class="col-md-7">{{ Form::select('metodo_pago_id', MetodoPago::where('id','!=',6)->where('id','!=',7)->lists('descripcion', 'id') ,'', array('class'=>'form-control')) }}</div>
            </div>

            <div style="height:150px">
                @include('ventas.payments_detail')
            </div>

            <div class="modal-footer">
            	<div class="left col-md-6">
            		<button type="button" v-on="click: getConsultarNotasDeCreditoDeCliente({{$cliente_id}}, {{Input::get('venta_id')}})" class="btn btn-info">Notas de Credito</button>
            	</div>
            	<div class="right col-md-6">
            		<button class="btn theme-button" type="submit">Enviar</button>
            	</div>
            </div>
        {{Form::close()}}
    </div>
    <div v-show="x==2" id="idConsultarNotasDeCredito">

    </div>
</div>


<script type="text/javascript">

    var pagosventa = new Vue({

        el: '#pagosventa',

        data: {
            x: 1,
            //variables para pagos en ventas
            resta_abonar: {{ $resta_abonar }},
            vuelto: {{ $vuelto }},
            TotalVenta: {{ $TotalVenta }},
            //variables para notas de credito
            datos: [],
            envio: { notas:[] },
			total: 0.00,
			restanteVenta: 0.00,
        },

        methods: {
            reset: function() {
                pagosventa.x -= 1;
                this.datos = [];
                this.envio = { notas:[] };
                this.total = 0.00;
                this.restanteVenta = 0.00;
            },

            getConsultarNotasDeCreditoDeCliente: function(cliente_id, venta_id) {
                $.ajax({
                    type: "GET",
                    url: 'user/notaDeCredito/getConsultarNotasDeCreditoCliente',
                    data: { venta_id: venta_id, cliente_id: cliente_id },
                }).done(function(data) {
                    if (!data.success)
                        return msg.warning(data, 'Advertencia!');
 
                    pagosventa.x = 2;
                    $('#idConsultarNotasDeCredito').html(data.table);
                    pagosventa.$nextTick(function() {
                        pagosventa.$compile(pagosventa.$el);
                    });
                });
            },

            agregarNota: function(event, id_nota,  monto)
            {
                if ($(event.target).is(':checked')) {
					var restante = this.restanteVenta - this.total;
					if(restante < monto){
						return $(event.target).prop('checked', false);
					}

                    this.envio.notas.push({ id_nota: id_nota, monto: monto });
                    this.total += parseFloat(monto);
                }
                else {
                    this.envio.notas.forEach(function(q, index)
                    {
                        if( id_nota === q.id_nota) {
                            pagosventa.envio.notas.$remove(index);
                            pagosventa.total -= parseFloat(monto);
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
						notas_creditos: pagosventa.envio.notas,
						venta_id: pagosventa.datos.enviar.venta_id,
						cliente_id: pagosventa.datos.enviar.cliente_id
					},
            	}).done(function(data) {
            		if (data.success == true)
            		{
						msg.success('Pago ingresado', 'Listo!');
						$('#graph_container').hide();
						$('#graph_container').html("");
						$('.modal-body').html("");
	                    $('.modal-body').html(data.detalle);
						return;
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


$('.numeric').autoNumeric({aSep:',', aNeg:'', mDec:2, mRound:'S', vMax: '999999.99', wEmpty: 'zero', lZero: 'deny', mNum:10});

</script>
