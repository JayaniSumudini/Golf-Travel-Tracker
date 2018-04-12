<?php
/**
 * Created by PhpStorm.
 * User: jayani
 * Date: 4/12/2018
 * Time: 3:38 PM
 */
require('../fpdf181/fpdf.php');

class PDF extends FPDF
{
// Page header
    function Header()
    {
        global $title;
        $s = (string)$title;
        $w = 0;
        $l = strlen($s);
        for($i=0;$i<$l;$i++)
            $w=$w+1;

        $w=$w+30;
        $this->Image('../images/logo.png',10,6,30);
        $date = date("Y/m/d");
        $this->SetX(190);
        $this->SetFont('Arial','B',15);
        $this->Cell(10,10,$date,0,2,'R');
        $this->Ln(20);
        $this->SetFont('Arial','B',15);
        $this->SetX((210 - $w) / 2);
        // Colors of frame, background and text
        $this->SetDrawColor(0, 80, 180);
        $this->SetFillColor(230, 230, 0);
        $this->SetTextColor(220, 50, 50);
        // Thickness of frame (1 mm)
        $this->SetLineWidth(1);
        // Title
        $this->Cell($w, 9, $title, 1, 1, 'C', true);
        // Line break
        $this->Ln(10);
    }
}
$pdf = new PDF();
$title = "This is your trips";
$pdf->SetTitle($title);
