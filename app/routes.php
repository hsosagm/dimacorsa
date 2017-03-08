<?php
    /*******************************************************************************/
    Route::when('*', 'csrf', array('post', 'put', 'delete'));
    Route::when('user/*' , 'auth');
    Route::when('admin/*', 'auth');
    Route::when('owner/*', 'auth');

    /******************************************************************************
    rutas para evitar los errores de las imagenes no encontradas
    ******************************************************************************/
    Route::get('img/avatar/50/{img}.png', function(){ return "";});
    Route::get('images/{img}.png', function(){ return "";});
    Route::get('/{img}.ico', function(){ return "";});
    Route::get('assets/global/img/loader/general/{img}.gif', function(){ return "";});
    /******************************************************************************/

    /******************************************************************************/
    //rutas para imprimr con el plugin qzprint
    Route::post('ImprimirGarantia'         , 'VentasController@ImprimirGarantia');
    Route::post('ImprimirDescarga'         , 'DescargaController@ImprimirDescarga');
    Route::post('ImprimirTraslado'         , 'TrasladoController@ImprimirTraslado');
    Route::post('ImprimirAbonoCliente'     , 'SalesPaymentsController@imprimirAbonoVenta');
    Route::post('ImprimirAbonoProveedor'   , 'ProveedorController@ImprimirAbono' );
    Route::post('imprimirFacturaBond'      , 'VentasController@imprimirFacturaBond' );

    //rutas para mostrar el pdf cuando no carga el plugin
    Route::get('ImprimirGarantiaPdf'       , 'VentasController@ImprimirGarantiaPdf');
    Route::get('ImprimirDescargaPdf'       , 'DescargaController@ImprimirDescargaPdf');
    Route::get('ImprimirTrasladoPdf'       , 'TrasladoController@ImprimirTrasladoPdf');
    Route::get('ImprimirAbonoClientePdf'   , 'SalesPaymentsController@imprimirAbonoVentaPdf');
    Route::get('ImprimirAbonoProveedorPdf' , 'ProveedorController@ImprimirAbonoPdf');
    Route::get('imprimirFacturaBondPdf'    , 'VentasController@imprimirFacturaBondPdf');


    Route::get('ImprimirCotizacion/{op}/{id}' , 'CotizacionController@ImprimirCotizacion' );
    Route::get('imprimirNotaDeCretido'        , 'NotaCreditoController@imprimirNotaDeCretido' );
    Route::get('retirarDineroDeCajaPdf'       , 'CajaController@retirarDineroDeCajaPdf' );
    Route::get('imprimirCorteCaja/{id}'       , 'CajaController@imprimirCorteCaja' );
    Route::get('printDevolucion'              , 'DevolucionesVentasController@printDevolucion' );

    // Esta funcion se usa solo cuando se imprime con qzprint
    // public_path() Carpeta public de laravel
    // Input::get('pdf') Trae el nombre del pdf que acaba de crear
    Route::post('/eliminar_pdf', function() {
        $file = public_path().'/pdf/'.Input::get('pdf').'.pdf';
        if (is_file($file)) { // Verifica si el archivo existe
            chmod($file,0777); // Quita los permisos para cualquier usuario lo pueda eliminar
            unlink($file); // Elimina el archivo
        }
    });
    /******************************************************************************/

    Route::get('/'     , 'HomeController@index');
    Route::get('logIn' , 'HomeController@login');
    Route::post('logIn', 'HomeController@validate_phone');
    Route::get('logout', 'HomeController@logout');
    Route::post('index', 'HomeController@validate');

    Route::post('setCambiarDeUsuarioAutenticado', 'HomeController@setCambiarDeUsuarioAutenticado');

    Route::get('proveedor', function()
    {
        return View::make('layouts.proveedor_master');
    });

    Route::get('cliente', function()
    {
        return View::make('layouts.cliente_master');
    });

    Route::get('pos', function()
    {
        return View::make('layouts.pos');
    });

    Route::group(array('prefix' => 'user'), function()
    {
        Route::group(array('prefix' => 'chart'), function()
        {
            Route::get('chartVentasPorUsuario', 'ChartController@chartVentasPorUsuario');
            Route::get('chartVentasPorCliente', 'ChartController@chartVentasPorCliente');
            Route::get('chartComparativaPorMesPorCliente', 'ChartController@chartComparativaPorMesPorCliente');
            Route::get('comparativaPorMesPorClientePrevOrNext', 'ChartController@comparativaPorMesPorClientePrevOrNext');
            Route::get('ventasMensualesPorAnoPorCliente', 'App\graphics\Ventas@ventasMensualesPorAnoPorCliente');
            Route::get('ventasDiariasPorMesCliente', 'App\graphics\Ventas@ventasDiariasPorMesCliente');
        });

        Route::group(array('prefix' => 'tema'), function()
        {
            Route::get('colorSchemes/{color}'         , 'TemaController@colorSchemes' );
            Route::get('navbarColor/{color}'          , 'TemaController@navbarColor'  );
            Route::get('sidebarColor/{color}'         , 'TemaController@sidebarColor' );
            Route::get('sidebarTypeSetting/{tipo}'    , 'TemaController@sidebarTypeSetting' );
        });

        Route::group(array('prefix' => 'notaDeCredito'), function()
        {
            Route::get('create'          , 'NotaCreditoController@create' );
            Route::post('create'         ,'NotaCreditoController@create'  );
            Route::post('detalle'        ,'NotaCreditoController@detalle' );
            Route::post('updateClienteId','NotaCreditoController@updateClienteId' );
            Route::post('eliminarDetalle','NotaCreditoController@eliminarDetalle' );
            Route::get('getFormSeleccionarTipoDeNotaDeCredito', 'NotaCreditoController@getFormSeleccionarTipoDeNotaDeCredito');
            Route::post('getConsultarNotasDeCreditoCliente'   ,'NotaCreditoController@getConsultarNotasDeCreditoCliente' );
            Route::get('getConsultarNotasDeCreditoCliente'    ,'NotaCreditoController@getConsultarNotasDeCreditoCliente' );
            Route::get('getDetalleNotaDeCredito'              , 'NotaCreditoController@getDetalleNotaDeCredito' );
        });

        Route::group(array('prefix' => 'consulta'), function()
        {
            Route::get('VerTablaAdelantosDelDiaUsuario', 'UserController@VerTablaAdelantosDelDiaUsuario');
            Route::get('VerTablaClientesUsuario'       , 'UserController@VerTablaClientesUsuario'       );
            Route::get('VentasAlCreditoUsuario'        , 'UserController@VentasAlCreditoUsuario'        );
            Route::get('VerTablaVentasDelDiaUsuario'   , 'UserController@VerTablaVentasDelDiaUsuario');
            //datatables de consultas de los usuarios//
            Route::get('VentasDelDiaUsuario_dt'        , 'UserController@VentasDelDiaUsuario_dt'        );
            Route::get('SoporteDelDiaUsuario_dt'       , 'UserController@SoporteDelDiaUsuario'          );
            Route::get('IngresosDelDiaUsuario_dt'      , 'UserController@IngresosDelDiaUsuario'         );
            Route::get('EgresosDelDiaUsuario_dt'       , 'UserController@EgresosDelDiaUsuario'          );
            Route::get('GastosDelDiaUsuario_dt'        , 'UserController@GastosDelDiaUsuario'           );
            Route::get('AdelantosDelDiaUsuario_dt'     , 'UserController@AdelantosDelDiaUsuario'        );
            Route::get('clientes_dt'                   , 'UserController@clientes'                      );
            Route::get('getConsultarSerie'             , 'UserController@getConsultarSerie'             );
            Route::post('setConsultarSerie'            , 'UserController@setConsultarSerie'             );
            Route::get('getConsultarNotasDeCredito'    , 'UserController@getConsultarNotasDeCredito'    );
            Route::get('DtConsultarNotasDeCredito'     , 'UserController@DtConsultarNotasDeCredito'     );
            Route::get('VentasSinFinalizar'            , 'UserController@VentasSinFinalizar'            );
            Route::get('DtVentasSinFinalizar'          , 'UserController@DtVentasSinFinalizar'     );

        });

        Route::group(array('prefix' => 'cliente'), function()
        {
            Route::get('search'                   , 'ClienteController@search');
            Route::get('getInfo'                  , 'ClienteController@getInfo');
            Route::post('delete'                  , 'ClienteController@delete');
            Route::get('index'                    , 'ClienteController@index');
            Route::get('create'                   , 'ClienteController@create');
            Route::post('create'                  , 'ClienteController@create');
            Route::post('edit'                    , 'ClienteController@edit');
            Route::get('_edit'                    , 'ClienteController@_edit');
            Route::get('info'                     , 'ClienteController@info'  );
            Route::post('contacto_create'         , 'ClienteController@contacto_create');
            Route::post('contacto_delete'         , 'ClienteController@contacto_delete');
            Route::get('contacto_nuevo'           , 'ClienteController@contacto_nuevo' );
            Route::post('contacto_update'         , 'ClienteController@contacto_update');
            Route::post('contacto_info'           , 'ClienteController@contacto_info'  );
            Route::get('salesByCustomer'          , 'ClienteController@salesByCustomer');
            Route::get('devolutionsByCustomer'    , 'ClienteController@devolutionsByCustomer');
            Route::get('DT_salesByCustomer'       , 'ClienteController@DT_salesByCustomer');
            Route::get('DT_devolutionsByCustomer' , 'ClienteController@DT_devolutionsByCustomer');
            Route::get('creditSalesByCustomer'    , 'ClienteController@creditSalesByCustomer');
            Route::get('getInfoCliente'           , 'ClienteController@getInfoCliente');
            Route::get('getHistorialAbonos'       , 'ClienteController@getHistorialAbonos');
            Route::get('getHistorialPagos'        , 'ClienteController@getHistorialPagos');
            Route::get('clientes'                 , 'ClienteController@clientes');
            Route::post('crearCliente'            , 'ClienteController@crearCliente');
            Route::post('actualizarCliente'       , 'ClienteController@actualizarCliente');
            Route::post('eliminarCliente'         , 'ClienteController@eliminarCliente');
            Route::get('estadoDeCuenta'           , 'ClienteController@estadoDeCuenta');
            Route::post('enviarEstadoDeCuenta'    , 'ClienteController@enviarEstadoDeCuenta');
        });

        Route::group(array('prefix' => 'soporte'), function()
        {
            Route::get('create'                 , 'SoporteController@create');
            Route::post('delete'                , 'SoporteController@delete');
            Route::post('create'                , 'SoporteController@create');
            Route::post('delete_detail'         , 'SoporteController@delete_detail');
            Route::post('delete_master'         , 'SoporteController@delete_master');
        });

        Route::group(array('prefix' => 'gastos'), function()
        {
            Route::get('create'                    , 'App\gastos\GastoController@create');
            Route::post('save'                     , 'App\gastos\GastoController@save');
            // Route::get('create'                    , 'GastoController@create');
            Route::post('delete'                   , 'App\gastos\GastoController@delete');
            // Route::post('delete'                   , 'GastoController@delete');
            Route::post('create'                   , 'GastoController@create');
            Route::post('delete_detail'            , 'GastoController@delete_detail');
            Route::post('delete_master'            , 'GastoController@delete_master');
        });

        Route::group(array('prefix' => 'egresos'), function()
        {
            Route::get('create'                      , 'EgresoController@create');
            Route::post('delete'                     , 'EgresoController@delete');
            Route::post('create'                     , 'EgresoController@create');
            Route::post('delete_detail'              , 'EgresoController@delete_detail');
            Route::post('delete_master'              , 'EgresoController@delete_master');
        });

        Route::group(array('prefix' => 'ingresos'), function()
        {
            Route::get('create'                , 'IngresoController@create');
            Route::post('delete'               , 'IngresoController@delete');
            Route::post('create'               , 'IngresoController@create');
            Route::post('delete_detail'        , 'IngresoController@delete_detail');
            Route::post('delete_master'        , 'IngresoController@delete_master');
        });

        Route::group(array('prefix' => 'adelantos'), function()
        {
            Route::post('create'                 , 'AdelantoController@create' );
            Route::post('detalle'                , 'AdelantoController@detalle');
            Route::post('removeItemAdelanto'     , 'AdelantoController@removeItemAdelanto' );
            Route::post('updateClienteId'        , 'AdelantoController@updateClienteId' );
            Route::get('ingresarProductoRapido'  , 'AdelantoController@ingresarProductoRapido' );
            Route::post('ingresarProductoRapido' , 'AdelantoController@ingresarProductoRapido' );
            Route::post('EliminarAdelanto'       , 'AdelantoController@EliminarAdelanto' );
            Route::get('getDetalleAdelantos'     , 'AdelantoController@getDetalleAdelantos' );
            Route::get('getAdelantos'            , 'AdelantoController@getAdelantos' );
            Route::get('DTadelantos'             , 'AdelantoController@DTadelantos' );
            Route::get('comprobante'             , 'AdelantoController@comprobante' );
        });

        Route::group(array('prefix' => 'productos'), function()
        {
            Route::get('/'                 , 'ProductoController@index');
            Route::post('find'             , 'ProductoController@find');
            Route::get('md_search'         , 'ProductoController@md_search');
            Route::get('md_search_dt'      , 'ProductoController@md_search_dt');
            Route::get('user_inventario_dt', 'ProductoController@user_inventario_dt');
            Route::get('getInventario'     , 'ProductoController@getInventario');
            Route::get('getProveedorProductoDetalle', 'ProductoController@getProveedorProductoDetalle');
            
        });

        Route::group(array('prefix' => 'ventas'), function()
        {
            Route::get('create'                               , 'App\ventas\VentasController@create');
            Route::post('create'                              , 'App\ventas\VentasController@create');
            Route::get('findProducto'                         , 'App\ventas\VentasController@findProducto');
            Route::get('table_productos_para_venta'           , 'App\ventas\VentasController@table_productos_para_venta');
            Route::get('table_productos_para_venta_DT'        , 'App\ventas\VentasController@table_productos_para_venta_DT');
            Route::post('postVentaDetalle'                    , 'App\ventas\VentasController@postVentaDetalle');
            Route::get('getSerialsForm'                       , 'App\ventas\VentasController@getSerialsForm');
            Route::post('detalle_venta_serie_add'             , 'App\ventas\VentasController@detalle_venta_serie_add');
            Route::post('detalle_venta_serie_delete'          , 'App\ventas\VentasController@detalle_venta_serie_delete');
            Route::post('eliminarVenta'                       , 'App\ventas\VentasController@eliminarVenta');
            Route::post('removeItem'                          , 'App\ventas\VentasController@removeItem');
            Route::post('UpdateDetalle'                       , 'App\ventas\VentasController@UpdateDetalle');
            Route::get('paymentForm'                          , 'App\ventas\VentasController@paymentForm');
            Route::post('endSale'                             , 'App\ventas\VentasController@endSale');
            Route::get('openSale'                             , 'App\ventas\VentasController@openSale');
            Route::get('notasDeCredito'                       , 'App\ventas\VentasController@notasDeCredito');
            Route::post('enviarACaja'                         , 'App\ventas\VentasController@enviarACaja');

            Route::post('detalle'                             , 'VentasController@detalle');
            Route::post('updateClienteId'                     , 'VentasController@updateClienteId');
            Route::post('RemoveSale'                          , 'VentasController@RemoveSale');
            Route::post('RemoveSaleItem'                      , 'VentasController@RemoveSaleItem');
            Route::get('ModalSalesPayments'                   , 'VentasController@ModalSalesPayments');
            Route::post('ModalSalesPayments'                  , 'VentasController@ModalSalesPayments');
            Route::post('RemoveSalePayment'                   , 'VentasController@RemoveSalePayment');
            Route::post('FinalizeSale'                        , 'VentasController@FinalizeSale');
            Route::get('OpenModalSalesPayments'               , 'VentasController@OpenModalSalesPayments');
            Route::get('showSalesDetail'                      , 'VentasController@showSalesDetail');
            Route::get('getCreditSales'                       , 'VentasController@getCreditSales');
            Route::get('getModalImprimirVenta'                , 'VentasController@getModalImprimirVenta'  );
            Route::get('printInvoice'                         , 'VentasController@printInvoice'  );
            Route::post('enviarVentaACaja'                    , 'VentasController@enviarVentaACaja'  );
            Route::get('imprimirFactura'                      , 'VentasController@imprimirFactura'  ); // for test
            Route::get('getVentasPedientesDePago'             , 'VentasController@getVentasPedientesDePago');
            Route::get('getVentasPendientesPorCliente'        , 'VentasController@getVentasPendientesPorCliente' );
            Route::get('getVentaConDetalle'                   , 'VentasController@getVentaConDetalle');
            Route::get('getVentasPorHoraPorUsuario'           , 'VentasController@getVentasPorHoraPorUsuario');
            Route::get('getDetalleVentasPorHoraUsuario'       , 'VentasController@getDetalleVentasPorHoraUsuario');
            Route::post('ingresarSeriesDetalleVenta'          , 'VentasController@ingresarSeriesDetalleVenta');
            Route::get('getVentasPedientesPorUsuario'         , 'VentasController@getVentasPedientesPorUsuario');
            Route::get('getDetalleVentasPendientesPorUsuario' , 'VentasController@getDetalleVentasPendientesPorUsuario');
            Route::post('pagoConNotasDeCredito'               , 'VentasController@pagoConNotasDeCredito');
            Route::get('getActualizarPagosVentaFinalizada'    , 'VentasController@getActualizarPagosVentaFinalizada');
            Route::post('actualizarPagosVentaFinalizada'      , 'VentasController@actualizarPagosVentaFinalizada');
            Route::get('getSumaDeVentasPorCliente'            , 'VentasController@getSumaDeVentasPorCliente');
            // Muestra resumen de los 100 mejores clientes
            Route::get('exportarSumaDeVentasPorCliente'       , 'ExportarController@exportarSumaDeVentasPorCliente');

            Route::group(array('prefix' => 'payments'),function()
            {
                Route::get('formPayments'           , 'SalesPaymentsController@formPayments');
                Route::post('formPayments'          , 'SalesPaymentsController@formPayments');
                Route::get('formPaymentsPagination' , 'SalesPaymentsController@formPaymentsPagination');
                Route::post('eliminarAbonoVenta'    , 'SalesPaymentsController@eliminarAbonoVenta');
                Route::post('SelectedPaySales'      , 'SalesPaymentsController@SelectedPaySales');
                Route::get('getDetalleAbono'        , 'SalesPaymentsController@getDetalleAbono');
            });

            Route::group(array('prefix' => 'devoluciones'),function()
            {
                Route::get('createDevolucion'       , 'DevolucionesVentasController@createDevolucion');
                Route::post('createDevolucion'      , 'DevolucionesVentasController@createDevolucion');
                Route::get('findProducto'           , 'DevolucionesVentasController@findProducto');
                Route::post('postDevolucionDetalle' , 'DevolucionesVentasController@postDevolucionDetalle');
                Route::post('removeItem'            , 'DevolucionesVentasController@removeItem');
                Route::post('eliminarDevolucion'    , 'DevolucionesVentasController@eliminarDevolucion');
                Route::post('UpdateDetalle'         , 'DevolucionesVentasController@UpdateDetalle');
                Route::get('getPaymentForm'         , 'DevolucionesVentasController@getPaymentForm');
                Route::post('finalizarDevolucion'       , 'DevolucionesVentasController@finalizarDevolucion');
                Route::get('getVentasParaDevoluciones'  , 'DevolucionesVentasController@getVentasParaDevoluciones');
                Route::get('DT_ventasParaDevoluciones'  , 'DevolucionesVentasController@DT_ventasParaDevoluciones');
                Route::get('misDevolucionesDelDia'      , 'DevolucionesVentasController@misDevolucionesDelDia');
                Route::get('devoluciones_DT'            , 'DevolucionesVentasController@devoluciones_DT');
                Route::get('getDevolucionesDetail'      , 'DevolucionesVentasController@getDevolucionesDetail');
                Route::get('openDevolucion'             , 'DevolucionesVentasController@openDevolucion');
                Route::post('deleteDevolucion'          , 'DevolucionesVentasController@deleteDevolucion');
                Route::get('getSerialsForm'             , 'DevolucionesVentasController@getSerialsForm');
                Route::post('post_detalle_devolulcion_serie'        , 'DevolucionesVentasController@post_detalle_devolulcion_serie');
                Route::post('post_detalle_devolulcion_serie_delete' , 'DevolucionesVentasController@post_detalle_devolulcion_serie_delete');
                Route::get('table_productos_para_devolucion'        , 'DevolucionesVentasController@table_productos_para_devolucion');
                Route::get('productos_para_devolucion_DT'           , 'DevolucionesVentasController@productos_para_devolucion_DT');
            });

        });

        Route::group(array('prefix' => 'cotizaciones'),function()
        {
            Route::get('create'                     , 'CotizacionController@create' );
            Route::post('create'                    , 'CotizacionController@create' );
            Route::post('detalle'                   , 'CotizacionController@detalle');
            Route::post('removeItemCotizacion'      , 'CotizacionController@removeItemCotizacion' );
            Route::post('updateClienteId'           , 'CotizacionController@updateClienteId' );
            Route::get('ingresarProductoRapido'     , 'CotizacionController@ingresarProductoRapido' );
            Route::post('ingresarProductoRapido'    , 'CotizacionController@ingresarProductoRapido' );
            Route::post('EliminarCotizacion'        , 'CotizacionController@EliminarCotizacion' );
            Route::get('getCotizaciones'            , 'CotizacionController@getCotizaciones' );
            Route::get('getMisCotizaciones'         , 'CotizacionController@getMisCotizaciones' );
            Route::get('DtCotizaciones'             , 'CotizacionController@DtCotizaciones' );
            Route::get('DtMisCotizaciones'          , 'CotizacionController@DtMisCotizaciones' );
            Route::get('getDetalleCotizacion'       , 'CotizacionController@getDetalleCotizacion' );
            Route::get('EditarCotizacion'           , 'CotizacionController@EditarCotizacion' );
            Route::post('UpdateDetalle'             , 'CotizacionController@UpdateDetalle' );
            Route::post('convertirCotizacionAVenta' , 'CotizacionController@convertirCotizacionAVenta' );
        });

        Route::group(array('prefix' => 'cajas'),function()
        {
            Route::get('asignar'               , 'CajaController@asignar');
            Route::post('asignar'              , 'CajaController@asignar');
            Route::post('getMovimientosDeCaja' , 'CajaController@getMovimientosDeCaja');
            Route::get('corteDeCaja'           , 'CajaController@corteDeCaja');
            Route::post('corteDeCaja'          , 'CajaController@corteDeCaja');
            Route::get('retirarEfectivoDeCaja' , 'CajaController@retirarEfectivoDeCaja');
            Route::get('ConsultasPorMetodoDePago/{model}' ,'ConsultasCajaController@ConsultasPorMetodoDePago');
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
        Route::group(array('prefix' => 'informeGeneral'), function()
        {
            Route::get('getTableInformeGeneral', 'InformeGeneralController@getTableInformeGeneral');
            Route::get('tableInformeGeneral_DT', 'InformeGeneralController@tableInformeGeneral_DT');
            Route::get('getInformeInversion'   , 'InformeGeneralController@getInformeInversion');
            Route::get('getInformeCuentasPorPagar'   , 'InformeGeneralController@getInformeCuentasPorPagar');
            Route::get('getInformeCuentasPorCobrar'   , 'InformeGeneralController@getInformeCuentasPorCobrar');
        });


        Route::post('notaDeCredito/eliminarNotaDeCredito', 'NotaCreditoController@eliminarNotaDeCredito');
        Route::get('users/buscar', 'UserController@buscar');

        Route::group(array('prefix' => 'vista'),function()
        {
            Route::post('cambiarVistaPuntoDeVenta'   , 'VistaController@cambiarVistaPuntoDeVenta');//limpiar
            Route::post('cambiarVistaAdministardor'  , 'VistaController@cambiarVistaAdministardor');
            Route::post('cambiarVistaPropietario'    , 'VistaController@cambiarVistaPropietario');
        });

        Route::group(array('prefix' => 'cajas'),function()
        {
            Route::get('create'                  , 'CajaController@create');
            Route::post('create'                 , 'CajaController@create');
            Route::post('edit'                   , 'CajaController@edit');
            Route::get('asignar'                 , 'CajaController@asignar');
            Route::get('asignarDt'               , 'CajaController@asignarDt');//limpiar
            Route::post('desAsignarDt'           , 'CajaController@desAsignarDt');//limpiar
            Route::post('asignar'                , 'CajaController@asignar');
            Route::post('asignarDt'              , 'CajaController@asignarDt');
            Route::get('getConsultarCajas'       , 'CajaController@getConsultarCajas');
            Route::get('DtConsultarCajas'        , 'CajaController@DtConsultarCajas' );

            // se encuentra en el menu de admin->cierre->corted de caja
            Route::get('cortesDeCajaPorDia'      , 'CajaController@cortesDeCajaPorDia');
            Route::get('DtCortesDeCajasPorDia'   , 'CajaController@DtCortesDeCajasPorDia');
            // se ejecuta desde datatables cortesDeCajaPorDia para ver el detalle de corte de la caja seleccionada
            Route::post('getMovimientosDeCajaDt' , 'CajaController@getMovimientosDeCajaDt');

            // se encuentra en el menu de admin->cierre->movimientos de cajas2
            Route::get('resumenDeActividadActualDeCajas' , 'CajaController@resumenDeActividadActualDeCajas');

        });

        Route::group(array('prefix' => 'kardex'),function()
        {
            Route::get('getKardexPorFecha/{consulta}' , 'KardexController@getKardexPorFecha');
            Route::get('DtKardexPorFecha/{consulta}'  , 'KardexController@DtKardexPorFecha');
            Route::get('exportarKardex/{tipo}'        , 'KardexController@exportarKardex');
        });


        Route::group(array('prefix' => 'exportar'),function()
        {
            Route::get('exportarEstadoDeCuentaDeClientes/{tipo}'   , 'ExportarController@exportarEstadoDeCuentaDeClientes');
            Route::get('exportarEstadoDeCuentaPorCliente/{tipo}'   , 'ExportarController@exportarEstadoDeCuentaPorCliente');
            Route::get('exportarVentasPendientesPorUsuario/{tipo}' , 'ExportarController@exportarVentasPendientesPorUsuario');
            Route::get('exportarVentasPendientesDeUsuarios/{tipo}' , 'ExportarController@exportarVentasPendientesDeUsuarios');
            Route::get('exportarInventarioActual/{tipo}'           , 'ExportarController@exportarInventarioActual');
        });


        Route::group(array('prefix' => 'configuracion'),function()
        {
            Route::get('impresora'              , 'ConfiguracionController@impresora');
            Route::get('notificacion'           , 'ConfiguracionController@notificacion');
            Route::post('notificacion'          , 'ConfiguracionController@notificacion');
            Route::post('eliminarNotificacion'  , 'ConfiguracionController@eliminarNotificacion');
            Route::post('impresora'             , 'ConfiguracionController@saveImpresora');
            Route::get('getImpresoras/{im}'     , 'ConfiguracionController@getImpresoras');
        });

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
            Route::get('getNotasDeCreditoPorFecha/{consulta}'    , 'QueriesController@getNotasDeCreditoPorFecha' );
            Route::get('DtNotasDeCreditoPorFecha/{consulta}'     , 'QueriesController@DtNotasDeCreditoPorFecha'  );
            Route::get('getIngresosPorFecha/{consulta}'          , 'QueriesController@getIngresosPorFecha'  );
            Route::get('DtIngresosPorFecha/{consulta}'           , 'QueriesController@DtIngresosPorFecha'   );

            Route::group(array('prefix' => 'devoluciones'),function()
            {
                Route::get('/', 'DevolucionesVentasController@devoluciones');
            });
        });

        Route::group(array('prefix' => 'cierre'),function()
        {
            Route::get('CierreDelDia'                        , 'CierreController@CierreDelDia' );
            Route::get('getCierreDelDia'                     , 'CierreController@getCierreDelDia' );// desde las Graficas
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
            Route::get('ExportarCierreDelMes/{tipo}/{fecha}' , 'ExportarController@ExportarCierreDelMes' );
            Route::get('VentasDelMes'                        , 'CierreController@VentasDelMes' );
            Route::get('VentasDelMes_dt'                     , 'CierreController@VentasDelMes_dt' );
            Route::get('SoportePorFecha'                     , 'CierreController@SoportePorFecha' );
            Route::get('SoportePorFecha_dt'                  , 'CierreController@SoportePorFecha_dt' );
            Route::get('GastosPorFecha'                      , 'CierreController@GastosPorFecha' );
            Route::get('GastosPorFecha_dt'                   , 'CierreController@GastosPorFecha_dt' );
            Route::get('DetalleDeVentasPorProducto'          , 'CierreController@DetalleDeVentasPorProducto' );
            Route::get('DetalleVentaCierre'                  , 'CierreController@DetalleVentaCierre' );
            Route::group(array('prefix' => 'consultas'),function()
            {
                Route::get('ConsultasPorMetodoDePago/{model}' , 'ConsultasCierreController@ConsultasPorMetodoDePago');
                Route::get('getVentasDelMesPorUsuario'        , 'ConsultasCierreController@getVentasDelMesPorUsuario');
                Route::get('DtVentasDelMesPorUsuario'         , 'ConsultasCierreController@DTVentasDelMesPorUsuario');
            });
        });

        Route::group(array('prefix' => 'barcode'),function()
        {
            Route::get('create'      , 'BarCodeController@create');
            Route::post('create'     , 'BarCodeController@create');
            Route::post('print_code' , 'BarCodeController@print_code');
        });


        Route::group(array('prefix' => 'inventario'), function()
        {
            Route::get('/'                , 'InventarioController@getInventario' );
            Route::get('dt_getInventario ' , 'InventarioController@dt_getInventario' );
            Route::post('setExistencia'   , 'InventarioController@setExistencia' );
            Route::get('getStockMinimo'  , 'InventarioController@getStockMinimo' );
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
            Route::get('_create'                     , 'ProveedorController@_create');
            Route::get('help'                        , 'ProveedorController@help'  );
            Route::post('edit'                       , 'ProveedorController@edit'  );
            Route::post('_edit'                      , 'ProveedorController@_edit'  );
            Route::post('create'                     , 'ProveedorController@create');
            Route::post('_create'                    , 'ProveedorController@_create');
            Route::post('delete'                     , 'ProveedorController@delete');
            Route::post('contacto_create'            , 'ProveedorController@contacto_create');
            Route::post('contacto_delete'            , 'ProveedorController@contacto_delete');
            Route::get('contacto_nuevo'              , 'ProveedorController@contacto_nuevo' );
            Route::post('contacto_update'            , 'ProveedorController@contacto_update');
            Route::post('contacto_info'              , 'ProveedorController@contacto_info'  );
            Route::post('total_credito'              , 'ProveedorController@TotalCredito'   );
            Route::get('ShowModalPaySupplier'        , 'ProveedorController@ShowModalPaySupplier'  );
            Route::get('proveedores'                 , 'ProveedorController@proveedores' );
            Route::get('getInfoProveedor'            , 'ProveedorController@getInfoProveedor');
            Route::post('crearProveedor'             , 'ProveedorController@create');
            Route::post('actualizarProveedor'        , 'ProveedorController@edit');
            Route::post('eliminarProveedor'          , 'ProveedorController@delete');
            Route::get('estadoDeCuenta'              , 'ProveedorController@estadoDeCuenta');
        });


        Route::group(array('prefix' => 'compras'), function()
        {
            Route::get('create'                             , 'CompraController@create' );
            Route::post('create'                            , 'CompraController@create' );
            Route::get('detalle'                            , 'CompraController@detalle');
            Route::post('detalle'                           , 'CompraController@detalle');
            Route::post('verfactura'                        , 'CompraController@AbrirCompraNoCompletada');
            Route::get('ModalPurchasePayment '              , 'CompraController@ModalPurchasePayment'  );
            Route::post('ModalPurchasePayment'              , 'CompraController@ModalPurchasePayment'  );
            Route::post('DeletePurchaseInitial'             , 'CompraController@DeletePurchaseInitial' );
            Route::get('OpenModalPurchaseItemSerials'       , 'CompraController@OpenModalPurchaseItemSerials' );
            Route::get('OpenModalPurchaseInfo'              , 'CompraController@OpenModalPurchaseInfo');
            Route::post('OpenModalPurchaseInfo'             , 'CompraController@OpenModalPurchaseInfo');
            Route::post('DeletePurchaseShipping'            , 'CompraController@DeletePurchaseShipping'   );
            Route::post('FinishInitialPurchase'             , 'CompraController@FinishInitialPurchase');
            Route::post('SaveEditPurchaseItemDetails'       , "CompraController@SaveEditPurchaseItemDetails" );
            Route::post('DeletePurchaseDetailsItem'         , 'CompraController@DeletePurchaseDetailsItem' );
            Route::post('DeletePurchasePaymentItem'         , 'CompraController@DeletePurchasePaymentItem'   );
            Route::get('ConsultPurchase'                    , 'CompraController@ConsultPurchase');
            Route::get('ShowTableUnpaidShopping'            , 'CompraController@ShowTableUnpaidShopping');
            Route::get('ShowTableHistoryPayment'            , 'CompraController@ShowTableHistoryPayment');
            Route::get('ShowTableHistoryPaymentDetails'     , 'CompraController@ShowTableHistoryPaymentDetails');
            Route::get('showPurchaseDetail'                 , 'CompraController@showPurchaseDetail');
            Route::get('showPaymentsDetail'                 , 'CompraController@showPaymentsDetail');
            Route::get('Purchase_dt'                        , 'CompraController@Purchase_dt');
            Route::get('PurchaseUnpaid_dt'                  , 'CompraController@PurchaseUnpaid_dt');
            Route::get('ComprasPendientesDePago'            , 'CompraController@ComprasPendientesDePago');
            Route::get('HistorialDePagos'                   , 'CompraController@HistorialDePagos');
            Route::get('HistorialDeAbonos'                  , 'CompraController@HistorialDeAbonos');
            Route::get('getCreditPurchase'                  , 'CompraController@getCreditPurchase');
            Route::get('getComprasPedientesDePago'          , 'CompraController@getComprasPedientesDePago');
            Route::get('getComprasPendientesPorProveedor'   , 'CompraController@getComprasPendientesPorProveedor');
            Route::get('getCompraConDetalle'                , 'CompraController@getCompraConDetalle');
            Route::post('ingresarSeriesDetalleCompra'       , 'CompraController@ingresarSeriesDetalleCompra');
            Route::get('getActualizarDetalleCompra'         , 'CompraController@getActualizarDetalleCompra');
            Route::get('getActualizarPagosCompraFinalizada' , 'CompraController@getActualizarPagosCompraFinalizada');
            Route::post('actualizarPagosCompraFinalizada'   , 'CompraController@actualizarPagosCompraFinalizada');

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

        Route::group(array('prefix' => 'kits'), function()
        {
            Route::get('create', 'App\kits\KitsController@create');
            Route::post('create', 'App\kits\KitsController@create');
            Route::get('table_productos', 'App\kits\KitsController@table_productos');
            Route::post('crearProducto', 'App\kits\KitsController@crearProducto');
            Route::post('deleteKit', 'App\kits\KitsController@deleteKit');
            Route::post('postKitDetalle', 'App\kits\KitsController@postKitDetalle');
            Route::post('removeItem', 'App\kits\KitsController@removeItem');
            Route::post('kits', 'App\kits\KitsController@kits');
            Route::get('historial_kits', 'App\kits\KitsController@historial_kits');
            Route::get('historial_kits_DT', 'App\kits\KitsController@historial_kits_DT');
            Route::get('getDetalle', 'App\kits\KitsController@getDetalle');
            Route::get('open_kit_no_finalizado', 'App\kits\KitsController@open_kit_no_finalizado');
            Route::get('findProducto', 'App\kits\KitsController@findProducto');
            Route::post('endKit', 'App\kits\KitsController@endKit');
            Route::post('updateCantidad', 'App\kits\KitsController@updateCantidad');
        });

        Route::group(array('prefix' => 'descargas'), function()
        {
            Route::get('create'                             , 'DescargaController@create' );
            Route::post('create'                            , 'DescargaController@create' );
            Route::post('edit'                              , 'DescargaController@edit'   );
            Route::get('edit'                               , 'DescargaController@edit'   );
            Route::post('eliminar_detalle'                  , 'DescargaController@eliminar_detalle'   );
            Route::post('delete'                            , 'DescargaController@delete'   );
            Route::get('OpenTableDownloadsDay'              , 'DescargaController@OpenTableDownloadsDay' );
            Route::get('DownloadsDay_dt'                    , 'DescargaController@DownloadsDay_dt'  );
            Route::get('showgDownloadsDetail'               , 'DescargaController@showgDownloadsDetail'  );
            Route::get('OpenDownload'                       , 'DescargaController@OpenDownload'  );
            Route::get('OpenTableDownloadsForDate'          , 'DescargaController@OpenTableDownloadsForDate' );
            Route::get('DownloadsForDate'                   , 'DescargaController@DownloadsForDate' );
            Route::get('descripcion'                        , 'DescargaController@descripcion' );
            Route::post('descripcion'                       , 'DescargaController@descripcion' );
            Route::post('ingresarSeriesDetalleDescarga'     , 'DescargaController@ingresarSeriesDetalleDescarga');
            Route::post('finalizarDescarga'                 , 'DescargaController@finalizarDescarga');
        });

        Route::group(array('prefix' => 'traslados'),function()
        {
            Route::get('buscarTienda'                   , 'TrasladoController@buscarTienda');
            Route::get('create'                         , 'TrasladoController@create' );
            Route::post('create'                        , 'TrasladoController@create');
            Route::post('edit'                          , 'TrasladoController@edit');
            Route::get('edit'                           , 'TrasladoController@edit');
            Route::post('detalle'                       , 'TrasladoController@detalle');
            Route::post('eliminar_detalle'              , 'TrasladoController@eliminar_detalle');
            Route::post('eliminarTraslado'              , 'TrasladoController@eliminarTraslado');
            Route::post('abrirTraslado'                 , 'TrasladoController@abrirTraslado');
            Route::post('finalizarTraslado'             , 'TrasladoController@finalizarTraslado');
            Route::post('recibirTraslado'               , 'TrasladoController@recibirTraslado');
            Route::get('getDetalleTraslado'             , 'TrasladoController@getDetalleTraslado');
            Route::post('abrirTrasladoDeRecibido'       , 'TrasladoController@abrirTrasladoDeRecibido');
            Route::post('ingresarSeriesDetalleTraslado' , 'TrasladoController@ingresarSeriesDetalleTraslado');
            Route::get('getTrasladosEnviados'           , 'TrasladoController@getTrasladosEnviados');
            Route::get('getTrasladosRecibidos'          , 'TrasladoController@getTrasladosRecibidos');
            Route::get('getTrasladosEnviados_dt'        , 'TrasladoController@getTrasladosEnviados_dt');
            Route::get('getTrasladosRecibidos_dt'       , 'TrasladoController@getTrasladosRecibidos_dt');
        });

        Route::group(array('prefix' => 'categorias'), function()
        {
            Route::get('create' , 'CategoriaController@create' );
            Route::post('create', 'CategoriaController@create' );
            Route::post('edit'  , 'CategoriaController@edit'   );
            Route::get('edit'   , 'CategoriaController@edit'   );
            Route::get('buscar' , 'CategoriaController@buscar' );
        });

        Route::group(array('prefix' => 'marcas'), function()
        {
            Route::get('create' , 'MarcaController@create');
            Route::post('create', 'MarcaController@create');
            Route::post('edit'  , 'MarcaController@edit'  );
            Route::get('edit'   , 'MarcaController@edit'  );
            Route::get('buscar' , 'MarcaController@buscar'  );
        });

        Route::group(array('prefix' => 'sub_categorias'), function()
        {
            Route::get('create' , 'SubCategoriaController@create');
            Route::post('create', 'SubCategoriaController@create');
            Route::get('filtro' , 'SubCategoriaController@filter_select');
            Route::post('edit'  , 'SubCategoriaController@edit'  );
            Route::get('edit'   , 'SubCategoriaController@edit');
            Route::get('buscar/{cat}' , 'SubCategoriaController@buscar');
        });

        Route::group(array('prefix' => 'chart'), function()
        {
            Route::get('ComprasPorProveedor', 'ChartController@ComprasPorProveedor');
            Route::get('ComparativaPorMesPorProveedor', 'ChartController@ComparativaPorMesPorProveedor');
            Route::get('comprasMensualesPorAnoPorProveedor', 'App\graphics\Compras@comprasMensualesPorAnoPorProveedor');
            Route::get('comprasDiariasPorMesProveedor', 'App\graphics\Compras@comprasDiariasPorMesProveedor');
            Route::get('comparativaPorMesPorProveedorPrevOrNext', 'ChartController@comparativaPorMesPorProveedorPrevOrNext');
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
            Route::get('comparativaMensual' , 'ChartController@comparativaMensual' );
            Route::get('proyeccionMensual' , 'ChartController@proyeccionMensual' );
            Route::get('getComparativaMensualPorMes' , 'ChartController@getComparativaMensualPorMes' );
            Route::get('getConsultaPorCriterio' , 'ChartController@getConsultaPorCriterio' );

            Route::group(array('prefix' => 'ventas'), function()
            {
                Route::get('ventasMensualesPorAno' , 'App\graphics\Ventas@ventasMensualesPorAno');
                Route::get('ventasDiariasPorMes' , 'App\graphics\Ventas@ventasDiariasPorMes');
                Route::get('ventasDelDiaPorHora' , 'App\graphics\Ventas@ventasDelDiaPorHora');
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

    Route::get('/informeGeneral/actual', function()
    {
        return View::make('informes.detalleInformeGeneral');
    });

    Route::get('/test', function()
    {
        $producto = Producto::find('1006167');

        return json_encode($producto);

        $number  = 4;
        $number *= 2;
        $number -= 2;
        $number /= 2;

        // return $number;

        $numbers = " 2,  3,5  ,1000,4 ";

        $numbers = trim($numbers);

        // $b = trim(" testing ", " teng"); // quita de la 1er var los caracteres de la 2da var
        // $numbers = explode(',', $numbers); // para convertir el string en array
        // $numbers = preg_split('/,/', $numbers); // hace lo mismo que el anterior
        // trim($numbers);

        $numbers = preg_split('/\s*,\s*/', $numbers); // string to array y quita los espacios en blanco pero no al prin y al fin

        var_dump($numbers);

        $sum = 0;

        foreach ($numbers as $number) {
            if ($number < 0) throw new InvalidArgumentException("Invalid number provided: {$number}");

            if ($number >= 1000) continue;
            $sum += $number;
        }

        // return array_sum($numbers);

        $a = 3;

        $a == 3 ? $a = 1 : $a = 2;

        // return $a;

        $producto = Producto::with('marca')->whereId(1003215)->first();

        if($producto) {
            return [
                'success' => true,
                'values'  => [
                    'id'             => $producto->id,
                    'descripcion'    => $producto->descripcion . PHP_EOL . $producto->marca->nombre,
                    'precio_publico' => $producto->p_publico,
                    'precio_costo'   => $producto->p_costo,
                    'existencia'     => $producto->existencia
                ]
            ];
        }
    });

    Route::get('logs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

    Route::get('clearcached',  function(){
        $url = 'http://localhost:4000/cached';
        App::make('http_cache.store')->purge($url);

        return 1;

    });

    Route::get('cached', array('after' => 'cache:30', function() {
        $query =  DetalleVenta::where('id', '>=', 1)->take(25000)->get();

        $total = 0;
        foreach ($query as $q) {
            $total = $total + ($q->cantidad * $q->precio);
        }

        return $total;
    }));

    /*
    Route::get('timetest', function()
    {
        $start = date('Y/m/d H:i:s');
        $start = round(microtime(true) * 1000);

        $cliente = Autocomplete::get('clientes', array('id', 'nombre', 'apellido'));

        $end = date('Y/m/d H:i:s');
        $end = round(microtime(true) * 1000);

        return $end -$start;
    });
    */

    Route::get('clear', function()
    {
        $ventas = DB::table('ventas')->take(40000)->skip(0)->get(array('id'));

        $contador = 0;

        foreach ($ventas as $key => $v) {
            $dt = DetalleVenta::whereVentaId($v->id)->get(array('id'));

            if (!count($dt)) {
               $contador++;
               Venta::find($v->id)->delete();
            }
        }

        return $contador;
    });


Route::get('exercise', function() {

    function welcome(array $names) {

        return $names;

    }

    $array = ['Dayle', 'James', 'Andrea', 'Ben', 'Mateusz'];

    return welcome($array);

});
