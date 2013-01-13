<?php

/**
 * This is the Helper
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
class Helper {

    public static function is_empty_array($array) {
        return ((empty($array) && count($array) == 0) || $array == null);
    }

    public static function normalize_word($word) {
        $word = str_replace(' ', '-', $word);
        return strtolower($word);
    }

    public static function array_to_object($array) {
        if (!is_array($array)) {
            return $array;
        }

        $object = new stdClass();
        if (is_array($array) && count($array) > 0) {
            foreach ($array as $name => $value) {
                $name = strtolower(trim($name));
                if (!empty($name)) {
                    $object->$name = self::array_to_object($value);
                }
            }
            return $object;
        } else {
            return FALSE;
        }
    }

    public static function format_string($string, array $args = array()) {
        // Transform arguments before inserting them.
        foreach ($args as $key => $value) {
            switch ($key[0]) {
                case '@':
                    // Escaped only.
                    $args[$key] = check_plain($value);
                    break;

                case '%':
                default:
                    // Escaped and placeholder.
                    $args[$key] = place_holder($value);
                    break;

                case '!':
                // Pass-through.
            }
        }
        return strtr($string, $args);
    }

    public static function place_holder($text) {
        return '<em class="placeholder">' . check_plain($text) . '</em>';
    }

    public static function check_plain($text) {
        return htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
    }

    public static function validate_utf8($text) {
        if (strlen($text) == 0) {
            return TRUE;
        }
        // With the PCRE_UTF8 modifier 'u', preg_match() fails silently on strings
        // containing invalid UTF-8 byte sequences. It does not reject character
        // codes above U+10FFFF (represented by 4 or more octets), though.
        return (preg_match('/^./us', $text) == 1);
    }

    public static function format_date($timestamp, $type = 'medium', $format = '', $timezone = NULL, $langcode = NULL) {
        $timezone = date_default_timezone_get();
        if (!isset($timezones[$timezone])) {
            $timezones[$timezone] = timezone_open($timezone);
        }
        global $language;
        if (empty($langcode)) {
            $langcode = isset($language->language) ? $language->language : 'en';
        }
        switch ($type) {
            case 'short':
                $format = 'm/d/Y - H:i';
                break;
            case 'long':
                $format = 'l, F j, Y - H:i';
                break;
            case 'medium':
            default:
                $format = 'D, m/d/Y - H:i';

                break;
        }
        $date_time = date_create('@' . $timestamp);
        date_timezone_set($date_time, $timezones[$timezone]);
        $format = preg_replace(array('/\\\\\\\\/', '/(?<!\\\\)([AaeDlMTF])/'), array("\xEF\\\\\\\\\xFF", "\xEF\\\\\$1\$1\xFF"), $format);
        $format = date_format($date_time, $format);
        return $format;
    }

    public static function map_assoc($array, $function = NULL) {
        $array = !empty($array) ? array_combine($array, $array) : array();
        if (is_callable($function)) {
            $array = array_map($function, $array);
        }
        return $array;
    }

    public static function valid_email_address($mail) {
        return (bool) filter_var($mail, FILTER_VALIDATE_EMAIL);
    }

    public static function set_message($message = NULL, $type = 'status', $repeat = TRUE) {
        session_start();
        $div = '<div id="messages"><div class="section clearfix">
        <div class="messages ' . $type . '"><h2 class="element-invisible">' . ucfirst($type) . ' message</h2>';
        $div.=$message . '</div></div></div>';
        $_SESSION['messages'] = $div;
    }

    public static function clear_session($session) {
        unset($_SESSION[$session]);
    }

    public static function require_all_php($folder) {
        foreach (glob("{$folder}/*.php") as $filename) {
            require_once $filename;
        }
    }

    public static function request_path() {
        if (isset($_GET['q']) && is_string($_GET['q'])) {
            // This is a request with a ?q=foo/bar query string. $_GET['q'] is
            // overwritten in drupal_path_initialize(), but request_path() is called
            // very early in the bootstrap process, so the original value is saved in
            // $path and returned in later calls.
            $path = $_GET['q'];
        } elseif (isset($_SERVER['REQUEST_URI'])) {
            // This request is either a clean URL, or 'index.php', or nonsense.
            // Extract the path from REQUEST_URI.
            $request_path = strtok($_SERVER['REQUEST_URI'], '?');
            $base_path_len = strlen(rtrim(dirname($_SERVER['SCRIPT_NAME']), '\/'));
            // Unescape and strip $base_path prefix, leaving q without a leading slash.
            $path = substr(urldecode($request_path), $base_path_len + 1);
            // If the path equals the script filename, either because 'index.php' was
            // explicitly provided in the URL, or because the server added it to
            // $_SERVER['REQUEST_URI'] even when it wasn't provided in the URL (some
            // versions of Microsoft IIS do this), the front page should be served.
            if ($path == basename($_SERVER['PHP_SELF'])) {
                $path = '';
            }
        } else {
            // This is the front page.
            $path = '';
        }
        $path = trim($path, '/');
        $path = empty($path) ? 'home' : $path;
        return $path;
    }

    public static function parse_url() {
        $current_url = self::request_path();
        $parts = explode('/', $current_url);
        $count = count($parts);
        $i = 1;
        if ($count == 0) {
            $options['path'] = $current_url == 'index' ? 'home' : $current_url;
        } else if ($i == $count) {
            $options['path'][$i] = $current_url;
        } else {
            foreach ($parts as $value) {
                if ($i < $count) {
                    if (is_numeric($value)) {
                        $options['query_id'] = $value;
                    }
                    $options['path'][$i] = $value;
                    /* $current_url=$value;
                      if ($i + 1 < $count) {
                      $current_url.='/';
                      } */
                    $i++;
                } else {
                    //$options['action'] = $value;
                    if (self::_test_action($value)) {
                        $options['action'] = $value;
                    } else {
                        $options['path'][$i] = $value;
                    }
                }
            }
        }
        return $options;
        // }
    }

    private static function _test_action($value) {
        return $value == 'edit' || $value == 'add' || $value == 'delete' || $value == 'view' || $value == 'upload';
    }
    
    public function load_controller() {
        global $action;
        $array = Helper::parse_url();
        $controllerName = '/controller/';
        foreach ($array['path'] as $val) {
            $controllerName.= ucfirst($val);
        }
        $action = !empty($array['action']) ? $array['action'] : 'view';
        if (empty($controllerName)) {
            $controllerName .='home';
        }
        $controllerName.="Controller.php";
        $controllerDirs = SEPROF_ROOT . $controllerName;
        if (file_exists($controllerDirs)) {
            include_once $controllerDirs;
        } else {
            include_once SEPROF_ROOT . '/controller/HomeController.php';
        }
    }


    public static function seprof_redirect($url = '/home', $http_response_code = 302) {
        static $http = array(
    100 => "HTTP/1.1 100 Continue",
    101 => "HTTP/1.1 101 Switching Protocols",
    200 => "HTTP/1.1 200 OK",
    201 => "HTTP/1.1 201 Created",
    202 => "HTTP/1.1 202 Accepted",
    203 => "HTTP/1.1 203 Non-Authoritative Information",
    204 => "HTTP/1.1 204 No Content",
    205 => "HTTP/1.1 205 Reset Content",
    206 => "HTTP/1.1 206 Partial Content",
    300 => "HTTP/1.1 300 Multiple Choices",
    301 => "HTTP/1.1 301 Moved Permanently",
    302 => "HTTP/1.1 302 Found",
    303 => "HTTP/1.1 303 See Other",
    304 => "HTTP/1.1 304 Not Modified",
    305 => "HTTP/1.1 305 Use Proxy",
    307 => "HTTP/1.1 307 Temporary Redirect",
    400 => "HTTP/1.1 400 Bad Request",
    401 => "HTTP/1.1 401 Unauthorized",
    402 => "HTTP/1.1 402 Payment Required",
    403 => "HTTP/1.1 403 Forbidden",
    404 => "HTTP/1.1 404 Not Found",
    405 => "HTTP/1.1 405 Method Not Allowed",
    406 => "HTTP/1.1 406 Not Acceptable",
    407 => "HTTP/1.1 407 Proxy Authentication Required",
    408 => "HTTP/1.1 408 Request Time-out",
    409 => "HTTP/1.1 409 Conflict",
    410 => "HTTP/1.1 410 Gone",
    411 => "HTTP/1.1 411 Length Required",
    412 => "HTTP/1.1 412 Precondition Failed",
    413 => "HTTP/1.1 413 Request Entity Too Large",
    414 => "HTTP/1.1 414 Request-URI Too Large",
    415 => "HTTP/1.1 415 Unsupported Media Type",
    416 => "HTTP/1.1 416 Requested range not satisfiable",
    417 => "HTTP/1.1 417 Expectation Failed",
    500 => "HTTP/1.1 500 Internal Server Error",
    501 => "HTTP/1.1 501 Not Implemented",
    502 => "HTTP/1.1 502 Bad Gateway",
    503 => "HTTP/1.1 503 Service Unavailable",
    504 => "HTTP/1.1 504 Gateway Time-out"
        );
        session_write_close();
        header('Location: /chamber-commerce' . $url);
    }

    public static function is_empty_string($string) {
        return strlen(trim($string)) == 0;
    }

    public static function get_date($date) {
        return date('D', $date);
    }

    /**
     * Check if a file exists under the webroot or include path
     * And if it does, return the absolute path.
     * @param string $filename - Name of the file to look for
     * @return string|false - The absolute path if file exists, false if it does not
     */
    //die('..'.$_GET['contentpage']);
    public static function findRealPath($filename) {
        // Check for absolute path
        if (realpath($filename) == $filename) {
            return $filename;
        }
        // Otherwise, treat as relative path
        $paths = explode(PATH_SEPARATOR, get_include_path());
        foreach ($paths as $path) {
            if (substr($path, -1) == DIRECTORY_SEPARATOR) {
                $fullpath = $path . $filename;
            } else {
                $fullpath = $path . DIRECTORY_SEPARATOR . $filename;
            }

            if (file_exists($fullpath)) {
                return $fullpath;
            }
        }

        return false;
    }

}

