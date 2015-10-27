<div>
    {{ Form::open(array('v-on="submit: generarVenta"','class' => "form-generarVenta")) }}
        <input type="hidden" name="cliente_id" v-model="cliente.id" >
        <div class="row">
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
                    <tr>
                        <td colspan="2" v-if="cliente.id" style="padding-top: 6px !important; background: #EEF8F1;">
                            <label class="col-md-6" style="padding-left: 0px !important;">@{{ cliente.nombre }}</label>
                            <label class="col-md-6" >Tipo Cliente: : @{{ cliente.tipocliente.nombre }}</label>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6" style="font-size:11px"  v-if="cliente.id">
                <label class="col-md-3 btn-success" >Saldo total:</label>
                <label class="col-md-3 btn-success" >@{{ cliente.saldo_total | currency ' '}}</label>
                <label class="col-md-3 btn-danger" >Saldo Vencido:</label>
                <label class="col-md-3 btn-danger" >@{{ cliente.saldo_vencido | currency ' '}}</label>
                <label class="col-md-3 border-theme" >Limite de Credito:</label>
                <label class="col-md-3" >@{{ cliente.limite_credito | currency ' '}}</label>
                <label class="col-md-3" >Saldo Disponible:</label>
                <label class="col-md-3" >@{{ (cliente.limite_credito - cliente.saldo_total) | currency ' '}}</label>
                <label class="col-md-6" >@{{ cliente.direccion }}</label>
                <label class="col-md-3" >NIT: @{{ cliente.nit }}</label>
                <label class="col-md-3" >Tel: @{{ cliente.telefono }}</label>
            </div>
        </div>
        <div v-show="!venta_id" class="form-footer footer" align="right">
              <button type="submit" class="btn theme-button inputGuardarVenta">Enviar!</button>
        </div>
    {{ Form::close() }}

    <div class="CustomerForm" v-if="showNewCustomerForm" v-transition>
        @@include('controles.crearCliente')
    </div>

    <div class="CustomerForm" v-if="showEditCustomerForm" v-transition>
        @@include('controles.actualizarClienteVue')
    </div>

    <div class="master-detail">
        <div class="master-detail-body"></div>
    </div>

</div>

@@include('controles.scriptBuscarClienteVue')
