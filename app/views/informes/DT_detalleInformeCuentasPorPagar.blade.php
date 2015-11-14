<table class="DT_table_div" width="100%">
    <tr>
        <td class="center" width="16%">Creditos</td>
        <td class="center" width="16%">Abonos</td>
        <td class="center" width="16%">Esperado</td>
        <td class="center" width="16%">Real</td>
    </tr>

	<tbody>
        <tr>
            <td class="right"> {{ f_num::get($infInv->creditos)   }} </td>
            <td class="right"> {{ f_num::get($infInv->abonos)    }} </td>
            <td class="right"> {{ f_num::get($infInv->esperado)  }} </td>
            <td class="right"> {{ f_num::get($infInv->real)      }} </td>
        </tr>
	</tbody>
</table>