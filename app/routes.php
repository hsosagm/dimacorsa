<?php

    /* 
    funciones para hacer el guardado de logs
    /*******************************************************************************/

    User::observe(new \NEkman\ModelLogger\Observer\Logger);
    Tienda::observe(new \NEkman\ModelLogger\Observer\Logger);
    Producto::observe(new \NEkman\ModelLogger\Observer\Logger);
    Cliente::observe(new \NEkman\ModelLogger\Observer\Logger);
    Compra::observe(new \NEkman\ModelLogger\Observer\Logger);
    DetalleCompra::observe(new \NEkman\ModelLogger\Observer\Logger);
    Venta::observe(new \NEkman\ModelLogger\Observer\Logger);
    DetalleVenta::observe(new \NEkman\ModelLogger\Observer\Logger);
    Existencia::observe(new \NEkman\ModelLogger\Observer\Logger);
    Gasto::observe(new \NEkman\ModelLogger\Observer\Logger);
    DetalleGasto::observe(new \NEkman\ModelLogger\Observer\Logger);
    Soporte::observe(new \NEkman\ModelLogger\Observer\Logger);
    DetalleSoporte::observe(new \NEkman\ModelLogger\Observer\Logger);
 
    /******************************************************************************/

    Route::get('/'     , 'HomeController@index'   );
    Route::get('logIn' , 'HomeController@login'   );
    Route::get('logout', 'HomeController@logout'  );
    Route::post('index', 'HomeController@validate');

    Route::group(array('prefix' => 'user'), function()
    {   
        Route::group(array('prefix' => 'consulta'), function()
        {
            Route::get('VerTablaVentasDelDiaUsuario'   , 'UserController@VerTablaVentasDelDiaUsuario'   );
            Route::get('VerTablaSoporteDelDiaUsuario'  , 'UserController@VerTablaSoporteDelDiaUsuario'  );
            Route::get('VerTablaIngresosDelDiaUsuario' , 'UserController@VerTablaIngresosDelDiaUsuario' );
            Route::get('VerTablaEgresosDelDiaUsuario'  , 'UserController@VerTablaEgresosDelDiaUsuario'  );
            Route::get('VerTablaGastosDelDiaUsuario'   , 'UserController@VerTablaGastosDelDiaUsuario'   );
            Route::get('VerTablaAdelantosDelDiaUsuario', 'UserController@VerTablaAdelantosDelDiaUsuario');
            Route::get('VerTablaClientesUsuario'       , 'UserController@VerTablaClientesUsuario'       );

            //datatables de consultas de los usuarios
            Route::get('VentasDelDiaUsuario_dt'        , 'UserController@VentasDelDiaUsuario'           );
            Route::get('SoporteDelDiaUsuario_dt'       , 'UserController@SoporteDelDiaUsuario'          );
            Route::get('IngresosDelDiaUsuario_dt'      , 'UserController@IngresosDelDiaUsuario'         );
            Route::get('EgresosDelDiaUsuario_dt'       , 'UserController@EgresosDelDiaUsuario'          );
            Route::get('GastosDelDiaUsuario_dt'        , 'UserController@GastosDelDiaUsuario'           );
            Route::get('AdelantosDelDiaUsuario_dt'     , 'UserController@AdelantosDelDiaUsuario'        );
            Route::get('clientes_dt'                   , 'UserController@clientes'                      );
        });

        Route::group(array('prefix' => 'cliente'), function()
        {
            Route::get('buscar'                , 'ClienteController@search');
            Route::get('index'                 , 'ClienteController@index');
            Route::get('create'                , 'ClienteController@create');
            Route::post('create'               , 'ClienteController@create');
            Route::post('edit'                 , 'ClienteController@edit'  );
            Route::get('info'                  , 'ClienteController@info'  );
            Route::post('contacto_create'      , 'ClienteController@contacto_create');
            Route::get('contacto_nuevo'        , 'ClienteController@contacto_nuevo' );
            Route::post('contacto_update'      , 'ClienteController@contacto_update');
            Route::post('contacto_info'        , 'ClienteController@contacto_info'  );
            Route::get('salesByCustomer'       , 'ClienteController@salesByCustomer');
            Route::get('DT_salesByCustomer'    , 'ClienteController@DT_salesByCustomer');
            Route::get('creditSalesByCustomer' , 'ClienteController@creditSalesByCustomer');
            Route::get('info_cliente'          , 'ClienteController@info_cliente');
            Route::get('clientes'              , 'ClienteController@clientes'    );
        });

        Route::group(array('prefix' => 'soporte'), function()
        {
            Route::get('create'        , 'SoporteController@create');
            Route::post('delete'       , 'SoporteController@delete');
            Route::post('create'       , 'SoporteController@create');
            Route::post('delete_detail', 'SoporteController@delete_detail');
            Route::get('OpenTableSupportDay', 'SoporteController@OpenTableSupportDay');
            Route::get('SupportDay_dt'      , 'SoporteController@SupportDay_dt');
        });

        Route::group(array('prefix' => 'gastos'), function()
        {
            Route::get('create'        , 'GastoController@create');
            Route::post('delete'       , 'GastoController@delete');
            Route::post('create'       , 'GastoController@create');
            Route::post('delete_detail', 'GastoController@delete_detail');
            Route::get('OpenTableExpensesDay', 'GastoController@OpenTableExpensesDay');
            Route::get('ExpensesDay_dt'      , 'GastoController@ExpensesDay_dt');
        });

        Route::group(array('prefix' => 'egresos'), function()
        {
            Route::get('create'        , 'EgresoController@create');
            Route::post('delete'       , 'EgresoController@delete');
            Route::post('create'       , 'EgresoController@create');
            Route::post('delete_detail', 'EgresoController@delete_detail');
            Route::get('OpenTableExpendituresDay', 'EgresoController@OpenTableExpendituresDay');
            Route::get('ExpendituresDay_dt'      , 'EgresoController@ExpendituresDay_dt');
        });

        Route::group(array('prefix' => 'ingresos'), function()
        {
            Route::get('create'        , 'IngresoController@create');
            Route::post('delete'       , 'IngresoController@delete');
            Route::post('create'       , 'IngresoController@create');
            Route::post('delete_detail', 'IngresoController@delete_detail');
            Route::get('OpenTableIncomeDay', 'IngresoController@OpenTableIncomeDay');
            Route::get('IncomeDay_dt'      , 'IngresoController@IncomeDay_dt');
        });

        Route::group(array('prefix' => 'adelantos'), function()
        {
            Route::get('create'        , 'AdelantoController@create');
            Route::post('delete'       , 'AdelantoController@delete');
            Route::post('create'       , 'AdelantoController@create');
            Route::post('delete_detail', 'AdelantoController@delete_detail');
            Route::get('OpenTableAdvancesDay', 'AdelantoController@OpenTableAdvancesDay');
            Route::get('AdvancesDay_dt'      , 'AdelantoController@AdvancesDay_dt');
        });

        Route::group(array('prefix' => 'productos'), function()
        {
            Route::get('inventario'        , 'ProductoController@user_inventario');
            Route::get('view_inventario'   , 'ProductoController@user_inventario');
            Route::post('find'             , 'ProductoController@find');
            Route::get('md_search'         , 'ProductoController@md_search');
            Route::get('md_search_dt'      , 'ProductoController@md_search_dt');
            Route::get('user_inventario'   , 'ProductoController@user_inventario');
            Route::get('user_inventario_dt', 'ProductoController@user_inventario_dt');
        });

        Route::group(array('prefix' => 'ventas'), function()
        {
            Route::get('create'                 , 'VentasController@create' );
            Route::post('create'                , 'VentasController@create' );
            Route::post('detalle'               , 'VentasController@detalle');
            Route::post('RemoveSale'            , 'VentasController@RemoveSale');
            Route::post('RemoveSaleItem'        , 'VentasController@RemoveSaleItem');
            Route::get('ModalSalesPayments'     , 'VentasController@ModalSalesPayments');
            Route::post('ModalSalesPayments'    , 'VentasController@ModalSalesPayments');
            Route::post('RemoveSalePayment'     , 'VentasController@RemoveSalePayment');
            Route::post('FinalizeSale'          , 'VentasController@FinalizeSale');
            Route::get('OpenModalSalesPayments' , 'VentasController@OpenModalSalesPayments');
            Route::get('OpenTableSalesOfDay'    , 'VentasController@OpenTableSalesOfDay');
            Route::get('showSalesDetail'        , 'VentasController@showSalesDetail');
            Route::get('openSale'               , 'VentasController@openSale');
            Route::get('getCreditSales'         , 'VentasController@getCreditSales');
            Route::get('SalesOfDay'             , 'VentasController@SalesOfDay'  );

            Route::group(array('prefix' => 'payments'),function() 
            {
                Route::get('formPayments'          , 'SalesPaymentsController@formPayments');
                Route::get('formPaymentsPagination', 'SalesPaymentsController@formPaymentsPagination');
                Route::post('DeleteBalancePay'     , 'SalesPaymentsController@DeleteBalancePay'  );
                Route::post('SelectedPaySales'     , 'SalesPaymentsController@SelectedPaySales'  );
                
            });

        });

        Route::get('profile' , 'UserController@edit_profile');
        Route::post('new'    , 'UserController@create_new'  );
        Route::post('profile', 'UserController@edit_profile');
        Route::get('buscar_marca'    , 'MarcaController@search'   );
        Route::get('buscar_categoria', 'CategoriaController@search');
        Route::get('view_existencias', 'ProductoController@view_existencias');

    });

Route::group(array('prefix' => 'admin'), function()
{

    Route::group(array('prefix' => 'cierre'),function() 
    {
         Route::get('CierreDelDia' , 'CierreController@CierreDelDia' );
         Route::get('CierreDelMes' , 'CierreController@CierreDelMes' );
    });

    Route::group(array('prefix' => 'barcode'),function() 
    {
         Route::get('create'      , 'BarCodeController@create');
         Route::post('create'     , 'BarCodeController@create');
         Route::post('print_code' , 'BarCodeController@print_code');
    });

    Route::group(array('prefix' => 'productos'), function()
    {
        Route::post('edit'         , 'ProductoController@edit'   );
        Route::post('delete'       , 'ProductoController@delete' );
        Route::get('create'        , 'ProductoController@create' );
        Route::post('create'       , 'ProductoController@create' );
        Route::post('compra'       , 'ProductoController@compra' );
        Route::get('/'             , 'ProductoController@index');
        Route::get('inventario_dt' , 'ProductoController@inventario_dt');
    });

    Route::group(array('prefix' => 'proveedor'), function()
    {
        Route::get('buscar'               , 'ProveedorController@search');
        Route::get('index'                , 'ProveedorController@index' );
        Route::get('create'               , 'ProveedorController@create');
        Route::get('help'                 , 'ProveedorController@help'  );
        Route::post('edit'                , 'ProveedorController@edit'  );
        Route::post('create'              , 'ProveedorController@create');
        Route::post('delete'              , 'ProveedorController@delete');
        Route::post('contacto_create'     , 'ProveedorController@contacto_create');
        Route::get('contacto_nuevo'       , 'ProveedorController@contacto_nuevo' );
        Route::post('contacto_update'     , 'ProveedorController@contacto_update');
        Route::post('contacto_info'       , 'ProveedorController@contacto_info'  );
        Route::post('total_credito'       , 'ProveedorController@TotalCredito'   );
        Route::get('ShowModalPaySupplier' , 'ProveedorController@ShowModalPaySupplier'  );
        
        Route::get('AbonarCompra'         , 'ProveedorController@AbonarCompra');
        Route::post('AbonarCompra'        , 'ProveedorController@AbonarCompra');
        Route::post('EliminarAbonoCompra' , 'ProveedorController@EliminarAbonoCompra');
        Route::post('EliminarDetalleAbono', 'ProveedorController@EliminarDetalleAbono');
        Route::get('proveedores'          , 'ProveedorController@proveedores' );
    });

    Route::group(array('prefix' => 'compras'), function()
    {
        Route::get('create'                         , 'CompraController@create' );
        Route::post('create'                        , 'CompraController@create' );
        Route::get('detalle'                        , 'CompraController@detalle');
        Route::post('detalle'                       , 'CompraController@detalle');
        Route::post('verfactura'                    , 'CompraController@AbrirCompraNoCompletada');
        Route::get('ModalPurchasePayment '          , 'CompraController@ModalPurchasePayment'  );
        Route::post('ModalPurchasePayment'          , 'CompraController@ModalPurchasePayment'  );
        Route::post('DeletePurchaseInitial'         , 'CompraController@DeletePurchaseInitial' );
        Route::get('OpenModalPurchaseItemSerials'   , 'CompraController@OpenModalPurchaseItemSerials' );
        Route::get('OpenModalPurchaseInfo'          , 'CompraController@OpenModalPurchaseInfo');
        Route::post('OpenModalPurchaseInfo'         , 'CompraController@OpenModalPurchaseInfo');
        Route::post('DeletePurchaseShipping'        , 'CompraController@DeletePurchaseShipping'   );
        Route::post('FinishInitialPurchase'         , 'CompraController@FinishInitialPurchase');
        Route::post('SaveEditPurchaseItemDetails'   , "CompraController@SaveEditPurchaseItemDetails" );
        Route::post('DeletePurchaseDetailsItem'     , 'CompraController@DeletePurchaseDetailsItem' );
        Route::post('DeletePurchasePaymentItem'     , 'CompraController@DeletePurchasePaymentItem'   );
        Route::get('ConsultPurchase'                , 'CompraController@ConsultPurchase');
        Route::get('OpenTablePurchaseDay'           , 'CompraController@OpenTablePurchaseDay');
        Route::get('ShowTableUnpaidShopping'        , 'CompraController@ShowTableUnpaidShopping');
        Route::get('ShowTableHistoryPayment'        , 'CompraController@ShowTableHistoryPayment');
        Route::get('ShowTableHistoryPaymentDetails' , 'CompraController@ShowTableHistoryPaymentDetails');
        Route::get('showPurchaseDetail'             , 'CompraController@showPurchaseDetail');
        Route::get('showPaymentsDetail'             , 'CompraController@showPaymentsDetail');
        Route::get('Purchase_dt'                    , 'CompraController@Purchase_dt');
        Route::get('PurchaseUnpaid_dt'              , 'CompraController@PurchaseUnpaid_dt');
        Route::get('PurchaseDay_dt'                 , 'CompraController@PurchaseDay_dt');
        Route::get('ComprasPendientesDePago'        , 'CompraController@ComprasPendientesDePago');
        Route::get('HistorialDePagos'               , 'CompraController@HistorialDePagos');
        Route::get('HistorialDeAbonos'              , 'CompraController@HistorialDeAbonos');

        Route::group(array('prefix' => 'payments'),function() 
        {
            Route::get('formPayments'          , 'PurchasePaymentsController@formPayments');
            Route::get('formPaymentsPagination', 'PurchasePaymentsController@formPaymentsPagination');
            Route::post('OverdueBalancePay'    , 'PurchasePaymentsController@OverdueBalancePay'  );
            Route::post('DeleteBalancePay'     , 'PurchasePaymentsController@DeleteBalancePay'  );
            Route::post('FullBalancePay'       , 'PurchasePaymentsController@FullBalancePay'  );
            Route::post('PartialBalancePay'    , 'PurchasePaymentsController@PartialBalancePay'  );
            Route::post('SelectedPayPurchases' , 'PurchasePaymentsController@SelectedPayPurchases'  );
        });

    });

    Route::group(array('prefix' => 'categorias'), function()
    {
        Route::get('create' , 'CategoriaController@create' );
        Route::post('create', 'CategoriaController@create' );
        Route::post('edit'  , 'CategoriaController@edit'   );
    });

    Route::group(array('prefix' => 'marcas'), function()
    {
        Route::get('create' , 'MarcaController@create');
        Route::post('create', 'MarcaController@create');
        Route::post('edit'  , 'MarcaController@edit'  );
    });

    Route::group(array('prefix' => 'sub_categorias'), function()
    {
        Route::get('create' , 'SubCategoriaController@create');
        Route::post('create', 'SubCategoriaController@create');
        Route::get('filtro' , 'SubCategoriaController@filter_select');
        Route::post('edit'  , 'SubCategoriaController@edit');
    });

});

Route::group(array('prefix' => 'owner'), function()
{
    Route::get('users', 'UserController@index');

    Route::group(array('prefix' => 'logs'), function()
    {
        Route::get('productos'           , 'LogsController@productos');
        Route::get('productos_serverside', 'LogsController@productos_serverside');
        Route::get('usuarios'            , 'LogsController@usuarios' );
        Route::get('usuarios_serverside' , 'LogsController@usuarios_serverside' );
    });

    Route::group(array('prefix' => 'user'), function()
    {
        Route::get('create'      , 'UserController@create');
        Route::post('create'     , 'UserController@create');
        Route::post('edit'       , 'UserController@edit'  );
        Route::post('delete'     , 'UserController@delete');
        Route::post('remove_role', 'UserController@remove_role');
        Route::post('add_role'   , 'UserController@add_role'   );
        Route::get('roles'       , 'RolesController@index' );
        Route::get('roles/search', 'RolesController@search');
        Route::post('roles/edit' , 'RolesController@edit'  );
        Route::get('users'       , 'UserController@users'  );
    });

    Route::group(array('prefix' => 'chart'), function()
    {
        Route::get('gastos' , 'ChartController@gastos' );
        Route::get('soporte', 'ChartController@soporte');
        Route::get('ventas' , 'ChartController@ventas' );
    });

    Route::group(array('prefix' => 'soporte'), function()
    {
        Route::post('graph_by_day', 'App\graphics\SoporteGraph@graph_by_day');
        Route::get('form_graph_by_date', 'App\graphics\SoporteGraph@form_graph_by_date_get');
        Route::post('form_graph_by_date', 'App\graphics\SoporteGraph@form_graph_by_date_post');
        Route::post('graph_by_date', 'App\graphics\SoporteGraph@graph_by_date');
    });

    Route::group(array('prefix' => 'gastos'), function()
    {
        Route::post('graph_by_day', 'App\graphics\GastoGraph@graph_by_day');
        Route::get('form_graph_by_date', 'App\graphics\GastoGraph@form_graph_by_date_get');
        Route::post('form_graph_by_date', 'App\graphics\GastoGraph@form_graph_by_date_post');
        Route::post('graph_by_date', 'App\graphics\GastoGraph@graph_by_date');
    });

});

Route::get('test2' , 'CierreController@CierreDelMes' );
Route::get('test', function()
{   
    $venta = Venta::find(26035);
    return View::make('ventas.ImprimirGarantia', compact('venta'));
});


Route::get('proveedor', function()
{
    return View::make('layouts.proveedor_master');

});
Route::get('cliente', function()
{
    return View::make('layouts.cliente_master');

 });



Route::get('init', function()
{
    $metodo_pago = new MetodoPago;
    $metodo_pago->descripcion = 'Efectivo';
    $metodo_pago->save();

    $tienda = new Tienda;
    $tienda->nombre = 'Click';
    $tienda->direccion = 'Chiquimula';
    $tienda->telefono = '79421383';
    $tienda->status = 1;
    $tienda->save();

    $tienda = new Tienda;
    $tienda->nombre = 'Bodega';
    $tienda->direccion = 'Chiquimula';
    $tienda->telefono = '78787878';
    $tienda->status = 1;
    $tienda->save();
});

Route::get('init2', function()
{
    $user = new User;
    $user->tienda_id = 1;
    $user->username = 'hsosan1';
    $user->nombre = 'Gilder';
    $user->apellido = 'Hernandez';
    $user->email = 'hsosan1@hotmail.com';
    $user->password = '003210';
    $user->status = 1;
    $user->save();

    $user = new User;
    $user->tienda_id = 1;
    $user->username = 'admin';
    $user->nombre = 'admin';
    $user->apellido = 'admin';
    $user->email = 'admin@hotmail.com';
    $user->password = '123456';
    $user->status = 1;
    $user->save();

    $user = new User;
    $user->tienda_id = 1;
    $user->username = 'usuario';
    $user->nombre = 'usuario';
    $user->apellido = 'usuario';
    $user->email = 'usuario@hotmail.com';
    $user->password = '123456';
    $user->status = 1;
    $user->save();

    $owner = new Role;
    $owner->name = 'Owner';
    $owner->save();

    $admin = new Role;
    $admin->name = 'admin';
    $admin->save();

    $usuario = new Role();
    $usuario->name = 'User';
    $usuario->save();


    $user = User::where('username','=','hsosan1')->first();
    $user->attachRole( $owner );

    $user = User::where('username','=','admin')->first();
    $user->attachRole( $admin );

    $user = User::where('username','=','usuario')->first();
    $user->attachRole( $usuario );


    $manageProductos = new Permission;
    $manageProductos->name = 'manage_productos';
    $manageProductos->display_name = 'Manage productos';
    $manageProductos->save();

    $manageUsers = new Permission;
    $manageUsers->name = 'manage_users';
    $manageUsers->display_name = 'Manage Users';
    $manageUsers->save();

    $owner->perms()->sync(array($manageProductos->id,$manageUsers->id));
    $admin->perms()->sync(array($manageProductos->id));

    return 'Success!';
});

Route::get('dbseed', 'LoadDataController@index');

Route::get('timetest', function() 
{
    $start = date('Y/m/d H:i:s');
    $start = round(microtime(true) * 1000);

    $cliente = Autocomplete::get('clientes', array('id', 'nombre', 'apellido'));

    $end = date('Y/m/d H:i:s');
    $end = round(microtime(true) * 1000);

    return $end -$start;
});

Route::get('cod', function() {
    
    // $venta = Venta::with('cliente', 'detalle_venta')->find(74);

    // return $venta->detalle_venta[0]->producto->descripcion;

//     $collection = User::all();
// $grouped = $collection->groupBy('status');
//  return $grouped; 


//     $collection = User::all();
// $names = $collection->implode('nombre', ',');
// echo $names;    

    //     $table = 'ventas';

    //     $columns = array(
    //         "ventas.created_at as fecha", 
    //         "CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
    //         "CONCAT_WS(' ',clientes.nombre,clientes.apellido) as cliente",
    //         "numero_documento",
    //         "saldo",
    //         "completed"
    //         );

    //     $Search_columns = array("users.nombre","users.apellido","numero_documento","clientes.nombre","clientes.apellido");

    //     $Join = "JOIN users ON (users.id = ventas.user_id) JOIN clientes ON (clientes.id = ventas.cliente_id)";

    //     $where = "saldo > 0";


    // $query = DB::table('ventas')
    //     ->select(DB::raw("ventas.created_at as fecha, 
    //         CONCAT_WS(' ',users.nombre,users.apellido) as usuario, 
    //         CONCAT_WS(' ',clientes.nombre,clientes.apellido) as cliente,
    //         numero_documento,
    //         saldo"))
    //     ->join('users', 'ventas.user_id', '=', 'users.id')
    //     ->join('clientes', 'ventas.cliente_id', '=', 'clientes.id')
    //     ->where('saldo', '>', 0)
    //     ->orderBy('fecha', 'ASC')
    //     ->get();

    //     return $query;

        // $query = Venta::where('cliente_id','=', 3914)
        // ->where('saldo', '>', 0)
        // ->get();


        //     return $query[0]->cliente->nombre;

        // $query = Venta::where('cliente_id','=', 3914)
        // ->where('saldo', '>', 0)
        // ->get();

        // $saldo_total = 0;
        // $saldo_vencido = 0;

        // foreach ($query as  $q)
        // {
        //     $fecha_entrada = $q->created_at;
        //     $fecha_entrada = date('Ymd', strtotime($fecha_entrada));
        //     $fecha_vencida = date('Ymd',strtotime("-30 days"));

        //     if ($fecha_entrada < $fecha_vencida)
        //     {
        //         $saldo_vencido = $saldo_vencido + $q->saldo;
        //     }
        //     $saldo_total = $saldo_total + $q->saldo;
        // }

        // $cliente = $query[0]->cliente->nombre . "&nbsp;" . $query[0]->cliente->apellido;

        // $saldo_total   = f_num::get($saldo_total);
        // $saldo_vencido = f_num::get($saldo_vencido);

        // $tab = "";

        // $info = $cliente . $tab . " Saldo total &nbsp;". $saldo_total . $tab ." Saldo vencido &nbsp;" .$saldo_vencido;

        // return Response::json(array(
        //     'success'       => true,
        //     'info' => $info
        // ));
      
        $table = 'ventas';

        $columns = array(
            "ventas.created_at as fecha", 
            "CONCAT_WS(' ',users.nombre,users.apellido) as usuario",
            "CONCAT_WS(' ',clientes.nombre,clientes.apellido) as cliente",
            "numero_documento","completed",
            "saldo"
            );

        $Search_columns = array("users.nombre","users.apellido","numero_documento","clientes.nombre","clientes.apellido");

        $Join = "JOIN users ON (users.id = ventas.user_id) JOIN clientes ON (clientes.id = ventas.cliente_id)";

        $where = null;

        $productos = DB::table('users')->get();

        $data = Paginator::make($productos, 4, 2);
});


// App::error(function(Exception $exception) {
//     echo '<pre>';
//     echo 'MESSAGE :: ';
//         print_r($exception->getMessage());
//     echo '<br> CODE ::';
//         print_r($exception->getCode());
//     echo '<br> IN ::';
//         print_r($exception->getFile());
//     echo '<br> ON LINE ::';
//         print_r($exception->getLine());
// die();
// });


Route::get('pusher', function()
{
    App::make('Pusher')->trigger('demoChannel', 'userPost', ['title' => 'pusher test'] );
});
