<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Model;

/**
 * Phân Quền
 *
 * @author MSI
 */
class Permistion extends \Module\user\Model\Admin {

    public static $ContentPermistion;

    const DirPath = "Module/option/Data/Permistion/";

    public static function CheckPermistion($nhom = [], $not = false) {
        $user = \Module\user\Model\Admin::getCurentUser(true)->Groups;
        if ($not == true) {
            return !in_array($user, $nhom);
        }
        return in_array($user, $nhom);
    }

    public static function GetAminGroups() {
        return [
            self::Admin => "Admin",
            self::Customer => "Khách Hàng Tiêu Dùng",
            self::DaiLy => "Đại Lý/Nhà Phân Phối",
            self::NVKT => "Nhân Viên Kỹ Thuật",
            self::TTBH => "Trung Tâm Bảo Hành",
        ];
    }

    static function GetModule() {
        return parse_ini_file("Module.ini", true);
    }

    static function GetController() {
        $redDirectory = new \lib\redDirectory();
        $Modules = self::GetModule();
//        var_dump($Modules);
        $allController = [];
        foreach ($Modules["Module"] as $ModuleName => $value) {
            $pathController = "Module/{$ModuleName}/Controller/";
            $redDirectory->redDirectoryByPath($pathController, $b);
            $allController[$ModuleName] = $b;
            $b = [];
        }
        return $allController;
    }

    public static function GetFunctionName() {
        $Module = self::GetModule();
    }

    public static function Save2File($k, $value) {
        $io = new \lib\io();
        $content = json_encode($value);
        $filename = self::DirPath . $k . ".per";
        return $io->writeFile($filename, $content);
    }

    public static function GetContentFile($filename, $isArray = true) {

        if (empty(self::$ContentPermistion[$filename])) {
            $filename = self::DirPath . $filename . ".per";
            $content = file_get_contents($filename);
            self::$ContentPermistion[$filename] = json_decode($content, JSON_OBJECT_AS_ARRAY);
        }

        return self::$ContentPermistion[$filename];
    }

    public static function CheckFunction($role, $ModuleName, $ControllerName, $actionName) {
        $role = self::GetContentFile(md5($role));
        return isset($role[$ModuleName][$ControllerName]);
    }

    public static function GetMeThods($PathModule) {
        $PathModule = sprintf("\\Module\\%s\\Config", $PathModule);
        $ConFigModule = new $PathModule();
        return $ConFigModule->Controller();
    }

}
