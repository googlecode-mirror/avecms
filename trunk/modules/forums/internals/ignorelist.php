<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if(!defined("IGNORELIST")) exit;

global $AVE_DB, $AVE_Template, $mod;

if(UGROUP==2)
{
	$this->msg($mod['config_vars']['ErrornoPerm']);
}

if(isset($_GET['insert']) && (empty($_GET['insert']) && empty($_GET['uname'])))
{
	header("Location:" . $_SERVER['HTTP_REFERER']);
	exit;
}

//=======================================================
// Eintragen
//=======================================================
if((isset($_GET['insert']) && is_numeric($_GET['insert']) && $_GET['insert'] > 0) || (isset($_GET['uname']) && $_GET['uname'] != ''))
{
	if(isset($_GET['uname']) && $_GET['uname'] != '')
	{
		$_GET['insert'] = $this->fetchuserid(addslashes($_GET['uname']));
	}

	$AVE_DB->Query("INSERT INTO " . PREFIX . "_modul_forum_ignorelist
	(
		id,
		uid,
		ignore_id,
		ignore_reason,
		ignore_date
	) VALUES (
		'',
		'" . $_SESSION['user_id'] . "',
		'" . @addslashes($_GET['insert']) . "',
		'" . @addslashes($_GET['reason']) . "',
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
	$AVE_DB->Query("DELETE FROM " . PREFIX . "_modul_forum_ignorelist WHERE ignore_id = '" . $_GET['remove'] . "'");
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
			$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_forum_ignorelist WHERE uid = '" . $_SESSION['user_id'] . "' ORDER BY ignore_date DESC");
			while($row = $sql->FetchArray())
			{
				$row['Name'] = $this->getUserName($row['ignore_id']);
				array_push($ignored, $row);
			}

			$AVE_Template->assign('ignored', $ignored);
			$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . 'ignorelist.tpl');
			define("MODULE_CONTENT", $tpl_out);
			define("MODULE_SITE", $mod['config_vars']['IgnoreList']);
		break;
	}
}
?>