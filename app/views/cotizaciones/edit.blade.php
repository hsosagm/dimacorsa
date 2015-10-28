<div>
    <input type="hidden" name="cliente_id" v-model="cliente.id">
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
                <tr v-if="cliente.tipocliente">
                    <td colspan="2" v-show="cliente.id" style="padding-top: 6px !important; background: #EEF8F1;">
                        <label class="col-md-6" style="padding-left: 0px !important;">@{{ cliente.nombre }}</label>
                        <label class="col-md-6" >Tipo Cliente: : @{{ cliente.tipocliente.nombre }}</label>
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
    </div>

    <div class="CustomerForm" v-if="showNewCustomerForm" v-transition>
        @include('controles.crearCliente')
    </div>

    <div class="CustomerForm" v-if="showEditCustomerForm" v-transition>
        @include('controles.actualizarClienteVue')
    </div>

<div class="master-detail">
    <div class="master-detail-body">
        @include('cotizaciones.detalle', array('convertir' => 'true'))
    </div>
</div>

</div>

<script type="text/javascript">
    $('#cliente').autocomplete({
        serviceUrl: '/user/cliente/search',
        onSelect: function (data) {
            app.getInfoCliente(data.id);
            $('#cliente').val("");
        }
    });

    app.$nextTick(function() {
        app.reset();
        app.cotizacion_id = {{ $cotizacion_id }};
        app.venta_id = 0;
        app.$compile(app.$el);
        $.get( "/user/cliente/getInfo",  { id: {{ $cotizacion->cliente->id}} }, function( data ) {
            app.cliente = data;
        });
    });
</script>
