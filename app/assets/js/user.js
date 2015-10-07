$(function() {
    $(document).on("click", "#profile", function(){ profile(this); });
    $(document).on("click", "#f_user_create", function(){ f_user_create(this); }); //rev
    $(document).on("click", "#add_user_group", function(){ add_user_group(this); });
    $(document).on("click", "#role_edit", function(){ role_edit(this); });
    $(document).on("click", "#users_list", function(){ users_list(); });
    $(document).on("click", "#logs_usuarios", function(){ logs_usuarios(this); });
    $(document).on("click", ".remove_role", function(e){ remove_role(e, this); });
    $(document).on("click", "#_edit_profile", function(){ _edit_profile(this); });
    $(document).on("submit", "form[data-remote-up]", function(e){ _update_profile(e,this); });
});


function logs_usuarios() {
    $.get( "owner/logs/usuarios", function( data ) {
        $('.table').html(data);
    });
};


function users_list() {
    $.get( "owner/users", function( data ) {
        makeTable(data, 'owner/user/', 'Usuario');
        $('#example').addClass('tableSelected');
    });
};


function role_edit(element) {
    $.ajax({
        type: "POST",
        url: "owner/roles/edit",
        data: {role_id: $(element).attr("role_id")},
        contentType: 'application/x-www-form-urlencoded',
        success: function (data, text) {
            $(".forms").html(data);
        }
    });
};


function profile() {
    $.get( "user/profile", function( data ) {
        $('.modal-body').html(data);
        $('.modal-title').text('Actualizar perfil');
        $('.bs-modal').modal('show');
    });
};

function _edit_profile() {
    $id  = $('.dataTable tbody .row_selected').attr('id');
    $url = $('.dataTable').attr('url') + 'edit';

    $.ajax({
        type: "POST",
        url: $url,
        data: {id: $id},
        contentType: 'application/x-www-form-urlencoded',
        success: function (data) {
            $('#modal-body-profile').html(data);
            $('#modal-title-profile').text( 'Editar ' + $('.dataTable').attr('title') );
            $('#bs-modal-profile').modal('show');
        }
    });
};

function _update_profile(e,element) {
    var form = $(element);
    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        success: function (data) {
            if (data == 'success') {
                msg.success(form.data('success'), 'Listo!');
            }
            else {
                msg.warning(data, 'Advertencia!');
            }
        }
    });

    e.preventDefault();
};

function f_user_create() {
    $.get( "owner/user/create", function( data ) {
        $(".forms").html(data);
    });
};

function add_user_group(element) {
    var id = $('.group_id option:selected').length;

    if (id === 0) {
        event.stopPropagation();
    }

    var form = $(element).closest("form");

    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        success: function (data) {
            $("#modal-body-profile").html(data);
            active_tab_roles();
        }
    });
};


function remove_role(e, element) {
    e.preventDefault();

    var form = $(element).closest("form");

    $.ajax({
        type: form.attr('method'),
        url: form.attr('action'),
        data: form.serialize(),
        success: function (data) {
            $("#modal-body-profile").html(data);
            active_tab_roles();
        }
    });
};

function active_tab_roles() {
   $("#tab-perfil-role").addClass('active');
   $("#tab-perfil-user").removeClass('active');
   $("#tab-informacion").removeClass('tab-pane fade active in');
   $("#tab-roles").addClass('tab-pane fade active in');
   $("#tab-informacion").addClass('tab-pane fade');
};
