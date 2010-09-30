<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @subpackage admin
 * @filesource
 */

if (!defined('ACP'))
{
	header('Location:index.php');
	exit;
}

global $AVE_DB, $AVE_Template;

$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_language'] . '/templates.txt');

$formaction = (isset($_REQUEST['action']) && $_REQUEST['action'] == 'new')
	? 'index.php?do=templates&action=new&sub=savenew'
	: 'index.php?do=templates&action=edit&sub=save';
$AVE_Template->assign('formaction', $formaction);

function fetchPrefabTemplates()
{
	global $AVE_Template;

	if (check_permission('template_new'))
	{
		$verzname = BASE_DIR . '/inc/data/prefabs/templates';
		$dht = opendir($verzname);
		$sel_theme = '';

		while (gettype($theme = readdir($dht)) != @boolean)
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
		if (check_permission_acp('template'))
		{
			$items   = array();
			$num_tpl = $AVE_DB->Query("
				SELECT COUNT(*)
				FROM " . PREFIX . "_templates
			")->GetCell();

			$page_limit = (isset($_REQUEST['set']) && is_numeric($_REQUEST['set'])) ? (int)$_REQUEST['set'] : 15;
			$seiten     = ceil($num_tpl / $page_limit);
			$set_start  = get_current_page() * $page_limit - $page_limit;

			if ($num_tpl > $page_limit)
			{
				$page_nav = " <a class=\"pnav\" href=\"index.php?do=templates&page={s}&amp;cp=" . SESSION. "\">{t}</a> ";
				$page_nav = get_pagination($seiten, 'page', $page_nav);
				$AVE_Template->assign('page_nav', $page_nav);
			}

			$sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_templates
				LIMIT " . $set_start . "," . $page_limit . "
			");

			while ($row = $sql->FetchRow())
			{
				$inuse = $AVE_DB->Query("
					SELECT 1
					FROM
						" . PREFIX . "_rubrics AS rubric,
						" . PREFIX . "_module AS module
					WHERE
						rubric.rubric_template_id = '" . $row->Id . "' OR
						module.Template = '" . $row->Id . "'
					LIMIT 1
				")->NumRows();

				if (!$inuse) $row->can_deleted = 1;

				$row->template_author = get_username_by_id($row->template_author_id);
				array_push($items, $row);
				unset($row);
			}

			$AVE_Template->assign('items', $items);
			$AVE_Template->assign('content', $AVE_Template->fetch('templates/templates.tpl'));
		}
		break;


	case 'new':
		if (check_permission_acp('template_new'))
		{
			$_REQUEST['sub'] = (isset($_REQUEST['sub'])) ? $_REQUEST['sub'] : '';
			switch ($_REQUEST['sub'])
			{
				case 'savenew':
					$save = true;

					$row->template_text = pretty_chars($_REQUEST['template_text']);
					$row->template_text = stripslashes($row->template_text);
					$row->template_title  = stripslashes($_REQUEST['template_title']);

					if (empty($_REQUEST['template_title']) || empty($_REQUEST['template_text']))
					{
						$save = false;
					}

					$check_code = strtolower($_REQUEST['template_text']);
					if (is_php_code($check_code) && check_permission('template_php') )
					{
						$AVE_Template->assign('php_forbidden', 1);
						$save = false;
					}

					if (!$save)
					{
						fetchPrefabTemplates();
						$AVE_Template->assign('row', $row);
						$AVE_Template->assign('content', $AVE_Template->fetch('templates/form.tpl'));
					}
					else
					{
						$AVE_DB->Query("
							INSERT
							INTO " . PREFIX . "_templates
							SET
								Id                 = '',
								template_title     = '" . $_REQUEST['template_title'] . "',
								template_text      = '" . pretty_chars($_REQUEST['template_text']) . "',
								template_author_id = '" . $_SESSION['user_id'] . "',
								template_created   = '" . time() . "'
						");

						reportLog($_SESSION['user_name'] . ' - ������ ������ (' . stripslashes($_REQUEST['template_title']) . ')', 2, 2);

						header('Location:index.php?do=templates');
						exit;
					}
					break;

				case '':
					fetchPrefabTemplates();
					$AVE_Template->assign('content', $AVE_Template->fetch('templates/form.tpl'));
					break;
			}
		}
		break;


	case 'delete' :
		if (check_permission_acp('template_del'))
		{
			$Used = $AVE_DB->Query("
				SELECT rubric_template_id
				FROM " . PREFIX . "_rubrics
				WHERE rubric_template_id = '" . (int)$_REQUEST['Id'] . "'
			")->GetCell();

			if ($Used >= 1 || $_REQUEST['Id'] == 1)
			{
				reportLog($_SESSION['user_name'] . ' - ������� �������� ��������� ������� (' . (int)$_REQUEST['Id'] . ')', 2, 2);

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

				reportLog($_SESSION['user_name'] . ' - ������ ������ (' . (int)$_REQUEST['Id'] . ') ', 2, 2);

				header('Location:index.php?do=templates');
				exit;
			}
		}
		break;

	case 'edit':
		if (check_permission_acp('template_edit'))
		{
			$_REQUEST['sub'] = (!isset($_REQUEST['sub'])) ? '' : $_REQUEST['sub'];
			switch ($_REQUEST['sub'])
			{
				case '':
					$row = $AVE_DB->Query("
						SELECT *
						FROM " . PREFIX . "_templates
						WHERE Id = '" . $_REQUEST['Id'] . "'
					")->FetchRow();

					$check_code = strtolower($row->template_text);
					if (is_php_code($check_code) && !check_permission('template_php'))
					{
						$AVE_Template->assign('php_forbidden', 1);
						$AVE_Template->assign('read_only', 'readonly');
					}

					$row->template_text = pretty_chars($row->template_text);
					$row->template_text = stripslashes($row->template_text);
					$AVE_Template->assign('row', $row);
					break;

				case 'save':
					$ok = true;
					$check_code = strtolower($_REQUEST['template_text']);
					if (is_php_code($check_code) && !check_permission('template_php') )
					{
						reportLog($_SESSION['user_name'] . ' - ������� ������������ PHP ���� � ������� (' . stripslashes($_REQUEST['template_title']) . ')', 2, 2);
						$AVE_Template->assign('php_forbidden', 1);
						$ok = false;
					}

					if (!$ok)
					{
						$row->template_text = stripslashes($_REQUEST['template_text']);
						$AVE_Template->assign('row', $row);
					}
					else
					{
						reportLog($_SESSION['user_name'] . ' - ������� ������ (' . stripslashes($_REQUEST['template_title']) . ')', 2, 2);
						$AVE_DB->Query("
							UPDATE " . PREFIX . "_templates
							SET
								template_title = '" . $_REQUEST['template_title'] . "',
								template_text  = '" . $_REQUEST['template_text'] . "'
							WHERE
								Id = '" . (int)$_REQUEST['Id'] . "'
						");
						header('Location:?do=templates');
					}
					break;
			}
			$AVE_Template->assign('content', $AVE_Template->fetch('templates/form.tpl'));
		}
		break;

	case 'multi':
		if (check_permission_acp('template_multi'))
		{
			$_REQUEST['sub'] = (!isset($_REQUEST['sub'])) ? '' : $_REQUEST['sub'];
			$errors = array();
			switch ($_REQUEST['sub'])
			{
				case 'save':
					$ok = true;
					$row = $AVE_DB->Query("
						SELECT template_title
						FROM " . PREFIX . "_templates
						WHERE template_title = '" . $_REQUEST['template_title'] . "'
					")->FetchRow();

					if (@$row->template_title != '')
					{
						array_push($errors, $AVE_Template->get_config_vars('TEMPLATES_EXIST'));
						$AVE_Template->assign('errors', $errors);
						$ok = false;
					}

					if ($_REQUEST['template_title'] == '')
					{
						array_push($errors, $AVE_Template->get_config_vars('TEMPLATES_NO_NAME'));
						$AVE_Template->assign('errors', $errors);
						$ok = false;
					}

					if ($ok)
					{
						$row = $AVE_DB->Query("
							SELECT template_text
							FROM " . PREFIX . "_templates
							WHERE Id = '" . (int)$_REQUEST['Id'] . "'
						")->FetchRow();

						$AVE_DB->Query("
							INSERT
							INTO " . PREFIX . "_templates
							SET
								Id = '',
								template_title     = '" . $_REQUEST['template_title'] . "',
								template_text      = '" . addslashes($row->template_text) . "',
								template_author_id = '" . $_SESSION['user_id'] . "',
								template_created   = '" . time() . "'
						");

						reportLog($_SESSION['user_name'] . ' - ������ ����� ������� (' . (int)$_REQUEST['oId'] . ')', 2, 2);

						echo '<script>window.opener.location.reload();window.close();</script>';
					}
					break;
			}
		}

		$AVE_Template->assign('content', $AVE_Template->fetch('templates/multi.tpl'));
		break;
}

?>