<?php

include '_embed_bootstrap.php';
define('USERID', isset($_GET['u']) ? $_GET['u'] : (SERVER_USERID ? SERVER_USERID : null));
define('USERID_MATCH', is_null(SERVER_USERID) || USERID == SERVER_USERID);

//
if (USERID) {
    setcookie('_tv', USERID, time() + 3600 * 24 * 90, '/');
    save_fingerprint(USERID);
    if (website_tracking_active()) {
        Tracking::view_website();
    }
        Tracking::view_user();
}