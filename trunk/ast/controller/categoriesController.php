<?php

/**
 * This is the Menu
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
include_once POS_ROOT . '/businessLayer/CategoryBusinessLayer.php';
$categoryBusinessLayer = new CategoryBusinessLayer();
unset($_SESSION['category_id']);
if ($action == 'index' || $action == 'categories'):
    $categoryDataTable = $categoryBusinessLayer->getCategories();
    if ($categoryBusinessLayer->getSuccess()):
        $content = Helper::fill_datatable('categories', $categoryDataTable, array('Category Name', 'Category Parent', 'Category Color Code', 'Category Description', 'Status'), array('category_name', 'category_parent_name', 'color_code', 'category_description', 'status_name'), 'category_id');
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
    include_once POS_ROOT . '/content/products/categoriesform.php';
elseif ($action == 'edit'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $categoryDataTable = $categoryBusinessLayer->getCategoryByID($query_id);
        if (count($categoryDataTable) == 0):
            print json_encode(array('status' => 'error', 'message' => 'Category doesn t  exist '));
            return;
        endif;
        $forms = array('category_id' => $categoryDataTable [0]['category_id'], 'category_name' => $categoryDataTable [0]['category_name'],
            'category_parent_id' => $categoryDataTable [0]['category_parent_id'], 'color_code' => $categoryDataTable [0]['color_code'],
            'category_description' => $categoryDataTable [0]['category_description'], 'status_id' => $categoryDataTable [0]['status_id']);
        include_once POS_ROOT . '/content/products/categoriesform.php';
    endif;
elseif ($action == 'save'):
    $name = isset($data['category_name']) ? $data['category_name'] : '';
    $parent = isset($data['category']) ? $data['category'] : '0';
    $color = isset($data['color_code']) ? $data['color_code'] : '';
    $description = isset($data['category_description']) ? $data['category_description'] : '';
    $status = isset($data['status']) ? $data['status'] : '';
    $additem = isset($data['status']) ? $data['status'] : '';
    $array = array('Category Name' => $name, 'Category Parent' => $parent, 'Category Color Code' => $color,
        'Category Description' => $description, 'Status' => $status);
    $message = Helper::is_list_empty($array);
    if (!Helper::is_empty_string($message)):
        print json_encode(array('status' => 'error', 'message' => $message));
        return;
    endif;
    $categoryDataTable = $categoryBusinessLayer->getCategoryByName($name);
    if (Helper::is_empty_string($query_id)):
        if (count($categoryDataTable) > 0):
            print json_encode(array('status' => 'error', 'message' => 'Category name already exist'));
            return;
        endif;
        $success = $categoryBusinessLayer->addCategory($name, $parent, $color, $description, $status, $_SESSION['user_pos']);
    else:
        if (!is_numeric($query_id)):
            print json_encode(array('status' => 'error', 'message' => 'Category doesn t  exist'));
            return;
        elseif (count($categoryDataTable) == 0):
            $categoryDataTable = $categoryBusinessLayer->getCategoryByID($query_id);
            if (count($categoryDataTable) == 0):
                print json_encode(array('status' => 'error', 'message' => 'Category doesn t  exist '));
                return;
            endif;
        else:
            if ($categoryDataTable [0]['category_id'] != $query_id):
                print json_encode(array('status' => 'error', 'message' => 'Can t be save'));
                return;
            endif;
        endif;
        $success = $categoryBusinessLayer->editCategory($query_id, $name, $parent, $color, $description, $status, $_SESSION['user_pos']);
    endif;
    if ($success):
        /*if ($additem):
            $action='index';
            $query_id = $categoryBusinessLayer->getCategoriesDataTable()[0][0];
            include_once POS_ROOT . '/controller/itemsController.php';
        else:*/
            $categoryDataTable = $categoryBusinessLayer->getCategories();
            if ($categoryBusinessLayer->getSuccess()):
                $content = Helper::fill_datatable('categories', $categoryDataTable, array('Category Name', 'Category Parent', 'Category Color Code', 'Category Description', 'Status'), array('category_name', 'category_parent_name', 'color_code', 'category_description', 'status_name'), 'category_id');
            endif;
            $container = Helper::set_message('Category saved succesfuly', 'status') . $content;
            print json_encode($container);
       // endif;
    else:
        print json_encode(array('status' => 'error', 'message' => 'Category not saved '));
    endif;
elseif ($action == 'delete'):
    if (!Helper::is_empty_string($query_id) && is_numeric($query_id)):
        $categoryDataTable = $categoryBusinessLayer->getCategoryByID($query_id);
        if (count($categoryDataTable) == 0):
            print json_encode(array('status' => 'error', 'message' => 'Category doesn t  exist '));
            return;
        endif;
        $success = $categoryBusinessLayer->deleteCategory($query_id);
        if ($success):
            $container = Helper::set_message('Category ' . $categoryDataTable [0]['category_name'] . ' delete succesfuly', 'status');
            print json_encode($container);
        else:
            print json_encode(array('status' => 'error', 'message' => 'Category not deleted '));
        endif;
    endif;
endif;
?>