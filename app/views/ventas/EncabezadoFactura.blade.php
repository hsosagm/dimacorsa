<div align="center">
	<div class="" width="750" height="" >
		<table border="0" width="750" id="table">

			<tbody height="390"  valign="top" style="font-size:13px;  height:340 !important;" >
				<tr height="35" > 
					<td width="70%"> </td>
					<td width="15%"></td>
					<td width="15%"></td>
				</tr >
				<tr height="25" > 
					<td width="70%">Nit: {{$venta->cliente->nit}} &nbsp;&nbsp;&nbsp;&nbsp; Fecha : {{ date('d-m-Y')}}</td>
					<td width="15%"></td>
					<td width="15%"></td>
				</tr >
				<tr height="25"> 
					<td colspan="3" width="100%"> 
						{{ $venta->cliente->nombre .' '.$venta->cliente->apellido}} &nbsp;&nbsp;&nbsp;&nbsp;
						{{ $venta->cliente->direccion}}
					</td>
				</tr>
				<tr height="30" > 
					<td width="70%"> </td>
					<td width="15%"></td>
					<td width="15%"></td>
				</tr >
				<tr>
					<td colspan="3" width="100%">
						<div style="height:300 !important; ">
							<table width="100%"	>
								<?php $total = 0; ?>