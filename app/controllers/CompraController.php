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

			return Response::json(array(
				'success' => true, 
				'detalle' => View::make('compras.detalle',compact("id"))->render()
				));
		}

		return View::make('compras.create');
	} 

	public function delete()
	{
		$detalle = DetalleCompra::where('compra_id','=',Input::get('id'));

		$detalle->delete();

		$detalle_abono = AbonosDetalle::where('compra_id','=',Input::get('id'));

		$arreglo = $detalle_abono->get();

		$detalle_abono->delete();

		foreach ($arreglo as $key => $dato) 
		{
			$abono = Abonos::find($dato->prov_abono_id);

			$abono->delete();
		}

		$compra = Compra::find(Input::get('id'));

		$compra->delete();
		
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

			return Response::json(array(
				'success' => true,
				'table'   => $this->table_detail()
				));
		}

		return false;
	}

	function detalle_edit()
	{
		if (Input::get('tipo') == 'precio') 
		{
			return ProcesarCompra::RecalculatedProductoPrecio(Input::get('detalle_id'), Input::get('dato'));
		}

		else if (Input::get('tipo') == 'cantidad') 
		{
			return ProcesarCompra::RecalculatedProductoCantidad(Input::get('detalle_id'), Input::get('dato'));
		}
	}

	function delete_inicial()
	{
		$detalle = DetalleCompra::find(Input::get('id'));

		$detalle->delete();

		return 'success';
	}

	function delete_compra()
	{
		return ProcesarCompra::delete(Input::get('compra_id'));
	}

	public function FinalizarCompra()
	{
		return ProcesarCompra::set(Input::get('compra_id'));
	}

	public function serial()
	{
		$data = explode(",", Input::get('serial'));;

		return View::make('compras.serial', compact('data'));
	}

	public function abono()
	{
		$detalle_compra = DetalleCompra::where('compra_id','=', Input::get('compra_id'))->get();

		if (count($detalle_compra) <= 0 )
			return 'no a ingresado productos a la factura...!';

		$metodos   = $this->metodos_no_asignados(Input::get('compra_id'));
		$det_pagos = $this->table_detail_abono(Input::get('compra_id'));
		$total_abono  = $this->TotalAbonado(Input::get('compra_id'));
		$total_compra = $this->TotalCompra(Input::get('compra_id'));
		$desabilitar = ''; 
		$value_submit ='Ingresar Abono'; 
		$funcion_submit = '';

		if(($total_compra - $total_abono )<= 0)
		{
			$desabilitar = 'disabled';
			$value_submit = 'Finalizar Compra';
            $funcion_submit = 'FinalizarCompraInicial();';
        }

		return Response::json(array(
			'success' => true, 
			'detalle' => View::make('compras.abono',compact('metodos','det_pagos','total_abono','total_compra','desabilitar','value_submit','funcion_submit'))->render()
			));
	}

	public function ingresar_abono()
	{	
		$values = trim(Input::get('monto'));
		$values = preg_replace('/\s{2,}/', ' ', $values);
		$cancelada = false;
		$total_abonos = $this->TotalAbonado(Input::get('compra_id'));
		$total_compra = $this->TotalCompra(Input::get('compra_id'));
		$total_restante = $total_compra - $total_abonos;

		if ($this->SeachMetodoPago(Input::get('compra_id'),Input::get('metodo_pago_id')) != '[]') 
			return 'no puede ingresar dos pagos con el mismo metodo..!';

		if($total_restante < $values)
			return 'El moto ingresado no puede ser mayor al monto Restante..!';

		if($total_compra <= $total_abonos)
			return Response::json( array('cancelada' => true ));

		if ($values == "" )
			return 'el monto es obligatorio';

		$metodoPago = MetodoPago::find(Input::get('metodo_pago_id'));
		$monto = $values;

		if($metodoPago->descripcion == 'Credito')
		{
			$compra = Compra::find( Input::get('compra_id'));
			$compra->saldo = $compra->saldo + $values;
			$compra->save();
			$monto = 0.00;
		}

		$this->Guardar_Abono($monto);
		
		$total_abonos = $this->TotalAbonado(Input::get('compra_id'));
		$total_compra = $this->TotalCompra(Input::get('compra_id'));

		if($total_compra <= $total_abonos)
			$cancelada = true;

		return Response::json( array('success' => true,'cancelada' => $cancelada ));
	}

	public function Guardar_Abono($monto)
	{
		$abono = new Abonos;
		$abono->user_id= Auth::user()->id;
		$abono->metodo_pago_id=Input::get('metodo_pago_id');
		$abono->proveedor_id=Input::get('proveedor_id');
		$abono->monto= $monto;
		$abono->save();

		$prov_abono_id = DB::getPdo()->lastInsertId();

		$detalle = new AbonosDetalle;
		$detalle->prov_abono_id = $prov_abono_id;
		$detalle->compra_id = Input::get('compra_id');
		$detalle->monto = Input::get('monto');
		$detalle->save();
	}

	public function delete_abono()
	{
		$detalle = AbonosDetalle::find(Input::get('id'));
		$abono = Abonos::find($detalle->prov_abono_id);

		if(Input::get("metodo") == "Credito")
		{
			$compra = Compra::find($detalle->compra_id);
			$compra->saldo = $compra->saldo - $detalle->monto;
			$compra->save();
		}

		$detalle->delete();
		$abono->delete();

		return Response::json( array(
			'success' => true,
			'metodo_pago' => $this->metodos_no_asignados($detalle->compra_id),
			'detalle' => $this->table_detail_abono($detalle->compra_id)
			));
	}

	public function edit_detalle_compra()
	{
		$datos = array( Input::get('tipo_dato') => Input::get('dato'));
		$validaciones = array( Input::get('tipo_dato') => array('required','numeric','min:1'));
		$validator = Validator::make($datos, $validaciones);

		if ( $validator->fails() )
		{
			return $validator->messages()->first();
		}

		$procesar = ProcesarCompra::EditarDetalleCompra(Input::get('detalle_id'),Input::get('tipo_dato'),Input::get('dato'));

		return Response::json(array(
			'success' => $procesar,
			'table'   => $this->table_detail()
			));
	}

	public function SeachMetodoPago($compra_id , $metodo_pago)
	{
		$query = AbonosDetalle::join('prov_abonos','prov_abonos.id','=','prov_abonos_detalle.prov_abono_id')
		->where('compra_id','=', $compra_id)
		->where('metodo_pago_id','=', $metodo_pago)
		->get();

		return $query;
	}

	public function TotalCompra($compra_id)
	{
		$total = DetalleCompra::select(DB::Raw('sum(cantidad * precio) as total'))
		->where('compra_id','=', $compra_id)->first();

		return $total->total;
	}

	public function TotalAbonado($compra_id)
	{
		$total = AbonosDetalle::select(DB::Raw('sum(monto) as total'))
		->where('compra_id','=', $compra_id)->first();

		return $total->total;
	}

	public function table_detail()
	{
		$query = DB::table('detalle_compras')
		->select(array('detalle_compras.id as id','compra_id', 'producto_id', 'cantidad', 'precio', DB::raw('CONCAT(productos.descripcion, " ", marcas.nombre) AS descripcion, cantidad * precio AS total') ))
		->where('compra_id', Input::get('compra_id'))
		->join('productos', 'detalle_compras.producto_id', '=', 'productos.id')
		->join('marcas', 'productos.marca_id', '=', 'marcas.id')
		->get();

		$deuda = 0;
		$detalle = '';

		foreach ($query as $key => $q)
		{
			$precio = number_format($q->precio,2,'.',',');
			$total = number_format($q->total,2,'.',',');
			$detalle.= '<tr>';
			$detalle.= '<td class="hide">' . $q->producto_id . '</td>';
			$detalle.= '<td field="cantidad" cod="'.$q->id.'" class="edit_detalle_compra" width="60">'.$q->cantidad.'</td>';       
			$detalle.= '<td width="770"> ' . $q->descripcion . ' </td>';
			$detalle.= '<td field="precio" cod="'.$q->id.'" class="edit_detalle_compra" width="70">'.$precio.'</td>';
			$detalle.= '<td width="75">' . $total . '</td>';
			$detalle.= '<td width="25"><i id="'.$q->id.'" href="admin/compras/delete_inicial" class="fa fa-times pointer btn-link theme-c" onClick="DeleteDetalle(this);"></i></td>';
			$detalle.= '</tr>'; 
		}

		return $detalle;
	}

	function table_detail_abono($compra_id)
	{
		$pagos = AbonosDetalle::select('prov_abonos_detalle.id as id','prov_abonos_detalle.monto as monto','metodo_pago.descripcion as metodo')
		->where('compra_id','=', $compra_id)
		->join('prov_abonos', 'prov_abonos_detalle.prov_abono_id', '=', 'prov_abonos.id')
		->join('metodo_pago', 'prov_abonos.metodo_pago_id', '=', 'metodo_pago.id')->get();

		return $pagos;
	}

	public function metodos_no_asignados($compra_id)
	{
		$no_assigned = MetodoPago::lists('descripcion', 'id');

		return Form::select('metodo_pago_id', $no_assigned,'', array('class'=>'form-control'));
	}

}	
