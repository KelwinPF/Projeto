<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pdf{
	public function __construct(){
	require_once 'dompdf/autoload.inc.php';

	$dompdf = new Dompdf\Dompdf();
	$CI =& get_instance();
	$CI->dompdf = $pdf;

	}

}