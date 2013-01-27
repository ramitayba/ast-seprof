<?php

if (isset($_GET['mindate']) && isset($_GET['maxdate'])) {
    $min = $_GET['mindate'];
    $max = $_GET['maxdate'];

//    die($min . " - ". $max);

    require('helper/BuilderPDF.php');
    include_once POS_ROOT . '/businessLayer/ReportsBusinessLayer.php';
    $reportsBusinessLayer = new ReportsBusinessLayer();

    $reportsDataTable = $reportsBusinessLayer->getAllUsersPurchasesByPeriod($min, $max);
    $data = array();
    foreach ($reportsDataTable as $row) {
        $data[] = array($row['order_id'], $row['cafeteria_name'], $row['cdate'], $row['order_total_payment']);
    }
//    echo '<pre>';
//    print_r($reportsDataTable);
//    echo '</pre>';
//    die();
    $pdf = new BuilderPDF();
    $title = 'Users Purchases From ' . $min . ' To ' . $max;
    $pdf->SetTitle($title);

    $header = array('Order #', 'Cafeteria', 'Date', 'Total');
    $pdf->SetFont('Arial', '', 14);
    $pdf->AddPage();
    $pdf->BuildTable($header, $data);
    $pdf->Output();
}
?>