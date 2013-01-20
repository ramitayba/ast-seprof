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
    $posDataTable = $posBusinessLayer->getPos();
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
    include_once POS_ROOT . '/content/cafeterias/posform.php';
elseif ($action == 'edit'):
    if (!Helper::is_empty_string($query_id)):
        $posDataTable = $posBusinessLayer->getPosByID($query_id);

        $forms = array('pos_id' => $posDataTable [0]['pos_id'], 'pos_key' => $posDataTable [0]['pos_key'], 'cafeteria_id' => $posDataTable [0]['cafeteria_id'], 'status_id' => $posDataTable [0]['status_id']);
        include_once POS_ROOT . '/content/cafeterias/posform.php';
    endif;
elseif ($action == 'save'):
    $name = isset($data['pos_key']) ? $data['pos_key'] : '';
    $cafeteria = isset($data['cafeteria']) ? $data['cafeteria'] : '';
    $status = isset($data['status']) ? $data['status'] : '';
    $forms = array('pos_id' => $query_id, 'pos_key' => $name, 'cafeteria_id' => $cafeteria, 'status_id' => $status);
    $array = array($name, $cafeteria, $status);

    $message = Helper::is_list_empty($array);
    if (!Helper::is_empty_string($message)):
        /* ob_start();
          include
          POS_ROOT . '/content/poss/possform.php';
          $html = ob_get_contents();
          ob_end_clean();
          print json_encode($html); */
        print json_encode(array('status' => 'error', 'message' => $message));
        return;
    endif;
    $posDataTable = $posBusinessLayer->getPosByName($name);
    if (Helper::is_empty_string($query_id)):
        if (count($posDataTable) > 0):
            print json_encode(array('status' => 'error', 'message' => 'Pos name already exist'));
            return;
        endif;
        $posDataTable = $posBusinessLayer->addPos($name, $cafeteria, $status, $_SESSION['user_pos']);
    else:
        if (count($posDataTable) == 0):
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
        $posDataTable = $posBusinessLayer->editPos($query_id, $name, $cafeteria, $status, $_SESSION['user_pos']);
    endif;
    if (count($posDataTable) > 0):
        $posDataTable = $posBusinessLayer->getPos();
        if ($posBusinessLayer->getSuccess()):
            $content = Helper::fill_datatable('pos', $posDataTable, array('Pos Name', 'Cafeteria Name', 'Status'), array('pos_key', 'cafeteria_name', 'status_name'), 'pos_id');
        endif;
        $_SESSION['messages'] = Helper::set_message('Pos saved succesfuly', 'status');
        print json_encode($content);
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
        $posDataTable = $posBusinessLayer->deletePos($query_id);
        if (count($posDataTable) > 0):
            print json_encode('POS delete succesfuly ');
        else:
            print json_encode(array('status' => 'error', 'message' => 'POS not deleted '));
        endif;
    endif;
endif;
?>