<div id="gastos" style="padding-right: 40px">
    <form v-on="submit: submit" class="form-horizontal" id="gastosForm">
        <div class="form-group" style="padding-bottom: 20px">
            <label class="col-sm-2" for="email">Categoria:</label>
            <div class="col-sm-3">
                {{ Form::select('categoria_id', categoriasGasto::lists('nombre', 'id') ,'', array('class'=>'form-control', 'v-model'=>'categoria', 'id'=>'categoria')) }}
            </div>
            <div class="col-sm-1"> </div>
            <label class="col-sm-2" for="email">Subcategoria:</label>
            <div class="col-sm-3">
                {{ Form::select('subcategoria_id', subcategoriasGasto::lists('nombre', 'id') ,'', array('class'=>'form-control', 'v-model'=>'subcategoria', 'id'=>'subcategoria')) }}
            </div>
        </div>

        <div>
            <div class="form-group">
                <div class="col-lg-7">Descripcion:</div>
                <div class="col-lg-2">Monto:</div>
                <div class="col-lg-2">Metodo de Pago:</div>
            </div>

            <div class="form-group">
                <div class="col-lg-7">
                    <input id="descripcion" type="text" class="form-control input" autocomplete="off">
                </div>
                <div class="col-lg-2">
                    <input id="monto" type="text" class="form-control numeric" autocomplete="off">
                </div>
                <div class="col-lg-2">
                 {{ Form::select('metodo_pago_id', MetodoPago::where('id','!=',2)->where('id','!=',6)->where('id','!=',7)
                 ->lists('descripcion', 'id') ,'', array('class'=>'form-control', 'id'=>'metodo_pago_id')) }}
                </div>
                <div class="col-lg-1" style="padding-top: 5px">
                    <button v-on="click: agregar" type="button" class="btn theme-button"><i class="fa fa-check"></i></button>
                </div>
            </div>
        </div>

        <div class="master-detail-body2">
            <table>
                <tbody v-repeat="dt: detalle">
                <tr>
                    <td width="40%">@{{ dt.categoria }}</td>
                    <td width="40%">@{{ dt.subcategoria }}</td>
                </tr>
                <tr>
                    <td width="70%">@{{ dt.descripcion }}</td>
                    <td width="13%">@{{ dt.monto }}</td>
                    <td width="13%">@{{ dt.metodo_pago }}</td>
                    <td width="4%">
                        <i v-on="click: removeGasto($index)" class="fa fa-trash-o pointer btn-link theme-c"></i>
                    </td>
                </tr>
            </tbody>
            </table>
        </div>

        <div class="form-group" style="text-align:right; padding-top: 30px">
            <div class="col-sm-12">
                <button type="submit" class="btn theme-button" style="height: 30px">Finalizar</button>
            </div>
        </div>
    </form>
</div>

<script type="text/javascript">
    $('.numeric').autoNumeric({aSep:',', aNeg:'', mDec:2, mRound:'S', vMax: '999999.99', wEmpty: 'zero', lZero: 'deny', mNum:10});
</script>

<style type="text/css">
    .bs-modal .Lightbox{
        width:900px !important;
      }
    .master-detail-body2 {
        padding-left: 10px;
        width: 95%;
    }
</style>

<script type="text/javascript">
var gastos = new Vue({

    el: '#gastos',

    data: {
        categoria: '',
        subcategoria: '',
        detalle: [],
    },

    methods: {
        agregar: function() {
            if (!this.categoria)
                return msg.warning('Seleccione una categoria', 'Advertencia!')

            if (!this.subcategoria)
                return msg.warning('Seleccione una subcategoria', 'Advertencia!')

            let monto = parseFloat($('#monto').autoNumeric('get')).toFixed(2)
            let descripcion = $("#descripcion").val()
            descripcion = descripcion.replace(/\s\s+/g, ' ')

            if (descripcion.length < 5)
                return msg.warning('La descripcion debe contener al menos 5 caracteres', 'Advertencia!')

            if (monto < 1)
                return msg.warning('El monto debe ser mayor o igual a 1', 'Advertencia!')

            this.detalle.push({
                categoria: $("#categoria option:selected").text(),
                subcategoria: $("#subcategoria option:selected").text(),
                categoria_id: this.categoria,
                subcategoria_id: this.subcategoria,
                descripcion: descripcion,
                monto: monto,
                metodo_pago: $("#metodo_pago_id option:selected").text(),
                metodo_pago_id: $("#metodo_pago_id").val(),
            })

            this.categoria = ''
            this.subcategoria = ''
            $('#monto').autoNumeric('set', 0)
            $("#descripcion").val('')
        },

        removeGasto: function(index)
        {
            this.detalle.$remove(index)
        },

        submit: function(e)
        {
            e.preventDefault()

            if (!this.detalle.length)
                return msg.warning('Debe ingresar por lo menos un gasto', 'Advertencia!')

            var form = $('#gastosForm')
            $('button[type=submit]', form).prop('disabled', true)

            $.ajax({
                type: 'POST',
                url: 'user/gastos/save',
                data: { detalle: this.detalle },
            }).done(function(data) {
                if (!data.success) {
                    $('button[type=submit]', form).prop('disabled', false)
                    return msg.warning(data.msg, 'Advertencia!')
                }

                $( '#gastos' ).empty()
                $('.bs-modal').modal('hide')
                return msg.success(data.msg, 'Listo!')
            })
        }
    }
});
</script>
