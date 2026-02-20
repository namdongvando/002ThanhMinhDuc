<?php

namespace Module\product\Controller; 
use Exception;

class index extends \ApplicationM
{ 
    function __construct()
    {
        new \Controller\backend();
        // thừa kế từ controller backend
        // controller này phải đăng nhập mới có thể vào.
        try {
            \Core\ViewTheme::set_viewthene("backend");
            // chọn theme hiển thị
        } catch (Exception $exc) {
            echo "Loi";
        }
    }
    function index() {
        // action  index
        // url: /product/index/index/
        return $this->ViewThemeModlue();
        // sử dụng view 
    }
}
