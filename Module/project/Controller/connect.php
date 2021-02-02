<?php

namespace Module\project\Controller;

// controller
// tất cả class thừa kế từ class này phải check login
class connect extends dashboard {

    static public $UserLayout = "backend";

    function __construct() {
        new \Controller\backend();
        parent::CheckCurentProjec();
        try {
            \Core\ViewTheme::set_viewthene("backend");
        } catch (Exception $exc) {
            echo "Loi";
        }
    }

    function index() {
        \Module\project\Model\Project::SetCurentProject($this->getParam()[0]);
        return $this->ModelView([], "");
    }

}
