<header id="header">

    <div class="header-left">

        <div class="navbar-minimize-mobile left">
            <i class="fa fa-bars"></i>
        </div>
        
        <div class="navbar-header">

            <a class="navbar-brand" href="dashboard.html">
                <img class="logo" src="img/logo/logo-white.png" alt="brand logo"/>
            </a>

        </div>

        <div class="navbar-minimize-mobile right">
            <i class="fa fa-cog"></i>
        </div>


        <div class="clearfix"></div>
    </div>

    <div class="header-right">

        <div class="navbar navbar-toolbar navbar-dark">

            <ul class="nav navbar-nav navbar-left">

                <li class="navbar-minimize">
                    <a href="javascript:void(0);" title="Minimize sidebar">
                        <i class="fa fa-bars"></i>
                    </a>
                </li>

                <li class="navbar-search">
                   
                    <a href="javascript:void(0)" class="trigger-search"><i class="fa fa-search"></i></a>
                    <form class="navbar-form" onsubmit=" return false">
                        <div class="form-group has-feedback">
                            <input id="iSearch" type="text" class="form-control typeahead rounded" placeholder="Buscar">
                            <button type="" class="btn btn-theme fa fa-search form-control-feedback rounded" id="search-inventario-user"></button>
                        </div>
                    </form>
                </li>

            </ul>
            <ul class="nav navbar-nav navbar-right">

                <li class="dropdown navbar-message">
                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bar-chart-o"></i></a>
                </li>

                <li class="dropdown navbar-message">
                    <a href="javascript:void(0)" class="dropdown-toggle f_ven_op" data-placement="bottom"  title="Venta" data-toggle="tooltip"><i class="fa fa-dollar"></i></a >
                </li>

                <li class="dropdown navbar-message">
                    <a id="f_com_op" href="javascript:void(0)" class="dropdown-toggle" data-placement="bottom"  title="Compra"  data-toggle="tooltip"><i class="fa fa-shopping-cart"></i></a>
                </li>

                <li class="dropdown navbar-message hide">

                    <a href="javascript:void(0)" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-envelope-o"></i><span class="count label label-danger rounded">7</span></a>

                    <!-- Start dropdown menu -->
                    <div class="dropdown-menu animated flipInX">
                        <div class="dropdown-header">
                            <span class="title">Messages <strong>(7)</strong></span>
                            <span class="option text-right"><a href="javascript:void(0)">+ New message</a></span>
                        </div>
                        <div class="dropdown-body">


                            <!-- Start message list -->
                            <div class="media-list niceScroll">

                                <a href="javascript:void(0)" class="media">
                                    <div class="pull-left"><img src="img/avatar/50/2.png" class="media-object img-circle" alt="John Kribo"/></div>
                                    <div class="media-body">
                                        <span class="media-heading">John Kribo</span>
                                        <span class="media-text">I was impressed how fast the content is loaded. Congratulations. nice design.</span>
                                        <!-- Start meta icon -->
                                        <span class="media-meta"><i class="fa fa-reply"></i></span>
                                        <span class="media-meta"><i class="fa fa-paperclip"></i></span>
                                        <span class="media-meta pull-right">13 minutes</span>
                                        <!--/ End meta icon -->
                                    </div><!-- /.media-body -->
                                </a><!-- /.media -->

                                <a href="javascript:void(0)" class="media">
                                    <div class="pull-left"><img src="img/avatar/50/3.png" class="media-object img-circle" alt="Jennifer Poiyem"/></div>
                                    <div class="media-body">
                                        <span class="media-heading">Jennifer Poiyem</span>
                                        <span class="media-text">It’s Simple, Clean & Nice .. Good work Dear .. GLWS</span>
                                        <!-- Start meta icon -->
                                        <span class="media-meta pull-right">17 hours</span>
                                        <!--/ End meta icon -->
                                    </div><!-- /.media-body -->
                                </a><!-- /.media -->

                                <a href="page-messages.html" class="media">
                                    <div class="pull-left"><img src="img/avatar/50/4.png" class="media-object img-circle" alt="Clara Wati"/></div>
                                    <div class="media-body">
                                        <span class="media-heading">Clara Wati</span>
                                        <span class="media-text">Great work! Do you have any plans to add loading indicators for AJAX calls that might take longer than normal?</span>
                                        <!-- Start meta icon -->
                                        <span class="media-meta pull-right">1 days</span>
                                        <!--/ End meta icon -->
                                    </div><!-- /.media-body -->
                                </a><!-- /.media -->

                                <a href="page-messages.html" class="media">
                                    <div class="pull-left"><img src="img/avatar/50/5.png" class="media-object img-circle" alt="Toni Mriang"/></div>
                                    <div class="media-body">
                                        <span class="media-heading">Toni Mriang</span>
                                        <span class="media-text">I am very interested in the theme and I’m thinking about buying it.</span>
                                        <!-- Start meta icon -->
                                        <span class="media-meta"><i class="fa fa-paperclip"></i></span>
                                        <span class="media-meta pull-right">2 days</span>
                                        <!--/ End meta icon -->
                                    </div><!-- /.media-body -->
                                </a><!-- /.media -->

                                <a href="page-messages.html" class="media">
                                    <div class="pull-left"><img src="img/avatar/50/6.png" class="media-object img-circle" alt="Bella negoro"/></div>
                                    <div class="media-body">
                                        <span class="media-heading">Bella negoro</span>
                                        <span class="media-text">Great work! Good luck!</span>
                                        <!-- Start meta icon -->
                                        <span class="media-meta"><i class="fa fa-paperclip"></i></span>
                                        <span class="media-meta"><i class="fa fa-user"></i></span>
                                        <span class="media-meta pull-right">1 week</span>
                                        <!--/ End meta icon -->
                                    </div><!-- /.media-body -->
                                </a><!-- /.media -->

                                <a href="page-messages.html" class="media">
                                    <div class="pull-left"><img src="img/avatar/50/7.png" class="media-object img-circle" alt="Kim Mbako"/></div>
                                    <div class="media-body">
                                        <span class="media-heading">Kim Mbako</span>
                                        <span class="media-text">Hi! First of all, thank you for the very nice theme for creating awesome web applications :)</span>
                                        <!-- Start meta icon -->
                                        <span class="media-meta"><i class="fa fa-paperclip"></i></span>
                                        <span class="media-meta pull-right">1 week</span>
                                        <!--/ End meta icon -->
                                    </div><!-- /.media-body -->
                                </a><!-- /.media -->

                                <a href="page-messages.html" class="media">
                                    <div class="pull-left"><img src="img/avatar/50/8.png" class="media-object img-circle" alt="Pack Suparman"/></div>
                                    <div class="media-body">
                                        <span class="media-heading">Pack Suparman</span>
                                        <span class="media-text">Apik temen kie jan template, nyong gep tuku jal..</span>
                                        <!-- Start meta icon -->
                                        <span class="media-meta pull-right">1 week</span>
                                        <!--/ End meta icon -->
                                    </div><!-- /.media-body -->
                                </a><!-- /.media -->

                                <!-- Start message indicator -->
                                <a href="#" class="media indicator inline">
                                    <span class="spinner">Load more messages...</span>
                                </a>
                                <!--/ End message indicator -->

                            </div>
                            <!--/ End message list -->

                        </div>
                        <div class="dropdown-footer">
                            <a href="page-messages.html">See All</a>
                        </div>
                    </div>
                    <!--/ End dropdown menu -->

                </li><!-- /.dropdown navbar-message -->
                <!--/ End messages -->

                <!-- Start notifications -->
                <li class="dropdown navbar-notification">

                    <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-bell-o"></i><span class="count label label-danger rounded">10</span></a>

                    <!-- Start dropdown menu -->
                    <div class="dropdown-menu animated flipInX">
                        <div class="dropdown-header">
                            <span class="title">Notifications <strong>(10)</strong></span>
                            <span class="option text-right"><a href="#"><i class="fa fa-cog"></i> Setting</a></span>
                        </div>
                        <div class="dropdown-body niceScroll">

                            <!-- Start notification list -->
                            <div class="media-list small">

                                <a href="#" class="media">
                                    <div class="media-object pull-left"><i class="fa fa-share-alt fg-info"></i></div>
                                    <div class="media-body">
                                        <span class="media-text"><strong>Dolanan Remi : </strong><strong>Chris Job,</strong><strong>Denny Puk</strong> and <strong>Joko Fernandes</strong> sent you <strong>5 free energy boosts and other request</strong></span>
                                        <!-- Start meta icon -->
                                        <span class="media-meta">3 minutes</span>
                                        <!--/ End meta icon -->
                                    </div><!-- /.media-body -->
                                </a><!-- /.media -->

                                <a href="#" class="media">
                                    <div class="media-object pull-left"><i class="fa fa-cogs fg-success"></i></div>
                                    <div class="media-body">
                                        <span class="media-text">Your sistem is updated</span>
                                        <!-- Start meta icon -->
                                        <span class="media-meta">5 minutes</span>
                                        <!--/ End meta icon -->
                                    </div><!-- /.media-body -->
                                </a><!-- /.media -->

                                <a href="#" class="media">
                                    <div class="media-object pull-left"><i class="fa fa-user fg-info"></i></div>
                                    <div class="media-body">
                                        <span class="media-text">Change your user profile</span>
                                        <!-- Start meta icon -->
                                        <span class="media-meta">1 days</span>
                                        <!--/ End meta icon -->
                                    </div><!-- /.media-body -->
                                </a><!-- /.media -->

                                <a href="#" class="media">
                                    <div class="media-object pull-left"><i class="fa fa-book fg-info"></i></div>
                                    <div class="media-body">
                                        <span class="media-text">Added new article</span>
                                        <!-- Start meta icon -->
                                        <span class="media-meta">1 days</span>
                                        <!--/ End meta icon -->
                                    </div><!-- /.media-body -->
                                </a><!-- /.media -->

                                <!-- Start notification indicator -->
                                <a href="#" class="media indicator inline">
                                    <span class="spinner">Load more notifications...</span>
                                </a>
                                <!--/ End notification indicator -->

                            </div>
                            <!--/ End notification list -->

                        </div>
                        <div class="dropdown-footer">
                            <a href="#">Ver todas</a>
                        </div>
                    </div>
                    <!--/ End dropdown menu -->

                </li><!-- /.dropdown navbar-notification -->
                <!--/ End notifications -->

                <!-- Start profile -->
                <li class="dropdown navbar-profile">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        <span class="meta">
                            <span class="avatar"><img src="img/avatar/35/1.png" class="img-circle" alt="admin"></span>
                            <span class="text hidden-xs hidden-sm text-muted">
                                <?php 
                                $user_nombre = explode(' ',Auth::user()->nombre);
                                $user_apellido = explode(' ',Auth::user()->apellido);

                                echo $user_nombre[0].' '.$user_apellido[0];
                                ?>
                                <span class="caret"></span>
                            </span>
                            
                        </span>
                    </a>
                    <!-- Start dropdown menu -->
                    <ul class="dropdown-menu animated flipInX">
                        <li class="dropdown-header">Account</li>
                        <li><a id="profile" href="javascript:void(0)"><i class="fa fa-user"></i>View profile</a></li>
                        <li><a href="logout"><i class="fa fa-sign-out"></i>Logout</a></li>
                    </ul>
                    <!--/ End dropdown menu -->
                </li><!-- /.dropdown navbar-profile -->
                <!--/ End profile -->

                <!-- Start settings -->
                <li class="navbar-setting pull-right">
                    <a href="javascript:void(0);"><i class="fa fa-cog"></i></a>
                </li><!-- /.navbar-setting pull-right -->
                <!--/ End settings -->

            </ul>
            <!--/ End right navigation -->

        </div><!-- /.navbar-toolbar -->
        <!--/ End navbar toolbar -->
    </div><!-- /.header-right -->
    <!--/ End header left -->

            </header> <!-- /#header -->