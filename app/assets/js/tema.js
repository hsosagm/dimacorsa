$('.color-schemes .theme').on('click',function() {
    var themename = $(this).find('.hide').text();
    if($('.page-sound').length) {
        ion.sound.play("camera_flashing_2");
    }
    $('link#theme').attr('href', 'css/themes/'+themename+'.theme.css');
    $.get( "user/tema/colorSchemes/"+themename, function( data ) {
        // msg.success(data, 'Listo!');
    });
});

$('.navbar-color .theme').on('click',function() {
    var classname = $(this).find('.hide').text();
    if($('.page-sound').length){
        ion.sound.play("camera_flashing_2");
    }
    $('.navbar-toolbar').attr('class', 'navbar navbar-toolbar navbar-'+classname);
    $.get( "user/tema/navbarColor/"+classname, function( data ) {
        // msg.success(data, 'Listo!');
    });
});

$('.sidebar-color .theme').on('click',function() {
    var classname = $(this).find('.hide').text();
    if($('.page-sound').length){
        ion.sound.play("camera_flashing_2");
    }
    if($('#sidebar-left').hasClass('sidebar-box')) {
        $('#sidebar-left').attr('class','sidebar-box sidebar-'+classname);
    }
    else if($('#sidebar-left').hasClass('sidebar-rounded')) {
        $('#sidebar-left').attr('class','sidebar-rounded sidebar-'+classname);
    }
    else if($('#sidebar-left').hasClass('sidebar-circle')) {
        $('#sidebar-left').attr('class','sidebar-circle sidebar-'+classname);
    }
    else if($('#sidebar-left').attr('class') == '') {
        $('#sidebar-left').attr('class','sidebar-'+classname);
    }
    $.get( "user/tema/sidebarColor/"+classname, function( data ) {
        // msg.success(data, 'Listo!');
    });
});
