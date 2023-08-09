<?php
namespace Model;

use Module\option\Model\Option;
use PFBC\Element\Select;

class FormCommon
{

  static  public function LyDoXuatKho($val = null, $Name, $prop)
    {
        $Options = Option::GetAll2OptionsByGroups("XuatKho_LyDo");
        $prop["value"] = $prop["value"] ?? $val;
        $lbl = "<a href='/option/index/groups/XuatKho_LyDo/' ><i class='fa fa-plus' ></i></a>";
        return new FormRender(new Select("Lý Do Xuất Kho {$lbl}", $Name, $Options, $prop));

    }

}