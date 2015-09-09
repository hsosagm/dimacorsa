<?php namespace App\graphics;

use Carbon, Input, DB, App, Auth;

class Compras extends \BaseController
{
    public function comprasMensualesPorAnoPorProveedor()
    {
        $compras = DB::table('compras')
        ->where('proveedor_id', Input::get('proveedor_id'))
        ->where(DB::raw('YEAR(compras.created_at)'), Input::get('year') )
        ->where(DB::raw('total'), '>', 0 )
        ->select(DB::raw("sum(total) as total, MONTH(compras.created_at) as mes,  YEAR(compras.created_at) as year"))
        ->groupBy('mes')
        ->get();

        $dt = App::make('Fecha');
        
        for ($i=0; $i < 12; $i++) { 
            $data[$i]['name'] = $dt->monthsNames($i+1)." "."de"." ".@$compras[$i]->year;
            $data[$i]['y'] = (float) @$compras[$i]->total;
            if ($data[$i]['y'] == 0) {
                $data[$i]['drilldown'] = false;
            } else {
                 $data[$i]['drilldown'] = true;
            }
            $data[$i]['url'] = 'admin/chart/comprasDiariasPorMesProveedor';
            $data[$i]['variables'] = array( "year" => @$compras[$i]->year, "month" => @$compras[$i]->mes, "proveedor_id" => Input::get('proveedor_id'));
            $data[$i]['tooltip'] = '';
        }

        $data['data'] = $data;
        $data['title'] = 'Compras de';
        $data['name'] = 'Compras por mes';

        return json_encode($data);
    }

    public function comprasDiariasPorMesProveedor()
    {
        $query = DB::table('compras')
        ->select(array(DB::Raw('DATE(compras.created_at) as dia'), DB::Raw('sum(total) as total')))
        ->where('proveedor_id', Input::get('proveedor_id'))
        ->where(DB::raw('YEAR(compras.created_at)'), '=', Input::get('year'))
        ->where(DB::raw('MONTH(compras.created_at)'), '=', Input::get('month'))
        ->where('tienda_id', '=', Auth::user()->tienda_id )
        ->groupBy('dia')
        ->get();

        $i = 0;

        foreach ($query as $q) {

            $carbon = Carbon::createFromFormat('Y-m-d', $q->dia);
            $object[$i]['name'] = strval($carbon->day);
            $object[$i]['y'] = intval($q->total);
            $i++;
        }

        $data['data'] = $object;
        $data['title'] = 'Compras del mes de';
        $data['name'] = 'Compras por dia';

        return json_encode($data);
    }

}
