<?php

namespace Application\Request;

class Post {

    public function __construct() {

    }

    public static function IsPost() {
        return count($_POST) > 0;
    }

    public static function GetPost($param0, $param1, $group = null) {
        if ($group) {
            if (isset($_POST[$group][$param0]))
                return $_POST[$group][$param0];
        }
        if (isset($_POST[$param0]))
            return $_POST[$param0];
        return $_POST[$param1];
    }

}

?>