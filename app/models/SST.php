<?php


class SST {

    public static function get($table, $columns, $Search_columns, $sJoin = null, $where = null, $limit = 10) {

        $sLimit = "";

        $page = Input::get('page', 1);

        $sLimit = "LIMIT ".intval( $limit * ($page - 1) ).", ".intval( $limit );

        foreach ($columns as $q)
        {
            if (strpos($q,' as ') == true)
            {
                $clean_columns[] = trim(substr($q, strrpos($q, ' as ') +4 ));
            }
            else
            {
                $clean_columns[] = $q;
            }
        }


        $sSearch = str_replace("'"," ", $_GET['sSearch']);
        $sSearch = ltrim($sSearch);

        $sWhere = "";
        $sAnd = "";

        if ($where)
        {
            $sWhere = "WHERE". ' ' .$where;
            $sAnd = "AND". ' ' .$where;
        }

        if ( $sSearch != "" )
        {
            $aWords = preg_split('/\s+/', $sSearch);
            $sWhere = "WHERE (";

                for ( $j=0 ; $j<count($aWords) ; $j++ )
                {
                    if ( $aWords[$j] != "" )
                    {
                        $sWhere .= "(";
                            for ( $i=0 ; $i<count($Search_columns) ; $i++ )
                            {
                                $sWhere .= $Search_columns[$i]." LIKE '%". $aWords[$j] ."%' OR ";
                            }
                            $sWhere = substr_replace( $sWhere, "", -3 );
                            $sWhere .= ") AND ";
                    }
                }
            $sWhere = substr_replace( $sWhere, "", -4 );
            $sWhere .= ')'.$sAnd;
        }


        $table = DB::select("SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $columns)).",
                    $table.id as id  FROM $table $sJoin $sWhere $sLimit");

        $Found_Rows = DB::select('SELECT FOUND_ROWS() as num_rows');

        $Found_Rows = (int) $Found_Rows['0']->num_rows;

        if (!$Found_Rows) {
           return false;
        }

        return Paginator::make($table, $Found_Rows, $limit);
    }
}
