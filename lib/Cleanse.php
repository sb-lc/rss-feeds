<?php

namespace Lib;

class Cleanse
{

    /**
     * Strip tags, optionally strip or encode special characters.
     * @param $str
     * @return mixed
     */
    static function sanitiseStr($str){
        $str = filter_var($str, FILTER_SANITIZE_STRING);
        return $str;
    }


    /**
     * Remove all illegal characters from a url
     *
     * @param $url
     * @return mixed
     */
    static function sanitiseUrl($url){
        $url = filter_var($url, FILTER_SANITIZE_URL);
        return $url;
    }

    /**
     * Remove all characters except digits, plus and minus sign from an integer
     *
     * @param $int
     * @return mixed
     */
    static function sanitiseNum($int){
        $int = filter_var($int, FILTER_SANITIZE_NUMBER_INT);
        return $int;
    }


    /**
     * Validates value as URL
     *
     * @param $url
     * @return bool
     */
    static function validateUrl($url){

        if (!filter_var($url, FILTER_VALIDATE_URL) === false) {
            return true;
        } else {
            return false;
        }

    }

}