<?php

class TableSearch {

    public static function get($table, $columns, $Search_columns, $sJoin = null, $where = null, $groupBy = "" ) {

        $sLimit = "";

        if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
        {
            $sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".intval( $_GET['iDisplayLength'] );
        }

        $sOrder = "";

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

        if ( isset( $_GET['iSortCol_0'] ) )
        {
            $sOrder = "ORDER BY  ";
            for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) {
                if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) {
                    $sortDir = (strcasecmp($_GET['sSortDir_'.$i], 'ASC') == 0) ? 'ASC' : 'DESC';
                    $sOrder .= "`".$clean_columns[ intval( $_GET['iSortCol_'.$i] ) ]."` ". $sortDir .", ";
                }
            }

            $sOrder = substr_replace( $sOrder, "", -2 );

            if ( $sOrder == "ORDER BY" )
            {
                $sOrder = "";
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

        $db_table = DB::select("SELECT ".str_replace(" , ", " ", implode(", ", $columns)).",
        $table.id as DT_RowId  FROM $table $sJoin $sWhere $groupBy $sOrder $sLimit");

        $recordsFiltered = DB::select("SELECT COUNT($table.`id`) as 'total' FROM $table $sJoin $sWhere");

        $output = [
            "sEcho" => intval($_GET['sEcho']),
            "iTotalRecords" => DB::table($table)->count(),
            "iTotalDisplayRecords" => intval( $recordsFiltered[0]->total ),
            "aaData" => []
        ];

        foreach($db_table as $aRow) {
            $row = [];

            for ( $i = 0; $i < count($clean_columns); $i++ ) {
                $col = $clean_columns[$i];
                $row['DT_RowId'] = $aRow->DT_RowId;
                $row[] = $aRow->$col;
            }

            $output['aaData'][] = $row;
        }

        return json_encode( $output );
    }
}
