<?php

require('helper/BuilderPDF.php');
    $data_report = $_SESSION['data_report'];
    $name = $data_report['select'];
    $reportsDataTable = $data_report['reports_data_table'];
    $fields = array('item_name','item_quantity','item_price');
    $pdf = new BuilderPDF();
    $title = 'Detailed Event';
    $pdf->SetTitle($title);
    $header = array('Item Name ','Item Quantity' ,'Item Price');
    $pdf->SetFont('Arial', '', 14);
    $pdf->AddPage();
    $pdf->Cell(130, 1, 'Event Name : ' . $name);
    $pdf->Ln(20);
    $pdf->BuildTable($header,$reportsDataTable, $fields,48);
    $pdf->Output();
    unset($_SESSION['data_report']);
?>