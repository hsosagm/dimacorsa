@if(count(@$det_abonos) > 0)
    <table width="100%"> 
        <thead>
            <tr>
                <th width="65%">Metodo</th>
                <th width="35%" style="text-align: center;">Monto</th>
                <th width="15%"> </th>
            </tr>
        </thead>
        <tbody> 
            @foreach (@$det_abonos as $key => $det) 
            <tr> 
                <td width="65%"> {{$det->metodo_pago->descripcion}} </td>
                <td width="30%" align="right"> {{@$det->monto}} </td>
                <td width="15%">
                    <i class="fa fa-times pointer btn-link theme-c" onClick="EliminarDetalleAbono({{$det->id}},{{Input::get('compra_id')}})"></i>
                </td>
            </tr>  
            @endforeach   
        </tbody>
    </table>

@endif