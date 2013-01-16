<?php

/**
 * This is the CategoryBusinessLayer
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
class CategoryBusinessLayer {

    private $_LastError;
    private $_CategoriesDataTable;
    private $_Success;
    private $_SQLQuery;
    private $_Result;

    public function __construct() {
        
    }

    private function _reset() {
        $this->_LastError = '';
        $this->_Result = '';
        $this->_SQLQuery = '';
        $this->_Success = false;
    }

    public function getSuccess() {
        return $this->_Success;
    }

    public function getLastError() {
        return $this->_LastError;
    }

    public function getCategories() {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getCategories}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_CategoriesDataTable = DataAccessManager::getInstance()->fillData();
            if (Helper::is_empty_array($this->_CategoriesDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_CategoriesDataTable;
    }

    public function getCategoryByName($name) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getCategoryByName(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_CategoriesDataTable = DataAccessManager::getInstance()->fillData(array($name));
            if (Helper::is_empty_array($this->_CategoriesDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_CategoriesDataTable;
    }

    public function getCategoryByID($id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getCategoryByID(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_CategoriesDataTable = DataAccessManager::getInstance()->fillData(array($id));
            if (Helper::is_empty_array($this->_CategoriesDataTable)) {
                $this->_Success = false;
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            } else {
                $this->_Success = true;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_CategoriesDataTable;
    }
    
    public function addCategory($category_name,$category_parent_id,$color_code,$category_description, $user_creation) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call addCategory(?,?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_CategoriesDataTable = DataAccessManager::getInstance()->saveData(array($category_name,$category_parent_id,$color_code,$category_description, $user_creation));
            if (!Helper::is_empty_array($this->_CategoriesDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_CategoriesDataTable;
    }

    public function editCategory($category_id,$category_name,$category_parent_id,$color_code,$category_description, $user_modification)  {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call editCategory(?,?,?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_CategoriesDataTable = DataAccessManager::getInstance()->saveData(array($category_id,$category_name,$category_parent_id,$color_code,$category_description, $user_modification));
            if (!Helper::is_empty_array($this->_CategoriesDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_CategoriesDataTable;
    }

    public function deleteCategory($category_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call deleteCategory(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_CategoriesDataTable = DataAccessManager::getInstance()->saveData(array($category_id));
            if (!Helper::is_empty_array($this->_CategoriesDataTable)) {
                $this->_Success = true;
            } else {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
                $this->_Success = false;
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
        }
        return $this->_CategoriesDataTable;
    }

}

