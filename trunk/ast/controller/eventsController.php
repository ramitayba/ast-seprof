<?php

/**
 * This is the Events
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 *
 */
include_once POS_ROOT . '/businessLayer/EventBusinessLayer.php';
include_once POS_ROOT . '/businessLayer/EventItemBusinessLayer.php';
include_once POS_ROOT . '/businessLayer/ItemBusinessLayer.php';
include_once POS_ROOT . '/businessLayer/CategoryBusinessLayer.php';
unset($_SESSION['event_id']);
$eventBusinessLayer = new EventBusinessLayer();
$title = 'Events';
if ($action == 'index' || $action == 'events'):
    $eventDataTable = $eventBusinessLayer->getEvents();
    if ($eventBusinessLayer->getSuccess()):
        $content = Helper::fill_datatable_event('events', 'events', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $eventDataTable, array('Event Name', 'Event Date', 'Event invitees Number', 'Department Name', 'Employee Name', 'Status'), array('event_name', 'event_date', 'event_invitees_nb', 'department_name', 'employee_name', 'status_name'), 'event_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                    1 => array('name' => 'Approved', 'link' => 'approved-', 'class' => 'approved'),
                    2 => array('name' => 'Rejected', 'link' => 'rejected-', 'class' => 'rejected')));
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
            print $content;
            return;
        endif;
        unset($_SESSION['messages']);
    else:
        $div = Helper::set_message('<li>error Connection</li>', 'error');
        $_SESSION['messages'] = $div;
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
            print $div;
        endif;
    endif;
elseif ($action == 'add'):
    $content = Helper::fill_datatable('items', 'items', array(), array(), array('Item ID', 'Item Name', 'Item Quantity'), array('item_id', 'item_name', 'item_quantity'), 'event_id', array(0 => array('name' => 'Delete', 'link' => 'delete-table', 'class' => 'delete')), true, 0
                    , 'items', 'item_quantity', '', '', 'rt','200');
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
        include_once POS_ROOT . '/content/events/add.php';
    endif;
elseif ($action == 'edit'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $eventDataTable = $eventBusinessLayer->getEventByID($query_id);
        if (count($eventDataTable) == 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('Event not exist', 'error')));
            return;
        endif;
        $forms = array('event_id' => $eventDataTable [0]['event_id']
            , 'event_name' => $eventDataTable [0]['event_name']
            , 'event_date' => $eventDataTable [0]['event_date']
            , 'event_invitees_nb' => $eventDataTable [0]['event_invitees_nb']
            , 'department_id' => $eventDataTable [0]['department_id']
            , 'employee_id' => $eventDataTable [0]['employee_id']);
        $eventItemBusinessLayer = new EventItemBusinessLayer();
        $eventItemDataTable = $eventItemBusinessLayer->getEventItemsByEventID($eventDataTable [0]['event_id']);
        $content = Helper::fill_datatable('items', 'items', array(), $eventItemDataTable, array('Item ID', 'Item Name', 'Item Quantity'), array('item_id', 'item_name', 'item_quantity'), 'event_id', array(0 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete-table')), true, 0, 'items', 'item_quantity', '', '', 'rt','200');
        include_once POS_ROOT . '/content/events/add.php';
    else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('Event not exist', 'error')));
    endif;
elseif ($action == 'save'):
    $name = isset($data['event_name']) ? $data['event_name'] : '';
    $event_date = isset($data['event_date']) ? $data['event_date'] : '';
    $event_invitees_nb = isset($data['event_invitees_nb']) ? $data['event_invitees_nb'] : '';
    $department_id = isset($data['department']) ? $data['department'] : '';
    $employee_id = isset($data['employee']) ? $data['employee'] : '';
    $xml = '';
    if (!Helper::is_empty_array($datatable)):
        $xml = new SimpleXMLElement('<root></root>');
        $xml = Helper::array_to_xml($datatable, $xml);
    endif;
    $array = array('Event Name' => array('content' => $name, 'type' => 'string', 'length' => '50'),
        'Event Date' => array('content' => $event_date, 'type' => 'date', 'length' => '17'),
        'Invitees Number' => array('content' => $event_invitees_nb, 'type' => 'decimal'), 'Department' => array('content' => $department_id, 'type' => 'int'),
        'Employee Name' => array('content' => $employee_id, 'type' => 'int'));
    $message = Helper::is_list_empty($array);
    if (!Helper::is_empty_string($message)):
        print Helper::json_encode_array(array('status' => 'error', 'message' => $message));
        return;
    endif;
    $event_date=str_replace("+", " ", $event_date);
    $eventDataTable = $eventBusinessLayer->getEventByName($name);
    if (Helper::is_empty_string($query_id)):
        if (count($eventDataTable) > 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Event name already exist'));
            return;
        endif;
        $op = 'insert';
        $success = $eventBusinessLayer->addEvent($name, $event_date, $event_invitees_nb, $department_id, $employee_id, $xml, UNDER_PROCESSING, $_SESSION['user_pos']);
    else:
        if (!is_numeric($query_id)):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Event doesn t  exist'));
            return;
        elseif (count($eventDataTable) == 0):
            $eventDataTable = $eventBusinessLayer->getEventByID($query_id);
            if (count($eventDataTable) == 0):
                print Helper::json_encode_array(array('status' => 'error', 'message' => 'Event doesn t  exist '));
                return;
            endif;
        else:
            if ($eventDataTable[0]['event_name'] == $name && $eventDataTable[0]['event_id'] != $query_id):
                print Helper::json_encode_array(array('status' => 'error', 'message' => 'Event name already exist'));
                return;
            elseif ($eventDataTable [0]['event_id'] != $query_id):
                print Helper::json_encode_array(array('status' => 'error', 'message' => 'Can t be save'));
                return;
            endif;
        endif;
        $op = 'update';
        $success = $eventBusinessLayer->editEvent($query_id, $name, $event_date, $event_invitees_nb, $department_id, $employee_id, $xml, $_SESSION['user_pos']);
    endif;
    if ($success):
        /*if ($op == 'update'):
            $eventDataTable = $eventBusinessLayer->getEvents();
            if ($eventBusinessLayer->getSuccess()):
                $content = Helper::fill_datatable_event('events', 'events', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $eventDataTable, array('Event Name', 'Event Date', 'Event invitees Number', 'Department Name', 'Employee Name', 'Status'), array('event_name', 'event_date', 'event_invitees_nb', 'department_name', 'employee_name', 'status_name'), 'event_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                            1 => array('name' => 'Approved', 'link' => 'approved-', 'class' => 'approved'),
                            2 => array('name' => 'Rejected', 'link' => 'rejected-', 'class' => 'rejected')));
            endif;
            $container = Helper::set_message('Event saved successfully', 'status') . $content;*/
        //else:
            $eventDataTable = $eventBusinessLayer->getLastEvent();
            $event_id = '';
            $event_name = '';
            $date = '';
            $event_invitees = '';
            $employee_name = '';
            $department_name = '';
            if ($eventBusinessLayer->getSuccess()):
                $event_id = $eventDataTable[0]['event_id'];
                $event_name = $eventDataTable[0]['event_name'];
                $date = $eventDataTable[0]['event_date'];
                $event_invitees = $eventDataTable[0]['event_invitees_nb'];
                $employee_name = $eventDataTable[0]['employee_name'];
                $department_name = $eventDataTable[0]['department_name'];
            endif;
            $eventItemBusinessLayer = new EventItemBusinessLayer();
            $eventItemDataTable = $eventItemBusinessLayer->getEventItemsByEventID($event_id);
            $data_report = array('event_name' => array('Event Name', $event_name),
                'department_name' => array('Department Name', $department_name),
                'employee_name' => array('Employee Name', $employee_name),
                'event_invitees' => array('Event Attendees', $event_invitees),
                'event_date' => array('Date', $date),
                'data_table' => $eventItemDataTable,
                'action'=>'edit-events-'.$event_id);
            //$pathreport = $root . 'reports/event-pdf';
            //$container = Helper::generate_container_pdf($pathreport, '', false);
            $_SESSION['data_report'] = $data_report;
            include POS_ROOT . '/include/template/preview.php';
            return;
       // endif;
        //print $container;
    else:
        print $eventBusinessLayer->getLastError();
        print Helper::json_encode_array(array('status' => 'error', 'message' => 'Event not saved'));
    endif;
elseif ($action == 'approved' || 'rejected'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $eventDataTable = $eventBusinessLayer->getEventByID($query_id);
        if (count($eventDataTable) == 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Event doesn t  exist '));
            return;
        endif;
        $status = $action == 'approved' ? APPROVED : REJECTED;
        $success = $eventBusinessLayer->updateStatusEvent($query_id, $status, $_SESSION['user_pos']);
        if ($success):
            $container = Helper::set_message('Event ' . $eventDataTable [0]['event_name'] . ' ' . $action . ' succesfuly', 'status');
            $eventDataTable = $eventBusinessLayer->getEvents();
            if ($eventBusinessLayer->getSuccess()):
                $content = Helper::fill_datatable_event('events', 'events', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $eventDataTable, array('Event Name', 'Event Date', 'Event invitees Number', 'Department Name', 'Employee Name', 'Status'), array('event_name', 'event_date', 'event_invitees_nb', 'department_name', 'employee_name', 'status_name'), 'event_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                            1 => array('name' => 'Approved', 'link' => 'approved-', 'class' => 'approved'),
                            2 => array('name' => 'Rejected', 'link' => 'rejected-', 'class' => 'rejected')));
            endif;
            $container .= $content;
            print $container;
        else:
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Event not saved '));
        endif;
    else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('Events not exist', 'error')));
    endif;
endif;
?>
