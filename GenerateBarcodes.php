<?php
/**
 * This script will make use of the open-source TCPDF library, licensed under GPL and available at http://www.tcpdf.org/
 */
require_once "tcpdf/tcpdf.php";
require_once "_Functions.php";
include "class/ChromePhp.php";

// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Erik Wilson');
$pdf->SetTitle('Scan It! Barcodes');
$pdf->SetSubject('Barcode Generator');
$pdf->SetKeywords('TCPDF, PDF, barcode, generator, scan it');

// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// set some language-dependent strings (optional)
if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
    require_once(dirname(__FILE__).'/lang/eng.php');
    $pdf->setLanguageArray($l);
}

// set font
$pdf->SetFont('helvetica', '', 11);

// add a page
$pdf->AddPage();

// ---------------------------------------------------------

// define barcode style
$style = array(
    'position' => 'C',
    'align' => 'C',
    'stretch' => false,
    'fitwidth' => true,
    'cellfitalign' => '',
    'border' => true,
    'hpadding' => 'auto',
    'vpadding' => 'auto',
    'fgcolor' => array(0,0,0),
    'bgcolor' => false, //array(255,255,255),
    'text' => true,
    'font' => 'helvetica',
    'fontsize' => 8,
    'stretchtext' => 4
);

foreach ($_POST as $value) {
    $pdf->Cell(0, 0, 'Item# ' . $value, 0, 1, 'C');
    $pdf->write1DBarcode($value .= CalcUPC($value), 'UPCA', '', '', '', 18, 0.4, $style, 'N');
    $pdf->Ln();
}

// ---------------------------------------------------------
//Close and output PDF document
$pdf->Output('ScanIt Barcodes' . date('Y-m-d H:i:s'), 'I');
