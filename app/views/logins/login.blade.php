<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">

        <title>SIGN IN |  {{ strtoupper(getenv('NAME_EMPRESA')) }} </title>

        <link href="login/assets/components/bower/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="login/assets/components/bower/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="login/assets/css/login/animate.css" rel="stylesheet">
        <link href="login/assets/css/login/reset.min.css" rel="stylesheet">
        <link href="login/assets/css/theme/layout.css" rel="stylesheet">
        <link href="login/assets/css/theme/components.css" rel="stylesheet">
        <link href="login/assets/css/theme/plugins.css" rel="stylesheet">
        <link href="login/assets/css/login/theme.min.css" rel="stylesheet">
        <link href="login/assets/css/login/sign.css" rel="stylesheet">
        <link href="login/assets/css/theme/custom.css" rel="stylesheet">
        <link href="login/toastr/toastr.css" rel="stylesheet">
        <script src="login/assets/components/bower/jquery/jquery.min.js"></script>
        <script src="login/toastr/toastr.js"></script>
    </head>

    <body> 
        <script type="text/javascript">
            function logout(message) {
                msg.success(" ", message);
            }
        </script>

        <div id="loading">
            <div class="loading-inner">
                <img class="animated bounceIn" src="images/loader/flat/1.gif" alt="..."/>
            </div>
        </div>

        <div id="sign-wrapper">

            <div class="hide">
                <img src="images/loader/flat/1.gif" alt="brand logo"/>
            </div>

            {{ Form::open(array('method' => 'post', 'class' => 'sign-in form-horizontal shadow rounded no-overflow' ,'autocomplete'=>'off')) }}

                <?php  if(Session::has('message')): ?>
                    <div class="hide" id="message"><?php echo Session::get('message') ?></div>

                    <?php echo
                        '<script type="text/javascript">
                            var message = $("#message").text();
                            logout(message);
                        </script>';
                    ?>
                <?php endif; ?>

                <div class="sign-header">
                    <div class="form-group">
                        <div class="sign-text">
                            <span> {{ getenv('SLOGAN_EMPRESA') }} </span>
                        </div>
                    </div>
                </div>
                <div class="sign-body">
                    <div class="form-group">
                        <div class="input-group input-group-lg rounded no-overflow">
                            <input autocomplete="off" type="text" class="form-control input-sm" placeholder="Username" name="username">
                            <span class="input-group-addon"><i class="fa fa-user"></i></span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="input-group input-group-lg rounded no-overflow">
                            <input type="password" class="form-control input-sm" placeholder="Password" name="password" autocomplete="off">
                            <span class="input-group-addon"><i class="fa fa-lock"></i></span>
                        </div>
                    </div>
                </div>
                <div class="sign-footer">
                    <div class="form-group">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="ckbox ckbox-theme">
                                    <input id="rememberme" name="rememberme" type="checkbox">
                                    <label for="rememberme" class="rounded">Remember me</label>
                                </div>
                            </div>
                            <div class="col-xs-6 text-right">
                                <a href="page-lost-password.html" title="lost password">Lost password?</a>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-theme btn-lg btn-block no-margin rounded" id="login-btn">Log In</button>
                    </div>
                </div>
            {{ Form::close() }}

            <p class="text-muted text-center sign-link"> {{ getenv('COPYRING_YEAR') }}  &copy; Created by<a href="#"> {{ getenv('AUTOR') }}</a></p>

        </div>

        <script src="login/assets/components/bower/bootstrap/js/bootstrap.min.js"></script>
        <script src="login/assets/js/jpreloader-v2/js/jpreloader.min.js"></script>
        <script src="login/assets/components/bower/jquery.easing/js/jquery.easing.js"></script>
        <script src="login/assets/js/login/validate.js"></script>
        <script src="login/assets/js/login/blakon.js"></script>

    </body>
    <!-- END BODY -->

</html>
