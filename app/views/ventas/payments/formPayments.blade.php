<div id="formPayments" class="panel panel-tab rounded shadow">
	<div class="panel-heading no-padding">
		<ul class="nav nav-tabs nav-pills">
			<li class="active" id="saldo_vencido">
				<a aria-expanded="true" href="#tab1" data-toggle="tab">
					<i class="fa fa-paypal"></i> <span>Saldo Vencido</span>
				</a>
			</li>
			<li class="" id="saldo_total">
				<a aria-expanded="false" href="#tab2" data-toggle="tab">
					<i class="fa fa-paypal"></i> <span>Saldo Total</span>
				</a>
			</li>
			<li class="" id="saldo_parcial">
				<a aria-expanded="false" href="#tab3" data-toggle="tab">
					<i class="fa fa-paypal"></i> <span>Saldo Parcial</span>
				</a>
			</li>
			<li>
				<a aria-expanded="false" href="#tab4" data-toggle="tab" onclick="GetSalesForPaymentsBySelection();">
					<i class="fa fa-paypal"></i> <span>Seleccionar ventas</span>
				</a>
			</li>
		</ul>
	</div>

	<div class="panel-body tab-content panel-body-abonos">

		<div class="tab-pane fade inner-all active in" id="tab1">

			{{ Form::open(array('v-on="submit: onSubmitForm"')) }}

				<input type="hidden" name="cliente_id" value="{{$cliente_id}}">

				<div class="row">
					<div class="form-group">
						<div class="col-md-5">
						    <input name="monto" value="{{ Crypt::encrypt($saldo_vencido) }}" class="">
							<input class="form-control" value="{{ f_num::get($saldo_vencido) }}" disabled>
						</div>
						<div class="col-md-5">
							{{ Form::select('metodo_pago_id', MetodoPago::lists('descripcion', 'id') ,'', array('class'=>'form-control')) }}
						</div>
						<div class="col-md-2">
							<button class="form-control">nota</button>
						</div>
					</div>
				</div>

				<div class="abonosDetalle"></div>

				<div class="form-footer" align="right">
					<input  class="btn theme-button" type="submit" value="Enviar" >
				</div>

			{{Form::close()}}

		</div>

		<div class="tab-pane fade inner-all" id="tab2">
			{{ Form::open(array('v-on="submit: onSubmitForm"')) }}
				<input type="hidden" name="cliente_id" value="{{$cliente_id}}">
				<div class="row">
					<div class="form-group">
						<div class="col-md-5">
							<input name="monto" class="form-control" value="{{ $saldo_total }}" disabled="true">
						</div>
						<div class="col-md-5">
							{{ Form::select('metodo_pago_id', MetodoPago::lists('descripcion', 'id') ,'', array('class'=>'form-control')) }}
						</div>
						<div class="col-md-2">
							<button class="form-control">nota</button>
						</div>
					</div>
				</div>

				<div class="abonosDetalle"></div>

				<div class="form-footer" align="right">
					<button class="btn btn-default" data-dismiss="modal" type="button">Cerrar!</button>
					<input  class="btn theme-button" type="submit" value="Enviar" >
				</div>
			{{Form::close()}}
		</div>

		<div class="tab-pane fade inner-all" id="tab3">
			{{ Form::open(array('v-on="submit: onSubmitForm"')) }}
				<input type="hidden" name="cliente_id" value="{{$cliente_id}}">
				<div class="row">
					<div class="form-group">
						<div class="col-md-5">
							<input name="monto" class="form-control" placeholder="Monto">
						</div>
						<div class="col-md-5">
							{{ Form::select('metodo_pago_id', MetodoPago::lists('descripcion', 'id') ,'', array('class'=>'form-control')) }}
						</div>
						<div class="col-md-2">
							<button class="form-control">nota</button>
						</div>
					</div>
				</div>

				<div class="abonosDetalle"></div>

				<div class="form-footer" align="right">
					<button class="btn btn-default" data-dismiss="modal" type="button">Cerrar!</button>
					<input  class="btn theme-button" type="submit" value="Enviar" >
				</div>
			{{Form::close()}}
		</div>

		<div class="tab-pane fade inner-all abonosDetalle" id="tab4">Cargando . . .</div>

	</div>

</div>


<script type="text/javascript">

new Vue({

    el: '#formPayments',

    methods: {

        onSubmitForm: function(e) {

            e.preventDefault();

            var form = $(e.target).closest("form");

            $.ajax({
                type: form.attr('method'),
                url: form.attr('action'),
                data: form.serialize(),
                success: function (data) {
                	alert(data);
                },
                error: function(errors){

                }
            });
        }
    }
});

</script>