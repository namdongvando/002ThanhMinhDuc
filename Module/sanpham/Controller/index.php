<?php

namespace Module\sanpham\Controller;

use Exception;

class index extends \ApplicationM implements \Controller\IController
{

    static public $UserLayout = "backend";

    function __construct()
    {
        new \Controller\backend();
        try {
            \Core\ViewTheme::set_viewthene("backend");
        } catch (Exception $exc) {
            echo "Loi";
        }
    }

    function index()
    {

        return $this->ViewThemeModlue();
    }

    public function create()
    {
        if (\Common\Form::RequestPost("TaoMaSanPham", null)) {
            try {
                $project = $_POST["project"];
                $pr = new \Module\project\Model\Project();
                $pr->InsertSubmit($project);
                \Application\redirectTo::Url($_SERVER["HTTP_REFERER"]);
            } catch (Exception $exc) {
                echo $exc->getTraceAsString();
            }
        }
    }

    public function delete()
    {
        $id = intval($this->getParam()[0]);
        $DanhMucSP = new \Module\sanpham\Model\DanhMucSanPham();
        $DanhMucSP->DeleteSubmit($id);
        \Common\Common::toUrl("/sanpham/index/");
    }

    public function detail()
    {
    }

    public function edit()
    {
        if (\Common\Form::isPost()) {
            $option = \Common\Form::RequestPost("DanhMuc", []);
            if ($option) {
                $ModelOption = new \Module\sanpham\Model\DanhMucSanPham();
                $ModelOption->UpdateSubmit($option);
            }
        }
        $id = $this->getParam(0);
        $option = new \Module\option\Model\Option($id);
        return $this->ViewThemeModlue(["option" => $option], "");
    }

    public function form()
    {
        $option = [];
        return $this->AView(["option" => $option], "");
    }
}
