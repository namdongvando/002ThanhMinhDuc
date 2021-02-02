<?php

namespace Module\mail\Controller;

// controller
// tất cả class thừa kế từ class này phải check login
class index extends \ApplicationM {

    static public $UserLayout = "backend";

    function __construct() {
        \Model_ViewTheme::set_viewthene("backend");
    }

    function index() {
        
    }

    function edit() {
        if (\Model\params::isPost()) {
            $_Mail = $_POST["Mail"];
            $MMail = new \Module\mail\Model\MailContent();
            $Mail = $MMail->getRowById($_Mail["Id"]);
            if ($Mail) {
                $Mail["Name"] = $_Mail["Name"];
                if ($Mail["Active"] < 2)
                    $Mail["Code"] = $_Mail["Code"];
                $Mail["Content"] = $_Mail["Content"];
                $MMail->UpdateMailConTent($Mail);
            }
            new \Model\Alert("success", "Đã cập nhật.");
            \Model\Common::toUrl($_SERVER["HTTP_REFERER"]);
            exit();
        }
        $id = $this->getParam()[0];
        $MMail = new \Module\mail\Model\MailContent();
        $MailDetail = $MMail->getRowById($id);
        $this->ViewModule(["Mail" => $MailDetail]);
    }

    function add() {

        if (\Model\params::isPost()) {
            $Mail = $_POST["Mail"];
            $MMail = new \Module\mail\Model\MailContent();
            $id = $MMail->InsertMailConTent($Mail);
            \Model\Common::toUrl("/mail/index/edit/" . $id);
            exit();
        }


        $this->ViewModule();
    }

    function delete() {
        $id = $this->getParam()[0];
        $MMail = new \Module\mail\Model\MailContent();
        $MMail->DeleteById($id);
        $this->ViewModule();
        \Model\Common::toUrl($_SERVER["HTTP_REFERER"]);
    }

}
