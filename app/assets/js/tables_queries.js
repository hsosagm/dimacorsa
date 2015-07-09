$(function() {
    $(document).on("click", "#list_roles", function(){ list_roles(this); });
});

function list_roles() {
    $.get( "owner/roles", function( data ) {
        $("#full_width").html(data);
    });
}
