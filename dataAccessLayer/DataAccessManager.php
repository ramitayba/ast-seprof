<?php

/*
 * @file: DataAccessManager.php
 * @author: Fayssal Obeid
 * @created: 4/12/12
 * @email: fayssal[dot]obeid[at]seprof[dot]com
 * Copyright © SEProf 2012
 * 
 */

class DataAccessManager {

    private static $_LastError;
    private static $_SQLQuery;
    private static $_Instance;
    private $_Statment = '';
    private $_Success = false;
    private $_DataTable = array();
    private $_LastID = 0;
    private $_OutputParam = array();

    private function __construct() {
        
    }

    public static function getInstance() {
        if (!self::$_Instance) {
            self::$_Instance = new DataAccessManager();
        }
        return self::$_Instance;
    }

    private function _reset() {
        self::$_LastError = '';
        $this->_Success = false;
    }

    public function getLastError() {
        return self::$_LastError;
    }

    public function setLastError($_LastError) {
        self::$_LastError = $_LastError;
    }

    public function getSQLQuery() {
        return self::$_SQLQuery;
    }

    public function setSQLQuery($_SQLQuery) {
        self::$_SQLQuery = $_SQLQuery;
    }

    public function getLastID() {
        return $this->_LastID;
    }

    public function getOutputParam() {
        return $this->_OutputParam;
    }

    public function fillData() {
        try {
            $this->_reset();
            Connection::getInstance()->openConnection();
            //$this->_Statment = odbc_prepare(Connection::getInstance()->getDB(), self::$_SQLQuery);
            $this->_Statment = odbc_exec(Connection::getInstance()->getDB(), self::$_SQLQuery);
            $this->_DataTable = odbc_result_all($this->_Statment);
            // $this->_DataTable = $this->_Success === true ? odbc_result_all($this->_Statment) : array();
        } catch (Exception $ex) {
            self::$_LastError = $ex->getMessage();
            $this->_DataTable = '';
        }
        Connection::getInstance()->closeConnection();
        return $this->_DataTable;
    }

    public function saveData($array = array()) {
        try {
            $this->_reset();
            Connection::getInstance()->openConnection();
            //$this->_Statment = odbc_prepare(Connection::getInstance()->getDB(), self::$_SQLQuery);
            $this->_Statment = odbc_exec(Connection::getInstance()->getDB(), self::$_SQLQuery);
             $this->_DataTable = odbc_result_all($this->_Statment);
           // $this->_DataTable = $this->_Success === true ? odbc_result_all($this->_Statment) : array();
        } catch (OdbcException $ex) {
            self::$_LastError = $ex->getMessage();
            $this->_DataTable = '';
        }
        Connection::getInstance()->closeConnection();
        return $this->_DataTable;
    }

}

?>
