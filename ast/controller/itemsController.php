<?php

/**
 * This is the Menu
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
        $content = Helper::fill_datatable('Items', $itemDataTable, array('Item Name', 'Category Name', 'Item Price', 'Item Description'), array('item_name', 'category_name', 'item_price', 'item_description'), 'Item_id');
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
        $forms = array('item_id' => $itemDataTable [0]['Item_id']
            , 'item_name' => $itemDataTable [0]['Item_name']
            , 'category_id' => $itemDataTable [0]['category_id']
            , 'item_price' => $itemDataTable [0]['item_price']
            , 'item_photo' => $itemDataTable [0]['item_photo']
            , 'item_description' => $itemDataTable [0]['item_description']);
         include_once POS_ROOT . '/content/products/itemsform.php';
    endif;
elseif ($action == 'save'):
    $name = isset($_POST['item_name']) ? $_POST['item_name'] : '';
    $category_id = isset($_POST['category_id']) ? $_POST['category_id'] : '';
    $item_price = isset($_POST['item_price']) ? $_POST['item_price'] : '';
    $item_photo = isset($_POST['item_photo']) ? $_POST['item_photo'] : '';
    $item_description = isset($_POST['item_description']) ? $_POST['item_description'] : '';
    $forms = array('item_id' => $query_id, 'item_name' => $name,
        'category_id' => $category_id, 'item_price' => $item_price,
        'item_photo' => $item_photo, 'item_description' => $item_description,);
    if (Helper::is_empty_string($name)):
        /* ob_start();
          include
          POS_ROOT . '/content/Items/Itemsform.php';
          $html = ob_get_contents();
          ob_end_clean();
          print json_encode($html); */
        print json_encode(array('status' => 'error', 'message' => 'Item name cant be empty'));
        return;
    endif;
    $itemDataTable = $itemBusinessLayer->getItemByName($name);
    if (Helper::is_empty_string($query_id)):
        if (count($itemDataTable) > 0):
            print json_encode(array('status' => 'error', 'message' => 'item name already exist'));
            return;
        endif;
        $itemDataTable = $itemBusinessLayer->addItem($name, $category_id, $item_price, $item_photo, $item_description, 1, $_SESSION['user_pos']);
    else:
        if (count($itemDataTable) == 0):
            $itemDataTable = $itemBusinessLayer->getItemByID($query_id);
            if (count($itemDataTable) == 0):
                print json_encode(array('status' => 'error', 'message' => 'item doesnt exist '));
                return;
            endif;
        else:
            if ($itemDataTable [0]['Item_id'] != $query_id):
                print json_encode(array('status' => 'error', 'message' => 'Can t be save'));
                return;
            endif;
        endif;
        $itemDataTable = $itemBusinessLayer->editItem($query_id, $name, $category_id, $item_price, $item_photo, $item_description, 1, $_SESSION['user_pos']);
    endif;
    if (count($itemDataTable) > 0):
        $itemDataTable = $itemBusinessLayer->getItems();
        if ($itemBusinessLayer->getSuccess()):
            $content = Helper::fill_datatable('Items', $itemDataTable, array('Item Name', 'Category Name', 'Item Price', 'Item Description'), array('item_name', 'category_name', 'item_price', 'item_description'), 'Item_id');
        endif;
        $_SESSION['messages'] = Helper::set_message('item saved succesfuly', 'status');
        print json_encode($content);
    else:
        print json_encode(array('status' => 'error', 'message' => 'item not saved '));
    endif;
endif;
?>