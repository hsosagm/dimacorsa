/* Consultas.js */
function getMasterQueries() {
    $('.dt-container').hide();
    $('.table').html("");

    $.ajax({
      url: "admin/queries/getMasterQueries",
      type: "GET"
    }).done(function(data) {
        if (data.success == true) {
            $("#table_length").html("");
            $( ".DTTT" ).html("");
            $('.table').html(data);
            $('.dt-panel').show();
            $('.dt-container').show();
            $('.table').html(data.view);
        }
    });
}

$('[data-action=collapse_head]').click(function(){
    var targetCollapse = $(this).parents('.panel').find('.HeadQueriesContainer');
    if (targetCollapse) {
        if((targetCollapse.is(':visible'))) {
            $(this).find('i').removeClass('fa-angle-up').addClass('fa-angle-down');
            targetCollapse.slideUp();
        }else{
            $(this).find('i').removeClass('fa-angle-down').addClass('fa-angle-up');
            targetCollapse.slideDown();
        }
    }
});
