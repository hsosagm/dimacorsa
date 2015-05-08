$(function() {
    $(document).on('click', '#f_adelantos', function(){ f_adelantos(this); });
});


function f_adelantos() {
    $('.divider').text("/");
    $('.bread-current').text("Adelantos");
    $('.q_cont').hide();
    $(".forms").html("");

    $.get( "user/form/adelantos", function( data ) {
        $(".forms").html(data);
    });
}