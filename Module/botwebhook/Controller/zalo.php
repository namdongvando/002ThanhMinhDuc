<?php
namespace Module\botwebhook\Controller;

use ApplicationM;

class zalo extends ApplicationM
{

    function __construct()
    {

    }

    function callback()
    {
        $update = json_decode(file_get_contents('php://input'), TRUE);
        $fileName = sha1(json_encode($update));
        file_put_contents("public/zalo/{$fileName}.txt", json_encode($update, JSON_UNESCAPED_UNICODE));
    }

}


?>