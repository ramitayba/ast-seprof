<?php

/**
 * This is the reportsController
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */

include_once POS_ROOT . '/businessLayer/ReportsBusinessLayer.php';

if ($action == 'cafeteria-balance'):
    include_once POS_ROOT . '/businessLayer/CafeteriaBusinessLayer.php';
    //$forms = array('action' => $cafeteriaDataTable [0]['cafeteria_id'],
    // include_once POS_ROOT . '/content/reports/cafeteria-balance.php';

    if ($query_id == 'show'):
        $url = Helper::get_url() . '/';
        $pathreport = $url . 'reports/' . $action . '-pdf';
        $pathback = $url . 'reports/' . $action;
        $filter_id = $data['cafeteria'];
        $mindate = $data['mindate'];
        $maxdate = $data['maxdate'];
        $reportsBusinessLayer = new ReportsBusinessLayer();
        $reportsDataTable = $reportsBusinessLayer->getCafeteriaBalanceByID($filter_id, ACTIVE);
        //include_once POS_ROOT . '/content/reports/cafeteria-balance-pdf.php'; 
        print Helper::generate_container_pdf($pathreport, $pathback);
    endif;
endif;
?>
