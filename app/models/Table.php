<?php

class Table {

    public function detail($query, $table_detail_id, $href)
    {
    	$detalle = $query->where($table_detail_id, '=', Input::get($table_detail_id))->get();
      $table = '<table width="100%">';
        foreach($detalle as $ds)
        {
            $table .= 
            '<tr>
            <td width="40%">' . $ds->descripcion . '</td>
            <td class="right" width="20%">' . $ds->monto . '</td>
            <td class="center" width="20%">' . $ds->metodo_pago->descripcion . '</td>
            <td class="center" width="10%"><i class="fa fa-times pointer btn-link theme-c" id="'.$ds->id.'" href="'.$href.'" onclick="DeleteDetalle(this);"  title="Eliminar"></i></td>
            </tr>';
        }
        $table .= '</table>';

        return $table;
    }

    public static function masterDetail($table , $id ,$href)
    {
       $dt_id = 'detalle_'.$table.'.id as id';
       $columns = array( $dt_id , 'descripcion','cantidad' , 'precio','producto_id' );
       $detalle=' <table width="100%" id="table-detalle"><thead><tr>
                      <td class="hide"></td>
                      <td style="text-align:center !important;">Cantidad:</td>
                      <td style="text-align:center !important;">Descripcion:</td>
                      <td style="text-align:center !important;">Costo U:</td>
                      <td style="text-align:center !important;">Total:</td>
                      <td></td>
                    </tr></thead>';

       $query = DB::table('detalle_'.$table)->select($columns);
       $query = $query->join('productos', 'productos.id', '=', 'detalle_'.$table.'.producto_id');
       $query = $query->where(substr($table, 0, -1).'_id', '=', $id);
       $query = $query->get();

       foreach($query as $dt)
        {
            $total = $dt->precio * $dt->cantidad;

            $detalle.= 
            '<tr>
            <td class="hide">' .$dt->producto_id. '</td>
            <td width="10%" style="text-align:right !important; padding-right:10px !important;">' .$dt->cantidad . '</td>
            <td class="right" width="50%">' .$dt->descripcion . '</td>
            <td class="center" width="15%" style="text-align:right !important;">' .$dt->precio . '</td>
            <td class="center" width="15%" style="text-align:right !important;">' .$total. '</td>
            <td class="center" width="40" style="text-align:center !important;">
            <a id="'.$dt->id.'" href="'.$href.'" onclick="DeleteDetalle(this);
             return false;" class="" title="Eliminar"><i class="fa fa-trash-o btn-link theme-c"></i></a></td>
            </tr>';
        }

        $detalle.='</table>';
       return $detalle;
    }
}
