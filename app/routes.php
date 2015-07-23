<?php
/*******************************************************************************/
Route::when('*', 'csrf', array('post', 'put', 'delete'));
Route::when('user/*' , 'auth');
Route::when('admin/*', 'auth');
Route::when('owner/*', 'auth');
    /*******************************************************************************
    funciones para hacer el guardado de logs    
    ********************************************************************************/
    Producto::observe(new \NEkman\ModelLogger\Observer\Logger);
    Compra::observe(new \NEkman\ModelLogger\Observer\Logger);
    Venta::observe(new \NEkman\ModelLogger\Observer\Logger);
    DetalleVenta::observe(new \NEkman\ModelLogger\Observer\Logger);
    Existencia::observe(new \NEkman\ModelLogger\Observer\Logger);

    /******************************************************************************
    rutas para evitar los errores de las imagenes no encontradas
    ******************************************************************************/
    Route::get('img/avatar/50/{img}.png', function(){ return "";});
    Route::get('images/{img}.png', function(){ return "";});
    Route::get('/{img}.ico', function(){ return "";});
    Route::get('assets/global/img/loader/general/{img}.gif', function(){ return "";});
    /******************************************************************************/
    
    Route::get('/'     , 'HomeController@index'   );
    Route::get('logIn' , 'HomeController@login'   );
    Route::get('logout', 'HomeController@logout'  );
    Route::post('index', 'HomeController@validate');

    Route::get('proveedor', function()
    {
        return View::make('layouts.proveedor_master');
    });

    Route::get('cliente', function()
    {
        return View::make('layouts.cliente_master');
    });

    Route::group(array('prefix' => 'user'), function()
    {
        Route::group(array('prefix' => 'chart'), function()
        {
            Route::get('chartVentasPorUsuario', 'ChartController@chartVentasPorUsuario');
        });

        Route::group(array('prefix' => 'tema'), function()
        {   
            Route::get('colorSchemes/{color}'         , 'TemaController@colorSchemes' );
            Route::get('navbarColor/{color}'          , 'TemaController@navbarColor'  );
            Route::get('sidebarColor/{color}'         , 'TemaController@sidebarColor' );
            Route::get('sidebarTypeSetting/{tipo}'    , 'TemaController@sidebarTypeSetting' );
        }); 

        Route::group(array('prefix' => 'consulta'), function()
        {
            Route::get('VerTablaVentasDelDiaUsuario'   , 'UserController@VerTablaVentasDelDiaUsuario'   );
            Route::get('VerTablaSoporteDelDiaUsuario'  , 'UserController@VerTablaSoporteDelDiaUsuario'  );
            Route::get('VerTablaIngresosDelDiaUsuario' , 'UserController@VerTablaIngresosDelDiaUsuario' );
            Route::get('VerTablaEgresosDelDiaUsuario'  , 'UserController@VerTablaEgresosDelDiaUsuario'  );
            Route::get('VerTablaGastosDelDiaUsuario'   , 'UserController@VerTablaGastosDelDiaUsuario'   );
            Route::get('VerTablaAdelantosDelDiaUsuario', 'UserController@VerTablaAdelantosDelDiaUsuario');
            Route::get('VerTablaClientesUsuario'       , 'UserController@VerTablaClientesUsuario'       );
            Route::get('VentasAlCreditoUsuario'        , 'UserController@VentasAlCreditoUsuario'        );
            //datatables de consultas de los usuarios//
            Route::get('VentasDelDiaUsuario_dt'        , 'UserController@VentasDelDiaUsuario_dt'        );
            Route::get('SoporteDelDiaUsuario_dt'       , 'UserController@SoporteDelDiaUsuario'          );
            Route::get('IngresosDelDiaUsuario_dt'      , 'UserController@IngresosDelDiaUsuario'         );
            Route::get('EgresosDelDiaUsuario_dt'       , 'UserController@EgresosDelDiaUsuario'          );
            Route::get('GastosDelDiaUsuario_dt'        , 'UserController@GastosDelDiaUsuario'           );
            Route::get('AdelantosDelDiaUsuario_dt'     , 'UserController@AdelantosDelDiaUsuario'        );
            Route::get('clientes_dt'                   , 'UserController@clientes'                      );
        });

Route::group(array('prefix' => 'cliente'), function()
{
    Route::get('search'                , 'ClienteController@search');
    Route::get('getInfo'               , 'ClienteController@getInfo');
    Route::post('delete'               , 'ClienteController@delete');
    Route::get('index'                 , 'ClienteController@index');
    Route::get('create'                , 'ClienteController@create');
    Route::post('create'               , 'ClienteController@create');
    Route::post('edit'                 , 'ClienteController@edit');
    Route::get('info'                  , 'ClienteController@info'  );
    Route::post('contacto_create'      , 'ClienteController@contacto_create');
    Route::post('contacto_delete'      , 'ClienteController@contacto_delete');
    Route::get('contacto_nuevo'        , 'ClienteController@contacto_nuevo' );
    Route::post('contacto_update'      , 'ClienteController@contacto_update');
    Route::post('contacto_info'        , 'ClienteController@contacto_info'  );
    Route::get('salesByCustomer'       , 'ClienteController@salesByCustomer');
    Route::get('DT_salesByCustomer'    , 'ClienteController@DT_salesByCustomer');
    Route::get('creditSalesByCustomer' , 'ClienteController@creditSalesByCustomer');
    Route::get('getInfoCliente'        , 'ClienteController@getInfoCliente');
    Route::get('getHistorialAbonos'    , 'ClienteController@getHistorialAbonos');
    Route::get('getHistorialPagos'     , 'ClienteController@getHistorialPagos');
    Route::get('DtHistorialPagos'      , 'ClienteController@DtHistorialPagos');
    Route::get('clientes'              , 'ClienteController@clientes'    );
});

Route::group(array('prefix' => 'soporte'), function()
{
    Route::get('create'                 , 'SoporteController@create');
    Route::post('delete'                , 'SoporteController@delete');
    Route::post('create'                , 'SoporteController@create');
    Route::post('delete_detail'         , 'SoporteController@delete_detail');
});

Route::group(array('prefix' => 'gastos'), function()
{
    Route::get('create'                    , 'GastoController@create');
    Route::post('delete'                   , 'GastoController@delete');
    Route::post('create'                   , 'GastoController@create');
    Route::post('delete_detail'            , 'GastoController@delete_detail');
});

Route::group(array('prefix' => 'egresos'), function()
{
    Route::get('create'                      , 'EgresoController@create');
    Route::post('delete'                     , 'EgresoController@delete');
    Route::post('create'                     , 'EgresoController@create');
    Route::post('delete_detail'              , 'EgresoController@delete_detail');
});

Route::group(array('prefix' => 'ingresos'), function()
{
    Route::get('create'                , 'IngresoController@create');
    Route::post('delete'               , 'IngresoController@delete');
    Route::post('create'               , 'IngresoController@create');
    Route::post('delete_detail'        , 'IngresoController@delete_detail');
});

Route::group(array('prefix' => 'adelantos'), function()
{
    Route::get('create'                    , 'AdelantoController@create');
    Route::post('delete'                   , 'AdelantoController@delete');
    Route::post('create'                   , 'AdelantoController@create');
    Route::post('delete_detail'            , 'AdelantoController@delete_detail');
});

Route::group(array('prefix' => 'productos'), function()
{
    Route::get('/'                 , 'ProductoController@index');
    Route::post('find'             , 'ProductoController@find');
    Route::get('md_search'         , 'ProductoController@md_search');
    Route::get('md_search_dt'      , 'ProductoController@md_search_dt');
    Route::get('user_inventario_dt', 'ProductoController@user_inventario_dt');
    Route::get('getInventario'     , 'ProductoController@getInventario');
});

Route::group(array('prefix' => 'ventas'), function()
{
    Route::get('create'                                 , 'VentasController@create' );
    Route::post('create'                                , 'VentasController@create' );
    Route::post('detalle'                               , 'VentasController@detalle');
    Route::post('UpdateDetalle'                         , 'VentasController@UpdateDetalle' );
    Route::post('updateClienteId'                       , 'VentasController@updateClienteId');
    Route::post('RemoveSale'                            , 'VentasController@RemoveSale');
    Route::post('RemoveSaleItem'                        , 'VentasController@RemoveSaleItem');
    Route::get('ModalSalesPayments'                     , 'VentasController@ModalSalesPayments');
    Route::post('ModalSalesPayments'                    , 'VentasController@ModalSalesPayments');
    Route::post('RemoveSalePayment'                     , 'VentasController@RemoveSalePayment');
    Route::post('FinalizeSale'                          , 'VentasController@FinalizeSale');
    Route::get('OpenModalSalesPayments'                 , 'VentasController@OpenModalSalesPayments');
    Route::get('showSalesDetail'                        , 'VentasController@showSalesDetail');
    Route::get('openSale'                               , 'VentasController@openSale');
    Route::get('getCreditSales'                         , 'VentasController@getCreditSales');
    Route::get('ImprimirVentaModal'                     , 'VentasController@ImprimirVentaModal'  );
    Route::get('ImprimirFacturaVenta/{id}'              , 'VentasController@ImprimirFacturaVenta'  );
    Route::get('ImprimirGarantiaVenta/{id}'             , 'VentasController@ImprimirGarantiaVenta'  );
    Route::get('ImprimirFacturaVenta/dt/{code}/{id}'    , 'VentasController@ImprimirFacturaVenta_dt'  );
    Route::get('ImprimirGarantiaVenta/dt/{code}/{id}'   , 'VentasController@ImprimirGarantiaVenta_dt'  );
    Route::get('imprimirAbonoVenta/{id}'                , 'VentasController@imprimirAbonoVenta'  );
    Route::get('VentasPorMetodoDePago'                  , 'VentasController@VentasPorMetodoDePago');

    Route::group(array('prefix' => 'payments'),function() 
    {
        Route::get('formPayments'              , 'SalesPaymentsController@formPayments');
        Route::post('formPayments'             , 'SalesPaymentsController@formPayments');
        Route::get('formPaymentsPagination'    , 'SalesPaymentsController@formPaymentsPagination');
        Route::post('eliminarAbonoVenta'       , 'SalesPaymentsController@eliminarAbonoVenta'  );
        Route::post('SelectedPaySales'         , 'SalesPaymentsController@SelectedPaySales'  );
        Route::get('getDetalleAbono'           , 'SalesPaymentsController@getDetalleAbono'  );
        Route::get('imprimirAbonoVenta/{id}'   , 'SalesPaymentsController@imprimirAbonoVenta'  );
        Route::get('imprimirAbonoVenta/dt/{id}', 'SalesPaymentsController@imprimirAbonoVenta_dt'  );
    });

});

Route::get('profile'                   , 'UserController@edit_profile');
Route::post('new'                      , 'UserController@create_new'  );
Route::post('profile'                  , 'UserController@edit_profile');
Route::get('buscar_marca'              , 'MarcaController@search'   );
Route::get('buscar_categoria'          , 'CategoriaController@search');
Route::get('view_existencias'          , 'ProductoController@view_existencias');
Route::get('OpenModalSalesItemSerials' , 'CompraController@OpenModalPurchaseItemSerials' );

});

Route::group(array('prefix' => 'admin'), function()
{
    Route::group(array('prefix' => 'queries'),function() 
    {
        Route::get('getMasterQueries'                        , 'QueriesController@getMasterQueries'    );
        Route::get('getVentasPorFecha/{consulta}'            , 'QueriesController@getVentasPorFecha'   );
        Route::get('DtVentasPorFecha/{consulta}'             , 'QueriesController@DtVentasPorFecha'    );
        Route::get('getComprasPorFecha/{consulta}'           , 'QueriesController@getComprasPorFecha'  );
        Route::get('DtComprasPorFecha/{consulta}'            , 'QueriesController@DtComprasPorFecha'   );
        Route::get('getDescargasPorFecha/{consulta}'         , 'QueriesController@getDescargasPorFecha');
        Route::get('DtDescargasPorFecha/{consulta}'          , 'QueriesController@DtDescargasPorFecha' );
        Route::get('getEgresosPorFecha/{consulta}'           , 'QueriesController@getEgresosPorFecha'  );
        Route::get('DtEgresosPorFecha/{consulta}'            , 'QueriesController@DtEgresosPorFecha'   );
        Route::get('getGastosPorFecha/{consulta}'            , 'QueriesController@getGastosPorFecha'   );
        Route::get('DtGastosPorFecha/{consulta}'             , 'QueriesController@DtGastosPorFecha'    );
        Route::get('getAbonosProveedoresPorFecha/{consulta}' , 'QueriesController@getAbonosProveedoresPorFecha');
        Route::get('DtAbonosProveedoresPorFecha/{consulta}'  , 'QueriesController@DtAbonosProveedoresPorFecha' );
        Route::get('getSoportePorFecha/{consulta}'           , 'QueriesController@getSoportePorFecha'  );
        Route::get('DtSoportePorFecha/{consulta}'            , 'QueriesController@DtSoportePorFecha'   );
        Route::get('getAbonosClientesPorFecha/{consulta}'    , 'QueriesController@getAbonosClientesPorFecha');
        Route::get('DtAbonosClientesPorFecha/{consulta}'     , 'QueriesController@DtAbonosClientesPorFecha' );
        Route::get('getAdelantosPorFecha/{consulta}'         , 'QueriesController@getAdelantosPorFecha' );
        Route::get('DtAdelantosPorFecha/{consulta}'          , 'QueriesController@DtAdelantosPorFecha'  );
        Route::get('getIngresosPorFecha/{consulta}'          , 'QueriesController@getIngresosPorFecha'  );
        Route::get('DtIngresosPorFecha/{consulta}'           , 'QueriesController@DtIngresosPorFecha'   );
    });

Route::group(array('prefix' => 'cierre'),function() 
{
 Route::get('CierreDelDia'                        , 'CierreController@CierreDelDia' );
 Route::get('cierre'                              , 'CierreController@cierre' );
 Route::post('cierre'                             , 'CierreController@cierre' );
 Route::get('CierreDelMes'                        , 'CierreController@CierreDelMes' );
 Route::get('CierreDelDiaPorFecha'                , 'CierreController@CierreDelDiaPorFecha' );
 Route::get('CierreDelMesPorFecha'                , 'CierreController@CierreDelMesPorFecha' );
 Route::get('CierresDelMes'                       , 'CierreController@CierresDelMes' );
 Route::get('CierresDelMes_dt'                    , 'CierreController@CierresDelMes_dt' );
 Route::get('VerDetalleDelCierreDelDia'           , 'CierreController@VerDetalleDelCierreDelDia' );
 Route::get('ImprimirCierreDelDia_dt/{code}/{id}' , 'CierreController@ImprimirCierreDelDia_dt' );
 Route::get('ExportarCierreDelDia/{tipo}/{fecha}' , 'CierreController@ExportarCierreDelDia' );
 Route::get('VentasDelMes'                        , 'CierreController@VentasDelMes' );
 Route::get('VentasDelMes_dt'                     , 'CierreController@VentasDelMes_dt' );
 Route::get('SoportePorFecha'                     , 'CierreController@SoportePorFecha' );
 Route::get('SoportePorFecha_dt'                  , 'CierreController@SoportePorFecha_dt' );
 Route::get('GastosPorFecha'                      , 'CierreController@GastosPorFecha' );
 Route::get('GastosPorFecha_dt'                   , 'CierreController@GastosPorFecha_dt' );
 Route::get('DetalleDeVentasPorProducto'          , 'CierreController@DetalleDeVentasPorProducto' );
 Route::get('DetalleVentaCierre'                  , 'CierreController@DetalleVentaCierre' );
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
    Route::get('edit_dt'       , 'ProductoController@edit_dt'   );
    Route::post('edit_dt'      , 'ProductoController@edit'   );
    Route::post('delete'       , 'ProductoController@delete' );
    Route::get('create'        , 'ProductoController@create' );
    Route::post('create'       , 'ProductoController@create' );
    Route::post('compra'       , 'ProductoController@compra' );
});

Route::group(array('prefix' => 'proveedor'), function()
{
    Route::get('buscar'                      , 'ProveedorController@search');
    Route::get('index'                       , 'ProveedorController@index' );
    Route::get('create'                      , 'ProveedorController@create');
    Route::get('help'                        , 'ProveedorController@help'  );
    Route::post('edit'                       , 'ProveedorController@edit'  );
    Route::post('create'                     , 'ProveedorController@create');
    Route::post('delete'                     , 'ProveedorController@delete');
    Route::post('contacto_create'            , 'ProveedorController@contacto_create');
    Route::post('contacto_delete'            , 'ProveedorController@contacto_delete');
    Route::get('contacto_nuevo'              , 'ProveedorController@contacto_nuevo' );
    Route::post('contacto_update'            , 'ProveedorController@contacto_update');
    Route::post('contacto_info'              , 'ProveedorController@contacto_info'  );
    Route::post('total_credito'              , 'ProveedorController@TotalCredito'   );
    Route::get('ShowModalPaySupplier'        , 'ProveedorController@ShowModalPaySupplier'  );
    Route::get('proveedores'                 , 'ProveedorController@proveedores' );
    Route::get('ImprimirAbono/dt/{code}/{id}', 'ProveedorController@ImprimirAbono_dt' );
    Route::get('ImprimirAbono/{id}'          , 'ProveedorController@ImprimirAbono' );
    Route::get('getInfoProveedor'            , 'ProveedorController@getInfoProveedor');
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
    Route::get('ShowTableUnpaidShopping'        , 'CompraController@ShowTableUnpaidShopping');
    Route::get('ShowTableHistoryPayment'        , 'CompraController@ShowTableHistoryPayment');
    Route::get('ShowTableHistoryPaymentDetails' , 'CompraController@ShowTableHistoryPaymentDetails');
    Route::get('showPurchaseDetail'             , 'CompraController@showPurchaseDetail');
    Route::get('showPaymentsDetail'             , 'CompraController@showPaymentsDetail');
    Route::get('Purchase_dt'                    , 'CompraController@Purchase_dt');
    Route::get('PurchaseUnpaid_dt'              , 'CompraController@PurchaseUnpaid_dt');
    Route::get('ComprasPendientesDePago'        , 'CompraController@ComprasPendientesDePago');
    Route::get('HistorialDePagos'               , 'CompraController@HistorialDePagos');
    Route::get('HistorialDeAbonos'              , 'CompraController@HistorialDeAbonos');
    Route::get('getCreditPurchase'              , 'CompraController@getCreditPurchase');

    Route::group(array('prefix' => 'payments'),function() 
    {
        Route::get('formPayments'               , 'PurchasePaymentsController@formPayments');
        Route::post('formPayments'              , 'PurchasePaymentsController@formPayments');
        Route::get('formPaymentsPagination'     , 'PurchasePaymentsController@formPaymentsPagination');
        Route::post('OverdueBalancePay'         , 'PurchasePaymentsController@OverdueBalancePay'  );
        Route::post('eliminarAbono'             , 'PurchasePaymentsController@eliminarAbono'  );
        Route::post('FullBalancePay'            , 'PurchasePaymentsController@FullBalancePay'  );
        Route::post('PartialBalancePay'         , 'PurchasePaymentsController@PartialBalancePay'  );
        Route::post('delete'                    , 'PurchasePaymentsController@delete'  );
        Route::post('abonosComprasPorSeleccion' , 'PurchasePaymentsController@abonosComprasPorSeleccion'  );
    });

});

Route::group(array('prefix' => 'descargas'), function()
{
    Route::get('create'                             , 'DescargaController@create' );
    Route::post('create'                            , 'DescargaController@create' );
    Route::post('edit'                              , 'DescargaController@edit'   );
    Route::get('edit'                               , 'DescargaController@edit'   );
    Route::post('eliminar_detalle'                  , 'DescargaController@eliminar_detalle'   );
    Route::post('delete'                            , 'DescargaController@delete'   );
    Route::get('ImprimirDescarga/{id}'              , 'DescargaController@ImprimirDescarga'   );
    Route::get('ImprimirDescarga/dt/{code}/{id}'    , 'DescargaController@ImprimirDescarga_dt'  );
    Route::get('OpenTableDownloadsDay'              , 'DescargaController@OpenTableDownloadsDay' );
    Route::get('DownloadsDay_dt'                    , 'DescargaController@DownloadsDay_dt'  );
    Route::get('showgDownloadsDetail'               , 'DescargaController@showgDownloadsDetail'  );
    Route::get('OpenDownload'                       , 'DescargaController@OpenDownload'  );
    Route::get('OpenTableDownloadsForDate'          , 'DescargaController@OpenTableDownloadsForDate' );
    Route::get('DownloadsForDate'                   , 'DescargaController@DownloadsForDate' );
    Route::get('descripcion'                        , 'DescargaController@descripcion' );
    Route::post('descripcion'                       , 'DescargaController@descripcion' );
});

Route::group(array('prefix' => 'categorias'), function()
{
    Route::get('create' , 'CategoriaController@create' );
    Route::post('create', 'CategoriaController@create' );
    Route::post('edit'  , 'CategoriaController@edit'   );
    Route::get('edit'   , 'CategoriaController@edit'   );
});

Route::group(array('prefix' => 'marcas'), function()
{
    Route::get('create' , 'MarcaController@create');
    Route::post('create', 'MarcaController@create');
    Route::post('edit'  , 'MarcaController@edit'  );
    Route::get('edit'   , 'MarcaController@edit'  );
});

Route::group(array('prefix' => 'sub_categorias'), function()
{
    Route::get('create' , 'SubCategoriaController@create');
    Route::post('create', 'SubCategoriaController@create');
    Route::get('filtro' , 'SubCategoriaController@filter_select');
    Route::post('edit'  , 'SubCategoriaController@edit'  );
    Route::get('edit'   , 'SubCategoriaController@edit');
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

        Route::group(array('prefix' => 'ventas'), function()
        {
            Route::get('ventasMensualesPorAno' , 'App\graphics\Ventas@ventasMensualesPorAno');
            Route::get('ventasDiariasPorMes' , 'App\graphics\Ventas@ventasDiariasPorMes');
        });
    });

    Route::group(array('prefix' => 'soporte'), function()
    {
        Route::post('graph_by_day'      , 'App\graphics\SoporteGraph@graph_by_day');
        Route::get('form_graph_by_date' , 'App\graphics\SoporteGraph@form_graph_by_date_get');
        Route::post('form_graph_by_date', 'App\graphics\SoporteGraph@form_graph_by_date_post');
        Route::post('graph_by_date'     , 'App\graphics\SoporteGraph@graph_by_date');
    });

    Route::group(array('prefix' => 'gastos'), function()
    {
        Route::post('graph_by_day'      , 'App\graphics\GastoGraph@graph_by_day');
        Route::get('form_graph_by_date' , 'App\graphics\GastoGraph@form_graph_by_date_get');
        Route::post('form_graph_by_date', 'App\graphics\GastoGraph@form_graph_by_date_post');
        Route::post('graph_by_date'     , 'App\graphics\GastoGraph@graph_by_date');
    });

});

Route::get('test', function()
{
   /*$detalle = DetalleVenta::with('venta','producto')->where('producto_id',1000038)
   ->join('ventas','ventas.id','=','venta_id')
   ->whereRaw("DATE_FORMAT(detalle_ventas.created_at, '%Y-%m') = DATE_FORMAT('2015-05-10', '%Y-%m')")
   ->where('ventas.tienda_id',Auth::user()->tienda_id)->get();
   
   return View::make('cierre.DetalleDeVentasPorProducto', compact('detalle'))->render();*/

        $ventas = DB::table('ventas')
        ->where('ventas.tienda_id', Auth::user()->tienda_id)
        ->where(DB::raw('YEAR(ventas.created_at)'), date("Y") )
        ->where(DB::raw('total'), '>', 0 )
        ->select(DB::raw("sum(total) as total, MONTH(ventas.created_at) as mes"))
        ->groupBy('mes')
        ->get();

        $dt = App::make('Fecha');
        $i = 0;
        
        foreach ($ventas as $v) {
            $data[$i]['name'] = $dt->monthsNames($v->mes);
            $data[$i]['y'] = (float) $v->total;
            $data[$i]['drilldown'] = true;
            $i++;
        }

        $data = json_encode($data);

        // return $data;
        $query = DB::table('ventas')
        ->select(array(DB::Raw('DATE(ventas.created_at) as dia'), DB::Raw('sum(total) as total')))
        ->where(DB::raw('YEAR(ventas.created_at)'), '=', 2015)
        ->where(DB::raw('MONTH(ventas.created_at)'), '=', 6)
        ->where('tienda_id', '=', 1)
        ->groupBy('dia')
        ->get();

        return json_encode($query);

});

Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');


/*Route::get('timetest', function() 
{
    $start = date('Y/m/d H:i:s');
    $start = round(microtime(true) * 1000);

    $cliente = Autocomplete::get('clientes', array('id', 'nombre', 'apellido'));

    $end = date('Y/m/d H:i:s');
    $end = round(microtime(true) * 1000);

    return $end -$start;
});
*/