<?php

if (isset($_SESSION['data_report'])):

    require('helper/BuilderPDF.php');
    $data_report = $_SESSION['data_report'];
    $filter_name = $data_report['select'];
    $mindate = $data_report['mindate'];
    $maxdate = $data_report['maxdate'];
    $reportsDataTable = $data_report['reports_data_table'];
    $fields = array('cafeteria_name', 'total');
    $pdf = new BuilderPDF();
    $title = 'Cafteria Balance ';
    $pdf->SetTitle($title);
    $header = array('Cafeteria Name ', 'Balance Total');
    $pdf->SetFont('Arial', '', 14);
    $pdf->AddPage();
    //$pdf->Cell(120);
    //$image=Helper::get_url() . '/settings/default/files/nesma.png';
    //$pdf->Image('logo.png', 10, 10, -300);
    $pdf->Cell(130, 1, 'From : ' . $mindate);
    $pdf->Cell(100, 1, 'To : ' . $maxdate);
    $pdf->Ln(20);
    $pdf->BuildTable($header,$reportsDataTable, $fields,95);
    $pdf->Output();
    unset($_SESSION['data_report']);
endif;
?>
               