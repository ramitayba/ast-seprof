<?php

/* * ***********************************************************************
 * @file: CafeteriaBusinessLayer.cs
 * @author: Fayssal Obeid
 * @created: 1/8/13
 * @email: fayssal[dot]obeid[at]seprof[dot]com
 * Copyright © SEProf 2013
 * ************************************************************************ */

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

    public function getLastError() {
        return $this->_LastError;
    }

    public function getCafeterias() {
        try {
            $this->_reset();
            $this->_SQLQuery = "exec getCafeterias();";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_CafeteriasDataTable = DataAccessManager::getInstance()->fillData();
            if (Helper::is_empty_array($this->__CafeteriasDataTable)) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_CafeteriasDataTable;
    }

    public function addCafeteria($cafeteria_name, $user_creation) {
        try {
            $this->_reset();
            $this->_SQLQuery = "exec addCafeteria(?,?);";
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
            $this->_SQLQuery = "exec editCafeteria(?,?,?);";
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
            $this->_SQLQuery = "exec deleteCafeteria(?);";
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

