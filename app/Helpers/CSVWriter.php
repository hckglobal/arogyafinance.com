<?php 

namespace App\Helpers;

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;

/**
 * 
 */
class CSVWriter
{

	private $writer;
	private $header;
	private $file_name;

	function __construct($header, $file_name)
	{
		ini_set('max_execution_time', 60000);
		$this->header = $header;
		$this->file_name = $file_name;
		$this->writer = WriterEntityFactory::createCSVWriter();
		$this->writer->openToBrowser($file_name.".csv"); // stream data directly to the browser
		$headerRow = WriterEntityFactory::createRowFromArray($header);
		$this->writer->addRow($headerRow);
	}
	

	/**
	 * Add a row to the report
	*/
	public function addRow($row)
	{
		$data_row = WriterEntityFactory::createRowFromArray($row);
		$this->writer->addRow($data_row);
	}

	/**
	 * Close the report
	*/
	public function close()
	{
		$this->writer->close();
	}
}