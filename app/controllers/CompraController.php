<?php

class CompraController extends \BaseController {

	public function create()
	{
		if (Input::has('_token'))
		{
			$compra = new Compra;

			if (!$compra->create_master())
			{
				return $compra->errors(); 
			}

			$id = $compra->get_id();
			
			$compra = Compra::find($id);
			$proveedor = Proveedor::find($compra->proveedor_id);
			$contacto = ProveedorContacto::where('proveedor_id','=',$proveedor->id)->first();
			$saldo = $this->TotalCreditoProveedor($proveedor->id);
			
			return Response::json(array(
				'success' => true, 
				'detalle' => View::make('compras.detalle',compact("id"))->render(),
				'info_head' => View::make('compras.info_compra',compact('compra','proveedor','contacto','saldo'))->render()
				));
		}

		return View::make('compras.create');
	} 

	public function AbrirCompraNoCompletada()
	{
		$compra = Compra::find(Input::get('id'));

		if($compra->completed == 1)
		{
			return 'La factura no se puede abri porque ya esta finalizada...';
		}

		$id = Input::get('id');
		$proveedor = Proveedor::find($compra->proveedor_id);
		$contacto = ProveedorContacto::where('proveedor_id','=',$proveedor->id)->first();
		$saldo = $this->TotalCreditoProveedor($proveedor->id);
		$detalle = $this->TablePurchaseDetailsEdit($id);

		return Response::json(array(
			'success' => true, 
			'form' => View::make('compras.edit',compact('id','compra','proveedor','contacto','saldo',"detalle"))->render()
		));


	}

	public function OpenModalPurchaseInfo()
	{

		if (Input::has('_token'))
		{
			$id = Input::get('id');
	    	$compra = Compra::find(Input::get('id'));

			if ( $compra->update_master() )
			{
				$compra = Compra::find($id);
				$proveedor = Proveedor::find($compra->proveedor_id);
				$contacto = ProveedorContacto::where('proveedor_id','=',$proveedor->id)->first();
				$saldo = $this->TotalCreditoProveedor($proveedor->id);

		       return Response::json(array(
				'success' => true, 
				'info_head' => View::make('compras.info_compra',compact('compra','proveedor','contacto','saldo'))->render()
				));
			}
			else
			{
			    return $compra->errors();
			}
    	}

    	$compra = Compra::find(Input::get('id'));
    	$proveedor = Proveedor::find($compra->proveedor_id);

        return View::make('compras.edit_info',compact('compra','proveedor'))->render();
	}

	public function DeletePurchaseDetailsItem()
	{
		DetalleCompra::destroy(Input::get('id'));

		return 'success';
	}

	public function DeletePurchaseInitial()
	{
		Compra::destroy(Input::get('id'));

		return 'success';
	}

	public function detalle()
	{
		if (Input::has('_token'))
		{
			$codigo = DetalleCompra::where('compra_id','=',Input::get("compra_id"))
			->where('producto_id','=',Input::get("producto_id"))->get();

			if($codigo != "[]")
			{
				return "El codigo ya ha sido ingresado..";
			}

			$query = new DetalleCompra;
			
			if (!$query->_create())
			{
				return $query->errors();
			}

			$detalle = $this->TablePurchaseDetails();

			return Response::json(array(
				'success' => true,
				'table'   => View::make('compras.detalle_body', compact("detalle"))->render()
				));
		}

		return false;
	}

	//para eliminar compra ya finalizada y restablecer los precios costo
	function DeletePurchase()
	{
		return ProcesarCompra::delete(Input::get('compra_id'));
	}

	function DeletePurchaseShipping()
	{
		$detalle = Flete::destroy(Input::get('id'));

		return 'success';
	}

	public function FinishInitialPurchase()
	{
		$credito = PagosCompra::join('metodo_pago','pagos_compras.metodo_pago_id','=','metodo_pago.id')
		->where('descripcion','=','Credito')->where('compra_id','=',Input::get('compra_id'))->first();

		$total_compra = $this->TotalPurchase();

		ProcesarCompra::set(Input::get('compra_id'),"nota", @$credito->monto, $total_compra);

		return 'success';
	}

	public function OpenModalPurchaseItemSerials()
	{
		
		$data = explode(",", Input::get('serial'));;
		
		return View::make('compras.serial', compact('data'));
	}

	public function ModalPurchasePayment()
	{

		if (Input::has('_token'))
		{
			if ($this->SeachPaymentMethod() != null ) 
				return 'no puede ingresar dos pagos con el mismo metodo..!';

			if((($this->TotalPurchase() - $this->TotalPurchasePayment())*100) < (Input::get("monto")*100))
				return 'El moto ingresado no puede ser mayor al monto Restante..!';

			$pagos = new PagosCompra;

			if (!$pagos->_create()) 
			{
				$pagos->errors();
			}

			return	$this->PurchasePaymentDetail();
		}

		$detalle_compra = DetalleCompra::where('compra_id','=', Input::get('compra_id'))
		->first(array(DB::Raw('sum(cantidad * precio) as total')));

		if (!count($detalle_compra))
			return 'no a ingresado productos a la factura...!';

		$pagos = PagosCompra::where('compra_id','=',Input::get('compra_id'));
		$pagos->delete();

		$total_compra = number_format($detalle_compra->total, 2, '.', '');

		return Response::json(array(
			'success' => true, 
			'detalle' => View::make('compras.payment',compact('total_compra'))
			->render()
			));
	}

	public function PurchasePaymentDetail()
	{	
		$total_pagos = number_format($this->TotalPurchasePayment(), 2, '.', '');
		$total_compra = number_format($this->TotalPurchase(), 2, '.', '');
		$det_pagos    = $this->TableDetailsPayments();

		return Response::json( array(
			'success' => true,
		    'detalle' => View::make('compras.payment',compact('total_pagos','total_compra','det_pagos'))->render() 
		  ));
		
	}

	//funcion para eliminar un detalle de pago
	public function DeletePurchasePaymentItem()
	{
		$detalle = PagosCompra::destroy(Input::get('id'));

		return $this->PurchasePaymentDetail();
	}

	public function SaveEditPurchaseItemDetails()
	{
		$datos = array( Input::get('dato') => Input::get('dato'));
		$validaciones = array( 
			Input::get('dato') => array('required','numeric','min:1')
			);
		$validator = Validator::make($datos, $validaciones);

		if ( $validator->fails() )
		{
			return $validator->messages()->first();
		}

		$procesar = ProcesarCompra::EditarDetalleCompra(Input::get('detalle_id'),Input::get('tipo_dato'),Input::get('dato'));
		$compra_detalle = DetalleCompra::find(Input::get('detalle_id'));

		$detalle = $this->TablePurchaseDetailsEdit($compra_detalle->compra_id);

		return Response::json(array(
			'success' => $procesar,
			'table'   => View::make('compras.detalle_body', compact("detalle"))->render()
			));
	}

	//funcion para verificar si ya se ingreso un pago con ese metodo
	public function SeachPaymentMethod()
	{
		$query = PagosCompra::where('compra_id','=', Input::get('compra_id'))
		->where('metodo_pago_id','=', Input::get('metodo_pago_id'))
		->first();

		return $query;
	}

	public function TotalPurchase()
	{
		$total = DetalleCompra::select(DB::Raw('sum(cantidad * precio) as total'))
		->where('compra_id','=', Input::get('compra_id'))->first();

		return $total->total;
	}

	public function TotalPurchasePayment()
	{
		$total = PagosCompra::select(DB::Raw('sum(monto) as total'))
		->where('compra_id','=', Input::get('compra_id'))->first();

		return $total->total;
	}

	public function TotalCreditoProveedor($proveedor_id)
    {
        $total = Compra::select(DB::Raw('sum(saldo) as total'))
        ->where('proveedor_id','=', $proveedor_id)
        ->where('saldo','>', 0 )->first();

        return $total->total;
    }

	public function TablePurchaseDetails()
	{
		$query = DB::table('detalle_compras')
		->select(array('detalle_compras.id as id','compra_id', 'producto_id', 'cantidad', 'precio', DB::raw('CONCAT(productos.descripcion, " ", marcas.nombre) AS descripcion, cantidad * precio AS total') ))
		->where('compra_id', Input::get("compra_id"))
		->join('productos', 'detalle_compras.producto_id', '=', 'productos.id')
		->join('marcas', 'productos.marca_id', '=', 'marcas.id')
		->get();

		return $query;		
	}

	public function TablePurchaseDetailsEdit($compra_id)
	{
		$query = DB::table('detalle_compras')
		->select(array('detalle_compras.id as id','compra_id', 'producto_id', 'cantidad', 'precio', DB::raw('CONCAT(productos.descripcion, " ", marcas.nombre) AS descripcion, cantidad * precio AS total') ))
		->where('compra_id', $compra_id)
		->join('productos', 'detalle_compras.producto_id', '=', 'productos.id')
		->join('marcas', 'productos.marca_id', '=', 'marcas.id')
		->get();

		return $query;		
	}


	function TableDetailsPayments()
	{
		$pagos = PagosCompra::where('compra_id','=', Input::get('compra_id'))->get();

		return $pagos;
	}
	
	public function showPurchaseDetail()
	{
		$detalle = DB::table('detalle_compras')
        ->select(array('detalle_compras.id', 'compra_id', 'producto_id', 'cantidad', 'precio', DB::raw('CONCAT(productos.descripcion, " ", marcas.nombre) AS descripcion, cantidad * precio AS total') ))
        ->where('compra_id', Input::get('id'))
        ->join('productos', 'detalle_compras.producto_id', '=', 'productos.id')
        ->join('marcas', 'productos.marca_id', '=', 'marcas.id')
        ->get();

		$deuda = 0;

		return Response::json(array(
			'success' => true,
			'table'   => View::make('compras.DT_detalle_compra', compact('detalle', 'deuda'))->render()
        ));
	}

	public function showPaymentsDetail()
	{
		 $detalle = DB::table('detalle_abonos_compra')
        ->select('compra_id','total','monto',DB::raw('detalle_abonos_compra.created_at as fecha'))
        ->join('compras','compras.id','=','detalle_abonos_compra.compra_id')
        ->where('abonos_compra_id','=', Input::get('id'))->get();


		$deuda = 0;

		return Response::json(array(
			'success' => true,
			'table'   => View::make('compras.DT_detalle_abono', compact('detalle', 'deuda'))->render()
        ));
	}


	/*
		************************************************************************************************
		SECCION DE CONSULTAS
		************************************************************************************************
	*/

	public function ConsultPurchase()
	{
		return View::make('compras.ConsultPurchase');
	}

	public function Purchase_dt()
	{

		$table = 'compras';

		$columns = array(
			"compras.created_at as fecha",
			"fecha_documento",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			'proveedores.nombre as proveedor_nombre',
			"numero_documento",
			"total",
			"saldo");

		$Search_columns = array("users.nombre","users.apellido","fecha_documento","numero_documento");

		$Join = "JOIN users ON (users.id = compras.user_id) JOIN proveedores ON (proveedores.id = compras.proveedor_id)";

		$where = " proveedor_id = ".Input::get('proveedor_id');

		echo TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}


	public function OpenTablePurchaseDay()
	{
		return View::make('compras.PurchaseDay');
	}

	function PurchaseDay_dt(){

		$table = 'compras';

		$columns = array(
			"compras.created_at as fecha",
			"fecha_documento",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"proveedores.nombre as proveedor_nombre",
			"numero_documento",
			"total",
			"saldo",
			"completed");

		$Search_columns = array("users.nombre","users.apellido","numero_documento","proveedores.nombre");

		$Join = "JOIN users ON (users.id = compras.user_id) JOIN proveedores ON (proveedores.id = compras.proveedor_id)";

		$where = " DATE_FORMAT(compras.created_at, '%Y-%m-%d')  = DATE_FORMAT(current_date, '%Y-%m-%d')";

		echo TableSearch::get($table, $columns, $Search_columns, $Join, $where );
	}

	public function ShowTableUnpaidShopping()
	{
			$compras = DB::table('compras')
        	->select(DB::raw("compras.fecha_documento as fecha, 
        		compras.created_at as  fecha_ingreso,
            	CONCAT_WS(' ',users.nombre,users.apellido) as usuario, 
            	proveedores.nombre as proveedor,
            	numero_documento,
            	compras.id as id ,
            	saldo,compras.total as total"))
        ->join('users', 'compras.user_id', '=', 'users.id')
        ->join('proveedores', 'compras.proveedor_id', '=', 'proveedores.id')
        ->where('saldo', '>', 0)
        ->where('proveedor_id','=',Input::get('proveedor_id'))
        ->orderBy('fecha', 'ASC')
        ->get();

		return Response::json(array(
			'success' => true,
			'table' => View::make('compras.ComprasPendientesDePago', compact('compras'))->render()
        ));
	}

	public function ComprasPendientesDePago()
	{

		$table = 'compras';

		$columns = array(
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			'proveedores.nombre as proveedor_nombre',
			'compras.created_at',
			"fecha_documento",
			"numero_documento",
			"completed",
			"saldo");

		$Search_columns = array("users.nombre","users.apellido","fecha_documento","numero_documento");

		$Join = "JOIN users ON (users.id = compras.user_id) JOIN proveedores ON (proveedores.id = compras.proveedor_id)";

		$where = " proveedor_id = ".Input::get('proveedor_id')." AND saldo > 0";

		echo TableSearch::get($table, $columns, $Search_columns, $Join ,$where);
		
	}

	public function getCreditPurchase()
	{
		$compras = DB::table('compras')
        	->select(DB::raw("compras.fecha_documento as fecha, 
            CONCAT_WS(' ',users.nombre,users.apellido) as usuario, 
            proveedores.nombre as proveedor,
            numero_documento,
            compras.id as id ,
            saldo"))
        ->join('users', 'compras.user_id', '=', 'users.id')
        ->join('proveedores', 'compras.proveedor_id', '=', 'proveedores.id')
        ->where('saldo', '>', 0)
        ->orderBy('fecha', 'ASC')
        ->get();

		return Response::json(array(
			'success' => true,
			'table' => View::make('compras.ComprasPendientesDePago', compact('compras'))->render()
        ));

	}
	
	public function ShowTableHistoryPayment()
	{
		return View::make('compras.HistorialDePagos');
	}

	public function HistorialDePagos()
	{
		$table = 'pagos_compras';

		$columns = array(

			"CONCAT_WS(' ',tiendas.nombre,tiendas.direccion) as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"pagos_compras.created_at as fecha",
			"compras.numero_documento as factura",
			"metodo_pago.descripcion as metodo_descripcion",
			'monto');


		$Searchable = array("users.nombre","users.apellido");

		$Join = "
		JOIN compras ON (compras.id = pagos_compras.compra_id) 
		JOIN users ON (users.id = compras.user_id)
		JOIN tiendas ON (tiendas.id = compras.tienda_id)
		JOIN metodo_pago ON (metodo_pago.id = pagos_compras.metodo_pago_id)";

		$where = " proveedor_id = ".Input::get('proveedor_id');

		echo TableSearch::get($table, $columns, $Searchable, $Join, $where );	
	}

	public function ShowTableHistoryPaymentDetails()
	{
		return View::make('compras.HistorialDeAbonos');
	}


	public function HistorialDeAbonos()
	{
		$table = 'abonos_compras';

		$columns = array(
			"CONCAT_WS(' ',tiendas.nombre,tiendas.direccion) as tienda_nombre",
			"CONCAT_WS(' ',users.nombre,users.apellido) as user_nombre",
			"abonos_compras.created_at as fecha",
			"metodo_pago.descripcion as metodo_descripcion",
			'total','observaciones');

		$Searchable = array("users.nombre","users.apellido");

		$Join = "
		JOIN users ON (users.id = abonos_compras.user_id)
		JOIN tiendas ON (tiendas.id = abonos_compras.tienda_id)
		JOIN metodo_pago ON (metodo_pago.id = abonos_compras.metodo_pago_id)";

		$where = " proveedor_id = ".Input::get('proveedor_id');

		echo TableSearch::get($table, $columns, $Searchable, $Join, $where );	
	}

}	
