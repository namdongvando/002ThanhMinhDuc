<?php

namespace Application\Html;

class Js {

    public static $Js;

    public function __construct($fileCss, $v = true) {
        $filename = substr($fileCss, 1);
        if (file_exists($filename)) {
            ?>
            <script src="<?php echo $fileCss ?>?v=<?php echo filemtime($filename); ?>"></script>
            <?php
        }
    }

    public static function FullLink($param0) {
        ?>
        <script src="<?php echo $param0 ?>"></script>

        <?php
    }

    public static function AddJS($Js) {
        if (self::$Js == null)
            self::$Js = "";
        self::$Js .= $Js;
    }

    public static function GetJS() {
        return self::$Js;
    }

}
