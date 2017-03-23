<table width="100%" class="detalleProveedor">
    <thead>
        <tr>
            <td></td>
            <td> Proveedor 1 </td>
            <td> Proveedor 2 </td>
            <td> Proveedor 3 </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>Nombre:</td>
            <td>{{ @$prov1->nombre }}</td>
            <td>{{ @$prov2->nombre }}</td>
            <td>{{ @$prov3->nombre }}</td>
        </tr>
        <tr>
            <td>Telefono:</td>
            <td>{{ @$prov1->telefono }}</td>
            <td>{{ @$prov2->telefono }}</td>
            <td>{{ @$prov3->telefono }}</td>
        </tr>
        <tr>
            <td>Direccion:</td>
            <td>{{ @$prov1->direccion }}</td>
            <td>{{ @$prov2->direccion }}</td>
            <td>{{ @$prov3->direccion }}</td>
        </tr>
    </tbody>
</table>