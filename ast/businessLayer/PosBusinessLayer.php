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

    public function getPos($status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetPos(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_PosDataTable = DataAccessManager::getInstance()->fillData(array($status));
           $this->_Success =DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success=false;
        }
        return $this->_PosDataTable;
    }

    public function getPosByName($name,$status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetPosByName(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_PosDataTable = DataAccessManager::getInstance()->fillData(array($name,$status));
            $this->_Success =DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success=false;
        }
        return $this->_PosDataTable;
    }

    public function getPosByID($id,$status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetPosByID(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_PosDataTable = DataAccessManager::getInstance()->fillData(array($id,$status));
            $this->_Success =DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success=false;
        }
        return $this->_PosDataTable;
    }

    public function getPosByCafeteriaID($id,$status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetPosByCafeteriaID(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_PosDataTable = DataAccessManager::getInstance()->fillData(array($id,$status));
            $this->_Success =DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success=false;
        }
        return $this->_PosDataTable;
    }
    
    public function addPos($pos_name, $cafeteria_id, $status_id, $user_creation) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call addPos(?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($pos_name, $cafeteria_id, $status_id, $user_creation));
           if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_Success;
    }
    
    public function editPos($pos_id, $pos_name, $cafeteria_id, $status_id, $user_modification) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call editPos(?,?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($pos_id, $pos_name, $cafeteria_id, $status_id, $user_modification));
           if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_Success;
    }


    public function deletePos($pos_id,$status,$user_modification_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call DeletePos(?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($pos_id,$status,$user_modification_id));
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

