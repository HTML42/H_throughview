<?php

class Request {

    public static $url = null;
    public static $url_base = null;
    public static $referer_base = null;
    public static $url_match = false;
    public static $domain = null;
    public static $rootdomain = null;
    public static $ssl = false;

    public static function init() {
        if (isset($_GET['r'])) {
            self::$url == trim($_GET['r']);
        } else if (isset($_SERVER['HTTP_REFERER'])) {
            self::$url == $_SERVER['HTTP_REFERER'];
        }
        if (isset($_SERVER['HTTP_REFERER'])) {
            self::$referer_base = $_SERVER['HTTP_REFERER'];
            if (strstr(self::$referer_base, '?')) {
                self::$referer_base = @reset(explode('?', self::$referer_base));
            }
        }
        self::$url_base = (strstr(self::$url, '?') ? @reset(explode('?', self::$url)) : self::$url);
        if (isset($_GET['r']) && isset($_SERVER['HTTP_REFERER'])) {
            self::$url_match = (self::$url_base == self::$referer_base);
        }
        //
        $without_protocol = @end(explode('://', self::$url_base));
        self::$domain = (strstr($without_protocol, '/') ? @reset(explode('/', $without_protocol)) : $without_protocol);
        self::$rootdomain = array_slice(explode('.', self::$domain), -2);
        if (in_array(self::$rootdomain, array('co.uk'))) {
            self::$rootdomain = array_slice(explode('.', self::$domain), -3);
        }
        //
        if (strstr(self::$url_base, 'https://')) {
            self::$ssl = true;
        }
    }

}

Request::init();
