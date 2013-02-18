<?php

if (isset($_SESSION['data_report'])):

    require('helper/BuilderPDF.php');
    $data_report = $_SESSION['data_report'];
    $reportsDataTable = $data_report['reports_data_table'];
    $fields_category = array('category_name');
    $fields_item = array('item_name', 'item_price');
    $pdf = new BuilderPDF();
    $title = 'Menu Reports';
    //$pdf->SetTitle($title);
    //$pdf->Image(POS_ROOT.'/default/files/images/header-report.png');
    $pdf->SetFont('Arial', '', 14);
    $pdf->AddPage();
    //$pdf->Cell(120);
    //$image=Helper::get_url() . '/settings/default/files/nesma.png';
    //$pdf->Image('logo.png', 10, 10, -300);
    $pdf->BuildTableMenuReport( $reportsDataTable, $fields_category, $fields_item, 70);
    $pdf->Output();
    unset($_SESSION['data_report']);
endif;
?>
               