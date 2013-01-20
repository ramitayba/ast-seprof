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
    if (!Helper::is_empty_string($query_id)):
        $cafeteriaDataTable = $cafeteriaBusinessLayer->getCafeteriaByID($query_id);
        $forms = array('cafeteria_id' => $cafeteriaDataTable [0]['cafeteria_id'], 'cafeteria_name' => $cafeteriaDataTable [0]['cafeteria_name']);
        include_once POS_ROOT . '/content/cafeterias/cafeteriasform.php';
    endif;
elseif ($action == 'save'):
    $name = isset($data['cafeteria_name']) ? $data['cafeteria_name'] : '';
    $forms = array('cafeteria_id' => $query_id, 'cafeteria_name' => $name);
    if (Helper::is_empty_string($name)):
        /* ob_start();
          include
          POS_ROOT . '/content/cafeterias/cafeteriasform.php';
          $html = ob_get_contents();
          ob_end_clean();
          print json_encode($html); */
        print json_encode(array('status' => 'error', 'message' => 'Cafeteria name cant be empty'));
        return;
    endif;
    $cafeteriaDataTable = $cafeteriaBusinessLayer->getCafeteriaByName($name);
    if (Helper::is_empty_string($query_id)):
        if (count($cafeteriaDataTable) > 0):
            print json_encode(array('status' => 'error', 'message' => 'Cafeteria name already exist'));
            return;
        endif;
        $cafeteriaDataTable = $cafeteriaBusinessLayer->addCafeteria($name, $_SESSION['user_pos']);
    else:
        if (count($cafeteriaDataTable) == 0):
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
        $cafeteriaDataTable = $cafeteriaBusinessLayer->editCafeteria($query_id, $name, $_SESSION['user_pos']);
    endif;
    if (count($cafeteriaDataTable) > 0):
        $cafeteriaDataTable = $cafeteriaBusinessLayer->getCafeterias();
        if ($cafeteriaBusinessLayer->getSuccess()):
            $content = Helper::fill_datatable('cafeterias', $cafeteriaDataTable, array('Cafeteria Name'), array('cafeteria_name'), 'cafeteria_id');
        endif;
        $_SESSION['messages'] = Helper::set_message('Cafeteria saved succesfuly', 'status');
        print json_encode($content);
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
        $cafeteriaDataTable = $cafeteriaBusinessLayer->deleteCafeteria($query_id);
        if (count($cafeteriaDataTable) > 0):
            print json_encode('Cafeteria delete succesfuly ');
        else:
            print json_encode(array('status' => 'error', 'message' => 'Cafeteria not deleted '));
        endif;
    endif;
endif;
?>