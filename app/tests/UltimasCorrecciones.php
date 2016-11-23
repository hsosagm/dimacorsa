<?php

// ChartController.php
// agregue esto para corregir el error en graficos - ventas

86    $data = [];
87    $ganancias = [];


// views - partials - controles - consultas
comente linea 11 (informe general)


// views - partials - controles - operaciones
comente ajuste de inventario
agregue
		@if(Auth::user()->hasRole("Owner"))
            <li id="users_list"><a href="javascript:void(0);">Usuarios</a></li>
		@endif


// views - user - index
modifique linea 27 Actualizar por modificar

// ProductoController linea 67
this $query = Producto::where('codigo', '=',Input::get('codigo'))->first();
x this $query = Producto::where('codigo', '=', $values)->first();