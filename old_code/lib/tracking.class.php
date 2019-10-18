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
            'eventname' => isset($_GET['n']) ? strip_tags(stripslashes($_GET['n'])) : null
        ));
        _zip_write(FILE_DATA_CURRENT_ACTIONS, $current);
    }

    public static function timer() {
        if (isset($_GET['t']) && is_numeric($_GET['t'])) {
            $seconds = intval($_GET['t']);
            $current = _zip_read(FILE_DATA_CURRENT_ACTIONS);
            array_push($current, self::_base_data() + array(
                'type' => 'timer',
                'seconds' => $seconds
            ));
            _zip_write(FILE_DATA_CURRENT_ACTIONS, $current);
        }
    }

    public static function create_track($type, $instance_key, $data) {
        $folder = DIR_DATA . $type . '/' . $instance_key . '/';
        $file_path = $folder . 'track_' . date('Y-m') . '.json.zip';
        $file_content = array();
        if (!is_dir($folder)) {
            mkdir($folder);
        } else if (is_file($file_path)) {
            $file_content = _zip_read($file_path);
        }
        $file_content += $data;
        _zip_write($file_path, $file_content);
    }

    public static function action_files() {
        $files = array();
        foreach (scandir(DIR_DATA_ACTIONS) as $filename) {
            if (preg_match('/\d{4}-\d{2}-\d{2}/isU', $filename)) {
                array_push($files, DIR_DATA_ACTIONS . $filename);
            }
        }
        return $files;
    }
    
    public static function list_instances($type) {
        $instances = array();
        foreach(scandir(DIR_DATA . $type) as $instance_key) {
            if(!in_array($instance_key, array('.', '..')) && is_dir(DIR_DATA . $type . '/' . $instance_key)) {
                array_push($instances, $instance_key);
            }
        }
        return $instances;
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
