<?php

/**
 * This is the userController
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
if ($action == 'login'):
    $user_name = isset($_POST['username']) ? $_POST['username'] : '';
    $password = isset($_POST['password']) ? $_POST['password'] : '';
    if (Helper::is_empty_string($user_name) || Helper::is_empty_string($password)):
        return;
    endif;
    $userBusinessLayer = new UserBusinessLayer();
    $userRow = $userBusinessLayer->login(Helper::mssql_escape($user_name), Helper::mssql_escape($password));
    if ($userBusinessLayer->getSuccess()):
        $_SESSION['user_pos'] = $userRow[0]['user_id'];
        $_SESSION['user_pos_role'] = $userRow[0]['role_id'];
        $_SESSION['user_pos_name'] = $userRow[0]['employee_first_name'];
    else: print $userBusinessLayer->getLastError();
    endif;
endif;
?>
