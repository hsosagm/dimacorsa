
{{ Form::open(array('data-remote-md-2', 'data-success' => $message, 'method' =>'post', 'role'=>'form', 'class' => 'form-horizontal')) }}

    <input name="{{$name}}" value="{{$id}}" type="text" class="hide">

    <div class="form-group">
         <div class="col-lg-4"> 
            Descripcion:
        </div>

        <div class="col-lg-3"> 
            Monto:
        </div>

        <div class="col-lg-3">  
            Metodo de Pago:
        </div>

        <div class="col-lg-1">

        </div>
    </div>
    
    <div class="form-group">
         <div class="col-lg-4"> 
            <input name="descripcion" type="text" class="form-control" autocomplete="off">
        </div>

        <div class="col-lg-3"> 
            <input name="monto" type="text" class="form-control" autocomplete="off">
        </div>

        <div class="col-lg-3">                               
        
         {{Form::select('metodo_pago_id', MetodoPago::lists('descripcion', 'id'),'', array('class'=>'form-control'));}}
         
        </div>

        <div class="col-lg-1">
            <input autocomplete="off" class="btn theme-button" value="Guardar!" type="submit">
        </div>
    </div>

    <div class="master-detail-body2">
    </div>

    <div class="modal-footer">

        <button class="btn btn-default" data-dismiss="modal" type="button">Cerrar!</button>

        <button class="btn btn-warning" id="delete_gasto" type="button">Eliminar!</button>

    </div>

{{ Form::close() }}

<style type="text/css">

.master-detail-body2 {
    max-height: 150px !important;
    height: 150px !important;*/
    overflow-x: hidden;
    overflow-y: scroll;
    width: 100%;
    padding: 0px 0px 0px 0px !important;
    margin: 0px 0px 0px 0px !important;
    background: white;
}
    
</style>