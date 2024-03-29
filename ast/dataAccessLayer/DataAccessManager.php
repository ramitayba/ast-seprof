<?php

/**
 * This is the DataAccessManager
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
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
        $this->_DataTable = array();
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

    public function getSuccess() {
        return $this->_Success;
    }

    public function getOutputParam() {
        return $this->_OutputParam;
    }

    public function getDataTable() {
        return $this->_DataTable;
    }

    public function fillData($array = array()) {
        try {
            $this->_reset();
            if (Connection::getInstance()->openConnection()) {
                $this->_Statment = odbc_prepare(Connection::getInstance()->getDB(), self::$_SQLQuery);
                $this->_Success = odbc_execute($this->_Statment, $array);
                if (odbc_error()) {
                    self::$_LastError = odbc_errormsg(Connection::getInstance()->getDB());
                    $this->_Success = false;
                }
                $i = 0;
                if ($this->_Success) {
                    while ($row = odbc_fetch_array($this->_Statment)):
                        $this->_DataTable[$i] = $row;
                        $i++;
                    endwhile;
                }
            }
            // $this->_DataTable = $this->_Success === true ? odbc_result_all($this->_Statment) : array();
        } catch (OdbcException $ex) {
            self::$_LastError = $ex->getMessage();
            $this->_Success = false;
            $this->_DataTable = array();
        }
        Connection::getInstance()->closeConnection();
        return $this->_DataTable;
    }

    public function saveData($array = array()) {
        try {
            $this->_reset();
            Connection::getInstance()->openConnection();
            $this->_Statment = odbc_prepare(Connection::getInstance()->getDB(), self::$_SQLQuery);
            $this->_Success = odbc_execute($this->_Statment, $array);
            if (odbc_error()) {
                self::$_LastError = odbc_errormsg(Connection::getInstance()->getDB());
                $this->_Success = false;
            }
        } catch (OdbcException $ex) {
            self::$_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        Connection::getInstance()->closeConnection();
        return $this->_Success;
    }

    public function saveDataWithRetun($array = array()) {
        try {
            $this->_reset();
            Connection::getInstance()->openConnection();
            $this->_Statment = odbc_prepare(Connection::getInstance()->getDB(), self::$_SQLQuery);
            $this->_Success = odbc_execute($this->_Statment, $array);
            if (odbc_error()) {
                self::$_LastError = odbc_errormsg(Connection::getInstance()->getDB());
                $this->_Success = false;
            }
            $i = 0;
            if ($this->_Success) {
                while ($row = odbc_fetch_array($this->_Statment)):
                    $this->_DataTable[$i] = $row;
                    $i++;
                endwhile;
            }
        } catch (OdbcException $ex) {
            self::$_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        Connection::getInstance()->closeConnection();
        return $this->_Success;
    }

}

?>
