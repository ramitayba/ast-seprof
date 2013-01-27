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
        $div = '<div id="messages"><div class="section clearfix">
        <div id="' . $type . '" class="messages"><h2 class="element-invisible">' . ucfirst($type) . ' message</h2><ul>';
        $div.=$message . '</ul></div></div></div>';
        return $div;
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

    public static function parse_url($current_url) {
//$current_url = self::request_path();
        $parts = explode('/', $current_url);
        $count = count($parts);
        $i = 1;
        if ($count == 0) {
            $options['path'] = $current_url == 'index' ? 'home' : $current_url;
        } else if ($i == $count) {
            $options['path'] = $current_url;
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

    public static function load_controller($url) {
        global $routes, $action, $query_string, $query_id;
        foreach ($routes as $pkey => $value) :
            if (in_array($url, $value)) :
                $parts = explode('/', $url);
                $count = count($parts);
                switch ($count):
                    case 1:
                        $action = $url;
                        $query_string = $query_id = '';
                        break;
                    case 2:$action = $parts[1];
                        $query_string = $query_id = '';
                        break;
                    case 3:
                        $query_string = $parts[1];
                        $query_id = '';
                        $action = $parts[2];
                        break;
                    case 4:$query_string = $parts[2];
                        $query_id = $parts[3];
                        $action = $parts[1];
                        break;
                    default:$action = $parts[1];
                        break;
                endswitch;
                $controllerName = '/controller/' . $pkey . '.php';
                break;
            endif;
        endforeach;
        if (empty($controllerName)):
            $controllerName = '/controller/mainController.php';
        endif;
        $controllerDirs = POS_ROOT . $controllerName;
        if (file_exists($controllerDirs)):
            return $controllerDirs;
        endif;
    }

    public static function redirect($url = '', $http_response_code = 302) {
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
        header('Location: /ast/' . $url);
    }

    public static function is_empty_string($string) {
        return strlen(trim($string)) == 0;
    }

    public static function is_list_empty($array) {
        $li = '';
        $message = '';
        foreach ($array as $pkey => $row):
            if (self::is_empty_string($row['content'])):
                $li.='<li>' . $pkey . ' can t be empty</li>';
            else:
                if ($row['type'] == 'string'):
                    if (strlen($row['content']) > $row['length']):
                        $li.='<li>' . $pkey . ' can t be grand than ' . $row['length'] . '</li>';
                    endif;
                else:
                    if (!is_numeric($row['content'])):
                        $li.='<li>' . $pkey . ' must be numeric </li>';
                    else:
                        switch ($row['type']):
                            case 'int':
                                $li.=!is_int($row['content']) ? '<li>' . $pkey . ' must be digit </li>' : '';
                                break;
                            case 'long':
                                $li.=!is_long($row['content']) ? '<li>' . $pkey . ' must be digit </li>' : '';
                                break;
                            default:
                                break;
                        endswitch;
                    endif;
                endif;
            endif;
        endforeach;
        if (!self::is_empty_string($li)):
            $message = '<ul>' . $li . '</ul>';
        endif;
        return $message;
    }

    public static function mssql_escape($data) {
        if (!isset($data) or empty($data))
            return '';
        if (is_numeric($data))
            return $data;
        /* $non_displayables = array(
          '/%0[0-8bcef]/', // url encoded 00-08, 11, 12, 14, 15
          '/%1[0-9a-f]/', // url encoded 16-31
          '/%2[0-9a-f]/', // url encoded 16-31
          '/%3[0-9a-f]/', // url encoded 16-31
          '/[\x00-\x08]/', // 00-08
          '/\x0b/', // 11
          '/\x0c/', // 12
          '/[\x0e-\x1f]/'             // 14-31
          );
          foreach ($non_displayables as $regex):
          $data = preg_replace($regex, '', $data);
          $unpacked = unpack('H*hex', $data);
          endforeach; */
        //return '0x' . $unpacked['hex'];
        $data = str_replace("'", "''", $data);
        $data = str_replace(";", "", $data);
        $data = str_replace("/", "", $data);
        $data = str_replace("%2B", "+", $data);
        $data = str_replace("%3D", "=", $data);
        $data = str_replace("%2F", "/", $data);
        $data = str_replace("%3A", ":", $data);
        $data = str_replace("+", " ", $data);
        $data = self::check_plain($data);
        return $data;
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

    public static function set_breadcrumb($url) {
        if ($url != 'login' and $url != 'index' and $url != 'master' and $url != '404'):
            $parts = explode('/', $url);
            $count = count($parts);
            $div = '<ul class="breadcrumb">';
            $div.='  <li>
			    <a href="/ast/">Home</a> <span class="divider">/</span>
			  </li>';
            if ($count == 1 || ($count == 2 && $parts[1] == 'index')):
                $div.=' <li class="active">' . $parts[0] . '</li>';
            else:
                $i = 1;
                foreach ($parts as $value):
//  if($value='index')
                    $link = '/' . $value;
                    if ($count == $i):
                        $div.=' <li class="active">' . str_replace('-', ' ', ucfirst($value)) . '</li>';
                    else:
                        $div.=' <li>
			    <a href="/ast' . $link . '">' . str_replace('-', ' ', ucfirst($value)) . '</a> <span class="divider">/</span>
			  </li>';
                    endif;
                    $i++;
                endforeach;
            endif;
            $div.='</ul>';
            return $div;
        endif;
        return '';
    }

    public static function fill_list_permission($array) {
        $li = '';
        $list = '<script>var $checktree = $("ul.tree").checkTree();</script><ul class="tree">';
        $lastID;
        foreach ($array as $row):
            $checked = $row['is_permission'] == 1 ? 'checked' : '';
            $li = '';
            if (isset($lastID) && $lastID != $row['menu_parent_id']):
                $li = '</ul></li>';
            endif;
            $li .= '<li><input type="checkbox" name="check" id="' . $row['menu_id'] . '" value="' . $row['menu_id'] . '" ' . $checked . ' ><label>' . $row['menu_name'] . '</label>';
            if ($row['menu_parent_id'] == 0):
                $lastID = $row['menu_id'];
                $li.='<ul>';
            else:
                $li.='</li>';
            endif;
            $list.=$li;
        endforeach;
        $list.='</ul>';
        return $list;
    }

    public static function fill_datatable($name, $header_buttons, $table, $header, $fields, $id_name, $linkcontrol = array(), $control = true, $column_hide = -1) {
        $datatable = '<div id="widget-table"> <div class="widget-header"><h3><i class="icon-th-list"></i>'
                . ucfirst($name) . '</h3></div><script>$(function () {     oTable = table("' . $name . '",' . $column_hide . ');});</script> 
                    <div class="widget-content" id="widget-content-' . $name . '-table">';
        if ($control):
            foreach ($header_buttons as $headerlink):
                $link = $headerlink['link'] . $name;
                $datatable.= '<span><a class="' . $headerlink['class'] . ' btn" id="' . $link . '" href="">' . $headerlink['name'] . '</a></span>';
            endforeach;
        endif;
        $datatable.= '<table class="table table-striped table-bordered table-highlight" id="' . $name . '-table">';
        $thead = ' <thead><tr>';
        foreach ($header as $row):
            $thead .= '<th>' . $row . '</th>';
        endforeach;
        $thead.= $control == true ? '<th>Actions</th></tr> </thead>' : '</tr> </thead>';
        $tbody = '<tbody>';
        $i = 1;
        $tr = '';
        foreach ($table as $row):
            $class = $i % 2 ? ' even' : ' odd';
            $tr = '<tr class="gradeA ' . $class . '">';
            foreach ($fields as $rowfields):
                $tr.= '<td class="tdedit">' . $row[$rowfields] . '</td>';
            endforeach;

            if ($control):
                $extra = '<td>';
                foreach ($linkcontrol as $rowlink):
                    $link = $rowlink['link'] . $name . '-' . $row[$id_name];
                    $extra.= '<span><a class="' . $rowlink['class'] . ' btn" id="' . $link . '" href="">' . $rowlink['name'] . '</a></span>';
                endforeach;
                $extra .= '</td>';
            endif;
            $tr.=$extra . '</tr>';
            $tbody.=$tr;
            $i++;
        endforeach;

        $tbody.= '</tbody>';
        $datatable.= $thead . $tbody . '</table></div>';
        return $datatable;
    }

    public static function findPage($pagename) {
        global $actions;
        $pagename = str_replace(array('.html', '.htm'), '', $pagename);
        $pagename = $pagename == 'master' ? 'index' : $pagename;
        $parts = explode('/', $pagename);
        if (file_exists($pagename . '.php')) :
            // URL refers to a page existing under the webroot, so just display page w/o using master page
            return $pagename;
        else :
            // Look for a PHP file matching the desired page name under the include/content folder
            if (!self::findRealPath("content/$pagename.php")):
                // The page name might represent a folder, so look for the index.php file in such
                // a folder under the include/page folder
                /*  foreach ($parts as $row):
                  if (!in_array($row, $actions)):
                  $pagename = $row;
                  else:
                  $action = $row;
                  endif;
                  endforeach; */
                if (Helper::findRealPath("content/$pagename/index.php")) :
                    // Page name is a folder, so change page name to the index file in that folder
                    $pagename = $pagename . '/index';
                else :
                    // Failed to find the page file, so display the 404 content page instead
                    $pagename = '404';
                endif;
            endif;
        endif;
        $pagename = ($pagename != 'login') && !isset($_SESSION['user_pos']) ? 'login' : $pagename;
        $pagename = $pagename == 'login' && isset($_SESSION['user_pos']) ? 'index' : $pagename;
        return $pagename;
    }

    public static function form_construct_drop_down($name, $array, $current, $field_name, $field_id, $disable = '', $class = '', $script = '') {
        $select = ' <select class="' . $class . '" ' . $disable . ' id="' . strtolower($name) . '" name = "' . strtolower($name) . '"><option value = "">Select</option>';
        foreach ($array as $key => $value) {
            $val_option = $value[$field_name];
            $selected = $current == $value[$field_id] ? 'selected' : '';
            $select.= '<option ' . $selected . ' value = "' . $value[$field_id] . '">' . $val_option . '</option>';
        }
        $select.='</select>';
        return $select . $script;
    }

    public static function array_to_xml($array, &$xml) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                if (!is_numeric($key)) {
                    $subnode = $xml->addChild("$key");
                    self::array_to_xml($value, $subnode);
                } else {
                    self::array_to_xml($value, $xml);
                }
            } else {
                $xml->addChild("$key", "$value");
            }
        }
    }

    public static function json_encode($string) {
        header('Content-type: text/json');
        return json_encode($string);
    }

    public static function json_encode_array($array = array()) {
        header('Content-type: text/json');
        return json_encode($array);
    }

}

