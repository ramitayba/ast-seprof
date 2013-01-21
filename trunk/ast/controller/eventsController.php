<?php

/**
 * This is the Events
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 *
 */
include_once POS_ROOT . '/businessLayer/EventBusinessLayer.php';
$eventBusinessLayer = new EventBusinessLayer();

if ($action == 'index' || $action == 'events'):
    $eventDataTable = $eventBusinessLayer->getEvents();
    if ($eventBusinessLayer->getSuccess()):
        $content = Helper::fill_datatable('events', $eventDataTable, array('Event Name', 'Event Date', 'Event invitees Number', 'Department Name', 'Employee Name', 'Status'), array('event_name', 'event_date', 'event_invitees_nb', 'department_name', 'employee_name', 'status_name'), 'event_id', array('items'));
        //print_r($content);
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
    include_once POS_ROOT . '/content/events/eventsform.php';
elseif ($action == 'edit'):
    if (!Helper::is_empty_string($query_id)):
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
            , 'employee_id' => $eventDataTable [0]['employee_id']
            , 'status_id' => $eventDataTable [0]['status_id']);
        include_once POS_ROOT . '/content/events/eventsform.php';
    endif;
elseif ($action == 'save'):
    $name = isset($data['event_name']) ? $data['event_name'] : '';
    $event_date = isset($data['event_date']) ? $data['event_date'] : '';
    $event_invitees_nb = isset($data['event_invitees_nb']) ? $data['event_invitees_nb'] : '';
    $department_id = isset($data['department']) ? $data['department'] : '';
    $employee_id = isset($data['employee']) ? $data['employee'] : '';
    $status = isset($data['status']) ? $data['status'] : '';
    $forms = array('event_id' => $query_id, 'event_name' => $name,
        'event_date' => $event_date, 'event_invitees_nb' => $event_invitees_nb,
        'department_id' => $department_id, 'employee_id' => $employee_id, 'status_id' => $status);
    $array = array('Evnent Name' => $name, 'Event Date' => $event_date,
        'Invitess Number' => $event_invitees_nb, 'Department' => $department_id,
        'Employee Name' => $employee_id, 'Status' => $status);
    $message = Helper::is_list_empty($array);
    //print_r($forms);die();
    if (!Helper::is_empty_string($message)):
        /* ob_start();
          include
          POS_ROOT . '/content/Items/Itemsform.php';
          $html = ob_get_contents();
          ob_end_clean();
          print json_encode($html); */
        print json_encode(array('status' => 'error', 'message' => $message));
        return;
    endif;
    $eventDataTable = $eventBusinessLayer->getEventByName($name);
    if (Helper::is_empty_string($query_id)):
        if (count($eventDataTable) > 0):
            print json_encode(array('status' => 'error', 'message' => 'Event name already exist'));
            return;
        endif;
        $eventDataTable = $eventBusinessLayer->addEvent($name, $event_date, $event_invitees_nb, $department_id, $employee_id, $status, $_SESSION['user_pos']);
    else:
        if (count($eventDataTable) == 0):
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
        $eventDataTable = $eventBusinessLayer->editEvent($query_id, $name, $event_date, $event_invitees_nb, $department_id, $employee_id, $status, $_SESSION['user_pos']);
    endif;
    if (count($eventDataTable) > 0):
        $eventDataTable = $eventBusinessLayer->getEvents();
        if ($eventBusinessLayer->getSuccess()):
            $content = Helper::fill_datatable('events', $eventDataTable, array('Event Name', 'Event Date', 'Event invitees Number', 'Department Name', 'Employee Name', 'Status'), array('event_name', 'event_date', 'event_invitees_nb', 'department_name', 'employee_name', 'status_name'), 'event_id', array('items'));
        endif;
        $container = Helper::set_message('Event saved succesfuly', 'status') . $content;
        print json_encode($container);
    else:
        print json_encode(array('status' => 'error', 'message' => 'Event not saved '));
    endif;
elseif ($action == 'delete'):
    if (!Helper::is_empty_string($query_id)):
        $eventDataTable = $eventBusinessLayer->getEventByID($query_id);
        if (count($eventDataTable) == 0):
            print json_encode(array('status' => 'error', 'message' => 'Event doesn t  exist '));
            return;
        endif;
        $eventDataTable = $eventBusinessLayer->deleteEvent($query_id);
        if (count($eventDataTable) > 0):
            $container = Helper::set_message('Event ' . $eventDataTable [0]['event_name'] . ' delete succesfuly', 'status');
            print json_encode($container);
        else:
            print json_encode(array('status' => 'error', 'message' => 'Event not deleted '));
        endif;
    endif;
endif;
?>
