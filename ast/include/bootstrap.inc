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
        return;
    }
    $message = '';

    switch ($errno) {
        case E_USER_ERROR:
            $message = '<b>My ERROR</b>' . $errno . $errstr . '\n' .
                    'Fatal error on line' . $errline . 'in file ' . $errfile;
            break;
        case E_USER_WARNING:
            $message = '<b>My WARNING</b>' . $errno . ' ' . $errstr;
            break;
        case E_USER_NOTICE:
            $message = '<b>My NOTICE</b> ' . $errno . ' ' . $errstr;
            break;
        case E_NOTICE:
            $message = '<b>NOTICE</b> ' . $errno . ' ' . $errstr;
            break;
        case E_WARNING:
            $message = '<b>WARNING</b> ' . $errno . ' ' . $errstr;
            break;
        default:
            $message = 'Unknown error type:' . $errno . ' ' . $errstr;
            break;
    }
    $date = date('d.m.Y h:i:s');
    $log = $message . "   |  Date:  " . $date . "\n";
    //error_mail( format_error( $errno, $errstr, $errfile, $errline ) );
    if (!Helper::is_empty_string($message)) {
        error_log($log, 3, POS_ROOT . '/default/files/log.txt');
        //print Helper::set_message($message, 'error');
        return true;
    }
    return false;
}

set_error_handler("error_handler");
?>