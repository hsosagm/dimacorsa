<div>

    {{ Form::open(array('v-on="submit: generarCotizacion"','class' => "form-generarCotizacion")) }}

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
            </table>
        </div>
        <div class="col-md-6" style="font-size:11px"  v-if="cliente.id">
            <label class="col-md-2" >Nombre:</label>
            <label class="col-md-10" >@{{ cliente.nombre }}</label>
            <label class="col-md-2" >NIT:</label>
            <label class="col-md-4" >@{{ cliente.nit }}</label>
            <label class="col-md-2" >Telefono:</label>
            <label class="col-md-4" >@{{ cliente.telefono }}</label>
            <label class="col-md-12" >@{{ cliente.direccion }}</label>
        </div>
    </div>

    <div class="form-footer footer" align="right">
      <button type="submit" class="btn theme-button inputGuardarCotizacion">Enviar!</button>
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
        <div class="col-sm-6">
            <input type="text" name="nombre" style="width: 100% !important;" class="input sm_input" placeholder="Nombre">
        </div>

        <div class="col-sm-3">
            <input type="text" name="direccion" style="width: 100% !important;" class="input sm_input" placeholder="Direccion">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-3">
            <input type="text" name="nit" style="width: 100% !important;" class="input sm_input" placeholder="Nit">
        </div>

        <div class="col-sm-3">
            <input type="text" name="telefono" style="width: 100% !important;" class="input sm_input" placeholder="Telefono">
        </div>

        <div class="col-sm-3">
            <input type="text" name="email" style="width: 100% !important;" class="sm_input" placeholder="Email">
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
        <div class="col-sm-6">
            <input type="text" name="nombre" style="width: 100% !important;" class="input sm_input" value="@{{ cliente.nombre }}" placeholder="Nombre">
        </div>

        <div class="col-sm-3">
            <input type="text" name="direccion" style="width: 100% !important;" class="input sm_input" value="@{{ cliente.direccion }}" placeholder="Direccion">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-3">
            <input type="text" name="nit" style="width: 100% !important;" class="input sm_input" value="@{{ cliente.nit }}" placeholder="Nit">
        </div>

        <div class="col-sm-3">
            <input type="text" name="telefono" style="width: 100% !important;" class="input sm_input" value="@{{ cliente.telefono }}" placeholder="Telefono">
        </div>

        <div class="col-sm-3">
            <input type="text" name="email" style="width: 100% !important;" class="input sm_input" value="@{{ cliente.email }}" placeholder="Correo">
        </div>
    </div>

    <div class="form-group">
        <div class="col-sm-3"></div>
        <div class="col-sm-3"></div>
        <div class="col-sm-3">
            <input class="btn theme-button inputGuardar" value="Guardar!" type="submit" style="margin-left:110px;">
        </div>
    </div>
    {{ Form::close() }}
</div>

<div class="master-detail">
    <div class="master-detail-body"></div>
</div>

</div>

<script type="text/javascript">
    $('#cliente').autocomplete({
        serviceUrl: '/user/cliente/search',
        onSelect: function (data) {
            app.getInfoCliente(data.id);
            $('#cliente').val("");
            app.verCliente = true;
            $(".inputGuardarVenta").focus();
        }
    });

    app.$nextTick(function() {
        app.$compile(app.$el);
        app.reset();
    });
</script>
