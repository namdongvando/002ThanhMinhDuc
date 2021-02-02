<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of redirectUrl
 *
 * @author MSI
 */

namespace Application;

class redirectTo {

    static public function Url($url) {
        \Common\Common::toUrl($url);
        die();
    }

}
