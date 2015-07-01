@if(!$ventas)
<tr class="tr_no_data">
    <td> {{ 'No se encontro ningun dato' }} </td>
</tr>
@else
<div class="container_selected" >
    <div class="row">
        <div class="col-md-8">
            <label style="text-align:left"> Total Seleccionado: Q</label>
            <label id="total_selected" ></label>
        </div>
        <div class="col-md-4">
            {{ Form::open(array('data-remote-SelectedPaySales','onSubmit'=>'return false')) }}
            <input type="hidden" name="monto" class="total_selected" value="0">
            <div class="row">
                <div class="col-md-9">
                    <input type="hidden" name="cliente_id" value="{{Input::get('cliente_id')}}">
                   {{ Form::select('metodo_pago_id', MetodoPago::where('id','!=',2)->lists('descripcion', 'id') ,'', array('class'=>'form-control')) }}
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
        <th class="center" width="18%">Usuario</th>
        <th class="center" width="18%">Fecha</th>
        <th class="center" width="18%">Total</th>
        <th class="center" width="18%">Saldo</th>
    </tr>

    @foreach($ventas as $q)
    <tr id="{{ $q->id }}">
        <td> {{ $q->usuario }} </td>
        <td> {{ $q->fecha }} </td>
        <td class="right"> {{ $q->total }} </td>
        <td class="right"> {{ $q->saldo }} </td>
        <td class="widthS center tbutton"  width="10%"> 
            <a href="javascript:void(0);" title="Ver detalle" onclick="showSalesDetail(this)" class="fa fa-plus-square show_detail"> </a>
            <input type="checkbox" name="selectedSales[]" title="Seleccionar" total="{{ $q->saldo }}" value="{{ $q->id }}" class="select"> 

        </td>
    </tr>
    @endforeach

</table>

<div style="float:right" class="pagination"> {{ $ventas->links() }} </div>

@endif