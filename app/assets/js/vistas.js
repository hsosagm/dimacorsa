	function cambiarVistaPuntoDeVenta (e) {
		$(e).prop('disabled', true);

		$.ajax({
			type: "POST",
			url: '/admin/vista/cambiarVistaPuntoDeVenta',
		}).done(function(data) {
			msg.success('Ingresando a Punto de Venta', 'Listo!');
			window.location.reload();
		});
	}

	function cambiarVistaAdministardor (e) {
		$(e).prop('disabled', true);
		$.ajax({
			type: "POST",
			url: '/admin/vista/cambiarVistaAdministardor',
		}).done(function(data) {
			msg.success('Ingresando a Vista Administrador!', 'Listo!');
			window.location.reload();
			return;
		});
	}

	function cambiarVistaPropietario (e) {
		$(e).prop('disabled', true);
		$.ajax({
			type: "POST",
			url: '/admin/vista/cambiarVistaPropietario',
		}).done(function(data) {
			msg.success('Ingresando a Vista Propietario', 'Listo!');
			window.location.reload();
		});
	}
