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
        $content = Helper::fill_datatable('events', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $eventDataTable, array('Event Name', 'Event Date', 'Event invitees Number', 'Department Name', 'Employee Name', 'Status'), array('event_name', 'event_date', 'event_invitees_nb', 'department_name', 'employee_name', 'status_name'), 'event_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                    1 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete'),
                    2 => array('name' => 'Items', 'link' => 'items-', 'class' => 'items')));
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
            print json_encode($content);
            return;
        endif;
        unset($_SESSION['messages']);
    else:
        $div = Helper::set_message('<li>error Connection</li>', 'error');
        $_SESSION['messages'] = $div;
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
            print json_encode($div);
            return;
        endif;
    endif;
elseif ($action == 'add'):
    $content = Helper::fill_datatable('items', array(0 => array('name' => 'Add New Record', 'link' => 'add-', 'class' => 'add'),
                1 => array('name' => 'Edit', 'link' => 'edit-table-', 'class' => 'edit-table')), array(), array('Item Event ID', 'Item Name', 'Item Quantity'), array('event_item_id', 'item_name', 'item_quantity'), 'event_id', array(0 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete')), true, 0);
    include_once POS_ROOT . '/content/events/eventsform.php';
elseif ($action == 'edit'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $eventDataTable = $eventBusinessLayer->getEventByID($query_id);
        if (count($eventDataTable) == 0):
            print json_encode(array('status' => 'error', 'message' => 'Event doesn t  exist '));
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
        $content = Helper::fill_datatable('items', array(0 => array('name' => 'Add New Record', 'link' => 'add-', 'class' => 'add'),
                    1 => array('name' => 'Edit', 'link' => 'edit-table-', 'class' => 'edit-table')), $eventItemDataTable, array('Item Event ID', 'Item Name', 'Item Quantity'), array('event_item_id', 'item_name', 'item_quantity'), 'event_id', array(0 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete')), true, 0);
        include_once POS_ROOT . '/content/events/eventsform.php';
    endif;
elseif ($action == 'save'):
    $name = isset($data['event_name']) ? $data['event_name'] : '';
    $event_date = isset($data['event_date']) ? $data['event_date'] : '';
    $event_invitees_nb = isset($data['event_invitees_nb']) ? $data['event_invitees_nb'] : '';
    $department_id = isset($data['department']) ? $data['department'] : '';
    $employee_id = isset($data['employee']) ? $data['employee'] : '';
    $xml = new SimpleXMLElement('<items_event></items_event>');
    Helper::array_to_xml($datatable, $xml);
    $xml = $xml->asXML();
    $array = array('Event Name' => $name, 'Event Date' => $event_date,
        'Invitess Number' => $event_invitees_nb, 'Department' => $department_id,
        'Employee Name' => $employee_id);
    print_r($xml);
    $message = Helper::is_list_empty($array);
    if (!Helper::is_empty_string($message)):
        print json_encode(array('status' => 'error', 'message' => $message));
        return;
    endif;
    $date = DateTime::createFromFormat('m-d-y', $event_date);
    $eventDataTable = $eventBusinessLayer->getEventByName($name);
    if (Helper::is_empty_string($query_id)):
        if (count($eventDataTable) > 0):
            print json_encode(array('status' => 'error', 'message' => 'Event name already exist'));
            return;
        endif;
        $success = $eventBusinessLayer->addEvent($name, $date, $event_invitees_nb, $department_id, $employee_id, $xml, $_SESSION['user_pos']);
    else:
        if (!is_numeric($query_id)):
            print json_encode(array('status' => 'error', 'message' => 'Event doesn t  exist'));
            return;
        elseif (count($eventDataTable) == 0):
            $eventDataTable = $eventBusinessLayer->getEventByID($query_id);
            if (count($eventDataTable) == 0):
                print json_encode(array('status' => 'error', 'message' => 'Event doesn t  exist '));
                return;
            endif;
        else:
            if ($eventDataTable [0]['event_id'] != $query_id):
                print json_encode(array('status' => 'error', 'message' => 'Can t be save'));
                return;
            endif;
        endif;
        $success = $eventBusinessLayer->editEvent($query_id, $name, $event_date, $event_invitees_nb, $department_id, $employee_id, $xml, $_SESSION['user_pos']);
    endif;
    if ($success):
        $eventDataTable = $eventBusinessLayer->getEvents();
        if ($eventBusinessLayer->getSuccess()):
            $content = Helper::fill_datatable('events', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $eventDataTable, array('Event Name', 'Event Date', 'Event invitees Number', 'Department Name', 'Employee Name', 'Status'), array('event_name', 'event_date', 'event_invitees_nb', 'department_name', 'employee_name', 'status_name'), 'event_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                        1 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete'),
                        2 => array('name' => 'Items', 'link' => 'items-', 'class' => 'items')));
        endif;
        $container = Helper::set_message('Event saved succesfuly', 'status') . $content;
        print json_encode($container);
    else:
        print json_encode(array('status' => 'error', 'message' => 'Event not saved '));
    endif;
elseif ($action == 'delete'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $eventDataTable = $eventBusinessLayer->getEventByID($query_id);
        if (count($eventDataTable) == 0):
            print json_encode(array('status' => 'error', 'message' => 'Event doesn t  exist '));
            return;
        endif;
        $success = $eventBusinessLayer->deleteEvent($query_id);
        if ($success):
            $container = Helper::set_message('Event ' . $eventDataTable [0]['event_name'] . ' delete succesfuly', 'status');
            print json_encode($container);
        else:
            print json_encode(array('status' => 'error', 'message' => 'Event not deleted '));
        endif;
    endif;
endif;
?>
