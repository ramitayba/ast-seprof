<?php

/**
 * This is the Menu
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
include_once POS_ROOT . '/businessLayer/PosBusinessLayer.php';
include_once POS_ROOT . '/businessLayer/CafeteriaBusinessLayer.php';

$posBusinessLayer = new PosBusinessLayer();
if ($action == 'index' || $action == 'pos'):
    if ((!Helper::is_empty_string($query_id) && is_numeric($query_id)) || isset($_SESSION['cafeteria_id'])):
        $_SESSION['cafeteria_id'] = isset($_SESSION['cafeteria_id']) ? $_SESSION['cafeteria_id'] : $query_id;
        $posDataTable = $posBusinessLayer->getPosByCafeteriaID($_SESSION['cafeteria_id']);
    else:
        $posDataTable = $posBusinessLayer->getPos();
    endif;
    if ($posBusinessLayer->getSuccess()):
        $content = Helper::fill_datatable('pos', $posDataTable, array('Pos Name', 'Cafeteria Name', 'Status'), array('pos_key', 'cafeteria_name', 'status_name'), 'pos_id');
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
            print json_encode($content);
            return;
        endif;
        unset($_SESSION['messages']);
    else:
        $div = Helper::set_message('<li>error Connection</li>', 'error');
        $_SESSION['messages'] = $div;
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
            print json_encode($div);
            return;
        endif;
    endif;
elseif ($action == 'add'):
    $forms = array('cafeteria_id' => isset($_SESSION['cafeteria_id']) ? $_SESSION['cafeteria_id'] : '');
    include_once POS_ROOT . '/content/cafeterias/posform.php';
elseif ($action == 'edit'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $posDataTable = $posBusinessLayer->getPosByID($query_id);
        if (count($posDataTable) == 0):
            print json_encode(array('status' => 'error', 'message' => 'Item doesn t  exist '));
            return;
        endif;
        $forms = array('pos_id' => $posDataTable [0]['pos_id'], 'pos_key' => $posDataTable [0]['pos_key'], 'cafeteria_id' => $posDataTable [0]['cafeteria_id'], 'status_id' => $posDataTable [0]['status_id']);
        include_once POS_ROOT . '/content/cafeterias/posform.php';
    endif;
elseif ($action == 'save'):
    $name = isset($data['pos_key']) ? $data['pos_key'] : '';
    $cafeteria = isset($data['cafeteria']) ? $data['cafeteria'] : '';
    $status = isset($data['status']) ? $data['status'] : '';
    $array = array('Pos key' => $name, 'Cafeteria' => $cafeteria, 'Status' => $status);
    $message = Helper::is_list_empty($array);
    if (!Helper::is_empty_string($message)):
        print json_encode(array('status' => 'error', 'message' => $message));
        return;
    endif;
    $posDataTable = $posBusinessLayer->getPosByName($name);
    if (Helper::is_empty_string($query_id)):
        if (count($posDataTable) > 0):
            print json_encode(array('status' => 'error', 'message' => 'Pos name already exist'));
            return;
        endif;
        $success = $posBusinessLayer->addPos($name, $cafeteria, $status, $_SESSION['user_pos']);
    else:
        if (!is_numeric($query_id)):
            print json_encode(array('status' => 'error', 'message' => 'Pos doesn t  exist'));
            return;
        elseif (count($posDataTable) == 0):
            $posDataTable = $posBusinessLayer->getPosByID($query_id);
            if (count($posDataTable) == 0):
                print json_encode(array('status' => 'error', 'message' => 'Pos doesn t  exist '));
                return;
            endif;
        else:
            if ($posDataTable[0]['pos_id'] != $query_id):
                print json_encode(array('status' => 'error', 'message' => 'Can t be save'));
                return;
            endif;
        endif;
        $success = $posBusinessLayer->editPos($query_id, $name, $cafeteria, $status, $_SESSION['user_pos']);
    endif;
    if ($success):
        $posDataTable = isset($_SESSION['cafeteria_id']) ? 
        $posBusinessLayer->getPosByCafeteriaID($_SESSION['cafeteria_id']) :
        $posDataTable = $posBusinessLayer->getPos();
        if ($posBusinessLayer->getSuccess()):
            $content = Helper::fill_datatable('pos', $posDataTable, array('Pos Name', 'Cafeteria Name', 'Status'), array('pos_key', 'cafeteria_name', 'status_name'), 'pos_id');
        endif;
        $container = Helper::set_message('Pos saved succesfuly', 'status') . $content;
        print json_encode($container);
    else:
        print json_encode(array('status' => 'error', 'message' => 'Pos not saved '));
    endif;
elseif ($action == 'delete'):
    if (!Helper::is_empty_string($query_id)):
        $posDataTable = $posBusinessLayer->getPosById($query_id);
        if (count($posDataTable) == 0):
            print json_encode(array('status' => 'error', 'message' => 'POS doesn t  exist '));
            return;
        endif;
        $success = $posBusinessLayer->deletePos($query_id);
        if ($success):
            $container = Helper::set_message('POS ' . $posDataTable [0]['pos_key'] . ' delete succesfuly', 'status');
            print json_encode($container);
        else:
            print json_encode(array('status' => 'error', 'message' => 'POS not deleted '));
        endif;
    endif;
endif;
?>