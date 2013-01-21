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
    $itemDataTable = $itemBusinessLayer->getItems();
    if ($itemBusinessLayer->getSuccess()):
        $content = Helper::fill_datatable('items', $itemDataTable, array('Item Name', 'Category Name', 'Item Price', 'Item Description', 'Status'), array('item_name', 'category_name', 'item_price', 'item_description', 'status_name'), 'item_id');
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
    if (!Helper::is_empty_string($query_id)):
        $itemDataTable = $itemBusinessLayer->getItemByID($query_id);
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
    $forms = array('item_id' => $query_id, 'item_name' => $name,
        'category_id' => $category_id, 'item_price' => $item_price,
        'item_photo' => $item_photo, 'item_description' => $item_description, 'status_id' => $status);
    $array = array('Item Name' => $name, 'Category' => $category_id,
        'Item Price' => $item_price, 'Item Photo' => $item_photo,
        'Description' => $item_description, 'Status' => $status);    
    $message = Helper::is_list_empty($array);
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
    $itemDataTable = $itemBusinessLayer->getItemByName($name);
    if (Helper::is_empty_string($query_id)):
        if (count($itemDataTable) > 0):
            print json_encode(array('status' => 'error', 'message' => 'Item name already exist'));
            return;
        endif;
        $itemDataTable = $itemBusinessLayer->addItem($name, $category_id, $item_price, $item_photo, $item_description, $status, $_SESSION['user_pos']);
    else:
        if (count($itemDataTable) == 0):
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
        $itemDataTable = $itemBusinessLayer->editItem($query_id, $name, $category_id, $item_price, $item_photo, $item_description, $status, $_SESSION['user_pos']);
    endif;
    if (count($itemDataTable) > 0):
        $itemDataTable = $itemBusinessLayer->getItems();
        if ($itemBusinessLayer->getSuccess()):
            $content = Helper::fill_datatable('items', $itemDataTable, array('Item Name', 'Category Name', 'Item Price', 'Item Description', 'Status'), array('item_name', 'category_name', 'item_price', 'item_description', 'status_name'), 'item_id');
        endif;
        $container = Helper::set_message('Item saved succesfuly', 'status');
        print json_encode($container);
    else:
        print json_encode(array('status' => 'error', 'message' => 'item not saved '));
    endif;
elseif ($action == 'delete'):
    if (!Helper::is_empty_string($query_id)):
        $itemDataTable = $itemBusinessLayer->getItemById($query_id);
        if (count($itemDataTable) == 0):
            print json_encode(array('status' => 'error', 'message' => 'Item doesn t  exist '));
            return;
        endif;
        $itemDataTable = $itemBusinessLayer->deleteItem($query_id);
        if (count($itemDataTable) > 0):
            $container = Helper::set_message('Item ' . $itemDataTable [0]['item_name'] . ' delete succesfuly', 'status');
            print json_encode($container);
        else:
            print json_encode(array('status' => 'error', 'message' => 'Item not deleted '));
        endif;
    endif;
endif;
?>