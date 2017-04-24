<li class="submenu">
	<a href="javascript:void(0);">
		<span class="icon"><i class="fa fa-columns"></i></span>
		<span class="text">Operaciones</span>
		<span class="plus"></span>
	</a>
	<ul>
		<li><a id="f_com_op" href="javascript:void(0)"><i class="fa fa-shopping-cart"></i> Compra</a></li>
		<li><a href="javascript:void(0)" onclick="f_coti_op();"><i class="fa fa-list-ol"></i> Cotizacion</a> </li>
		<li><a href="javascript:void(0)" onclick="fopen_descarga();"><i class="fa fa-download"></i> Descarga</a></li>
		{{-- <li><a href="javascript:void(0)" onclick="fopen_traslado();"><i class="fa fa-exchange"></i> Traslado</a></li> --}}
		{{-- <li><a href="javascript:void(0)" onclick="fopen_kit();"><i class="fa fa-exchange"></i> Crear combo</a></li> --}}
		{{-- <li><a href="javascript:void(0)" onclick="historial_kits();"><i class="fa fa-exchange"></i> Historial de combos</a></li> --}}

		@if(Auth::user()->hasRole("Owner"))
            <li id="users_list"><a href="javascript:void(0);"><i class="fa fa-users"></i> Usuarios</a></li>
		@endif

		<li><a href="javascript:void(0);" onclick="inventario();">Ajuste de inventario</a></li>
	</ul>
</li>
