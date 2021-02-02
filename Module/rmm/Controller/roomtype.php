<?php

namespace Module\rmm\Controller;

class roomtype extends index implements \Controller\IController {

    static public $UserLayout = "user";
    private $OPtion;

    function __construct() {
        parent::__construct();

        $this->OPtion = new \Module\rmm\Model\Option();
    }

    function index() {

        return $this->ModelView([], "");
    }

    public function create() {
        if (isset($_POST["OnSave"])) {

            $Option = $_POST["option"];
            unset($Option["Id"]);
            $MOption = new \Module\rmm\Model\Option();
            $MOption->InsertSubmit($Option);
            \Application\redirectTo::Url($_SERVER["HTTP_REFERER"]);
            exit();
        }
    }

    public function delete() {
        $MOption = new \Module\rmm\Model\Option();
        $MOption->DelteteSubmit($model);
        \Application\redirectTo::Url($_SERVER["HTTP_REFERER"]);
        exit();
    }

    public function detail() {

        $id = $this->getParam()[0];
        $option = $this->OPtion->GetById($id);
        return $this->ModelView(["Option" => $option], "");
    }

    public function edit() {
        if (isset($_POST["OnSave"])) {
            $Option = $_POST["option"];
            $MOption = new \Module\rmm\Model\Option();
            $MOption->UpdateSubmit($Option);
        }
        $id = $this->getParam()[0];
        $option = $this->OPtion->GetById($id);
        return $this->ModelView(["Option" => $option], "");
    }

}
?>

