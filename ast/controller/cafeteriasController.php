<?php

/**
 * This is the Menu
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
include_once POS_ROOT . '/businessLayer/CafeteriaBusinessLayer.php';
$cafeteriaBusinessLayer = new CafeteriaBusinessLayer();
if ($action == 'index'):
    $cafeteriaDataTable = $cafeteriaBusinessLayer->getCafeterias();
    if ($cafeteriaBusinessLayer->getSuccess()):
        $content = Helper::fill_datatable('cafeterias', $cafeteriaDataTable, array('Cafeteria Name'), array('cafeteria_name'), 'cafeteria_id');
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
    include_once POS_ROOT . '/content/cafeterias/cafeteriasform.php';
elseif ($action == 'edit'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $cafeteriaDataTable = $cafeteriaBusinessLayer->getCafeteriaByID($query_id);
        if (count($cafeteriaDataTable) == 0):
            print json_encode(array('status' => 'error', 'message' => 'Cafeteria doesn t  exist '));
            return;
        endif;
        $forms = array('cafeteria_id' => $cafeteriaDataTable [0]['cafeteria_id'],
            'cafeteria_name' => $cafeteriaDataTable [0]['cafeteria_name']
            , 'status_id' => $cafeteriaDataTable [0]['status_id']);
        include_once POS_ROOT . '/content/cafeterias/cafeteriasform.php';
    endif;
elseif ($action == 'save'):
    $name = isset($data['cafeteria_name']) ? $data['cafeteria_name'] : '';
    $array = array('Cafeteria Name ' => $name);
    $message = Helper::is_list_empty($array);
    if (!Helper::is_empty_string($message)):
        print json_encode(array('status' => 'error', 'message' => $message));
        return;
    endif;
    $cafeteriaDataTable = $cafeteriaBusinessLayer->getCafeteriaByName($name);
    if (Helper::is_empty_string($query_id)):
        if (count($cafeteriaDataTable) > 0):
            print json_encode(array('status' => 'error', 'message' => 'Cafeteria name already exist'));
            return;
        endif;
        $success = $cafeteriaBusinessLayer->addCafeteria($name, $_SESSION['user_pos']);
    else:
        if (!is_numeric($query_id)):
            print json_encode(array('status' => 'error', 'message' => 'Cafeteria doesn t  exist'));
            return;
        elseif (count($cafeteriaDataTable) == 0):
            $cafeteriaDataTable = $cafeteriaBusinessLayer->getCafeteriaByID($query_id);
            if (count($cafeteriaDataTable) == 0):
                print json_encode(array('status' => 'error', 'message' => 'Cafeteria doesn t  exist '));
                return;
            endif;
        else:
            if ($cafeteriaDataTable [0]['cafeteria_id'] != $query_id):
                print json_encode(array('status' => 'error', 'message' => 'Can t be save'));
                return;
            endif;
        endif;
         $success = $cafeteriaBusinessLayer->editCafeteria($query_id, $name, $_SESSION['user_pos']);
    endif;
    if ($success):
        $cafeteriaDataTable = $cafeteriaBusinessLayer->getCafeterias();
        if ($cafeteriaBusinessLayer->getSuccess()):
            $content = Helper::fill_datatable('cafeterias', $cafeteriaDataTable, array('Cafeteria Name'), array('cafeteria_name'), 'cafeteria_id');
        endif;
        $container = Helper::set_message('Cafeteria saved succesfuly', 'status') . $content;
        print json_encode($container);
    else:
        print json_encode(array('status' => 'error', 'message' => 'Cafeteria not saved '));
    endif;
elseif ($action == 'delete'):
    if (!Helper::is_empty_string($query_id)):
        $cafeteriaDataTable = $cafeteriaBusinessLayer->getCafeteriaByID($query_id);
        if (count($cafeteriaDataTable) == 0):
            print json_encode(array('status' => 'error', 'message' => 'Cafeteria doesn t  exist '));
            return;
        endif;
         $success = $cafeteriaBusinessLayer->deleteCafeteria($query_id);
        if ( $success):
            $container = Helper::set_message('Cafeteria ' . $cafeteriaDataTable [0]['cafeteria_name'] . ' delete succesfuly', 'status');
            print json_encode($container);
        else:
            print json_encode(array('status' => 'error', 'message' => 'Cafeteria not deleted '));
        endif;
    endif;
endif;
?>