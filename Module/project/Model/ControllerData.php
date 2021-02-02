<?php

namespace Module\project\Model;

include_once 'simplehtmldom/simple_html_dom.php';

class ControllerData extends ControllerDataTable {

    public $Id, $Col0,
            $Col1,
            $ControllerId,
            $Col2,
            $Col3,
            $Col4,
            $Col5;

    function __construct($user = null) {
        parent::__construct();
        if ($user) {
            $this->Id = !empty($user["Id"]) ? $user["Id"] : null;
            $this->Col0 = !empty($user["Col0"]) ? $user["Col0"] : null;
            $this->Col1 = !empty($user["Col1"]) ? $user["Col1"] : null;
            $this->Col2 = !empty($user["Col2"]) ? $user["Col2"] : null;
            $this->Col3 = !empty($user["Col3"]) ? $user["Col3"] : null;
            $this->Col4 = !empty($user["Col4"]) ? $user["Col4"] : null;
            $this->Col5 = !empty($user["Col5"]) ? $user["Col5"] : null;
            $this->ControllerId = !empty($user["ControllerId"]) ? $user["ControllerId"] : null;
        }
    }

    public function getUserDatasSocialUserList($id) {
        $response = $this->getSocialUserListHtml($id);
        $rowdata = [];
        if ($response) {
            $html = str_get_html($response);
            $box = $html->find("table.box tr");
            foreach ($html->find("table.testgrid tr") as $key => $value) {
                if ($key == 0) {
                    $trhtml = str_get_html($value->innertext);
                    $unique = 0;
                    foreach ($trhtml->find("td") as $key => $value) {
                        if (strpos($value->innertext, "unique")) {
                            $unique = $key;
                        }
                    }
                } else {

                    $trhtml = str_get_html($value->innertext);
                    $row[0] = $trhtml->find("td")[0]->innertext;
                    $row[1] = isset($trhtml->find("td")[1]) ? $trhtml->find("td")[1]->innertext : "";
                    $row[2] = isset($trhtml->find("td")[2]) ? $trhtml->find("td")[2]->innertext : "";
                    $row[3] = isset($trhtml->find("td")[3]) ? $trhtml->find("td")[3]->innertext : "";
                    $row[4] = isset($trhtml->find("td")[4]) ? $trhtml->find("td")[4]->innertext : "";
                    $row[5] = isset($trhtml->find("td")[5]) ? $trhtml->find("td")[5]->innertext : "";
                    $temp = $row[$unique];
                    $row[$unique] = $row[0];
                    $row[0] = $temp;
                    $rowTable["Col0"] = $row[0];
                    $rowTable["Col1"] = $row[1];
                    $rowTable["Col2"] = $row[2];
                    $rowTable["Col3"] = $row[3];
                    $rowTable["Col4"] = $row[4];
                    $rowTable["Col5"] = $row[5];
                    $rowTable["ControllerId"] = $id;
                    $rowdata[] = $rowTable;
                }
            }
        }
        return $rowdata;
    }

    function getSocialUserListHtml($idController) {
        $controller = new Controller();
        $_Controller = new Controller($controller->GetById($idController));
        $URL = sprintf("http://%s/UserAuthentication/SocialUserList.shtml", $_Controller->Ip);
        $Cookie = sprintf("Cookie: language=English; adm=%s; admpwd=%s;", $_Controller->Username, md5($_Controller->Password));

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                $Cookie
            ),
        ));
        $response = curl_exec($curl);
        $response = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $response);
        $response = strtolower($response);
        return $response;
    }

    function getFreeUserListHtml($idController) {
        $controller = new Controller();
        $_Controller = new Controller($controller->GetById($idController));
        $URL = sprintf("http://%s/UserAuthentication/FreeUserList.shtml", $_Controller->Ip);
        $Cookie = sprintf("Cookie: language=English; adm=%s; admpwd=%s;", $_Controller->Username, md5($_Controller->Password));
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                $Cookie
            ),
        ));
        $response = curl_exec($curl);
        $response = preg_replace('#<script(.*?)>(.*?)</script>#is', '', $response);
        $response = strtolower($response);
        return $response;
    }

    public function getUserDatasFreeUserList($id) {

        $response = $this->getFreeUserListHtml($id);
        $rowdata = [];
        if ($response) {
            $html = str_get_html($response);
            $box = $html->find("table.box tr");
            foreach ($html->find("table.testgrid tr") as $key => $value) {
                if ($key == 0) {
                    $trhtml = str_get_html($value->innertext);
                    $unique = 0;
                    foreach ($trhtml->find("td") as $key => $value) {
                        if (strpos($value->innertext, "unique")) {
                            $unique = $key;
                        }
                    }
                } else {
                    $trhtml = str_get_html($value->innertext);
                    $row[0] = $trhtml->find("td")[0]->innertext;
                    $row[1] = isset($trhtml->find("td")[1]) ? $trhtml->find("td")[1]->innertext : "";
                    $row[2] = isset($trhtml->find("td")[2]) ? $trhtml->find("td")[2]->innertext : "";
                    $row[3] = isset($trhtml->find("td")[3]) ? $trhtml->find("td")[3]->innertext : "";
                    $row[4] = isset($trhtml->find("td")[4]) ? $trhtml->find("td")[4]->innertext : "";
                    $row[5] = isset($trhtml->find("td")[5]) ? $trhtml->find("td")[5]->innertext : "";
                    $temp = $row[$unique];
                    $row[$unique] = $row[0];
                    $row[0] = $temp;
                    $rowTable["Col0"] = $row[0];
                    $rowTable["Col1"] = $row[1];
                    $rowTable["Col2"] = $row[2];
                    $rowTable["Col3"] = $row[3];
                    $rowTable["Col4"] = $row[4];
                    $rowTable["Col5"] = $row[5];
                    $rowTable["ControllerId"] = $id;
                    $rowdata[] = $rowTable;
                }
            }
        }
        return $rowdata;
    }

    public function LoginController($id) {
        $controller = new Controller();
        $_Controller = new Controller($controller->GetById($id));
        $URL = sprintf("http://%s/check.shtml", $_Controller->Ip);
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => $URL,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => array('adm_name' => $_Controller->Username, 'adm_pwd' => $_Controller->Password),
            CURLOPT_HTTPHEADER => array(),
        ));
        $response = curl_exec($curl);
        curl_close($curl);
    }

    public function getControllerDatasByController($id) {
        $this->LoginController($id);
        $a = $this->getUserDatasSocialUserList($id);
        $b = $this->getUserDatasFreeUserList($id);
        $c = array_merge($a, $b);
//        var_dump($c);
        $this->InsertRowsArrayTable($c);
        return $c;
    }

    public function TongControllerData($ControllerIds) {
        $ControllerIdsStr = implode(",", $ControllerIds);
        $where = "SELECT count(*) as `Tong` FROM `" . $this->TableName . "` where `ControllerId` in ({$ControllerIdsStr}) ";
        $a = $this->fechRow($this->runsql($where));
        return $a["Tong"];
    }

    public function GetDataByController($ControllerId) {
        $where = "`ControllerId` = '{$ControllerId}' limit 0,1";
        $a = $this->GetRows($where);
        return $a;
    }

}
