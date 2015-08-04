<?php namespace App\graphics;

use Carbon, Input, DB, App, Auth;

class Ventas extends \BaseController
{
    public function ventasMensualesPorAno()
    {
        $ventas = DB::table('ventas')
        ->where('ventas.tienda_id', Auth::user()->tienda_id)
        ->where(DB::raw('YEAR(ventas.created_at)'), Input::get('year') )
        ->where(DB::raw('total'), '>', 0 )
        ->select(DB::raw("sum(total) as total, MONTH(ventas.created_at) as mes,  YEAR(ventas.created_at) as year"))
        ->groupBy('mes')
        ->get();

        $dt = App::make('Fecha');
        $i = 0;
        
        foreach ($ventas as $v) {
            $data[$i]['name'] = $dt->monthsNames($v->mes);
            $data[$i]['y'] = (float) $v->total;
            $data[$i]['url'] = 'owner/chart/ventas/ventasDiariasPorMes';
            $data[$i]['variables'] = array( "year" => $v->year, "month" => $v->mes);
            $data[$i]['tooltip'] = "<a href='javascript:void(0);' onclick='cierreDelMes( $v->year, $v->mes )'>Cierre del mes";
            $data[$i]['drilldown'] = true;
            $i++;
        }

        $data['data'] = $data;
        $data['title'] = 'Ventas de';
        $data['name'] = 'ventas por mes';

        return json_encode($data);
    }

    public function ventasDiariasPorMes()
    {
        $query = DB::table('ventas')
        ->select(array(DB::Raw('DATE(ventas.created_at) as dia'), DB::Raw('sum(total) as total')))
        ->where(DB::raw('YEAR(ventas.created_at)'), '=', Input::get('year'))
        ->where(DB::raw('MONTH(ventas.created_at)'), '=', Input::get('month'))
        ->where('tienda_id', '=', Auth::user()->tienda_id )
        ->groupBy('dia')
        ->get();

        $dt = App::make('Fecha');

        $count = 0;

        foreach ($query as $q) {

            $carbon = Carbon::createFromFormat('Y-m-d', $q->dia);
            $object[$count]['name'] = strval($carbon->day);
            $object[$count]['y'] = intval($q->total);
            $object[$count]['fecha'] = $q->dia;
            $object[$count]['dia'] = $dt->Weekday($q->dia);
            $dia = "'".$q->dia."'";
            $object[$count]['tooltip'] = '<a href="javascript:void(0);" onclick="cierreDelDia('.$dia.')">Cierre del dia';
            $count++;
        }

        $data['data'] = $object;
        $data['title'] = 'Ventas del mes de';

        return json_encode($data);
    }
}
