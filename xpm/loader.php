<?php

include_once str_replace('\\', '/', __DIR__ . '/connect.php');
if (class_exists('XPM')) {
    XPM::init(false);
    XPM::load();
}
