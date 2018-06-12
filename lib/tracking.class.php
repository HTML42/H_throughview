<?php

class Tracking {

    public static function view() {
        $current = _zip_read(FILE_DATA_CURRENT_ACTIONS);
        array_push($current, self::_base_data() + array(
            'type' => 'view',
        ));
        _zip_write(FILE_DATA_CURRENT_ACTIONS, $current);
    }

    public static function event() {
        $current = _zip_read(FILE_DATA_CURRENT_ACTIONS);
        array_push($current, self::_base_data() + array(
            'type' => 'event',
        ));
        _zip_write(FILE_DATA_CURRENT_ACTIONS, $current);
    }

    public static function view_website() {
        #$current = _zip_read(FILE_DATA_WEBSITE);
        #_zip_write(FILE_DATA_WEBSITE, $current);
    }

    public static function view_user() {
        #$current = _zip_read(FILE_DATA_USER);
        #_zip_write(FILE_DATA_WEBSITE, $current);
    }

    public static function _base_data() {
        return array(
            'timestamp' => time(),
            'url' => Request::$url_base,
            'url_match' => Request::$url_match,
            'ssl' => Request::$ssl,
            'userid' => USERID,
            'userid_match' => USERID_MATCH,
            'ip' => user_ip(),
            'useragent' => $_SERVER['HTTP_USER_AGENT']
        );
    }

}
