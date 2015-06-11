
	{{ $contacto->direccion }} <br>
	{{ $contacto->telefono1.'  ' }}
	{{ $contacto->telefono2.'  ' }}
	{{ $contacto->celular }}<br>
	@if($contacto->correo != '')
		{{ $contacto->correo }}
	@endif
