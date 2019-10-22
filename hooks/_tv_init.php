<?php

//
if(!is_dir(PROJECT_ROOT . 'tmp/')) {
    File::_create_folder(PROJECT_ROOT . 'tmp/');
}
if(!is_dir(PROJECT_ROOT . 'data/')) {
    File::_create_folder(PROJECT_ROOT . 'data/');
}

//Project Startup
include PROJECT_CLASSES . 'tv.class.php';
include PROJECT_CLASSES . 'tvrequest.class.php';
include PROJECT_CLASSES . 'tracking.class.php';
define('FINGERPRINT', sha1($_SERVER['HTTP_USER_AGENT'] . TV::user_ip()));
define('FINGERPRINT_FOLDERPATH', PROJECT_ROOT . 'tmp/' . substr(FINGERPRINT, 0, 4) . '/');
define('FINGERPRINT_FILEPATH', FINGERPRINT_FOLDERPATH . FINGERPRINT);
define('SERVER_USERID', TV::check_for_userid());
define('DIR_DATA', PROJECT_ROOT . 'data/');
define('FILE_ACCESSES', DIR_DATA . 'accesses.json');
define('FILE_DATA_USER', DIR_DATA . 'users/' . substr(FINGERPRINT, 0, 4) . '/' . FINGERPRINT . '.json.zip');
define('DIR_DATA_ACTIONS', DIR_DATA . 'actions/');
define('FILE_DATA_CURRENT_ACTIONS', DIR_DATA_ACTIONS . date('Y-m-d_H') . '.json.zip');

TvRequest::init();
define('FILE_DATA_WEBSITE', '../data/websites/' . str_replace('.', '_', TvRequest::$rootdomain) . '.json.zip');


define('USERID', isset($_GET['u']) ? $_GET['u'] : (SERVER_USERID ? SERVER_USERID : null));
define('USERID_MATCH', is_null(SERVER_USERID) || USERID == SERVER_USERID);

if (USERID) {
    setcookie('_tv', USERID, time() + 3600 * 24 * 90, '/');
    TV::save_fingerprint(USERID);
}
