<?php

/**
 * This is the Menu
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 *
 */
include_once POS_ROOT . '/businessLayer/EventBusinessLayer.php';
$eventBusinessLayer = new EventBusinessLayer();
if ($action == 'index'):
    $eventDataTable = $eventBusinessLayer->getEvents();
    if ($eventBusinessLayer->getSuccess()):
        $content = Helper::fill_datatable('event', $eventDataTable, array('Event Name','Event Date','Event invitees','Department Name','User Name'), array('event_name','event_date','event_invitees_nb','department_id','event_user_order_id'), 'event_id');
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
    include_once POS_ROOT . '/content/event/eventform.php';
elseif ($action == 'edit'):
    if (!Helper::is_empty_string($query_id)):
        $eventDataTable = $eventBusinessLayer->getEventByID($query_id);
        if (count($eventDataTable) == 0):
            print json_encode(array('status' => 'error', 'message' => 'Event doesn t  exist '));
            return;
        endif;
        $forms = array('event_id' => $eventDataTable [0]['event_id'], 'event_name' => $eventDataTable [0]['event_name']);
        include_once POS_ROOT . '/content/event/eventform.php';
    endif;
elseif ($action == 'save'):
    $name = isset($data['event_name']) ? $data['event_name'] : '';
    $forms = array('event_id' => $query_id, 'event_name' => $name);
    if (Helper::is_empty_string($name)):
        print json_encode(array('status' => 'error', 'message' => 'Event name cant be empty'));
        return;
    endif;
    $eventDataTable = $eventBusinessLayer->getEventByName($name);
    if (Helper::is_empty_string($query_id)):
        if (count($eventDataTable) > 0):
            print json_encode(array('status' => 'error', 'message' => 'Event name already exist'));
            return;
        endif;
        $eventDataTable = $eventBusinessLayer->addEvent($name, $_SESSION['user_pos']);
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
        $eventDataTable = $eventBusinessLayer->editEvent($query_id, $name, $date, $invitees, $department, $user, $_SESSION['user_pos']);
    endif;
    if (count($eventDataTable) > 0):
        $eventDataTable = $eventBusinessLayer->getEvents();
        if ($eventBusinessLayer->getSuccess()):
            $content = Helper::fill_datatable('events', $eventDataTable, array('Event Name','Event Date','Event invitees','Department Name','User Name'), array('event_name','event_name','event_invitees_nb','department_name','user_name'), 'event_id');
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
