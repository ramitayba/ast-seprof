<?php

require('helper/BuilderPDF.php');
    $data_report = $_SESSION['data_report'];
    $mindate = $data_report['mindate'];
    $maxdate = $data_report['maxdate'];
    $reportsDataTable = $data_report['reports_data_table'];
    $fields = array('employee_name', 'balance','order_date');
    $pdf = new BuilderPDF();
    $title = 'Detailed User Purchases';
    $pdf->SetTitle($title);
    $header = array('Employee Name ', 'Balance Total','Order Date');
    $pdf->SetFont('Arial', '', 14);
    $pdf->AddPage();
    $pdf->Cell(130, 1, 'From : ' . $mindate);
    $pdf->Cell(100, 1, 'To : ' . $maxdate);
    $pdf->Ln(20);
    $pdf->BuildTable($header,$reportsDataTable, $fields,65);
    $pdf->Output();
    unset($_SESSION['data_report']);
?>