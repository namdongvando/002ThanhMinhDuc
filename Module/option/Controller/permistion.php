<?php

namespace Module\option\Controller;

define("AppDir", "Module/option");
define("AppPath", "/Module/option");

class permistion extends Auth implements \Controller\IController {

    static public $UserLayout = "user";

    function __construct() {
        parent::__construct();
    }

    function index() {
        if (isset($_POST["Save"])) {
            $Quyen = $_POST['Quyen'];
            if (!empty($Quyen))
                foreach ($Quyen as $k => $value) {
                    \Model\Permistion::Save2File($k, $value);
                }
        }
        return $this->ViewThemeModlue([], "");
    }

    public function create() {
        return $this->ViewThemeModlue([], "");
    }

    public function delete() {
        return $this->ViewThemeModlue([], "");
    }

    public function detail() {
        return $this->ViewThemeModlue([], "");
    }

    public function edit() {
        return $this->ViewThemeModlue([], "");
    }

}
?>

