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
    unset($_SESSION['user_pos']);
elseif ($action == 'login'):
    $user_name = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    if (Helper::is_empty_string($user_name) || Helper::is_empty_string($password)):
        return;
    endif;
    $userRow = $userBusinessLayer->login(Helper::mssql_escape($user_name), Helper::mssql_escape($password));
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
    $userDataTable = $userBusinessLayer->getUsers();
    if ($userBusinessLayer->getSuccess()):
        $content = Helper::fill_datatable('users', $userDataTable, array('User Name', 'Password', 'Pin Code', 'Role Name', 'Employee Name'), array('user_name', 'user_password', 'user_pin', 'role_name', 'employee_name'), 'user_id');
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
    include POS_ROOT . '/content/users/usersform.php';
elseif ($action == 'edit'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $userDataTable = $userBusinessLayer->getUserByID($query_id);
        $forms = array('user_name' => $userDataTable [0]['user_name'], 'user_password' => $userDataTable [0]['user_password'],
            'user_pin' => $userDataTable [0]['user_pin'], 'role_id' => $userDataTable [0]['role_id'], 'employee_id' => $userDataTable [0]['empoyee_id'],
            'status' => $userDataTable [0]['status_id']);
        include_once POS_ROOT . '/content/users/usersform.php';
    endif;
elseif ($action == 'save'):
    $name = isset($data['user_name']) ? $data['user_name'] : '';
    $password = isset($data['user_password']) ? $data['user_password'] : '';
    $pin = isset($data['user_pin']) ? $data['user_pin'] : '';
    $role = isset($data['roles']) ? $data['roles'] : '';
    $employee = isset($data['employees']) ? $data['employees'] : '';
    $status = isset($data['status']) ? $data['status'] : '';
    $array = array('User Name ' => $name, 'Password' => $password,
        'Pin Code' => $pin, 'Role' => $role, 'Employee' => $employee, 'Status' => $employee);
    $message = Helper::is_list_empty($array);
    if (!Helper::is_empty_string($message)):
        print json_encode(array('status' => 'error', 'message' => $message));
        return;
    endif;
    $userDataTable = $userBusinessLayer->getUserByName($name);
    if (Helper::is_empty_string($query_id)):
        if (count($userDataTable) > 0):
            print json_encode(array('status' => 'error', 'message' => 'User name already exist'));
            return;
        endif;
        $success = $userBusinessLayer->addUser($name, $password, $pin, $role, $employee, $status);
    else:
        if (!is_numeric($query_id)):
            print json_encode(array('status' => 'error', 'message' => 'User doesn t  exist'));
            return;
        elseif (count($userDataTable) == 0):
            $userDataTable = $userBusinessLayer->getUserByID($query_id);
            if (count($userDataTable) == 0):
                print json_encode(array('status' => 'error', 'message' => 'User doesn t  exist '));
                return;
            endif;
        else:
            if ($userDataTable [0]['user_id'] != $query_id):
                print json_encode(array('status' => 'error', 'message' => 'Can t be save because User name already exist'));
                return;
            endif;
        endif;
        $success = $userBusinessLayer->editUser($query_id, $name, $password, $pin, $role, $employee, $status);
    endif;
    if (count($userDataTable) > 0):
        $userDataTable = $userBusinessLayer->getUsers();
        if ($userDataTable->getSuccess()):
            $content = Helper::fill_datatable('users', $userDataTable, array('User Name', 'Password', 'Pin Code', 'Role Name', 'Employee Name'), array('user_name', 'user_password', 'user_pin', 'role_name', 'employee_name'), 'user_id');
        endif;
        $container = Helper::set_message('User saved succesfuly', 'status') . $content;
        print json_encode($container);
    else:
        print json_encode(array('status' => 'error', 'message' => 'User not saved '));
    endif;
    if (!Helper::is_empty_string($query_id)):
        $userDataTable = $userBusinessLayer->getUserByID($query_id);
        if (count($userDataTable) == 0):
            print json_encode(array('status' => 'error', 'message' => 'User  doesn t  exist '));
            return;
        endif;
        $success = $userBusinessLayer->deleteUser($query_id, 2);
        if ($success):
            $container = Helper::set_message('Role ' . $userDataTable [0]['user_name'] . ' delete succesfuly', 'status');
            print json_encode($container);
        else:
            print json_encode(array('status' => 'error', 'message' => 'User not deleted '));
        endif;
    endif;
endif;
?>
