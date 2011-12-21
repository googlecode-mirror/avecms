<?php

class DataExport
{
	var $id;
	var $db;
	var $groups;
	var $separator;
	var $enclosed;
	var $cutter;

	function  DataExportDownload($datstring, $datname, $dattype, $extra = '0')
	{
		$filetype = 'application/octet-stream';
		header('Content-Type: ' . $dattype);
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Content-Disposition: attachment; filename="' . $datname . '"');
		if ($extra != 1) header('Content-Length: ' . mb_strlen($datstring));
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');
		echo $datstring;
		exit;
	}

	// ========================================================
	// Generelle Exportfunktion
	// ========================================================
	function Export($filename, $table = '', $format, $groups = '', $limit = '', $start = '')
	{
		global $AVE_DB;

		switch($table)
		{
			case 'user':
				$whichgroups_pre = " OR user_group = " . @implode(" OR user_group = ", $groups);
				$whichgroups = " AND (user_group = " . $groups[0] . " " . $whichgroups_pre . ")";
				$sql = $AVE_DB->Query("SELECT *  FROM " . PREFIX . "_users WHERE user_group != 0 " . $whichgroups);
				break;

			case 'orders':
				$sql = $AVE_DB->Query("SELECT *  FROM  " . PREFIX . "_modul_shop_bestellungen");
				break;

			case 'articles':
				$whichgroups_pre = " OR KatId = " . @implode(" OR KatId = ", $groups);
				$whichgroups = " AND (KatId = " . $groups[0] . " " . $whichgroups_pre . ")";
				$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_shop_artikel WHERE KatId != '0' " . $whichgroups);
				break;
		}

		$separator = ($_REQUEST['separator'] != '') ? stripslashes($_REQUEST['separator']) : ";";
		$enclosed  = ($_REQUEST['enclosed'] != '')  ? stripslashes($_REQUEST['enclosed'])  : "\"";
		$cutter    = ($_REQUEST['cutter'] != '')    ? stripslashes($_REQUEST['cutter'])    : "\r\n";

		$cutter  = str_replace("\\r", "\015", $cutter);
		$cutter  = str_replace("\\n", "\012", $cutter);
		$cutter  = str_replace("\\t", "\011", $cutter);
		$xoutput = '';

		// ========================================================
		// Hier wird in die 1. Zeile die Feldnamen gesetzt, wenn angefordert
		// ========================================================
		if (isset($_REQUEST['showcsvnames']) && $_REQUEST['showcsvnames'] == 'yes')
		{
			$fieldcount = $sql->NumFields();
			for ($i=0; $i<$fieldcount; $i++)
			{
				$xoutput .= $enclosed . $sql->FieldName($i) . $enclosed . $separator;
			}
			$xoutput .= '' . $cutter;
		}

		while ($row = $sql->FetchRow())
		{
			foreach ($row as $key=>$val)
			{
				$val = str_replace("\r\n", "\n", $val);
				$xoutput .= ($val == '') ? $separator : $enclosed . addslashes($val) . $enclosed . $separator;
				//$xoutput .= $enclosed . $val . $enclosed . $separator;
			}
			$xoutput .= $cutter;
		}
		// Hier erfolgt der Download
		$xoutput = str_replace(array("\";\r\n", "\";\n"), "\"\r\n", $xoutput);
		$header = ($format == 'txt') ? 'text/plain' : 'text/csv';
		$this->DataExportDownload($xoutput, '' . $filename . '.' . $format . '', $header, 1);
	}
}

?>