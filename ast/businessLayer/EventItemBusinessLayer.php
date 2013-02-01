<?php

/**
 * This is the EventItemBusinessLayer
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 *
 */
class EventItemBusinessLayer {

    private $_LastError;
    private $_EventItemsDataTable;
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

    public function getEventItems() {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetEventItems}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_EventItemsDataTable = DataAccessManager::getInstance()->fillData();
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_EventItemsDataTable;
    }

    public function getEventItemsByEventID($eventid) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetEventItemsByEventID(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_EventItemsDataTable = DataAccessManager::getInstance()->fillData(array($eventid));
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_EventItemsDataTable;
    }

    public function getEventItemByItemID($event_id, $itemid) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetEventItemByItemID(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_EventItemsDataTable = DataAccessManager::getInstance()->fillData(array($event_id,$itemid));
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_EventItemsDataTable;
    }

    public function getEventItemByID($id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetEventItemByID(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_EventItemsDataTable = DataAccessManager::getInstance()->fillData(array($id));
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_EventItemsDataTable;
    }

    public function addEventItem($event_id, $item_id, $item_quantity, $user_creation) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call AddEventItem(?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($event_id, $item_id, $item_quantity, $user_creation));
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_Success;
    }

    public function editEventItem($event_item_id, $event_id, $item_id, $item_quantity, $user_modification) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call EditEventItem(?,?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($event_item_id, $event_id, $item_id, $item_quantity, $user_modification));
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_Success;
    }

    public function deleteEventItem($event_item_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call DeleteEventItem(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($event_item_id));
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

