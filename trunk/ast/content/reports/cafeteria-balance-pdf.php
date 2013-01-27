<?php

if (isset($_GET['cid']) && $_GET['cid'] != '') {
    $cid = $_GET['cid'];

    require('helper/BuilderPDF.php');
    include_once POS_ROOT . '/businessLayer/ReportsBusinessLayer.php';
    $reportsBusinessLayer = new ReportsBusinessLayer();
    
    include_once POS_ROOT . '/businessLayer/CafeteriaBusinessLayer.php';
    $cafeteriaBusinessLayer = new CafeteriaBusinessLayer();

    $reportsDataTable = $reportsBusinessLayer->getCafeteriaBalanceByID($cid);
    $cafeteriaDataTable = $cafeteriaBusinessLayer->getCafeteriaByID($cid,1);

    $data = array();
    foreach ($reportsDataTable as $row) {
        $data[] = array($row['order_id'], $row['cdate'], $row['order_total_payment']);
    }

    $pdf = new BuilderPDF();
    $title = 'Detail Purchases For ' . $cafeteriaDataTable[0]['cafeteria_name'];
    $pdf->SetTitle($title);

    $header = array('Order #', 'Date', 'Total');
    $pdf->SetFont('Arial', '', 14);
    $pdf->AddPage();
    $pdf->BuildTable($header, $data);
    $pdf->Cell(120);
    $pdf->Cell(40, 10, 'Balance = '.$reportsDataTable[0]['total'], 1, 1, 'C');
    $pdf->Output();
}
?>