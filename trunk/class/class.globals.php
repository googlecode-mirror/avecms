<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * Глобальный класс
 */
class AVE_Globals
{

/**
 *	ВНЕШНИЕ МЕТОДЫ
 */

	function fetchCountries($active = '')
	{
		global $AVE_DB;

		$countries = array();
		$sql = $AVE_DB->Query("
			SELECT
				Id,
				LOWER(LandCode) AS LandCode,
				LandName,
				Aktiv,
				IstEU
			FROM " . PREFIX . "_countries
			" . (empty($active) ? "WHERE Aktiv = 1" : "") . "
			ORDER BY LandName ASC
		");
		while ($row = $sql->FetchRow()) array_push($countries, $row);

		return $countries;
	}

	function delUser($id)
	{
		global $AVE_DB;

		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_users
			WHERE Id = '" . $id . "'
		");
		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_modul_forum_userprofile
			WHERE BenutzerId = '" . $id . "'
		");
	}

	function mainSettings($field = '')
	{
		global $AVE_DB;
        static $settings = null;

		if ($settings === null)
		{
			$settings = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_settings")->FetchAssocArray();
		}

		if ($field == '') return $settings;
		return isset($settings[$field]) ? $settings[$field] : null;
	}

	function cp_mail($to, $text, $subject = '', $fromemail = '', $from = '', $content_type = '', $attach = '', $html = '')
	{
		include_once(BASE_DIR . '/class/class.phpmailer.php');
		$PHPMailer = new PHPMailer;

		$PHPMailer->ContentType = ($this->mainSettings('mail_content_type') == 'text/plain' || $content_type == 'text') ? 'text/plain' : 'text/html';
		$PHPMailer->ContentType = ($html == 1) ? 'text/html' : $PHPMailer->ContentType;
		$PHPMailer->From        = ($fromemail != '') ? $fromemail : $this->mainSettings('mail_from');
		$PHPMailer->FromName    = ($from != '') ? $from : $this->mainSettings('mail_from_name');
		$PHPMailer->Host        = $this->mainSettings('mail_host');
		$PHPMailer->Mailer      = $this->mainSettings('mail_type');
		$PHPMailer->AddAddress($to);
		$PHPMailer->Subject     = $subject;
		$PHPMailer->Body        = $text . "\n\n" . ($PHPMailer->ContentType == 'text/html' ? '' : $this->mainSettings('mail_signature'));
		$PHPMailer->Sendmail    = $this->mainSettings('mail_sendmail_path');
		$PHPMailer->WordWrap    = $this->mainSettings('mail_word_wrap');

		if (!empty($attach))
		{
			if (is_array($attach))
			{
				foreach ($attach as $attachment)
				{
					$PHPMailer->AddAttachment(BASE_DIR . '/attachments/' . $attachment);
				}
			}
			else
			{
				$PHPMailer->AddAttachment(BASE_DIR . '/attachments/' . $attach);
			}
		}

		$PHPMailer->Send();

//		if (is_array($attach)) {
//			foreach ($attach as $attachment) {
//				@unlink(BASE_DIR . '/attachments/' . $attachment);
//			}
//		}
//		else {
//			@unlink(BASE_DIR . '/attachments/' . $attach);
//		}
	}
}

?>