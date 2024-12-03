<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'libraries/CustomPHPExcel.php');

class Excel extends CustomPHPExcel{
	public function __construct()
	{
		parent::__construct();
	}
}



?>