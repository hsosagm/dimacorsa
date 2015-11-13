<script>
	pagosventa.datos = {{ json_encode($data) }};
	pagosventa.restanteVenta = {{ $data['saldo_restante'] }};
</script>

<div style="margin: 0px 0px 0px !important;" class="row">
	<label class="col-md-6">Saldo restante: @{{ restanteVenta - total | currency ' ' }}</label> <label class="col-md-6">Total: @{{ total | currency ' ' }}</label>
</div>

<table class="table table-striped">
    <thead>
        <tr>
            <th>Fecha</th>
            <th>Monto</th>
            <th></th>
        </tr>
    </thead>
    <tbody class="scrolling">
        <tr v-repeat="nc: datos.notas">
            <td> @{{ nc.fecha }} </td>
            <td class="right"> @{{ nc.monto }} </td>
            <td>
                <div class="ckbox ckbox-success">
					<fieldset @{{ (verificarMonto($event, nc.monto))? "":"disabled" }}>
	                    <input id="chk-@{{nc.id}}" type="checkbox" v-on="click:agregarNota($event, nc.id, nc.monto)">
	                    <label for="chk-@{{nc.id}}"></label>
					</fieldset>
                </div>
            </td>
        </tr>
    </tbody>
</table>
<div class="modal-footer">
	<div class="left col-md-6">
		<button v-on="click: reset" class="btn btn-warning">Cancelar</button>
	</div>
	<div class="right col-md-6">
		<button v-on="click: eviarNotasDeCredito"  v-show="total" class="btn bg-theme btn-info">Agregar</button>
	</div>
</div>
