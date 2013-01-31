<?php

if (isset($_SESSION['data_report'])):

    require('helper/BuilderPDF.php');
    $data_report = $_SESSION['data_report'];
    $event_name = $data_report['event_name'];
    $department_name = $data_report['department_name'];
    $event_employee = $data_report['event_employee'];
    $event_invitees = $data_report['event_invitees'];
    $event_date = $data_report['event_date'];
    $reportsDataTable = $data_report['reports_data_table'];
    $fields = array('item_name', 'item_quantity');
    $pdf = new BuilderPDF();
    $title = 'Event';
    $pdf->SetTitle($title);
    $header = array('Item Name ', 'Item Quantity');
    $pdf->SetFont('Arial', '', 14);
    $pdf->AddPage();
    $pdf->Cell(130, 1, 'Event Name : ' . $event_name);
    $pdf->Cell(100, 1, 'Department Name : ' . $department_name);
    $pdf->Cell(130, 1, 'Employee Name : ' . $event_employee);
    $pdf->Cell(100, 1, 'Event Nb Invitees : ' . $event_invitees);
    $pdf->Cell(130, 1, 'Event Date : ' . $event_date);
    $pdf->Ln(20);
    $pdf->BuildTable($header, $reportsDataTable, $fields, 100);
    $pdf->Output();
    unset($_SESSION['data_report']);
endif;
?>
               