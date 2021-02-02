<?php

namespace Module\project\Controller;

// controller
// tất cả class thừa kế từ class này phải check login
class dashboard extends index {

    static public $UserLayout = "backend";

    function __construct() {
        parent::__construct();
        \Core\ViewTheme::set_viewthene("backend");
    }

    function index() {
        return $this->ModelView([], "");
    }

    function dashboard() {
        return $this->ModelView([], "");
    }

    function CheckCurentProjec() {
        $CurentProjec = \Module\project\Model\Project::GetCurentProject(true);
        if ($CurentProjec == null) {
            \Application\redirectTo::Url("/project/dashboard/index/");
            return;
        }
        if (\Module\user\Model\Admin::getCurentUser(TRUE)->Groups == \Module\user\Model\Admin::Admin) {
            return;
        }
        $a = $CurentProjec->GetProjectUser();
        if ($a == null) {
            \Application\redirectTo::Url("/project/dashboard/index/");
            return;
        }
    }

    function SetCurentProject() {
        if ($this->getParam()[0]) {
//            var_dump(\Module\project\Model\Project::DecodeData($this->getParam()[0]));
            $id = \Module\project\Model\Project::DecodeData($this->getParam()[0])->Id;
            \Module\project\Model\Project::SetCurentProject($id);
            \Application\redirectTo::Url("/project/controller/index/");
        }
    }

}
