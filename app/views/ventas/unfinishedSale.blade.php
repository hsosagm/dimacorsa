<div>

{{ Form::open(array('v-on="submit: generarVenta"')) }}
    
    <input type="hidden" name="cliente_id" v-model="cliente.id">

    <div class="row">
        <div class="col-md-6 master-detail-info">
            <table class="master-table">
                <tr>
                    <td>Cliente:</td>
                    <td>
                        <input type="text" id="cliente" class="input">
                        <i v-if="cliente.id" class="fa fa-question-circle btn-link theme-c" id="cliente_help"></i>
                        <i v-if="cliente.id" class="fa fa-pencil btn-link theme-c" v-on="click: showEditCustomer"></i>
                        <i class="fa fa-plus-square btn-link theme-c" v-on="click: showNewCustomer"></i>
                    </td>
                </tr>

            </table>
        </div>
        <div class="col-md-6"><label v-show="cliente.id">@{{fullName}}</label></div>
    </div>

    <div v-show="!venta_id" class="form-footer footer" align="right">
          <button type="submit" class="btn theme-button">Enviar!</button>
    </div>

{{ Form::close() }}


<div class="CustomerForm" v-if="showNewCustomerForm" v-transition>
    {{ Form::open(array('url' => '/user/cliente/create', 'v-on="submit: createNewCustomer"')) }}
        <div class="form-group">
            <div class="col-sm-3">
                <h4>Nuevo cliente</h4>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-3">
                <input type="text" name="nombre" class="input sm_input" placeholder="Nombre">
            </div>

            <div class="col-sm-3">
                <input type="text" name="apellido" class="input sm_input" placeholder="Apellido">
            </div>

            <div class="col-sm-3">
                <input type="text" name="direccion" class="input sm_input" placeholder="Direccion">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-3">
                <input type="text" name="nit" class="input sm_input" placeholder="Nit">
            </div>

            <div class="col-sm-3">
                <input type="text" name="telefono" class="input sm_input" placeholder="Telefono">
            </div>

            <div class="col-sm-3">
                <input type="text" name="email" class="input sm_input" placeholder="Email">
            </div>
        </div>

    <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-3"></div>
        <div class="col-sm-3">
            <input class="btn theme-button" value="Guardar!" type="submit" style="margin-left:110px;">
        </div>
    </div>
    {{ Form::close() }}

</div>


<div class="CustomerForm" v-if="showEditCustomerForm" v-transition>
    {{ Form::open(array('url' => '/user/cliente/edit', 'v-on="submit: editCustomer"')) }}
        <input type="hidden" name="id" v-model="cliente.id">

        <div class="form-group">
            <div class="col-sm-3">
                <h4>Editar cliente</h4>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-3">
                <input type="text" name="nombre" class="input sm_input" value="@{{ cliente.nombre }}">
            </div>

            <div class="col-sm-3">
                <input type="text" name="apellido" class="input sm_input" value="@{{ cliente.apellido }}">
            </div>

            <div class="col-sm-3">
                <input type="text" name="direccion" class="input sm_input" value="@{{ cliente.direccion }}">
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-3">
                <input type="text" name="nit" class="input sm_input" value="@{{ cliente.nit }}">
            </div>

            <div class="col-sm-3">
                <input type="text" name="telefono" class="input sm_input" value="@{{ cliente.telefono }}">
            </div>

            <div class="col-sm-3">
                <input type="text" name="email" class="input sm_input" value="@{{ cliente.email }}">
            </div>
        </div>

    <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-3"></div>
        <div class="col-sm-3">
            <input class="btn theme-button" value="Guardar!" type="submit" style="margin-left:110px;">
        </div>
    </div>
    {{ Form::close() }}

</div>


<div class="master-detail">
    <div class="master-detail-body">
        @include('ventas.detalle')
    </div>
</div>

</div>

<script type="text/javascript">

    $('#cliente').autocomplete({
        serviceUrl: '/user/cliente/buscar',
        onSelect: function (data) {
            app.getInfoCliente(data.id);
            $('#cliente').val("");
        }
    });


    app.$nextTick(function() {
        app.$compile(app.$el);
        app.reset();
        app.getInfoCliente({{$venta->cliente->id}});
    });

</script>