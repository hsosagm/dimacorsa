
$(document).ready(function(){

    // =========================================================================
    // LOADING
    // =========================================================================
    if($('#sign-wrapper').length){
        $('#sign-wrapper').jpreLoader({
                loaderVPos: '50%',
                autoClose: true
            },
            function() {
                $('#loading').fadeOut('fast');
                $('#sign-wrapper').animate({'opacity':'1'},{queue:false,duration:700,easing:'easeInOutQuad'});
                $('form').addClass('animated zoomIn');
                $('.sign-link').addClass('animated fadeinup');
            });
    }


    // =========================================================================
    // FORM VALIDATION
    // =========================================================================
    if($('.sign-in').length && $(window).width() >= 1024){

        $('.sign-in').validate(
            {
                invalidHandler:
                    function() {

                    },
                rules:{
                    username: {
                        required: true
                    },
                    password: {
                        required: true
                    }
                },
                messages: {
                    username: {
                        required: "El nombre de usuario es requerido"
                    },
                    password: {
                        required: "El password es requerido"
                    }
                },
                highlight:function(element) {
                    $(element).parents('.form-group').addClass('has-error has-feedback');
                },
                unhighlight: function(element) {
                    $(element).parents('.form-group').removeClass('has-error');
                },
                submitHandler: function(form){
                    var btn = $('#login-btn');
                    btn.html('Checking ...');
                    btn.attr('disabled', 'disabled');
                    $('.fa').removeClass("err");

                    $username   = $("input[name='username']").val();
                    $password   = $("input[name='password']").val();
                    $rememberme = $("input[name='rememberme']").prop("checked");

                    $.ajax({
                        type: "POST",
                        url: "index",
                        data: {username: $username, password: $password, rememberme: $rememberme},
                        contentType: 'application/x-www-form-urlencoded',
                        success: function (data) {
                            if (data == 'success')
                            {
                                setTimeout(function() {
                                    btn.text('Log In');
                                    msg.success(" ", "Usuario logeado correctamente");
                                }, 1000);

                                setTimeout(function () {
                                    btn.removeAttr('disabled');
                                    window.location.href="/";
                                }, 2000);
                            }

                            else if (data == 0) {
                                setTimeout(function() {
                                    btn.removeAttr('disabled');
                                    btn.html('Sing In');
                                    msg.error('El usuario ingresado se encuentra inactivo');
                                    $('.fa').addClass("err");
                                    $('#sign-wrapper').addClass('animated shake');
                                    setTimeout(function(){$('#sign-wrapper').removeClass('animated shake')}, 1500);
                                }, 1000);
                            }

                            else if(data == 1) {
                                setTimeout(function() {
                                    btn.removeAttr('disabled');
                                    btn.html('Sing In');

                                    var validator = $( ".sign-in" ).validate();
                                    validator.showErrors({
                                    "username": "El nombre de usuario no es valido!"
                                    });

                                    $('.fa-user').addClass("err");
                                    $('#sign-wrapper').addClass('animated shake');
                                    setTimeout(function(){$('#sign-wrapper').removeClass('animated shake')}, 1500);
                                }, 1000);
                            }

                            else if(data == 2) {
                                setTimeout(function() {
                                    btn.removeAttr('disabled');
                                    btn.html('Sing In');

                                    var validator = $( ".sign-in" ).validate();
                                    validator.showErrors({
                                    "password": "El password no es valido!"
                                    });

                                    $('.fa-lock').addClass("err");
                                    $('#sign-wrapper').addClass('animated shake');
                                    setTimeout(function(){$('#sign-wrapper').removeClass('animated shake')}, 1500);
                                }, 1000);
                            }
                        },
                        error: function (request, status, error) {
                            alert(request.responseText);
                            btn.removeAttr('disabled');
                        }
                    });
                }
            }
        );
    }

    // =========================================================================
    // SETTING HEIGHT
    // =========================================================================
    $('#sign-wrapper').css('min-height',$(window).outerHeight());

});