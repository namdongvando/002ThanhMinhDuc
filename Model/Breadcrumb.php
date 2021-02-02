<?php

namespace Model;

class Breadcrumb {

    public static $List;

    static function setBreadcrumb($array) {
        self::$List = $array;
    }

    static function getBreadcrumb() {
        return (array) self::$List;
    }

    function showBreadcrumb() {
        $ds = self::$List;
        $a = [];
        ?>  
        <div class="container mt-20" >
            <ul class="breadcrumbs">
                <li class="breadcrumbs__item" ><a class="breadcrumbs__url" href="/" title="Return to Home">Trang Chủ</a></li> 
                <?php
                if ($ds) {
                    $a = end($ds);
                    unset($ds[count($ds) - 1]);
                    if ($ds)
                        foreach ($ds as $v) {
                            ?> 
                            <li class="breadcrumbs__item" ><a class="breadcrumbs__url"  title="<?php echo $v["title"] ?>" href="<?php echo $v["link"] ?>"><?php echo $v["title"] ?></a></li> 
                            <?php
                        }
                }
                if ($a) {
                    ?> 
                    <li class="breadcrumbs__item breadcrumbs__item--current">
                        <?php echo $a["title"] ?>
                    </li> 
                    <?php
                }
                ?>
            </ul>
        </div>


        <?php
    }

    function backendBreadcrumb() {
        $ds = self::$List;
        $a = [];
        ?> 
        <div class="breadcrumb clearfix">
            <a class="home" href="/" title="Return to Home">Trang Chủ</a>
            <?php
            if ($ds) {
                $a = end($ds);
                unset($ds[count($ds) - 1]);
                if ($ds)
                    foreach ($ds as $v) {
                        ?> 
                        <span class="navigation-pipe">&nbsp;</span>
                        <a href="<?php echo $v["link"] ?>"><?php echo $v["title"] ?></a>
                        <?php
                    }
            }
            if ($a) {
                ?> 
                <span class="navigation-pipe">&nbsp;</span>
                <span class="navigation_page"><?php echo $a["title"] ?></span>
                <?php
            }
            ?>
        </div>

        <?php
    }

    function backend() {
        $ds = self::$List;
        $a = [];
        ?> 
        <section class="content-header">
            <ol class="breadcrumb pull-left">
                <?php
                if ($ds) {
                    $a = end($ds);
                    unset($ds[count($ds) - 1]);
                    if ($ds)
                        foreach ($ds as $v) {
                            ?> 
                            <li class="active">
                                <a href="<?php echo $v["link"] ?>"><?php echo $v["title"] ?></a>
                            </li>
                            <?php
                        }
                }
                if ($a) {
                    ?> 
                    <li class="active"><?php echo $a["title"] ?></li>
                    <?php
                }
                ?>
            </ol>
            <h1  style="font-size: 16px;font-weight: bold;" >
                <?php echo isset($a["title"]) ? $a["title"] : "Dashboard"; ?>
            </h1>
        </section>
        <?php
    }

}
