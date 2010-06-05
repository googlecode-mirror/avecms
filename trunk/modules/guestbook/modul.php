<?php

/**
 * AVE.cms - Модуль Гостевая книга
 *
 * @package AVE.cms
 * @subpackage module_Guestbook
 * @filesource
 */

if (!defined('BASE_DIR'))
	exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Гостевая книга';
    $modul['ModulPfad'] = 'guestbook';
    $modul['ModulVersion'] = '0.1';
    $modul['Beschreibung'] = 'Модуль для организации на Вашем сайте интерактивного общения между пользователями.';
    $modul['Autor'] = 'Arcanum (arcanum@php.su)';
    $modul['MCopyright'] = '&copy; 2007 (Участник команды overdoze.ru)';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 0;
    $modul['AdminEdit'] = 1;
    $modul['ModulTemplate'] = 1;
    $modul['ModulFunktion'] = null;
    $modul['CpEngineTagTpl'] = '<b>Ссылка:</b> <a target="_blank" href="../index.php?module=guestbook">index.php?module=guestbook</a>';
    $modul['CpEngineTag'] = null;
    $modul['CpPHPTag'] = null;
}

if (isset ($_REQUEST['module']) && $_REQUEST['module'] == 'guestbook')
{
	//=======================================================
	// Все функции управления в публичной части
	//=======================================================
	require_once (BASE_DIR . '/functions/func.modulglobals.php');
	set_modul_globals('guestbook');

	require_once (BASE_DIR . '/modules/guestbook/class.guest.php');
	$guest = new Guest_Module_Pub;

	// Проверяем наличие библиотеки GD и функции вывода текста на изображение
	$use_securecode = false;
	if (@ extension_loaded('gd') == 1)
	{
		if (function_exists('imagettftext'))
		{
			$use_securecode = true;
			$AVE_Template->assign('use_code', 1);
			$codeid = $guest->secureCode();
		}
		else
		{
			$use_securecode = false;
		}
	}

	// Генерируем секретный код и передаем в шаблон
	if ($use_securecode)
	{
		if (!isset ($_REQUEST['action']) && $_REQUEST['action'] == '')
		{
			$AVE_Template->assign('pim', $guest->secureCode());
		}
		elseif (isset ($_REQUEST['action']) && $_REQUEST['action'] == 'new')
		{
			$securecode = $AVE_DB->Query("
				SELECT Code
				FROM " . PREFIX . "_antispam
				WHERE Id = '" . (int) $_REQUEST['pim'] . "'
				LIMIT 1
			")->GetCell();
		}
	}

	// Получаем настройки модуля и отображаем модуль в публичной части в соответствии с ними
	$gb_set = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_modul_guestbook_settings")->FetchRow();
	define('GB_CHECK', $gb_set->entry_censore);
	define('COMMENTSMILEYS', $gb_set->smiles);
	define('COMMENTSBBCODE', $gb_set->bbcodes);
	$AVE_Template->assign('maxpostlength', $gb_set->maxpostlength);
	$limit = $_REQUEST['pp'] = (!empty ($_REQUEST['pp']) && is_numeric($_REQUEST['pp'])) ? $_REQUEST['pp'] : '10';
	$_REQUEST['sort'] = (!empty ($_REQUEST['sort'])) ? $_REQUEST['sort'] : 'desc';
	$sort = mysql_escape_string($_REQUEST['sort']);

	switch ($_REQUEST['action'])
	{
		case '' :
		case 'showentries' :
			if ($_REQUEST['sort'] == 'asc')
				$ascsel = 'selected="selected"';
			if ($_REQUEST['sort'] == 'desc')
				$descsel = 'selected="selected"';
			$AVE_Template->assign('pps_array', $guest->ppsite());
			$AVE_Template->assign('dessel', $descsel);
			$AVE_Template->assign('ascsel', $ascsel);

			// Если разрешено использовать смайлы, получаем список и передаем в шаблон
			if (COMMENTSMILEYS == 1)
			{
				$smilies = $guest->listsmilies();
				$AVE_Template->assign('smilie', 1);
				$AVE_Template->assign('listemos', $smilies);
			}

			// Если разрешено использовать bbCode, передаем в шаблон разрешение
			if (COMMENTSBBCODE == 1)
			{
				$AVE_Template->assign('bbcodes', 1);
			}

			// Получаем количество сообщений и формируем постраничную навигацию
			$inserts = array();
			$num = $AVE_DB->Query("
				SELECT COUNT(*)
				FROM " . PREFIX . "_modul_guestbook
				WHERE is_active = 1
			")->GetCell();

			if ($num > $limit)
			{
				$seiten = ceil($num / $limit);
				$page_nav = " <a class=\"page_navigation\" href=\"index.php?module=guestbook&amp;pp=" . $limit . "&amp;sort=" . $_REQUEST['sort'] . "&amp;page={s}\">{t}</a> ";
				$page_nav = get_pagination($seiten, 'page', $page_nav);
				$AVE_Template->assign('pages', $page_nav);
			}

			$start = get_current_page() * $limit - $limit;

			// Получаем список всех сообщений и передаем их в шаблон для вывода
			$sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_modul_guestbook
				WHERE is_active = 1
				ORDER BY id " . $sort . "
				LIMIT " . $start . "," . $limit
			);

			while ($row = $sql->FetchRow())
			{
				$row->ctime = date('m.d.y', $row->ctime);

				// Если разрешено использовать смайлы и bbCode тогда обрабатываем все сообщения
				if (COMMENTSMILEYS == 1)
				{
					$row->comment = $guest->kcodes_comments($row->comment);
					$row->comment = $guest->dosmilies($row->comment);
				}
				else
				{
					$row->comment = $guest->kcodes_comments($row->comment);
				}
				array_push($inserts, $row);
			}

			$AVE_Template->assign('comments_array', $inserts);
			break;

		//Если в запросе пришел параметр на создание нового сообщения, тогда
		case 'new' :
			$error = false;
			// Проверяем какой защитный код был введен:
			if (($_REQUEST['scode'] != $securecode) && ($use_securecode))
			{
				$text = $guest->formtext($_POST['text'], $gb_set->maxpostlength);
				$dataString = '&gbcomment=' . $text . '&author=' . $_REQUEST['author'] . '&email=' . $_REQUEST['email'] . '&web=' . str_replace('http://', '%%webseite%%', $_REQUEST['http']) . '&from=' . $_REQUEST['from'];
				$guest->msg($GLOBALS['mod']['config_vars']['guest_wrong_scode']);
				$error = true;
			}

			// Проверяем на время между добавлением сообщения (защита от спама)
			if (($gb_set->spamprotect == 1) && (!$error))
			{
				$row = $AVE_DB->Query("
					SELECT
						ip,
						ctime
					FROM " . PREFIX . "_modul_guestbook
					WHERE ip = '" . $_SERVER['REMOTE_ADDR'] . "'
					ORDER BY id DESC
					LIMIT 1
				")->FetchRow();
				if ($row)
				{
					if (($row->ctime) + (60 * $gb_set->spamprotect_time) > time())
					{
						$guest->msg($GLOBALS['mod']['config_vars']['guest_wrong_spam']);
						$error = true;
					}
				}
			}

			// Если ошибок нет
			if (!$error)
			{
				$entry_now = (GB_CHECK == 1) ? '0' : '1';
				$text = $guest->formtext($_POST['text'], $gb_set->maxpostlength);
				if (strlen(chop($text)) < 2)
				{
					header('Location:index.php?module=guestbook');
					exit;
				}
				$AVE_DB->Query("
					INSERT
					INTO " . PREFIX . "_modul_guestbook
					SET
						id        = '',
						ctime     = '" . time() . "',
						author    = '" . strip_tags(substr($_REQUEST['author'], 0, 25)) . "',
						comment   = '" . $text . "',
						email     = '" . strip_tags(substr($_REQUEST['email'], 0, 100)) . "',
						web       = '" . strip_tags(substr($_REQUEST['http'], 0, 100)) . "',
						ip        = '" . getenv('REMOTE_ADDR') . "',
						authfrom  = '" . strip_tags(substr($_REQUEST['from'], 0, 100)) . "',
						is_active = '" . $entry_now . "'
				");

				$AVE_DB->Query("
					DELETE
					FROM " . PREFIX . "_antispam
					WHERE Code = '" . (int) $_REQUEST['scode'] . "'
				");

				//====================================================
				// Отправляем сообщение администратору на E-mail
				//====================================================
				if ($gb_set->mailbycomment == 1)
				{
					$mail = $AVE_DB->Query("
						SELECT mailsend
						FROM " . PREFIX . "_modul_guestbook_settings
						LIMIT 1
					")->GetCell();

					$SystemMail = get_settings('mail_from');
					send_mail(
						$mail,
						$text,
						$GLOBALS['mod']['config_vars']['guest_new_mail'],
						$mail,
						$GLOBALS['mod']['config_vars']['guest_pub_name'],
						$mail,
						'text',
						''
					);
				}
				//Проверяем включена ли проверка сообщений модератором и выводит то или иное сообщение
				$text_thankyou = (GB_CHECK == 1) ? $GLOBALS['mod']['config_vars']['guest_check_thanks'] : $GLOBALS['mod']['config_vars']['guest_thanks'];
				$guest->msg($text_thankyou);
				$error = true;
			}
			break;
	}

	$AVE_Template->assign('allcomments', $num);
	$tpl_out = $AVE_Template->fetch($GLOBALS['mod']['tpl_dir'] . 'guestbook.tpl');
	define('MODULE_CONTENT', $tpl_out);
}

//=======================================================
// Управление модулем в Панели управления
//=======================================================
if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	require_once (BASE_DIR . '/modules/guestbook/class.guest_admin.php');

	$tpl_dir = BASE_DIR . '/modules/guestbook/templates/';
	$lang_file = BASE_DIR . '/modules/guestbook/lang/' . $_SESSION['user_language'] . '.txt';

	$guest = new Guest_Module;
	$AVE_Template->config_load($lang_file);
	$config_vars = $AVE_Template->get_config_vars();
	$AVE_Template->assign('config_vars', $config_vars);

	switch ($_REQUEST['moduleaction'])
	{
		case '1' :
			$guest->settings($tpl_dir);
			break;

		case 'medit' :
			$guest->edit_massage();
			break;
	}
}

?>