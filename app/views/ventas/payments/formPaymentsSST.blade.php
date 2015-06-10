@if(!$ventas)
    <tr class="tr_no_data">
        <td> {{ 'No se encontro ningun dato' }} </td>
    </tr>
@else

    <table class="SST" cellspacing='0'>
        <tr>
            <th class="center" width="18%">Usuario</th>
            <th class="center" width="18%">Fecha</th>
            <th class="center" width="18%">Factura</th>
            <th class="center" width="18%">Total</th>
            <th class="center" width="18%">Saldo</th>
        </tr>

        @foreach($ventas as $q)
            <tr id="{{ $q->id }}">
                <td> {{ $q->usuario }} </td>
                <td> {{ $q->fecha }} </td>
                <td> {{ $q->numero_documento }} </td>
                <td class="right"> {{ $q->total }} </td>
                <td class="right"> {{ $q->saldo }} </td>
                <td class="widthS center tbutton"  width="10%"> 
                    <a href="javascript:void(0);" title="Ver detalle" onclick="showSalesDetail(this)" class="fa fa-plus-square show_detail"> 
                    <a href="javascript:void(0);" title="Seleccionar" onclick="" class="select fa fa-check-square-o"> 
                </td>
            </tr>
        @endforeach

    </table>

    <div style="float:right" class="pagination"> {{ $ventas->links() }} </div>

@endif