<?php

if (isset($_SESSION['data_report'])):

    /* require('helper/BuilderPDF.php');
      $data_report = $_SESSION['data_report'];
      $event_name = $data_report['event_name'];
      $department_name = $data_report['department_name'];
      $event_employee = $data_report['employee_name'];
      $event_invitees = $data_report['event_invitees'];
      $event_date = $data_report['event_date'];
      $reportsDataTable = $data_report['reports_data_table'];
      $fields = array('item_name', 'item_quantity');
      $pdf = new BuilderPDF();
      $title = 'Event Report ';
      $pdf->SetTitle($title);
      $header = array('Item Name ', 'Item Quantity');
      $pdf->SetFont('Arial', '', 14);
      $pdf->AddPage();
      $pdf->Cell(130, 1, 'Event Name : ' . $event_name);
      $pdf->Cell(80, 1, 'Department: ' . $department_name);
      $pdf->Ln(10);
      $pdf->Cell(130, 1, 'Employee Name : ' . $event_employee);
      $pdf->Cell(80, 1, 'Event Attendees : ' . $event_invitees);
      $pdf->Ln(10);
      $pdf->Cell(130, 1, 'Event Date : ' . $event_date);
      $pdf->Ln(10);
      $pdf->BuildTable($header, $reportsDataTable, $fields, 95);
      $pdf->Output(); */
    $data_report = $_SESSION['data_report'];
    $content = Helper::construct_template_view($data_report);
    include POS_ROOT . '/include/template/preview.php';
    unset($_SESSION['data_report']);
endif;
?>
               