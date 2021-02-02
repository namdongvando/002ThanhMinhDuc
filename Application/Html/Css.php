<?php

namespace Application\Html;

class Css {

    public static $css;

    public function __construct($fileCss, $v = true) {
        $filename = substr($fileCss, 1);
        if (file_exists($filename)) {
            ?>
            <link href="<?php echo $fileCss ?>?v=<?php echo filemtime($filename); ?>" rel="stylesheet" type="text/css"/>
            <?php
        }
    }

    public static function FullLink($param0) {
        ?>
        <link href = "<?php echo $param0 ?>" rel = "stylesheet" type = "text/css"/>
        <?php
    }

    public static function AddCss($Css) {

        if (self::$css == null)
            self::$css = "";
        self::$css .= $Css;
    }

    public static function GetCss() {
        return self::$css;
    }

}
