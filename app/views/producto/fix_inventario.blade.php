<div class="panel-body">
    <table class="master-table table-detail-existencia">
        <thead>
            <tr>
                <th>producto_id</th>
                <th>codigo</th>
                <th>descripcion</th>
                <th>existencia</th>
                <th>p costo</th>
            </tr>
        </thead>
        <tbody>
            @foreach($query as $key => $data)
            <tr>
                <td width="30%">{{ $data->producto_id }}</td>
                <td width="30%">{{ $data->codigo }}</td>
                <td width="30%">{{ $data->descripcion }}</td>
                <td width="30%">{{ $data->existencia }}</td>
                <td width="30%">{{ $data->p_costo }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<style type="text/css">

    .bs-modal .Lightbox{
        width: 650px !important;
    }

    .panel-title-existencia p{
        margin-left: 10px
    }

    .panel-body-existencia{
        padding: 0px;
        margin:0px;
    }

    .table-detail-existencia  thead tr th {
        font-size: 10px;
        line-height: 100%;
        padding-left: 5px !important;
        background: #FBFBFB !important;
    }

     .table-detail-existencia  tbody tr td {
        font-size: 12px;
        padding-left: 5px !important;
    }

    .table-detail-existencia{
        background: white;
        width: 100% !important;
    }

    .table-detail-existencia td{
        margin-left: 15px !important;
    }

    .table-detail-existencia {
        margin-top: 10px;
        padding-top: 5px;
        /*border: 1px solid #C5C5C5;*/

    }
</style>