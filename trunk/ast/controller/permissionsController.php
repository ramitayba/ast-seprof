<?php

/**
 * This is the permissionsController
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
include_once POS_ROOT . '/businessLayer/RoleBusinessLayer.php';
$roleBusinessLayer = new RoleBusinessLayer();
if ($action == 'index'):
    $roleDataTable = $roleBusinessLayer->getRoles(ACTIVE);
    if ($roleBusinessLayer->getSuccess()):
        $content = Helper::fill_datatable('roles','roles', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $roleDataTable, array('Role Name', 'Status Name'), array('role_name', 'status_name'), 'role_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                    1 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete'),
                    2 => array('name' => 'Permissions', 'link' => 'permissions-', 'class' => 'permissions')));
        print $content;
    endif;
elseif ($action == 'add'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $permissionDataTable = $roleBusinessLayer->getListMenuUnionAccess($query_id);
        if (count($permissionDataTable) == 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Role doesn t  exist '));
            return;
        endif;
        $forms = array('role_id' => $query_id,
            'permissions' => $permissionDataTable);
        include_once POS_ROOT . '/content/users/permissionsform.php';
   else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('Permissions not exist', 'error')));
        return;
    endif;
elseif ($action == 'save'):
    $permissions = isset($sequence) ? $sequence : '';
    if (Helper::is_empty_string($query_id) || !is_numeric($query_id)):
        print Helper::json_encode_array(array('status' => 'error', 'message' => 'Role doesn t exist'));
        return;
    endif;
    $success = $roleBusinessLayer->assignPermission($query_id, $permissions);
    if ($success):
        $roleDataTable = $roleBusinessLayer->getRoles(ACTIVE);
        if ($roleBusinessLayer->getSuccess()):
            $content = Helper::fill_datatable('roles','roles', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $roleDataTable, array('Role Name', 'Status Name'), array('role_name', 'status_name'), 'role_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                        1 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete'),
                        2 => array('name' => 'Permissions', 'link' => 'permissions-', 'class' => 'permissions')));
        endif;
        $container = Helper::set_message('Role Permissions saved succesfuly', 'status') . $content;
        print $container;
    else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => 'Role Permissions not saved '));
    endif;
endif;
?>
