 <?php 
//consulta para ver todos los productos con su existencia cada uno
 	$table = 'productos';

        $columns = array(
            "codigo",
            "nombre",
            "descripcion",
            "p_publico",
            "IFNULL((SELECT existencia FROM existencias WHERE producto_id = productos.id AND tienda_id = ".Auth::user()->tienda_id." ),0) as existencia");

        $Searchable = array("codigo","nombre","descripcion");
        
        $Join = 'JOIN marcas ON productos.marca_id = marcas.id ';
        
        $where = null;

        echo TableSearch::get($table, $columns, $Searchable, $Join ,$where );
