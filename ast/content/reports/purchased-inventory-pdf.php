<?php

if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    //require('include/fpdf17/fpdf.php');
//    $pdf = new FPDF();
//    $pdf->AddPage();
//    $pdf->SetFont('Arial', 'B', 16);
//    $pdf->Cell(40, 10, 'Hello World!!!' . $_GET['userid']);
//    $pdf->Output();

    require('helper/BuilderPDF.php');
    include_once POS_ROOT . '/businessLayer/ReportsBusinessLayer.php';
    $reportsBusinessLayer = new ReportsBusinessLayer();

    $reportsDataTable = $reportsBusinessLayer->getMiniReportsByUser($uid);
    $data = array();
    foreach ($reportsDataTable as $row) {
        $data[] = array($row['order_id'], $row['cafeteria_name'], $row['order_date'], $row['order_total_payment']);
    }
//echo '<pre>';print_r($reportsDataTable);echo '</pre>';die();
    $pdf = new BuilderPDF();
    $title = 'Mini Reports for user #' . $uid;
    $pdf->SetTitle($title);

    $header = array('Order #', 'Cafeteria', 'Date', 'Total');
//// Data loading
//$data = $pdf->LoadData('countries.txt');
    $pdf->SetFont('Arial', '', 14);
    $pdf->AddPage();
    $pdf->BuildTable($header, $data);
    $pdf->Output();
}
?>