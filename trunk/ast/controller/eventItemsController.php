<?php

/**
 * This is the Events
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 *
 */

include_once POS_ROOT . '/businessLayer/EventItemBusinessLayer.php';
include_once POS_ROOT . '/businessLayer/ItemBusinessLayer.php';
$eventItemBusinessLayer = new EventItemBusinessLayer();
if ($action == 'index'):
    if ((!Helper::is_empty_string($query_id) && is_numeric($query_id))||isset($_SESSION['event_id'])):
        $_SESSION['event_id'] = !Helper::is_empty_string($query_id)?$query_id:$_SESSION['event_id'];
        $eventItemDataTable = $eventItemBusinessLayer->getEventItemsByEventID($_SESSION['event_id']);
        if ($eventItemBusinessLayer->getSuccess()):
            $content = Helper::fill_datatable('eventitems', $eventItemDataTable, array('Item Name', 'Item Price', 'Item Quantity'), array('item_name', 'item_price', 'item_quantity'), 'event_item_id');
            print json_encode($content);
            unset($_SESSION['messages']);
        else:
            $div = Helper::set_message('<li>error Connection</li>', 'error');
            $_SESSION['messages'] = $div;
            print json_encode($div);
            return;
        endif;
    endif;
elseif ($action == 'add'):
    include_once POS_ROOT . '/content/events/eventitemsform.php';
elseif ($action == 'edit'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $eventItemDataTable = $eventItemBusinessLayer->getEventItemByID($query_id);
        if (count($eventItemDataTable) == 0):
            print json_encode(array('status' => 'error', 'message' => 'Event item doesn t  exist '));
            return;
        endif;
        $forms = array('event_item_id' => $eventItemDataTable [0]['event_item_id']
            , 'event_id' => $eventItemDataTable [0]['event_id']
            , 'item_id' => $eventItemDataTable [0]['item_id']
            , 'item_quantity' => $eventItemDataTable [0]['item_quantity']);
        include_once POS_ROOT . '/content/events/eventitemsform.php';
    endif;
elseif ($action == 'save'):
    $event_id = $_SESSION['event_id']; //isset($data['$event_id']) ? $data['$event_id'] : '';
    $item_id = isset($data['item']) ? $data['item'] : '';
    $item_quantity = isset($data['item_quantity']) ? $data['item_quantity'] : '';
    $array = array('Item Name' => $item_id, 'Item Quantity' => $item_quantity);
    $message = Helper::is_list_empty($array);
    if (!Helper::is_empty_string($message)):
        print json_encode(array('status' => 'error', 'message' => $message));
        return;
    endif;
    $eventItemDataTable = $eventItemBusinessLayer->getEventItemByItemID($event_id, $item_id);
    if (Helper::is_empty_string($query_id)):
        if (count($eventItemDataTable) > 0):
            print json_encode(array('status' => 'error', 'message' => 'Item name already exist into Event'));
            return;
        endif;
        $success = $eventItemBusinessLayer->addEventItem($event_id, $item_id, $item_quantity, $_SESSION['user_pos']);
    else:
        if (!is_numeric($query_id)):
            print json_encode(array('status' => 'error', 'message' => 'Event doesn t  exist'));
            return;
        elseif (count($eventItemDataTable) == 0):
            $eventItemDataTable = $eventItemBusinessLayer->getEventItemByID($query_id);
            if (count($eventItemDataTable) == 0):
                print json_encode(array('status' => 'error', 'message' => 'Event Item doesn t  exist '));
                return;
            endif;
        else:
            if ($eventItemDataTable [0]['event_item_id'] != $query_id):
                print json_encode(array('status' => 'error', 'message' => 'Can t be save'));
                return;
            endif;
        endif;
        $success = $eventItemBusinessLayer->editEventItem($query_id, $event_id, $item_id, $item_quantity, $_SESSION['user_pos']);
    endif;
    if ($success):
        $eventItemDataTable = $eventItemBusinessLayer->getEventItemsByEventID($event_id);
        if ($eventItemBusinessLayer->getSuccess()):
            $content = Helper::fill_datatable('eventitems', $eventItemDataTable, array('Item Name', 'Item Price', 'Item Quantity'), array('item_name', 'item_price', 'item_quantity'), 'event_item_id');
        endif;
        $container = Helper::set_message('Event Item saved succesfuly', 'status') . $content;
        print json_encode($container);
    else:
        print json_encode(array('status' => 'error', 'message' => 'Event Item not saved '));
    endif;
elseif ($action == 'delete'):
    if (!Helper::is_empty_string($query_id)):
        $eventItemDataTable = $eventItemBusinessLayer->getEventItemByID($query_id);
        if (count($eventItemDataTable) == 0):
            print json_encode(array('status' => 'error', 'message' => 'Event Item doesn t  exist '));
            return;
        endif;
        $success = $eventItemBusinessLayer->deleteEventItem($query_id);
        if ($success):
            $container = Helper::set_message('Event Item delete succesfuly', 'status');
            print json_encode($container);
        else:
            print json_encode(array('status' => 'error', 'message' => 'Event Item not deleted '));
        endif;
    endif;
endif;
?>
