<?php namespace App\graphics;

use Carbon, Gasto, View, Input, DB, App;

class GastoGraph extends \BaseController
{
    public function form_graph_by_date_get()
    {
        $first = Carbon::createFromFormat('Y-m-d H:i:s', Gasto::first()->created_at);

        return View::make('gastos.chart', compact('first'));
    }

    public function form_graph_by_date_post()
    {
        return View::make('chart.gastos');
    }

    public function graph_by_date()
    {
        $start = Carbon::createFromFormat('Y/m', Input::get('start'));
        $end = Carbon::createFromFormat('Y/m', Input::get('end'));
        $diff = $start->diffInMonths($end);

        $dt = App::make('Fecha');

        for ($i=0; $i<= $diff; $i++)
        {
            $gastos = DB::table('gastos')
            ->join('detalle_gastos', 'gastos.id', '=', 'detalle_gastos.gasto_id')
            ->where('tienda_id', 1)
            ->where(DB::raw('MONTH(gastos.created_at)'), '=', $dt->monthNum($i, $end, $diff) )
            ->where(DB::raw('YEAR(gastos.created_at)'), '=', $dt->year($i, $end, $diff) )
            ->select(DB::raw('sum(monto) as total'))
            ->first();

            if ($gastos->total == null)
            {
               $gastos->total = 0;
            }

            $val[$i]['name'] = strval($dt->month($i, $end, $diff));
            $val[$i]['y'] = intval($gastos->total);
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
        $query = DB::table('detalle_gastos')
        ->select(array(DB::Raw('DATE(gastos.created_at) as created_at'), DB::Raw('sum(monto) as y')))
        ->join('gastos', 'detalle_gastos.gasto_id', '=', 'gastos.id')
        ->where(DB::raw('YEAR(gastos.created_at)'), '=', Input::get('year'))
        ->where(DB::raw('MONTH(gastos.created_at)'), '=', Input::get('month'))
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
        $data['title'] = 'Gastos del mes de';

        return json_encode($data);
    }
}
