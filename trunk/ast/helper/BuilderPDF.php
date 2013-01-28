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

    function Header() {
        global $title;
        $this->SetFont('Arial', 'B', 18);
        $this->Cell(0, 9, $title, 1, 1, 'C');
        $this->ln(5);
    }

    function Footer() {
// Page footer
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128);
        $this->Cell( 0, 10, 'Nisma Cafeterias System', 0, 0, 'L' );
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
    function BuildTable($header, $data) {
        // Header
        foreach ($header as $col)
            $this->Cell(40, 7, $col, 1);
        $this->Ln();
        // Data
        foreach ($data as $row) {
            foreach ($row as $col)
                $this->Cell(40, 6, $col, 1);
            $this->Ln();
        }
    }

}