{{ Form::open(array('data-chart', 'data-success' => 'Soporte por fecha')) }}

    <div class="row" style="height: 275px;">

        <div class="master-detail-info">

            <table class="master-table short_calendar" style="margin-top: 20px; margin-left: 20px;">
                <tr>
                    <td>Seleccionar fecha inicio:</td>
                    <td><input type="text" name="start"></td>
                    <td>Seleccionar fecha final:</td>
                    <td><input type="text" name="end"></td>
                </tr>
            </table>
        </div>

        <div class="col-md-6 search-proveedor-info">  </div>

    </div>

    <div class="form-footer" align="right">
        {{ Form::submit('Ok!', array('class'=>'theme-button')) }}
    </div>

{{ Form::close() }}


<script>

    var counter = 2;

    var $start = $('form[data-chart] input[name="start"]').pickadate(
    {
        selectYears: true,
        selectMonths: true,
        min: [<?php echo $first->year ?>, <?php echo $first->month - 1 ?>, <?php echo $first->day ?>],
        max: true,
        formatSubmit: 'yyyy/m',
        hiddenName: true,
        onSet: function() {
            $('.short_calendar .picker__table').css('display', 'none'); 
            if (counter == 2) {
                counter = 0;
                picker_start.set('select', picker_start.get('highlight'));
            };
            counter++;
        },
        onClose: function(element) {
            counter = 2;
            picker_end.set('min', picker_start.get('highlight'));
            if ( $('form[data-chart] input[name="start"]').val() != "") {
                picker_end.open();
            }
        }
    });

    var picker_start = $start.pickadate('picker');

    var $end = $('form[data-chart] input[name="end"]').pickadate(
    {
        selectYears: true,
        selectMonths: true,
        max: true,
        formatSubmit: 'yyyy/m',
        hiddenName: true,
        onSet: function() {
            $('.short_calendar .picker__table').css('display', 'none');
            if (counter == 2) {
                counter = 0;
                picker_end.set('select', picker_end.get('highlight'));
            };
            counter++;
        },
    });

    var picker_end = $end.pickadate('picker');

    $('.short_calendar .picker__table').css('display', 'none');

</script>