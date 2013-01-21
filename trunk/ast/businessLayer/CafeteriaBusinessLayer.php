<?php

/**
 * This is the CafeteriaBusinessLayer
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
class CafeteriaBusinessLayer {

    private $_LastError;
    private $_CafeteriasDataTable;
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

    public function getCafeterias() {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getCafeterias}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_CafeteriasDataTable = DataAccessManager::getInstance()->fillData();
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_CafeteriasDataTable;
    }

    public function getCafeteriaByName($name) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getCafeteriaByName(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_CafeteriasDataTable = DataAccessManager::getInstance()->fillData(array($name));
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_CafeteriasDataTable;
    }

    public function getCafeteriaByID($id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getCafeteriaByID(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_CafeteriasDataTable = DataAccessManager::getInstance()->fillData(array($id));
           $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_CafeteriasDataTable;
    }

    public function addCafeteria($cafeteria_name, $user_creation) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call addCafeteria(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($cafeteria_name, $user_creation));
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_Success;
    }

    public function editCafeteria($cafeteria_id, $cafeteria_name, $user_modification) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call editCafeteria(?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($cafeteria_id, $cafeteria_name, $user_modification));
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_Success;
    }

    public function deleteCafeteria($cafeteria_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call deleteCafeteria(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($cafeteria_id));
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_Success;
    }

}

