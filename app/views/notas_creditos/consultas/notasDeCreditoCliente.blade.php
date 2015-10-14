<div class="panel-body" style="padding:0px;">
    <table width="100%" class="table table-default">
        <thead>
            <tr>
                <th align="center">Fecha</th>
                <th align="center">Usuario</th>
                <th align="center">Cliente</th>
                <th align="center">Tipo</th>
                <th align="center">Nota</th>
                <th align="center">Monto</th>
                <th align="center"></th>
            </tr>
        </thead>
        <tbody>
            <tr v-repeat="anc: tabla.adelanto">
                <td> @{{ anc.fecha }} </td>
                <td> @{{ anc.usuario }} </td>
                <td> @{{ anc.cliente }} </td>
                <td> @{{ anc.tipo }} </td>
                <td> @{{ anc.nota }} </td>
                <td class="right"> @{{ anc.monto | currency ' '}} </td>
                <td>
                    <div class="ckbox ckbox-teal" style="margin-left:30px;">
						<input id="checkbox-@{{ anc.id }}-@{{ anc.id_foraneo }}" type="checkbox"
                        v-on="click: agregarNota($event, anc.id, anc.id_foraneo, anc.monto)">
						<label for="checkbox-@{{ anc.id }}-@{{ anc.id_foraneo }}"></label>
					</div>
                </td>
            </tr>

            <tr v-repeat="dnc: tabla.devolucion">
                <td> @{{ dnc.fecha }} </td>
                <td> @{{ dnc.usuario }} </td>
                <td> @{{ dnc.cliente }} </td>
                <td> @{{ dnc.tipo }} </td>
                <td> @{{ dnc.nota }} </td>
                <td class="right"> @{{ dnc.monto | currency ' '}} </td>
                <td>
                    <div class="ckbox ckbox-teal" style="margin-left:30px;">
						<input id="checkbox-@{{ dnc.id }}-@{{ dnc.id_foraneo }}" type="checkbox"
                        v-on="click: agregarNota($event, dnc.id, dnc.id_foraneo, dnc.monto)">
						<label for="checkbox-@{{ dnc.id }}-@{{ dnc.id_foraneo }}"></label>
					</div>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" class="right"> Total:</td>
                <td class="right"> @{{ total | currency ' '}} </td>
                <td></td>
            </tr>
            <tr>
                <td colspan="6"></td>
                <td>
                    <button v-on="click: eviarNotasDeCredito" class="btn bg-theme form-control">Agregar</button>
                </td>
            </tr>
        </tfoot>
    </table>
</div>
