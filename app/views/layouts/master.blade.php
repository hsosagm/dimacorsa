<!DOCTYPE html>
<html lang="en"> 

<?php $tienda = Tienda::find(Auth::user()->tienda_id); ?>
<?php $tema = Tema::where('user_id', Auth::user()->id)->first(); ?>

@include('partials.head')

<body style="display: block;" class="page-header-fixed page-sidebar-fixed page-footer-fixed">

    <div id="loading">
        <div class="loading-inner">
            <img src="img/loader/flat/3.gif" alt="..."/>
        </div>
    </div>

    <section id="wrapper">

       @include('partials.header')

       @include('partials.slidebar-left')

       <section id="page-content">

        <div id="loader"><div class="spinner flat"></div></div>

        <div class="header-content">

            <h2> <span ><a href="javascript:void(0);" class="fa fa-home" style="font-size:22px;" onclick="ocultar_capas();"></a></span>  
                <span id="home"></span></h2>
            </div>

            @include('partials.body-content')

            <footer class="footer-content"> 
                2015 &copy; {{$tienda->nombre}}. Created by <a href="javascript:void(0)">SOFTWARE.</a>
            </footer>

        </section>

        @include('partials.slidebar-right')

    </section>


    <div id="back-top" class="animated pulse circle">
        <i class="fa fa-angle-up"></i>
    </div>

    <div class="graficas_auxiliar" style="display:none"></div>

    <script src="js/vue.min.js"></script>
    <script src="js/main.js"></script>
    <script src="js/custom.js"></script>
    <script src="calendar/picker.js"></script>
    <script src="calendar/picker.date.js"></script>
    <script src="calendar/translations/es_ES.js"></script>
    <script type="text/javascript" src="js/qz/qz.js"></script>
    <script type="text/javascript" src="js/qz/html2canvas.js"></script>
    <script type="text/javascript" src="js/qz/jquery.plugin.html2canvas.js"></script>

    <script>
        $(document).ready(function(){
            /*configuracion del thema capturado de la base de datos*/ 
            $('link#theme').attr('href', 'css/themes/{{@$tema->colorSchemes}}.theme.css');
            $('.navbar-toolbar').attr('class', 'navbar navbar-toolbar navbar-{{@$tema->navbarColor}}');
            $('#sidebar-left').addClass('{{@$tema->sidebarTypeSetting}}');

            if($('#sidebar-left').hasClass('sidebar-box')){
                $('#sidebar-left').attr('class','sidebar-box sidebar-{{@$tema->sidebarColor}}');
            }
            else if($('#sidebar-left').hasClass('sidebar-rounded')){
                $('#sidebar-left').attr('class','sidebar-rounded sidebar-{{@$tema->sidebarColor}}');
            }
            else if($('#sidebar-left').hasClass('sidebar-circle')){
                $('#sidebar-left').attr('class','sidebar-circle sidebar-{{@$tema->sidebarColor}}');
            }
            else if($('#sidebar-left').attr('class') == ''){
                $('#sidebar-left').attr('class','sidebar-{{@$tema->sidebarColor}}');
            } 

            if($('#sidebar-left').hasClass('sidebar-default')){
                $('#sidebar-type-default').attr('checked','checked');
            }
            if($('#sidebar-left').hasClass('sidebar-box')){
                $('#sidebar-type-box').attr('checked','checked');
            }
            if($('#sidebar-left').hasClass('sidebar-rounded')){
                $('#sidebar-type-rounded').attr('checked','checked');
            }
            if($('#sidebar-left').hasClass('sidebar-circle')) {
                $('#sidebar-type-circle').attr('checked','checked');
            }
        }); 
</script>

<script>
    $(document.body).delegate(":input", "keyup", function(e) {
        if(e.which == 13) {
            $(this).trigger("enter");
        }
    });

    $(document).on("keydown",".input",function(event) {
        if (event.which === 13 || event.keyCode === 13) {
            var position = $(this).index('input');
            $("input, select").eq(position+1).select();
            event.preventDefault();
        }
    });

    $(document).on("keydown",".preventDefault",function(event) {
        if (event.which === 13 || event.keyCode === 13) {
            event.preventDefault();
        }
    });

    $('#date-input').datepicker();
</script>

<style>
  #wrapper {
    height: 100% !important;
}

#page-content {
    height: 100% !important;
}
</style>
    <canvas id="hidden_screenshot" style="display:none;"></canvas>
    <canvas id="barcode" style="display:none;"></canvas>
</body>
</html>