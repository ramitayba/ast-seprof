<?php

/**
 * This is the PosBusinessLayer
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
class PosBusinessLayer {

    private $_LastError;
    private $_PosDataTable;
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

    public function getPos() {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getPos}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_PosDataTable = DataAccessManager::getInstance()->fillData();
            if (Helper::is_empty_array($this->_PosDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_PosDataTable;
    }

    public function getPosByName($name) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getPosByName(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_PosDataTable = DataAccessManager::getInstance()->fillData(array($name));
            if (Helper::is_empty_array($this->_PosDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_PosDataTable;
    }

    public function getPosByID($id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getPosByID(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_PosDataTable = DataAccessManager::getInstance()->fillData(array($id));
            if (Helper::is_empty_array($this->_PosDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_PosDataTable;
    }

    public function addPos($pos_name, $cafeteria_id, $status_id, $user_creation) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call addPos(?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_PosDataTable = DataAccessManager::getInstance()->saveData(array($pos_name, $cafeteria_id, $status_id, $user_creation));
            if (!Helper::is_empty_array($this->_PosDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_PosDataTable;
    }

    public function editPos($pos_id, $pos_name, $cafeteria_id, $status_id, $user_modification) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call editPos(?,?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_PosDataTable = DataAccessManager::getInstance()->saveData(array($pos_id, $pos_name, $cafeteria_id, $status_id, $user_modification));
            if (!Helper::is_empty_array($this->_PosDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_PosDataTable;
    }

    public function deletePos($pos_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call DeletePos(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_PosDataTable = DataAccessManager::getInstance()->saveData(array($pos_id));
            if (!Helper::is_empty_array($this->_PosDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_PosDataTable;
    }

}

