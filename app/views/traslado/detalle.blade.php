<div class="row">
    <div class="col-md-6">
        {{ Form::open(array('url' => '/admin/traslados/detalle', 'data-remote-md-d2', 'data-success' => 'Traslado Ingresado', 'status' => '0')) }}
        {{ Form::hidden('producto_id') }}
        {{ Form::hidden('traslado_id', $id) }}
        <table class="master-table">
            <tr>
                <td>Codigo:</td>
                <td>Cantidad:</td>
            </tr>
            <tr>
                <td>
                    <input type="text" id="search_producto">
                    <i class="fa fa-search btn-link theme-c" id="md-search"></i> 
                </td>
                <td>
                    <input class="input input_numeric" type="text" name="cantidad"> 
                    <i onclick="ingresarProductoAlDetalle2(this)" class="fa fa-check fg-theme"></i>
                </td>

            </tr>
        </table>
        {{ Form::close() }}
    </div>
    <div class="col-md-6">
        <div class="row master-precios">
            <div class="col-md-4 precio-costo" style="text-align:left;"> </div>
            <div class="col-md-3 existencia" style="text-align:right;"> </div>
        </div>
        <div class="row master-descripcion">
            <div class="col-md-11 descripcion"> </div>
        </div>
    </div>
</div>
<div class="body-detail">
    @include('traslado.detalle_body')
</div>
<div class="form-footer" >
    <div class="row">
        <div class="col-md-6">
            <i class="fa fa-print fa-lg icon-print" onclick=""></i>
        </div>
        <div class="col-md-6" align="right">
            <i class="fa fa-trash-o fa-lg icon-delete" onclick="eliminarTraslado(this,{{$id}});"></i>
            <i class="fa fa-check fa-lg icon-success" onclick="finalizarTraslado(this,{{$id}})"></i>
        </div>
    </div>
</div>
