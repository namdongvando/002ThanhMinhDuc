<?php

namespace Module\rmm\Controller;

class api extends index {

    static public $UserLayout = "user";

    function __construct() {
        header('Access-Control-Allow-Origin: *');
        header("Content-type: application/json; charset=utf-8");
    }

    function rooms() {
        $room = new \Module\rmm\Model\Room();
        $a = $room->Rooms();
        foreach ($a as $key => $value) {
            $value = new \Module\rmm\Model\Room($value);
            $a[$key]["TypeName"] = $value->Type()->Name;
        }
        echo \lib\APIs::Json_encode($a);
    }

    function roomstype() {
        $room = new \Module\rmm\Model\Option();
        $a = $room->GetAll();

        echo \lib\APIs::Json_encode($a);
    }

    function index() {

        return $this->ModelView([], "");
    }

}
?>

