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
if ($action == 'cafeterias' && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'):
    if ((!Helper::is_empty_string($query_id) && is_numeric($query_id)) || isset($_SESSION['cafeteria_id'])):
        $_SESSION['cafeteria_id'] = isset($_SESSION['cafeteria_id']) ? $_SESSION['cafeteria_id'] : $query_id;
        $posDataTable = $posBusinessLayer->getPosByCafeteriaID($_SESSION['cafeteria_id'], ACTIVE);
        $content = Helper::fill_datatable('pos', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $posDataTable, array('Pos Name', 'Cafeteria Name', 'Status'), array('pos_key', 'cafeteria_name', 'status_name'), 'pos_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                    1 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete')));
        print $content;
        return;
    endif;
endif;
if ($action == 'pos'):
    unset($_SESSION['cafeteria_id']);
endif;
if ($action == 'index' || $action == 'pos'):
    $posDataTable = isset($_SESSION['cafeteria_id']) ? $posBusinessLayer->getPosByCafeteriaID($_SESSION['cafeteria_id'], ACTIVE) : $posBusinessLayer->getPos(ACTIVE);
    if ($posBusinessLayer->getSuccess()):
        $content = Helper::fill_datatable('pos', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $posDataTable, array('Pos Name', 'Cafeteria Name', 'Status'), array('pos_key', 'cafeteria_name', 'status_name'), 'pos_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                    1 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete')));
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
            print $content;
            return;
        endif;
        unset($_SESSION['messages']);
    else:
        $div = Helper::set_message('<li>error Connection</li>', 'error');
        $_SESSION['messages'] = $div;
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
            print $div;
            return;
        endif;
    endif;
elseif ($action == 'add'):
    $forms = array('cafeteria_id' => isset($_SESSION['cafeteria_id']) ? $_SESSION['cafeteria_id'] : '',
        'status_id' => ACTIVE);
    include_once POS_ROOT . '/content/cafeterias/posform.php';
elseif ($action == 'edit'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $posDataTable = $posBusinessLayer->getPosByID($query_id, ACTIVE);
        if (count($posDataTable) == 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Item doesn t  exist '));
            return;
        endif;
        $forms = array('pos_id' => $posDataTable [0]['pos_id'], 'pos_key' => $posDataTable [0]['pos_key'], 'cafeteria_id' => $posDataTable [0]['cafeteria_id'], 'status_id' => $posDataTable [0]['status_id']);
        include_once POS_ROOT . '/content/cafeterias/posform.php';
    endif;
elseif ($action == 'save'):
    $name = isset($data['pos_key']) ? $data['pos_key'] : '';
    $cafeteria = isset($data['cafeteria']) ? $data['cafeteria'] : '';
    $status = isset($data['status']) ? $data['status'] : '';
    $array = array('Pos key' => array('content' => $name, 'type' => 'string', 'length' => '150'), 'Cafetereia Name' => array('content' => $cafeteria, 'type' => 'int'), 'Status' => array('content' => $status, 'type' => 'int'));
    $message = Helper::is_list_empty($array);
    if (!Helper::is_empty_string($message)):
        print Helper::json_encode_array(array('status' => 'error', 'message' => $message));
        return;
    endif;
    $posDataTable = $posBusinessLayer->getPosByName($name, ACTIVE);
    if (Helper::is_empty_string($query_id)):
        if (count($posDataTable) > 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Pos name already exist'));
            return;
        endif;
        $success = $posBusinessLayer->addPos($name, $cafeteria, $status, $_SESSION['user_pos']);
    else:
        if (!is_numeric($query_id)):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Pos doesn t  exist'));
            return;
        elseif (count($posDataTable) == 0):
            $posDataTable = $posBusinessLayer->getPosByID($query_id, ACTIVE);
            if (count($posDataTable) == 0):
                print Helper::json_encode_array(array('status' => 'error', 'message' => 'Pos doesn t  exist '));
                return;
            endif;
        else:
            if ($posDataTable[0]['pos_id'] != $query_id):
                print Helper::json_encode_array(array('status' => 'error', 'message' => 'Can t be save'));
                return;
            endif;
        endif;
        $success = $posBusinessLayer->editPos($query_id, $name, $cafeteria, $status, $_SESSION['user_pos']);
    endif;
    if ($success):
        $posDataTable = isset($_SESSION['cafeteria_id']) ?
                $posBusinessLayer->getPosByCafeteriaID($_SESSION['cafeteria_id'], ACTIVE) :
                $posDataTable = $posBusinessLayer->getPos(ACTIVE);
        if ($posBusinessLayer->getSuccess()):
            $content = Helper::fill_datatable('pos', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $posDataTable, array('Pos Name', 'Cafeteria Name', 'Status'), array('pos_key', 'cafeteria_name', 'status_name'), 'pos_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                        1 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete')));
        endif;
        $container = Helper::set_message('Pos saved succesfuly', 'status') . $content;
        print $container;
    else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => 'Pos not saved '));
    endif;
elseif ($action == 'delete'):
    if (!Helper::is_empty_string($query_id)):
        $posDataTable = $posBusinessLayer->getPosById($query_id, ACTIVE);
        if (count($posDataTable) == 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'POS doesn t  exist '));
            return;
        endif;
        $success = $posBusinessLayer->deletePos($query_id, DESACTIVE, $_SESSION['user_pos']);
        if ($success):
            $container = Helper::set_message('POS ' . $posDataTable [0]['pos_key'] . ' delete succesfuly', 'status');
            print Helper::json_encode($container);
        else:
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'POS not deleted '));
        endif;
    endif;
endif;
?>