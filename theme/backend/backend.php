<?php

namespace theme\backend;

class backend {

    function head() {
        ?>
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <link rel="shortcut icon" href="/public/no-image.jpg" />
        <!-- Bootstrap 3.3.5 -->
        <link rel="stylesheet" href="/public/admin/bootstrap/css/bootstrap.min.css">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <!-- Ionicons -->
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link href="/public/admin/plugins/select2/select2.min.css" rel="stylesheet" type="text/css"/>
        <!-- Theme style -->
        <!-- AdminLTE Skins. Choose a skin from the css/skins
             folder instead of downloading all of them to reduce the load. -->
        <link rel="stylesheet" href="/public/admin/dist/css/skins/_all-skins.min.css">
        <!-- iCheck -->
        <link rel="stylesheet" href="/public/admin/plugins/iCheck/flat/blue.css">
        <!-- Morris chart -->
        <link rel="stylesheet" href="/public/admin/plugins/morris/morris.css">
        <!-- jvectormap -->
        <link rel="stylesheet" href="/public/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <!-- Date Picker -->
        <link rel="stylesheet" href="/public/admin/plugins/datepicker/datepicker3.css">
        <!-- Daterange picker -->
        <link rel="stylesheet" href="/public/admin/plugins/daterangepicker/daterangepicker-bs3.css">
        <!-- bootstrap wysihtml5 - text editor -->
        <link rel="stylesheet" href="/public/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        <link rel="stylesheet" href="/public/admin/plugins/datatables/dataTables.bootstrap.css">
        <link href="/public/admin/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="/public/admin/dist/css/AdminLTE.min.css">
        <link href="/public/admin/dist/Custom.css?v=<?php echo fileatime("public/admin/dist/Custom.css"); ?>" rel="stylesheet" type="text/css"/>
        <style type="text/css" >
            .alert{
                position: fixed;
                top: 20%;
            }
            .alert-fixed-top-right{
                position: fixed;
                right: 0px;
                min-width: 300px;
                top: 40px;
                z-index: 9999;
            }
            .dataTables_length{
                float: left;
            }
            fieldset legend {
                margin: 0;
                padding: 0;
                position: static;
                border: 0;
                top: auto; left: auto;
                float: none;
                display: table;
                font-size: 14px;
                line-height: 18px;
                width: auto;
            }
            fieldset{
                display: block;
                margin-inline-start: 2px;
                margin-inline-end: 2px;
                padding-block-start: 0.35em;
                padding-inline-start: 0.75em;
                padding-inline-end: 0.75em;
                padding-block-end: 0.625em;
                min-inline-size: min-content;
                border-width: 2px;
                border-style: groove;
                border-color: threedface;
                border-image: initial;

            }
            .nav-tabs>li>a,
            .nav-tabs>li.active>a,s .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover{
                font-weight: bold;
                overflow: hidden;

            }
        </style>

        <?php
    }

    public static function user_menu() {
        ?>
        <li class="dropdown user user-menu">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                <img src="/public/user_no_photo.png" class="user-image" alt="User Image">
                <span class="hidden-xs"><?php echo $_SESSION[QuanTri]["Name"] ?></span>
            </a>
            <ul class="dropdown-menu">
                <!-- User image -->
                <li class="user-header">
                    <img src="/public/user_no_photo.png" class="img-circle" alt="User Image">
                    <p>
                        <?php echo $_SESSION[QuanTri]["Name"] ?>
                        <small><?php echo $_SESSION[QuanTri]["Username"] ?></small>
                    </p>
                </li>
                <!-- Menu Footer-->
                <li class="user-footer">
                    <div class="pull-left">
                        <a href="<?php echo \Common\Link::profile() ?>" class="btn btn-default btn-flat">Tài khoản</a>
                    </div>
                    <div class="pull-right">
                        <a href="<?php echo \Common\Link::logout() ?>" class="btn btn-default btn-flat">Đăng Xuất</a>
                    </div>
                </li>
            </ul>
        </li>
        <?php
    }

    function Menu() {
        ?>
        <header class="main-header">
            <nav class="navbar navbar-static-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a href="/dashboard/" class="navbar-brand">TMD</a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            <?php
                            \Common\Link::MenuQuanLy();
                            \Common\Link::MenuDoiTac();
                            ?>

                        </ul>
                    </div><!-- /.navbar-collapse -->
                    <!-- Navbar Right Menu -->
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="">
                                <a href="/option/index">
                                    <span><i class="fa fa-gears" ></i></span>
                                </a>
                            </li>
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <span class="hidden-xs">Tìm Kiếm</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li class="">
                                        <form action="" method="POST" class="navbar-form navbar-left" role="search">
                                            <div class="form-group">
                                                <input type="text" class="form-control" id="navbar-search-input" placeholder="Search">
                                                <button type="submit" class="btn btn-primary" >
                                                    <i class="fa fa-search" ></i>
                                                </button>
                                            </div>
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="/public/user_no_photo.png" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo $_SESSION[QuanTri]["Name"] ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="/public/user_no_photo.png" class="img-circle" alt="User Image">
                                        <p>
                                            <?php echo $_SESSION[QuanTri]["Name"] ?>
                                            <small><?php echo $_SESSION[QuanTri]["Username"] ?></small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="<?php echo \Common\Link::profile() ?>" class="btn btn-default btn-flat">Tài khoản</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="<?php echo \Common\Link::logout() ?>" class="btn btn-default btn-flat">Đăng Xuất</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            `
                        </ul>
                    </div><!-- /.navbar-custom-menu -->
                </div><!-- /.container-fluid -->
            </nav>
        </header>
        <aside class="hidden main-sidebar" >
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar ">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="/public/user_no_photo.png" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>

                <ul class="sidebar-menu ">
                    <?php
                    \Common\Link::LeftMenu();
                    ?>
                </ul>

            </section>
            <!-- /.sidebar -->
        </aside>
        <?php
    }

    function Menuifame() {
        ?>
        <header class="main-header ">
            <nav class="navbar navbar-static-top">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <a href="/backend/" target="MainContent" class="navbar-brand"><b>HCDC</b></a>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
                            <i class="fa fa-bars"></i>
                        </button>
                    </div>
                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
                        <ul class="nav navbar-nav">
                            <li class="dropdown " >
                                <a href="/mpage/index" class="dropdown-toggle" data-toggle="dropdown" >
                                    <i class="fa fa-list-alt"></i> <span>Quản Lý Bài Viết</span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a target="MainContent" href="/mpage/index"><i class="fa fa-circle-o"></i> Danh Mục</a></li>
                                    <li><a target="MainContent" href="/mpage/addpage/"><i class="fa fa-circle-o"></i> Thêm Danh Mục</a></li>
                                    <li><a target="MainContent" href="/mnews/addnews/"><i class="fa fa-circle-o"></i> Thêm Bài Viết</a></li>
                                    <li><a target="MainContent" href="/backend/test/"><i class="fa fa-circle-o"></i> test</a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <!-- Messages: style can be found in dropdown.less-->
                            <li>
                                <a href="/backend/timkiem/" >
                                    <span class="fa fa-search"></span>
                                </a>
                            </li>
                            <li><a href="/" target="_blank"  >Xem Website</a></li>
                            <!-- User Account: style can be found in dropdown.less -->
                            <li class="dropdown user user-menu">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <img src="/public/user_no_photo.png" class="user-image" alt="User Image">
                                    <span class="hidden-xs"><?php echo $_SESSION[QuanTri]["Name"] ?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- User image -->
                                    <li class="user-header">
                                        <img src="/public/user_no_photo.png" class="img-circle" alt="User Image">
                                        <p>
                                            <?php echo $_SESSION[QuanTri]["Name"] ?>
                                            <small><?php echo $_SESSION[QuanTri]["Username"] ?></small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="/mprofile/index" class="btn btn-default btn-flat">Tài khoản</a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="/backend/logout" class="btn btn-default btn-flat">Đăng Xuất</a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>

                </div><!-- /.container-fluid -->
            </nav>
        </header>
        <?php
    }

    function js() {
        ?>
        <script type="text/javascript" >
            /*
             "/public/admin/plugins/jQuery/jQuery-2.1.4.min.js",
             */
            var linkArray = [
                "https://code.jquery.com/ui/1.11.4/jquery-ui.min.js",
                "/public/admin/bootstrap/js/bootstrap.min.js",
                "https://cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js",
                "/public/admin/plugins/morris/morris.min.js",
                "/public/admin/plugins/select2/select2.min.js",
                "/public/admin/plugins/sparkline/jquery.sparkline.min.js",
                "/public/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js",
                "/public/admin/plugins/jvectormap/jquery-jvectormap-world-mill-en.js",
                "/public/admin/plugins/knob/jquery.knob.js",
                "https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.10.2/moment.min.js",
                "/public/admin/plugins/daterangepicker/daterangepicker.js",
                "/public/admin/plugins/datepicker/bootstrap-datepicker.js",
                "/public/admin/plugins/datepicker/locales/bootstrap-datepicker.vi.js",
                "/public/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js",
                "/public/admin/plugins/slimScroll/jquery.slimscroll.min.js",
                "/public/admin/plugins/fastclick/fastclick.min.js",
                "/public/admin/plugins/datatables/jquery.dataTables.min.js",
                "/public/admin/dist/js/app.min.js",
                "/public/admin/dist/js/pages/dashboard.js",
                "/public/admin/dist/js/demo.js",
                "/public/admin/plugins/ckeditor/ckeditor.js",
                "/public/admin/dist/js/TabNVD.js?v=23123121231",
                "/public/admin/dist/js/Custom.js?v=<?php echo time(); ?>"
            ];
            for (var i = 0; i < linkArray.length; i++) {
                document.write('<script type="text/javascript" src="' + linkArray[i] + '"><\/script>');
            }


        </script>
        <style type="text/css" >
            .toolbardatatable{
                float: left;
            }
        </style>
        <?php
        $str = ob_get_clean();
        echo $str;
    }

    function Breadcrumb() {
//        $brea = new \Model\Breadcrumb();
//        $brea->backend();
    }

    function menumcategory() {

    }

    function DecodeHTML() {
        $str = ob_get_clean();
        echo $str;
    }

    public function footer() {
        ?>
        <footer class="main-footer ">
            <div class="pull-right hidden-xs">
                <b>Version</b> 1.0.1
            </div>
            <strong>Copyright &copy; <?php echo date("Y", time()); ?> <a href="http://thanhminhduc.com.vn">thanhminhduc.com.vn</a>.</strong>
        </footer>
        <?php
    }

}
