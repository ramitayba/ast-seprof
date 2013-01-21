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
            if (Helper::is_empty_array($this->_EventItemsDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
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
            if (Helper::is_empty_array($this->_EventItemsDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_EventItemsDataTable;
    }

    public function getEventItemByItemID($event_id,$itemid) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetEventItemByItemID(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_EventItemsDataTable = DataAccessManager::getInstance()->fillData(array($eventid));
            if (Helper::is_empty_array($this->_EventItemsDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
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
            if (Helper::is_empty_array($this->_EventItemsDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_EventItemsDataTable;
    }

    public function addEventItem($event_id, $item_id, $item_price, $item_quantity, $user_creation) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call AddEventItem(?,?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_EventItemsDataTable = DataAccessManager::getInstance()->saveData(array($event_id, $item_id, $item_price, $item_quantity, $user_creation));
            if (!Helper::is_empty_array($this->_EventItemsDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_EventItemsDataTable;
    }

    public function editEventItem($event_item_id, $event_id, $item_id, $item_price, $item_quantity, $user_modification) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call editEventItem(?,?,?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_EventItemsDataTable = DataAccessManager::getInstance()->saveData(array($event_item_id, $event_id, $item_id, $item_price, $item_quantity, $user_modification));
            if (!Helper::is_empty_array($this->_EventItemsDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_EventItemsDataTable;
    }

    public function deleteEventItem($event_item_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call DeleteEventItem(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_EventItemsDataTable = DataAccessManager::getInstance()->saveData(array($event_item_id));
            if (!Helper::is_empty_array($this->_EventItemsDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_EventItemsDataTable;
    }

}

