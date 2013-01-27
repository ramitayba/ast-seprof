<?php

/**
 * This is the AllowanceBusinessLayer
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
class AllowanceBusinessLayer {

    private $_LastError;
    private $_AllowancesDataTable;
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

    public function getAllowances() {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getAllowances}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_AllowancesDataTable = DataAccessManager::getInstance()->fillData();
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_AllowancesDataTable;
    }

    public function addAllowance($xml,$user_modification) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call AddAllowance(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($xml, $user_modification));
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

