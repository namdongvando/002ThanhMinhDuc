<?php

namespace Common;

class Alert
{

    function __construct($content = [])
    {
        self::setAlert($content[0], $content[1]);
    }

    static function getAlert()
    {
        if (!isset($_SESSION["Alert"])) {
            return NULL;
        }
        $al = $_SESSION["Alert"];
        unset($_SESSION["Alert"]);
        return $al;
    }

    static function showAlert()
    {
        $alert = self::getAlert();
        if ($alert) {
            ?>
            <div class="container">
                <div class="alert-fixed-top-right alert alert-<?php echo $alert["Type"] ?>" role="alert">
                    <?php echo $alert["Content"] ?>
                </div>
            </div>
            <?php
        }
    }

    static function setAlert($type, $Content)
    {
        $_SESSION["Alert"]["Type"] = $type;
        $_SESSION["Alert"]["Content"] = $Content;
    }

}
?>