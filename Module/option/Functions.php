<?php

namespace Module\option;

class Functions {

    static $DoiTuongKhachHang;
    static $NhomKinhDoanh;
    static $KhuVuc;

    public function __construct() {
        self::$DoiTuongKhachHang = Model\Option::MaDoiTuongKhachHang;
        self::$NhomKinhDoanh = Model\Option::MaNhomKinhDoanh;
        self::$KhuVuc = Model\Option::KhuVuc;
    }

    function head() {
        ?>
        <meta http-equiv="cache-control" content="max-age=0" />
        <meta http-equiv="cache-control" content="no-cache" />
        <link rel="shortcut icon" href="/public/no-image.jpg" />
        <link rel="stylesheet" href="/public/admin/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
        <link rel="stylesheet" href="/public/admin/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="/public/admin/dist/css/skins/_all-skins.min.css">
        <link rel="stylesheet" href="/public/admin/plugins/iCheck/flat/blue.css">
        <link rel="stylesheet" href="/public/admin/plugins/morris/morris.css">
        <link rel="stylesheet" href="/public/admin/plugins/jvectormap/jquery-jvectormap-1.2.2.css">
        <link rel="stylesheet" href="/public/admin/plugins/datepicker/datepicker3.css">
        <link rel="stylesheet" href="/public/admin/plugins/daterangepicker/daterangepicker-bs3.css">
        <link rel="stylesheet" href="/public/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
        <link href="/public/admin/plugins/select2/select2.min.css" rel="stylesheet" type="text/css"/>
        <link rel="stylesheet" href="/public/admin/plugins/datatables/dataTables.bootstrap.css">
        <link href="/public/admin/plugins/datatables/jquery.dataTables.min.css" rel="stylesheet" type="text/css"/>
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
            .nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover{
                font-weight: bold;
                font-size: 16px;
                max-width: 100px;
                overflow: hidden;

            }
        </style>

        <?php
    }

    function Menu() {
        ?>
        <header class="main-header ">
            <!-- Logo -->
            <a href="/dashboard/" class="logo">
                <span class="logo-mini"><b>TMĐ</b></span>
                <span class="logo-lg"><b>Thành Minh Đức</b></span>
            </a>
            <nav class="navbar navbar-static-top " role="navigation">
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <li>
                            <a href="/backend/timkiem/" >
                                <span class="fa fa-search"></span>
                            </a>
                        </li>
                        <?php
                        \theme\backend\backend::user_menu();
                        ?>
                    </ul>
                </div>
            </nav>
        </header>
        <aside class="main-sidebar" >
            <section class="sidebar ">
                <ul class="sidebar-menu ">
                    <li class="treeview">
                        <a href="/dashboard/index/">
                            <i class="fa fa-dashboard"></i> <span>Quay Lại</span>
                            <i class="fa fa-angle-right pull-right"></i>
                        </a>
                    </li>
                    <li class="treeview">
                        <a href="/option/index/">
                            <i class="fa fa-list-alt"></i> <span>Tất Cả</span>
                            <i class="fa fa-angle-right pull-right"></i>
                        </a>
                    </li>
                    <?php
                    $GetGroupsOption = Model\Option::GetGroupsOption();
                    foreach ($GetGroupsOption as $key => $value) {
                        ?>
                        <li class="treeview">
                            <a href="/option/index/groups/<?php echo $key; ?>/">
                                <i class="fa fa-list-alt"></i> <span><?php echo $value; ?></span>
                                <i class="fa fa-angle-right pull-right"></i>
                            </a>
                        </li>
                        <?php
                    }
                    ?>
                </ul>
            </section>
        </aside>
        <?php
    }

    function Breadcrumb() {
        $brea = new \Model\Breadcrumb();
        $brea->backend();
    }

    function js() {
        ?>
        <script type="text/javascript" >
            var linkArray = [
                "/public/admin/plugins/jQuery/jQuery-2.1.4.min.js",
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
                "/public/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js",
                "/public/admin/plugins/slimScroll/jquery.slimscroll.min.js",
                "/public/admin/plugins/fastclick/fastclick.min.js",
                "/public/admin/plugins/datatables/jquery.dataTables.min.js",
                "/public/admin/dist/js/app.min.js",
                "/public/admin/dist/js/pages/dashboard.js",
                "/public/admin/dist/js/demo.js",
                "/public/admin/plugins/ckeditor/ckeditor.js",
                "/public/admin/dist/js/Custom.js"
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

}
