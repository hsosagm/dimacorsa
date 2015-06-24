@if(!$compras)
<tr class="tr_no_data">
    <td> {{ 'No se encontro ningun dato' }} </td>
</tr>
@else
<div class="container_selected" >
    <div class="row">
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-3">
                    <label style="text-align:left"> Total Seleccionado: </label>
                </div>
                <div class="col-md-3">
                    <input type="text" class="total_selected form-control" value="0" disabled>
                </div>
                <div class="col-md-4"></div>

            </div>
        </div>
        <div class="col-md-4">
            {{ Form::open(array('data-remote-SelectedPayPurchases','onSubmit'=>'return false')) }}
            <div class="row">
                <div class="col-md-9">
                    <input type="hidden" name="proveedor_id" value="{{Input::get('proveedor_id')}}">
                    {{ Form::select('metodo_pago_id', MetodoPago::where('id','!=',2)->lists('descripcion', 'id') ,'', array('class'=>'form-control')) }}
                </div>
                <div class="col-md-2">
                    <input  class="btn theme-button" type="button" value="Enviar" onclick="SelectedPayPurchases(this);" >
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
        <th class="center" width="18%">Factura</th>
        <th class="center" width="18%">Total</th>
        <th class="center" width="18%">Saldo</th>
    </tr>

    @foreach($compras as $q)
    <tr id="{{ $q->id }}">
        <td> {{ $q->usuario }} </td>
        <td> {{ $q->fecha }} </td>
        <td> {{ $q->numero_documento }} </td>
        <td class="right"> {{ $q->total }} </td>
        <td class="right"> {{ $q->saldo }} </td>
        <td class="widthS center tbutton"  width="10%"> 
            <a href="javascript:void(0);" title="Ver detalle" onclick="showPurchasesDetail(this)" class="fa fa-plus-square show_detail"> </a>
            <input type="checkbox" name="selectedPurshase[]" title="Seleccionar" total="{{ $q->saldo }}" compra_id="{{ $q->id }}" value="{{ $q->id }}" class="select">
        </td>
    </tr>
    @endforeach

</table>
<div style="float:right" class="pagination"> {{ $compras->links() }} </div>

@endif