<?php

/*
 * @file: Connection.php
 * @author: Fayssal Obeid
 * @created: 4/12/12
 * @email: fayssal[dot]obeid[at]seprof[dot]com
 * Copyright © SEProf 2012
 * 
 */

class Connection {

    private static $_Instance;
    private $_Hostname;
    private $_Database; //The name of the database
    private $_Username; //The username for the database
    private $_Password; // The password for the database
    private $_Prefix;
    private static $_DB;

    private function __construct() {
        global $databases;
        $this->_Hostname = $databases['host'];
        $this->_Database = $databases['database'];
        $this->_Username = $databases['username'];
        $this->_Password = $databases['password'];
        $this->_Prefix = $databases['prefix'];
    }

    public static function getInstance() {
        if (!self::$_Instance) {
            self::$_Instance = new Connection();
        }
        return self::$_Instance;
    }

    public function openConnection() {
        $conn = "Driver={SQL Server};Server=$this->_Hostname;Database=$this->_Database;";
        self::$_DB = odbc_connect($conn, $this->_Username, $this->_Password);
    }

    public function closeConnection() {
        odbc_close(self::$_DB);
    }

    public function getDB() {
        return self::$_DB;
    }

}

?>
