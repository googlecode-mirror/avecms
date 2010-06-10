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

require(BASE_DIR . '/class/class.rubs.php');
$AVE_Rubric = new AVE_Rubric;

$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_language'] . '/rubs.txt', 'rubs');

switch($_REQUEST['action'])
{
	case '' :
		if(check_permission('rubs'))
		{
			switch($_REQUEST['sub'])
			{
				case 'quicksave':
					$AVE_Rubric->quickSave();
					break;
			}
			$AVE_Rubric->rubricList();
			$AVE_Template->assign('templates', get_all_templates());
		}
		else
		{
			define('NOPERM', 1);
		}
		$AVE_Template->assign('content', $AVE_Template->fetch('rubs/rubs.tpl'));
		break;

	case 'new':
		if(check_permission('rub_neu'))
		{
			$AVE_Rubric->rubricNew();
		}
		else
		{
			define('NOPERM', 1);
		}
		break;


	case 'template':
		if(check_permission('rub_edit'))
		{
			switch($_REQUEST['sub'])
			{
				case '':
					$AVE_Rubric->rubricTemplateShow();
					break;

				case 'save':
					$Rtemplate = $_POST['RubrikTemplate'];
					$check_code = strtolower($Rtemplate);
					$ok = true;

					if(is_php_code($check_code) && !check_permission('rub_php') )
					{
						$AVE_Template->assign('php_forbidden', 1);
						$ok = false;
					}

					if(!$ok)
					{
						$AVE_Rubric->rubricTemplateShow(1);
					}
					else
					{
						$AVE_Rubric->rubricTemplateSave($_POST['RubrikTemplate']);
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
		if(check_permission('rub_loesch'))
		{
			$AVE_Rubric->rubricDelete();
		}
		else
		{
			define('NOPERM', 1);
		}
		break;

	case 'multi':
		if(check_permission('rub_multi'))
		{
			switch($_REQUEST['sub'])
			{
				case 'save':
					$AVE_Rubric->rubricCopy();
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
		if(check_permission('rub_edit'))
		{
			switch($_REQUEST['sub'])
			{
				case '':
					switch($_REQUEST['submit'])
					{
						case 'saveperms':
							$AVE_Rubric->rubricPermissionSave();
							break;

						case 'save':
							$AVE_Rubric->rubricFieldSave();
							break;

						case 'next':
							header('Location:index.php?do=rubs&action=template&Id=' . $_REQUEST['Id'] . '&cp=' . SESSION);
							exit;
//							break;

						case 'newfield':
							$AVE_Rubric->rubricFieldNew();
							break;
					}
					$AVE_Rubric->rubricFieldShow();
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