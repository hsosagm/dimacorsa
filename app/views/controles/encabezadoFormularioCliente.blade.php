<div class="col-md-6 master-detail-info">
    <table class="master-table">
        <tr>
            <td>Cliente:</td>
            <td>
                <input type="text" id="cliente" class="input" style="width:260px">
                <i v-if="cliente.id" class="fa fa-question-circle btn-link theme-c" id="cliente_help"></i>
                <i v-if="cliente.id" class="fa fa-pencil btn-link theme-c" v-on="click: showEditCustomer"></i>
                <i class="fa fa-plus-square btn-link theme-c" v-on="click: showNewCustomer"></i>
            </td>
        </tr>
    </table>
</div>
<div class="col-md-6" style="font-size:11px"  v-if="cliente.id">
    <label class="col-md-2" >Nombre:</label>
    <label class="col-md-5" >@{{ cliente.nombre }}</label>
    <label class="col-md-2" >NIT:</label>
    <label class="col-md-3" >@{{ cliente.nit }}</label>
    <label class="col-md-2" >Correo:</label>
    <label class="col-md-5" >@{{ cliente.email }}</label>
    <label class="col-md-2" >Telefono:</label>
    <label class="col-md-3" >@{{ cliente.telefono }}</label>
    <label class="col-md-12" >@{{ cliente.direccion }}</label>
</div>
