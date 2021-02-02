<?php

namespace Module\project\Controller;

ob_start();

class api extends \ApplicationM {

    function __construct() {
        new \Controller\backend();
        header('Content-Type: application/json');
    }

    function getDataController($id) {
        $Controller = new \Module\project\Model\ControllerData();
        $Controller->getControllerDatasByController($id);
    }

    function dashboard() {
        $Project = \Module\project\Model\Project::GetCurentProject(true);
        $data["TongKhachHang"] = $Project->TongKhachHang();
        $data["SoLuongProject"] = 1;
        $data["WifiRouter"] = count($this->GetControllerByProject());
        $data["UserAdmin"] = count($this->usersByProject());
        echo \lib\APIs::Json_encode($data);
    }

    function projectByUser() {
        $UserProject = new \Module\project\Model\ProjectUsers();

        $Admin = \Module\user\Model\Admin::getCurentUser(true);
        if ($Admin->isAdmin()) {
            $a = $UserProject->GetAll();
        } else {
            $a = $UserProject->GetByUserId();
        }

        foreach ($a as $key => $value) {
            $admin = new \Module\user\Model\Admin();
            $Project = new \Module\project\Model\Project();
            $adminById = new \Module\user\Model\Admin($admin->GetById($value["AdminId"]));
            $_Project = new \Module\project\Model\Project($Project->GetById($value["PId"]));
            $value["user"] = $adminById->AdminViewModel();
            $value["Project"] = $_Project->ProjecViewModel();
            $a[$key] = $value;
        }
        echo \lib\APIs::Json_encode($a);
    }

    function projects() {
        $model_option = new \Module\project\Model\Project();
        $Options = $model_option->GetAll();
        foreach ($Options as $key => $value) {
            $Mvalue = new \Module\project\Model\Project($value);
            $value["Status"] = $Mvalue->Status();
            $_value = $value;
//            var_dump($_value);
            $_value["Address"] = "";
//            var_dump($_value);
            $value["Id"] = $Mvalue->EncodeData();
            $Options[$key] = $value;
        }

        echo \lib\APIs::Json_encode($Options);
    }

    function usersByProject() {
        $UserProject = new \Module\project\Model\ProjectUsers();
        $a = $UserProject->GetByProjectId();
        foreach ($a as $key => $value) {
            $admin = new \Module\user\Model\Admin();
            $adminById = $admin->GetById($value["AdminId"]);
            $value["user"] = $adminById;
            $a[$key] = $value;
        }
        return $a;
    }

    /**
     * user by project
     * @param {type} parameter
     */
    function users() {
        $UserProject = new \Module\project\Model\ProjectUsers();
        $a = $UserProject->GetByProjectId();
        foreach ($a as $key => $value) {
            $admin = new \Module\user\Model\Admin();
            $adminById = $admin->GetById($value["AdminId"]);
            $value["user"] = $adminById;
            $a[$key] = $value;
        }
        echo \lib\APIs::Json_encode($a);
    }

    function usersproject() {
        $projecID = \Module\project\Model\Project::GetEditProject(true)->Id;
        $UserProject = new \Module\project\Model\ProjectUsers();
        $a = $UserProject->GetByProjectId($projecID);
        foreach ($a as $key => $value) {
            $admin = new \Module\user\Model\Admin();
            $adminById = $admin->GetById($value["AdminId"]);
            $value["user"] = $adminById;
            $a[$key] = $value;
        }
        echo \lib\APIs::Json_encode($a);
    }

    function projectController() {
        $model_option = new \Module\project\Model\Controller();
        $projecID = \Module\project\Model\Project::GetEditProject(true)->Id;
        $UserProject = new \Module\project\Model\Controller();
        $a = $UserProject->GetControllerByProject($projecID);
        foreach ($a as $key => $value) {
            $value["token"] = $model_option->CodeId($value["Id"]);
            $value["LinkLogin"] = "http://" . $value["Ip"];
            $a[$key] = $value;
        }
        echo \lib\APIs::Json_encode($a);
    }

    /**
     * get all usr
     * @param {type} parameter
     */
    function allusers() {
        $UserProject = new \Module\user\Model\Admin();
        $a = $UserProject->GetUserActive();
        echo \lib\APIs::Json_encode($a);
    }

    function addusersproject() {
        $editP = \Module\project\Model\Project::GetEditProject(true);
        $PS = new \Module\project\Model\ProjectUsers();
        $model["PId"] = $editP->Id;
        $model["AdminId"] = $this->getParam()[0];
        $model["Active"] = TRUE;
        $model["DateCreate"] = date("Y-m-d H:i:s", time());
        $model["Note"] = json_encode([]);
        $PS->InsertSubmit($model);
    }

    function removeusersproject() {
        $editP = \Module\project\Model\Project::GetEditProject(true);
        $PS = new \Module\project\Model\ProjectUsers();
        $AdminId = $this->getParam()[0];
        $PS->DeleteProjecUser($editP->Id, $AdminId);
    }

    function GetControllerByProject() {
        $model_option = new \Module\project\Model\Controller();
        $PId = \Module\project\Model\Project::GetCurentProject(true)->Id;
        $where = "`PId` = '{$PId}'";
        $Options = $model_option->GetRows($where);
        foreach ($Options as $key => $value) {
            $value["token"] = $model_option->CodeId($value["Id"]);
            $value["LinkLogin"] = "http://" . $value["Ip"];
            $Options[$key] = $value;
        }
        return $Options;
    }

    function controller() {
        $model_option = new \Module\project\Model\Controller();
        $PId = \Module\project\Model\Project::GetCurentProject(true)->Id;
        $where = "`PId` = '{$PId}'";
        $Options = $model_option->GetRows($where);
        foreach ($Options as $key => $value) {
            $value["token"] = $model_option->CodeId($value["Id"]);
            $value["LinkLogin"] = "http://" . $value["Ip"];
            $Options[$key] = $value;
        }
        echo \lib\APIs::Json_encode($Options);
    }

    function controllerdata() {
        $model_option = new \Module\project\Model\ControllerData();
        $Controller = new \Module\project\Model\Controller();
        $DataToken = $Controller->TokenDecode($this->getParam()[0]);
        $where = "`ControllerId` = '{$DataToken->Id}'";
        $Options = $model_option->GetRows($where);
        echo \lib\APIs::Json_encode($Options);
//        $this->getDataController($DataToken->Id);
    }

    function controllersdata() {
        $Project = \Module\project\Model\Project::GetCurentProject(TRUE);
        $Controllers = $Project->GetControllersId();
        $Controllers = implode(",", $Controllers);
        $model_option = new \Module\project\Model\ControllerData();
        $where = "`ControllerId` in ({$Controllers})";
        $Options = $model_option->GetRows($where);
        echo \lib\APIs::Json_encode($Options);
    }

    function controllersdataajaxPt() {

        $_length = isset($_GET["length"]) ? intval($_GET["length"]) : 10;
        $_start = isset($_GET["start"]) ? intval($_GET["start"]) : 0;


        $Project = \Module\project\Model\Project::GetCurentProject(TRUE);
        $Controllers = $Project->GetControllersId();
        $Controllers = implode(",", $Controllers);
        $model_option = new \Module\project\Model\ControllerData();
        $where = "`ControllerId` in ({$Controllers})";
        $Options = $model_option->GetRows($where);
        $OptionData = [];
        $where = "`ControllerId` in ({$Controllers}) limit {$_start},{$_length}";
        $OptionsLimit = $model_option->GetRows($where);

        foreach ($OptionsLimit as $k => $value) {

            $_value[0] = $k + 1;
            $_value[1] = $value["Col0"];
            $_value[2] = $value["Col1"];
            $_value[3] = $value["Col2"];
            $_value[4] = $value["Col3"];
            $_value[5] = $value["Col4"];
            $_value[6] = $value["Col5"];
            $OptionData[] = $_value;
        }
        // "draw": 9,
//  "recordsTotal": 57,
//  "recordsFiltered": 57,
        $data["draw"] = isset($_GET["draw"]) ? intval($_GET["draw"]) : 1;
        $data["recordsTotal"] = count($Options);
        $data["recordsFiltered"] = count($Options);
        $data["data"] = $OptionData;
        echo \lib\APIs::Json_encode($data);
    }

    function controllersdataajax() {
        $Project = \Module\project\Model\Project::GetCurentProject(TRUE);
        $Controllers = $Project->GetControllersId();
        $Controllers = implode(",", $Controllers);
        $model_option = new \Module\project\Model\ControllerData();
        $where = "`ControllerId` in ({$Controllers})";
        $Options = $model_option->GetRows($where);
        $OptionData = [];
        foreach ($Options as $k => $value) {

            $_value[0] = $k + 1;
            $_value[1] = $value["Col0"];
            $_value[2] = $value["Col1"];
            $_value[3] = $value["Col2"];
            $_value[4] = $value["Col3"];
            $_value[5] = $value["Col4"];
            $_value[6] = $value["Col5"];
            $OptionData[] = $_value;
        }
        $data["data"] = $OptionData;
        echo \lib\APIs::Json_encode($data);
    }

    function controllerdatabyid() {
        ob_start();
        echo "";
        $Controller = new \Module\project\Model\ControllerData();
        $Controller1 = new \Module\project\Model\Controller;
        $DataToken = $Controller1->TokenDeCode($this->getParam()[0]);
        $data = $Controller->getControllerDatasByController($DataToken->Id);
        echo "done";
    }

    public function TokenDeCode($param0) {

    }

}
?>

