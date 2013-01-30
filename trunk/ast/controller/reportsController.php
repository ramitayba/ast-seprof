<?php

/**
 * This is the reportsController
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
require('helper/BuilderPDF.php');
include_once POS_ROOT . '/businessLayer/ReportsBusinessLayer.php';

if ($action == 'cafeteria-balance'):
    include_once POS_ROOT . '/businessLayer/CafeteriaBusinessLayer.php';
    //$forms = array('action' => $cafeteriaDataTable [0]['cafeteria_id'],
    // include_once POS_ROOT . '/content/reports/cafeteria-balance.php';

    if ($query_id == 'show'):
        $cafeteria_id = $data['cafeteria'];
        $mindate = $data['mindate'];
        $maxdate = $data['maxdate'];
        $reportsBusinessLayer = new ReportsBusinessLayer();
        $reportsDataTable = $reportsBusinessLayer->getCafeteriaBalanceByID($cafeteria_id, ACTIVE);
        include_once POS_ROOT . '/content/reports/cafeteria-balance-pdf.php'; 
        //print Helper::generate_container_pdf('/ast/reports/cafeteria-balance-pdf', '');
    endif;
endif;
?>
