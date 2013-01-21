<?php

/**
 * This is the UserBusinessLayer
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
class UserBusinessLayer {

    private $_LastError;
    private $_UserDataTable;
    private $_IDLogin;
    private $_IDUser;
    private $_Success;
    private $_SQLQuery;
    private $_Result;

    public function __construct() {
        
    }

    private function _reset() {
        $this->_LastError = '';
        $this->_IDLogin = 0;
        $this->_IDUser = 0;
        $this->_Result = '';
        $this->_SQLQuery = '';
        $this->_Success = false;
    }

    public function getLogin() {
        return $this->_IDLogin;
    }

    public function getLastError() {
        return $this->_LastError;
    }

    public function getSuccess() {
        return $this->_Success;
    }

    public function getUsers1() {
        try {
            $this->_reset();
            $this->_SQLQuery = "SELECT * From [user]";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_UserDataTable = DataAccessManager::getInstance()->fillData();
            if (Helper::is_empty_array($this->_UserDataTable)) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_UserDataTable;
    }

    public function getUsers() {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getUsers}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_UserDataTable = DataAccessManager::getInstance()->fillData();
            if (!Helper::is_empty_array($this->_UserDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_UserDataTable;
    }

    public function getUserByName($name) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getUserByName(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_UserDataTable = DataAccessManager::getInstance()->fillData(array($name));
            if (Helper::is_empty_array($this->_UserDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_UserDataTable;
    }

    public function login($user_name, $password) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getLogin(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_UserDataTable = DataAccessManager::getInstance()->fillData(array($user_name, $password));
            if (!Helper::is_empty_array($this->_UserDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_UserDataTable;
    }

    public function getUserByID($user_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getUserByID(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_UserDataTable = DataAccessManager::getInstance()->saveData(array($user_id));
            if (!Helper::is_empty_array($this->_UserDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_UserDataTable;
    }

    public function addUser($user_name, $password, $pin_code, $role_id, $employee_id, $status_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call addUser(?,?,?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success= DataAccessManager::getInstance()->saveData(array($user_name, $password, $pin_code, $role_id, $employee_id, $status_id));
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success=false;
        }
        return $this->_Success;
    }

    public function editUser($user_id, $user_name, $password, $pin_code, $role_id, $employee_id, $status_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call editUser(?,?,?,?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($user_id, $user_name, $password, $pin_code, $role_id, $employee_id, $status_id));
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success=false;
        }
        return $this->_Success;
    }

    public function deleteUser($user_id,$status_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call deleteUser(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($user_id,$status_id));
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success=false;
        }
        return $this->_Success;
    }

}

