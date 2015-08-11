    <table class="master-table">
        <tr class="subTableChild">
            <td colspan="3">
                <br>
            </td>
        </tr>
        <tr class="col-md-4 subTableChild">
            <td class="col-md-4">Fecha inicial:</td>
            <td class="col-md-6"><input type="text" name="fecha_inicial" value="{{Input::get('fecha_inicial')}}"></td>
            <td class="col-md-2"></td>
        </tr>
        <tr class="col-md-4 subTableChild">
            <td class="col-md-4">Fecha final:</td>
            <td class="col-md-6"><input type="text" name="fecha_final" value="{{Input::get('fecha_final')}}"></td>
            <td class="col-md-2"></td>
        </tr>
        <tr class="col-md-4">
            <td><button class="btn btn-theme" type="submit" onclick="kardexProductoActualizar()" > Actualizar !</button></td>
        </tr>
        <tr class="subTableChild">
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
            <tr id="hhh" class="subTableChild">
                <th width="18%">Fecha</th>
                <th width="18%">Usuario</th>
                <th width="9%">Transaccion</th>
                <th width="10%">Evento</th>
                <th width="9%">Cantidad</th>
                <th width="9%">Exist.</th>
                <th width="9%">Costo</th>
                <th width="9%">Costo P.</th>
                <th width="9%">Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kardex as $dt)
                <tr class="subTableChild">
                    <td width="18%"> {{ $dt->fecha }} </td>
                    <td width="18%"> {{ $dt->usuario }}  </td>
                    <td width="9%"> {{ $dt->nombre }} </td>
                    <td width="10%"> {{ $dt->evento }} </td>
                    <td width="9%"> {{ $dt->cantidad }} </td>
                    <td width="9%"> {{ $dt->existencia }} </td>
                    <td width="9%" class="right"> {{ $dt->costo }} </td>
                    <td width="9%" class="right"> {{ $dt->costo_promedio }} </td>
                    <td width="9%" class="right"> {{ f_num::get($dt->costo_promedio * $dt->existencia) }} </td>
                </tr>
            @endforeach
        </tbody>
        <tfoot width="100%">
            <tr class="subTableChild">
                <td colspan="9">
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