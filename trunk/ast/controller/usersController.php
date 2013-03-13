<?php

/**
 * This is the userController
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
include_once POS_ROOT . '/businessLayer/UserBusinessLayer.php';
include_once POS_ROOT . '/businessLayer/RoleBusinessLayer.php';
$userBusinessLayer = new UserBusinessLayer();
if ($action == 'logout'):
    $title = 'login';
    unset($_SESSION['user_pos']);
elseif ($action == 'login'):
    $title = 'login';
    $user_name = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    if (Helper::is_empty_string($user_name) || Helper::is_empty_string($password)):
        return;
    endif;
    $userRow = $userBusinessLayer->login(Helper::mssql_escape($user_name), md5(Helper::mssql_escape($password)), ACTIVE);
    if ($userBusinessLayer->getSuccess()):
        $_SESSION['user_pos'] = $userRow[0]['user_id'];
        $_SESSION['user_pos_role'] = $userRow[0]['role_id'];
        $_SESSION['user_pos_name'] = $userRow[0]['employee_first_name'];
        unset($_SESSION['messages']);
        Helper::redirect();
    else:
        $div = Helper::set_message('<li>username and password is incorrect</li>', 'error');
        $_SESSION['messages'] = $div;
    endif;
elseif ($action == 'index'):
    $userDataTable = $userBusinessLayer->getUsers(DELETED);
    if ($userBusinessLayer->getSuccess()):
        $content = Helper::fill_datatable('users', 'users', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $userDataTable, array('User Name', 'Pin Code', 'Role Name', 'Employee Name'), array('user_name', 'user_pin', 'role_name', 'employee_name'), 'user_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
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
        endif;
    endif;
elseif ($action == 'add'):
    $forms = array('status_id' => ACTIVE);
    include POS_ROOT . '/content/users/usersform.php';
elseif ($action == 'edit'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $userDataTable = $userBusinessLayer->getUserByID($query_id, DELETED);
        if (count($userDataTable) == 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('User doesn t exist', 'error')));
            return;
        endif;
        $forms = array('user_id' => $query_id, 'user_name' => $userDataTable [0]['user_name'], 'user_password' => $userDataTable [0]['user_password'],
            'user_pin' => $userDataTable [0]['user_pin'], 'role_id' => $userDataTable [0]['role_id'], 'employee_id' => $userDataTable [0]['employee_id'],
            'status_id' => $userDataTable [0]['status_id']);
        include_once POS_ROOT . '/content/users/usersform.php';
    else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('Users not exist', 'error')));
    endif;
elseif ($action == 'save'):
    $name = isset($data['user_name']) ? $data['user_name'] : '';
    $password = isset($data['user_password']) ? $data['user_password'] : '';
    $pin = isset($data['user_pin']) ? $data['user_pin'] : '';
    $role = isset($data['roles']) ? $data['roles'] : '';
    $employee = isset($data['employees']) ? $data['employees'] : '';
    $status = isset($data['status']) ? $data['status'] : '';
    $array = array('Role' => array('content' => $role, 'type' => 'int'), 'Employee' => array('content' => $employee, 'type' => 'int'), 'Status' => array('content' => $status, 'type' => 'int'));
    $message = Helper::is_list_empty($array);
    if (!Helper::is_empty_string($message)):
        print Helper::json_encode_array(array('status' => 'error', 'message' => $message));
        return;
    endif;
    $array = array();
    switch ($role):
        case ADMINISTRATOR:
            $array = array('User Name ' => array('content' => $name, 'type' => 'string', 'length' => '50'), 'Password' => array('content' => $password, 'type' => 'string', 'length' => '50'));
            break;
        case SUPERVISOR:
            $array = array('User Name ' => array('content' => $name, 'type' => 'string', 'length' => '50'), 'Password' => array('content' => $password, 'type' => 'string', 'length' => '50'),
                'Pin Code' => array('content' => $pin, 'type' => 'string', 'length' => '4'));
            break;
        case OPERATOR:
            $array = array('Pin Code' => array('content' => $pin, 'type' => 'string', 'length' => '4'));
            break;
        case MANAGER:
            $array = array('User Name ' => array('content' => $name, 'type' => 'string', 'length' => '50'), 'Password' => array('content' => $password, 'type' => 'string', 'length' => '50'));
            break;
        default :break;
    endswitch;
    $message = Helper::is_list_empty($array);
    if (!Helper::is_empty_string($message)):
        print Helper::json_encode_array(array('status' => 'error', 'message' => $message));
        return;
    endif;
    $password = Helper::is_empty_string($password) ? $password : md5($password);
    $userDataTable = $userBusinessLayer->getUserByName($name, DELETED);
    if (Helper::is_empty_string($query_id)):
        if (count($userDataTable) > 0 && $role != OPERATOR):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'User name already exist'));
            return;
        endif;
        $success = $userBusinessLayer->addUser($name,$password, $pin, $role, $employee, $status);
    else:
        if (!is_numeric($query_id)):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'User doesn t  exist'));
            return;
        elseif (count($userDataTable) == 0):
            $userDataTable = $userBusinessLayer->getUserByID($query_id, DELETED);
            if (count($userDataTable) == 0):
                print Helper::json_encode_array(array('status' => 'error', 'message' => 'User doesn t  exist '));
                return;
            endif;
        else:
            if ($userDataTable[0]['user_name'] == $name && $userDataTable[0]['user_id'] != $query_id && $role != OPERATOR):
                print Helper::json_encode_array(array('status' => 'error', 'message' => 'User name already exist'));
                return;
            elseif ($userDataTable [0]['user_id'] != $query_id&& $role != OPERATOR):
                print Helper::json_encode_array(array('status' => 'error', 'message' => 'Can t be save because User name already exist'));
                return;
            endif;
        endif;
        $success = $userBusinessLayer->editUser($query_id, $name, $password, $pin, $role, $employee, $status);
    endif;
    if ($success):
        $userDataTable = $userBusinessLayer->getUsers(DELETED);
        if ($userBusinessLayer->getSuccess()):
            $content = Helper::fill_datatable('users', 'users', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $userDataTable, array('User Name', 'Pin Code', 'Role Name', 'Employee Name'), array('user_name', 'user_pin', 'role_name', 'employee_name'), 'user_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                        1 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete')));
        endif;
        $container = Helper::set_message('User saved successfully', 'status') . $content;
        print $container;
    else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => 'User not saved '));
    endif;
elseif ($action == 'delete'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $userDataTable = $userBusinessLayer->getUserByID($query_id, DELETED);
        if (count($userDataTable) == 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('User not exist', 'error')));
            return;
        endif;
        $success = $userBusinessLayer->deleteUser($query_id, DELETED);
        if ($success):
            $container = Helper::set_message('Role ' . $userDataTable [0]['user_name'] . ' deleted successfully', 'status');
            print Helper::json_encode_array(array('status' => 'success', 'message' => $container));
        else:
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'User not deleted '));
        endif;
    else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('Users not exist', 'error')));
    endif;
endif;
?>
