<!DOCTYPE html>

<?php $tienda = Tienda::find(Auth::user()->tienda_id); ?>
<?php $tema = Tema::whereUserId(Auth::user()->id)->first(); ?>
<?php $caja = Caja::whereUserId(Auth::user()->id)->get(); ?>

@include('partials.head')

<body style="display: block;" class="page-header-fixed page-sidebar-fixed page-footer-fixed">

    <div id="loading">
        <div class="loading-inner">
            <img src="img/loader/flat/3.gif" alt="..."/>
        </div>
    </div>

    <section id="wrapper">

    @if (Auth::user()->tienda->cajas)
        @if(Auth::user()->hasRole("Owner"))
            @include('partials.Owner.header')
            @include('partials.Owner.slidebar-left')
        @elseif(Auth::user()->hasRole("Admin"))
            @include('partials.Admin.header')
            @include('partials.Admin.slidebar-left')
        @elseif(Auth::user()->hasRole("User"))
            @include('partials.User.header')
            @include('partials.User.slidebar-left')
        @else
            @include('partials.Default.header')
            @include('partials.Default.slidebar-left')
        @endif
    @else
        @include('partials.SinCaja.header')
        @include('partials.SinCaja.slidebar-left')
    @endif


        <section id="page-content">
            <div id="loader">
                <div class="spinner flat"></div>
            </div>

            <div class="header-content">
                <h2> <span ><a href="javascript:void(0);" class="fa fa-home" style="font-size:22px;" onclick="ocultar_capas();"></a></span>
                <span id="home"></span></h2>
            </div>

            @include('partials.body-content')

            <footer class="footer-content">
                {{ getenv('COPYRING_YEAR') }} &copy;Created by GiSaJo.org<a href="javascript:void(0)" target="_blank">{{ getenv('AUTOR') }}</a>
            </footer>

        </section>

        @include('partials.slidebar-right')
    </section>


    <div id="back-top" class="animated pulse circle">
        <i class="fa fa-angle-up"></i>
    </div>

    <script src="js/main.js"></script>
    <script src="js/custom.js"></script>


    <script type="text/javascript">
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
    </script>

    <canvas id="barcode" style="display:none;"></canvas>

</body>

</html>
