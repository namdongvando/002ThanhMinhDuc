<?php

namespace Common\CoreCodePhp\ModelDataSytem;

use Zend\Db\Sql\Ddl;
use Zend\Db\Sql\TableIdentifier;
use Zend\Db\TableGateway\TableGateway;

class ModelTable extends \datatable\ZendData {

    function __construct() {

    }

    static function getTableName() {
        $dataName = DataBaseName;
        $db = new \datatable\ZendData();
        $sql = "SELECT TABLE_NAME FROM information_schema.tables WHERE table_schema = '{$dataName}'";
        $a = $db->runsqlToArray($sql);
        $colName = [];
        foreach ($a as $value) {
            $colName[] = $value["TABLE_NAME"];
        }
        return $colName;
    }

    static function createFolder() {
        $tableNames = self::getTableName();
        foreach ($tableNames as $name) {
            $name = str_replace("_", "", $name);
            $folder = "data/tables/" . $name;
            if (!is_dir($folder))
                mkdir($folder, 0777);
        }
    }

    static function getColumnName($tableName) {
        $dataBaseName = DataBaseName;
        $sql = "select `COLUMN_NAME` from information_schema.columns where "
                . "table_schema = '{$dataBaseName}' "
                . "AND TABLE_NAME = '{$tableName}' "
                . "ORDER BY `columns`.`ORDINAL_POSITION` ASC";
        $db = new \datatable\ZendData();
        $a = $db->runsqlToArray($sql);
        $colName = [];
        foreach ($a as $value) {
            $colName[] = $value["COLUMN_NAME"];
        }
        return $colName;
    }

    static function createFiles($className) {

        $tableName = str_replace(table_prefix, "", $className);
        $folderName = str_replace("_", "", $className);
        $namespace = "data\\tables\\{$folderName}";

        $folder = "data/tables/" . $folderName;
        $io = new \lib\io();
        $fileIModelForm = "Common/CoreCodePhp/ModelTemplate/IModelForm.php";
        $fileModelData = "Common/CoreCodePhp/ModelTemplate/ModelData.php";
        $fileModelForm = "Common/CoreCodePhp/ModelTemplate/ModelForm.php";
        // iform
        $fileIModelFormContent = $io->readFile($fileIModelForm);
        $content = self::fileIModelFormContent($className);
        $fileIModelFormContent = str_replace("__Code__", $content, $fileIModelFormContent);
        $fileIModelFormContent = str_replace("IModelForm", "I{$tableName}Form", $fileIModelFormContent);
        $fileIModelFormContent = str_replace("CoreCodePhp", $namespace, $fileIModelFormContent);
        $filename = $folder . "/I{$tableName}Form.php";
        $io->writeFile($filename, $fileIModelFormContent);
        // modeldata
        $fileIModelFormContent = $io->readFile($fileModelData);
        $content = self::fileIModelFormContent($className);
        $fileIModelFormContent = str_replace("__nametable__", $tableName, $fileIModelFormContent);
        $fileIModelFormContent = str_replace("Classname", $tableName, $fileIModelFormContent);
        $fileIModelFormContent = str_replace("CoreCodePhp", $namespace, $fileIModelFormContent);
        $filename = $folder . "/{$tableName}Data.php";
        $io->writeFile($filename, $fileIModelFormContent);
        // modelForm
        $fileIModelFormContent = $io->readFile($fileModelForm);
        $tableName = str_replace(table_prefix, "", $className);
        $content = self::fileModelFormContent($className);
        $fileIModelFormContent = str_replace("__nametable__", $tableName, $fileIModelFormContent);
        $filename = $folder = "data/tables/" . $className . "/{$className}Data.php";
        $io->writeFile($filename, $fileIModelFormContent);
    }

    public static function fileIModelFormContent($className) {
        $colNames = self::getColumnName($className);
        $pro = 'static public function Code($value = null, $title = ""); ' . PHP_EOL;
        $proContent = "";
        foreach ($colNames as $value) {
            $proTemp = str_replace("Code", $value, $pro);
            $proContent .= $proTemp;
        }
        return $proContent;
    }

    public static function fileModelFormContent($className) {
        $str = <<<STRCODE
        public static function {$colName}(\$value = null, \$title = null) {
            if (\$title != null)
                \$title = "{$colName}";
            \$Option = self::\$Option;
            \$Option["value"] = \$value;
            \$Option["maxlenght"] = 15;
            \$nameForm = self::nameForm;
            return new \PFBC\Element\Textbox(\$title, "{\$nameForm}[" . __FUNCTION__ . "]", \$Option);
        }

STRCODE;
        $colNames = self::getColumnName($className);
        $strpropertive = "";
        foreach ($colNames as $colName) {
            $strpropertive .= $str . PHP_EOL . PHP_EOL . PHP_EOL;
        }

        return $strpropertive;
    }

}
