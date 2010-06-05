<?php

/**
 * AVE.cms - Модуль Статистика
 *
 * @package AVE.cms
 * @subpackage module_Counter
 * @filesource
 */

if(!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul = array();
    $modul['ModulName'] = 'Статистика';
    $modul['ModulPfad'] = 'counter';
    $modul['ModulVersion'] = '1.3';
    $modul['Beschreibung'] = 'Данный модуль предназначен для сбора статистики посещений страниц вашего сайта, а также дополнительных данных о посетителях. Для того, чтобы начать сбор статистики, разместите системный тег <strong>[mod_counter:XXX]</strong> на нужной вам странице или шаблоне сайта. ХХХ - это порядковый номер счетчика в системе. Для отображения статистики в публичной части, разместите системный тэг <strong>[mod_counter:show]</strong> в нужном месте Вашего шаблона.';
    $modul['Autor'] = 'Arcanum';
    $modul['MCopyright'] = '&copy; 2007 Overdoze Team';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['AdminEdit'] = 1;
    $modul['ModulFunktion'] = 'mod_counter';
    $modul['CpEngineTagTpl'] = '[mod_counter:XXX]';
    $modul['CpEngineTag'] = '#\\\[mod_counter:(\\\d+)(-show)*]#';
    $modul['CpPHPTag'] = "<?php mod_counter(''$1'', ''$2''); ?>";
}

/**
 * Функция сбора и отображения статистики
 *
 * @access public
 * @param string $counter_id цифровой идентификатор счетчика
 * и опционально строка show для отображения статистики
 */
function mod_counter($counter_id, $action = '')
{
    $counter_id = preg_replace('/\D/', '', $counter_id);

	if ($counter_id > 0 && $action == '-show')
	{
		require_once(BASE_DIR . '/modules/counter/class.browser.php');
		$counter = new Counter;

		$tpl_dir   = BASE_DIR . '/modules/counter/templates/';
		$lang_file = BASE_DIR . '/modules/counter/lang/' . $_SESSION['user_language'] . '.txt';

		$counter->counterStatisticShow($tpl_dir, $lang_file, $counter_id);
	}
	elseif ($counter_id > 0 &&
		!(empty($_SERVER['REMOTE_ADDR']) && empty($_SERVER['HTTP_CLIENT_IP'])) &&
		!(isset($_COOKIE['counter_' . $counter_id]) && $_COOKIE['counter_' . $counter_id] == '1'))
	{
		require_once(BASE_DIR . '/modules/counter/class.browser.php');
		$counter = new Counter;

		$counter->counterClientNew($counter_id);
	}
}

if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	global $AVE_Template;

	require_once(BASE_DIR . '/modules/counter/class.browser.php');
	$counter = new Counter;

	$tpl_dir   = BASE_DIR . '/modules/counter/templates/';
	$lang_file = BASE_DIR . '/modules/counter/lang/' . $_SESSION['admin_language'] . '.txt';

	switch ($_REQUEST['moduleaction'])
	{
		case '1':
			$counter->counterList($tpl_dir, $lang_file);
			break;

		case 'view_referer':
			$counter->counterRefererList($tpl_dir, $lang_file);
			break;

		case 'quicksave':
			$counter->counterSettingsSave();
			break;

		case 'new_counter':
			$counter->counterNew();
			break;
	}
}

?>