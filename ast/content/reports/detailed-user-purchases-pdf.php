<?php

require('helper/BuilderPDF.php');
    $data_report = $_SESSION['data_report'];
    $mindate = $data_report['mindate'];
    $maxdate = $data_report['maxdate'];
     $name_employee=$data_report['select'];
    $reportsDataTable = $data_report['reports_data_table'];
    $reportsDetailsDataTable = $data_report['reports_details_data_table'];
    $fields = array( 'order_date','balance');
    $pdf = new BuilderPDF();
    $title = 'Detailed User Purchases';
    $pdf->SetTitle($title);
    $header = array('Order Date','Balance Total');
    $pdf->SetFont('Arial', '', 14);
    $pdf->AddPage();
    $pdf->Cell(130, 1, 'From : ' . $mindate);
    $pdf->Cell(100, 1, 'To : ' . $maxdate);
    $pdf->Ln(10);
    $pdf->Cell(130, 1, 'Employee Name :' . $name_employee);
    $pdf->Ln(10);
    foreach($reportsDetailsDataTable as $row)
    $pdf->Cell(100, 1, 'Department Name : ' . $row['department_name']);
    $pdf->Ln(10);
    $pdf->BuildTable($header,$reportsDataTable, $fields,95);
    $pdf->Output();
    unset($_SESSION['data_report']);
?>