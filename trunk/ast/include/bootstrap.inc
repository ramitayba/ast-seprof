<?php

include_once POS_ROOT . '/default/settings.php';
include_once POS_ROOT . '/helper/variables.php';
include_once POS_ROOT . '/helper/Helper.php';
include_once POS_ROOT . '/dataAccessLayer/Connection.php';
include_once POS_ROOT . '/dataAccessLayer/DataAccessManager.php';
include_once POS_ROOT . '/businessLayer/LookupBusinessLayer.php';
include_once POS_ROOT . '/helper/Menu.php';

function error_handler($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }
    $message = '';
    switch ($errno) {
        case E_USER_ERROR:
            $message = '<b>My ERROR</b>' . $errno . $errstr . '<br />' .
                    'Fatal error on line' . $errline . 'in file ' . $errfile;
            break;
        case E_USER_WARNING:
            $message = '<b>My WARNING</b>' . $errno . $errstr . '<br />';
            break;
        case E_USER_NOTICE:
            $message = '<b>My NOTICE</b> ' . $errno . $errstr . '<br />';
            break;

        default:
            $message = 'Unknown error type:'. $errstr . '<br />';
            break;
    }
    if (!Helper::is_empty_string($message)) {
        print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message($message, 'error')));
        return true;
    }
    return false;
}

set_error_handler("error_handler");
?>