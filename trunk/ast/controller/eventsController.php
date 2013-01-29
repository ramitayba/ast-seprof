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
if ($action == 'index' || $action == 'events'):
    $eventDataTable = $eventBusinessLayer->getEvents();
    if ($eventBusinessLayer->getSuccess()):
        $content = Helper::fill_datatable('events', 'events', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $eventDataTable, array('Event Name', 'Event Date', 'Event invitees Number', 'Department Name', 'Employee Name', 'Status'), array('event_name', 'event_date', 'event_invitees_nb', 'department_name', 'employee_name', 'status_name'), 'event_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                    1 => array('name' => 'Approved', 'link' => 'approved-', 'class' => 'approved'),
                    2 => array('name' => 'Rejected', 'link' => 'rejected-', 'class' => 'rejected'),
                /* 3 => array('name' => 'Items', 'link' => 'items-', 'class' => 'items') */                ));
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
    $content = Helper::fill_datatable('items', 'items', array(), array(), array('Item ID', 'Item Name', 'Item Quantity'), array('item_id', 'item_name', 'item_quantity'), 'event_id', array(0 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete')), true, 0, 'items', 'item_quantity');
    include_once POS_ROOT . '/content/events/eventsform.php';
elseif ($action == 'edit'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $eventDataTable = $eventBusinessLayer->getEventByID($query_id);
        if (count($eventDataTable) == 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Event doesn t  exist '));
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
        $content = Helper::fill_datatable('items', 'items', array(), $eventItemDataTable, array('Item ID', 'Item Name', 'Item Quantity'), array('item_id', 'item_name', 'item_quantity'), 'event_id', array(0 => array('name' => 'Delete', 'link' => 'delete-table', 'class' => 'delete')), true, 0, 'items', 'item_quantity');
        include_once POS_ROOT . '/content/events/eventsform.php';
    else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('Events not exist', 'error')));
    endif;
elseif ($action == 'save'):
    $name = isset($data['event_name']) ? $data['event_name'] : '';
    $event_date = isset($data['event_date']) ? $data['event_date'] : '';
    $event_invitees_nb = isset($data['event_invitees_nb']) ? $data['event_invitees_nb'] : '';
    $department_id = isset($data['department']) ? $data['department'] : '';
    $employee_id = isset($data['employee']) ? $data['employee'] : '';
    $xml = new SimpleXMLElement('<items_event></items_event>');
    $datatable = !Helper::is_empty_array($datatable) ? $datatable : array();
    Helper::array_to_xml($datatable, $xml);
    $xml = $xml->asXML();
    $array = array('Event Name' => array('content' => $name, 'type' => 'string', 'length' => '50'),
        'Event Date' => array('content' => $event_date, 'type' => 'date', 'length' => '17'),
        'Invitess Number' => array('content' => $event_invitees_nb, 'type' => 'decimal'), 'Department' => array('content' => $department_id, 'type' => 'int'),
        'Employee Name' => array('content' => $employee_id, 'type' => 'int'));
    $message = Helper::is_list_empty($array);
    if (!Helper::is_empty_string($message)):
        print Helper::json_encode_array(array('status' => 'error', 'message' => $message));
        return;
    endif;
    $eventDataTable = $eventBusinessLayer->getEventByName($name);
    if (Helper::is_empty_string($query_id)):
        if (count($eventDataTable) > 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Event name already exist'));
            return;
        endif;
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
            if ($eventDataTable [0]['event_id'] != $query_id):
                print Helper::json_encode_array(array('status' => 'error', 'message' => 'Can t be save'));
                return;
            endif;
        endif;
        $success = $eventBusinessLayer->editEvent($query_id, $name, $event_date, $event_invitees_nb, $department_id, $employee_id, $xml, $_SESSION['user_pos']);
    endif;
    if ($success):
        $eventDataTable = $eventBusinessLayer->getEvents();
        if ($eventBusinessLayer->getSuccess()):
            $content = Helper::fill_datatable('events', 'events', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $eventDataTable, array('Event Name', 'Event Date', 'Event invitees Number', 'Department Name', 'Employee Name', 'Status'), array('event_name', 'event_date', 'event_invitees_nb', 'department_name', 'employee_name', 'status_name'), 'event_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                        1 => array('name' => 'Approved', 'link' => 'approved-', 'class' => 'approved'),
                        2 => array('name' => 'Rejected', 'link' => 'rejected-', 'class' => 'rejected')
                    /* 3 => array('name' => 'Items', 'link' => 'items-', 'class' => 'items') */                    ));
        endif;
        $container = Helper::set_message('Event saved succesfuly', 'status') . $content;
        print $container;
    else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => 'Event not saved '));
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
            print Helper::json_encode_array(array('status' => 'success', 'message' => $container));
        else:
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Event not saved '));
        endif;
    else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('Events not exist', 'error')));
    endif;
endif;
?>
