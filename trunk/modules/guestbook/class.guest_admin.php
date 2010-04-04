<?php

/**
 * Класс работы с Гостевой книгой в административной части
 *
 * @package AVE.cms
 * @subpackage module_Guestbook
 * @filesource
 */
class Guest_Module
{
	/**
	 * Метод управления настройками модуля
	 *
	 * @param string $tpl_dir путь к папке с шаблонами
	 */
	function settings($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		switch ($_REQUEST['sub'])
		{
			case '' :
				// Если в запросе не пришел параметр на сохранение, тогда
				// получаем все настройки для модуля и передаем их в шаблон
				$row = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_guestbook_settings")->FetchRow();
				$AVE_Template->assign('settings', $row);

				// Получеам список последних добавленных сообщений
				$limit = (!empty ($_REQUEST['pp']) && is_numeric($_REQUEST['pp'])) ? $_REQUEST['pp'] : '15';
				$sort = (!empty ($_REQUEST['sort'])) ? mysql_escape_string($_REQUEST['sort']) : 'desc';

				$num = $AVE_DB->Query("SELECT COUNT(*) FROM " . PREFIX . "_modul_guestbook")->GetCell();

				// Формируем навигацию между сообщениями
				if ($num > $limit)
				{
					$seiten = ceil($num / $limit);
					$AVE_Template->assign('pnav', pagenav($seiten, 'page',
						" <a class=\"page_navigation\" href=\"index.php?do=modules&action=modedit&mod=guestbook&moduleaction=1&cp=" . $sess
							. "&pp=" . $limit . "&sort=" . $_REQUEST['sort'] . "&page={s}\">{t}</a> "));
				}

				$start = prepage() * $limit - $limit;

				//Получаем сообщения которые будут выведены в зависимости от страницы
				$sql = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_modul_guestbook
					ORDER BY id " . $sort . "
					LIMIT " . $start . "," . $limit
				);
				$inserts = array();
				while ($row = $sql->FetchRow())
				{
					$row->ctime = date('m.d.y', $row->ctime);
					array_push($inserts, $row);
				}

				$AVE_Template->assign('comments_array', $inserts);
				$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'admin_conf.tpl'));
				break;

			case 'save' :
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_guestbook_settings
					SET
						spamprotect = '" . $_REQUEST['spamprotect'] . "',
						mailbycomment = '" . $_REQUEST['mailbycomment'] . "',
						maxpostlength  = '" . $_REQUEST['maxpostlength'] . "',
						spamprotect_time = '" . $_REQUEST['spamprotect_time'] . "',
						entry_censore = '" . $_REQUEST['entry_censore'] . "',
						smiles = '" . $_REQUEST['ensmiles'] . "',
						bbcodes = '" . $_REQUEST['enbbcodes'] . "',
						mailsend = '" . $_REQUEST['mailsend'] . "',
						smiliebr = '" . $_REQUEST['sbr'] . "'
				");
				header('Location:index.php?do=modules&action=modedit&mod=guestbook&moduleaction=1&cp=' . $sess);
				break;
		}
	}

	/**
	 * Метод управления сообщениями (активация, удаление и т.д.)
	 *
	 */
	function edit_massage()
	{
		global $AVE_DB;

		if (count($_POST['author']) > 0)
		{
			foreach ($_POST['author'] as $id => $author)
			{
				$gisa = ($_POST['is_active'][$id] != '') ? ",is_active = '" . $_POST['is_active'][$id] . "'" : '';
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_guestbook
					SET
						author = '" . $_POST['author'][$id] . "',
						comment = '" . $_POST['comment'][$id] . "',
						email = '" . $_POST['email'][$id] . "',
						web = '" . $_POST['web'][$id] . "',
						authfrom = '" . $_POST['authfrom'][$id] . "'
						" . $gisa . "
					WHERE
						id = '" . $id . "'
				");
			}
		}

		if (count($_POST['del']) > 0)
		{
			foreach ($_POST['del'] as $id => $del)
			{
				$AVE_DB->Query("DELETE FROM " . PREFIX . "_modul_guestbook WHERE id = '" . $id . "'");
				$AVE_DB->Query("ALTER TABLE " . PREFIX . "_modul_guestbook PACK_KEYS = 0 CHECKSUM = 0 DELAY_KEY_WRITE = 0 AUTO_INCREMENT = 1");
			}
		}

		header('Location:index.php?do=modules&action=modedit&mod=guestbook&moduleaction=1&cp=' . $sess);
	}
}

?>