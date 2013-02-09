<?php

require('helper/BuilderPDF.php');
    $data_report = $_SESSION['data_report'];
    $mindate = $data_report['mindate'];
    $maxdate = $data_report['maxdate'];
    $reportsDataTable = $data_report['reports_data_table'];
    $fields = array('item_name', 'balance');
    $pdf = new BuilderPDF();
    $title = 'Purchases Inventory ';
    $pdf->SetTitle($title);
    $header = array('Item Name ', 'Total',);
    $pdf->SetFont('Arial', '', 14);
    $pdf->AddPage();
    $pdf->Cell(130, 1, 'From : ' . $mindate);
    $pdf->Cell(100, 1, 'To : ' . $maxdate);
    $pdf->Ln(20);
    $pdf->BuildTable($header,$reportsDataTable, $fields,90);
    $pdf->Output();
    unset($_SESSION['data_report']);
?>