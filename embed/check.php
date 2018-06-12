<?php

include '_embed_bootstrap.php';

//

header('Content-Type: text/javascript; charset=UTF-8');

//
echo 'if(typeof window._tv_check_response == "function"){';
echo 'window._tv_check_response(' . (SERVER_USERID ? '"' . SERVER_USERID . '"' : 'false') . ')';
echo '}';
