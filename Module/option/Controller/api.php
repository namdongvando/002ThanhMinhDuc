<?php

namespace Module\option\Controller;

class api extends \ApplicationM {

    function __construct() {
        new \Controller\backend();
    }

    function options() {
        $model_option = new \Module\option\Model\Option();
        $Options = $model_option->GetAll();
        echo \lib\APIs::Json_encode($Options);
    }

}
?>

