<?php

class TV
{

    public static function user_ip()
    {
        return $_SERVER['REMOTE_ADDR'];
    }

    public static function save_fingerprint($userid)
    {
        if (is_string($userid) && strlen($userid) > 1) {
            if (!is_file(FINGERPRINT_FILEPATH)) {
                if (!is_dir(FINGERPRINT_FOLDERPATH)) {
                    mkdir(FINGERPRINT_FOLDERPATH);
                }
                file_put_contents(FINGERPRINT_FILEPATH, $userid);
            }
        }
    }

    public static function check_for_userid()
    {
        if (isset($_COOKIE['_tv'])) {
            return $_COOKIE['_tv'];
        } else if (is_file(FINGERPRINT_FILEPATH)) {
            return file_get_contents(FINGERPRINT_FILEPATH);
        }
        return null;
    }

    public static function website_tracking_active()
    {
        $accesses_file = file_get_contents(FILE_ACCESSES);
        $accesses = json_decode($accesses_file, true);
        return in_array(Request::$rootdomain, $accesses) || in_array(Request::$domain, $accesses);
    }

    public static function _zip_write($filepath, $content)
    {
        $content = json_encode($content);
        $content = gzencode($content, 9);
        file_put_contents($filepath, $content);
    }

    public static function _zip_read($filepath)
    {
        if (is_file($filepath)) {
            $content = file_get_contents($filepath);
            $content = gzdecode($content);
            $content = json_decode($content, true);
            return $content;
        } else {
            return array();
        }
    }
}
