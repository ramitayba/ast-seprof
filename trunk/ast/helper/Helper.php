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

    public static function valid_date($date) {
        return (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $date));
    }

    public static function get_size_array($array, $key1, $key2) {
        $count = array_key_exists($key1, $array) ? count($array[$key1]) : 0;
        $count+=array_key_exists($key2, $array) ? count($array[$key2]) : 0;
        if (array_key_exists($key1, $array)) {
            foreach ($array[$key1] as $row) {
                $count+=array_key_exists($key2, $row) ? count($row[$key2]) : 0;
            }
        }
        return $count;
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
        if (isset($_GET['contentpage']) && is_string($_GET['contentpage'])) {
// This is a request with a ?q=foo/bar query string. $_GET['q'] is
// very early in the bootstrap process, so the original value is saved in
// $path and returned in later calls.
            $path = $_GET['contentpage'];
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
        header('Location:' . self::get_url() . $url);
    }

    public static function is_empty_string($string) {
        return strlen(trim($string)) == 0;
    }

    public static function is_list_empty($array) {
        $li = '';
        $message = '';
        foreach ($array as $pkey => $row):
            if (self::is_empty_string($row['content'])):
                $li.='<li>' . $pkey . ' cannot be empty</li>';
            else:
                if ($row['type'] == 'string'):
                    if (strlen($row['content']) > $row['length']):
                        $li.='<li>' . $pkey . ' cannot be greater than ' . $row['length'] . '</li>';
                    endif;
                elseif ($row['type'] == 'string'):
                    if (self::valid_date($row['content'])):
                        $li.='<li>' . $pkey . ' must be date </li>';
                    endif;
                    if (!is_numeric($row['content'])):
                        $li.='<li>' . $pkey . ' must be numeric </li>';
                    else:
                    /* switch ($row['type']):
                      case 'int':
                      $li.=!intva($row['content']) ? '<li>' . $pkey . ' must be digit </li>' : '';
                      break;
                      case 'long':
                      $li.=!is_long($row['content']) ? '<li>' . $pkey . ' must be digit </li>' : '';
                      break;
                      default:
                      break;
                      endswitch; */
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
        if (!isset($data) or self::is_empty_string($data))
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
        $data = str_replace("#", "", $data);
        /* $data = str_replace("%2B", "+", $data);
          $data = str_replace("%3D", "=", $data);
          $data = str_replace("%2F", "/", $data);
          $data = str_replace("%3A", ":", $data);
          $data = str_replace("%23", "", $data);
          $data = str_replace("+", " ", $data); */
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
        $root = self::get_url() . '/';
        if ($url != 'login' and $url != 'index' and $url != 'master' and $url != '404'):
            $parts = explode('/', $url);
            $count = count($parts);
            $div = '<ul class="breadcrumb">';
            $div.='  <li>
			    <a href="' . $root . '">Home</a> <span class="divider">/</span>
			  </li>';
            if ($count == 1 || ($count == 2 && $parts[1] == 'index')):
                $div.=' <li class="active">' . $parts[0] . '</li>';
            else:
                $i = 1;
                foreach ($parts as $value):
//  if($value='index')
                    $link = $value;
                    if ($count == $i):
                        $div.=' <li class="active">' . str_replace('-', '  ', ucfirst($value)) . '</li>';
                    else:
                        $div.=' <li>
			    <a href="' . $root . $link . '">' .  str_replace('-', '  ', ucfirst($value)). '</a> <span class="divider">/</span>
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
        $list = '<ul class="tree">';
        $lastID;
        foreach ($array as $row):
            $checked = $row['is_permission'] == 1 ? 'checked' : '';
            $li = '';
            if (isset($lastID) && $lastID != $row['menu_parent_id']):
                $li = '</ul></li>';
            endif;
            $li .= '<li><input type="checkbox" class="check" name="check" id="' . $row['menu_id'] . '" value="' . $row['menu_id'] . '" ' . $checked . ' ><label>' . $row['menu_name'] . '</label>';
            if ($row['menu_parent_id'] == 0 || $row['menu_link'] == '#'):
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

    public static function fill_datatable_event($name, $id, $header_buttons, $table, $header, $fields, $id_name, $linkcontrol = array(), $sdom = "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>") {
        $datatable = '<div id="widget-table"> <div class="widget-header"><h3><i class="icon-th-list"></i>'
                . ucfirst($name) . '</h3></div>';
        $datatable.= ' <script>$(function () {     oTable = table("' . $name . '","' . $sdom . '","-1","0");});</script>';
        $datatable.='<div class="widget-content" id="widget-content-' . $name . '-table">';
        $datatable.='<div class="header-table">';
        foreach ($header_buttons as $headerlink):
            $link = $headerlink['link'] . $id;
            $datatable.= '<span class="header-table-link"><a class="' . $headerlink['class'] . '" id="' . $link . '" href="" title="' . $headerlink['name'] . '"></a></span>';
        endforeach;
        $datatable.='</div>';
        $datatable.= '<table class="table table-striped table-bordered table-highlight" id="' . $name . '-table">';
        $thead = ' <thead><tr>';
        foreach ($header as $row):
            $thead .= '<th>' . $row . '</th>';
        endforeach;
        $thead.= '<th class="controls">Actions</th></tr> </thead>';
        $tbody = '<tbody>';
        $i = 1;
        $tr = '';
        foreach ($table as $row):
            $class = $i % 2 ? ' even' : ' odd';
            $tr = '<tr class="gradeA ' . $class . '">';
            foreach ($fields as $rowfields):
                $tr.= '<td class="">' . wordwrap($row[$rowfields], 30, "<br/>\n", true) . '</td>';
            endforeach;
            $extra = '<td class="controls">';
            foreach ($linkcontrol as $rowlink):
                $link = $rowlink['link'] . $id . '-' . $row[$id_name];
                if ($row['status_id'] != APPROVED && $row['status_id'] != REJECTED):
                    $extra.= '<span class="content-link"> <a class="' . $rowlink['class'] . '" id="' . $link . '" href="" title="' . $rowlink['name'] . '"></a></span>';
                endif;
            endforeach;
            $extra .= '</td>';

            $tr.=$extra . '</tr>';
            $tbody.=$tr;
            $i++;
        endforeach;
        $tbody.= '</tbody>';
        $datatable.= $thead . $tbody . '</table></div>';
        return $datatable;
    }

    public static function fill_datatable($name, $id, $header_buttons, $table, $header, $fields, $id_name, $linkcontrol = array(), $control = true, $columnsearch = 0, $column_hide = -1, $editable = '', $class_td_edit = '', $tdicon = '', $tdicon_class = '', $sdom = "<'row'<'span6'l><'span6'f>r>t<'row'<'span6'i><'span6'p>>", $query_id = '', $script = true) {
        $param = !self::is_empty_string($query_id) ? $name . '-' . $query_id : $name;
        $datatable = '<div id="widget-table"> <div class="widget-header"><h3><i class="icon-th-list"></i>'
                . ucfirst($name) . '</h3></div>';
        $datatable.= $script ? ' <script>$(function () {     oTable = table("' . $param . '","' . $sdom . '",' . $column_hide . ',"' . $editable . '","' . $columnsearch . '");});</script>' : '';
        $datatable.='<div class="widget-content" id="widget-content-' . $name . '-table">';
        if ($control):
            $datatable.='<div class="header-table">';
            foreach ($header_buttons as $headerlink):
                $link = $headerlink['link'] . $id;
                $datatable.= '<span class="header-table-link"><a class="' . $headerlink['class'] . '" id="' . $link . '" href="" title="' . $headerlink['name'] . '"></a></span>';
            endforeach;
            $datatable.='</div>';
        endif;
        $datatable.= '<table class="table table-striped table-bordered table-highlight ' . $name . '-table" id="' . $param . '-table">';
        $thead = ' <thead><tr>';
        $thead .=!self::is_empty_string($tdicon) ? '<th></th>' : '';
        foreach ($header as $row):
            $thead .= '<th>' . $row . '</th>';
        endforeach;
        $thead.= $control == true ? '<th class="controls">Actions</th></tr> </thead>' : '</tr> </thead>';
        $tbody = '<tbody>';
        $i = 1;
        $tr = '';
        foreach ($table as $row):
            $class = $i % 2 ? ' even' : ' odd';
            $tr = '<tr class="gradeA ' . $class . '">';
            $img = array_key_exists('count_number', $row) && !self::is_empty_string($row['count_number']) && $row['count_number'] != 0 ? '<img src="' . $tdicon . '">' : '';
            $tr.=!self::is_empty_string($tdicon) ? '<td class="' . $tdicon_class . '">' . $img . '</td>' : '';
            foreach ($fields as $rowfields):
                $class = $rowfields == $class_td_edit ? 'tdedit' : '';
                $tr.= '<td class="' . $class . '">' . wordwrap($row[$rowfields], 30, "<br/>\n", true) . '</td>';
            endforeach;
            $extra = '';
            if ($control):
                $extra = '<td class="controls">';
                foreach ($linkcontrol as $rowlink):
                    $link = $rowlink['link'] . $id . '-' . $row[$id_name];
                    $extra.= '<span class="content-link"> <a class="' . $rowlink['class'] . '" id="' . $link . '" href="" title="' . $rowlink['name'] . '"></a></span>';
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

    public static function array_to_xml($array, $xml) {
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
        return $xml->asXML();
    }

    public static function json_encode($string) {
        header('Content-type: text/json');
        return json_encode($string);
    }

    public static function json_encode_array($array = array()) {
        header('Content-type: text/json');
        return json_encode($array);
    }

    public static function get_url() {
        $protocol = strtolower(substr($_SERVER["SERVER_PROTOCOL"], 0, 5)) == 'https://' ? 'https://' : 'http://';
        $path = $_SERVER['PHP_SELF'];

        /*
         * returns an array with:
         * Array (
         *  [dirname] => /myproject/
         *  [basename] => index.php
         *  [extension] => php
         *  [filename] => index
         * )
         */
        $path_parts = pathinfo($path);
        $directory = $path_parts['dirname'];
        $directory = ($directory == "/"||$directory == "\\") ? "" : $directory;
        $host = $_SERVER['HTTP_HOST'];
        return $protocol . $host . $directory;
       // return $directory;
    }

    public static function generate_container_pdf($url_pdf, $action, $exist = true) {
        //$container = '<div class="widget-content report"><iframe style="border:none" width="100%" height="500" src="' . $url_pdf . '"></iframe>';
        //$container.= $exist ? '<div class="form-actions"><a id="' . $action . '"class="back btn btn-large btn-inverse" href="">Back</a></div></div>' : '';

        $container = '<div class="widget-content"><div class="report"><embed wmode="transparent" name="plugin" src="' . $url_pdf . '" type="application/pdf"></div>';
        $container.=$exist ? '<div class="form-actions"><a id="' . $action . '"class="back btn btn-large btn-inverse" href="">Back</a></div></div>' : '';
        return $container;
    }

    public static function preview($url_preview, $exist = true) {
        $container = '<div class="widget-content"><iframe style="border:none" width="100%" height="500" src="' . $url_preview . '"></iframe>';
        $container.= $exist ? '<div class="form-actions"><a id="print"class="back btn btn-large btn-inverse" href="">Print</a></div></div>' : '';
        return $container;
    }

    public static function construct_template_view($array, $header, $fields, $specifique_field, &$total) {
        $container = '<div class="control-group"><div class="widget widget-table"><div id="widget-table"><table class="table table-content"><tbody><tr> ';
        $i = 0;
        foreach ($array as $key => $val):
            $container.=$i % 2 == 0 && $i != 0 ? '</tr><tr>' : '';
            if ($key !== 'data_table' && $key != 'action'):
                $i++;
                $container.='<td>' . $val[0] . '</td>';
                $container.='<td>' . $val[1] . '</td>';
            elseif ($key !== 'action'):
                $container.= '</tr></div></div></div></tbody></table>' . self::_construct_table_view($val, $header, $fields, $specifique_field, $total);
            endif;
        endforeach;
        return $container;
    }

    private static function _construct_table_view($array, $header, $fields, $specifique_field, &$total) {
        if (self::is_empty_array($array))
            return '';
        $container_table = '<div class="control-group"><div class="widget widget-table"><div id="widget-table">';
        $container_table.=' <table class="table "> <thead><tr>';
        foreach ($header as $val):
            $container_table.='<th>' . $val . '</th>';
        endforeach;
        $container_table.='</tr></thead><tbody>';
        $i = 1;
        $tr = '';
        foreach ($array as $row):
            $class = $i % 2 ? ' even' : ' odd';
            $tr.= '<tr class="gradeA ' . $class . '">';
            foreach ($fields as $rowfields):
                $tr.= '<td class="' . $class . '">' . $row[$rowfields] . '</td>';
                if ($specifique_field == $rowfields)
                    $total+= $row[$rowfields];
            endforeach;
            $tr.='</tr>';
            $i++;
        endforeach;
        $container_table.=$tr . '</tbody></table></div></div></div>';

        return $container_table;
    }

    public static function trigger_error($message, $type) {
        trigger_error($message, $type);
    }

    public static function get_title_action($action) {
        $title = ' ';
        $split = explode('-', $action);
        foreach ($split as $word):
            $title.= ucfirst($word) . ' ';
        endforeach;
        return $title;
    }

    public static function word_wrap_pdf($text, $maxwidth) {
        $text = trim($text);
        if ($text === '')
            return 0;
        $space = strlen(' ');
        $lines = explode("\n", $text);
        $text = '';
        $count = 0;

        foreach ($lines as $line) {
            $words = preg_split('/ +/', $line);
            $width = 0;

            foreach ($words as $word) {
                $wordwidth = strlen($word);
                if ($width + $wordwidth <= $maxwidth) {
                    $width += $wordwidth + $space;
                    $text .= $word . ' ';
                } else {
                    $width = $wordwidth + $space;
                    $text = rtrim($text) . "\n" . $word . ' ';
                    $count++;
                }
            }
            $text = rtrim($text) . "\n";
            $count++;
        }
        $text = rtrim($text);
        return $text;
    }

}

