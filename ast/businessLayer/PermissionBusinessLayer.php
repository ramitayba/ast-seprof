<?php

/**
 * This is the PermissionBusinessLayer
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */

class PermissionBusinessLayer {

    private $_LastError;
    private $_PermissionDataTable;
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

    public function getPermission($role_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getPermission($role_id)";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_PermissionDataTable = DataAccessManager::getInstance()->fillData();
            if (Helper::is_empty_array($this->_PermissionDataTable)) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_PermissionDataTable;
    }
}
