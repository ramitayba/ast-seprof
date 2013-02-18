<?php

/**
 * This is the Category
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
include_once POS_ROOT . '/businessLayer/CategoryBusinessLayer.php';
$categoryBusinessLayer = new CategoryBusinessLayer();
unset($_SESSION['category_id']);
if ($action == 'index' || $action == 'categories'):
    $title = 'Categories';
    $categoryDataTable = $categoryBusinessLayer->getParentCategories(DELETED);
    if ($categoryBusinessLayer->getSuccess()):
        $content = Helper::fill_datatable('categories', 'categories', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $categoryDataTable, array('Category ID', 'Category Name', 'Category Color Code', 'Category Description', 'Status'), array('category_id', 'category_name', 'color_code', 'category_description', 'status_name'), 'category_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                    1 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete')), true,10, 1, '', '', $root . 'themes/img/details_open.png', 'control-category');
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
            return;
        endif;
    endif;
elseif ($action == 'add'):
    $forms = array('status_id' => ACTIVE);
    include_once POS_ROOT . '/content/menu-management/categoriesform.php';
elseif ($action == 'edit'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $categoryDataTable = $categoryBusinessLayer->getCategoryByID($query_id, DELETED);
        if (count($categoryDataTable) == 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('Categories doesn t exist', 'error')));
            return;
        endif;
        $forms = array('category_id' => $categoryDataTable [0]['category_id'], 'category_name' => $categoryDataTable [0]['category_name'],
            'category_parent_id' => $categoryDataTable [0]['category_parent_id'], 'color_code' => $categoryDataTable [0]['color_code'],
            'category_description' => $categoryDataTable [0]['category_description'], 'status_id' => $categoryDataTable [0]['status_id']);
        include_once POS_ROOT . '/content/menu-management/categoriesform.php';
    else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('Categories not exist', 'error')));
        return;
    endif;
elseif ($action == 'save'):
    $name = isset($data['category_name']) ? $data['category_name'] : '';
    $parent = isset($data['category']) && !Helper::is_empty_string($data['category']) ? $data['category'] : '0';
    $color = isset($data['color_code']) ? $data['color_code'] : '';
    $description = isset($data['category_description']) ? $data['category_description'] : '';
    $status = isset($data['status']) ? $data['status'] : '';
    $array = array('Category Name' => array('content' => $name, 'type' => 'string', 'length' => '100'), 'Category Color Code' => array('content' => $color, 'type' => 'string', 'length' => '7'),
        'Status' => array('content' => $status, 'type' => 'int'));
    $message = Helper::is_list_empty($array);
    if (!Helper::is_empty_string($message)):
        print Helper::json_encode_array(array('status' => 'error', 'message' => $message));
        return;
    endif;
    $categoryDataTable = $categoryBusinessLayer->getCategoryByName($name, DELETED);
    if (Helper::is_empty_string($query_id)):
        if (count($categoryDataTable) > 0):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Category name already exist'));
            return;
        endif;
        $success = $categoryBusinessLayer->addCategory($name, $parent, $color, $description, $status, $_SESSION['user_pos']);
    else:
        if (!is_numeric($query_id)):
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Category doesn t  exist'));
            return;
        elseif (count($categoryDataTable) == 0):
            $categoryDataTable = $categoryBusinessLayer->getCategoryByID($query_id, DELETED);
            if (count($categoryDataTable) == 0):
                print Helper::json_encode_array(array('status' => 'error', 'message' => 'Category doesn t  exist '));
                return;
            endif;
        else:
            if ($categoryDataTable[0]['category_name'] == $name && $categoryDataTable[0]['category_id'] != $query_id):
                print Helper::json_encode_array(array('status' => 'error', 'message' => 'Role name already exist'));
                return;
            elseif ($categoryDataTable [0]['category_id'] != $query_id):
                print Helper::json_encode_array(array('status' => 'error', 'message' => 'Can t be saved'));
                return;
            endif;
        endif;
        $success = $categoryBusinessLayer->editCategory($query_id, $name, $parent, $color, $description, $status, $_SESSION['user_pos']);
    endif;
    if ($success):
        $categoryDataTable = $categoryBusinessLayer->getParentCategories(DELETED);
        if ($categoryBusinessLayer->getSuccess()):
            $content = Helper::fill_datatable('categories', 'categories', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $categoryDataTable, array('Category ID', 'Category Name', 'Category Color Code', 'Category Description', 'Status'), array('category_id', 'category_name', 'color_code', 'category_description', 'status_name'), 'category_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                        1 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete')), true, 1,1, '', '', $root . 'themes/img/details_open.png', 'control-category');
        endif;
        $container = Helper::set_message('Category saved successfully', 'status') . $content;
        print $container;
// endif;
    else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => 'Category not saved '));
    endif;
elseif ($action == 'delete'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $categoryDataTable = $categoryBusinessLayer->getCategoryByID($query_id, DELETED);
        if (count($categoryDataTable) == 0):
            print json_encode(array('status' => 'error', 'message' => Helper::set_message('Cafeteria not exist', 'error')));
            return;
        endif;
        $success = $categoryBusinessLayer->deleteCategory($query_id, DELETED, $_SESSION['user_pos']);
        if ($success):
            $container = Helper::set_message('Category ' . $categoryDataTable [0]['category_name'] . ' deleted successfully', 'status');
            $categoryDataTable = $categoryBusinessLayer->getParentCategories(DELETED);
            if ($categoryBusinessLayer->getSuccess()):
                $content = Helper::fill_datatable('categories', 'categories', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $categoryDataTable, array('Category ID', 'Category Name', 'Category Color Code', 'Category Description', 'Status'), array('category_id', 'category_name', 'color_code', 'category_description', 'status_name'), 'category_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                            1 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete')), true,1, 1, '', '', $root . 'themes/img/details_open.png', 'control-category');
                $container = $container . $content;
            endif;
            print $container;
        else:
            print Helper::json_encode_array(array('status' => 'error', 'message' => 'Category not deleted '));
        endif;
    else:
        print Helper::json_encode_array(array('status' => 'error', 'message' => Helper::set_message('Categories not exist', 'error')));
        return;
    endif;
elseif ($action == 'get'):
    $container = '';
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $categoryDataTable = $categoryBusinessLayer->getCategoryChildrenByParentID($query_id, DELETED);
        if (!Helper::is_empty_array($categoryDataTable)):
            $container = ' <div class="control-category-children"> <div class="clear"></div>
                <label class="control-label" for="children-category">Sub Category Name</label>
                    <div class="controls">';
            $container.=Helper::form_construct_drop_down('category-children', $categoryDataTable, '', 'category_name', 'category_id', '', '', '');
            $container.=' </div></div>';
        else:
            include_once POS_ROOT . '/businessLayer/ItemBusinessLayer.php';
            $itemBusinessLayer = new ItemBusinessLayer();
            $itemDataTable = $itemBusinessLayer->GetItemByCategory($query_id, DELETED);
            if (!Helper::is_empty_array($itemDataTable)):
                $container = '<div class="control-item"> <div class="clear"></div><label class="control-label" for="items">Item Name</label>
                    <div class="controls">';
                $container.=Helper::form_construct_drop_down('id', $itemDataTable, '', 'item_name', 'item_id', '', '', '');
                $container.=' </div></div>';
            endif;
        endif;
        print $container;
    endif;
elseif ($action == 'nested' && (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest')):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $categoryDataTable = $categoryBusinessLayer->getCategoryChildrenByParentID($query_id, DELETED);
        if ($categoryBusinessLayer->getSuccess() && !Helper::is_empty_array($categoryDataTable)):
            $content = Helper::fill_datatable('category-Children', 'categories', array(), $categoryDataTable, array('Category ID', 'Category Name', 'Category Color Code', 'Category Description', 'Status'), array('category_id', 'category_name', 'color_code', 'category_description', 'status_name'), 'category_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                        1 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete')), true, 1,1, '', '', $root . 'themes/img/details_open.png', 'control-sub-category', 'rt',$query_id);
        else:
            include_once POS_ROOT . '/businessLayer/ItemBusinessLayer.php';
            $itemBusinessLayer = new ItemBusinessLayer();
            $itemDataTable = $itemBusinessLayer->GetItemByCategory($query_id, DELETED);
            if ($itemBusinessLayer->getSuccess() && !Helper::is_empty_array($itemDataTable)):
                $content = Helper::fill_datatable('items', 'items', array(0 => array('name' => 'Add New Record', 'link' => 'new-', 'class' => 'new')), $itemDataTable, array('Item Name', 'Item Price', 'Item Description', 'Status'), array('item_name', 'item_price', 'item_description', 'status_name'), 'item_id', array(0 => array('name' => 'Edit', 'link' => 'edit-', 'class' => 'edit'),
                            1 => array('name' => 'Delete', 'link' => 'delete-', 'class' => 'delete')), true,0, -1, '', '', $root . '', '', 'rt',$query_id);
            endif;
        endif;
        print $content;
    endif;
endif;
?>