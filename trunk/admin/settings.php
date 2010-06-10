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

				case 'save':
					$AVE_Settings->settingsSave();

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
					$AVE_Template->templateCacheClear();
					$AVE_Template->templateCompiledTemplateClear();
					exit;
			}
		}
		break;
}

?>