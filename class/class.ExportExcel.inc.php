<?php
class ExportExcel
{
	// Variable of the class
	private $titles=array();
	private $all_values=array();
	private $_filename;

	public function __construct($f_name)
	{
		$this->_filename = $f_name;
	}

	function setHeadersAndValues($hdrs,$all_vals) //set headers and query
	{
		$this->titles=$hdrs;
		$this->all_values=$all_vals;
	}
	function GenerateExcelFile() //function to generate excel file
	{

		foreach ($this->titles as $title_val)
 		{
 			$header .= $title_val."\t";
 		}
 		for($i=0;$i<sizeof($this->all_values);$i++)
 		{
 			$line = '';
 			foreach($this->all_values[$i] as $value)
			{
 				if ((!isset($value)) OR ($value == ""))
				{
 					$value = "\t";
 				} //end of if
				else
				{
 					$value = str_replace('"', '""', $value);
 					$value = '"' . $value . '"' . "\t";
 				} //end of else
 				$line .= $value;
 			} //end of foreach
 			$data .= trim($line)."\n";
 		}//end of the while
 		$data = str_replace("\r", "", $data);
		if ($data == "")
 		{
 			$data = "\n(0) Records Found!\n";
 		}
		//echo $data;
		header("Content-type: application/vnd.ms-excel");
		header("Content-Disposition: attachment; filename=$this->_filename");
		header("Pragma: no-cache");
		header("Expires: 0");
		print "$header\n$data";


	}

}
?>