<!DOCTYPE html>

    <?php $tienda = Tienda::find(Auth::user()->tienda_id); ?>
    <!-- START @HEAD -->
    @include('cliente_partials.head')
    <!-- END @HEAD -->
    

    <body style="display: block;" class="page-header-fixed page-sidebar-fixed page-footer-fixed">

        <div id="loading">
            <div class="loading-inner">
                <img src="img/loader/flat/3.gif" alt="..."/>
            </div>
        </div>

        <section id="wrapper">

             <!--/ START HEADER -->
            @include('cliente_partials.header')
            <!--/ END HEADER -->

            <!-- /#sidebar-left -->
             @include('cliente_partials.slidebar-left')
            <!--/ END SIDEBAR LEFT -->

            <!-- START @PAGE CONTENT -->
            <section id="page-content">

                <!-- Start page header -->
                <div class="header-content">
                    <h2><i class="fa fa-home"></i> <span id="info_cliente"></span></h2>

                </div><!-- /.header-content -->
                <!--/ End page header -->

            @include('cliente_partials.body-content')

            @include('cliente_partials.footer')

            </section><!-- /#page-content -->
            <!--/ END PAGE CONTENT -->

            <!-- START @SIDEBAR RIGHT -->
            @include('cliente_partials.slidebar-right')
            <!-- END   @SIDEBAR RIGHT -->
            
        </section>


        <div id="back-top" class="animated pulse circle">
            <i class="fa fa-angle-up"></i>
        </div>

<script src="js/main.js"></script>
<script src="js/cliente.js"></script>
<script src="calendar/picker.js"></script>
<script src="calendar/picker.date.js"></script>
<script src="calendar/translations/es_ES.js"></script>


<script>

    $(document.body).delegate(":input", "keyup", function(e) {

        if (e.keyCode == 13 && e.shiftKey) {
            $(this).trigger("shift_enter");
            e.preventDefault();
        }
    });

    $(document).on("keydown",".focus_next_on_enter",function(event) {
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