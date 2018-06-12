<?php

define('FINGERPRINT', sha1($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']));
define('FINGERPRINT_FOLDERPATH', '../tmp/' . substr(FINGERPRINT, 0, 4) . '/');
define('FINGERPRINT_FILEPATH', FINGERPRINT_FOLDERPATH . FINGERPRINT);
define('SERVER_USERID', check_for_userid());
define('DIR_DATA', '../data/');
define('FILE_ACCESSES', DIR_DATA . 'accesses.json');
define('FILE_DATA_USER', DIR_DATA . 'users/' . substr(FINGERPRINT, 0, 4) . '/' . FINGERPRINT . '.json.zip');
define('DIR_DATA_ACTIONS', DIR_DATA . 'actions/');
define('FILE_DATA_CURRENT_ACTIONS', DIR_DATA_ACTIONS . date('Y-m-d_H') . '.json.zip');

include '_request.class.php';
include '_tracking.class.php';
Request::init();
define('FILE_DATA_WEBSITE', '../data/websites/' . str_replace('.', '_', Request::$rootdomain) . '.json.zip');

function save_fingerprint($userid) {
    if (is_string($userid) && strlen($userid) > 1) {
        if (!is_file(FINGERPRINT_FILEPATH)) {
            if (!is_dir(FINGERPRINT_FOLDERPATH)) {
                mkdir(FINGERPRINT_FOLDERPATH);
            }
            file_put_contents(FINGERPRINT_FILEPATH, $userid);
        }
    }
}

function check_for_userid() {
    if (isset($_COOKIE['_tv'])) {
        return $_COOKIE['_tv'];
    } else if (is_file(FINGERPRINT_FILEPATH)) {
        return file_get_contents(FINGERPRINT_FILEPATH);
    }
    return null;
}

function website_tracking_active() {
    $accesses_file = file_get_contents(FILE_ACCESSES);
    $accesses = json_decode($accesses_file, true);
    return in_array(Request::$rootdomain, $accesses) || in_array(Request::$domain, $accesses);
}

function zip_write($filepath, $content) {
    $content = json_encode($content);
    $content = gzencode($content, 9);
    file_put_contents($filepath, $content);
}

function zip_read($filepath) {
    if (is_file($filepath)) {
        $content = file_get_contents($filepath);
        $content = gzdecode($content);
        $content = json_decode($content, true);
        return $content;
    } else {
        return '';
    }
}
