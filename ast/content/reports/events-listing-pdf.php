<?php

require('helper/BuilderPDF.php');
    $data_report = $_SESSION['data_report'];
    $mindate = $data_report['mindate'];
    $maxdate = $data_report['maxdate'];
    $reportsDataTable = $data_report['reports_data_table'];
    $fields = array('event_name', 'employee_name','department_name','event_date');
    $pdf = new BuilderPDF();
    $title = 'Event Listing';
    $pdf->SetTitle($title);
    $header = array('Event Name ','Employee Name' ,'Department Name','Event Date');
    $pdf->SetFont('Arial', '', 14);
    $pdf->AddPage();
    $pdf->Cell(130, 1, 'From : ' . $mindate);
    $pdf->Cell(100, 1, 'To : ' . $maxdate);
    $pdf->Ln(20);
    $pdf->BuildTable($header,$reportsDataTable, $fields,48);
    $pdf->Output();
    unset($_SESSION['data_report']);
?>