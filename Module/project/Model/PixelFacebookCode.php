<?php

namespace Module\project\Model;

use PFBC\Element;

class PixelFacebookCode extends ProjectSeting {

    public static $options = ["class" => "form-control"];
    public $TextValues;
    public $UUID;
    public $PId;

    const Name = "Pixel Facebook Code";
    const Keyword = "pixelfacebook";

    public function __construct($pid) {
        parent::__construct();

        $a = $this->GetProjectSetingByKeyPid(self::Keyword, $pid);
        if (!$a) {
            $this->createProjectSeting(self::Name, $pid, self::Keyword, "");
        }
        $a = $this->GetProjectSetingByKeyPid(self::Keyword, $pid);
        $this->TextValues = $a["TextValues"];
        $this->UUID = $a["UUID"];
        $this->PId = $a["PId"];
    }

    static function pixelfacebook($value = "") {
        $properties = self::$options;
        $properties["value"] = $value;
        $keyword = self::Keyword;
        return new Element\Textarea(self::Name, "projectseting[{$keyword}]", $properties);
    }

    /**
     * luu gia tri theo du an
     * @param {type} parameter
     */
    public function Save($pid, $value) {
        $model = $this->GetProjectSetingByKeyPid(self::Keyword, $pid);
        $model["TextValues"] = $value;
        return $this->UpdateSubmit($model);
    }

}
