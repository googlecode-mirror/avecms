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

global $AVE_Template;

require(BASE_DIR . '/class/class.settings.php');
$AVE_Settings = new AVE_Settings;

switch($_REQUEST['action'])
{
	case '':
		if(check_permission_acp('gen_settings'))
		{
			switch ($_REQUEST['sub'])
			{
				case '':
					$AVE_Template->config_load(
						BASE_DIR . '/admin/lang/' . $_SESSION['admin_language'] . '/settings.txt',
						'settings'
					);
					$AVE_Settings->settingsShow();
					break;

				case 'case':
					$AVE_Template->config_load(
						BASE_DIR . '/admin/lang/' . $_SESSION['admin_language'] . '/settings.txt',
						'settings'
					);
					$AVE_Settings->settingsCase();
					break;	
					
				case 'save':
					if ($_REQUEST['dop']) {
						$AVE_Settings->settingsCase();
					} else {
						$AVE_Settings->settingsSave();
					}	
					header('Location:index.php?do=settings&saved=1&cp=' . SESSION);
					exit;
					break;

				case 'countries':
					if (isset($_REQUEST['save']) && $_REQUEST['save'] == 1)
					{
						$AVE_Settings->settingsCountriesSave();

						header('Location:index.php?do=settings&sub=countries&cp=' . SESSION);
						exit;
					}
					$AVE_Template->config_load(
						BASE_DIR . '/admin/lang/' . $_SESSION['admin_language'] . '/settings.txt',
						'settings'
					);
					$AVE_Settings->settingsCountriesList();
					break;

				case 'clearcache':
					if (isset($_REQUEST['templateCacheClear'])) $AVE_Template->templateCacheClear();
					if (isset($_REQUEST['templateCompiledTemplateClear'])) $AVE_Template->templateCompiledTemplateClear();
					if (isset($_REQUEST['moduleCacheClear'])) $AVE_Template->moduleCacheClear();
					if (isset($_REQUEST['sqlCacheClear'])) $AVE_Template->sqlCacheClear();
					if (isset($_REQUEST['sessionClear'])) $AVE_Template->sessionClear();
					exit;
			}
		}
		break;
}

?>