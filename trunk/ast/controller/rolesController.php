<?php

/**
 * This is the roleController
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
include_once POS_ROOT . '/businessLayer/RoleBusinessLayer.php';
$roleBusinessLayer = new RoleBusinessLayer();
if ($action == 'roles'||$action == 'index'):
    $roleDataTable = $roleBusinessLayer->getRoles();
    if ($roleBusinessLayer->getSuccess()):
        $content = Helper::fill_datatable('roles', $roleDataTable, array('Role Name', 'Status Name'), array('role_name', 'status_name'), 'role_id','permission');
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
    //ob_start();
    include POS_ROOT . '/content/users/rolesform.php';
//$//html = ob_get_contents();
//ob_end_clean();
//print json_encode($html);
elseif ($action == 'edit'):
    if (!Helper::is_empty_string($query_id)):
        $roleDataTable = $roleBusinessLayer->getRoleByID($query_id);
        $forms = array('role_name' => $roleDataTable [0]['role_name']);
        include_once POS_ROOT . '/content/users/rolesform.php';
    endif;
elseif ($action == 'save'):
    $name = isset($_POST['role_name']) ? $_POST['role_name'] : '';
    $forms = array('role_name' => $name);
    if (Helper::is_empty_string($name)):
        /* ob_start();
          include
          POS_ROOT . '/content/cafeterias/cafeteriasform.php';
          $html = ob_get_contents();
          ob_end_clean();
          print json_encode($html); */
        print json_encode(array('status' => 'error', 'message' => 'cant be empty'));
        return;
    endif;
    $roleDataTable = $roleBusinessLayer->getRoleByName($name);
    if (Helper::is_empty_string($query_id)):
        if (count($roleDataTable) > 0):
            print json_encode(array('status' => 'error', 'message' => 'Role name already exist'));
            return;
        endif;
        $roleDataTable = $roleBusinessLayer->addRole($name, 1,$_SESSION['user_pos']);
    else:
        if (count($roleDataTable) == 0):
            $roleDataTable = $roleBusinessLayer->getRoleByID($query_id);
            if (count($roleDataTable) == 0):
                print json_encode(array('status' => 'error', 'message' => 'Role doesn t  exist '));
                return;
            endif;
        else:
            if ($roleDataTable [0]['role_id'] != $query_id):
                print json_encode(array('status' => 'error', 'message' => 'Can t be save'));
                return;
            endif;
        endif;
        $roleDataTable = $roleBusinessLayer->editRole($query_id,$name, 1,$_SESSION['user_pos']);
    endif;
    if (count($roleDataTable) > 0):
        $roleDataTable = $roleBusinessLayer->getRoles();
        if ($roleDataTable->getSuccess()):
           $content = Helper::fill_datatable('roles', $roleDataTable, array('Role Name','Status Name'), array('role_name','status_name'), 'role_id');
        endif;
        $_SESSION['messages'] = Helper::set_message('Role saved succesfuly', 'status');
        print json_encode($content);
    else:
        print json_encode(array('status' => 'error', 'message' => 'Role not saved '));
    endif;
endif;
?>
