<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @subpackage admin
 * @filesource
 */

if(!defined('ACP'))
{
	header('Location:index.php');
	exit;
}

include_once(BASE_DIR . '/class/class.rubs.php');
$AVE_Rubric = new AVE_Rubric;

//$AVE_Rubric->showRubs(1);
$AVE_Template->assign('navi', $AVE_Template->fetch('navi/navi.tpl'));

$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_lang'] . '/rubs.txt', 'rubs');
//$config_vars = $AVE_Template->get_config_vars();
//$AVE_Template->assign('config_vars', $config_vars);

$_REQUEST['sub']    = (!isset($_REQUEST['sub']))    ? '' : $_REQUEST['sub'];
$_REQUEST['action'] = (!isset($_REQUEST['action'])) ? '' : $_REQUEST['action'];
$_REQUEST['submit'] = (!isset($_REQUEST['submit'])) ? '' : $_REQUEST['submit'];

switch($_REQUEST['action'])
{
	case '' :
		if(checkPermission('rubs'))
		{
			switch($_REQUEST['sub'])
			{
				case 'quicksave':
					$AVE_Rubric->quickSave();
					break;
			}
			$AVE_Rubric->showRubs();
			$AVE_Template->assign('templates', getAllTemplates());
		}
		else
		{
			define('NOPERM', 1);
		}
		$AVE_Template->assign('content', $AVE_Template->fetch('rubs/rubs.tpl'));
		break;

	case 'new':
		if(checkPermission('rub_neu'))
		{
			$AVE_Rubric->newRub();
		}
		else
		{
			define('NOPERM', 1);
		}
		break;


	case 'template':
		if(checkPermission('rub_edit'))
		{
			switch($_REQUEST['sub'])
			{
				case '':
					$AVE_Rubric->showRubTpl();
					break;

				case 'save':
					$Rtemplate = $_POST['RubrikTemplate'];
					$check_code = strtolower($Rtemplate);
					$ok = true;

					if(isPhpCode($check_code) && !checkPermission('rub_php') )
					{
						$AVE_Template->assign('php_forbidden', 1);
						$ok = false;
					}

					if(!$ok)
					{
						$AVE_Rubric->showRubTpl(1);
					}
					else
					{
						$AVE_Rubric->saveRubTpl($_POST['RubrikTemplate']);
					}
					break;
			}
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'delete':
		if(checkPermission('rub_loesch'))
		{
			$AVE_Rubric->delRub();
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'multi':
		if(checkPermission('rub_multi'))
		{
			switch($_REQUEST['sub'])
			{
				case 'save':
					$AVE_Rubric->duplicate();
					break;
			}
		}
		else
		{
			define('NOPERM', 1);
		}
		$AVE_Template->assign('content', $AVE_Template->fetch('rubs/multi.tpl'));
		break;

	case 'edit':
		if(checkPermission('rub_edit'))
		{
			switch($_REQUEST['sub'])
			{
				case '':
					switch($_REQUEST['submit'])
					{
						case 'saveperms':
							$AVE_Rubric->savePerms();
							break;

						case 'save':
							$AVE_Rubric->saveFields();
							break;

						case 'next':
							header('Location:index.php?do=rubs&action=template&Id=' . $_REQUEST['Id'] . '&cp=' . SESSION);
							exit;
							break;

						case 'newfield':
							$AVE_Rubric->newField();
							break;
					}
					$AVE_Rubric->fetchRubDetails();
					break;
			}
		}
		else
		{
			define('NOPERM', 1);
		}
		break;
}

?>