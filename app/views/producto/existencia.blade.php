
    <div class="row">
        <div class="col-md-1"> </div>
        <div class="col-md-4"> {{$info->codigo}}</div>
        <div class="col-md-7">Existencia Total: {{$info->existencia}}</div>
    </div>
    <div class="row">
       <div class="col-md-1"> </div>
       <div class="col-md-11">{{$info->descripcion}}</div> 
   </div>

<div class="panel-body">
    <table class="master-table table-detail-existencia">
        <thead>
            <tr>
                <th>Tienda</th>
                <th>Existencia</th>
                <th align="center">Direccion</th>
            </tr>
        </thead>
        <tbody>
            @foreach($Query as $key => $data)
            <tr>
                <td width="30%">{{ $data->tienda }}</td>
                <td width="30%">{{ $data->existencia }}</td>
                <td width="40%">{{ $data->direccion }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
</div>
<style type="text/css">
    
    .bs-modal .Lightbox{
        width: 400px !important;
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