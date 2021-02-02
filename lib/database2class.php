<?php

namespace lib;

class database2class extends \Model_Adapter {

    static $table, $ListColum;

    function __construct() {

        parent::__construct();
    }

    function setTable($Table) {
        self::$table = $Table;
    }

    function getTable() {
        return self::$table;
    }

    private function getAllTable($database) {
        $sql = "SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='{$database}'";
        $this->Query($sql);
        $a = $this->fetchAll();
        return $a;
    }

    function MapingClass() {
        global $INI;
        $alltable = $this->getAllTable($INI['DBname']);
        foreach ($alltable as $k => $tableName) {
            $this->setTable($tableName["TABLE_NAME"]);
            $this->createFileClassByTable();
        }
        echo "ok";
    }

    function setColum() {
        $sql = "DESCRIBE {$this->getTable()}";
        $this->Query($sql);
        $a = $this->fetchAll();
        $b = [];
        foreach ($a as $row) {
            $b[] = $row["Field"];
        }
        self::$ListColum = $b;
    }

    function getColum() {
        return self::$ListColum;
    }

    function createFileClassByTable() {
        $OI = new \lib\io();
        $tableName = str_replace("_", "", $this->getTable());
        $OI->writeFile("classdatabase/" . $tableName . ".php", $this->createClassByTable());
    }

    protected function createClassByTable() {
        $this->setColum();
        $tableName = str_replace("_", "", $this->getTable());
        $Claass = "<?php 
            namespace classdatabase;
            
            class {$tableName} { 
                public 
            ";

        $lisColum = $this->getColum();
        $i = 0;
        foreach ($lisColum as $value) {
            if ($i < count($lisColum) - 1) {
                $Claass .= " \${$value} , 
            ";
            } else {
                $Claass .= " \${$value} ";
            }
            $i++;
        }
        $Claass .= "; ";

        $Claass .= "
            
            function __construct(\$menu = null) {
                    if(\$menu){
                        ";
        $i = 0;
        foreach ($lisColum as $value) {
            $Claass .= " \$this->{$value} = \$menu['{$value}'];";
        }
        $Claass .= "
                    }
                     parent::__construct();
                 }
            
            } ";
        return $Claass;
    }

}
