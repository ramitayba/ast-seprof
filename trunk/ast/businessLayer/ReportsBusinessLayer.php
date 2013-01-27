<?php

/**
 * This is the ReportsBusinessLayer
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
class ReportsBusinessLayer {

    private $_LastError;
    private $_ReportsDataTable;
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

    /**
     * get mini report for all purchase by user
     * @param type $user_id
     * @return type 
     */
    public function getMiniReportsByUser($user_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getMiniReportsByUser(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_ReportsDataTable = DataAccessManager::getInstance()->fillData(array($user_id));
            if (Helper::is_empty_array($this->_ReportsDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_ReportsDataTable;
    }

    public function getAllUsersPurchasesByPeriod($min, $max) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getAllUsersPurchasesByPeriod(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_ReportsDataTable = DataAccessManager::getInstance()->fillData(array($min, $max));
            if (Helper::is_empty_array($this->_ReportsDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_ReportsDataTable;
    }

    public function getUserPurchasesByPeriod($uid, $min, $max) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getUserPurchasesByPeriod(?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_ReportsDataTable = DataAccessManager::getInstance()->fillData(array($uid, $min, $max));
            if (Helper::is_empty_array($this->_ReportsDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_ReportsDataTable;
    }

    public function getCafeteriaBalanceByID($cid) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getCafeteriaBalanceByID(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_ReportsDataTable = DataAccessManager::getInstance()->fillData(array($cid));
            if (Helper::is_empty_array($this->_ReportsDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_ReportsDataTable;
    }

    public function getPurchasedItemsByPeriod($min, $max) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getPurchasedItemsByPeriod(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_ReportsDataTable = DataAccessManager::getInstance()->fillData(array($min, $max));
            if (Helper::is_empty_array($this->_ReportsDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_ReportsDataTable;
    }

    public function getEventsByPeriod($min, $max) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getEventsByPeriod(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_ReportsDataTable = DataAccessManager::getInstance()->fillData(array($min, $max));
            if (Helper::is_empty_array($this->_ReportsDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_ReportsDataTable;
    }

    public function getEventDetailByID($eid) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getEventDetailByID(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_ReportsDataTable = DataAccessManager::getInstance()->fillData(array($eid));
            if (Helper::is_empty_array($this->_ReportsDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_ReportsDataTable;
    }
    
    public function getMenuReports() {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getMenuReports}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_ReportsDataTable = DataAccessManager::getInstance()->fillData();
            if (Helper::is_empty_array($this->_ReportsDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_ReportsDataTable;
    }

}