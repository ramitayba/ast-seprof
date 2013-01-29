<?php

/**
 * This is the rolesController
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
include_once POS_ROOT . '/businessLayer/RoleBusinessLayer.php';
$roleBusinessLayer = new RoleBusinessLayer();
if ($action == 'roles' || $action == 'index'):
    $roleDataTable = $roleBusinessLayer->getRoles(ACTIVE);
    if ($roleBusinessLayer->getSuccess()):
        $content = Helper::fill_datatable('roles', 'roles', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $roleDataTable, array('Role Name', 'Status Name'), array('role_name', 'status_name'), 'role_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                    1 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete'),
                    2 => array('name' => 'Permissions', 'link' => 'permissions-', 'class' => 'permissions')));
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
    $forms = array('status_id' => ACTIVE);
    include POS_ROOT . '/content/users/rolesform.php';
elseif ($action == 'edit'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $roleDataTable = $roleBusinessLayer->getRoleByID($query_id, ACTIVE);
        if (count($roleDataTable) == 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Role doesn t  exist '));
            return;
        endif;
        $forms = array('role_id' => $query_id,
            'role_name' => $roleDataTable [0]['role_name'],
            'status_id' => $roleDataTable [0]['status_id']);
        include_once POS_ROOT . '/content/users/rolesform.php';
    else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('Roles not exist', 'error')));
    endif;
elseif ($action == 'save'):
    $name = isset($data['role_name']) ? $data['role_name'] : '';
    $status = isset($data['status']) ? $data['status'] : '';
    $array = array('Role Name ' => array('content' => $name, 'type' => 'string', 'length' => '100'), 'Status' => array('content' => $status, 'type' => 'int'));
    $message = Helper::is_list_empty($array);
    if (!Helper::is_empty_string($message)):
        print Helper::json_encode_array(array('status' => 'error', 'message' => $message));
        return;
    endif;
    $roleDataTable = $roleBusinessLayer->getRoleByName($name, ACTIVE);
    if (Helper::is_empty_string($query_id)):
        if (count($roleDataTable) > 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Role name already exist'));
            return;
        endif;
        $success = $roleBusinessLayer->addRole($name, $status, $_SESSION['user_pos']);
    else:
        if (!is_numeric($query_id)):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Role doesn t  exist'));
            return;
        elseif (count($roleDataTable) == 0):
            $roleDataTable = $roleBusinessLayer->getRoleByID($query_id, ACTIVE);
            if (count($roleDataTable) == 0):
                print Helper::json_encode_array(array('status' => 'error', 'message' => 'Role doesn t  exist '));
                return;
            endif;
        else:
            if ($roleDataTable [0]['role_id'] != $query_id):
                print Helper::json_encode_array(array('status' => 'error', 'message' => 'Can t be save because Role name already exist'));
                return;
            endif;
        endif;
        $success = $roleBusinessLayer->editRole($query_id, $name, $status, $_SESSION['user_pos']);
    endif;
    if ($success):
        $roleDataTable = $roleBusinessLayer->getRoles(ACTIVE);
        if ($roleBusinessLayer->getSuccess()):
            $content = Helper::fill_datatable('roles', 'roles', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $roleDataTable, array('Role Name', 'Status Name'), array('role_name', 'status_name'), 'role_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                        1 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete'),
                        2 => array('name' => 'Permissions', 'link' => 'permissions-', 'class' => 'permissions')));
        endif;
        $container = Helper::set_message('Role saved succesfuly', 'status') . $content;
        print $container;
    else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => 'Role not saved '));
    endif;
elseif ($action == 'delete'):
   if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $roleDataTable = $roleBusinessLayer->getRoleByID($query_id, ACTIVE);
        if (count($roleDataTable) == 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Role doesn t  exist '));
            return;
        endif;
        $success = $roleBusinessLayer->deleteRole($query_id, UNDER_PROCESSING, $_SESSION['user_pos']);
        if ($success):
            $container = Helper::set_message('Role ' . $roleDataTable [0]['role_name'] . ' delete succesfuly', 'status');
            print Helper::json_encode($container);
        else:
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Role not deleted '));
        endif;
   else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('Roles not exist', 'error')));
    endif;
endif;
?>
