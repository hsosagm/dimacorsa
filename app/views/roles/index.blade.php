<script>
$(document).ready(function() {   

    $('.divider').text("/");
    $('.bread-current').text("Roles de usuarios");
    $('.q_cont').hide();
    $(".full_width").html("");
    $("#tablesearch").html("");

    var table = '<table class="display table-striped table-hover" id="example"><tbody style="background: #FFF;">';
    table += '<tr>';
    table += '<td style="font-size: 14px; color:#1b7be2;" colspan="7" class="dataTables_empty">Cargando datos del servidor...</td>';
    table += '</tr>';
    table += '</tbody></table>';
    $('#full_width').html(table);
    setTimeout(function(){
        $("#buscar_ID_DT").focus();
        $('#example_length').prependTo("#tablesearch");
        $('.q_cont').show();
        oTable = $('#example').dataTable();
        $('#buscar_ID_DT').keyup(function(){
        oTable.fnFilter( this.value, oTable.oApi._fnVisibleToColumnIndex( 
        oTable.fnSettings(), $("#buscar_ID_DT input").index(1) ) );
        })
    }, 300); 

    $('#example').dataTable({
        "bAutoWidth": false,
        aoColumns: [
            { "sTitle": "Nombre", "sWidth": "40%"},
            { "sTitle": "No de usuarios", "sWidth": "20%" },
            { "sTitle": "Creado en", "sWidth": "20%" },
            { "sTitle": "Actions", "sWidth": "20%" },

        ],
        "iDisplayLength": 10,
        "aLengthMenu": [[10, 20, 25, 50, -1], [10, 20, 25, 50, "All"]],
        "bJQueryUI": false,
        "sPaginationType": "full_numbers",
        "bProcessing": true,
        "bServerSide": true,
        "sAjaxSource": "owner/roles/search",


        "fnRowCallback": function( nRow ) {
            $('td:eq(0)', nRow).css('text-align', 'left');
            $('td:eq(1)', nRow).css('text-align', 'center');
            $('td:eq(2)', nRow).css('text-align', 'center');
            $('td:eq(3)', nRow).css('text-align', 'right');
        }
    });
  });  
</script>