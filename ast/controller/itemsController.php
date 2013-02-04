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
    $itemDataTable = $itemBusinessLayer->getItems(DELETED);
    if ($itemBusinessLayer->getSuccess()):
        $content = Helper::fill_datatable('items', 'items', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $itemDataTable, array('Category Parent Name', 'Sub Category Name', 'Item Name', 'Item Price', 'Item Description', 'Status'), array('category_parent_name', 'category_name', 'item_name', 'item_price', 'item_description', 'status_name'), 'item_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                    1 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete')));
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
    $forms = array('status_id' => ACTIVE);
    include_once POS_ROOT . '/content/products/itemsform.php';
elseif ($action == 'edit'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $itemDataTable = $itemBusinessLayer->getItemByID($query_id, DELETED);
        if (count($itemDataTable) == 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Item doesn t  exist '));
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
    else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('Items not exist', 'error')));
    endif;
elseif ($action == 'save'):
    $name = isset($data['item_name']) ? $data['item_name'] : '';
    $category_id = isset($data['category']) ? $data['category'] : '';
    $item_price = isset($data['item_price']) ? $data['item_price'] : '';
    $item_photo = isset($data['item_photo']) ? $data['item_photo'] : '';
    $item_description = isset($data['item_description']) ? $data['item_description'] : '';
    $status = isset($data['status']) ? $data['status'] : '';
    $array = array('Item Name' => array('content' => $name, 'type' => 'string', 'length' => '100'), 'Item Price' => array('content' => $item_price, 'type' => 'decimal'),
        'Category' => array('content' => $category_id, 'type' => 'int'), 'Status' => array('content' => $status, 'type' => 'int'));
    $message = Helper::is_list_empty($array);
    if (!Helper::is_empty_string($message)):
        print Helper::json_encode_array(array('status' => 'error', 'message' => $message));
        return;
    endif;
    $itemDataTable = $itemBusinessLayer->getItemByName($name, $category_id, DELETED);
    if (Helper::is_empty_string($query_id)):
        if (count($itemDataTable) > 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Item name already exist'));
            return;
        endif;
        $success = $itemBusinessLayer->addItem($name, $category_id, $item_price, $item_photo, $item_description, $status, $_SESSION['user_pos']);
    else:
        if (!is_numeric($query_id)):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Item doesn t  exist'));
            return;
        elseif (count($itemDataTable) == 0):
            $itemDataTable = $itemBusinessLayer->getItemByID($query_id, DELETED);
            if (count($itemDataTable) == 0):
                print Helper::json_encode_array(array('status' => 'error', 'message' => 'Item doesnt exist '));
                return;
            endif;
        else:
            if ($itemDataTable [0]['item_id'] != $query_id):
                print Helper::json_encode_array(array('status' => 'error', 'message' => 'Can t be save'));
                return;
            endif;
        endif;
        $success = $itemBusinessLayer->editItem($query_id, $name, $category_id, $item_price, $item_photo, $item_description, $status, $_SESSION['user_pos']);
    endif;
    if ($success):
        $itemDataTable = $itemBusinessLayer->getItems(DELETED);
        if ($itemBusinessLayer->getSuccess()):
            $content = Helper::fill_datatable('items', 'items', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $itemDataTable, array('Category Parent Name', 'Sub Category Name', 'Item Name', 'Item Price', 'Item Description', 'Status'), array('category_parent_name', 'category_name', 'item_name', 'item_price', 'item_description', 'status_name'), 'item_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                        1 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete')));
        endif;
        $container = Helper::set_message('Item saved succesfuly', 'status') . $content;
        print $container;
    else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => 'item not saved '));
    endif;
elseif ($action == 'delete'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $itemDataTable = $itemBusinessLayer->getItemById($query_id, DELETED);
        if (count($itemDataTable) == 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('Cafeteria not exist', 'error')));
            return;
        endif;
        $success = $itemBusinessLayer->deleteItem($query_id, DELETED, $_SESSION['user_pos']);
        if ($success):
            $container = Helper::set_message('Item ' . $itemDataTable [0]['item_name'] . ' delete succesfuly', 'status');
            print Helper::json_encode_array(array('status' => 'success', 'message' => $container));
        else:
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Item not deleted '));
        endif;
    else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('Items not exist', 'error')));
    endif;
endif;
?>