<?php

class VentasController extends \BaseController {

	public function create()
	{
		if (Input::has('_token'))
		{
			$venta = new Venta;

			if (!$venta->create_master())
			{
				return $venta->errors();
			}

			$id = DB::getPdo()->lastInsertId();

			return Response::json(array(
				'success' => true, 
				'id'      => $id, 
				'detalle' => View::make('ventas.detalle')->render()
             ));
		}

		return View::make('ventas.create');
	}

	public function detalle()
	{
		if (Input::has('_token'))
		{
			$query = new DetalleVenta;

			if (!$query->_create())
			{
				return $query->errors();
			}

			return Response::json(array(
				'success' => true,
				'table'   => $this->table_detail()
             ));
		}

		return false;
	}


	public function table_detail()
    {
        $query = DB::table('detalle_ventas')
        ->select(array('venta_id', 'producto_id', 'cantidad', 'precio', DB::raw('CONCAT(productos.descripcion, " ", marcas.nombre) AS descripcion, cantidad * precio AS total') ))
        ->where('venta_id', Input::get('venta_id'))
        ->join('productos', 'detalle_ventas.producto_id', '=', 'productos.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->get();

        $deuda = 0;

        $detalle = '<table>
        <thead>
            <tr>
               <th class="hide">id</th>
               <th width="50">Cantidad</th>
               <th width="580">Descripcion</th>
               <th width="70">Precio</th>
               <th width="70">Totales</th>
               <th width="70">Eliminar</th>
           </tr>
       </thead>
       <tr> <td colspan="5" rowspan="" headers=""> 
       <div class="table-scroll">
       <table> <tbody> ';

       foreach ($query as $key => $q)
       {
        $deuda = $deuda + $q->total;        
        $precio = number_format($q->precio,2,'.',',');
        $total = number_format($q->total,2,'.',',');

        $detalle.= '
        <tr>
            <td class="hide">' . $q->producto_id . '</td>
            <td field="cantidad" cod="' . $q->producto_id . '" class="edit" width="60">' . $q->cantidad . '</td>          
            <td width="580"> ' . $q->descripcion . ' </td>
            <td field="precio" cod="' . $q->producto_id . '" class="edit" width="75">' . $precio . '</td>
            <td width="75">' . $total . '</td>
            <td width="50"><i id="fv_item_delete" class="fa fa-trash-o pointer"></i></td>
        </tr>'; 
    }

    $deuda2 = $deuda;
    $deuda = number_format($deuda,2,'.',',');
    $detalle.= ' </tbody> </table>  </div></td></tr>
    <tr style="border: solid 1px black">
    <td colspan="3" id="totalventas" class="td_total_text" style="text-align:center"> Total a cancelar</td>
    <td id="total_ventas" class="td_total">' . $deuda . '</td>
    <td class="hide"><input id="saldo_venta" type="text" value="' . $deuda2 . '" /></td>
    <td class="td_tabla" colspan="2" ></td></tr>';
    $detalle.= '</table>';

    return $detalle;
}

}
