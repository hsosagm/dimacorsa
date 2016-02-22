<?php

class SearchController extends Controller {

    public function get()
    {
        $sExp = preg_split('/\s+/',Input::get('term'));

        $words = array();

        foreach ($sExp as $key=>$keyword)
        {
            if (strlen($keyword) >= 2)
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
