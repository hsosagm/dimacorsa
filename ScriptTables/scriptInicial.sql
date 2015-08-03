
INSERT INTO `tiendas` (`id`, `nombre`, `direccion`, `telefono`, `status`, `created_at`, `updated_at`) VALUES (1, 'Empresa', 'Direccion', '000000', 1, '2015-02-16 23:23:05', '2015-02-16 23:23:05');

INSERT INTO `permissions` (`id`, `name`, `display_name`, `created_at`, `updated_at`) VALUES
(1, 'manage_productos', 'Manage productos', '2015-02-16 17:25:17', '2015-02-16 17:25:17'),
(2, 'manage_users', 'Manage Users', '2015-02-16 17:25:17', '2015-02-16 17:25:17');

INSERT INTO `roles` (`id`, `name`, `created_at`, `updated_at`) VALUES (1, 'Owner', '2015-02-16 17:25:17', '2015-02-16 17:25:17'), (2, 'Admin', '2015-02-16 17:25:17', '2015-02-16 17:25:17'), (3, 'User', '2015-02-16 17:25:17', '2015-02-16 17:25:17');

INSERT INTO `permission_role` (`id`, `permission_id`, `role_id`) VALUES (1, 1, 1),(2, 2, 1),(3, 1, 2);

INSERT INTO `users` (`id`, `tienda_id`, `username`, `nombre`, `apellido`, `email`, `password`, `status`, `remember_token`, `created_at`, `updated_at`) VALUES (1, 1, 'admin', 'Administrador', 'Sistema', 'admin@empresa.com', '', 1, NULL, '2015-02-16 17:23:13', '2015-02-16 17:23:13')

INSERT INTO `assigned_roles` (`id`, `user_id`, `role_id`) VALUES (1, 1, 1);

INSERT INTO `precio_venta` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Base', '2015-06-03 14:35:48', '2015-06-03 14:35:48');

INSERT INTO `tipo_cliente` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Consumidor Final', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

INSERT INTO `metodo_pago` (`id`, `descripcion`, `created_at`, `updated_at`) VALUES
(1, 'Efectivo', '2015-02-16 23:23:05', '2015-02-16 23:23:05'),(2, 'Credito', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Cheque', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), (4, 'Tarjeta', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(5, 'Deposito', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

INSERT INTO `precio_venta` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Base', '2015-06-03 14:35:48', '2015-06-03 14:35:48');

INSERT INTO `tipo_cliente` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'Consumidor Final', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

INSERT INTO `soporte_estados` (`id`, `estado`, `created_at`, `updated_at`) VALUES
(1, 'Espera', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), (2, 'Proceso', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(3, 'Finalizado', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), (4, 'Entregado', '0000-00-00 00:00:00', '0000-00-00 00:00:00'), (5, 'Pendiente', '0000-00-00 00:00:00', '0000-00-00 00:00:00');

INSERT INTO `kardex_transaccion` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'compras', '2015-07-31 18:02:58', '2015-07-31 18:02:58'), (2, 'ventas', '2015-07-31 18:02:58', '2015-07-31 18:02:58'),
(3, 'descargas', '2015-07-31 18:02:58', '2015-07-31 18:02:58'), (4, 'traslados', '2015-07-31 18:02:58', '2015-07-31 18:02:58');

INSERT INTO `kardex_accion` (`id`, `nombre`, `created_at`, `updated_at`) VALUES
(1, 'insert', '2015-07-31 18:02:58', '2015-07-31 18:02:58'), (2, 'update', '2015-07-31 18:02:58', '2015-07-31 18:02:58'),
(3, 'delete', '2015-07-31 18:02:58', '2015-07-31 18:02:58');