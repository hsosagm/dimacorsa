<?php

class Autocomplete {

    public static function get($table, $columns, $plus = null)
    {
        $terms = Autocomplete::cleaner();
        $query = DB::table($table)->select($columns);
        array_shift($columns);

        if ($plus != null) 
        {
            array_pop($columns);
        }

        $result = [];

        foreach($terms as $term)
        {
            $query = $query->Where(DB::raw('CONCAT(" ",' . implode(",",$columns) . ')'), 'LIKE', '%'. $term .'%');
        }

        $query = $query->take(5)->get();

        foreach ($query as $q)
        {
            if ($plus == null) 
            {
                $result[] = [ 'id' => $q->id, 'value' => $q->$columns[0] . ' ' . $q->$columns[1] ];
            }
            else
            {
                $result[] = [ 'id' => $q->id, 'value' => $q->$columns[0] . ' ' . $q->$columns[1] ,'descripcion' => $q->$plus];
            }
        }

        $data['suggestions'] = $result;

        return $data;
    }


    public static function cleaner()
    {
        $sExp = preg_split('/\s+/',Input::get('query'));
        $words = array();

        foreach ($sExp as $keyword)
        {
            $words[] = $keyword;
        }

        $keywords = array();
        $keywords = array_map(function($item){ return ($item); }, $words); 
        $keywords = implode(" ",$keywords);
        $term = preg_replace('/\s+/', ' ', $keywords);
        $parts = explode(' ', $term);
        return $parts;
    }
}
