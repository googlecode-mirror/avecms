<?php

/**
 * Класс работы с рассылками
 *
 * @package AVE.cms
 * @subpackage module_Newsletter
 * @author Arcanum
 * @since 2.01
 * @filesource
 */
class Newsletter
{
	/**
	 * Метод создания объекта FCKeditor
	 *
	 * @param string $val		значение поля ввода
	 * @param int $height		высота поля ввода
	 * @param string $name		наименование поля ввода
	 * @param string $toolbar	панель управления
	 * @return object			объект FCKeditor
	 */
	function _newsletterFckObjectCreate($val, $height = 300, $name, $toolbar = 'Default')
	{
		$oFCKeditor = new FCKeditor($name);
		$oFCKeditor->Height = $height;
		$oFCKeditor->ToolbarSet = $toolbar;
		$oFCKeditor->Value = $val;
		$obj = $oFCKeditor->Create();

		return $obj;
	}

	/**
	 * Метод загрузки прикреплённых файлов
	 *
	 * @param int $maxupload	максимальное размер прикреплённых файлов в Kb
	 * @return array			массив имён прикреплённых файлов
	 */
	function _newsletterFileUpload($maxupload = 1000)
	{
		global $_FILES;

		$attach = "";
		define("UPDIR", BASE_DIR . "/attachments/");
		if (isset($_FILES['upfile']) && is_array($_FILES['upfile']))
		{
			for ($i=0;$i<count($_FILES['upfile']['tmp_name']);$i++)
			{
				if ($_FILES['upfile']['tmp_name'][$i] != "")
				{
					$d_name = mb_strtolower(ltrim(rtrim($_FILES['upfile']['name'][$i])));
					$d_name = str_replace(" ", "", $d_name);
					$d_tmp = $_FILES['upfile']['tmp_name'][$i];

					$fz = filesize($_FILES['upfile']['tmp_name'][$i]);
					$mz = $maxupload*1024;;

					if ($mz >= $fz)
					{
						if (file_exists(UPDIR . $d_name))
						{
							$d_name = $this->_newsletterFileRename($d_name);
						}
						@move_uploaded_file($d_tmp, UPDIR . $d_name);
						$attach[] = $d_name;
					}
				}
			}
		}

		return $attach;
	}

	/**
	 * Метод формирования уникального имени файла
	 *
	 * @param string $file	имя файла
	 * @return string		уникальное имя файла
	 */
	function _newsletterFileRename($file)
	{
		$old = $file;
		mt_rand();
		$random = rand(1000, 9999);
		$new = $random . "_" . $old;

		return $new;
	}

	/**
	 * Метод получения прикреплённого файла
	 *
	 * @param string $file	имя файла
	 */
	function _newsletterFileGet($file)
	{
		if (!file_exists(BASE_DIR . '/attachments/' . $file))
		{
			$page = !empty($_REQUEST['page']) ? '&page=' . $_REQUEST['page'] : '';
			header("Location:index.php?do=modules&action=modedit&mod=newsletter&moduleaction=1" . $page . "&file_not_found=1&cp=" . SESSION);
			exit;
		}

		@ob_start();
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Content-Type: application/octet-stream");
		header("Content-Disposition: attachment; filename=$file");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: " . @filesize(BASE_DIR . '/attachments/' . $file));
		@set_time_limit(0);
		@readfile(BASE_DIR . '/attachments/' . $file);

		exit;
	}

	/**
	 * Вывод списка рассылок
	 *
	 * @param string $tpl_dir	путь к директории с шаблонами модуля
	 */
	function newsletterList($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		$db_extra = '';
		$nav_string = '';

		if (!empty($_REQUEST['q']))
		{
			$query = preg_replace('/[^ +_A-Za-zА-Яа-яЁёЇЄІїєі0-9-]/s', '', $_REQUEST['q']);
			$db_extra = " WHERE newsletter_title LIKE '%{$query}%' OR newsletter_message LIKE '%{$query}%' ";
			$nav_string = "&q={$query}";
		}

		$num = $AVE_DB->Query("
			SELECT COUNT(*)
			FROM " . PREFIX . "_modul_newsletter
			" . $db_extra . "
			ORDER BY id DESC
		")->GetCell();

		$limit = 20;
		@$pages = @ceil($num / $limit);
		$start = get_current_page() * $limit - $limit;

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_newsletter
			" . $db_extra . "
			ORDER BY Id DESC
			LIMIT " . $start . "," . $limit
		);
		while ($row = $sql->FetchRow())
		{
			$s = $AVE_DB->Query("
				SELECT user_group_name
				FROM " . PREFIX . "_user_groups
				WHERE user_group = " . implode(' OR user_group = ', explode(';', $row->newsletter_groups))
			);
			$e = array();
			while ($r = $s->FetchRow())
			{
				array_push($e, $r);
			}

			$row->newsletter_attach = explode(';', $row->newsletter_attach);
			$row->newsletter_groups = $e;
			array_push($items, $row);
		}

		if ($num > $limit)
		{
			$page_nav = " <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=newsletter&moduleaction=1" . $nav_string . "&page={s}&cp=" . SESSION . "\">{t}</a> ";
			$page_nav = get_pagination($pages, 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}

		$AVE_Template->assign('items', $items);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'start.tpl'));
	}

	/**
	 * Метод отображения рассылки
	 *
	 * @param string $tpl_dir	путь к директории с шаблонами модуля
	 * @param int $id			идентификатор рассылки
	 * @param string $format	формат рассылаемых писем {text|html}
	 */
	function newsletterShow($tpl_dir, $id, $format = 'text')
	{
		global $AVE_DB, $AVE_Template;

		$row = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_newsletter
			WHERE id = '" . $id . "'
		")->FetchRow();

		if ($format=='html')
		{
			$AVE_Template->assign('Editor', $this->_newsletterFckObjectCreate($row->newsletter_message,'550','text','cpengine'));
		}

		$AVE_Template->assign('row', $row);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'showtext.tpl'));
	}

	/**
	 * Метод создания новой рассылки
	 *
	 * @param string $tpl_dir	путь к директории с шаблонами модуля
	 */
	function newsletterNew($tpl_dir)
	{
		global $AVE_DB, $AVE_Template, $AVE_User;

		$tpl_out = "new.tpl";
		$attach = "";

		$AVE_Template->assign('from', get_settings("mail_from_name"));
		$AVE_Template->assign('frommail', get_settings("mail_from"));
		$AVE_Template->assign('Editor', $this->_newsletterFckObjectCreate($AVE_Template->get_config_vars('SNL_NEW_TEMPLATE') . '<br /><br />' . nl2br(get_settings("mail_signature")), '300', 'text', 'cpengine'));

		if (!empty($_REQUEST['sub']))
		{
			switch ($_REQUEST['sub'])
			{
				case 'send':
					if (empty($_SESSION['nl']))
					{
						$_SESSION['nl']['text']       = ($_REQUEST['type'] == 'text') ? str_replace('src="' . ABS_PATH, 'src="' . HOST . ABS_PATH, stripslashes($_REQUEST['text_norm'])) : str_replace('src="' . ABS_PATH, 'src="' . HOST . ABS_PATH, stripslashes($_REQUEST['text']));
						$_SESSION['nl']['format']     = ($_REQUEST['type'] == 'text') ? 'text' : 'html';
						$_SESSION['nl']['groups_id']  = implode(',', $_REQUEST['usergroups']);
						$_SESSION['nl']['groups_db']  = implode(';', $_REQUEST['usergroups']);
						$_SESSION['nl']['attach']     = $this->_newsletterFileUpload();
						$_SESSION['nl']['steps']      = (int)$_REQUEST['steps'];
						$_SESSION['nl']['del_attach'] = (int)$_REQUEST['delattach'];
						$_SESSION['nl']['titel']      = $_REQUEST['newsletter_title'];
						$_SESSION['nl']['from']       = $_REQUEST['from'];
						$_SESSION['nl']['from_mail']  = $_REQUEST['frommail'];
						$_SESSION['nl']['count']      = 0;
						$_SESSION['nl']['countall']   = $AVE_DB->Query("
							SELECT COUNT(*)
							FROM " . PREFIX . "_users
							WHERE user_group IN (0," . $_SESSION['nl']['groups_id'] . ")
						")->GetCell();
					}

					$user_exist = $AVE_DB->Query("
						SELECT 1
						FROM " . PREFIX . "_users
						WHERE user_group IN (0," . $_SESSION['nl']['groups_id'] . ")
						LIMIT " . $_SESSION['nl']['count'] . ",1"
					)->NumRows();

					if ($user_exist == 1)
					{
						$sql = $AVE_DB->Query("
							SELECT
								firstname,
								lastname,
								email
							FROM " . PREFIX . "_users
							WHERE user_group IN (0," . $_SESSION['nl']['groups_id'] . ")
							LIMIT " . $_SESSION['nl']['count'] . "," . $_SESSION['nl']['steps']
						);
						while ($row = $sql->FetchRow())
						{
							send_mail(
								$row->email,
								str_replace('%%USER%%', $row->lastname . ' ' . $row->firstname, $_SESSION['nl']['text']),
								$_SESSION['nl']['titel'],
								$_SESSION['nl']['from_mail'],
								$_SESSION['nl']['from'],
								((isset($_SESSION['nl']['format']) && $_SESSION['nl']['format'] == 'html') ? 'html' : 'text'),
								$_SESSION['nl']['attach']
							);
						}
						$_SESSION['nl']['count'] += $_SESSION['nl']['steps'];

						$prozent = round(($_SESSION['nl']['countall'] - ($_SESSION['nl']['countall'] - $_SESSION['nl']['count'])) / $_SESSION['nl']['countall'] * 100,0);
						$prozent = ($prozent > 100) ? 100 : $prozent;

						$AVE_Template->assign('prozent', $prozent);
						$AVE_Template->assign('dotcount', str_repeat('.', $_SESSION['nl']['count']));
						echo '<meta http-equiv="Refresh" content="0;URL=index.php?do=modules&action=modedit&mod=newsletter&moduleaction=new&cp=' . SESSION . '&sub=send&pop=1" />';
						$tpl_out = "progress.tpl";
					}
					else
					{
						$AVE_DB->Query("
							INSERT
							INTO " . PREFIX . "_modul_newsletter
							SET
								id                   = '',
								newsletter_format    = '" . ((isset($_SESSION['nl']['format']) && $_SESSION['nl']['format'] == 'html') ? 'html' : 'text') . "',
								newsletter_send_date = '" . time() . "',
								newsletter_sender    = '" . $_SESSION['nl']['from'] . "',
								newsletter_title     = '" . $_SESSION['nl']['titel'] . "',
								newsletter_message   = '" . $_SESSION['nl']['text'] . "',
								newsletter_groups    = '" . $_SESSION['nl']['groups_db'] . "',
								newsletter_attach    = '" . @implode(';', $_SESSION['nl']['attach']) . "'
						");

						if (!empty($_SESSION['nl']['attach']) && (int)$_SESSION['nl']['del_attach'] == 1)
						{
							$del_files = explode(";", $_SESSION['nl']['attach']);
							foreach ($del_files as $del_file)
							{
								@unlink(BASE_DIR . "/attachments/" . $del_file);
							}
						}
						echo "<script>window.opener.location.reload();</script>";
						unset($_SESSION['nl']);
						$tpl_out = "sendok.tpl";
					}
					break;
			}
		}

		$AVE_Template->assign('usergroups', $AVE_User->userGroupListGet(2));
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . $tpl_out));
	}

	/**
	 * Метод удаления рассылки
	 *
	 */
	function newsletterDelete()
	{
		global $AVE_DB;

		foreach ($_POST['del'] as $id => $del)
		{
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_modul_newsletter
				WHERE id = '". $id ."'
			");
		}

		header("Location:index.php?do=modules&action=modedit&mod=newsletter&moduleaction=1&cp=" . SESSION);
		exit;
	}
}

?>