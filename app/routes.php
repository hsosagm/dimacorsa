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
        Route::group(array('prefix' => 'datatables'),function() 
        {
            Route::get('md_search'      , 'InventarioController@md_search');
            Route::get('md_datatables'  , 'DatatablesController@md_search');
            Route::get('user_inventario', 'InventarioController@user_inventario');
            Route::get('user_datatables', 'DatatablesController@user_inventario');
            Route::get('proveedores'    , 'DatatablesController@proveedores'    );
            Route::get('users'          , 'DatatablesController@users');
            Route::get('/'              , 'DatatablesController@index');

        });

        Route::group(array('prefix' => 'cliente'), function()
        {
            Route::get('buscar' , 'ClienteController@search');
            Route::get('create' , 'ClienteController@create');
            Route::post('create', 'ClienteController@create');
            Route::post('edit'  , 'ClienteController@edit'  );
        });

        Route::group(array('prefix' => 'soporte'), function()
        {
            Route::get('create'        , 'SoporteController@create');
            Route::post('delete'       , 'SoporteController@delete');
            Route::post('create'       , 'SoporteController@create');
            Route::post('delete_detail', 'SoporteController@delete_detail');
        });

        Route::group(array('prefix' => 'gastos'), function()
        {
            Route::get('create'        , 'GastoController@create');
            Route::post('delete'       , 'GastoController@delete');
            Route::post('create'       , 'GastoController@create');
            Route::post('delete_detail', 'GastoController@delete_detail');
        });

        Route::group(array('prefix' => 'egresos'), function()
        {
            Route::get('create'        , 'EgresoController@create');
            Route::post('delete'       , 'EgresoController@delete');
            Route::post('create'       , 'EgresoController@create');
            Route::post('delete_detail', 'EgresoController@delete_detail');
        });

        Route::group(array('prefix' => 'ingresos'), function()
        {
            Route::get('create'        , 'IngresoController@create');
            Route::post('delete'       , 'IngresoController@delete');
            Route::post('create'       , 'IngresoController@create');
            Route::post('delete_detail', 'IngresoController@delete_detail');
        });

        Route::group(array('prefix' => 'productos'), function()
        {
            Route::get('inventario'     , 'ProductoController@user_inventario');
            Route::get('view_inventario', 'DatatablesController@user_inventario');
            Route::post('find'          , 'ProductoController@find');

        });

        Route::group(array('prefix' => 'ventas'), function()
        {
            Route::get('create'  , 'VentasController@create' );
            Route::post('create' , 'VentasController@create' );
            Route::post('detalle', 'VentasController@detalle');
            Route::post('RemoveSale', 'VentasController@RemoveSale');
            Route::post('RemoveSaleItem', 'VentasController@RemoveSaleItem');
            Route::get('OpenModalSalesPayments', 'VentasController@OpenModalSalesPayments');
        });

        Route::get('profile' , 'UserController@edit_profile');
        Route::post('new'    , 'UserController@create_new'  );
        Route::post('profile', 'UserController@edit_profile');
        Route::get('buscar_marca'    , 'MarcaController@search'   );
        Route::get('buscar_categoria', 'CategoriaController@search');
        Route::get('buscar_proveedor', 'ProveedorController@search');
        Route::get('view_existencias', 'ProductoController@view_existencias');

    });

Route::group(array('prefix' => 'admin'), function()
{

    Route::group(array('prefix' => 'datatables'),function() 
    {
        Route::get('inventario_dt', 'InventarioController@inventario_dt');
    });

    Route::group(array('prefix' => 'productos'), function()
    {
        Route::post('edit'  , 'ProductoController@edit'   );
        Route::post('delete', 'ProductoController@delete' );
        Route::get('create' , 'ProductoController@create' );
        Route::post('create', 'ProductoController@create' );
        Route::post('compra', 'ProductoController@compra' );
    });

    Route::group(array('prefix' => 'proveedor'), function()
    {
        Route::get('index'  , 'ProveedorController@index' );
        Route::get('create' , 'ProveedorController@create');
        Route::get('help'   , 'ProveedorController@help'  );
        Route::post('edit'  , 'ProveedorController@edit'  );
        Route::post('create', 'ProveedorController@create');
        Route::post('delete', 'ProveedorController@delete');
        Route::post('contacto_create', 'ProveedorController@contacto_create');
        Route::get('contacto_nuevo'  , 'ProveedorController@contacto_nuevo' );
        Route::post('contacto_update', 'ProveedorController@contacto_update');
        Route::post('contacto_info'  , 'ProveedorController@contacto_info'  );
        Route::post('total_credito'  , 'ProveedorController@TotalCredito'   );
    });

    Route::group(array('prefix' => 'compras'), function()
    {
        Route::get('create'  , 'CompraController@create' );
        Route::post('create' , 'CompraController@create' );
        Route::get('detalle' , 'CompraController@detalle');
        Route::post('detalle', 'CompraController@detalle');
        Route::get('OpenModalPurchasePayment'    , 'CompraController@OpenModalPurchasePayment'  );
        Route::post('SavePurchasePayment'        , 'CompraController@SavePurchasePayment'  );
        Route::post('DeletePurchaseInitial'      , 'CompraController@DeletePurchaseInitial' );
        Route::get('OpenModalPurchaseItemSerials', 'CompraController@OpenModalPurchaseItemSerials' );
        Route::get('OpenModalPurchaseInfo'       , 'CompraController@OpenModalPurchaseInfo');
        Route::post('OpenModalPurchaseInfo'      , 'CompraController@OpenModalPurchaseInfo');
        Route::post('DeletePurchaseShipping'     , 'CompraController@DeletePurchaseShipping'   );
        Route::post('FinishInitialPurchase'      , 'CompraController@FinishInitialPurchase');
        Route::post('SaveEditPurchaseItemDetails', "CompraController@SaveEditPurchaseItemDetails" );
        Route::post('DeletePurchaseDetailsItem'  , 'CompraController@DeletePurchaseDetailsItem' );
        Route::post('DeletePurchasePaymentItem'  , 'CompraController@DeletePurchasePaymentItem'   );
       
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
        Route::get('productos', 'LogsController@productos');
        Route::get('productos_serverside', 'LogsController@productos_serverside');
        Route::get('usuarios' , 'LogsController@usuarios' );
        Route::get('usuarios_serverside' , 'LogsController@usuarios_serverside' );
    });

    Route::group(array('prefix' => 'user'), function()
    {
        Route::get('create' , 'UserController@create');
        Route::post('create', 'UserController@create');
        Route::post('edit'  , 'UserController@edit'  );
        Route::post('delete', 'UserController@delete');
        Route::post('remove_role', 'UserController@remove_role');
        Route::post('add_role'   , 'UserController@add_role'   );
        Route::get('roles'       , 'RolesController@index' );
        Route::get('roles/search', 'RolesController@search');
        Route::post('roles/edit' , 'RolesController@edit'  );
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

Route::get('test', function()
{


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

    $cliente = Existencia::where('producto_id', 1003783)->update(array('existencia' => 12));

    $end = date('Y/m/d H:i:s');
    $end = round(microtime(true) * 1000);

    return $end -$start;
});

Route::get('cod', function() {

    // $query = DB::table('productos')->where('id', '=', '1003562')->first();

    // return $query->id;

    // $query = Producto::find(1003562);

    // return $query->id;

    // $query = DetalleVenta::where('venta_id', 5)->get();

    // foreach ($query as $q) {
    //     echo $q->producto_id;
    //     echo $q->cantidad;
    // }

    // $existencia = Existencia::where('producto_id', 1000000)->where('tienda_id', Auth::user()->tienda_id)->first();

    // dd($existencia);

    // if ($existencia->existencia < Input::get('cantidad')) {
    //         return false;
    // }

    // return 2;

        $dv = DetalleVenta::where('venta_id','=', 2)->first();

        if ($dv == null ) return 'si';
        return 'no';
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