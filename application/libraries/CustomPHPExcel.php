<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH . 'libraries/PhpSpreadsheet/Spreadsheet.php');
require_once(APPPATH . 'libraries/PhpSpreadsheet/Writer/Xlsx.php');
require_once(APPPATH . 'libraries/PhpSpreadsheet/IOFactory.php');

use PhpSpreadsheet\Spreadsheet;
use PhpSpreadsheet\Writer\Xlsx;
use PhpSpreadsheet\IOFactory;

class CustomPHPExcel {

    private $spreadsheet;

    public function __construct()
    {
        $this->spreadsheet = new Spreadsheet();
    }

    public function createNewSheet($sheetIndex = null)
    {
        $sheet = $this->spreadsheet->createSheet($sheetIndex);
        return $sheet;
    }

    public function setActiveSheetIndex($index)
    {
        $this->spreadsheet->setActiveSheetIndex($index);
    }

    public function getActiveSheet()
    {
        return $this->spreadsheet->getActiveSheet();
    }

    public function saveSpreadsheet($filename)
    {
        $writer = new Xlsx($this->spreadsheet);
        $writer->save($filename);
    }

    public function loadSpreadsheet($filename)
    {
        $this->spreadsheet = IOFactory::load($filename);
    }

    public function getProperties()
    {
        return $this->spreadsheet->getProperties();
    }

    public function setProperties($properties)
    {
        $this->spreadsheet->setProperties($properties);
    }

   
}
