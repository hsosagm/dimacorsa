<?php

class TableSearchMaster {

    public static function get($table, $columns, $Search_columns, $sJoin = null, $where = null ,$url = null,$opcion1 = null,$opcion2 = null ,$others_columns = null ,$pos_columns = 0) {

        $sLimit = "";

        if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
        {
            $sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".intval( $_GET['iDisplayLength'] );
        }
        
        $sOrder = "";

        if ( isset( $_GET['iSortCol_0'] ) )
        { 
            if ($others_columns != null) 
            {
                for ($x=0; $x < count($others_columns) ; $x++) 
                { 
                    $colum_two = explode(" ", $others_columns[$x]);
                    $columns_others[] =($colum_two[2] == "as") ? $colum_two[3]:$colum_two[2];
                }
            }
            

            $resultado = array_merge($columns_others,$columns);

            if($opcion1 != null )
            {
                $resultado[]= $opcion1;
            }

            if($opcion2 != null)
            {
                $resultado[]= $opcion2;
            }

            $sOrder = "ORDER BY  ";
            for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ ) {
                if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" ) {
                    $sortDir = (strcasecmp($_GET['sSortDir_'.$i], 'ASC') == 0) ? 'ASC' : 'DESC';
                    $sOrder .= "`".$resultado[ intval( $_GET['iSortCol_'.$i] ) ]."` ". $sortDir .", ";
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

        $completed = " ";

        if ($table == 'compras' || $table == 'ventas') 
        {
            $completed =", completed ";
        }   


        $productos = DB::select("SELECT SQL_CALC_FOUND_ROWS `".str_replace(" , ", " ", implode("`, `", $columns))."`,
        	         $table.id as id  $full_others_columns $completed FROM $table $sJoin $sWhere $sOrder $sLimit") ;

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
                            $row[] =($colum_two[2] == "as") ? $aRow->$colum_two[3]:$aRow->$colum_two[2];
                        }
                    }
                }

		        $row[] = $aRow->$columns[$i];
		    }
            if ($opcion1 != null) 
            {
                $op_space1 = str_replace(' ','',$opcion1);
                $row[] = '<td><a  href="javascript:void(0);" url="'.$url.'" class="btn-link theme-c master_opcion_'.strtolower($op_space1).'" id='.$aRow->id.'>'.$opcion1.'</a></td>' ;
            }

            if ($opcion2 != null) 
            {
                $cadena = str_replace(' ','',$opcion2);
                $op_space2 = (@$aRow->completed == 1) ? 'cancelar':$cadena;
                $opcion_2  = (@$aRow->completed == 1) ? 'Cancelar':$opcion2;

                if (strtolower($opcion2) == 'abonar')    
                {
                    $op_space2 = (@$aRow->completed == 1) ? 'abonar':$cadena;
                    $opcion_2  = (@$aRow->completed == 1) ? 'Abonar':$opcion2;
                }
               
                $op_space2 = strtolower($op_space2);

                $row[] = '<td><a href="javascript:void(0);" url="'.$url.'" class="btn-link theme-c master_opcion_'.$op_space2.'" id='.$aRow->id.'>'.$opcion_2.'</a></td>' ;
            }

		    $output['aaData'][] = $row;
		}
		
		return json_encode( $output );
    }
}
