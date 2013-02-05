<?php

/**
 * This is the Cafeterias 
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
include_once POS_ROOT . '/businessLayer/CafeteriaBusinessLayer.php';
$cafeteriaBusinessLayer = new CafeteriaBusinessLayer();
unset($_SESSION['cafeteria_id']);
if ($action == 'index'):
    $cafeteriaDataTable = $cafeteriaBusinessLayer->getCafeterias(DELETED);
    if ($cafeteriaBusinessLayer->getSuccess()):
        $content = Helper::fill_datatable('cafeterias', 'cafeterias', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $cafeteriaDataTable, array('Cafeteria Name'), array('cafeteria_name'), 'cafeteria_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                    1 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete'),
                    2 => array('name' => 'Pos', 'link' => 'pos-', 'class' => 'pos')));
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
            print $content;
        endif;
        unset($_SESSION['messages']);
    else:
        $div = Helper::set_message('<li>error Connection</li>', 'error');
        $_SESSION['messages'] = $div;
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
            print $div;
        endif;
    endif;
elseif ($action == 'add'):
    include_once POS_ROOT . '/content/cafeterias/cafeteriasform.php';
elseif ($action == 'edit'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $cafeteriaDataTable = $cafeteriaBusinessLayer->getCafeteriaByID($query_id, DELETED);
        if (count($cafeteriaDataTable) == 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('Cafeteria doesn t exist', 'error')));
            return;
        endif;
        $forms = array('cafeteria_id' => $cafeteriaDataTable [0]['cafeteria_id'],
            'cafeteria_name' => $cafeteriaDataTable [0]['cafeteria_name']
            , 'status_id' => $cafeteriaDataTable [0]['status_id']);
        include_once POS_ROOT . '/content/cafeterias/cafeteriasform.php';
    else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('Cafeteria not exist', 'error')));
    endif;
elseif ($action == 'save'):
    $name = isset($data['cafeteria_name']) ? $data['cafeteria_name'] : '';
    $list = array('Cafeteria Name ' => array('content' => $name, 'type' => 'string', 'length' => '50'));
    $message = Helper::is_list_empty($list);
    if (!Helper::is_empty_string($message)):
        print Helper::json_encode_array(array('status' => 'error', 'message' => $message));
        return;
    endif;
    $cafeteriaDataTable = $cafeteriaBusinessLayer->getCafeteriaByName($name, DELETED);
    if (Helper::is_empty_string($query_id)):
        if (count($cafeteriaDataTable) > 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Cafeteria name already exist'));
            return;
        endif;
        $success = $cafeteriaBusinessLayer->addCafeteria($name, ACTIVE, $_SESSION['user_pos']);
    else:
        if (!is_numeric($query_id)):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Cafeteria doesn t exist'));
            return;
        elseif (count($cafeteriaDataTable) == 0):
            $cafeteriaDataTable = $cafeteriaBusinessLayer->getCafeteriaByID($query_id, DELETED);
            if (count($cafeteriaDataTable) == 0):
                print Helper::json_encode_array(array('status' => 'error', 'message' => 'Cafeteria doesn t  exist '));
                return;
            endif;
        else:
            if ($cafeteriaDataTable[0]['cafeteria_name'] == $name&&$cafeteriaDataTable[0]['cafeteria_id'] != $query_id):
                print Helper::json_encode_array(array('status' => 'error', 'message' => 'Cafeteria name already exist'));
                return;
            elseif ($cafeteriaDataTable [0]['cafeteria_id'] != $query_id):
                print Helper::json_encode_array(array('status' => 'error', 'message' => 'Cafeteria canot be saved'));
                return;
            endif;
        endif;
        $success = $cafeteriaBusinessLayer->editCafeteria($query_id, $name, $_SESSION['user_pos']);
    endif;
    if ($success):
        $cafeteriaDataTable = $cafeteriaBusinessLayer->getCafeterias(DELETED);
        if ($cafeteriaBusinessLayer->getSuccess()):
            $content = Helper::fill_datatable('cafeterias', 'cafeterias', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $cafeteriaDataTable, array('Cafeteria Name'), array('cafeteria_name'), 'cafeteria_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                        1 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete'),
                        2 => array('name' => 'Pos', 'link' => 'pos-', 'class' => 'pos')));
        endif;
        $container = Helper::set_message('Cafeteria saved succesfuly', 'status') . $content;
        print $container;
    else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => 'Cafeteria not saved '));
    endif;
elseif ($action == 'delete'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $cafeteriaDataTable = $cafeteriaBusinessLayer->getCafeteriaByID($query_id, DELETED);
        if (count($cafeteriaDataTable) == 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('Cafeteria not exist', 'error')));
            return;
        endif;
        $success = $cafeteriaBusinessLayer->deleteCafeteria($query_id, DELETED, $_SESSION['user_pos']);
        if ($success):
            $container = Helper::set_message('Cafeteria ' . $cafeteriaDataTable [0]['cafeteria_name'] . ' delete succesfuly', 'status');
             print Helper::json_encode_array(array('status' => 'success', 'message' =>$container));
        else:
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Cafeteria not deleted '));
        endif;
    else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('Cafeteria not exist', 'error')));
    endif;
endif;
?>