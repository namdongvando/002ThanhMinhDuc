<?php

namespace Model;

class CodeQR {

    const fileName = "public/[username]/";

    public $user;
    public static $io;

    public function __construct($user) {
        if ($user == null) {
            $this->user = "admin";
        } else {
            $this->user = $user;
        }
        if (self::$io == null)
            self::$io = new \lib\io();
    }

    function filePath() {
        $filePath = str_replace("[username]", $this->user, self::fileName);
        if (!is_dir($filePath)) {
            mkdir($filePath, 0777);
        }
        return $filePath . "danhsachQRcode.txt";
    }

    function SaveCode($code) {
        $DSCode = $this->GetCodes();
        if (!isset($DSCode[$code]))
            $DSCode[$code] = $code;
        self::$io->writeFile($this->filePath(), json_encode($DSCode));
    }

    function GetCodes() {
        return json_decode(self::$io->readFile($this->filePath()), JSON_OBJECT_AS_ARRAY);
    }

    public function clearCode() {
        $DSCode = [];
        self::$io->writeFile($this->filePath(), json_encode($DSCode));
    }

}
