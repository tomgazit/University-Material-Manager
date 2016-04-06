<?php

/**
 * Split PDF file
 *
 * <p>Split all of the pages from a larger PDF files into
 * single-page PDF files.</p>
 *
 * @package FPDF required http://www.fpdf.org/
 * @package FPDI required http://www.setasign.de/products/pdf-php-solutions/fpdi/
 * @param string $filename The filename of the PDF to split
 * @param string $end_directory The end directory for split PDF (original PDF's directory by default)
 * @return void
 */
function split_pdf($filename, $end_directory = false)
{
	require_once('fpdf.php');
	require_once('fpdi.php');
	
	$end_directory = $end_directory ? $end_directory : './';
	$new_path = preg_replace('/[\/]+/', '/', $end_directory.'/'.substr($filename, 0, strrpos($filename, '/')));
	
	if (!is_dir($new_path))
	{
		// Will make directories under end directory that don't exist
		// Provided that end directory exists and has the right permissions
		mkdir($new_path, 0777, true);
	}
	
	$pdf = new FPDI();
	$pagecount = $pdf->setSourceFile($filename); // How many pages?
	
	// Split each page into a new PDF
	for ($i = 1; $i <= $pagecount; $i++) {
		$new_pdf = new FPDI();
		$new_pdf->AddPage();
		$new_pdf->setSourceFile($filename);
		$new_pdf->useTemplate($new_pdf->importPage($i));
		
		try {
			$new_filename = $end_directory.str_replace('.pdf', '', $filename).'_'.$i.".pdf";
			$new_pdf->Output($new_filename, "F");
			echo "Page ".$i." split into ".$new_filename."<br />\n";
		} catch (Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}
	}
}

// Create and check permissions on end directory!
split_pdf("2pages.pdf", 'split/');

?>