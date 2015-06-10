// crear tiendas 

INSERT INTO `tiendas` (`id`, `nombre`, `direccion`, `telefono`, `status`, `created_at`, `updated_at`) VALUES
(1, 'Click', 'Chiquimula', '79421383', 1, '2015-02-16 17:23:05', '2015-02-16 17:23:05'),
(2, 'Bodega', 'Chiquimula', '78787878', 1, '2015-02-16 17:23:05', '2015-02-16 17:23:05');

// crear usuarios -- usar el colocar tienda id 2
// crear categorias
// crear marcas //agregar la marca 492
INSERT INTO marcas(id,nombre) VALUES(492,'ups');

//ejecutar scrip
INSERT INTO `precio_venta` VALUES (1, 'Base', '2015-6-3 08:35:48', '2015-6-3 08:35:48');

INSERT INTO `metodo_pago` (`id`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Efectivo', '2015-02-16 17:23:05', '2015-02-16 17:23:05'),
(2, 'Credito', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Cheque', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(4, 'Tarjeta', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Deposito', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

//productos

//ejecutar antes de crear los clientes
INSERT INTO tipo_cliente(nombre) values('Consumidor Final');

//cliente
//soporte - detalle soporte
//gastos - detalle gastos
//egresos - detalle egresos
//adelantos - detalle adelantos

//proveedores

//en ventas y compras enviar la tienda id dela base de datos antigua

//compras

//antes de importar detalles de compras /crear una tabla temporar con la estructura de la tabla de la 
//base de datos vieja y agregar una columna con el nombre producto_id y ejecutar este script

UPDATE detallecompra SET 
producto_id = (SELECT id from productos WHERE codigo = detallecompra.codigo) ;

//exportar la tabla modificada e importar ala tabla de la bd nueva

//crear ventas

//para el detalle ventas realizar el mismo proceso quese hiso con el detalle de compras
UPDATE detalleventa SET 
producto_id = (SELECT id from productos WHERE codigo = detalleventa.codigo) ;

// crear pagos compras
// crear pagos ventas

// crear abonos_compras
// crear detalle abonos compras

//crear abonos ventas
//crear detalle abonos ventas