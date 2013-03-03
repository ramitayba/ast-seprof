<?php

require('helper/BuilderPDF.php');
    $data_report = $_SESSION['data_report'];
    $mindate = $data_report['mindate'];
    $maxdate = $data_report['maxdate'];
     $name_employee=$data_report['select'];
    $reportsDataTable = $data_report['reports_data_table'];
    $fields = array( 'balance','order_date');
    $pdf = new BuilderPDF();
    $title = 'Detailed User Purchases';
    $pdf->SetTitle($title);
    $header = array('Balance Total','Order Date');
    $pdf->SetFont('Arial', '', 14);
    $pdf->AddPage();
    $pdf->Cell(130, 1, 'From : ' . $mindate);
    $pdf->Cell(100, 1, 'To : ' . $maxdate);
    $pdf->Ln(10);
    $pdf->Cell(130, 1, 'Employee Name :' . $name_employee);
    $pdf->Ln(10);
    $pdf->BuildTable($header,$reportsDataTable, $fields,95);
    $pdf->Output();
    unset($_SESSION['data_report']);
?>