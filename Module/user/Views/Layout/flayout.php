<?php

namespace Module\user\Views\Layout;

use Module\user\Model\user;

class flayout {

    function __construct() {

    }

    static function Menu() {
        ?>

        <header class="main-header">
            <!-- Logo -->
            <a href="<?php echo \Common\Link::linkUser(); ?>" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>CDC</b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>CDC</b></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="/public/no-image.jpg" class="user-image" alt="User Image">
                                <span class="hidden-xs"><?php echo user::getCurentUserInfor(TRUE)->Name; ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="/public/no-image.jpg" class="img-circle" alt="User Image">
                                    <p>
                                        <?php echo user::getCurentUserInfor(TRUE)->Email; ?>
                                    </p>
                                </li>
                                <!-- Menu Body -->
                                <li class="user-body hidden">
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Followers</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Sales</a>
                                    </div>
                                    <div class="col-xs-4 text-center">
                                        <a href="#">Friends</a>
                                    </div>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="<?php echo \Common\Link::profile() ?>" class="btn btn-default btn-flat">Tài Khoản</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo \Common\Link::logout() ?>" class="btn btn-default btn-flat">Đăng xuất</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                        <!-- Control Sidebar Toggle Button -->

                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="/public/no-image.jpg" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p><?php echo user::getCurentUserInfor(true)->Name ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                <!-- search form -->
                <form action="#" method="get" class="sidebar-form hidden">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search...">
                        <span class="input-group-btn">
                            <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
                <!-- /.search form -->
                <!-- sidebar menu: : style can be found in sidebar.less -->
                <ul class="sidebar-menu">
                    <?php
                    \Common\Link::LeftMenu();
                    ?>


                </ul>
            </section>
            <!-- /.sidebar -->
        </aside>

        <?php
    }

}
?>