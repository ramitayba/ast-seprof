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

    private function __construct() {
        
    }

    public static function getInstance() {
        if (!self::$_Instance) {
            self::$_Instance = new Menu();
        }
        return self::$_Instance;
    }

    public function constructMenu($role_id,$root) {
        $this->_MenuTable = LookupBusinessLayer::getInstance()->getPermission($role_id);
        $this->_ready_memu_table();
        return $this->_build_menu($this->_ParentMenu,$root);
    }

    public function getAccessMenu($url) {
        if ($url == 'master' or $url == 'index' or $url == 'login' or $url == '404' or $url == 'logout'):
            return true;
        endif;
        foreach ($this->_MenuTable as $obj):
            $split = explode($obj['menu_link'] . '/', $url);
            if (count($split)>= 2):
                $split = $split[1];
            endif;
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
        foreach ($this->_MenuTable as $obj) {
            if ($obj['menu_parent_id'] == 0) {
                $id_parent = $id_sub_parent = $obj['menu_id'];
                $this->_ParentMenu[$obj['menu_id']]['menu_id'] = $obj['menu_id'];
                $this->_ParentMenu[$obj['menu_id']]['label'] = $obj['menu_name'];
                $this->_ParentMenu[$obj['menu_id']]['link'] = $obj['menu_link'];
            } else {
                if ($id_parent != $id_sub_parent && $obj['menu_parent_id'] == $id_sub_parent) {
                    $this->_ParentMenu[$id_parent]['children'][$id_sub_parent]['children'][$obj['menu_id']]['parent'] = $obj['menu_parent_id'];
                    $this->_ParentMenu[$id_parent]['children'][$id_sub_parent]['children'][$obj['menu_id']]['label'] = $obj['menu_name'];
                    $this->_ParentMenu[$id_parent]['children'][$id_sub_parent]['children'][$obj['menu_id']]['link'] = $obj['menu_link'];
                } else {
                    $this->_ParentMenu[$id_parent]['children'][$obj['menu_id']]['parent'] = $id_parent;
                    $this->_ParentMenu[$id_parent]['children'][$obj['menu_id']]['menu_id'] = $obj['menu_id'];
                    $this->_ParentMenu[$id_parent]['children'][$obj['menu_id']]['label'] = $obj['menu_name'];
                    $this->_ParentMenu[$id_parent]['children'][$obj['menu_id']]['link'] = $obj['menu_link'];
                }
                $id_sub_parent = $obj['menu_link'] == '#' ? $obj['menu_id'] : $id_sub_parent;
            }
        }
    }

    private function _build_menu($parent_array, $root,$main_id = 'nav', $sub_id = 'dropdown-menu', $icon = '<i class="icon-th"></i>', $recursive = false) {
         $menu='';
        if (!$recursive) {
            $menu = '
    <ul id="' . $main_id . '" class="' . $main_id . '"><li class="nav-icon active">
                    <a href="./">
                        <i class="icon-home"></i>
                        <span>Home</span>
                    </a>	    				
                </li>';
        }
      
        if (!Helper::is_empty_array($parent_array)) {
            foreach ($parent_array as $pval) {
                $id_parent = $pval['menu_id'];
                $val=!$recursive ? $icon . $pval['label'] . '<b class="caret"></b>' : $pval['label'] . $icon;
                $menu .= ' <li id="menu-' . $id_parent . '" class="dropdown"> <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">'.$val. '</a>';
                 if (array_key_exists('children', $pval)) {
                    $menu .= '<ul class="' . $sub_id . '">';
                    foreach ($pval['children'] as $sval) {
                        if ($id_parent == $sval['parent'] && $sval['link'] != '#') {
                            $menu .= '
            <li><a title="' . $sval['label'] . '"  href="' . $root . $sval['link'] . '">' . $sval['label'] . '</a></li>';
                        } else {
                           // print_r($sval);
                            $array = array($sval);
                            if (array_key_exists('children', $sval)) {
                                $menu.=$this->_build_menu($array,$root, $main_id, 'dropdown-menu sub-menu', '<i class="icon-chevron-right sub-menu-caret"></i>', true);
                            }
                        }
                    }
                    $menu .= '
        </ul>';
                }
                $menu .= '</li>';
            }
        }
        if (!$recursive) {
            $menu .= '
    </ul>';
        }
        return $menu;
    }

}

