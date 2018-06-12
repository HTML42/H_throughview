<?php

class Tracking {
    
    public static function view() {
        $current = zip_read(FILE_DATA_CURRENT_ACTIONS);
        array_push($current, array(
            'timestamp' => time(),
            'url' => Request::$url_base,
            'url_match' => Request::$url_match,
            'ssl' => Request::$ssl,
            'userid' => USERID,
            'userid_match' => USERID_MATCH,
        ));
        zip_write(FILE_DATA_CURRENT_ACTIONS, $current);
    }

    public static function view_website() {
        #$current = zip_read(FILE_DATA_WEBSITE);
        #zip_write(FILE_DATA_WEBSITE, $current);
    }

    public static function view_user() {
        #$current = zip_read(FILE_DATA_USER);
        #zip_write(FILE_DATA_WEBSITE, $current);
    }

}
