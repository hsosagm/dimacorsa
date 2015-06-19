<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<?php $tienda = Tienda::find(Auth::user()->tienda_id); ?>

<?php 
$assigned = Assigned_roles::where('user_id', Auth::user()->id)
->join('roles', 'assigned_roles.role_id', '=', 'roles.id')
->orderBy('roles.id', 'DESC')->get();

 $slide_bar_left = 0;
?>

@foreach (@$assigned as $roles)

    @if(strtolower($roles->name) == 'user' || strtolower($roles->name) == 'admin' || strtolower($roles->name) == 'owner' && $slide_bar_left == 0)
        <?php $slide_bar_left = 1;  ?>
    @endif

    @if(strtolower($roles->name) == 'admin' || strtolower($roles->name) == 'owner' && $slide_bar_left == 1)
        <?php $slide_bar_left = 2;  ?>
    @endif  

    @if(strtolower($roles->name) == 'owner' && $slide_bar_left == 2)
        <?php $slide_bar_left = 3;  ?>
    @endif
    
@endforeach 

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

        <!-- Start page header -->

        <span id="home"></span>

        <div class="header-content">
            <h2> <span ><a href="javascript:void(0);" class="fa fa-home" style="font-size:22px;" onclick="limpiar_home();"></a></span>  <span id="home"></span></h2>
        </div>

       @include('partials.body-content')

       <footer class="footer-content">
        2015 &copy; {{$tienda->nombre}} admin. Created by <a href="javascript:void(0)" target="_blank">Hsosa</a>, GM
       </footer><!-- /.footer-content -->

</section><!-- /#page-content -->

@include('partials.slidebar-right')

</section>


<div id="back-top" class="animated pulse circle">
    <i class="fa fa-angle-up"></i>
</div>
<div id="print_barcode"></div>
<script src="js/main.js"></script>
<script src="js/vue.min.js"></script>
<script src="js/custom.js"></script>
<script src="js/autoNumeric.js"></script>
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
</body>

</html>