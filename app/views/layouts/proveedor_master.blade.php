<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
    <?php $tienda = Tienda::find(Auth::user()->tienda_id); ?>
    <?php  $tema = Tema::where('user_id', Auth::user()->id)->first(); ?>
    
    <!-- START @HEAD -->
    @include('proveedor_partials.head')
    <!-- END @HEAD -->
    

    <body style="display: block;" class="page-header-fixed page-sidebar-fixed page-footer-fixed">

        <div id="loading">
            <div class="loading-inner">
                <img src="img/loader/flat/3.gif" alt="..."/>
            </div>
        </div>

        <section id="wrapper">

             <!--/ START HEADER -->
            @include('proveedor_partials.header')
            <!--/ END HEADER -->

            <!-- /#sidebar-left -->
             @include('proveedor_partials.slidebar-left')
            <!--/ END SIDEBAR LEFT -->

            <!-- START @PAGE CONTENT -->
            <section id="page-content">

                <div id="loader"><div class="spinner flat"></div></div>
                
                <!-- Start page header -->
                <div class="header-content">
                        <h2><a href="/" class="fa fa-home" style="font-size:22px;" onclick="limpiar_home();"></a> <span v-html="infoProveedor"></span></h2>
                </div><!-- /.header-content -->
                <!--/ End page header -->

            @include('proveedor_partials.body-content')

            @include('proveedor_partials.footer')

            </section><!-- /#page-content -->
            <!--/ END PAGE CONTENT -->

            <!-- START @SIDEBAR RIGHT -->
            @include('proveedor_partials.slidebar-right')
            <!-- END   @SIDEBAR RIGHT -->
            
        </section>


        <div id="back-top" class="animated pulse circle">
            <i class="fa fa-angle-up"></i>
        </div>

<script src="js/vue.min.js"></script>
<script src="js/main.js"></script>
<script src="js/proveedor.js"></script>
<script src="calendar/picker.js"></script>
<script src="calendar/picker.date.js"></script>
<script src="calendar/translations/es_ES.js"></script>

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

    $('#ProviderFinder').autocomplete({
        serviceUrl: 'admin/proveedor/buscar',
        onSelect: function (q) {
            $('#ProviderFinder').val('');
            vm.proveedor_id = q.id;
            vm.infoProveedor = q.value;
            vm.getInfoProveedor(q.id);
        }
    });

    $(document.body).delegate(":input", "keyup", function(e) {

        if(e.which == 13) {
            $(this).trigger("enter");
        }

        if (e.keyCode == 13 && e.shiftKey) {
            $(this).trigger("shift_enter");
            e.preventDefault();
        }
    });

    $(document).on("keydown",".input",function(event) {
        if (event.which === 13 || event.keyCode === 13) {
            event.stopPropagation();
            var position = $(this).index('input');
            $("input, select").eq(position+1).select();
        }
    });

    $('#date-input').datepicker();

</script> 

    </body>

</html>