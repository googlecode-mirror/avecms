<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if(!defined("GETFILE") || (!is_numeric($_GET['f_id']) || $_GET['f_id'] < 1) ) exit;

global $AVE_DB;

$permissions = $this->getForumPermissionsByUser($_GET['f_id'], UID);

if ((@$permissions[FORUM_PERMISSION_CAN_DOWNLOAD_ATTACHMENT] == 0) && (UGROUP != 1))
{
	header("Location:index.php?module=forums");
	exit;
} else {
	@ob_start();
	$result = $AVE_DB->Query("SELECT filename, orig_name FROM " . PREFIX . "_modul_forum_attachment WHERE id = '".addslashes($_GET['file_id'])."'");
	$file = $result->FetchRow();
	$update = $AVE_DB->Query("UPDATE " . PREFIX . "_modul_forum_attachment set hits=hits+1 WHERE id='" . $_GET['file_id'] . "'");
	@ob_end_flush();
	@ob_end_clean();
	header("Cache-control: private");
	header("Content-type: application/octet-stream");
	header("Content-disposition:attachment; filename=" . str_replace(' ','',$file->orig_name));
	header("Content-Length: " . filesize(BASE_DIR . "/modules/forums/attachments/" . $file->filename));
	readfile(BASE_DIR . "/modules/forums/attachments/" . $file->filename);
	exit();
}
?>