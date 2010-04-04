<?php

/**
 * AVE.cms - Модуль Баннеры
 *
 * @package AVE.cms
 * @subpackage module_Banner
 * @filesource
 */

if(!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Баннер';
    $modul['ModulPfad'] = 'media';
    $modul['ModulVersion'] = '1.2';
    $modul['Beschreibung'] = 'Данный модуль позволяет организовать удобное управление показами рекламных баннеров на вашем сайте. Для того, чтобы отобразить рекламный баннер, разместите системный тег <strong>[mod_banner:XXX]</strong> в нужном месте вашего шаблона сайта или содержимом документа.<br>Допустимые форматы рекламных баннеров: jpg, jpeg, png, gif, swf';
    $modul['Autor'] = 'Arcanum';
    $modul['MCopyright'] = '&copy; 2007 Overdoze Team';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['AdminEdit'] = 1;
    $modul['ModulFunktion'] = 'mod_banner';
    $modul['CpEngineTagTpl'] = '[mod_banner:XXX]';
    $modul['CpEngineTag'] = '#\\\[mod_banner:(\\\d+)]#';
    $modul['CpPHPTag'] = "<?php mod_banner(''$1''); ?>";
}

if(!defined('BANNER_DIR')) define('BANNER_DIR', 'media');

/**
 * Обработка тэга модуля
 *
 * @param int $id - идентификатор категории баннеров
 */
function mod_banner($id)
{
	require_once(BASE_DIR . '/modules/' . BANNER_DIR . '/class.banner.php');
	$banner = new ModulBanner;
	$banner->displayBanner(stripslashes($id));
}

if (isset($_REQUEST['module']) && $_REQUEST['module'] == BANNER_DIR)
{
	if (is_numeric($_REQUEST['id']))
	{
		require_once(BASE_DIR . '/modules/' . BANNER_DIR . '/class.banner.php');
		$banner = new ModulBanner;
		$banner->fetch_addclick($_REQUEST['id']);
	}
}

if (defined('ACP') && !(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete'))
{
	global $AVE_Template;

	require_once(BASE_DIR . '/modules/' . BANNER_DIR . '/sql.php');
	require_once(BASE_DIR . '/modules/' . BANNER_DIR . '/class.banner.php');

	$tpl_dir   = BASE_DIR . '/modules/' . BANNER_DIR . '/templates/';
	$lang_file = BASE_DIR . '/modules/' . BANNER_DIR . '/lang/' . DEFAULT_LANGUAGE . '.txt';

	$banner = new ModulBanner;

	$AVE_Template->config_load($lang_file);
	$config_vars = $AVE_Template->get_config_vars();
	$AVE_Template->assign('config_vars', $config_vars);

	if (!empty($_REQUEST['moduleaction']))
	{
		switch($_REQUEST['moduleaction'])
		{
			case '1':
				$banner->showBanner($tpl_dir);
				break;

			case 'quicksave':
				$banner->quickSave($_REQUEST['id']);
				break;

			case 'kategs':
				$banner->bannerKategs($tpl_dir);
				break;

			case 'editbanner':
				$banner->editBanner($tpl_dir, $_REQUEST['id']);
				break;

			case 'new':
			case 'newbanner':
				$banner->newBanner($tpl_dir);
				break;

			case 'delbanner':
				$banner->deleteBanner($_REQUEST['id']);
				break;
		}
	}
}

?>