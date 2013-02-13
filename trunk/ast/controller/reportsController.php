<?php

/**
 * This is the reports
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
include_once POS_ROOT . '/businessLayer/ReportsBusinessLayer.php';
$url = Helper::get_url() . '/';
$pathreport = $url . 'reports/' . $action . '-pdf';
$pathback = POS_ROOT . '/content/reports/' . $action . '.php';
$checkall = isset($data) && array_key_exists('checkall', $data) ? $data['checkall'] : '';
$filter_id = $checkall==1 ? null : isset($data) && array_key_exists('filter_select', $data) ? $data['filter_select'] : '';
$name_select = isset($data) && array_key_exists('select', $data) ? $data['select'] : '';
$mindate = isset($data) && array_key_exists('mindate', $data) ? $data['mindate'] : '';
$maxdate = isset($data) && array_key_exists('maxdate', $data) ? $data['maxdate'] : '';
$reportsDataTable = array();
$reportsDetailsDataTable = array();
$title = Helper::get_title_action($action);
include_once POS_ROOT . '/businessLayer/CafeteriaBusinessLayer.php';
if ($action == 'cafeteria-balance'):
    if ($query_id == 'show'):
        $reportsBusinessLayer = new ReportsBusinessLayer();
        $reportsDataTable = $filter_id!=null ?$reportsBusinessLayer->getCafeteriaBalanceByID($filter_id, $mindate, $maxdate, DELETED):
        $reportsBusinessLayer->getCafeteriaBalance($mindate, $maxdate, DELETED);
    endif;
elseif ($action == 'user-purchases'):
    if ($query_id == 'show'):
        $reportsBusinessLayer = new ReportsBusinessLayer();
        $reportsDataTable = $reportsBusinessLayer->getUsersPurchases($mindate, $maxdate);
    endif;
elseif ($action == 'detailed-user-purchases'):
    if ($query_id == 'show'):
        $reportsBusinessLayer = new ReportsBusinessLayer();
        $reportsDataTable = $reportsBusinessLayer->getMiniReportsByUser($filter_id, $mindate, $maxdate);
    endif;
elseif ($action == 'purchases-inventory'):
    if ($query_id == 'show'):
        $reportsBusinessLayer = new ReportsBusinessLayer();
        $reportsDataTable = $reportsBusinessLayer->getPurchasesInventory($mindate, $maxdate);
    endif;
elseif ($action == 'events-listing'):
    if ($query_id == 'show'):
        $reportsBusinessLayer = new ReportsBusinessLayer();
        $reportsDataTable = $reportsBusinessLayer->getEventListing($mindate, $maxdate);
    endif;
elseif ($action == 'detailed-event'):
    if ($query_id == 'show'):
        $reportsBusinessLayer = new ReportsBusinessLayer();
        $reportsDataTable = $reportsBusinessLayer->getEventDetailed($filter_id);
        $eventDetailsDataTable = $reportsBusinessLayer->getEventItemsDetailed($filter_id);
        $id_parent = '';
        foreach ($eventDetailsDataTable as $obj) {
            $id_parent = $obj['event_history_id'];
            $reportsDetailsDataTable[$id_parent][$obj['item_id']]['event_history_id'] = $id_parent;
            $reportsDetailsDataTable[$id_parent][$obj['item_id']]['category_name'] = $obj['category_name'];
            $reportsDetailsDataTable[$id_parent][$obj['item_id']]['item_name'] = $obj['item_name'];
            $reportsDetailsDataTable[$id_parent][$obj['item_id']]['item_quantity'] = $obj['item_quantity'];
            $reportsDetailsDataTable[$id_parent][$obj['item_id']]['item_price'] = $obj['item_price'];
        }
    endif;
elseif ($action == 'menu-report'):
    if ($query_id == 'show'):
        $reportsBusinessLayer = new ReportsBusinessLayer();
        $menuReport = $reportsBusinessLayer->getMenuReports(DELETED);
        $reportsDataTable = array();
        foreach ($menuReport as $obj) {
            if ((!array_key_exists('category_id', $reportsDataTable) && $obj['category_parent_id'] != 0) || ($obj['category_parent_id'] == 0 && $reportsDataTable[$obj['category_id']]['category_id'] != $obj['category_id'])) {
                $id_parent = $id_sub_parent = !Helper::is_empty_string($obj['category_name']) ? $obj['category_parent_id'] : $obj['category_id'];
                $reportsDataTable[$id_parent]['category_id'] = $id_parent;
                $reportsDataTable[$id_parent]['category_name'] = $obj['category_parent_name'];
            }
            if (!Helper::is_empty_string($obj['category_name']) && $id_sub_parent != $obj['category_id']) {
                $id_sub_parent = $obj['category_id'];
                $reportsDataTable[$id_parent]['sub-categories'][$id_sub_parent]['category_name'] = $obj['category_name'];
                $reportsDataTable[$id_parent]['sub-categories'][$id_sub_parent]['category_id'] = $obj['category_id'];
                $reportsDataTable[$id_parent]['sub-categories'][$id_sub_parent]['items'][$obj['item_id']]['item_name'] = $obj['item_name'];
                $reportsDataTable[$id_parent]['sub-categories'][$id_sub_parent]['items'][$obj['item_id']]['item_price'] = $obj['item_price'];
            } else {
                $reportsDataTable[$id_parent]['items'][$obj['item_id']]['item_name'] = $obj['item_name'];
                $reportsDataTable[$id_parent]['items'][$obj['item_id']]['item_price'] = $obj['item_price'];
            }
        }
    endif;
endif;
if ($query_id == 'show'):
    $data_report = array('select' => $name_select,
        'mindate' => $mindate,
        'maxdate' => $maxdate,
        'reports_data_table' => $reportsDataTable,
        'reports_details_data_table' => $reportsDetailsDataTable);
    $_SESSION['data_report'] = $data_report;
    print Helper::generate_container_pdf($pathreport, $action);
elseif ($query_id == 'back'):
    include_once POS_ROOT . '/include/header/reports/reports.php';
    include_once $pathback;
endif;

?>
