<?php

namespace Module\project\Controller;

// controller
// tất cả class thừa kế từ class này phải check login
class pixelfacebook extends \ApplicationM {

    static public $UserLayout = "backend";

    function __construct() {
        new \Controller\backend();
        try {
            \Core\ViewTheme::set_viewthene("backend");
        } catch (Exception $exc) {
            echo "Loi";
        }
    }

    /**
     * khởi tạo PixelFacebook nếu chưa co
     * @param {type} parameter
     */
    function index() {
        $pid = \Module\project\Model\Project::GetCurentProject(true)->Id;
        if (isset($_POST["Save"])) {
            $value = $_POST["projectseting"][\Module\project\Model\PixelFacebookCode::Keyword];
            $a = new \Module\project\Model\PixelFacebookCode($pid);
            $a->Save($pid, $value);
        }
        $a = new \Module\project\Model\PixelFacebookCode($pid);

        return $this->ModelView(["pixelfacebook" => $a], "");
    }

}
