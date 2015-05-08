{{ Form::open(array('data-remote-md', 'data-success' => 'Venta Generada')) }}
    
    {{ Form::hidden('cliente_id') }}

    <div class="row">
        <div class="col-md-6 master-detail-info">
            <table class="master-table">
                <tr>
                    <td>Cliente:</td>
                    <td>
                        <input type="text" id="cliente_id"> 
                        <i class="fa fa-question-circle btn-link theme-c" id="cliente_help"></i>
                        <i class="fa fa-pencil btn-link theme-c" id="cliente_edit"></i>
                        <i class="fa fa-plus-square btn-link theme-c" id="cliente_create"></i>
                    </td>
                </tr>
                <tr>
                    <td>Factura No.: </td>
                    <td> <input type="text" name="numero_documento"> </td>
                </tr>

            </table>
        </div>
        <div class="col-md-6 search-cliente-info"></div>
    </div>

    <div class="form-footer" align="right">
          {{ Form::submit('Ok!', array('class'=>'theme-button')) }}
    </div>

{{ Form::close() }}


<div class="master-detail">
    <div class="master-detail-body"></div>
    {{ Form::hidden('venta_id') }}
</div>


<script>

$(function() {

    $("#cliente_id").autocomplete({
        source: function (request, response) {
            $.ajax({
                url: "user/cliente/buscar",
                dataType: "json",
                data: request,
                success: function (data) {
                    response(data);
                },
                error: function () {
                    response([]);
                }
            });
        },
        minLength: 3,
        select:function( data, ui ) {
            $("input[name='cliente_id']").val(ui.item.id);
            $(".search-cliente-info").html('<strong>Direccion:  '+ui.item.descripcion+'</strong><br><strong>Contacto:   '+ui.item.value+'</strong>');

        },
        autoFocus: true,
        open: function(event, ui) {
            $(".ui-autocomplete").css("z-index", 100000);
        }
    });
});

</script>