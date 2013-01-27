<?php

/**
 * This is the Items
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
include_once POS_ROOT . '/businessLayer/ItemBusinessLayer.php';
include_once POS_ROOT . '/businessLayer/CategoryBusinessLayer.php';
$itemBusinessLayer = new ItemBusinessLayer();
if ($action == 'index' || $action == 'items'):
    if ((!Helper::is_empty_string($query_id) && is_numeric($query_id)) || isset($_SESSION['category_id'])):
        $_SESSION['category_id'] = !Helper::is_empty_string($query_id) ? $query_id : $_SESSION['category_id'];
        $itemDataTable = $itemBusinessLayer->GetItemByCategory($_SESSION['category_id']);
    else:
        $itemDataTable = $itemBusinessLayer->getItems();
    endif;
    if ($itemBusinessLayer->getSuccess()):
        $content = Helper::fill_datatable('items', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $itemDataTable, array('Item Name', 'Category Name', 'Item Price', 'Item Description', 'Status'), array('item_name', 'category_name', 'item_price', 'item_description', 'status_name'), 'item_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                    1 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete')));
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
    include_once POS_ROOT . '/content/products/itemsform.php';
elseif ($action == 'edit'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $itemDataTable = $itemBusinessLayer->getItemByID($query_id);
        if (count($itemDataTable) == 0):
            print json_encode(array('status' => 'error', 'message' => 'Item doesn t  exist '));
            return;
        endif;
        $forms = array('item_id' => $itemDataTable [0]['item_id']
            , 'item_name' => $itemDataTable [0]['item_name']
            , 'category_id' => $itemDataTable [0]['category_id']
            , 'item_price' => $itemDataTable [0]['item_price']
            , 'item_photo' => $itemDataTable [0]['item_photo']
            , 'item_description' => $itemDataTable [0]['item_description']
            , 'status_id' => $itemDataTable [0]['status_id']);
        include_once POS_ROOT . '/content/products/itemsform.php';
    endif;
elseif ($action == 'save'):
    $name = isset($data['item_name']) ? $data['item_name'] : '';
    $category_id = isset($data['category']) ? $data['category'] : '';
    $item_price = isset($data['item_price']) ? $data['item_price'] : '';
    $item_photo = isset($data['item_photo']) ? $data['item_photo'] : '';
    $item_description = isset($data['item_description']) ? $data['item_description'] : '';
    $status = isset($data['status']) ? $data['status'] : '';
    $array = array('Item Name' => $name, 'Category' => $category_id,
        'Item Price' => $item_price, 'Item Photo' => $item_photo,
        'Description' => $item_description, 'Status' => $status);
    $message = Helper::is_list_empty($array);
    if (!Helper::is_empty_string($message)):
        print json_encode(array('status' => 'error', 'message' => $message));
        return;
    endif;
    $itemDataTable = $itemBusinessLayer->getItemByName($name);
    if (Helper::is_empty_string($query_id)):
        if (count($itemDataTable) > 0):
            print json_encode(array('status' => 'error', 'message' => 'Item name already exist'));
            return;
        endif;
        $success = $itemBusinessLayer->addItem($name, $category_id, $item_price, $item_photo, $item_description, $status, $_SESSION['user_pos']);
    else:
        if (!is_numeric($query_id)):
            print json_encode(array('status' => 'error', 'message' => 'Item doesn t  exist'));
            return;
        elseif (count($itemDataTable) == 0):
            $itemDataTable = $itemBusinessLayer->getItemByID($query_id);
            if (count($itemDataTable) == 0):
                print json_encode(array('status' => 'error', 'message' => 'Item doesnt exist '));
                return;
            endif;
        else:
            if ($itemDataTable [0]['item_id'] != $query_id):
                print json_encode(array('status' => 'error', 'message' => 'Can t be save'));
                return;
            endif;
        endif;
        $success = $itemBusinessLayer->editItem($query_id, $name, $category_id, $item_price, $item_photo, $item_description, $status, $_SESSION['user_pos']);
    endif;
    if ($success):
        $itemDataTable = $itemBusinessLayer->getItems();
        if ($itemBusinessLayer->getSuccess()):
            $content = Helper::fill_datatable('items', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $itemDataTable, array('Item Name', 'Category Name', 'Item Price', 'Item Description', 'Status'), array('item_name', 'category_name', 'item_price', 'item_description', 'status_name'), 'item_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                        1 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete')));
        endif;
        $container = Helper::set_message('Item saved succesfuly', 'status') . $content;
        print json_encode($container);
    else:
        print json_encode(array('status' => 'error', 'message' => 'item not saved '));
    endif;
elseif ($action == 'delete'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $itemDataTable = $itemBusinessLayer->getItemById($query_id);
        if (count($itemDataTable) == 0):
            print json_encode(array('status' => 'error', 'message' => 'Item doesn t  exist '));
            return;
        endif;
        $success = $itemBusinessLayer->deleteItem($query_id);
        if ($success):
            $container = Helper::set_message('Item ' . $itemDataTable [0]['item_name'] . ' delete succesfuly', 'status');
            print json_encode($container);
        else:
            print json_encode(array('status' => 'error', 'message' => 'Item not deleted '));
        endif;
    endif;
endif;
?>