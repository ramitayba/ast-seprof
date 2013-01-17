<?php

/**
 * This is the CafeteriaBusinessLayer
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
class LookupBusinessLayer {

    private $_LastError;
    private $_EmployeesDataTable;
    private $_PermissionDataTable;
    private $_Success;
    private $_SQLQuery;
    private $_Result;
    private static $_Instance;

    public static function getInstance() {
        if (!self::$_Instance) {
            self::$_Instance = new LookupBusinessLayer();
        }
        return self::$_Instance;
    }

    private function __construct() {
        
    }

    private function _reset() {
        $this->_LastError = '';
        $this->_Result = '';
        $this->_SQLQuery = '';
        $this->_Success = false;
    }

    public function getLastError() {
        return $this->_LastError;
    }

    public function getEmployees() {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getEmployees}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_EmployeesDataTable = DataAccessManager::getInstance()->fillData();
            if (Helper::is_empty_array($this->_EmployeesDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_EmployeesDataTable;
    }

    public function getPermission($role_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getPermission(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_PermissionDataTable = DataAccessManager::getInstance()->fillData(array($role_id));
            if (Helper::is_empty_array($this->_PermissionDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_PermissionDataTable;
    }

}

?>
