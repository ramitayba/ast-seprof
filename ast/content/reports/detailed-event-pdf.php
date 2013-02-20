<?php

require('helper/BuilderPDF.php');
$data_report = $_SESSION['data_report'];
$reportsDataTable = $data_report['reports_data_table'];
$reportsDetailsDataTable = $data_report['reports_details_data_table'];
print_r($reportsDetailsDataTable);
$fields = array('item_name', 'item_quantity', 'item_price','line_total');
$pdf = new BuilderPDF();
$title = 'Detailed Event';
$pdf->SetTitle($title);
$header = array( 'Item Name ', 'Item Quantity', 'Item Price','Total');
$pdf->SetFont('Arial', '', 14);
$pdf->Ln(20);
/* $pdf->Cell(130, 1, 'Event Name : ' . $event_name);
  $pdf->Cell(80, 1, 'Department Name : ' . $department_name);
  $pdf->Ln(10);
  $pdf->Cell(130, 1, 'Employee Name : ' . $event_employee);
  $pdf->Cell(80, 1, 'Event Nb Invitees : ' . $event_invitees);
  $pdf->Ln(10);
  $pdf->Cell(130, 1, 'Event Date : ' . $event_date);
  $pdf->Ln(10); */
$pdf->BuildTableEventHistoryReport($header, $reportsDataTable, $reportsDetailsDataTable, $fields, 48);
$pdf->Output();
unset($_SESSION['data_report']);
?>