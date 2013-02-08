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
    
     public function getCategoriesDataTable() {
        return $this->_CategoriesDataTable;
    }

    public function getCategories($status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetCategories(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_CategoriesDataTable = DataAccessManager::getInstance()->fillData(array($status));
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_CategoriesDataTable;
    }

    public function getParentCategories($status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetParentCategories(?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_CategoriesDataTable = DataAccessManager::getInstance()->fillData(array($status));
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_CategoriesDataTable;
    }

    public function getParentCategoriesWithoutID($id,$status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call getParentCategoriesWithoutID(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_CategoriesDataTable = DataAccessManager::getInstance()->fillData(array($id,$status));
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_CategoriesDataTable;
    }
    public function getCategoryByName($name,$status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetCategoryByName(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_CategoriesDataTable = DataAccessManager::getInstance()->fillData(array($name,$status));
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_CategoriesDataTable;
    }

    public function getCategoryByID($id,$status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetCategoryByID(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_CategoriesDataTable = DataAccessManager::getInstance()->fillData(array($id,$status));
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_CategoriesDataTable;
    }

    public function getCategoryChildrenByParentID($id,$status) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call GetCategoryChildrenByParentID(?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_CategoriesDataTable = DataAccessManager::getInstance()->fillData(array($id,$status));
            $this->_Success = DataAccessManager::getInstance()->getSuccess();
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_CategoriesDataTable;
    }
    
    public function addCategory($category_name, $category_parent_id, $color_code, $category_description, $status_id, $user_creation) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call AddCategory(?,?,?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($category_name, $category_parent_id, $color_code, $category_description, $status_id, $user_creation));
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
            $this->_CategoriesDataTable=DataAccessManager::getInstance()->getDataTable();
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_Success;
    }

    public function editCategory($category_id, $category_name, $category_parent_id, $color_code, $category_description, $status_id, $user_modification) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call EditCategory(?,?,?,?,?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveDataWithRetun(array($category_id, $category_name, $category_parent_id, $color_code, $category_description, $status_id, $user_modification));
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
             $this->_CategoriesDataTable=DataAccessManager::getInstance()->getDataTable();
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_Success;
    }

    public function deleteCategory($category_id,$status,$user_modification_id) {
        try {
            $this->_reset();
            $this->_SQLQuery = "{call DeleteCategory(?,?,?)}";
            DataAccessManager::getInstance()->setSQLQuery($this->_SQLQuery);
            $this->_Success = DataAccessManager::getInstance()->saveData(array($category_id,$status,$user_modification_id));
            if (!$this->_Success) {
                $this->_LastError = DataAccessManager::getInstance()->getLastError();
            }
        } catch (Exception $ex) {
            $this->_LastError = $ex->getMessage();
            $this->_Success = false;
        }
        return $this->_Success;
    }

}

