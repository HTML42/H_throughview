<?php

define('FINGERPRINT', sha1($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']));
define('FINGERPRINT_FOLDERPATH', '../tmp/' . substr(FINGERPRINT, 0, 4) . '/');
define('FINGERPRINT_FILEPATH', FINGERPRINT_FOLDERPATH . FINGERPRINT);
define('SERVER_USERID', check_for_userid());

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
