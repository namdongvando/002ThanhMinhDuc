<?php

namespace lib;

class imageComp {

    static public $imagesDefault = "";

    function __construct() {
        
    }

    static function SetImagesDefault($param) {
        self::$imagesDefault = $param;
    }

// có đường dan hinh
    function layHinh($avata, $w, $h, $CapNha = FALSE) {
        try {
            $url = substr($avata, 1);
            if (file_exists($url)) {
                if (getimagesize($url)) {
                    $a = explode(basename($url), $url);
                    $ThuMuc = reset($a);
                    $TenHinh = basename($url);
                    $filename = $ThuMuc . $TenHinh;
                    $_TenHinh = explode(".", $TenHinh);
                    $__TenHinh = reset($_TenHinh);
                    $__MoRong = end($_TenHinh);
                    $ThuMucThumbs = $ThuMuc . "_thumbs/";
                    if (!is_dir($ThuMuc)) {
                        mkdir($ThuMuc, 0777);
                    }
                    if (!is_dir($ThuMucThumbs)) {
                        mkdir($ThuMucThumbs, 0777);
                    }
                    $KiemTraHinh = $ThuMucThumbs . $__TenHinh . "_{$h}x{$w}.{$__MoRong}";

                    if ($CapNha) {
                        return $ThuMucThumbs . $this->create_thumb($TenHinh, $w, $h, $ThuMuc, $__TenHinh, 1.7);
                    }
                    if (file_exists($KiemTraHinh)) {
                        return $KiemTraHinh;
                    }
                    return $ThuMucThumbs . $this->create_thumb($TenHinh, $w, $h, $ThuMuc, $__TenHinh, 1.7);
                }
            }
            return self::$imagesDefault;
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
    }

// len hinh theo đường dan
    function lenHinh($avata, $w, $h) {
        $url = substr($avata, 1);
        if (file_exists($url)) {
            if (getimagesize($url)) {
                $DuongDanHinh = explode("/", $avata);
                $TenHinhFull = end($DuongDanHinh);
                $aTenHinh = explode(".", $TenHinhFull);
                $TenHinh = reset($aTenHinh);
                $PhanMoRong = end($aTenHinh);
                $ThuMuc = explode($TenHinhFull, $avata);
                $ThuMuc = reset($ThuMuc);
                $ThuMuc = substr($ThuMuc, 1);
                $HKT = $ThuMuc . $TenHinh . "_" . $w . "x" . $h . "." . $PhanMoRong;
                if (file_exists($HKT)) {
                    return "/" . $HKT;
                }
                try {
                    $TenHinhnew = $this->create_thumb($TenHinhFull, $w, $h, $ThuMuc, $TenHinh, 3);
                    return "/" . $ThuMuc . $TenHinhnew;
                } catch (Exception $ex) {
                    return self::$imagesDefault;
                }
            }
        }
        return self::imagesImages;
    }

// lến hình theo $_FILE
    function lenFileHinh($_File, $folder, $height, $width, $TenHinh) {

        $this->create_thumbFile($_File, $width, $height, $folder, $TenHinh, 2);
    }

    function create_thumb($file, $width, $height, $folder, $file_name, $zoom_crop = '2') {
        $new_width = $width;
        $Dai = $width;
        $new_height = $height;
        $Cao = $height;
        if ($new_width && !$new_height) {
            $new_height = floor($height * ($new_width / $width));
        } else if ($new_height && !$new_width) {
            $new_width = floor($width * ($new_height / $height));
        }
        $image_url = $folder . $file;
        $origin_x = 0;
        $origin_y = 0;
// GET ORIGINAL IMAGE DIMENSIONS
        $array = FALSE;
        if (getimagesize($image_url))
            $array = getimagesize($image_url);
        if ($array) {
            list($image_w, $image_h) = $array;
        } else {
            return FALSE;
        }
        $width = $image_w;
        $height = $image_h;
// ACQUIRE THE ORIGINAL IMAGE
        $TenHinh = explode('.', $image_url);
        $image_ext = trim(strtolower(end($TenHinh)));
        switch (strtoupper($image_ext)) {
            case 'JPG' :
            case 'JPEG' :
                $image = imagecreatefromjpeg($image_url);
                $func = 'imagejpeg';
                break;
            case 'PNG' :
                $image = imagecreatefrompng($image_url);
                $func = 'imagepng';
                break;
            case 'GIF' :
                $image = imagecreatefromgif($image_url);
                $func = 'imagegif';
                break;

            default : die("UNKNOWN IMAGE TYPE: $image_url");
        }

// scale down and add borders
        if ($zoom_crop == 3) {

            $final_height = $height * ($new_width / $width);

            if ($final_height > $new_height) {
                $new_width = $width * ($new_height / $height);
            } else {
                $new_height = $final_height;
            }
        }

        // create a new true color image
        $canvas = imagecreatetruecolor($new_width, $new_height);
        imagealphablending($canvas, false);

        // Create a new transparent color for image
        $color = imagecolorallocatealpha($canvas, 255, 255, 255, 127);

        // Completely fill the background of the new image with allocated color.
        imagefill($canvas, 0, 0, $color);
        // scale down and add borders
        if ($zoom_crop == 2) {

            $final_height = $height * ($new_width / $width);

            if ($final_height > $new_height) {

                $origin_x = $new_width / 2;
                $new_width = $width * ($new_height / $height);
                $origin_x = round($origin_x - ($new_width / 2));
            } else {

                $origin_y = $new_height / 2;
                $new_height = $final_height;
                $origin_y = round($origin_y - ($new_height / 2));
            }
        }
        imagesavealpha($canvas, true);
        if ($zoom_crop > 0) {

            $src_x = $src_y = 0;
            $src_w = $width;
            $src_h = $height;

            $cmp_x = $width / $new_width;
            $cmp_y = $height / $new_height;
            if ($cmp_x > $cmp_y) {

                $src_w = round($width / $cmp_x * $cmp_y);
                $src_x = round(($width - ($width / $cmp_x * $cmp_y)) / 2);
            } else if ($cmp_y > $cmp_x) {

                $src_h = round($height / $cmp_y * $cmp_x);
                $src_y = round(($height - ($height / $cmp_y * $cmp_x)) / 2);
            }
            $align = FALSE;
            if ($align) {
                if (strpos($align, 't') !== false) {
                    $src_y = 0;
                }
                if (strpos($align, 'b') !== false) {
                    $src_y = $height - $src_h;
                }
                if (strpos($align, 'l') !== false) {
                    $src_x = 0;
                }
                if (strpos($align, 'r') !== false) {
                    $src_x = $width - $src_w;
                }
            }
            imagecopyresampled($canvas, $image, $origin_x, $origin_y, $src_x, $src_y, $new_width, $new_height, $src_w, $src_h);
        } else {
            imagecopyresampled($canvas, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        }

        $new_file = $file_name . '_' . $Dai . 'x' . $Cao . '.' . $image_ext;

        if ($func == 'imagejpeg')
            $func($canvas, $folder . "_thumbs/" . $new_file, 75);
        else
            $func($canvas, $folder . "_thumbs/" . $new_file, 4);
        return $new_file;
    }

    function create_thumbFile($_file, $width, $height, $folder, $file_name, $zoom_crop = '2') {
        var_dump($_file);
        $new_width = $width;
        $Dai = $width;
        $new_height = $height;
        $Cao = $height;
        if ($new_width && !$new_height) {
            $new_height = floor($height * ($new_width / $width));
        } else if ($new_height && !$new_width) {
            $new_width = floor($width * ($new_height / $height));
        }
        $image_url = $folder . $file_name;
        $origin_x = 0;
        $origin_y = 0;

// GET ORIGINAL IMAGE DIMENSIONS
        $array = FALSE;
        if (getimagesize($_file['tmp_name']))
            $array = getimagesize($_file['tmp_name']);
        var_dump($array);
        if ($array) {
            list($image_w, $image_h) = $array;
        } else {
            return FALSE;
        }
        $width = $image_w;
        $height = $image_h;
// ACQUIRE THE ORIGINAL IMAGE
        $TenHinh = explode('.', $_file["name"]);
        $image_ext = trim(strtolower(end($TenHinh)));
        switch (strtoupper($image_ext)) {
            case 'JPG' :
            case 'JPEG' :
                $image = imagecreatefromjpeg($_file['tmp_name']);
                $func = 'imagejpeg';
                break;
            case 'PNG' :
                $image = imagecreatefrompng($_file['tmp_name']);
                $func = 'imagepng';
                break;
            case 'GIF' :
                $image = imagecreatefromgif($_file['tmp_name']);
                $func = 'imagegif';
                break;
            default : die("UNKNOWN IMAGE TYPE: ");
        }
// scale down and add borders
        if ($zoom_crop == 3) {

            $final_height = $height * ($new_width / $width);

            if ($final_height > $new_height) {
                $new_width = $width * ($new_height / $height);
            } else {
                $new_height = $final_height;
            }
        }

        // create a new true color image
        $canvas = imagecreatetruecolor($new_width, $new_height);
        imagealphablending($canvas, false);

        // Create a new transparent color for image
        $color = imagecolorallocatealpha($canvas, 255, 255, 255, 127);

        // Completely fill the background of the new image with allocated color.
        imagefill($canvas, 0, 0, $color);
        // scale down and add borders
        if ($zoom_crop == 2) {

            $final_height = $height * ($new_width / $width);

            if ($final_height > $new_height) {

                $origin_x = $new_width / 2;
                $new_width = $width * ($new_height / $height);
                $origin_x = round($origin_x - ($new_width / 2));
            } else {

                $origin_y = $new_height / 2;
                $new_height = $final_height;
                $origin_y = round($origin_y - ($new_height / 2));
            }
        }
        imagesavealpha($canvas, true);
        if ($zoom_crop > 0) {

            $src_x = $src_y = 0;
            $src_w = $width;
            $src_h = $height;

            $cmp_x = $width / $new_width;
            $cmp_y = $height / $new_height;
            if ($cmp_x > $cmp_y) {

                $src_w = round($width / $cmp_x * $cmp_y);
                $src_x = round(($width - ($width / $cmp_x * $cmp_y)) / 2);
            } else if ($cmp_y > $cmp_x) {

                $src_h = round($height / $cmp_y * $cmp_x);
                $src_y = round(($height - ($height / $cmp_y * $cmp_x)) / 2);
            }
            $align = FALSE;
            if ($align) {
                if (strpos($align, 't') !== false) {
                    $src_y = 0;
                }
                if (strpos($align, 'b') !== false) {
                    $src_y = $height - $src_h;
                }
                if (strpos($align, 'l') !== false) {
                    $src_x = 0;
                }
                if (strpos($align, 'r') !== false) {
                    $src_x = $width - $src_w;
                }
            }
            imagecopyresampled($canvas, $image, $origin_x, $origin_y, $src_x, $src_y, $new_width, $new_height, $src_w, $src_h);
        } else {
            imagecopyresampled($canvas, $image, 0, 0, 0, 0, $new_width, $new_height, $width, $height);
        }
        echo $new_file = $folder . $file_name . '_' . $Dai . 'x' . $Cao . '.' . $image_ext;
        if ($func == 'imagejpeg')
            $func($canvas, $new_file, 75);
        else
            $func($canvas, $new_file, 4);
        return $new_file;
    }

}

?>