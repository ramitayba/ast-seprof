<?php

if (isset($_GET['uid']) && $_GET['uid'] != '' && isset($_GET['mindate']) && isset($_GET['maxdate'])) {
    $uid = $_GET['uid'];
    $min = $_GET['mindate'];
    $max = $_GET['maxdate'];
    require('helper/BuilderPDF.php');
    include_once POS_ROOT . '/businessLayer/UserBusinessLayer.php';
    $userBusinessLayer = new UserBusinessLayer();
    include_once POS_ROOT . '/businessLayer/ReportsBusinessLayer.php';
    $reportsBusinessLayer = new ReportsBusinessLayer();

    $reportsDataTable = $reportsBusinessLayer->getUserPurchasesByPeriod($uid, $min, $max);
    $user = $userBusinessLayer->getUserByID($uid);
    
    $data = array();
    foreach ($reportsDataTable as $row) {
        $data[] = array($row['order_id'], $row['cafeteria_name'], $row['cdate'], $row['order_total_payment']);
    }
    
    $pdf = new BuilderPDF();
    $title = 'Detail Purchases For ' . $user[0]['user_name'];
    $pdf->SetTitle($title);

    $header = array('Order #', 'Cafeteria', 'Date', 'Total');
    $pdf->SetFont('Arial', '', 14);
    $pdf->AddPage();
    $pdf->BuildTable($header, $data);
    $pdf->Output();
}
?>