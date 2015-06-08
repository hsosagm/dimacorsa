{{ Form::open(array('data-remote-OverdueBalance','onsubmit'=>"return false")) }}

    <div class="container">

        <table class="SST" cellspacing='0'>
            <tr>
                <th class="center" width="20%">Usuario</th>
                <th class="center" width="50%">Fecha</th>
                <th class="center" width="10%">Factura</th>
                <th class="center" width="10%">Total</th>
                <th class="center" width="10%">Saldo</th>
            </tr>

            @foreach($ventas as $q)
                <tr class="even">
                    <td> {{ $q->usuario }} </td>
                    <td> {{ $q->fecha }} </td>
                    <td> {{ $q->numero_documento }} </td>
                    <td class="right"> {{ $q->total }} </td>
                    <td class="right"> {{ $q->saldo }} </td>
                    <td class="widthS center font14"  width="12%"> 
                        <a href="javascript:void(0);" title="Ver detalle" onclick="showSalesDetail(this)" class="fa fa-plus-square show_detail"> 
                    </td>
                </tr>
            @endforeach

        </table>

        <div style="float:right" class="pagination"> {{ $ventas->links() }} </div>

    </div>

{{--     <div class="form-footer" style="float:right">
        <button class="btn btn-default" data-dismiss="modal" type="button">Cerrar!</button>
        <input  class="btn theme-button" type="submit" value="Enviar" >
    </div> --}}
{{Form::close()}}