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
if ($action == 'roles' || $action == 'index'):
    $roleDataTable = $roleBusinessLayer->getRoles();
    if ($roleBusinessLayer->getSuccess()):
        $content = Helper::fill_datatable('roles', $roleDataTable, array('Role Name', 'Status Name'), array('role_name', 'status_name'), 'role_id', array('permissions'));
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
    include POS_ROOT . '/content/users/rolesform.php';
elseif ($action == 'edit'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $roleDataTable = $roleBusinessLayer->getRoleByID($query_id);
        if (count($roleDataTable) == 0):
            print json_encode(array('status' => 'error', 'message' => 'Role doesn t  exist '));
            return;
        endif;
        $forms = array('role_id' => $roleDataTable [0]['role_id'],
            'role_name' => $roleDataTable [0]['role_name'],
            'status_id' => $roleDataTable [0]['status_id']);
        include_once POS_ROOT . '/content/users/rolesform.php';
    endif;
elseif ($action == 'save'):
    $name = isset($data['role_name']) ? $data['role_name'] : '';
    $status = isset($data['status']) ? $data['status'] : '';
    $array = array('Role Name ' => $name, 'Status' => $status);
    $message = Helper::is_list_empty($array);
    if (!Helper::is_empty_string($message)):
        print json_encode(array('status' => 'error', 'message' => $message));
        return;
    endif;
    $roleDataTable = $roleBusinessLayer->getRoleByName($name);
    if (Helper::is_empty_string($query_id)):
        if (count($roleDataTable) > 0):
            print json_encode(array('status' => 'error', 'message' => 'Role name already exist'));
            return;
        endif;
        $success = $roleBusinessLayer->addRole($name, $status, $_SESSION['user_pos']);
    else:
        if (!is_numeric($query_id)):
            print json_encode(array('status' => 'error', 'message' => 'Role doesn t  exist'));
            return;
        elseif (count($roleDataTable) == 0):
            $roleDataTable = $roleBusinessLayer->getRoleByID($query_id);
            if (count($roleDataTable) == 0):
                print json_encode(array('status' => 'error', 'message' => 'Role doesn t  exist '));
                return;
            endif;
        else:
            if ($roleDataTable [0]['role_id'] != $query_id):
                print json_encode(array('status' => 'error', 'message' => 'Can t be save because Role name already exist'));
                return;
            endif;
        endif;
        $success = $roleBusinessLayer->editRole($query_id, $name, $status, $_SESSION['user_pos']);
    endif;
    if ($success):
        $roleDataTable = $roleBusinessLayer->getRoles();
        if ($roleBusinessLayer->getSuccess()):
            $content = Helper::fill_datatable('roles', $roleDataTable, array('Role Name', 'Status Name'), array('role_name', 'status_name'), 'role_id', array('permissions'));
        endif;
        $container = Helper::set_message('Role saved succesfuly', 'status') . $content;
        print json_encode($container);
    else:
        print json_encode(array('status' => 'error', 'message' => 'Role not saved '));
    endif;
elseif ($action == 'delete'):
    if (!Helper::is_empty_string($query_id)):
        $roleDataTable = $roleBusinessLayer->getRoleByID($query_id);
        if (count($roleDataTable) == 0):
            print json_encode(array('status' => 'error', 'message' => 'Role doesn t  exist '));
            return;
        endif;
        $success = $roleBusinessLayer->deleteRole($query_id,2,$_SESSION['user_pos']);
        if ($success):
            $container = Helper::set_message('Role ' . $roleDataTable [0]['role_name'] . ' delete succesfuly', 'status');
            print json_encode($container);
        else:
            print json_encode(array('status' => 'error', 'message' => 'Role not deleted '));
        endif;
    endif;
endif;
?>
