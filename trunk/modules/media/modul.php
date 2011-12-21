<?php

/**
 * AVE.cms - Модуль Баннеры
 *
 * @package AVE.cms
 * @subpackage module_Banner
 * @since 1.4
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Баннер';
    $modul['ModulPfad'] = 'media';
    $modul['ModulVersion'] = '1.3';
    $modul['description'] = 'Данный модуль позволяет организовать удобное управление показами рекламных баннеров на вашем сайте. Для того, чтобы отобразить рекламный баннер, разместите системный тег <strong>[mod_banner:XXX]</strong> в нужном месте вашего шаблона сайта или содержимом документа.<br>Допустимые форматы рекламных баннеров: jpg, jpeg, png, gif, swf';
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

if (!defined('BANNER_DIR')) define('BANNER_DIR', 'media');

/**
 * Обработка тэга модуля
 *
 * @param int $banner_category_id - идентификатор категории баннеров
 */
function mod_banner($banner_category_id)
{
    if (!is_numeric($banner_category_id)) return;

    require_once(BASE_DIR . '/modules/' . BANNER_DIR . '/class.banner.php');
	$banner = new ModulBanner;
	$banner->bannerShow($banner_category_id);
}

if (isset($_REQUEST['module']) && $_REQUEST['module'] == BANNER_DIR)
{
	if (isset($_REQUEST['id']) && is_numeric($_REQUEST['id']))
	{
		require_once(BASE_DIR . '/modules/' . BANNER_DIR . '/class.banner.php');
		$banner = new ModulBanner;
		$banner->bannerClickCount($_REQUEST['id']);
	}
}

if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	require_once(BASE_DIR . '/modules/' . BANNER_DIR . '/class.banner.php');
	$banner = new ModulBanner;

	$tpl_dir   = BASE_DIR . '/modules/' . BANNER_DIR . '/templates/';
	$lang_file = BASE_DIR . '/modules/' . BANNER_DIR . '/lang/' . $_SESSION['user_language'] . '.txt';
	$AVE_Template->config_load($lang_file);

	switch ($_REQUEST['moduleaction'])
	{
		case '1':
			$banner->bannerList($tpl_dir);
			break;

		case 'quicksave':
			$banner->bannerSave($_REQUEST['id']);
			break;

		case 'category':
			$banner->bannerCategory($tpl_dir);
			break;

		case 'editbanner':
			$banner->bannerEdit($tpl_dir, $_REQUEST['id']);
			break;

		case 'new':
		case 'newbanner':
			$banner->bannerNew($tpl_dir);
			break;

		case 'delbanner':
			$banner->bannerDelete($_REQUEST['id']);
			break;
	}
}

?>