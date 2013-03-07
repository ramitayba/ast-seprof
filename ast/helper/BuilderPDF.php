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
        $h = 1;
        if (!Helper::is_empty_array($data)) {
            foreach ($data as $row) {
                //$x = 10;
                //$y_axis=$this->GetY();
                //$y_axis = $y_axis>7*28?10:$y_axis;
                foreach ($fields as $col) {
                    $newWidth = $specifique_colonne == $col ? $specifique_width : $width;
                    $text = $row[$col];
                    //$nb = max($nb, $this->NbLines($newWidth, $text));
                    // $h = $h < $nb ? 15 * $nb : $h;
                    $height = 7;
                    $this->Cell($newWidth, $height, $text, $border, 0, 'C');
                    //$x+=$newWidth;
                    // $this->SetXY($x, $y_axis);
                }
                //$this->SetXY(10, $y_axis + 3);
                $this->Ln();
            }
            // $this->Ln($h);
        }
    }

    function CheckPageBreak($h) {
        //If the height h would cause an overflow, add a new page immediately
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function BuildTableMenuReport($data, $fields_category, $fields_item, $width, $field_parent,$counter=0,$nbLine=0) {
        foreach ($data as $row) {
            $this->SetX(0);
            $exitItem = array_key_exists('items', $row) && $row['category_parent_id'] == 0;
            $exist = array_key_exists('sub-categories', $row) || $exitItem;
            $y_axis = $this->GetY();
            $y = 10;
            $nb = $exist?Helper::get_size_array($row, 'sub-categories', 'items'):$nbLine;
            //$count = array_key_exists('sub-categories', $row) ? count('sub-categories') : 0;
            $counter_line = $counter;
            foreach ($fields_category as $col) {
                $font = $exist ? 20 : 16;
                $style = $exist ? 'I' : 'B';
                $border = $exist ? 'R' : '0';
                $y = $exist ? 7 * $nb : 10;
                $this->SetFont('times', $style, $font);
                if (!$exist) {
                    $align = 'L';
                    // $this->Cell($width+10, $y, '', $border, 0);
                } else {
                    $align = 'C';
                }
                if (!$exist) {
                    $y_axis = $this->GetY();
                    $this->SetXY(0, $y_axis);
                    $this->Cell($width, $y, '', 'R', 0, $align);
                    $this->SetXY(90, $y_axis);
                    $this->Cell($width, $y, $row[$col], $border, 0, $align);
                    $counter++;
                }
            }
            if (array_key_exists('sub-categories', $row)) {
                $counter_line++;
                if ($counter_line >= ($nb / 2)) {
                    $this->SetX(0);
                    $this->SetFont('times', $style, $font);
                    $this->Cell($width, 10, $row[$col], 0, 0, $align);
                    $counter_line = -50;
                }
                $this->BuildTableMenuReport($row['sub-categories'], $fields_category, $fields_item, $width,$field_parent,$counter_line,$nb);
            } else {
                if (!$exist) {
                    $this->Ln(10);
                }
                $widthitems = 60;
                $this->SetFont('Arial', '', 10);
                foreach ($row['items'] as $row_items) {
                    $counter_line++;
                    if ($counter_line >= ($nb / 2)) {
                        $this->SetX(0);
                        $this->SetFont('times', 'I', 20);
                        $this->Cell($width, 5, $row[$field_parent], 'R', 0, 'C');
                        $counter_line = -100;
                        $counter=-100;
                    } else {
                        $this->SetX(0);
                        $this->Cell($width, 5, '', 'R', 0, $align);
                    }
                    $this->SetFont('Arial', '', 10);
                    $this->SetX(90);
                    foreach ($fields_item as $col_items) {
                        $text = is_numeric($row_items[$col_items]) && $row_items[$col_items] == 0 ? '0' : $row_items[$col_items];
                        $this->Cell($widthitems, 5, $text, 0, 0, 'L');
                    }
                    $this->Ln(5);
                }
                $counter=$counter_line>0?$nbLine/2:$counter;
            }
            if ($exist) {
                $this->SetX(50);
                $this->Cell(155, 2, '', 'B', 0, 'c');
                $this->Ln(10);
            }
        }
    }

    function BuildTableEventHistoryReport($header_event_item, $date_event, $data_event_item, $fields_event_item, $width) {
// Header
        foreach ($date_event as $row_event) {
            $this->AddPage();
            $text = wordwrap($row_event['event_name'], 30, "\n", true);
            $this->MultiCell(130, 5, 'Event Name : ' . $text);
            $this->SetXY(140, 48);
            $this->Cell(80, 5, 'Department : ' . $row_event['department_name']);
            $this->SetXY(0, 60);
            $this->Ln(10);
            $this->Cell(130, 1, 'Employee Name : ' . $row_event['employee_name']);
            $this->Cell(80, 1, 'Event Nb Invitees : ' . $row_event['event_invitees_nb']);
            $this->Ln(10);
            $this->Cell(130, 1, 'Event Date : ' . $row_event['event_date']);
            $this->Ln(10);
            $this->BuildTable($header_event_item, $data_event_item[$row_event['event_history_id']], $fields_event_item, $width);
            $this->Ln(10);
            $total_item = $row_event['sum_item'] == 0 ? '0' : $row_event['sum_item'];
            $total_price = $row_event['sum_price'] == 0 ? '0' : $row_event['sum_price'];
            $width_item = 0;
            $width_total = 0;
            if (strlen($total_price) > 12) {
                $width_item = 110;
                $width_total = 100;
            } else {
                $width_item = 130;
                $width_total = 80;
            }
            $this->Cell($width_item, 1, 'Total Items : ' . $total_item);
            $this->Cell($width_total, 1, 'Total Price : ' . $total_price);
        }
    }

    function nbLines($w, $txt) {
        //Computes the number of lines a MultiCell of width w will take
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 and $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l+=$cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                }
                else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }

}