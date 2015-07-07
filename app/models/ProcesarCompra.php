<?php

class ProcesarCompra 
{	
	public static function set($compra_id, $nota = null,$saldo = 0.00 , $total_compra)
	{
		ProcesarCompra::UpdateProducto($compra_id);

		$compra = Compra::find($compra_id);

		$compra->completed = 1 ;

		$compra->nota = $nota;

		$compra->saldo = $saldo;

		$compra->total = $total_compra;

		$compra->save();

		return 'success';
	}

	public static function delete($compra_id)
	{
		ProcesarCompra::ResetProducto($compra_id);

		Compra::destroy($compra_id);

		return 'Compra Eliminada...!';
	}

	public static function EditarDetalleCompra($detalle_id , $tipo , $dato)
	{
		
		if ($tipo == "precio") 
		{
			return ProcesarCompra::EditarPrecioDetalle($detalle_id , $dato);
		}

		else if ($tipo == "cantidad") 
		{
			return ProcesarCompra::EditarCantidadDetalle($detalle_id, $dato);
		}
	}

	public static function EditarPrecioDetalle($detalle_id , $precio)
	{
		$detalle = DetalleCompra::find($detalle_id);

		$detalle->precio = $precio ;

		$detalle->save();

		return true;
	}

	public static function EditarCantidadDetalle($detalle_id , $cantidad)
	{
		$detalle = DetalleCompra::find($detalle_id);

		$detalle->cantidad = $cantidad ;

		$detalle->save();

		return true;
	}

	public static function RecalculatedProductoPrecio($detalle_id , $precio_n)
	{
		$detalle = DetalleCompra::find($detalle_id);

		// funciones para setear el producto

		$producto = Producto::find($detalle->producto_id);

		$precio = ProcesarCompra::resetPrecio(($detalle->precio*100),$detalle->cantidad,$producto->p_costo,$producto->existencia);
		
		ProcesarCompra::setProducto($detalle->producto_id , $precio);

		//funcion para actualizar el producto

		$producto = Producto::find($detalle->producto_id);

		$precio = ProcesarCompra::getPrecio(($precio_n*100),$detalle->cantidad,$producto->p_costo,$producto->existencia);

		ProcesarCompra::setProducto($detalle->producto_id , $precio);

		//funcion para actualizar el precio en el detalle

		$detalle->precio = $precio_n;

		$detalle->save();

		return 'success';

	}

	public static function RecalculatedProductoCantidad($detalle_id , $cantidad_n)
	{
		$detalle = DetalleCompra::find($detalle_id);

		// funciones para setear el producto

		$producto = Producto::find($detalle->producto_id);

		$precio = ProcesarCompra::resetPrecio(($detalle->precio*100),$detalle->cantidad,$producto->p_costo,$producto->existencia);
		
		ProcesarCompra::setProducto($detalle->producto_id , $precio );

		$existencia = ProcesarCompra::resetCantidad($detalle->producto_id , $detalle->cantidad);

		ProcesarCompra::setExistencia($detalle->producto_id , $existencia);

		//funcion para actualizar el producto

		$producto = Producto::find($detalle->producto_id);

		$precio = ProcesarCompra::getPrecio(($detalle->precio*100),$cantidad_n,$producto->p_costo,$producto->existencia);

		ProcesarCompra::setProducto($detalle->producto_id , $precio);

		$existencia = ProcesarCompra::getCantidad($detalle->producto_id,$cantidad_n);

		ProcesarCompra::setExistencia($detalle->producto_id , $existencia);


		//funcion para actualizar la cantidad en el detalle
		
		$detalle->cantidad = $cantidad_n;

		$detalle->save();

		return 'success';
		
	}

	public static function UpdateProducto($compra_id)
	{
		$detalle = DetalleCompra::where('compra_id','=',$compra_id)->get();

		// funcion para recorrer el detalle de la compra

		foreach ($detalle as $key => $dt) 
		{
			//funcion para obtener el precio y existencia del producto
			$producto = ProcesarCompra::getPrecioProducto($dt->producto_id);

			//funcion para calcular el precio costo del producto
			$precio = ProcesarCompra::getPrecio(($dt->precio*100),$dt->cantidad,$producto[0],$producto[1]);

			$existencia = ProcesarCompra::getCantidad($dt->producto_id,$dt->cantidad);

			//funcion para actualizar los datos del producto
			ProcesarCompra::setProducto($dt->producto_id , $precio);

			ProcesarCompra::setExistencia($dt->producto_id , $existencia);
		}
	}

	public static function ResetProducto($compra_id)
	{
		$detalle = DetalleCompra::where('compra_id','=',$compra_id)->get();

		//funcion para recorrer el detalle de la compra

		foreach ($detalle as $key => $dt) 
		{	
			//funcion para obtener precio y existencia del producto
			$producto = ProcesarCompra::getPrecioProducto($dt->producto_id);

			//funcion para setear el precio del producto
			$precio = ProcesarCompra::resetPrecio(($dt->precio*100),$dt->cantidad,$producto[0],$producto[1]);

			$existencia = ProcesarCompra::resetCantidad($producto_id,$dt->cantidad);

			//funcion para actualizar los datos ya seteados del producto
			ProcesarCompra::setProducto($dt->producto_id , $precio );

			ProcesarCompra::setExistencia($producto_id , $existencia);
		}
	}

	public static function getPrecio($precio, $cantidad, $_precio, $_cantidad)
	{
		$total_nvo = $precio * $cantidad;

		$total_inv = $_precio * $_cantidad;

		$total = $total_nvo + $total_inv;

		$existencia = $cantidad + $_cantidad ;

		$precio_costo = $total / $existencia;

		return  $precio_costo;
	}

	public static function resetPrecio($precio, $cantidad, $_precio, $_cantidad)
	{
		$total_nvo = $precio * $cantidad;

		$total_inv = $_precio * $_cantidad;

		$total = $total_inv - $total_nvo;

		$existencia = $_cantidad - $cantidad ;

		if ($existencia == 0) 
			$precio_costo = $total;

		else
			$precio_costo = $total / $existencia;


		return  array( $precio_costo ,  $existencia );
	}

	public static function getCantidad($producto_id, $_cantidad)
	{
		$cantidad = Existencia::where('producto_id', '=' , $producto_id)
		->where('tienda_id','=',Auth::user()->tienda_id)->first();

		if($cantidad == null)
		{
			return $_cantidad;
		}

		$existencia = $cantidad->existencia + $_cantidad ;

		return  $existencia;
	}

	public static function resetCantidad($producto_id, $_cantidad)
	{
		$cantidad = Existencia::where('producto_id', '=' , $producto_id)
		->where('tienda_id','=',Auth::user()->tienda_id)->first();

		if($cantidad == null)
		{
			return $_cantidad;
		}

		$existencia = $cantidad->existencia - $_cantidad ;

		return   $existencia;
	}

	public static function getPrecioProducto($producto_id)
	{
		$producto = Producto::find($producto_id);

		return array($producto->p_costo , $producto->existencia);
	}

	public static function setProducto($producto_id, $p_costo)
	{
		$producto = Producto::find($producto_id);

		$producto->p_costo = $p_costo;

		$producto->save();
	}

	public static function setExistencia($producto_id, $existencia)
	{
		$Exist = Existencia::where('producto_id','=',$producto_id)
		->where('tienda_id' , '=' , Auth::user()->tienda_id)->first();

		if($Exist == null)
		{
			$table = new Existencia;

			$table->producto_id = $producto_id;

			$table->tienda_id = Auth::user()->tienda_id;

			$table->existencia = $existencia;

			$table->save();

			echo $Exist;

			return 'insertado';
		}

		else
		{
			$table = Existencia::find($Exist->id);

			$table->existencia = $existencia;

			$table->save();

		}
	}

}
