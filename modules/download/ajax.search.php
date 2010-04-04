<?php

define('ANTISPAM', 1);

define('BASE_DIR', str_replace("\\", "/", substr(dirname(__FILE__), 0, -17)));

//include_once (BASE_DIR . '/functions/func.pref.php');

$sc = (isset($_REQUEST['content']) ) ?  eregi_replace('[^ A-Za-zÀ-ßà-ÿ¨¸0-9]', '', $_REQUEST['content']) : '';

if (!empty($sc))
{
//	include_once (BASE_DIR . '/inc/db.config.php');
//	include_once (BASE_DIR . '/inc/config.php');
	include_once (BASE_DIR . '/inc/init.php');

	$kid = (!empty($_REQUEST['kid']) && is_numeric($_REQUEST['kid']) && $_REQUEST['kid'] != '9999') ? "AND b.Id = '" . $_REQUEST['kid'] . "'" : '';
	$div = '';

	$sql = $GLOBALS['AVE_DB']->Query("
		SELECT
			 a.Id,
			 a.Name,
			 b.Id as KatId
		FROM
			" . PREFIX . "_modul_download_files as a,
			" . PREFIX . "_modul_download_kat as b

		WHERE
			a.Aktiv = 1 AND
			a.KatId = b.Id AND
			(
				b.Gruppen like '" . UGROUP . "|%' OR
				b.Gruppen like '%|" . UGROUP . "' OR
				b.Gruppen like '%|" . UGROUP . "|%' OR
				b.Gruppen = '" . UGROUP . "'
			)
		AND
			(Name LIKE '%" . $sc . "%' OR Beschreibung LIKE '%" . $sc . "%')
		" . $kid . "
	");
	$num = $sql->NumRows();

	if ($num>0)
	{
		include_once (BASE_DIR . '/modules/download/funcs/func.rewrite.php');

		echo 'showDiv||';
		$div .= '<div id="cp_ajs" class="mod_download_ajaxsearchdiv">';
		while ($row = $sql->FetchRow())
		{
			$row->Link = 'index.php?module=download&amp;action=showfile&amp;file_id=' . $row->Id . '&amp;categ=' . $row->KatId;
			$row->Link = (CP_REWRITE==1) ? DownloadRewrite($row->Link) : $row->Link;
			$div .= '<a class="mod_download_ajsearch" href="' . $row->Link . '">&nbsp;' . stripslashes($row->Name) . '</a>';
		}
		$div .= '</div>';
		echo $div;
	}
	else
	{
		echo 'showDiv||';
		echo '';
	}
}
else
{
	echo 'showDiv||';
	echo '';
}

?>