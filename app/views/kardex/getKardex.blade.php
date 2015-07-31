    <table class="master-table">
        <tr>
            <td colspan="3">
                <br>
            </td>
        </tr>
        <tr class="col-md-5">
            <td class="col-md-4">Fecha inicial:</td>
            <td class="col-md-6"><input type="text"  name="fecha_inicial"></td>
            <td class="col-md-2"></td>
        </tr>
        <tr class="col-md-5">
            <td class="col-md-4">Fecha final:</td>
            <td class="col-md-6"><input type="text"  name="fecha_final"></td>
            <td class="col-md-2"></td>
        </tr>
        <tr class="col-md-2">
            <td><button class="btn btn-theme" type="submit" > Actualizar !</button></td>
        </tr>
        <tr>
            <td colspan="3">
                <br>
            </td>
        </tr>
    </table>
@if(!$kardex)
    <div align="center"> No se encontraron registros </div>
@else
    <table id="example"  class="display kardex_detail" width="100%" cellspacing="0">

        <thead>
            <tr id="hhh" class="">
                <th width="25%">Fecha</th>
                <th width="25%">Usuario</th>
                <th width="8%">Transaccion</th>
                <th width="10%">Evento</th>
                <th width="8%">Cantidad</th>
                <th width="8%">Existencia</th>
                <th width="8%">Costo</th>
                <th width="8%">Costo P.</th>
            </tr>
        </thead>

        <tbody>

            @foreach($kardex as $dt)
                <tr>
                    <td width="25%"> {{ $dt->fecha }} </td>
                    <td width="25%"> {{ $dt->usuario }}  </td>
                    <td width="8%"> {{ $dt->nombre }} </td>
                    <td width="10%"> {{ $dt->evento }} </td>
                    <td width="8%"> {{ $dt->cantidad }} </td>
                    <td width="8%"> {{ $dt->existencia }} </td>
                    <td width="8%"> {{ $dt->costo }} </td>
                    <td width="8%"> {{ $dt->costo_promedio }} </td>
                </tr>
            @endforeach

        </tbody>
        <tfoot width="100%">
            <tr>
                <td colspan="8">
                    <div style="float:right" class="pagination_kardex_producto"> {{ @$kardex->links() }} </div>
                </td>
            </tr>
        </tfoot>
    </table>
@endif

<script>
    $('input[name="fecha_inicial"]').pickadate({ 
  max: true,
  selectYears: true,
  selectMonths: true
});

$('input[name="fecha_final"]').pickadate({ 
  max: true,
  selectYears: true,
  selectMonths: true
});
</script>