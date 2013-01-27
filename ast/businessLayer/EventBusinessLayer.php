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

    public function getEvents() {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetEvents}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_EventsDataTable = DataAccessManager::getInstance()->fillData();
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

    public function addEvent($event_name, $event_date, $event_invitees_nb, $department_id, $employee_id, $xml, $user_creation) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call AddEvent(?,?,?,?,?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($event_name, $event_date, $event_invitees_nb, $department_id, $employee_id, $xml,UNDER_PROCESSING, $user_creation));
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
            $this->_SQLQuery = "{call editEvent(?,?,?,?,?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($event_id, $event_name, $event_date, $event_invitees_nb, $department_id, $employee_id, $xml ,$user_modification));
           if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_Success;
    }

    public function deleteEvent($event_id,$status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call DeleteEvent(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($event_id,$status));
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

