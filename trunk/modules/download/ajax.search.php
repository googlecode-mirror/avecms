<?php

$response = '';
$query_string = (isset($_REQUEST['ajq']))
	? preg_replace('/[^ A-Za-zА-Яа-яЁёЇЄІїєі0-9]/i', '', $_REQUEST['ajq'])
	: '';

if (strlen($query_string) > 2)
{
	define('BASE_DIR', str_replace("\\", "/", dirname(dirname(dirname(__FILE__)))));

	require(BASE_DIR . '/inc/init.php');

	$where_category_id = '';
	if (!empty($_REQUEST['cid']) && (int)$_REQUEST['cid'] > 0)
	{
		$where_category_id = "AND b.Id = '" . (int)$_REQUEST['cid'] . "'";
	}

	$sql = $GLOBALS['AVE_DB']->Query("
		SELECT
			 a.Id,
			 a.Name,
			 b.Id as KatId
		FROM
			" . PREFIX . "_modul_download_files as a,
			" . PREFIX . "_modul_download_kat as b

		WHERE
			a.status = 1 AND
			a.KatId = b.Id AND
			(
				b.user_group LIKE '" . UGROUP . "|%' OR
				b.user_group LIKE '%|" . UGROUP . "' OR
				b.user_group LIKE '%|" . UGROUP . "|%' OR
				b.user_group = '" . UGROUP . "'
			)
		AND
			(
				Name LIKE '%" . $query_string . "%' OR
				description LIKE '%" . $query_string . "%'
			)
		" . $where_category_id . "
	");
	$num = $sql->NumRows();

	if ($num > 0)
	{
		$response .= '<div id="cp_ajs" class="mod_download_ajaxsearchdiv">';
		while ($row = $sql->FetchRow())
		{
			$response .= '<a class="mod_download_ajsearch" href="index.php'
				. '?module=download&amp;action=showfile&amp;file_id=' . $row->Id
				. '&amp;categ=' . $row->KatId . '">' . stripslashes($row->Name)
				. '</a>';
		}
		$response .= '</div>';

		if (REWRITE_MODE)
		{
			require(BASE_DIR . '/modules/download/funcs/func.rewrite.php');
			$response = DownloadRewrite($response);
		}
	}
}

echo 'showDiv||', $response;

?>