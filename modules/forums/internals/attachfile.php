<?php

/**
 * 
 *
 * @package AVE.cms
 * @subpackage module_Forums
 * @filesource
 */
if(!defined("ATTACHFILE")) exit;

global $AVE_DB, $AVE_Template, $mod;

if(isset($_REQUEST['action']) && $_REQUEST['action']=="shopstart")
{
	unset($_REQUEST['action']);
}
function findFileType($param)
{
	switch($param['t'])
	{
		case 'application/x-zip-compressed' : $ft = "ZIP"; break;
		case 'application/x-rar-compressed' : $ft = "RAR"; break;
		case 'application/pdf' : $ft = "PDF"; break;
		case 'application/msword' : $ft = "DOC"; break;
		case 'application/postscript' : $ft = "AI, EPS"; break;
		case 'application/rtf' : $ft = "RTF"; break;
		case 'application/vnd.ms-powerpoint' : $ft = "PPS (Powerpoint)"; break;
		case 'application/vnd.rn-realplayer' : $ft = "RM (Audio &amp; Video)"; break;
		case 'application/winhlp' : $ft = "HLP"; break;
		case 'application/x-gtar' : $ft = "GTAR"; break;
		case 'application/x-gzip' : $ft = "GZ, GZIP, TGZ"; break;
		case 'application/x-javascript' : $ft = "JS"; break;
		case 'application/x-latex' : $ft = "LTX"; break;
		case 'application/x-msdownload' : $ft = "EXE"; break;
		case 'application/x-shockwafe-flash' : $ft = "SWF"; break;
		case 'application/xml' : $ft = "XML"; break;
		case 'audio/midi' : $ft = "MIDI"; break;
		case 'audio/mpeg' : $ft = "MP3, MP2"; break;
		case 'audio/wav' : $ft = "WAV"; break;
		case 'image/bmp' : $ft = "BMP"; break;
		case 'image/jpeg' : $ft = "JPEG, JPG, JPE"; break;
		case 'image/png' : $ft = "PNG"; break;
		case 'text/comma-separated-values' : $ft = "CSV"; break;
		case 'text/css' : $ft = "CSS"; break;
		case 'text/html' : $ft = "HTM, HTML, SHTML"; break;
		case 'text/plain' : $ft = "TXT, SQL, KLP, TEX, PL, PHP, PHP3, PHP4, PHP5, ASP, ASPX"; break;
		case 'text/wml' : $ft = "WML"; break;
		case 'text/xml' : $ft = "XML"; break;
		case 'video/mpeg' : $ft = "MPEG, MPG, MPE, MLV, MPA, WMV, WMA"; break;
		case 'video/quicktime' : $ft = "QT, MOV"; break;
		case 'video/x-msvideo' : $ft = "AVI"; break;
		case 'application/vnd.ms-excel' : $ft = "XLS"; break;
		case 'image/x-photoshop' : $ft = "PSD"; break;
		default : $ft = $param['t']; break;
	}
	return $ft;
}

$AVE_Template->register_function("findFileType", "findFileType");

	if(isset($_REQUEST['toid']) && is_numeric($_REQUEST['toid']) && $_REQUEST['toid']!="")
	{
		$q_closed = "SELECT
		f.id,
		f.status AS fstatus,
		t.status AS tstatus,
		t.uid
		FROM
		" . PREFIX . "_modul_forum_forum AS f,
		" . PREFIX . "_modul_forum_topic AS t
		WHERE
		t.id = '" . $_REQUEST["toid"]  . "' AND f.id = t.forum_id";

		$r_closed = $AVE_DB->Query($q_closed);
		$closed = $r_closed->FetchRow();
		$permissions = $this->getForumPermissionsByUser($closed->id, UID);
	} else {
		$permissions = $this->getForumPermissionsByUser(addslashes($_REQUEST['fid']), UID);
	}
	if ($permissions[FORUM_PERMISSION_CAN_UPLOAD_ATTACHMENT] == 0){
		echo "<pre>permission denied</pre>";
		exit;
	}

	if (!isset($_REQUEST['action']))
	{
		$query = "SELECT filetype, filesize FROM " . PREFIX . "_modul_forum_allowed_files";
		$result = $AVE_DB->Query($query);

		$allowed_files = array();

		while ($allowed_file = $result->FetchRow())
		{
			$allowed_files[] = $allowed_file;
		}

		$AVE_Template->assign("allowed_files", $allowed_files);
		$AVE_Template->assign("pname", $mod['config_vars']['FORUMS_ATTACH_FILES']);
		$AVE_Template->assign('content', $AVE_Template->fetch($mod['tpl_dir'] . "attachment.tpl"));
		$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . "popup.tpl");
		define("MODULE_CONTENT", $tpl_out);
		define("MODULE_SITE", $mod['config_vars']['FORUMS_ATTACH_FILES']);

	}
	else
	{
		if (isset($_REQUEST['action']) && $_REQUEST['action'] == "upload")
		{
			$file_names = $_FILES['attachment']['name'];
			$tmp_file_names = $_FILES['attachment']['tmp_name'];
			$file_types = $_FILES['attachment']['type'];
			$file_sizes = $_FILES['attachment']['size'];

			//=======================================================
			// erlaubte dateitypen und die dazugehoerige
			// dateigroesse aus der datenbank holen
			//
			// Opera: image/jpeg
			// IE: image/pjpeg
			// Netscape: image/pjpeg
			//=======================================================
			$upload_dir = BASE_DIR . "/modules/forums/attachments";
			$files = array();

			$q_allowed_files = "SELECT filetype, filesize FROM " . PREFIX . "_modul_forum_allowed_files";
			$r_allowed_files = $AVE_DB->Query($q_allowed_files);

			$allowed_type = array();
			$allowed_size = array();

			while ($allowed_file = $r_allowed_files->FetchRow())
			{
				$allowed_type[] = $allowed_file->filetype;
				$allowed_size[$allowed_file->filetype] = $allowed_file->filesize;
			}

			//=======================================================
			// alle hochgeschickten dateien durchgehen
			//=======================================================
			for ($i = 0; $i < count($file_names); $i++)
			{
				if ($file_names[$i]	!= "")
				{
					//=======================================================
					// Einige Browser haben das Problem, den Mime-Typ der Dateien richtig
					// zu deuten. Deshalb versuchen wir nun hier, dieses Problem zu umgehen,
					// indem wir einfach die Endung kontrollieren
					//=======================================================
					$endung_1 = substr($file_names[$i],-4);
					$endung_2 = substr($file_names[$i],-3);

					switch(strtolower($endung_1))
					{
						case '.psd': $file_types[$i] = "image/x-photoshop"; break;
						case '.rar': $file_types[$i] = "application/x-rar-compressed"; break;
						case '.zip': $file_types[$i] = "application/x-zip-compressed"; break;
						case '.pdf': $file_types[$i] = "application/pdf"; break;
						case '.bz2': $file_types[$i] = "application/bzip2"; break;
						case '.doc':
						case '.dot':
						case '.wiz':
						case '.wzs': $file_types[$i] = "application/msword"; break;
						case '.eps': $file_types[$i] = "application/postscript"; break;
						case '.pot':
						case '.ppa':
						case '.pps':
						case '.ppt':
						case '.pwz': $file_types[$i] = "application/vnd.ms-powerpoint"; break;
						case '.rtf': $file_types[$i] = "application/rtf"; break;
						case '.rnx': $file_types[$i] = "application/vnd.rn-realmedia"; break;

						case '.hlp': $file_types[$i] = "hlp"; break;
						case 'gtar': $file_types[$i] = "application/x-gtar"; break;
						case 'gzip':
						case '.tgz': $file_types[$i] = "application/x-gzip"; break;
						case '.lnx': $file_types[$i] = "application/x-latex"; break;
						case '.exe': $file_types[$i] = "application/x-msdownload"; break;
						case '.swf': $file_types[$i] = "application/x-shockwafe-flash"; break;
						case '.xml': $file_types[$i] = "application/xml"; break;
						case 'midi': $file_types[$i] = "audio/midi"; break;
						case '.mp3':
						case '.mp2':
						case 'mpga': $file_types[$i] = "audio/mpeg"; break;
						case '.wav': $file_types[$i] = "audio/wav"; break;
						case '.bmp': $file_types[$i] = "audio/wav"; break;
						case '.gif': $file_types[$i] = "image/gif"; break;
						case 'jpeg':
						case '.jpg':
						case '.jpe': $file_types[$i] = "image/jpeg"; break;
						case '.png': $file_types[$i] = "image/png"; break;
						case '.tif':
						case 'tiff': $file_types[$i] = "image/tiff"; break;
						case '.ico': $file_types[$i] = "image/x-icon"; break;
						case '.csv': $file_types[$i] = "text/comma-separated-values"; break;
						case '.css': $file_types[$i] = "text/css"; break;
						case '.htm':
						case 'html':
						case 'shtml': $file_types[$i] = "text/html"; break;
						case '.txt':
						case '.klp':
						case '.tex':
						case '.php':
						case '.asp':
						case 'aspx':
						case 'php3':
						case 'php4':
						case 'php5':
						case '.sql': $file_types[$i] = "text/plain"; break;
						case '.xml': $file_types[$i] = "text/xml"; break;
						case 'xhtm': $file_types[$i] = "text/xhtml"; break;
						case '.wml': $file_types[$i] = "text/wml"; break;
						case 'mpeg':
						case '.mpg':
						case '.mpe':
						case '.mlv':
						case '.mpa':
						case '.wma':
						case '.wmv': $file_types[$i] = "video/mpeg"; break;
						case '.avi': $file_types[$i] = "video/x-msvideo"; break;
						case '.mov': $file_types[$i] = "video/quicktime"; break;
						case '.xls': $file_types[$i] = "application/vnd.ms-excel"; break;
					}

					switch(strtolower($endung_2))
					{
						case '.ai': $file_types[$i] = "application/postscript"; break;
						case '.rm': $file_types[$i] = "application/vnd.rn-realmedia"; break;
						case '.gz': $file_types[$i] = "application/x-gzip"; break;
						case '.js': $file_types[$i] = "application/x-javascript"; break;
						case '.pl':
						case '.cc': $file_types[$i] = "text/plain"; break;
						case '.qt': $file_types[$i] = "video/quicktime"; break;
					}

					$orig_name = $file_names[$i];
					if (in_array($file_types[$i], $allowed_type))
					{
						//=======================================================
						//      filesize in KB
						//=======================================================
						if ( ($file_sizes[$i] / 1024) <= $allowed_size[$file_types[$i]])
						{
							$file_names[$i] = $this->createFilename(BASE_DIR . "/modules/forums/attachments/");
							if (move_uploaded_file($tmp_file_names[$i], $upload_dir . "/" . $file_names[$i])) 
							{
								@chmod($upload_dir . "/" . $file_names[$i],0777);

								$q_attach = "
								INSERT INTO " . PREFIX . "_modul_forum_attachment (
									id,
									orig_name,
									filename
									)
								VALUES
									(
									'',
									'$orig_name',
									'" . $file_names[$i] . "'
									)
								";

								$r_attach = $AVE_DB->Query($q_attach);
								$file['id'] = $AVE_DB->InsertId();
							} // if move_uploaded_file
						}
						else
						{
							$file['forbidden'] = true;
							$file['reason'] = $mod['config_vars']['FORUMS_ATTACH_TO_BIG'];
						}
					}
					else
					{ // if allowed file type
						$file['forbidden'] = true;
						$file['reason'] = $mod['config_vars']['FORUMS_ATTACH_WRONG'];
					}

					$file['orig_name'] = $orig_name;
					$file['file_name'] = @$prefix . $file_names[$i];
					$file['file_size'] = $file_sizes[$i];
					$file['file_type'] = $file_types[$i];
					$files[] = $file;
				} // if filename != ""
			} // for uploaded files

			$query = "SELECT filetype, filesize FROM " . PREFIX . "_modul_forum_allowed_files";
			$result = $AVE_DB->Query($query);

			$allowed_files = array();

			while ($allowed_file = $result->FetchRow())
			{
				$allowed_files[] = $allowed_file;
			}

			$AVE_Template->assign("allowed_files", $allowed_files);
			$AVE_Template->assign("files", $files);
			$AVE_Template->assign("file", $file);
			$AVE_Template->assign("ecount", @count(@$file['forbidden']));
			$AVE_Template->assign("pname", $mod['config_vars']['FORUMS_ATTACH_FILES']);
			$AVE_Template->assign('content', $AVE_Template->fetch($mod['tpl_dir'] . "attachment.tpl"));
			$tpl_out = $AVE_Template->fetch($mod['tpl_dir'] . "popup.tpl");
			define("MODULE_CONTENT", $tpl_out);
			define("MODULE_SITE", $mod['config_vars']['FORUMS_ATTACH_FILES']);
		} // if action == upload
	}
?>