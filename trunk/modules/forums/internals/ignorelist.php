<?php
/*::::::::::::::::::::::::::::::::::::::::
 System name: cpengine
 Short Desc: Full Russian Security Power Pack
 Version: 2.0 (Service Pack 2)
 Authors:  Arcanum (php@211.ru) &  Censored!
 Date: March 18, 2008
::::::::::::::::::::::::::::::::::::::::*/

if(!defined("IGNORELIST")) exit;
if(UGROUP==2)
{
	$this->msg($GLOBALS['mod']['config_vars']['ErrornoPerm']);
}

if(isset($_GET['insert']) && (empty($_GET['insert']) && empty($_GET['BenutzerName'])))
{
	header("Location:" . $_SERVER['HTTP_REFERER']);
	exit;
}

//=======================================================
// Eintragen
//=======================================================
if((isset($_GET['insert']) && is_numeric($_GET['insert']) && $_GET['insert'] > 0) || (isset($_GET['BenutzerName']) && $_GET['BenutzerName'] != ''))
{
	if(isset($_GET['BenutzerName']) && $_GET['BenutzerName'] != '')
	{
		$_GET['insert'] = $this->fetchuserid(addslashes($_GET['BenutzerName']));
	}

	$GLOBALS['AVE_DB']->Query("INSERT INTO " . PREFIX . "_modul_forum_ignorelist
	(
		Id,
		BenutzerId,
		IgnoreId,
		Grund,
		Datum
	) VALUES (
		'',
		'" . $_SESSION['user_id'] . "',
		'" . @addslashes($_GET['insert']) . "',
		'" . @addslashes($_GET['Grund']) . "',
		'" . time() . "'
	)");
	header("Location:" . $_SERVER['HTTP_REFERER']);
	exit;
}

//=======================================================
// Austragen
//=======================================================
if(isset($_GET['remove']) && is_numeric($_GET['remove']) && $_GET['remove'] > 0)
{
	$GLOBALS['AVE_DB']->Query("DELETE FROM " . PREFIX . "_modul_forum_ignorelist WHERE IgnoreId = '" . $_GET['remove'] . "'");
	header("Location:" . $_SERVER['HTTP_REFERER']);
	exit;
}

//=======================================================
// Liste anzeigen
//=======================================================
if(isset($_GET['action']) && $_GET['action'] != '')
{
	switch($_GET['action'])
	{
		case 'showlist':
			$ignored = array();
			$sql = $GLOBALS['AVE_DB']->Query("SELECT * FROM " . PREFIX . "_modul_forum_ignorelist WHERE BenutzerId = '" . $_SESSION['user_id'] . "' ORDER BY Datum DESC");
			while($row = $sql->FetchArray())
			{
				$row['Name'] = $this->getUserName($row['IgnoreId']);
				array_push($ignored, $row);
			}

			$GLOBALS['AVE_Template']->assign('ignored', $ignored);
			$tpl_out = $GLOBALS['AVE_Template']->fetch($GLOBALS['mod']['tpl_dir'] . 'ignorelist.tpl');
			define("MODULE_CONTENT", $tpl_out);
			define("MODULE_SITE", $GLOBALS['mod']['config_vars']['IgnoreList']);
		break;
	}
}
?>