@if(!$ventas)
    <tr class="tr_no_data">
        <td> {{ 'No se encontro ningun dato' }} </td>
    </tr>
@else
    <div class="container_selected" style="margin-left:10%">
        <div class="row">
            <div class="col-md-2">
                <label style="text-align:left">Monto:</label>
                <label id="total_selected">0.00</label>
            </div>
            <div class="col-md-8">
                {{ Form::open(array('data-remote-SelectedPaySales', 'onSubmit'=>'return false')) }}
                    <input type="hidden" name="cliente_id" value="{{Input::get('cliente_id')}}">
                    <input type="hidden" name="monto" class="total_selected" value="0">

                    <div class="row">
                        <label class="col-md-2" style="text-align:right">Metodo pago:</label>
                        <div class="col-md-2">
                            {{ Form::select('metodo_pago_id', MetodoPago::where('id','!=',2)->where('id','!=',6)
                            ->lists('descripcion', 'id') ,'', array('class'=>'form-control col-md-6')) }}
                        </div>

                        <div class="col-md-6">
                            <textarea name="observaciones" class="form-control" placeholder="Comentario ..." rows="1" style="height: 35px;"></textarea>
                        </div>

                        <div class="col-md-2">
                            <input  class="btn theme-button" type="button" value="Enviar" onclick="SelectedPaySales(this);" >
                        </div>
                    </div>

                {{Form::close()}}
            </div>
        </div>
    </div>

    <table class="SST" cellspacing='0'>

        <tr>
            <th class="center" width="30%">Usuario</th>
            <th class="center" width="15%">Fecha</th>
            <th class="center" width="15%">No. Venta</th>
            <th class="center" width="15%">Total</th>
            <th class="center" width="15%">Saldo</th>
        </tr>

        @foreach($ventas as $q)
            <tr id="{{ $q->id }}">
                <td> {{ $q->usuario }} </td>
                <td> {{ $q->fecha }} </td>
                <td> {{ $q->id }} </td>
                <td class="right"> {{ f_num::get($q->total) }} </td>
                <td class="right"> {{ f_num::get($q->saldo) }} </td>
                <td class="widthS center tbutton"  width="10%"> 
                    <a href="javascript:void(0);" title="Ver detalle" onclick="showSalesDetail(this)" class="fa fa-plus-square show_detail"> </a>
                    <input type="checkbox" name="selectedSales[]" title="Seleccionar" total="{{ $q->saldo }}" value="{{ $q->id }}" class="select"> 

                </td>
            </tr>
        @endforeach

    </table>

    <div style="float:right" class="pagination_sales_by_selection"> {{ $ventas->links() }} </div>

@endif