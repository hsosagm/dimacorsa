<?php


class TableSearchMaster {

    public static function get($table, $columns, $Search_columns, $sJoin = null, $where = null ,$abono = false ,$others_columns = null ,$pos_columns = 0) {

        $sLimit = "";

        if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
        {
            $sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".intval( $_GET['iDisplayLength'] );
        }
        
        $sOrder = "";

        if ( isset( $_GET['iSortCol_0'] ) )
        {
            $sOrder = "ORDER BY  ";
            for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) {
                if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) {
                    $sortDir = (strcasecmp($_GET['sSortDir_'.$i], 'ASC') == 0) ? 'ASC' : 'DESC';
                    $sOrder .= "`".$columns[ intval( $_GET['iSortCol_'.$i] ) ]."` ". $sortDir .", ";
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

        $full_others_columns = " ";

        if ($others_columns != null) 
        {
            $full_others_columns = ','.implode(",", $others_columns);
        }

        $productos = DB::select("SELECT SQL_CALC_FOUND_ROWS `".str_replace(" , ", " ", implode("`, `", $columns))."`,
        	         $table.id as id  $full_others_columns FROM $table $sJoin $sWhere $sOrder $sLimit") ;

        $Found_Rows = DB::select('SELECT FOUND_ROWS() as num_rows');

		$output = array(
		    "sEcho" => intval($_GET['sEcho']),
		    "iTotalRecords" => DB::table($table)->count(),
		    "iTotalDisplayRecords" => intval($Found_Rows[0]->num_rows),
		    "aaData" => array()
		);

		foreach($productos as $aRow) {

		    $row = array();
		    for ( $i = 0; $i < count($columns); $i++ ) {

                $row['DT_RowId'] = $aRow->id;

                if ($others_columns != null) 
                {
                    if (($pos_columns-1) == $i) 
                    {
                        for ($x=0; $x < count($others_columns) ; $x++) 
                        { 
                            $colum_two = explode(" ", $others_columns[$x]);
                            $row[] =$aRow->$colum_two[2];
                        }
                    }
                }

		        $row[] = $aRow->$columns[$i];
		    }

            $row[] = '<td><a href="#" class="btn-link theme-c" id='.$aRow->id.' >Ver Detalle</a></td>' ;

            if ($abono == true) 
            {
                $row[] = '<td><a href="#" class="btn-link theme-c _abono_master" id='.$aRow->id.'>Abono</a></td>' ;
            }

		    $output['aaData'][] = $row;
		}
		
		return json_encode( $output );
    }
}
