<?php
namespace App\PDF;
require('fpdf.php');
class PDFWriter extends FPDF{
	function __construct()
	{
		parent::FPDF();
	}
}