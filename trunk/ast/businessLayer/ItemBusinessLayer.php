<?php

/**
 * This is the ItemBusinessLayer
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
class ItemBusinessLayer {

    private $_LastError;
    private $_ItemsDataTable;
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

    public function getItems($status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetItems(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_ItemsDataTable = DataAccessManager::getInstance()->fillData(array($status));
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_ItemsDataTable;
    }

    public function getItemByName($name,$status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetItemByName(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_ItemsDataTable = DataAccessManager::getInstance()->fillData(array($name,$status));
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_ItemsDataTable;
    }

    public function getItemByID($id,$status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetItemByID(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_ItemsDataTable = DataAccessManager::getInstance()->fillData(array($id,$status));
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_ItemsDataTable;
    }

     public function getItemByCategory($id,$status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetItemByCategory(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_ItemsDataTable = DataAccessManager::getInstance()->fillData(array($id,$status));
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_ItemsDataTable;
    }
    
    public function addItem($item_name, $category_id, $item_price, $item_photo, $item_description, $status_id, $user_creation) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call AddItem(?,?,?,?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($item_name, $category_id, $item_price, $item_photo, $item_description, $status_id, $user_creation));
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_Success;
    }

    public function editItem($item_id, $item_name, $category_id, $item_price, $item_photo, $item_description, $status_id, $user_modification) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call EditItem(?,?,?,?,?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($item_id, $item_name, $category_id, $item_price, $item_photo, $item_description, $status_id, $user_modification));
           if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_Success;
    }

    public function deleteItem($item_id,$status,$user_modification_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call DeleteItem(?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($item_id,$status,$user_modification_id));
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

