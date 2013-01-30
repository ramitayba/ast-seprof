<?php

require('helper/BuilderPDF.php');
$data = array();
global $reportsDataTable, $filter_id;
foreach ($reportsDataTable as $row) {
    $data[] = array($row['order_id'], $row['cdate'], $row['order_total_payment']);
}

$pdf = new BuilderPDF();
$title = 'Detail Purchases For ' . $filter_id;
$pdf->SetTitle($title);

$header = array('Order #', 'Date', 'Total');
$pdf->SetFont('Arial', '', 14);
$pdf->AddPage();
$pdf->BuildTable($header, $data);
$pdf->Cell(120);
$pdf->Cell(40, 10, 'Balance = ' . $reportsDataTable[0]['total'], 1, 1, 'C');
$pdf->Output();
?>
               