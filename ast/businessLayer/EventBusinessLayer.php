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
            if (Helper::is_empty_array($this->_EventsDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
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
            if (Helper::is_empty_array($this->_EventsDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
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
            if (Helper::is_empty_array($this->_EventsDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_EventsDataTable;
    }

    public function addEvent($event_name, $event_date, $event_invitees_nb, $department_id, $employee_id, $status_id, $user_creation) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call AddEvent(?,?,?,?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_EventsDataTable = DataAccessManager::getInstance()->saveData(array($event_name, $event_date, $event_invitees_nb, $department_id, $employee_id, $status_id, $user_creation));
            if (!Helper::is_empty_array($this->_EventsDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_EventsDataTable;
    }

    public function editEvent($event_id, $event_name, $event_date, $event_invitees_nb, $department_id, $employee_id, $status_id, $user_modification) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call editEvent(?,?,?,?,?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_EventsDataTable = DataAccessManager::getInstance()->saveData(array($event_id, $event_name, $event_date, $event_invitees_nb, $department_id, $employee_id, $status_id, $user_modification));
            if (!Helper::is_empty_array($this->_EventsDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_EventsDataTable;
    }

    public function deleteEvent($event_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call DeleteEvent(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_EventsDataTable = DataAccessManager::getInstance()->saveData(array($event_id));
            if (!Helper::is_empty_array($this->_EventsDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_EventsDataTable;
    }

}

