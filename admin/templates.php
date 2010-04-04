<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @subpackage admin
 * @filesource
 */

global $AVE_DB, $AVE_Template;

if (!defined('ACP'))
{
	header('Location:index.php');
	exit;
}

$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_lang'] . '/templates.txt');
$config_vars = $AVE_Template->get_config_vars();

$AVE_Template->assign('config_vars', $config_vars);

$_REQUEST['action'] = (!isset($_REQUEST['action'])) ? '' : addslashes($_REQUEST['action']);
$formaction = (isset($_REQUEST['action']) && $_REQUEST['action'] == 'new')
	? 'index.php?do=templates&action=new&sub=savenew'
	: 'index.php?do=templates&action=edit&sub=save';
$AVE_Template->assign('formaction', $formaction);

function fetchPrefabTemplates()
{
	global $AVE_Template;

	if (checkPermission('vorlagen_neu'))
	{
		$verzname = BASE_DIR . '/inc/data/prefabs/templates';
		$dht = opendir($verzname);
		$sel_theme = '';

		while(gettype($theme = readdir($dht)) != @boolean)
		{
			if (is_file( $verzname . '/' . $theme) && $theme != '.' && $theme != '..')
			{
				$sel_theme .= '<option value="' . $theme . '">' . strtoupper(substr($theme, 0, -4)) . '</option>';
				$theme = '';
			}
		}
		$AVE_Template->assign('sel_theme', $sel_theme);

		if (!empty($_REQUEST['theme_pref']))
		{
			ob_start();
			@readfile(BASE_DIR . '/inc/data/prefabs/templates/' . $_REQUEST['theme_pref']);
			$prefab = ob_get_contents();
			ob_end_clean();
			$AVE_Template->assign('prefab', $prefab);
		}
	}
}

switch ($_REQUEST['action'])
{
	case'':
		if (checkPermission('vorlagen'))
		{
			$items   = array();
			$num_tpl = $AVE_DB->Query("
				SELECT COUNT(*)
				FROM " . PREFIX . "_templates
			")
			->GetCell();

			$page_limit = (isset($_REQUEST['set']) && is_numeric($_REQUEST['set'])) ? (int)$_REQUEST['set'] : 15;
			$seiten     = ceil($num_tpl / $page_limit);
			$set_start  = prepage() * $page_limit - $page_limit;

			if ($num_tpl > $page_limit)
			{
				$page_nav = pagenav($seiten, 'page',
					" <a class=\"pnav\" href=\"index.php?do=templates&page={s}&amp;cp=" . SESSION. "\">{t}</a> ");
				$AVE_Template->assign('page_nav', $page_nav);
			}

			$sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_templates
				LIMIT " . $set_start . "," . $page_limit . "
			");

			while ($row = $sql->FetchRow())
			{
				$row_rub = $AVE_DB->Query("
					SELECT Vorlage
					FROM " . PREFIX . "_rubrics
					WHERE Vorlage = '" . $row->Id . "'
				")
				->FetchRow();

				if (@$row_rub->Vorlage != $row->Id)
				{
					$row->can_deleted = 1;
				}

				$row->TBenutzer = getUserById($row->TBenutzer);
				array_push($items, $row);
				unset($row);
			}

			$AVE_Template->assign('items', $items);
			$AVE_Template->assign('content', $AVE_Template->fetch('templates/templates.tpl'));
		}
		else
		{
			define('NOPERM', 1);
		}
		break;


	case 'new':
		if (checkPermission('vorlagen_neu'))
		{
			$_REQUEST['sub'] = (isset($_REQUEST['sub'])) ? addslashes($_REQUEST['sub']) : '';
			switch ($_REQUEST['sub'])
			{
				case 'savenew':
					$save = true;

					$row->Template = prettyChars($_REQUEST['Template']);
					$row->Template = stripslashes($row->Template);
					$row->TplName  = stripslashes($_REQUEST['TplName']);

					if (empty($_REQUEST['TplName']) || empty($_REQUEST['Template']))
					{
						$save = false;
					}

					$check_code = strtolower($_REQUEST['Template']);
					if (isPhpCode($check_code) && checkPermission('vorlagen_php') )
					{
						$AVE_Template->assign('php_forbidden', 1);
						$save = false;
					}

					if (!$save)
					{
						fetchPrefabTemplates();
						$AVE_Template->assign('row', $row);
						$AVE_Template->assign('tags', fetchTplTags(BASE_DIR . '/inc/data/vorlage.php'));
						$AVE_Template->assign('content', $AVE_Template->fetch('templates/form.tpl'));
					}
					else
					{
						$AVE_DB->Query("
							INSERT
							INTO " . PREFIX . "_templates
							SET
								Id        = '',
								TplName   = '" . $_REQUEST['TplName'] . "',
								Template  = '" . prettyChars($_REQUEST['Template']) . "',
								TBenutzer = '" . $_SESSION['user_id'] . "',
								TDatum    = '" . time() . "'
						");

						reportLog($_SESSION['user_name'] . ' - создал шаблон (' . $_REQUEST['TplName'] . ')', 2, 2);
						header('Location:index.php?do=templates');
					}
					break;

				case '':
					fetchPrefabTemplates();
					$AVE_Template->assign('tags', fetchTplTags(BASE_DIR . '/inc/data/vorlage.php'));
					$AVE_Template->assign('content', $AVE_Template->fetch('templates/form.tpl'));
					break;
			}
		}
		else
		{
			define('NOPERM', 1);
		}
		break;


	case 'delete' :
		if (checkPermission('vorlagen_loesch'))
		{
			$Used = $AVE_DB->Query("
				SELECT Vorlage
				FROM " . PREFIX . "_rubrics
				WHERE Vorlage = '" . (int)$_REQUEST['Id'] . "'
			")
			->GetCell();

			if ($Used >= 1 || $_REQUEST['Id'] == 1)
			{
				reportLog($_SESSION['user_name'] . ' - попытка удаления основного шаблона (' . (int)$_REQUEST['Id'] . ')', 2, 2);
				header('Location:index.php?do=templates');
				exit;
			}
			else
			{
				$AVE_DB->Query("
					DELETE
					FROM " . PREFIX . "_templates
					WHERE Id = '" . (int)$_REQUEST['Id'] . "'
				");
				$AVE_DB->Query("
					ALTER
					TABLE " . PREFIX . "_templates
					PACK_KEYS = 0
					CHECKSUM = 0
					DELAY_KEY_WRITE = 0
					AUTO_INCREMENT = 1
				");
				reportLog($_SESSION['user_name'] . ' - удалил шаблон (' . (int)$_REQUEST['Id'] . ') ', 2, 2);
				header('Location:index.php?do=templates');
				exit;
			}
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'edit':
		if (checkPermission('vorlagen_edit'))
		{
			$_REQUEST['sub'] = (!isset($_REQUEST['sub'])) ? '' : addslashes($_REQUEST['sub']);
			switch ($_REQUEST['sub'])
			{
				case '':
					$row = $AVE_DB->Query("
						SELECT *
						FROM " . PREFIX . "_templates
						WHERE Id = '" . addslashes($_REQUEST['Id']) . "'
					")
					->FetchRow();

					$check_code = strtolower($row->Template);
					if (isPhpCode($check_code) && !checkPermission('vorlagen_php'))
					{
						$AVE_Template->assign('php_forbidden', 1);
						$AVE_Template->assign('read_only', 'readonly');
					}

					$AVE_Template->assign('tags', fetchTplTags(BASE_DIR . '/inc/data/vorlage.php'));

					$row->Template = prettyChars($row->Template);
					$row->Template = stripslashes($row->Template);
					$AVE_Template->assign('row', $row);
					break;

				case 'save':
					$ok = true;
					$check_code = strtolower($_REQUEST['Template']);
					if (isPhpCode($check_code) && !checkPermission('vorlagen_php') )
					{
						reportLog($_SESSION['user_name'] . ' - попытка использования PHP кода в шаблоне (' . $_REQUEST['TplName'] . ')', 2, 2);
						$AVE_Template->assign('php_forbidden', 1);
						$ok = false;
					}

					if (!$ok)
					{
						reportLog($_SESSION['user_name'] . ' - ошибка при изменении шаблона (' . $_REQUEST['TplName'] . ')', 2, 2);
						$row->Template = stripslashes($_REQUEST['Template']);
						$AVE_Template->assign('row', $row);
						$AVE_Template->assign('tags', fetchTplTags(BASE_DIR . '/inc/data/vorlage.php'));
					}
					else
					{
						reportLog($_SESSION['user_name'] . ' - изменил шаблон (' . $_REQUEST['TplName'] . ')', 2, 2);
						$AVE_DB->Query("
							UPDATE " . PREFIX . "_templates
							SET
								TplName = '" . $_REQUEST['TplName'] . "',
								Template = '" . $_REQUEST['Template'] . "'
							WHERE
								Id = '" . (int)$_REQUEST['Id'] . "'
						");
						header('Location:?do=templates');
					}
					break;
			}
			$AVE_Template->assign('content', $AVE_Template->fetch('templates/form.tpl'));
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'multi':
		if (checkPermission('vorlagen_multi'))
		{
			$_REQUEST['sub'] = (!isset($_REQUEST['sub'])) ? '' : addslashes($_REQUEST['sub']);
			$errors = array();
			switch ($_REQUEST['sub'])
			{
				case 'save':
					$ok = true;
					$row = $AVE_DB->Query("
						SELECT TplName
						FROM " . PREFIX . "_templates
						WHERE TplName = '" . addslashes($_REQUEST['TplName']) . "'
					")
					->FetchRow();

					if (@$row->TplName != '')
					{
						array_push($errors, $GLOBALS['config_vars']['TEMPLATES_EXIST']);
						$AVE_Template->assign('errors', $errors);
						$ok = false;
					}

					if ($_REQUEST['TplName'] == '')
					{
						array_push($errors, $GLOBALS['config_vars']['TEMPLATES_NO_NAME']);
						$AVE_Template->assign('errors', $errors);
						$ok = false;
					}

					if ($ok)
					{
						reportLog($_SESSION['user_name'] . ' - создал копию шаблона (' . (int)$_REQUEST['oId'] . ')', 2, 2);
						$row = $AVE_DB->Query("
							SELECT Template
							FROM " . PREFIX . "_templates
							WHERE Id = '" . (int)$_REQUEST['Id'] . "'
						")
						->FetchRow();

						$AVE_DB->Query("
							INSERT
							INTO " . PREFIX . "_templates
							SET
								Id = '',
								TplName = '" . htmlspecialchars($_REQUEST['TplName']) . "',
								Template = '" . addslashes($row->Template) . "',
								TBenutzer = '" . $_SESSION['user_id'] . "',
								TDatum = '" . time() . "'
						");
						echo '<script>window.opener.location.reload();window.close();</script>';
					}
					break;
			}
		}
		else
		{
			define('NOPERM', 1);
		}
		$AVE_Template->assign('content', $AVE_Template->fetch('templates/multi.tpl'));
		break;
}

?>