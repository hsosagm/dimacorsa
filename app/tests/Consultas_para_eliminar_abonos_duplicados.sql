Delete from pagos_compras 
where 
CONCAT_WS('',pagos_compras.metodo_pago_id,
	DATE_FORMAT(pagos_compras.created_at,'%Y-%m-%d'),
	pagos_compras.compra_id )

in (select 
	CONCAT_WS('',abonos_compras.metodo_pago_id,
		DATE_FORMAT(detalle_abonos_compra.created_at,'%Y-%m-%d'),
		detalle_abonos_compra.compra_id)
	FROM detalle_abonos_compra 
	INNER JOIN abonos_compras ON (abonos_compras.id = detalle_abonos_compra.abonos_compra_id));

Delete from pagos_ventas 
where 

CONCAT_WS('',pagos_ventas.metodo_pago_id,
	DATE_FORMAT(pagos_ventas.created_at,'%Y-%m-%d'),
	pagos_ventas.venta_id )

in (select 
	CONCAT_WS('',abonos_ventas.metodo_pago_id,
		DATE_FORMAT(detalle_abonos_ventas.created_at,'%Y-%m-%d'),
		detalle_abonos_ventas.venta_id)
	FROM detalle_abonos_ventas 
	INNER JOIN abonos_ventas ON (abonos_ventas.id = detalle_abonos_ventas.abonos_ventas_id));
