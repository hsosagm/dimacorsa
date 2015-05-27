{{ Form::open(array('data-remote-md', 'data-success' => 'Venta Generada')) }}
    
    {{ Form::hidden('cliente_id') }}

    <div class="row">
        <div class="col-md-6 master-detail-info">
            <table class="master-table">
                <tr>
                    <td>Cliente:</td>
                    <td>
                        <input type="text" id="cliente_id" class="input"> 
                        <i class="fa fa-question-circle btn-link theme-c" id="cliente_help"></i>
                        <i class="fa fa-pencil btn-link theme-c" id="cliente_edit"></i>
                        <i class="fa fa-plus-square btn-link theme-c" id="cliente_create"></i>
                    </td>
                </tr>
                <tr>
                    <td>Factura No.: </td>
                    <td> <input type="text" name="numero_documento" class="input"> </td>
                </tr>

            </table>
        </div>
        <div class="col-md-6 search-cliente-info"></div>
    </div>

    <div class="form-footer" align="right">
          <button type="submit" class="theme-button">Ok!</button>
    </div>

{{ Form::close() }}


<div class="master-detail">
    <div class="master-detail-body"></div>
</div>


<script>

    $('#cliente_id').autocomplete({

        serviceUrl: '/user/cliente/buscar',

        onSelect: function (q) {
           $t = q.id;
        }

    });

</script>