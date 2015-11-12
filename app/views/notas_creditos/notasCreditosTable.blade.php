<table class="table table-striped">
    <thead>
        <tr>
            <th>Usuario</th>
            <th>Monto</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <tr v-repeat="nc: datos.notas">
            <td> @{{ nc.usuario }} </td>
            <td> @{{ nc.monto }} </td>
            <td>
                <div class="ckbox ckbox-success" v-show="verificarMonto($event, nc.monto)">
                    <input id="chk-@{{nc.id}}" type="checkbox" v-on="click:agregarNota($event, nc.id, nc.monto)">
                    <label for="chk-@{{nc.id}}"></label>
                </div>
            </td>
        </tr>
    </tbody>
</table>
 
