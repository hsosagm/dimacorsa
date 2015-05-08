<?php namespace App\graphics;

use Carbon, Soporte, View, Input, DB, App;

class SoporteGraph extends \BaseController
{
    public function form_graph_by_date_get()
    {
        $first = Carbon::createFromFormat('Y-m-d h:i:s', Soporte::first()->created_at);

        return View::make('soporte.chart', compact('first'));
    }

    public function form_graph_by_date_post()
    {
        return View::make('chart.soporte');
    }

    public function graph_by_date()
    {
        $start = Carbon::createFromFormat('Y/m', Input::get('start'));
        $end = Carbon::createFromFormat('Y/m', Input::get('end'));
        $diff = $start->diffInMonths($end);

        $dt = App::make('Fecha');

        for ($i=0; $i<= $diff; $i++)
        {
            $soporte = DB::table('soporte')
            ->join('detalle_soporte', 'soporte.id', '=', 'detalle_soporte.soporte_id')
            ->where('tienda_id', 1)
            ->where(DB::raw('MONTH(soporte.created_at)'), '=', $dt->monthNum($i, $end, $diff) )
            ->where(DB::raw('YEAR(soporte.created_at)'), '=', $dt->year($i, $end, $diff) )
            ->select(DB::raw('sum(monto) as total'))
            ->first();

            if ($soporte->total == null)
            {
               $soporte->total = 0;
            }

            $val[$i]['name'] = strval($dt->month($i, $end, $diff));
            $val[$i]['y'] = intval($soporte->total);
            $val[$i]['year'] = $dt->year($i, $end, $diff);
            $val[$i]['month'] = $dt->monthNum($i, $end, $diff);
            $val[$i]['drilldown'] = true;
        }

        for ($i= $diff; $i>=0; $i--)
        {
            $data[] = $val[$i];
        }

        print json_encode($data);
    }

    public function graph_by_day()
    {
        $query = DB::table('detalle_soporte')
        ->select(array(DB::Raw('DATE(soporte.created_at) as created_at'), DB::Raw('sum(monto) as y')))
        ->join('soporte', 'detalle_soporte.soporte_id', '=', 'soporte.id')
        ->where(DB::raw('YEAR(soporte.created_at)'), '=', Input::get('year'))
        ->where(DB::raw('MONTH(soporte.created_at)'), '=', Input::get('month'))
        ->where('tienda_id', '=', 1)
        ->groupBy('created_at')
        ->orderBy('created_at')
        ->get();

        $dt = App::make('Fecha');

        $count = 0;

        foreach ($query as $q) {
            $carbon = Carbon::createFromFormat('Y-m-d', $q->created_at);
            $object[$count]['name'] = strval($carbon->day);
            $object[$count]['y'] = intval($q->y);
            $object[$count]['fecha'] = $q->created_at;
            $object[$count]['dia'] = $dt->Weekday($q->created_at);
            $count++;
        }

        $data['data'] = $object;
        $data['title'] = 'Soporte del mes de';

        return json_encode($data);
    }
}
