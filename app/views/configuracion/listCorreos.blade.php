@if(count(@$correos) > 0)
<table class="table" width="100%">
    <thead>
        <tr>
            <th width="74%">Correo</th>
            <th width="26%">Notificacion</th>
            <th width="5%"> </th>
        </tr>
    </thead>
    <tbody>
        @foreach(@$correos as $correo)
        <tr>
            <td width="75%"> {{ $correo->correo }} </td>
            <td width="25%"> {{ $correo->notificacion }} </td>
            <td width="5%"> 
                <i id="{{ $correo->id }}" href="admin/configuracion/eliminarNotificacion" class="fa fa-trash-o pointer btn-link theme-c" onClick="DeleteDetalle(this);"></i>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endif
