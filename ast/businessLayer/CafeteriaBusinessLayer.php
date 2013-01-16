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
            if (Helper::is_empty_array($this->_CafeteriasDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
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
            if (Helper::is_empty_array($this->_CafeteriasDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
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
            if (Helper::is_empty_array($this->_CafeteriasDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
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
            $this->_CafeteriasDataTable = DataAccessManager::getInstance()->saveData(array($cafeteria_name, $user_creation));
            if (!Helper::is_empty_array($this->_CafeteriasDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_CafeteriasDataTable;
    }

    public function editCafeteria($cafeteria_id, $cafeteria_name, $user_modification) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call editCafeteria(?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_CafeteriasDataTable = DataAccessManager::getInstance()->saveData(array($cafeteria_id, $cafeteria_name, $user_modification));
            if (!Helper::is_empty_array($this->_CafeteriasDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_CafeteriasDataTable;
    }

    public function deleteCafeteria($cafeteria_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call deleteCafeteria(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_CafeteriasDataTable = DataAccessManager::getInstance()->saveData(array($cafeteria_id));
            if (!Helper::is_empty_array($this->_CafeteriasDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_CafeteriasDataTable;
    }

}

