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
        $this->Image(POS_ROOT . '/default/files/images/header-report.png', '', '', '250', '30');
        //$this->SetFont('Arial', '', 14);
        $this->ln(13);
        $this->Cell(300, 9, $title . ' Date:' . date("d-m-Y"), 0, 0, 'C');
        $this->ln(20);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Aller', '', 8);
        $this->SetTextColor(255, 187);
        //$this->Cell(0, 10, 'Nisma Cafeterias System', 0, 0, 'L')
        $this->Image(POS_ROOT . '/default/files/images/footer-report.png', '0', $this->GetY() + 5, '250', '10');
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