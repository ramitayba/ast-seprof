<?php

ob_start();
session_start();
define('POS_ROOT', getcwd());
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
    include_once POS_ROOT . '/include/bootstrap.inc';
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $query_id = isset($_POST['query']) ? $_POST['query'] : '';
    $controllerDirs = POS_ROOT . '/controller/' . $name . 'Controller.php';
    $datainput = isset($_POST['datainput']) ? $_POST['datainput'] : '';
    $sequence= isset($_POST['sequence']) ? $_POST['sequence'] : '';
    if ($datainput != ''):
        $array = explode('&', $datainput);
        foreach ($array as $row):
            $split = explode('=', $row);
            $data[$split[0]] = Helper::mssql_escape($split[1]);
        endforeach;
    endif;
    if (!file_exists($controllerDirs)):
        return;
    endif;
    if ($action == 'add' or $action == 'edit'):
        ob_start();
        include
                $controllerDirs;
        $html = ob_get_contents();
        ob_end_clean();
        print json_encode($html);
    else:
        include $controllerDirs;
    endif;
else:
    Helper::redirect();
endif;
?>