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
            self::$url = trim($_GET['r']);
        } else if (isset($_SERVER['HTTP_REFERER'])) {
            self::$url = $_SERVER['HTTP_REFERER'];
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
        $domain_rootdomain = self::_domain(self::$url_base);
        self::$domain = $domain_rootdomain[0];
        self::$rootdomain = $domain_rootdomain[1];
        //
        if (strstr(self::$url_base, 'https://')) {
            self::$ssl = true;
        }
    }
    
    public static function _domain($url) {
        $without_protocol = @end(explode('://', $url));
        $_domain = (strstr($without_protocol, '/') ? @reset(explode('/', $without_protocol)) : $without_protocol);
        $_rootdomain = implode('.', array_slice(explode('.', $_domain), -2));
        if (in_array($_rootdomain, array('co.uk'))) {
            $_rootdomain = implode('.', array_slice(explode('.', $_domain), -3));
        }
        return array($_domain, $_rootdomain);
    }

}
