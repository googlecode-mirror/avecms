<?php

class CSVReader
{
	var $_fp;
	var $_fields;
	var $_rows;
	var $_pointer;
	var $_lf;

	function CSVReader($fp)
	{
		$this->_fp = $fp;
		$this->_pointer = 0;
		$this->_rows = array();

		$content = '';
		while (!feof($this->_fp))
		{
			$content .= fread($fp, 8096);
		}

		if (strpos($content, "\r\n") !== false)
		{
			($this->_lf = "\n") && ($content = str_replace("\r", '', $content));
		}
		elseif (strpos($content, "\n") !== false)
		{
			$this->_lf = "\n";
		}
		elseif (strpos($content, "\r") !== false)
		{
			$this->_lf = "\r";
		}
		else
		{
			$this->_lf = "\n";
		}

		$this->_rows = $this->_parse($content);
		$this->_fields = $this->_rows[0];
	}

	function FetchRow()
	{
		if ($this->_pointer >= count($this->_rows))
		{
			return(false);
		}

		$this->_pointer++;
		$row = array();
		foreach ($this->_fields as $key=>$value)
		{
			@$row[$value] = $this->_rows[$this->_pointer][$key];
		}

		return($row);
	}

	function Fields()
	{
		return($this->_fields);
	}

	function NumFields()
	{
		return(count($this->_fields));
	}

	function _parse($data)
	{
		$rows = array();
		$rows[$row_p = 0] = array();
		$col_p = 0;
		$lastc = chr(0);
		$c = chr(0);
		$nextc = chr(0);
		$in_string = false;
		$commas = array(',', ';', chr(0), "\r", "\r\n", "\n", "\"");

		// walk through data
		for ($i=0; $i<strlen($data); $i++)
		{
			$lastc = $i == 0 ? chr(0) : $data[$i-1];
			$c = $data[$i];
			$nextc = isset($data[$i+1]) ? $data[$i+1] : chr(0);

			if ($c == '"' && $lastc != '\\')
			{
				// string begin / end
				$in_string = !$in_string;
			}
			elseif (($c == ';' || $c == ',') && !$in_string)
			{
				// new field
				$col_p++;
			}
			elseif (($c == $this->_lf) && !$in_string)
			{
				// new row
				$col_p = 0;
				$rows[++$row_p] = array();
			}
			else
			{
				// data
				@$rows[$row_p][$col_p] .= $c;
			}
		}
		//print_r($rows);
		return($rows);
	}
}

?>