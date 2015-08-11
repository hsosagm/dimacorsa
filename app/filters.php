<?php

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

Event::listen('eloquent.updated: Compra', function(Compra $model){
    if ($model->completed == 1 && $model->kardex == 0) 
    {
        $compra = Compra::find($model->id);
        $compra->kardex = 1 ;
        $compra->save();

        $detalleCompra = DetalleCompra::with('producto')->where('compra_id',$model->id)->get();

        foreach ($detalleCompra as $dt) 
        {
            $existencia = Existencia::where('tienda_id', '=', $model->tienda_id)->where('producto_id', '=', $dt->producto_id)->first();

            $kardex = new Kardex;
            $kardex->tienda_id = Auth::user()->tienda_id;
            $kardex->user_id = Auth::user()->id;
            $kardex->kardex_accion_id = 2;
            $kardex->producto_id = $dt->producto_id;
            $kardex->kardex_transaccion_id = 1;
            $kardex->transaccion_id = $dt->compra_id;
            $kardex->evento = 'ingreso';
            $kardex->cantidad = $dt->cantidad;
            $kardex->existencia = $existencia->existencia;
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
            $existencia = Existencia::where('tienda_id', '=', $model->tienda_id)->where('producto_id', '=', $dt->producto_id)->first();
            
            $kardex = new Kardex;
            $kardex->tienda_id = Auth::user()->tienda_id;
            $kardex->user_id = Auth::user()->id;
            $kardex->kardex_accion_id = 2;
            $kardex->producto_id = $dt->producto_id;
            $kardex->kardex_transaccion_id = 2;
            $kardex->transaccion_id = $dt->venta_id;
            $kardex->evento = 'salida';
            $kardex->cantidad = $dt->cantidad;
            $kardex->existencia = $existencia->existencia;
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

        $detalleVenta = DetalleTraslado::with('producto')->where('traslado_id',$model->id)->get();

        foreach ($detalleVenta as $dt) 
        {
            $existencia = Existencia::where('tienda_id', '=', $model->tienda_id)->where('producto_id', '=', $dt->producto_id)->first();
            
            $kardex = new Kardex;
            $kardex->tienda_id = Auth::user()->tienda_id;
            $kardex->user_id = Auth::user()->id;
            $kardex->kardex_accion_id = 2;
            $kardex->producto_id = $dt->producto_id;
            $kardex->kardex_transaccion_id = 4;
            $kardex->transaccion_id = $dt->traslado_id;
            $kardex->evento = 'salida';
            $kardex->cantidad = $dt->cantidad;
            $kardex->existencia = $existencia->existencia;
            $kardex->costo = ($dt->producto->p_costo/100);
            $kardex->costo_promedio = ($dt->producto->p_costo/100);
            $kardex->save();  
        }
    }
});


/** Roles de Administrador , Propietario  y Usuario **/
Entrust::routeNeedsRole( 'user/*'   ,  array('Owner','Admin','User') , Redirect::to('/'), false );
Entrust::routeNeedsRole( 'cliente'  ,  array('Owner','Admin','User') , Redirect::to('/'), false );

/** Roles de Administrador y Propietario **/
Entrust::routeNeedsRole( 'admin/*'     , array('Owner','Admin') , Redirect::to('/'), false );
Entrust::routeNeedsRole( 'proveedor'   , array('Owner','Admin') , Redirect::to('/'), false );
Entrust::routeNeedsRole( 'owner/users' , array('Owner','Admin') , Redirect::to('/'), false );
Entrust::routeNeedsRole( 'owner/user/*', array('Owner','Admin') , Redirect::to('/'), false );

/** Roles del Propietario **/
Entrust::routeNeedsRole( 'owner/chart/*'  , array('Owner') , Redirect::to('/'), false );
Entrust::routeNeedsRole( 'owner/soporte/*', array('Owner') , Redirect::to('/'), false );
Entrust::routeNeedsRole( 'owner/gastos/*' , array('Owner') , Redirect::to('/'), false );
