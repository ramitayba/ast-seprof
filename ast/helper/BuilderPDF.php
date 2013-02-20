<?php

/**
 * This is the BuilderPDF
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
require('include/fpdf17/fpdf.php');
define('POS_ROOT', getcwd());

class BuilderPDF extends FPDF {

    public function __construct() {
        parent::__construct();
        $this->AddFont('Aller-Bold', '', 'ALLER.php');
        $this->AddFont('Aller', '', 'ALLER_RG.php');
    }

    function Header() {
        global $title;
        $this->SetFont('Aller-Bold', '', 14);
        $this->Image(POS_ROOT . PATH_IMAGES_REPORT . HEADER_REPORT_BACKGROUND_IMAGE, '', '', '250', '40');
        $this->Image(POS_ROOT . PATH_IMAGES_REPORT . HEADER_REPORT_LOGO, 10, 5, 50, 20);
        $this->SetTextColor(255, 187);
        $this->Cell(150, 20, HEADER_TITLE, 0, 0, 'C');
        //$this->SetFont('Arial', '', 14);
        $this->ln(18);
        $this->SetTextColor(000);
        $this->Cell(300, 15, $title . ' Date:' . date("d-m-Y"), 0, 0, 'C');
        $this->ln(20);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Aller', '', 8);
        $this->SetTextColor(255, 187);
        //$this->Cell(0, 10, 'Nisma Cafeterias System', 0, 0, 'L')
        $this->Image(POS_ROOT . PATH_IMAGES_REPORT . HEADER_REPORT_FOOTER, '0', $this->GetY() + 5, '250', '10');
        $this->Cell(0, 20, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
        $this->AliasNbPages();
    }

    /**
     *
     * @param type $file
     * @return type 
     */
    function LoadData($source) {
//TODO
        return $data;
    }

    /**
     *
     * @param type $header
     * @param type $data 
     */
    function BuildTable($header, $data, $fields, $width, $font = 14, $specifique_header = '', $specifique_colonne = '', $specifique_width = '') {
// Header
        $newWidth = $width;
        $this->SetFont('Arial', '', $font);
        if (!Helper::is_empty_array($header)) {
            foreach ($header as $col) {
                $newWidth = $specifique_header == $col ? $specifique_width : $width;
                $this->Cell($newWidth, 10, $col, 1, 0, 'C');
            }
            $this->Ln();
        }
// Data
        $border = !Helper::is_empty_array($header) ? 1 : 0;
        if (!Helper::is_empty_array($data)) {
            foreach ($data as $row) {
                foreach ($fields as $col) {
                    $newWidth = $specifique_colonne == $col ? $specifique_width : $width;
                    $this->Cell($newWidth, 10, $row[$col], $border, 0, 'C');
                }
                $this->Ln();
            }
        }
    }

    function BuildTableMenuReport($data, $fields_category, $fields_item, $width) {
        foreach ($data as $row) {
            $this->SetX(0);
            $exitItem = array_key_exists('items', $row) && $row['category_parent_id'] == 0;
            $exist = array_key_exists('sub-categories', $row) || $exitItem;
            foreach ($fields_category as $col) {
                $font = $exist ? 20 : 16;
                $style = $exist ? 'I' : 'B';
                $border = $exist ? 'R' : '0';
                $y = $exist ? 7 * Helper::get_size_array($row, 'sub-categories', 'items') : 10;
                $this->SetFont('times', $style, $font);
                if (!$exist) {
                    $align = 'L';
                    // $this->Cell($width+10, $y, '', $border, 0);
                } else {
                    $align = 'C';
                }
                if (!$exist) {
                    $this->SetX(90);
                }
                $this->Cell($width, $y, $row[$col], $border, 0, $align);
            }
            if (array_key_exists('sub-categories', $row)) {
                $this->BuildTableMenuReport($row['sub-categories'], $fields_category, $fields_item, $width);
            } else {
                if (!$exist) {
                    $this->Ln(10);
                }
                $widthitems = 50;
                $this->SetFont('Arial', '', 10);
                foreach ($row['items'] as $row_items) {
                    $this->SetX(90);
                    foreach ($fields_item as $col_items) {
                        $row_items[$col_items] = is_numeric($row_items[$col_items]) && $row_items[$col_items] == 0 ? '0' : $row_items[$col_items];
                        $this->Cell($widthitems, 5, $row_items[$col_items], 0, 0, 'L');
                    }
                    $this->Ln(5);
                }
                $this->Ln(5);
            }
            if ($exist) {
                // $this->SetMargins(-$width, 0 );
                $this->SetX(50);
                $this->Cell(155, 2, '', 'B', 0, 'c');
                $this->Ln(15);
            }
        }
    }

    function BuildTableEventHistoryReport($header_event_item, $date_event, $data_event_item, $fields_event_item, $width) {
// Header
        foreach ($date_event as $row_event) {
            $this->AddPage();
            $this->Cell(130, 1, 'Event Name : ' . $row_event['event_name']);
            $this->Cell(80, 1, 'Department : ' . $row_event['department_name']);
            $this->Ln(10);
            $this->Cell(130, 1, 'Employee Name : ' . $row_event['employee_name']);
            $this->Cell(80, 1, 'Event Nb Invitees : ' . $row_event['event_invitees_nb']);
            $this->Ln(10);
            $this->Cell(130, 1, 'Event Date : ' . $row_event['event_date']);
            $this->Ln(10);
            $this->BuildTable($header_event_item, $data_event_item[$row_event['event_history_id']], $fields_event_item, $width);
            $this->Ln(10);
            $total_item = $row_event['sum_item'] == 0 ? '0' : $row_event['sum_item'];
            $total_price = $row_event['sum_price'] == 0 ? '0' : $row_event['sum_price']*$total_item;
            $this->Cell(130, 1, 'Total Items : ' . $total_item);
            $this->Cell(80, 1, 'Total Price : ' . round($total_price,2));
        }
    }

}