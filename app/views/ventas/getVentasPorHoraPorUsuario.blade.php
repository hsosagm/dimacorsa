
<table id="example" class="display" width="100%" cellspacing="0">
    <thead>
        <tr id="hhh">
            <th>Fecha</th>
            <th>Usuario</th>
            <th>Total Ventas</th>
            <th>Total Utilidad</th>
            <th> % </th>
            <th>     </th>
        </tr>
    </thead>

    <tbody>
        @foreach($ventas as $q)
            <tr class="" id="{{$q->id}}">
                <td class="" width="20%"> {{ $q->fecha }} </td>
                <td class="" width="30%"> {{ $q->usuario }} </td>
                <td class="right" width="15%"> {{ f_num::get($q->total) }} </td>
                <td class="right" width="15%"> {{ f_num::get($q->utilidad) }} </td>
                <td class="right" width="15%"> %{{ f_num::get(($q->utilidad * 100 )/ $q->total )}} </td>
                <td class="center" width="5%">
                    <i id="{{$q->id}}" class="fa fa-plus-square btn-link theme-c" onClick="" ></i>
                </td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr>
            <td colspan="6"></td>
        </tr>
    </tfoot>
</table>

<script type="text/javascript">
    graph_container_compile();
</script>
