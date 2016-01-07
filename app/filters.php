<?php

Route::filter('cache', function($route, $request, $response, $age=60){
    $response->setTtl($age);
});


Route::filter('auth', function()
{
    if (!Auth::check())
    {
        if (Request::ajax())
        {
            return Response::json('Su sesion a expirado favor logearse de nuevo', 401);
        }
        else
        {
            return Redirect::to('logIn');
        }
    }
});


Route::filter('csrf', function()
{
	if (Input::has('_token')) {
		if (Session::token() != Input::get('_token'))
		{
			throw new Illuminate\Session\TokenMismatchException;
		}
	}
});


/*
    ========================================
    |   Modelo       |kardex_transaccion_id|
    ========================================
    |    compras     |       1             |
	|    ventas      |       2             |
    |    descargas   |       3             |
	|    traslados   |       4             |
	|    devolucion  |       5             |
	|    ajuste      |       6             |
    ========================================
*/


/*************************************************************************
    INICIO DE EVENTOS PARA KARDEX
*************************************************************************/
Event::listen('eloquent.updated: Compra', function(Compra $model){
    if ($model->completed == 1 && $model->kardex == 0)
    {
        $compra = Compra::find($model->id);
        $compra->kardex = 1 ;
        $compra->save();

        $detalleCompra = DetalleCompra::with('producto')->where('compra_id',$model->id)->get();

        foreach ($detalleCompra as $dt)
        {
            $existencia = Existencia::whereProductoId($dt->producto_id)->first(array(DB::raw('sum(existencia) as total')));
            $exisntencia_tienda = Existencia::whereProductoId($dt->producto_id)->whereTiendaId(Auth::user()->tienda_id)->first();

            $kardex = new Kardex;
            $kardex->tienda_id = Auth::user()->tienda_id;
            $kardex->user_id = Auth::user()->id;
            $kardex->kardex_accion_id = 2;
            $kardex->producto_id = $dt->producto_id;
            $kardex->kardex_transaccion_id = 1;
            $kardex->transaccion_id = $dt->compra_id;
            $kardex->evento = 'ingreso';
            $kardex->cantidad = $dt->cantidad;
            $kardex->existencia = $existencia->total;
            $kardex->exisntencia_tienda = $exisntencia_tienda->existencia;
            $kardex->exisntencia_tienda = $exisntencia_tienda->existencia;
            $kardex->costo = $dt->precio;
            $kardex->costo_promedio = ($dt->producto->p_costo/100);
            $kardex->save();
        }
    }
});

Event::listen('eloquent.updated: Venta', function(Venta $model){
    if ($model->completed == 1 && $model->kardex == 0)
    {
        $venta = Venta::find($model->id);
        $venta->kardex = 1 ;
        $venta->save();

        $detalleVenta = DetalleVenta::with('producto')->where('venta_id',$model->id)->get();

        foreach ($detalleVenta as $dt)
        {
            $existencia = Existencia::whereProductoId($dt->producto_id)->first(array(DB::raw('sum(existencia) as total')));
            $exisntencia_tienda = Existencia::whereProductoId($dt->producto_id)->whereTiendaId(Auth::user()->tienda_id)->first();

            $kardex = new Kardex;
            $kardex->tienda_id = Auth::user()->tienda_id;
            $kardex->user_id = Auth::user()->id;
            $kardex->kardex_accion_id = 2;
            $kardex->producto_id = $dt->producto_id;
            $kardex->kardex_transaccion_id = 2;
            $kardex->transaccion_id = $dt->venta_id;
            $kardex->evento = 'salida';
            $kardex->cantidad = $dt->cantidad;
            $kardex->existencia = $existencia->total;
            $kardex->exisntencia_tienda = $exisntencia_tienda->existencia;
            $kardex->costo = ($dt->producto->p_costo/100);
            $kardex->costo_promedio = ($dt->producto->p_costo/100);
            $kardex->save();
        }
    }
});

Event::listen('eloquent.updated: Descarga', function(Descarga $model){
    if ($model->status == 1 && $model->kardex == 0)
    {
        $venta = Descarga::find($model->id);
        $venta->kardex = 1 ;
        $venta->save();

        $detalleDescarga = DetalleDescarga::with('producto')->where('descarga_id',$model->id)->get();

        foreach ($detalleDescarga as $dt)
        {
            $existencia = Existencia::whereProductoId($dt->producto_id)->first(array(DB::raw('sum(existencia) as total')));
            $exisntencia_tienda = Existencia::whereProductoId($dt->producto_id)->whereTiendaId(Auth::user()->tienda_id)->first();

            $kardex = new Kardex;
            $kardex->tienda_id = Auth::user()->tienda_id;
            $kardex->user_id = Auth::user()->id;
            $kardex->kardex_accion_id = 2;
            $kardex->producto_id = $dt->producto_id;
            $kardex->kardex_transaccion_id = 3;
            $kardex->transaccion_id = $dt->descarga_id;
            $kardex->evento = 'salida';
            $kardex->cantidad = $dt->cantidad;
            $kardex->existencia = $existencia->total;
            $kardex->exisntencia_tienda = $exisntencia_tienda->existencia;
            $kardex->costo = ($dt->producto->p_costo/100);
            $kardex->costo_promedio = ($dt->producto->p_costo/100);
            $kardex->save();
        }
    }
});

Event::listen('eloquent.updated: Traslado', function(Traslado $model){
    if ($model->status == 1 && $model->kardex == 0)
    {
        $venta = Traslado::find($model->id);
        $venta->kardex = 1 ;
        $venta->save();

        $detalleTraslado = DetalleTraslado::with('producto')->where('traslado_id',$model->id)->get();

        foreach ($detalleTraslado as $dt)
        {
            $existencia = Existencia::whereProductoId($dt->producto_id)->first(array(DB::raw('sum(existencia) as total')));
            $exisntencia_tienda = Existencia::whereProductoId($dt->producto_id)->whereTiendaId(Auth::user()->tienda_id)->first();

            $kardex = new Kardex;
            $kardex->tienda_id = Auth::user()->tienda_id;
            $kardex->user_id = Auth::user()->id;
            $kardex->kardex_accion_id = 2;
            $kardex->producto_id = $dt->producto_id;
            $kardex->kardex_transaccion_id = 4;
            $kardex->transaccion_id = $dt->traslado_id;
            $kardex->evento = 'salida';
            $kardex->cantidad = $dt->cantidad;
            $kardex->existencia = $existencia->total;
            $kardex->exisntencia_tienda = $exisntencia_tienda->existencia;
            $kardex->costo = ($dt->producto->p_costo/100);
            $kardex->costo_promedio = ($dt->producto->p_costo/100);
            $kardex->save();
        }
    }

    if ($model->status == 1 && $model->recibido == 1)
    {
        $detalleTraslado = DetalleTraslado::with('producto')->where('traslado_id',$model->id)->get();

        foreach ($detalleTraslado as $dt)
        {
            $existencia = Existencia::whereProductoId($dt->producto_id)->first(array(DB::raw('sum(existencia) as total')));
            $exisntencia_tienda = Existencia::whereProductoId($dt->producto_id)->whereTiendaId(Auth::user()->tienda_id)->first();

            $kardex = new Kardex;
            $kardex->tienda_id = Auth::user()->tienda_id;
            $kardex->user_id = Auth::user()->id;
            $kardex->kardex_accion_id = 2;
            $kardex->producto_id = $dt->producto_id;
            $kardex->kardex_transaccion_id = 4;
            $kardex->transaccion_id = $dt->traslado_id;
            $kardex->evento = 'ingreso';
            $kardex->cantidad = $dt->cantidad;
            $kardex->existencia = $existencia->total;
            $kardex->exisntencia_tienda = $exisntencia_tienda->existencia;
            $kardex->costo = ($dt->producto->p_costo/100);
            $kardex->costo_promedio = ($dt->producto->p_costo/100);
            $kardex->save();
        }
    }
});

Event::listen('eloquent.updated: Devolucion', function(Devolucion $model){
    if ($model->completed == 1)
    {
        $detalleDevolucion = DevolucionDetalle::with('producto')->where('devolucion_id',$model->id)->get();

        foreach ($detalleDevolucion as $dt)
        {
            $existencia = Existencia::whereProductoId($dt->producto_id)->first(array(DB::raw('sum(existencia) as total')));
            $exisntencia_tienda = Existencia::whereProductoId($dt->producto_id)->whereTiendaId(Auth::user()->tienda_id)->first();

            $kardex = new Kardex; 
            $kardex->tienda_id = Auth::user()->tienda_id;
            $kardex->user_id = Auth::user()->id;
            $kardex->kardex_accion_id = 2;
            $kardex->producto_id = $dt->producto_id;
            $kardex->kardex_transaccion_id = 5;
            $kardex->transaccion_id = $dt->devolucion_id;
            $kardex->evento = 'ingreso';
            $kardex->cantidad = $dt->cantidad; 
            $kardex->existencia = $existencia->total;
            $kardex->exisntencia_tienda = $exisntencia_tienda->existencia;
            $kardex->costo = ($dt->precio - $dt->ganancias);
            $kardex->costo_promedio = ($dt->producto->p_costo/100);
            $kardex->save();
        }
    }
}); 
/*************************************************************************
    FIN DE EVENTOS PARA KARDEX
*************************************************************************/


/*************************************************************************
    INICIO DE PERMISOS DE INGRESO A RUTAS CON ROLES
*************************************************************************/
/**Administrador , Propietario  y Usuario**/
Entrust::routeNeedsRole( 'user/*'   ,  array('Owner','Admin','User') , '<script>window.location.reload();</script>', false );
Entrust::routeNeedsRole( 'cliente'  ,  array('Owner','Admin','User') , Redirect::to('/'), false );

/**Administrador y Propietario**/
Entrust::routeNeedsRole( 'admin/*'     , array('Owner','Admin') , '<script>window.location.reload();</script>', false );
Entrust::routeNeedsRole( 'proveedor'   , array('Owner','Admin') , Redirect::to('/'), false );
Entrust::routeNeedsRole( 'pos'         , array('Owner','Admin') , Redirect::to('/'), false );
Entrust::routeNeedsRole( 'owner/users' , array('Owner','Admin') , '<script>window.location.reload();</script>', false );
Entrust::routeNeedsRole( 'owner/user/*', array('Owner','Admin') , '<script>window.location.reload();</script>', false );

/**Propietario**/ 
Entrust::routeNeedsRole( 'owner/chart/*'  , array('Owner') , '<script>window.location.reload();</script>', false );
Entrust::routeNeedsRole( 'owner/soporte/*', array('Owner') , '<script>window.location.reload();</script>', false );
Entrust::routeNeedsRole( 'owner/gastos/*' , array('Owner') , '<script>window.location.reload();</script>', false );
/*************************************************************************
    FIN DE PERMISOS DE INGRESO A RUTAS CON ROLES
*************************************************************************/
