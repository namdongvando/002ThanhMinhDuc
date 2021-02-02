<?php

namespace lib;

class form extends \Model_Adapter {

    function __construct() {
        
    }

    function listClassVars($className) {
        $a = get_class_vars($className);
        return $a;
    }

    private function getAllTable($database) {
        $sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='{$database}'";
        $this->Query($sql);
        $a = $this->fetchAll();
        return $a;
    }

    function MapingForm() {
        global $INI;
        $alltable = $this->getAllTable($INI['DBname']);
        foreach ($alltable as $k => $tableName) {
            $nameTable = str_replace("_", "", $tableName["TABLE_NAME"]);
            $className = "\classdatabase\\{$nameTable}";
            $filename = str_replace("\\", '_', $className);
            $this->createFormByClassToFile($className, $filename . $k . "_form");
        }
        echo "ok";
    }

    function createFormByClassToFile($className, $page) {
        $fileName = "public/form/" . $page . ".phtml";
        $IO = new \lib\io();
        $content = $this->createFormByClass($className);
        $IO->writeFile($fileName, $content);
        return TRUE;
    }

    function createFormByClass($className) {
        $a = $this->listClassVars($className);
        $HTML = '<form action="" method="POST" enctype="multipart/form-data" > 
            ';
        foreach ($a as $k => $v) {
            $HTML .= '
                <div class="form-group">
                <label for="">__' . $k . '___</label>
                <input type="text" value="{{' . $className . "." . $k . '}}" class="form-control" name="' . $k . '" >
            </div>
            ';
        }
        $HTML .= '
            </form>';
        return $HTML;
    }

}

?>