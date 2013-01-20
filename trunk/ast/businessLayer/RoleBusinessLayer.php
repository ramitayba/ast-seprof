<?php

/**
 * This is the RoleBusinessLayer
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
class RoleBusinessLayer {

    private $_LastError;
    private $_RoleDataTable;
    private $_Success;
    private $_SQLQuery;
    private $_Result;

    public function __construct() {
        
    }

    private function _reset() {
        $this->_LastError = '';
        $this->_Result = '';
        $this->_SQLQuery = '';
        $this->_Success = false;
    }

    public function getSuccess() {
        return $this->_Success;
    }

    public function getLastError() {
        return $this->_LastError;
    }

    public function getRoles() {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getRoles}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_RoleDataTable = DataAccessManager::getInstance()->fillData();
            if (Helper::is_empty_array($this->_RoleDataTable)) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_RoleDataTable;
    }

    public function getRoleByName($name) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getRoleByName(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_RoleDataTable = DataAccessManager::getInstance()->fillData(array($name));
            if (Helper::is_empty_array($this->_RoleDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_RoleDataTable;
    }

    public function getRoleByID($role_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getRoleByID(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_RoleDataTable = DataAccessManager::getInstance()->saveData(array($role_id));
            if (!Helper::is_empty_array($this->_RoleDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_RoleDataTable;
    }

    public function addRole($role_name, $status_id, $user_creation) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call addRole(?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_RoleDataTable = DataAccessManager::getInstance()->saveData($role_name, $status_id, $user_creation);
            if (!Helper::is_empty_array($this->_RoleDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_RoleDataTable;
    }

    public function editRole($role_id, $role_name, $status_id, $user_modification) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call editRole(?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_RoleDataTable = DataAccessManager::getInstance()->saveData($role_id, $role_name, $status_id, $user_modification);
            if (!Helper::is_empty_array($this->_RoleDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_RoleDataTable;
    }

    public function deleteRole($role_id, $status_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call deleteRole(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_RoleDataTable = DataAccessManager::getInstance()->saveData(array($role_id, $status_id));
            if (!Helper::is_empty_array($this->_RoleDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_RoleDataTable;
    }

    public function assignPermission($role_id, $permission) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call assignPermission($role_id, $permission);";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_RoleDataTable = DataAccessManager::getInstance()->saveData(); //array($role_id, $permission));
            if (!Helper::is_empty_array($this->_RoleDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_RoleDataTable;
    }

}
