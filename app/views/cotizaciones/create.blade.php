<div>
    {{ Form::open(array('v-on="submit: generarCotizacion"','class' => "form-generarCotizacion")) }}
        <input type="hidden" name="cliente_id" v-model="cliente.id" >
        <div class="row">
            @include('controles.encabezadoFormularioCliente')
        </div>
        <div class="form-footer footer" align="right">
          <button type="submit" class="btn theme-button inputGuardarCotizacion">Enviar!</button>
        </div>
    {{ Form::close() }}

    <div class="CustomerForm" v-if="showNewCustomerForm" v-transition>
        @include('controles.crearCliente')
    </div>

    <div class="CustomerForm" v-if="showEditCustomerForm" v-transition>
        @include('controles.actualizarClienteVue')
    </div>

    <div class="master-detail">
        <div class="master-detail-body"></div>
    </div>
</div>

@include('controles.scriptBuscarClienteVue')
