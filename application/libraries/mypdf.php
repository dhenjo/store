<?php
require_once('tcpdf.php');
class MYPDF extends TCPDF {

	//Page header
//	public function Header() {
//		// Logo
//		$image_file = K_PATH_IMAGES.'logo_example.jpg';
//		$this->Image($image_file, 10, 10, 15, '', 'JPG', '', 'T', false, 300, '', false, false, 0, false, false, false);
//		// Set font
//		$this->SetFont('helvetica', 'B', 20);
//		// Title
//		$this->Cell(0, 15, '<< TCPDF Example 003 >>', 0, false, 'C', 0, '', 0, false, 'M', 'M');
//	}

	// Page footer
	public function Footer() {
		// Position at 15 mm from bottom
    $image_file = K_PATH_IMAGES."img/width-logo2.png"; 
    $this->Image($image_file, 20, 285, 10, "", "PNG", "", "T", false, 300, "", false, false, 0, false, false, false);
    
		$this->SetY(-15);
		// Set font
		$this->SetFont('helvetica', 'I', 8);
		// Page number
		$this->Cell(0, 8, 'www.nusato.com', 0, false, 'R', 0, '', 0, false, 'T', 'M');
	}
}
?>
