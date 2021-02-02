<?php

namespace Module\mail\Model;

class MailContent extends MialContentTable {

    public $Id;
    public $Code;
    public $Name;
    public $Content;

    const MailDoiPassword = "MailDoiPassword";
    const MailResetpassword = "MailResetpassword";
    const MailEditInfor = "MailEditInfor";

    public static $DataContent;

    function __construct($user = null) {
        parent::__construct();
        if ($user) {
            $this->Id = !empty($user["Id"]) ? $user["Id"] : null;
            $this->Name = !empty($user["Name"]) ? $user["Name"] : null;
            $this->Code = !empty($user["Code"]) ? $user["Code"] : null;
            $this->Content = !empty($user["Content"]) ? $user["Content"] : null;
        }
    }

    public function getMailContents() {
        return $this->getRowsBy();
    }

    public function InsertMailConTent($Mail) {
        return $this->insertTable($Mail);
    }

    function linkEditMail() {
        return "/mail/index/edit/" . $this->Id;
    }

    function linkDeleteMail() {
        return "/mail/index/delete/" . $this->Id;
    }

    public function DeleteById($id) {
        return $this->deleteTable($id);
    }

    public function UpdateMailConTent($Mail) {
        return $this->updateTable($Mail);
    }

    public function getMailContentsByCode($param0) {
        $where = "`Code` = '{$param0}'";
        $a = $this->getRowsBy($where);
        return $a[0];
    }

    public static function setContentData($param0) {
        self::$DataContent = $param0;
    }

    public static function ContentDecode($param0) {
        $MailContent = new \Module\mail\Model\MailContent();
        $Mail = $MailContent->getMailContentsByCode($param0);
        $Content = $Mail["Content"];
        $Title = $Mail["Name"];
        foreach (self::$DataContent as $key => $value) {
            $Content = str_replace("[{$key}]", $value, $Content);
            $Title = str_replace("[{$key}]", $value, $Title);
        }
        $Title = str_replace("[time]", time(), $Title);
        $Content = str_replace("[time]", time(), $Content);
        $data["Content"] = $Content;
        $data["Title"] = $Title;
        return $data;
    }

}
