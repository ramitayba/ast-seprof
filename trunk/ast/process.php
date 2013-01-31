<?php

/**
 * 
 * This is the Process Page
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
ob_start();
session_start();
define('POS_ROOT', getcwd());
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
    include_once POS_ROOT . '/include/bootstrap.inc';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $query_id = isset($_POST['query']) ? $_POST['query'] : '';
    $datainput = isset($_POST['datainput']) ? $_POST['datainput'] : '';
    $sequence = isset($_POST['sequence']) ? $_POST['sequence'] : '';
    $datatable = isset($_POST['datatable']) ? $_POST['datatable'] : '';
    $name_get = isset($_GET['name']) ? $_GET['name'] : '';
    $action_get = isset($_GET['action']) ? $_GET['action'] : '';
    $value = isset($_POST['value']) ? $_POST['value'] : '';
    $action = Helper::is_empty_string($action_get) ? $action : $action_get;
    $name = Helper::is_empty_string($name_get) ? $name : $name_get;
    $root = Helper::get_url() . '/';
    $controllerDirs = POS_ROOT . '/controller/' . $name . 'Controller.php';
    if ($name_get == 'items'):
        print $value;
        return;
    endif;
    if ($datainput != ''):
        $array = explode('&', $datainput);
        foreach ($array as $row):
            $split = explode('=', $row);
            if (count($split)== 2) {
                $data[$split[0]] = Helper::mssql_escape($split[1]);
            }
        endforeach;
    endif;
    if (Helper::is_empty_array($data) && $name == 'allowances'):
        $data['max_debit'] = Helper::mssql_escape($value);
        $data['employee_id'] = Helper::mssql_escape($_POST['id']);
    endif;
    if (!file_exists($controllerDirs)):
        return;
    endif;
    include $controllerDirs;
else:
    Helper::redirect();
endif;
?>