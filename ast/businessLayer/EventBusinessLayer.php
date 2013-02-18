<?php

/**
 * This is the EventBusinessLayer
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 *
 */
class EventBusinessLayer {

    private $_LastError;
    private $_EventsDataTable;
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

    public function getEvents($status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetEvents(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_EventsDataTable = DataAccessManager::getInstance()->fillData(array($status));
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_EventsDataTable;
    }

    public function getLastEvent() {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetLastEvent}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_EventsDataTable = DataAccessManager::getInstance()->fillData(array());
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_EventsDataTable;
    }

    public function getEventByName($name) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetEventByName(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_EventsDataTable = DataAccessManager::getInstance()->fillData(array($name));
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_EventsDataTable;
    }

    public function getEventByID($id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetEventByID(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_EventsDataTable = DataAccessManager::getInstance()->fillData(array($id));
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_EventsDataTable;
    }

    public function addEvent($event_name, $event_date, $event_invitees_nb, $department_id, $employee_id, $xml, $status, $user_creation) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call AddEvent(?,?,?,?,?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($event_name, $event_date, $event_invitees_nb, $department_id, $employee_id, $xml, $status, $user_creation));
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_Success;
    }

    public function editEvent($event_id, $event_name, $event_date, $event_invitees_nb, $department_id, $employee_id, $xml, $user_modification) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call EditEvent(?,?,?,?,?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($event_id, $event_name, $event_date, $event_invitees_nb, $department_id, $employee_id, $xml, $user_modification));
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_Success;
    }

    public function updateStatusEvent($event_id, $status, $user_modification) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call UpdateStatusEvent(?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($event_id, $status, $user_modification));
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

