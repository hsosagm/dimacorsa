-- Inventario
SELECT productos.id, concat( descripcion, " ", nombre ) AS item, existencia, p_costo
FROM productos
JOIN marcas ON productos.marca_id = marcas.id
WHERE existencia >0
ORDER BY categoria_id
LIMIT 0 , 30

SELECT concat( descripcion, " ", nombre ) AS item, p_costo, existencias.existencia
FROM existencias
JOIN productos ON existencias.producto_id = productos.id
JOIN marcas ON productos.marca_id = marcas.id
WHERE tienda_id =1
AND existencias.existencia >0


SELECT existencias.id, `producto_id` , concat( descripcion, " ", nombre ) AS item, p_costo, existencias.existencia
FROM existencias
JOIN productos ON existencias.producto_id = productos.id
JOIN marcas ON productos.marca_id = marcas.id
WHERE tienda_id =2
AND existencias.existencia >0
ORDER BY existencias.id ASC


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


--consulta para sacar las compras con deposito de un mes especifico
SELECT
	CONCAT_WS(' ', u.nombre, u.apellido) as USUARIO,
	p.nombre as PROVEEDOR,
	c.total AS TOTAL,
	pc.monto AS MONTO,
	mp.descripcion AS METODO_PAGO,
	c.created_at AS FECHA

FROM compras c

INNER JOIN pagos_compras pc ON ( pc.compra_id = c.id )
INNER JOIN proveedores p ON (p.id = c.proveedor_id)
INNER JOIN users u ON (u.id = c.user_id)
INNER JOIN metodo_pago mp ON (mp.id = pc.metodo_pago_id)

WHERE
	pc.metodo_pago_id = 5 AND
	DATE_FORMAT( c.created_at, '%Y-%m' ) = DATE_FORMAT( '2016-02-01', '%Y-%m' ) AND
	c.tienda_id = 1

Reporte clientes
select
	id,
	nombre,
	direccion,
	telefono,
	email
from clientes
order by email desc;