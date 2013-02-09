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
    public function getMiniReportsByUser($user_id, $from_date, $to_date) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetMiniReportsByUser(?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_ReportsDataTable = DataAccessManager::getInstance()->fillData(array($user_id, $from_date, $to_date));
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

    public function getCafeteriaBalanceByID($cafeteria_id, $from_date, $to_date, $status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetCafeteriaBalanceByID(?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_ReportsDataTable = DataAccessManager::getInstance()->fillData(array($cafeteria_id, $from_date, $to_date, $status));
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

     public function getCafeteriaBalance($from_date, $to_date, $status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetCafeteriaBalance(?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_ReportsDataTable = DataAccessManager::getInstance()->fillData(array($from_date, $to_date, $status));
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
    
    public function getUsersPurchases($from_date, $to_date) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetUsersPurchases(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_ReportsDataTable = DataAccessManager::getInstance()->fillData(array($from_date, $to_date));
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

    public function getPurchasesInventory($from_date, $to_date) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetPurchasesInventory(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_ReportsDataTable = DataAccessManager::getInstance()->fillData(array($from_date, $to_date));
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

    public function getEventListing($from_date, $to_date) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetEventListing(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_ReportsDataTable = DataAccessManager::getInstance()->fillData(array($from_date, $to_date));
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

    public function getEventDetailed($event_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetEventDetailed(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_ReportsDataTable = DataAccessManager::getInstance()->fillData(array($event_id));
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
    
    public function getEventItemsDetailed($event_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetEventItemsDetailed(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_ReportsDataTable = DataAccessManager::getInstance()->fillData(array($event_id));
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
    
    public function getMenuReports($status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetMenuReports(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_ReportsDataTable = DataAccessManager::getInstance()->fillData(array($status));
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