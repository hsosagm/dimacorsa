<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->

    <!-- START @HEAD -->
    @include('partials.head')
    <!-- END @HEAD -->
    

    <body class="page-header-fixed page-sidebar-fixed">

        <div id="loading">
            <div class="loading-inner">
                <img src="img/loader/flat/3.gif" alt="..."/>
            </div>
        </div>

        <section id="wrapper">

             <!--/ START HEADER -->
            @include('partials.header')
            <!--/ END HEADER -->

            <!-- /#sidebar-left -->
             @include('partials.slidebar-left')
            <!--/ END SIDEBAR LEFT -->

            <!-- START @PAGE CONTENT -->
            <section id="page-content">

                <!-- Start page header -->
                <div class="header-content">
                    <h2><i class="fa fa-home"></i> <span>Inventario</span></h2>

{{--                     <div class="breadcrumb-wrapper hidden-xs">
                        <ol class="breadcrumb">
                            <a id="f_com_op" href="javascript:void(0);">
                                <ol class="breadcrumb">
                                    <li class="active">Compras</li>
                                </ol>
                            </a>
                        </ol>
                        <ol class="breadcrumb">
                            <a class="f_ven_op" href="javascript:void(0);">
                                <ol class="breadcrumb">
                                    <li class="active">Ventas</li>
                                </ol>
                            </a>
                        </ol>
                    </div> --}}

                </div><!-- /.header-content -->
                <!--/ End page header -->

            @include('partials.body-content')
    
                <!-- Start footer content -->
                <footer class="footer-content">
                    2015 &copy; Click admin. Created by <a href="javascript:void(0)" target="_blank">Hsosa</a>, GM
                </footer><!-- /.footer-content -->
                <!--/ End footer content -->

            </section><!-- /#page-content -->
            <!--/ END PAGE CONTENT -->

            <!-- START @SIDEBAR RIGHT -->
            @include('partials.slidebar-right')
            <!-- END   @SIDEBAR RIGHT -->
            
        </section>


        <div id="back-top" class="animated pulse circle">
            <i class="fa fa-angle-up"></i>
        </div>

<script src="js/main.js"></script>
<script src="calendar/picker.js"></script>
<script src="calendar/picker.date.js"></script>
<script src="calendar/translations/es_ES.js"></script>


<script>

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

    $.ui.autocomplete.prototype._renderItem = function (ul, item) {
        var term = this.term.split(' ').join('|');
        var re = new RegExp("(" + term + ")", "gi");
        var t = item.label.replace(re, "<b class='hiligth'>$1</b>");
        return $("<li></li>")
        .data("item.autocomplete", item)
        .append("<a>" + t + "</a>")
        .appendTo(ul);
    };

    $('#date-input').datepicker();

</script> 

    </body>

</html>