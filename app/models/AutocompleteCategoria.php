<?php

class AutocompleteCategoria {

    public static function get($table, $columns, $fk = null)
    {
        $terms = Autocomplete::cleaner();
        $query = DB::table($table)->select($columns);
        array_shift($columns);

        $result = [];

        foreach($terms as $term)
        {
            $query = $query->Where(DB::raw('CONCAT(" ",' . implode(",",$columns) . ')'), 'LIKE', '%'. $term .'%');
        }

        if ($fk != null) 
            $query = $query->WhereRaw($fk);

        $query = $query->take(5)->get();

        foreach ($query as $q)
        {
            $result[] = [ 'id' => $q->id, 'value' => $q->$columns[0]];
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
