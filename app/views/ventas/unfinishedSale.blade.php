{{ Form::open(array('data-remote-md', 'data-success' => 'Venta Generada')) }}
    
    {{ Form::hidden('cliente_id', $venta->cliente->id) }}

    <div class="row">
        <div class="col-md-6 master-detail-info">
            <table class="master-table">
                <tr>
                    <td>Cliente:</td>
                    <td>
                        <input type="text" id="cliente_id" value="{{$venta->cliente->nombre.' '.$venta->cliente->apellido}}"> 
                        <i class="fa fa-question-circle btn-link theme-c" id="cliente_help"></i>
                        <i class="fa fa-pencil btn-link theme-c" id="cliente_edit"></i>
                        <i class="fa fa-plus-square btn-link theme-c" id="cliente_create"></i>
                    </td>
                </tr>

            </table>
        </div>
        <div class="col-md-6 search-cliente-info"></div>
    </div>

{{ Form::close() }}


<div class="master-detail">
    <div class="master-detail-body">
        @include('ventas.detalle')
    </div>
</div>