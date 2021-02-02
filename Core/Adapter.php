<?php

namespace Core;

class Adapter {

    static protected $_conn = "";
    static protected $_result = "";
    static protected $_Query = "";

    public function __construct() { // Kết nối csdl đầu tiên
        global $INI;
        self::$_conn = mysqli_connect($INI['host'], $INI['username'], $INI['password'], $INI['DBname']) or mysqli_errno("Can't connect database");
        mysqli_query(self::$_conn, "SET NAMES utf8"); // Chuyển dữ liệu trả về sang kiểu utf8
    }

    public function ThemTable($tablename, $row) {
        $sql = "INSERT INTO `$tablename` SET ";
        $content = null;
        $table = $this->Table($tablename, $row);

        foreach ($table as $k => $v) {
            $v_str = null;
            if (is_numeric($v))
                $v_str = "'{$v}'";
            else if (is_null($v))
                $v_str = 'NULL';
            else
                $v_str = "'{$v}'";

            $content .= "`$k`=$v_str,";
        }

        $content = trim($content, ',');
        $sql .= $content;
        self::$_Query = $sql;
    }

    public function _createDir($StringPath, $SubString = '/') {

        $Dir = explode($SubString, $StringPath);
        $root = reset($Dir) . $SubString;
        if (!is_dir($root)) {
            mkdir($root, 0777);
        }
        unset($Dir[0]);
        foreach ($Dir as $NDir) {
            if ($NDir) {
                $root .= $NDir . $SubString;
                if (!is_dir($root)) {
                    mkdir($root, 0777);
                }
            }
        }
    }

    public function _createFile($StringPathFile, $NoiDung) {
        $myfile = fopen($StringPathFile, "w") or die("Unable to open file!");
        fwrite($myfile, $NoiDung);
        fclose($myfile);
    }

    public function Bokytusql($str) {
        $str = addslashes($str);
        return $str;
    }

    function guimail($NoiDungMail) {
//      $tennguoigui = trim(strip_tags($NoiDungMail['tennguoigui']));
        $tennguoigui = $NoiDungMail['NguoiGui'];
        // mail nguoi nhan
        $to_email = $NoiDungMail['ToMail'];
//      $from_email = trim(strip_tags($NoiDungMail['emailgui']));
//      mail gửi/
        $from_email = $NoiDungMail['FromMail'];

//      Tiêu đề mail
        $tieude = $NoiDungMail['TieuDe'];
//      nội dung mail
        $noidung = $NoiDungMail['NoiDung'];
//
        $username = $NoiDungMail['FromMail']; // Tài khoản gmail dùng để gửi thư
        $password = $NoiDungMail['PassWord']; // mật khẩu của tài khoản gửi mail
        require_once 'PHPMailerAutoload.php';
        $mail = new PHPMailer();
        $mail->isSMTP(); //Tell PHPMailer to use SMTP
        $mail->SMTPDebug = 2; //0=off,1=client messages,2=client and server messages
        $mail->Debugoutput = 'html';
        $mail->CharSet = 'UTF-8';
        $mail->ContentType = 'text/html; charset=utf-8';
        $mail->Host = "smtp.gmail.com";
        $mail->Port = 465;  //25,465 or 587
        $mail->SMTPSecure = 'ssl';
        $mail->SMTPAuth = true;
        $mail->Username = $username;
        $mail->Password = $password;
        $mail->setFrom($from_email, $tennguoigui);
        $mail->addAddress($to_email);
        $mail->Subject = $tieude;
        $mail->msgHTML($noidung);
        //$mail->addAttachment('images/phpmailer_mini.gif');
        if (!$mail->send())
            return "Lỗi: " . $mail->ErrorInfo;
        else
            return "Đã gửi mail";
    }

    function _header($url) {
        header("Location: " . $url);
        exit();
    }

    function bodautv($str) {
        if (!$str)
            return false;

        $str = str_replace(array(',', '<', '>', '&', '{', '}', "[", "]", '*', '?', '/', '+', '@', '%', '"'), array(' '), $str);
        $str = str_replace(array("'"), array(' '), $str);
        while (strpos($str, "  ") > 0) {
            $str = str_replace("  ", " ", $str);
        }
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ằ|Ẳ|Ẵ|Ặ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'd' => 'đ',
            'D' => 'Đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ử|Ữ|Ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ'
        );
        foreach ($unicode as $khongdau => $codau) {
            $str = preg_replace("/($codau)/i", $khongdau, $str);
        }
        $str = strtolower($str);
        $str = trim($str);
        $str = preg_replace('/[^a-zA-Z0-9\ ]/', '', $str);
        $str = str_replace(" ", "-", $str);
        return $str;
    }

    function _subStringUnicode($str, $SL) {
        return mb_substr($str, 0, $SL, 'UTF-8');
    }

    function upload_image($file, $extension, $folder, $tienTo) {
        $ext = trim(substr($file["type"], 6, strlen($file["type"])));
        $name = basename($file['name'], '.' . $ext);
        $extension = "jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF";
        if (strpos($extension, $ext) === false) {
            return false;
        }
        if (file_exists($folder . $name))
            for ($i = 0; $i < 100; $i++) {
                if (!file_exists($folder . $name . $i . '.' . $ext)) {
                    $file['name'][$k] = $name . $i . '.' . $ext;
                    break;
                }
            }
        $file['name'] = $folder . $tienTo . "." . $ext;
        copy($file["tmp_name"], $file['name']);
        move_uploaded_file($file["tmp_name"], $file['name']);
        return $file['name'];
    }

    function mkdir_r($dirName, $rights = 0777) {
        $dirs = explode('/', $dirName);
        $dir = '';
        foreach ($dirs as $part) {
            $dir .= $part . '/';
            if (!is_dir($dir) && strlen($dir) > 0)
                mkdir($dir, $rights);
        }
    }

    function upload_image1($file, $folder, $tt = "sp-", $isNameFile = false) {
        $this->mkdir_r($folder);
        if (!is_dir($folder)) {
            mkdir($folder, 0777);
        }
        if (!$isNameFile) {
            $tienTo = $tt . time() . rand(1, 2000);
        } else {
            $tienTo = $tt;
        }
        $ext = trim(substr($file["type"], 6, strlen($file["type"])));
        $name = basename($file['name'], '.' . $ext);
        $extension = "jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF";
        if (strpos($extension, $ext) === false) {
            return false;
        }
        if (file_exists($folder . $name))
            for ($i = 0; $i < 100; $i++) {
                if (!file_exists($folder . $name . $i . '.' . $ext)) {
                    $file['name'][$k] = $name . $i . '.' . $ext;
                    break;
                }
            }
        $file['name'] = $folder . $tienTo . "." . $ext;
        copy($file["tmp_name"], $file['name']);
        move_uploaded_file($file["tmp_name"], $file['name']);
        return $file['name'];
    }

    function upload_multi_image($file, $folder, $tt = "sp-", $isNameFile = false) {
        $this->mkdir_r($folder);
        $extension = "jpg|jpeg|png|gif|JPG|JPEG|PNG|GIF";
        $listName = array();
        foreach ($file['name'] as $k => $name) {
            if (!$isNameFile) {
                $tienTo = $tt . $k;
            } else {
                $tienTo = $tt;
            }
            $ext = trim(substr($file["type"][$k], 6, strlen($file["type"][$k])));
            $name = basename($file['name'][$k], '.' . $ext);
            if ($ext) {
                if (strpos($extension, $ext) === false) {
                    break;
                }
                if (file_exists($folder . $file['name'][$k]))
                    for ($i = 0; $i < 100; $i++) {
                        if (!file_exists($folder . $name . $i . '.' . $ext)) {
                            $file['name'][$k] = $name . $i . '.' . $ext;
                            break;
                        }
                    }
                $listName[$k] = $file['name'][$k] = $folder . $tienTo . "-" . $k . '.' . $ext;
                copy($file["tmp_name"][$k], $file['name'][$k]);
                move_uploaded_file($file["tmp_name"][$k], $file['name'][$k]);
            }
        }
        return $listName;
    }

    function RandomString($a) {
        $md5_hash = md5(rand(0, 9999) . time());
        $security_code = substr($md5_hash, 2, 10);
        return $security_code;
    }

}

?>
