<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model;

/**
 * Description of OptionsService
 *
 * @author MSI
 */
class OptionsService  
{



    static protected $OptionData = [];
    const TrangThaiDonHang = "TrangThaiDonHang";
    const DVT = "DVT";
    const QuyCachDongGoi = "QuyCachDongGoi";
    const HinhThucThuMua = "HinhThucThuMua";

    public $Id;
    public $Name;
    public $Val;
    public $Des;
    public $STT;
    public $Keyword;
    public $GroupsId;

    public function __construct($op = null)
    {
        if ($op) {
            // var_dump($op);
            if (!is_array($op)) {
                $Id = $op;
                $op = $this->GetById($Id);
                // var_dump($op);
                // var_dump("__op");
            }
        }

        $this->Id = $op["Id"] ?? null;
        $this->Name = $op["Name"] ?? null;
        $this->Val = $op["Val"] ?? null;
        $this->Des = $op["Des"] ?? null;
        $this->STT = $op["STT"] ?? null;
        $this->GroupsId = $op["GroupsId"] ?? null;
    }

    //put your code here
    public function Delete($Id)
    {
    }

    function LoadData()
    {

    }

    public function GetById($Id)
    {
        if (self::$OptionData[$Id] ?? null) {
            self::$OptionData[$Id];
        }
      
    }

    public function GetItems($params, $indexPage, $pageNumber, &$total)
    {
        $where = "`GroupsId` = '{$params["GroupsId"]}' and `Name` like '%{$params["keyword"]}%'";
        // return $this->SelectPT($where, $indexPage, $pageNumber, $total);
    }

    public function Post($model)
    {
        if (!isset($model["Id"])) {
            $model["Id"] = Common::uuid();
        }
        // return $this->Insert($model);
    }

    public function Put($model)
    {
        // return $this->UpdateRow($model);
    }

    public static function GetGroupsToSelect($idGroups)
    {
        $op = new OptionsService();
        // return $op->SelectToOptions("`GroupsId`= '{$idGroups}' order by `STT` DESC ", ["Val", "Name"]);
    }

    public static function ToSelect()
    {
        $op = new OptionsService();
        // return $op->SelectToOptions("1=1", ["Val", "Name"]);
    }

}
