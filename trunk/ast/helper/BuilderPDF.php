<?php

/**
 * This is the BuilderPDF
 * Designed and Developed by SEProf Team
 * Copyright (c) 2013 SEProf Inc.
 * http://seprof.com/
 * 
 */
require('include/fpdf17/fpdf.php');

class BuilderPDF extends FPDF {

    public function __construct() {
        AddFont('Aller', 'B', 'aller.php');
    }

    function Header() {
        global $title;
        $this->SetFont('Aller', 'Bold', 14);
        $this->Cell(0, 9, $title, 1, 1, 'C');
        $this->ln(20);
    }

    function Footer() {
// Page footer
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128);
        $this->Cell(0, 10, 'Nisma Cafeterias System', 0, 0, 'L');
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
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
    function BuildTable($header, $data, $fields, $width) {
// Header
        foreach ($header as $col)
            $this->Cell($width, 10, $col, 1, 0, 'C');
        $this->Ln();
// Data
        foreach ($data as $row) {
            foreach ($fields as $col)
                $this->Cell($width, 10, $row[$col], 1, 0, 'C');
            $this->Ln();
        }
    }

    function BuildTableMenuReport($header_category, $header_sub, $header_item, $data, $fields_category, $fields_item, $width) {
// Header
        $countHeader = count($header_category);
        $counter = 0;
        while ($counter < $countHeader) {
            foreach ($data as $row) {
                $this->Cell($width, 10, $header_category[$counter], 1, 0, 'C');
                $this->Ln();
                foreach ($fields_category as $col) {
                    $this->Cell($width, 10, $row[$col], 1, 0, 'C');
                    $this->Ln();
                    if (array_key_exists('sub-categories', $row)) {
                        $this->BuildTableMenuReport($header_sub, array(), $header_item, $row['sub-categories'], $fields_category, $fields_item, $width);

                        /* foreach ($header_sub as $colsub)
                          $this->Cell($width, 10, $colsub, 1, 0, 'C');
                          $this->Ln();
                          foreach ($data as $row) {
                          foreach ($fields as $col)
                          $this->Cell($width, 10, $row[$col], 1, 0, 'C');
                          $this->Ln();
                          } */
                    } else {
                        $this->BuildTable($header_item, $row['items'], $fields_item, $width);
                    }
                }
            }
            $counter++;
        }
    }

}