@if(count(@$det_abonos) != null)
    <table width="100%"> 
        <thead>
            <tr>
                <th width="65%">Metodo</th>
                <th width="35%" style="text-align: center;">Monto</th>
                <th width="15%"> </th>
            </tr>
        </thead>
        <tbody> 
            <tr> 
                <td width="65%"> {{$det_abonos->metodo_pago->descripcion}} </td>
                <td width="30%" align="right"> {{@$det_abonos->total}} </td>
                <td width="15%">
                    <i class="fa fa-times pointer btn-link theme-c" onClick="EliminarDetalleAbono({{$det_abonos->id}},{{Input::get('compra_id')}})"></i>
                </td>
            </tr>  
        </tbody>
    </table>

@endif