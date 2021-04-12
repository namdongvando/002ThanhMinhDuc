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

    function optionsbyGroups() {
        $model_option = new \Module\option\Model\Option();
        $groups = $this->getParam()[0];
        $Options = $model_option->OptionByGroups($groups);
        echo \lib\APIs::Json_encode($Options);
    }

    function TinhThanhTagOption() {
        $model_option = new \Module\option\Model\Option();
        $groups = $this->getParam()[0];
        $Options = $model_option->GetTinhThanh($groups);
//        var_dump($Options);
        foreach ($Options as $key => $tt) {
            echo "<option value='{$tt["Id"]}' >{$tt["Name"]}</option>";
        }
    }

}
?>

