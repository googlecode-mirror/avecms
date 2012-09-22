<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if(!defined("BASE_DIR") || !is_numeric(UGROUP)) exit;

global $AVE_DB;

$extra = ((!is_mod($_REQUEST['toid'])) && (UGROUP != 1)) ? " AND opened='1'" : "";

$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_forum_post WHERE topic_id = '".addslashes($_REQUEST['toid'])."' $extra  order by id DESC limit 5");
while($row = $sql->FetchRow())
{
	$row->user = $this->fetchusername($row->uid);
	$row->message = ($row->use_bbcode == 1) ? $this->kcodes($row->message) : nl2br($row->message);
	if ( ($row->use_smilies == 1) && (SMILIES==1) ) $row->message = $this->replaceWithSmileys($row->message);
	$row->message = $this->badwordreplace($row->message);
	array_push($items,$row);
}
?>