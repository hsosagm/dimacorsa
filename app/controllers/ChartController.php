<?php

class ChartController extends \BaseController {

	public function gastos()
	{
        $dt = App::make('Fecha');

        for ($i=0; $i<=12; $i++)
        {
			$gastos = DB::table('gastos')
	        ->join('detalle_gastos', 'gastos.id', '=', 'detalle_gastos.gasto_id')
	        ->where('tienda_id', 1)
	        ->where(DB::raw('MONTH(gastos.created_at)'), '=', $dt->monthNum($i) )
	        ->where(DB::raw('YEAR(gastos.created_at)'), '=', $dt->year($i) )
	        ->select(DB::raw('sum(monto) as total'))
	        ->first();

	        $g = $gastos->total;
        }

        return View::make('chart.gastos', compact('dt', 'g'));
	}


	public function soporte()
	{
		$g = [];

        $dt = App::make('Fecha');

        for ($i=0; $i<=12; $i++)
        {
			$soporte = DB::table('soporte')
	        ->join('detalle_soporte', 'soporte.id', '=', 'detalle_soporte.soporte_id')
	        ->where('tienda_id', 1)
	        ->where(DB::raw('MONTH(soporte.created_at)'), '=', $dt->monthNum($i) )
	        ->where(DB::raw('YEAR(soporte.created_at)'), '=', $dt->year($i) )
	        ->select(DB::raw('sum(monto) as total'))
	        ->first();

	        if ($soporte->total == null)
            {
               $soporte->total = 0;
            }

	        $g[] = $soporte->total;
        }

        return View::make('chart.soporte', compact('dt', 'g'));
	}

	public function soporte_graph()
	{
		$g = [];

        $dt = App::make('Fecha');

        for ($i=0; $i<=12; $i++)
        {
			$soporte = DB::table('soporte')
	        ->join('detalle_soporte', 'soporte.id', '=', 'detalle_soporte.soporte_id')
	        ->where('tienda_id', 1)
	        ->where(DB::raw('MONTH(soporte.created_at)'), '=', $dt->monthNum($i) )
	        ->where(DB::raw('YEAR(soporte.created_at)'), '=', $dt->year($i) )
	        ->select(DB::raw('sum(monto) as total'))
	        ->first();

	        if ($soporte->total == null)
            {
               $soporte->total = 0;
            }

	        $g[] = $soporte->total;
        }

        return View::make('chart.soporte', compact('dt', 'g'));
	}

	public function ventas()
	{
        $ventas = DB::table('ventas')
        ->where('ventas.tienda_id', Auth::user()->tienda_id)
        ->where(DB::raw('total'), '>', 0 )
        ->select(DB::raw("sum(total) as total, YEAR(ventas.created_at) as year"))
        ->groupBy('year')
        ->get();

        $i = 0;
        foreach ($ventas as $v) {
        	$data[$i]['name'] = $v->year;
            $data[$i]['y'] = (float) $v->total;
            $data[$i]['year'] = $v->year;
            $data[$i]['url'] = 'owner/chart/ventas/ventasMensualesPorAno';
            $data[$i]['variables'] = array( "year" => $v->year);
            $data[$i]['drilldown'] = true;
            $i++;
        }

        $data = json_encode($data);

        $d_ventas = DB::table('detalle_ventas')
        ->select(DB::raw("sum(cantidad * ganancias) as ganancias, YEAR(detalle_ventas.created_at) as year"))
        ->where('ventas.tienda_id', 1)
        ->join('ventas', 'detalle_ventas.venta_id', '=', 'ventas.id')
        ->groupBy('year')
        ->get();

        $i = 0;
        foreach ($d_ventas as $dv) {
            $ganancias[$i]['y'] = (float) $dv->ganancias;
            $i++;
        }

        $ganancias = json_encode($ganancias);

		return Response::json(array(
			'success' => true,
			'view'    => View::make('chart.ventas.ventas', compact('data', 'ganancias'))->render()
        ));
	}

	public function chartVentasPorUsuario()
	{
        $ventas = DB::table('ventas')
        ->join('users', 'ventas.user_id', '=', 'users.id')
        ->where('ventas.tienda_id', Auth::user()->tienda_id)
        ->where(DB::raw('MONTH(ventas.created_at)'), date('m') )
        ->where(DB::raw('YEAR(ventas.created_at)'), date("Y") )
        ->where(DB::raw('total'), '>', 0 )
        ->select(DB::raw("user_id, CONCAT_WS(' ',users.nombre,users.apellido) as usuario, sum(total) as total"))
        ->groupBy('user_id')
        ->orderBy('total')
        ->get();

        foreach ($ventas as $v) {
            $totales[] = (float) $v->total;
            $usuarios[] = $v->usuario;
        }

        $usuarios = json_encode(@$usuarios);
        $totales = json_encode(@$totales);

		return Response::json(array(
			'success' => true,
			'view'    => View::make('chart.ventasPorUsuario', compact('totales', 'usuarios'))->render()
        ));
	}
}
