<?php

class KardexController extends \BaseController {

	public function getKardex()
	{
		$table = 'kardex';

        $columns = array(
            "kardex.created_at as fecha",
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
            "kardex_transaccion.nombre as nombre",
            "evento",
            "cantidad",
            "existencia",
            "costo",
            "costo_promedio"
        );

        $Search_columns = array("evento" , "cantidad" , 'existencia' ,'costo');

        $Join = "JOIN users ON (users.id = kardex.user_id) ";
        $Join .= "JOIN kardex_transaccion ON (kardex_transaccion.id = kardex_transaccion_id) ";

        $where = " DATE_FORMAT(kardex.created_at, '%Y-%m') = DATE_FORMAT(current_date, '%Y-%m') ";

        if (Input::get('fecha_inicial') != null && Input::get('fecha_final') != null)
        {
            $where  = "DATE_FORMAT(kardex.created_at, '%Y-%m-%d') >= DATE_FORMAT('".Input::get('fecha_inicial')."', '%Y-%m-%d')";
            $where .= " AND DATE_FORMAT(kardex.created_at, '%Y-%m-%d') <= DATE_FORMAT('".Input::get('fecha_final')."', '%Y-%m-%d')";
        }

        $where .= " AND kardex.tienda_id =".Auth::user()->tienda_id;
        $where .= " AND kardex.producto_id =".Input::get('producto_id');
        $where .= " ORDER BY kardex.created_at";

        $kardex = SST::get($table, $columns, $Search_columns, $Join, $where );

        return Response::json(array(
            'success' => true,
            'table'   => View::make('kardex.getKardex', compact('kardex'))->render()
        ));
	}

    /*******************************************************************
    Inicio Exportar Kardex
    *******************************************************************/
    public function exportarKardex($tipo)
    {
        $kardex = DB::table('kardex')
        ->select("kardex.created_at as fecha",
            DB::raw("CONCAT_WS(' ',users.nombre,users.apellido) as usuario"),
            DB::raw("kardex_transaccion.nombre as transaccion"),
            "evento","cantidad", "existencia", "costo", "costo_promedio",
            DB::raw("(costo * cantidad) as total_movimiento"),
            DB::raw("(costo_promedio * existencia) as total_acumulado"))
        ->join('users','users.id','=','kardex.user_id')
        ->join('kardex_transaccion','kardex_transaccion.id','=','kardex.kardex_transaccion_id')
        ->where('kardex.tienda_id','=',Auth::user()->tienda_id)
        ->where('producto_id','=',Input::get('producto_id'))
        ->whereRaw("DATE_FORMAT(kardex.created_at, '%Y-%m-%d') >= DATE_FORMAT('".Input::get('fecha_inicial')."', '%Y-%m-%d')")
        ->whereRaw("DATE_FORMAT(kardex.created_at, '%Y-%m-%d') <= DATE_FORMAT('".Input::get('fecha_final')."', '%Y-%m-%d')")
        ->get();

        $producto = Producto::find(Input::get('producto_id'));

        if (trim($tipo) == 'pdf') {
            $pdf = PDF::loadView('kardex.exportarKardex', array('kardex' => $kardex, 'producto' => $producto,  'tipo' =>  $tipo))->setPaper('letter')->setOrientation('landscape');
            return $pdf->stream('Kardex.pdf');
        }

        Excel::create('Kardex', function($excel) use($kardex, $producto, $tipo)
        {
            $excel->setTitle('Kardex');
            $excel->setCreator('Leonel Madrid [ leonel.madrid@hotmail.com ]')
            ->setCompany('Click Chiquimula');
            $excel->setDescription('Creada desde la aplicacion web @powerby Nelug');
            $excel->setSubject('Click');

            $excel->sheet('datos', function($hoja) use($kardex, $producto , $tipo)
            {
                $hoja->setOrientation('landscape');
                $hoja->loadView('kardex.exportarKardex', array('kardex' => $kardex, 'producto' => $producto, 'tipo' =>  $tipo));
            });

        })->export("xls");
    }
    /*******************************************************************
    Fin  Exportar Kardex
    *******************************************************************/

    /*******************************************************************
    Inicio Consultas de Kardex
    *******************************************************************/
    public function getKardexPorFecha($consulta)
    {
        $fecha_final = Carbon::now();
        $producto_id = Input::get('producto_id');

        if (Input::has('fecha_inicial')) {
            $fecha_inicial = Input::get('fecha_inicial');
            $fecha_final = Input::get('fecha_final');
            $consulta = 'fechas';
        }
        else {
            $fecha_inicial = Carbon::now()->startOfMonth();
        }

        return View::make('kardex.getKardexPorFecha',compact('consulta','fecha_inicial','fecha_final','producto_id'))->render();
    }

    public function DtKardexPorFecha($consulta)
    {
        if ($consulta == 'mes')
            echo $this->consultaKardex('%Y-%m');
        else if ($consulta == 'fechas')
            echo $this->consultaKardex(null, Input::get('fecha_inicial'), Input::get('fecha_final'));
    }

    public function consultaKardex($formato , $fecha_inicial = null , $fecha_final = null)
    {
        $table = 'kardex';

         $columns = array(
            "kardex.created_at as fecha",
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
            "kardex_transaccion.nombre as nombre",
            "evento",
            "cantidad",
            "existencia",
            "costo",
            "costo_promedio",
            "(costo * cantidad) as total_movimiento",
            "(costo_promedio * existencia) as total_acumulado"
        );

        $Search_columns = array("evento" , "cantidad" , 'existencia' ,'costo' , 'users.nombre',
         'users.apellido', 'kardex.created_at','kardex_transaccion.nombre');

        $where = "DATE_FORMAT(kardex.created_at, '{$formato}') = DATE_FORMAT(current_date, '{$formato}')";

        if ($fecha_inicial != null && $fecha_final != null)
        {
            $where  = "DATE_FORMAT(kardex.created_at, '%Y-%m-%d') >= DATE_FORMAT('{$fecha_inicial}', '%Y-%m-%d')";
            $where .= " AND DATE_FORMAT(kardex.created_at, '%Y-%m-%d') <= DATE_FORMAT('{$fecha_final}', '%Y-%m-%d')";
        }

        $where .= " AND kardex.tienda_id =".Auth::user()->tienda_id;
        $where .= " AND kardex.producto_id =".Input::get('producto_id');

        $Join = "JOIN users ON (users.id = kardex.user_id) ";
        $Join .= "JOIN kardex_transaccion ON (kardex_transaccion.id = kardex_transaccion_id) ";

        return TableSearch::get($table, $columns, $Search_columns, $Join, $where );
    }
    /*******************************************************************
    Fin Consultas de Kardex
    *******************************************************************/
}
