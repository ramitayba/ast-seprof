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
if ($action == 'index'||$action == 'categories'):
    $categoryDataTable = $categoryBusinessLayer->getCategories();
    if ($categoryBusinessLayer->getSuccess()):
        $content = Helper::fill_datatable('categories', $categoryDataTable, array('Category Name','Category Parent','Category Color Code','Category Description'), array('category_name','category_parent_name','color_code','category_description'), 'category_id');
        if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') :
            print json_encode($content);
            return;
        endif;
        unset( $_SESSION['messages']);
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
    if (!Helper::is_empty_string($query_id)):
        $categorieDataTable = $categorieBusinessLayer->getCategoryByID($query_id);
        $forms = array('categorie_id' => $categorieDataTable [0]['categorie_id'], 'categorie_name' => $categorieDataTable [0]['categorie_name'],
         'categorie_parent_id' => $categorieDataTable [0]['categorie_parent_id'], 'color_code' => $categorieDataTable [0]['color_code'],'category_description' => $categorieDataTable [0]['category_description']);
        include_once POS_ROOT . '/content/categories/categoriesform.php';
    endif;
elseif ($action == 'save'):
    $name = isset($_POST['category_name']) ? $_POST['category_name'] : '';
    $parent = isset($_POST['category_parent_id']) ? $_POST['category_parent_id'] : '';
    $color = isset($_POST['color_code']) ? $_POST['color_code'] : '';
    $description = isset($_POST['category_description']) ? $_POST['category_description'] : '';
    $forms = array('category_name' => $name, 'category_parent_id' => $parent,
        'color_code' => $color);
    $array = array($name, $parent, $color);
    $message = Helper::is_list_empty($array);
    if (!Helper::is_empty_string($message)):
       /* ob_start();
        include
               POS_ROOT . '/content/categories/categoriesform.php';
        $html = ob_get_contents();
        ob_end_clean();
        print json_encode($html);*/
        print json_encode(array('status' => 'error', 'message' =>$message));
        return;
    endif;
    $categorieDataTable = $categorieBusinessLayer->getCategoryByName($name);
    if (Helper::is_empty_string($query_id)):
        if (count($categorieDataTable) > 0):
            print json_encode(array('status' => 'error', 'message' => 'Category name already exist'));
            return;
        endif;
        $categorieDataTable = $categorieBusinessLayer->addCategory($name ,$parent,$color,$description,$_SESSION['user_pos']);
    else:
        if (count($categorieDataTable) == 0):
            $categorieDataTable = $categorieBusinessLayer->getCategoryByID($query_id);
            if (count($categorieDataTable) == 0):
                 print json_encode(array('status' => 'error', 'message' => 'Category doesn t  exist '));
                return;
            endif;
        else:
            if ($categorieDataTable [0]['categorie_id'] != $query_id):
                 print json_encode(array('status' => 'error', 'message' => 'Can t be save'));
                return;
            endif;
        endif;
        $categorieDataTable = $categorieBusinessLayer->editCategory($query_id, $name ,$parent,$color,$description,$_SESSION['user_pos']);
    endif;
    if (count($categorieDataTable) > 0):
        $categorieDataTable = $categorieBusinessLayer->getCategories();
        if ($categorieBusinessLayer->getSuccess()):
             $content = Helper::fill_datatable('categories', $categorieDataTable, array('Category Name','Category Parent','Category Color Code','Category Description'), array('category_name','category_parent_name','color_code','category_description'), 'category_id');
        endif;
        $_SESSION['messages'] = Helper::set_message('Category saved succesfuly', 'status');
        print json_encode($content);
    else:
        print json_encode(array('status' => 'error', 'message' => 'Category not saved '));
    endif;
endif;
?>