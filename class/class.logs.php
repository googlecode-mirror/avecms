<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * ����� ��� ������ � ��������� ��������
 */
class AVE_Logs
{

/**
 *	��������
 */

	/**
	 * ���������� ������� �� ��������
	 *
	 * @var int
	 */
	var $_limit = 15;

/**
 *	������� ������
 */

	/**
	 * ����������� ������� ������� �������
	 *
	 */
	function showLogs()
	{
		global $AVE_DB, $AVE_Template;

		$logs = array();
		$sql = $AVE_DB->Query("SELECT *
			FROM " . PREFIX . "_log
			ORDER BY Id DESC
		");

		while ($row = $sql->FetchRow())
		{
			array_push($logs, $row);
		}

		$AVE_Template->assign('logs', $logs);
		$AVE_Template->assign('content', $AVE_Template->fetch('logs/logs.tpl'));
	}

	/**
	 * �������� ������� ������� �������
	 *
	 */
	function deleteLogs()
	{
		global $AVE_DB;

		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_log
		");
		$AVE_DB->Query("
			ALTER
			TABLE " . PREFIX . "_log
			PACK_KEYS = 0
			CHECKSUM = 0
			DELAY_KEY_WRITE = 0
			AUTO_INCREMENT = 1
		");

		reportLog($_SESSION['user_name'] . ' - ������� ������ �������', 2, 2);

		header('Location:index.php?do=logs&cp=' . SESSION);
	}

	/**
	 * ������� ������� ������� �������
	 *
	 */
	function logExport()
	{
		global $AVE_DB;

		$datstring = '';
		$dattype = 'text/csv';
		$datname = 'system_log_' . date('dmyhis', time()) . '.csv';

		$separator = ';';
		$enclosed = "\"";
		$cutter = '\r\n';

		$cutter = str_replace('\\r', '\015', $cutter);
		$cutter = str_replace('\\n', '\012', $cutter);
		$cutter = str_replace('\\t', '\011', $cutter);

		$sql = $AVE_DB->Query("SELECT *
			FROM " . PREFIX . "_log
			ORDER BY Id DESC
		");
		$fieldcount = $sql->NumFields();

		for ($it=0; $it<$fieldcount; $it++)
		{
			$datstring .= $enclosed . $sql->FieldName($it) . $enclosed . $separator;
		}
		$datstring .= $cutter;

		while ($row = $sql->FetchRow())
		{
			foreach ($row as $key => $val)
			{
				$val = str_replace("\r\n", "\n", $val);
				$val = ($key=='Zeit') ? date('d-m-Y, H:i:s', $row->Zeit) : $val;
				$datstring .= ($val == '') ? $separator : $enclosed . stripslashes($val) . $enclosed . $separator;
			}
			$datstring .= $cutter;
		}

		header('Content-Type: text/csv' . $dattype);
		header('Expires: ' . gmdate('D, d M Y H:i:s') . ' GMT');
		header('Content-Disposition: attachment; filename="' . $datname . '"');
		header('Content-Length: ' . strlen($datstring));
		header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
		header('Pragma: public');

		echo $datstring;

		reportLog($_SESSION['user_name'] . ' - ������������� ������ �������', 2, 2);

		exit;
	}
}

?>