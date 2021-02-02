<?php

namespace Module\user\Model;

class modeluser {

    public $Address;
    public $BirthDate;
    public $Code;
    public $DistrictCode;
    public $DistrictName;
    public $Email;
    public $FullName;
    public $Gender;
    public $HasRegistered;
    public $HealthInsurance;
    public $IC;
    public $Id;
    public $Image;
    public $LoginProvider;
    public $Phone;
    public $ProvinceCode;
    public $ProvinceName;
    public $Role;
    public $Username;
    public $WardCode;
    public $WardName;

    function __construct($u = null) {
          
         if ($u) {
            $this->Address = $u["Address"];
            $this->BirthDate = $u["BirthDate"];
            $this->Code = $u["Code"];
            $this->DistrictCode = $u["DistrictCode"];
            $this->DistrictName = $u["DistrictName"];
            $this->Email = $u["Email"];
            $this->FullName = $u["FullName"];
            $this->Gender = $u["Gender"];
            $this->HasRegistered = $u["HasRegistered"];
            $this->HealthInsurance = $u["HealthInsurance"];
            $this->IC = $u["IC"];
            $this->Id = $u["Id"];
            $this->Image = $u["Image"];
            $this->LoginProvider = $u["LoginProvider"];
            $this->Phone = $u["Phone"];
            $this->ProvinceCode = $u["ProvinceCode"];
            $this->ProvinceName = $u["ProvinceName"];
            $this->Role = $u["Role"];
            $this->Username = $u["Username"];
            $this->WardCode = $u["WardCode"];
            $this->WardName = $u["WardName"];
        }
    }

}
?>

