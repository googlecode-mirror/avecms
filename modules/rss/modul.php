<?php

/**
 * AVE.cms - Модуль RSS
 *
 * @package AVE.cms
 * @subpackage module_RSS
 * @filesource
 */

if(!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'RSS потоки';
    $modul['ModulPfad'] = 'rss';
    $modul['ModulVersion'] = '1.1';
    $modul['Beschreibung'] = 'Данный модуль предзназначен для организации RSS потоков на вашем сайте.';
    $modul['Autor'] = 'Arcanum';
    $modul['MCopyright'] = '&copy; 2007-2008 Overdoze Team';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['AdminEdit'] = 1;
    $modul['ModulFunktion'] = 'mod_rss';
    $modul['CpEngineTagTpl'] = '[mod_rss:XXX]';
    $modul['CpEngineTag'] = '#\\\[mod_rss:(\\\d+)]#';
    $modul['CpPHPTag'] = "<?php mod_rss(''$1''); ?>";
}

/**
 * Обработка тэга модуля RSS
 *
 * @param int $rss_id идентификатор RSS-ленты
 */
function mod_rss($rss_id)
{
	$rss_id  = preg_replace('/\D/', '', $rss_id);

	if (is_numeric($rss_id))
	{
		echo '<a href="', ABS_PATH, 'rss/rss-', $rss_id, '.xml" target="blank"><img src="modules/rss/templates/feed.gif" border="0" title="RSS лента новостей" /></a>';
	}
}

if (isset($_REQUEST['module']) && $_REQUEST['module'] == 'rss'
	&& isset($_REQUEST['do']) && $_REQUEST['do'] == 'show')
{
	header('Location:rss/index.php?id=' . $_GET['id']);
}

if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	global $AVE_Template;

	require_once(BASE_DIR . '/modules/rss/class.rss.php');

	switch ($_REQUEST['moduleaction'])
	{
		case '1':
			$tpl_dir   = BASE_DIR . '/modules/rss/templates/';
			$lang_file = BASE_DIR . '/modules/rss/lang/' . $_SESSION['user_language'] . '.txt';
			Rss::rssList($tpl_dir, $lang_file);
			break;

		case 'add':
			Rss::rssNew();
			break;

		case 'del':
			Rss::rssDelete();
			break;

		case 'edit':
			$tpl_dir   = BASE_DIR . '/modules/rss/templates/';
			$lang_file = BASE_DIR . '/modules/rss/lang/' . $_SESSION['user_language'] . '.txt';
			Rss::rssEdit($tpl_dir, $lang_file);
			break;

		case 'saveedit':
			Rss::rssSave();
			break;
	}
}

?>