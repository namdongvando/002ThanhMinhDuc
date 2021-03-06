<?php

namespace lib;

class APIs {

    function StringToArray($string) {
        if ($string) {
            return json_decode($string, JSON_OBJECT_AS_ARRAY);
        } else {
            return [];
        }
    }

    function StringToObj($string) {
        if ($string) {
            return json_decode($string);
        } else {
            return [];
        }
    }

    function ArrayToApi($array) {
        if ($array) {
            $a = json_encode($array, JSON_UNESCAPED_UNICODE);
            echo trim(html_entity_decode($a));
        } else {
            echo "[]";
        }
    }

    function ArrayToStringJson($array) {
        if ($array) {
            $a = json_encode($array, JSON_UNESCAPED_UNICODE);
            return html_entity_decode($a);
        } else {
            return NULL;
        }
    }

    public static function Json_encode($a) {
        $jsonString = json_encode($a, JSON_UNESCAPED_UNICODE);
        return $jsonString;
    }

    public static function ResApi($data, $pagesIndex, $pagesNumber, $pagesTotal) {
        $a["data"] = $data;
        $a["pagesIndex"] = $pagesIndex;
        $a["pagesNumber"] = $pagesNumber;
        $a["pagesTotal"] = $pagesTotal;
        return self::Json_encode($a);
    }

}
