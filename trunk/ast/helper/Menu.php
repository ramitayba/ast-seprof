<?php

/**
 * This is the Menu
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
class Menu {

    private static $_Instance;
    private $_MenuTable;
    private $_ParentMenu;
    private $_SubMenu;

    private function __construct() {
        
    }

    public static function getInstance() {
        if (!self::$_Instance) {
            self::$_Instance = new Menu();
        }
        return self::$_Instance;
    }

    public function constructMenu($role_id) {
        $this->_MenuTable = LookupBusinessLayer::getInstance()->getPermission($role_id);
        $this->_ready_memu_table();
        return $this->_build_menu($this->_ParentMenu, $this->_SubMenu);
    }

    public function getAccessMenu($url) {
        if ($url == 'master' or $url == 'index' or $url == 'login' or $url == '404' or $url == 'logout'):
            return true;
        endif;
        foreach ($this->_MenuTable as $obj):
            $split = explode($obj['menu_link'] . '/', $url);
            $split = $split[1];
            if ($split == 'index'):
                return true;
            endif;
            if ($obj['menu_link'] == $url):
                return true;
            endif;
        endforeach;
        return false;
    }

    private function _ready_memu_table() {
        unset($this->_ParentMenu);
        unset($this->_SubMenu);
        foreach ($this->_MenuTable as $obj) {
            if ($obj['menu_parent_id'] == 0) {
                $this->_ParentMenu[$obj['menu_id']]['label'] = $obj['menu_name'];
                $this->_ParentMenu[$obj['menu_id']]['link'] = $obj['menu_link'];
            } else {
                $this->_SubMenu[$obj['menu_id']]['parent'] = $obj['menu_parent_id'];
                $this->_SubMenu[$obj['menu_id']]['label'] = $obj['menu_name'];
                $this->_SubMenu[$obj['menu_id']]['link'] = $obj['menu_link'];
                if (empty($this->_ParentMenu[$obj['menu_parent_id']]['count'])) {
                    $this->_ParentMenu[$obj['menu_parent_id']]['count'] = 0;
                }
                $this->_ParentMenu[$obj['menu_parent_id']]['count']++;
            }
        }
        if (!isset($this->_SubMenu)) {
            $this->_SubMenu = array();
        }
    }

    private function _build_menu($parent_array, $sub_array, $main_id = 'nav', $sub_id = 'dropdown-menu') {
        $menu = '
    <ul id="' . $main_id . '" class="' . $main_id . '"><li class="nav-icon active">
                    <a href="./">
                        <i class="icon-home"></i>
                        <span>Home</span>
                    </a>	    				
                </li>';
        if (!Helper::is_empty_array($parent_array)) {
            foreach ($parent_array as $pkey => $pval) {
                //$classes = $this->_build_classes_menu('depth-1 ', $level_parent, count($parent_array), empty($pval['count']),$url,$pval['link']);
                $menu .= '
        <li id="menu-' . $pkey . '" class="dropdown">
            <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
            <i class="icon-th"></i>' . $pval['label'] . '<b class="caret"></b></a>';
                if (!empty($pval['count'])) {
                    $menu .= '<ul class="' . $sub_id . '">';
                    foreach ($sub_array as $skey => $sval) {
                        if ($pkey == $sval['parent']) {
                            $menu .= '
            <li><a title="' . $sval['label'] . '"  href="/ast/' . $sval['link'] . '">' . $sval['label'] . '</a></li>';
                        }
                    }
                    $menu .= '
        </ul>';
                }
                $menu .= '</li>';
            }
        }
        $menu .= '
    </ul>';
        return $menu;
    }

}

