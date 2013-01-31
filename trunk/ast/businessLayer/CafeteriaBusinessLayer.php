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

    public function getCafeterias($status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetCafeterias(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_CafeteriasDataTable = DataAccessManager::getInstance()->fillData(array($status));
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

    public function getCafeteriaByName($name,$status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetCafeteriaByName(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_CafeteriasDataTable = DataAccessManager::getInstance()->fillData(array($name, $status));
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

    public function getCafeteriaByID($id,$status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetCafeteriaByID(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_CafeteriasDataTable = DataAccessManager::getInstance()->fillData(array($id, $status));
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_Success = false;
            $this->_LastError = $ex->getMessage();
        }
        return $this->_CafeteriasDataTable;
    }

    public function addCafeteria($cafeteria_name,$status, $user_creation) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call AddCafeteria(?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($cafeteria_name, $status, $user_creation));
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
            $this->_SQLQuery = "{call EditCafeteria(?,?,?)}";
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

    public function deleteCafeteria($cafeteria_id,$status,$user_modification_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call DeleteCafeteria(?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($cafeteria_id, $status,$user_modification_id));
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

