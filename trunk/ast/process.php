<?php

define('POS_ROOT', getcwd());
if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
    global $data;
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    $query_id = isset($_POST['query']) ? $_POST['query'] : '';
    $datainput = isset($_POST['datainput']) ? $_POST['datainput'] : '';
    $data = explode('&', $datainput);
    $controllerDirs = POS_ROOT . '/controller/' . $name . 'Controller.php';
    include_once POS_ROOT . '/include/bootstrap.inc';
    $action = isset($_POST['action']) ? $_POST['action'] : '';
    if (!file_exists($controllerDirs)):
        $controllerDirs = POS_ROOT . '/controller/mainController.php';
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