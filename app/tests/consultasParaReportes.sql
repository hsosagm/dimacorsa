--consulta para sacar las ventas con deposito de un mes especifico
SELECT 
	CONCAT_WS(' ', u.nombre, u.apellido) as USUARIO,
	c.nombre as CLIENTE,
	v.total AS TOTAL,
	pv.monto AS MONTO,
	mp.descripcion AS METODO_PAGO,
	v.created_at AS FECHA

FROM ventas v

INNER JOIN pagos_ventas pv ON ( pv.venta_id = v.id )
INNER JOIN clientes c ON (c.id = v.cliente_id) 
INNER JOIN users u ON (u.id = v.user_id)
INNER JOIN metodo_pago mp ON (mp.id = pv.metodo_pago_id)

WHERE 
	pv.metodo_pago_id = 5 AND 
	DATE_FORMAT( v.created_at, '%Y-%m' ) = DATE_FORMAT( '2016-02-01', '%Y-%m' ) AND
	v.tienda_id = 1