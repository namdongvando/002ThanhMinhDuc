<?php

namespace lib;

class redDirectory {

    function redDirectoryByPath($dir, &$a) {
        if (!is_dir($dir)) {
            return;
        }
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != "." && $file != "..") {
                    $fileName = $dir . $file;
                    if (is_file($fileName)) {
                        $a[] = $file;
                    } else {
                        $this->redDirectoryByPath($dir . $file . "/", $a);
                    }
                }
            }
            closedir($dh);
        }
    }

    function redDirectoryByFullPath($dir, &$a) {
        if (!is_dir($dir)) {
            return;
        }
        if ($dh = opendir($dir)) {
            while (($file = readdir($dh)) !== false) {
                if ($file != "." && $file != "..") {
                    $fileName = $dir . $file;
                    if (is_file($fileName)) {
                        $a[] = $fileName;
                    } else {
                        $this->redDirectoryByFullPath($dir . $file . "/", $a);
                    }
                }
            }
            closedir($dh);
        }
    }

    public static function unlink($path) {
        /*    make sure the path exists    */
        if (!file_exists($path)) {
            return false;
        }

        /*    If it is a file or link, just delete it    */
        if (is_file($path) || is_link($path)) {
            return @unlink($path);
        }

        /*    Scan the dir and recursively unlink    */
        $files = scandir($path);
        if ($files) {
            foreach ($files as $filename) {
                if ($filename == '.' || $filename == '..') {
                    continue;
                }
                $file = str_replace('//', '/', $path . '/' . $filename);
                self::unlink($file);
            }
        }
        if (!@rmdir($path)) {
            return false;
        }
        return true;
    }

    function delete_directory($dirname) {
        if (!is_dir($dirname))
            return false;
        $dir_handle = opendir($dirname);
        if (!$dir_handle)
            while ($file = readdir($dir_handle)) {
                if ($file != "." && $file != "..") {
                    if (!is_dir($dirname . "/" . $file))
                        unlink($dirname . "/" . $file);
                    else
                        return $this->delete_directory($dirname . '/' . $file);
                }
            }
        closedir($dir_handle);
        rmdir($dirname);
        return true;
    }

}

?>