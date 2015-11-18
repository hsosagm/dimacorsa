<table class="DT_table_div" width="100%">
    <tr>
        <td class="center" width="16%">Compras</td>
        <td class="center" width="16%">Ventas</td>
        <td class="center" width="16%">Descargas</td>
        <td class="center" width="16%">Traslados</td>
        <td class="center" width="16%">Esperado</td>
        <td class="center" width="16%">Real</td>
    </tr>

	<tbody>
        <tr>
            <td class="right"> {{ f_num::get($infInv->compras)   }} </td>
            <td class="right"> {{ f_num::get($infInv->ventas)    }} </td>
            <td class="right"> {{ f_num::get($infInv->descargas) }} </td>
            <td class="right"> {{ f_num::get($infInv->traslados) }} </td>
            <td class="right"> {{ f_num::get($infInv->esperado)  }} </td>
            <td class="right"> {{ f_num::get($infInv->real)      }} </td>
        </tr>
	</tbody>
</table>