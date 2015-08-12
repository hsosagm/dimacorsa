<?php 
    $tiendas = array();
    $tienda = Tienda::select('id','nombre','direccion')->where('id','!=',Auth::user()->tienda_id)->get();
    foreach ($tienda as $td) {
        $tiendas["{$td->id}"] = $td->nombre .' '. $td->direccion; 
    }
 ?>
{{ Form::open(array('data-remote-md', 'data-success' => 'Traslado Generado' ,"onsubmit"=>" return false")) }}
<div class="row info_head">
    <div class="col-md-6 master-detail-info">
        <table class="master-table">
            <tr>
                <td>Tienda Destino:</td>
                <td align="left">
                     {{ Form::select('tienda_id_destino', $tiendas ,'', array('class'=>'form-control')) }}
                </td>
            </tr>
        </table>
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8">
                <textarea name="nota" placeholder="Nota....!" style="height: 36px;" class="form-control"></textarea>
            </div>
            <div class="col-md-2"></div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="row">
            <div class="col-md-12 search-tienda-info"> </div>
        </div>
    </div>
</div>


<div class="form-footer" align="right">
    {{ Form::submit('Ok!', array('class'=>'theme-button')) }}
</div>

{{ Form::close() }}
<div class="master-detail"> 
    <div class="master-detail-body"></div>
</div>         
            