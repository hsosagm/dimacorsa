<?php namespace App\graphics;

use Carbon, Input, DB, App, Auth;

class Ventas extends \BaseController
{
    public function ventasMensualesPorAno()
    {
        $d_ventas = DB::table('detalle_ventas')
        ->select(DB::raw("sum(cantidad * ganancias) as ganancias, MONTH(detalle_ventas.created_at) as mes"))
        ->where('ventas.tienda_id', Auth::user()->tienda_id)
        ->where(DB::raw('YEAR(ventas.created_at)'), Input::get('year') )
        ->join('ventas', 'detalle_ventas.venta_id', '=', 'ventas.id')
        ->groupBy('mes')
        ->get();

        $i = 0;
        foreach ($d_ventas as $dv) {
            $ganancias[$i]['y'] = (float) $dv->ganancias;
            $i++;
        }

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
            $g = \f_num::get($ganancias[$i]['y']);
            $data[$i]['name'] = $dt->monthsNames($v->mes)." "."de"." ".$v->year;
            $data[$i]['y'] = (float) $v->total;
            $data[$i]['url'] = 'owner/chart/ventas/ventasDiariasPorMes';
            $data[$i]['variables'] = array( "year" => $v->year, "month" => $v->mes);
            $data[$i]['tooltip'] =
            "<div class='toltip'><a href='javascript:void(0);' style='color:#1C6667' onclick='cierreDelMes( $v->year, $v->mes )'>Ver cierre del mes</a></div><div class='toltip'></div><i>Ganancias $g</i>";
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
            $object[$count]['tooltip'] = '<a href="javascript:void(0);" onclick="cierreDelDia('.$dia.')">Cierre del dia</a>';
            $object[$count]['variables'] = array( "fecha" => $q->dia);
            $object[$count]['url'] = 'owner/chart/ventas/ventasDelDiaPorHora';
            $object[$count]['drilldown'] = true;
            $count++;
        }

        $data['data'] = $object;
        $data['title'] = 'Ventas del mes de';
        $data['name'] = 'Ventas por dia';

        return json_encode($data);
    }

    public function ventasDelDiaPorHora()
    {
        $query = DB::table('ventas')
        ->select(array(DB::Raw('HOUR(ventas.created_at) as hora, DATE(ventas.created_at) as dia, sum(total) as total')))
        ->where(DB::raw('DATE(ventas.created_at)'), Input::get('fecha'))
        ->where('tienda_id', '=', Auth::user()->tienda_id )
        ->groupBy(DB::raw('HOUR(ventas.created_at)'))
        ->get();

        $dt = App::make('Fecha');

        $count = 0;

        foreach ($query as $q) {
            $object[$count]['name'] = strval($q->hora);
            $object[$count]['y'] = intval($q->total);
            $object[$count]['tooltip'] = '<a href="javascript:void(0);" onclick="getVentasPorHoraPorUsuario('."'".Input::get('fecha')." {$q->hora}'".')">Ventas por usuario';
            $count++;
        }

        $data['data'] = $object;
        $data['title'] = 'Ventas por hora';
        $data['name'] = 'Ventas por hora';

        return json_encode($data);
    }

    public function ventasMensualesPorAnoPorCliente()
    {
        $ventas = DB::table('ventas')
        ->where('cliente_id', Input::get('cliente_id'))
        ->where(DB::raw('YEAR(ventas.created_at)'), Input::get('year') )
        ->where(DB::raw('total'), '>', 0 )
        ->select(DB::raw("sum(total) as total, MONTH(ventas.created_at) as mes,  YEAR(ventas.created_at) as year"))
        ->groupBy('mes')
        ->get();

        $dt = App::make('Fecha');
        
        for ($i=0; $i < 12; $i++) { 
            $data[$i]['name'] = $dt->monthsNames($i+1)." "."de"." ".@$ventas[$i]->year;
            $data[$i]['y'] = (float) @$ventas[$i]->total;
            if ($data[$i]['y'] == 0) {
                $data[$i]['drilldown'] = false;
            } else {
                 $data[$i]['drilldown'] = true;
            }
            $data[$i]['url'] = 'user/chart/ventasDiariasPorMesCliente';
            $data[$i]['variables'] = array( "year" => @$ventas[$i]->year, "month" => @$ventas[$i]->mes, "cliente_id" => Input::get('cliente_id'));
            $data[$i]['tooltip'] = '';
        }

        $data['data'] = $data;
        $data['title'] = 'Ventas de';
        $data['name'] = 'ventas por mes';

        return json_encode($data);
    }

    public function ventasDiariasPorMesCliente()
    {
        $query = DB::table('ventas')
        ->select(array(DB::Raw('DATE(ventas.created_at) as dia'), DB::Raw('sum(total) as total')))
        ->where('cliente_id', Input::get('cliente_id'))
        ->where(DB::raw('YEAR(ventas.created_at)'), '=', Input::get('year'))
        ->where(DB::raw('MONTH(ventas.created_at)'), '=', Input::get('month'))
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
        $data['title'] = 'Ventas del mes de';
        $data['name'] = 'Ventas por dia';

        return json_encode($data);
    }

}
