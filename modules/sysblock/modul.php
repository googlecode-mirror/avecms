<?php

/**
 * AVE.cms - Модуль Системные блоки
 *
 * @package AVE.cms
 * @subpackage module_SysBlock
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Системные блоки';
    $modul['ModulPfad'] = 'sysblock';
    $modul['ModulVersion'] = '1.0';
    $modul['Beschreibung'] = 'Данный модуль предназначен для вывода системных блоков с произвольным содержимым в шаблоне или документе.<br /><br />Можно использовать PHP и тэги модулей<br /><br />Для вывода результатов используйте системный тег<br /><strong>[mod_sysblock:XXX]</strong>';
    $modul['Autor'] = 'Mad Den';
    $modul['MCopyright'] = '&copy; 2008 Overdoze Team';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['AdminEdit'] = 1;
    $modul['ModulTemplate'] = 0;
    $modul['ModulFunktion'] = 'mod_sysblock';
    $modul['CpEngineTagTpl'] = '[mod_sysblock:XXX]';
    $modul['CpEngineTag'] = '#\\\[mod_sysblock:(\\\d+)]#';
    $modul['CpPHPTag'] = "<?php mod_sysblock(''$1''); ?>";
}

/**
 * Показать текстовый блок
 *
 * @param int $id
 */
function mod_sysblock($id)
{
	if (! @require_once(BASE_DIR . '/modules/sysblock/class.sysblock.php')) moduleError();
	sysblock::ShowSysBlock(stripslashes($id));
}

// Администрирование
if (defined('ACP') && !(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete'))
{
	require_once(BASE_DIR . '/modules/sysblock/sql.php');
	if (! @require_once(BASE_DIR . '/modules/sysblock/class.sysblock.php')) moduleError();

	$tpl_dir = BASE_DIR . '/modules/sysblock/templates/';
	$lang_file = BASE_DIR . '/modules/sysblock/lang/' . DEFAULT_LANGUAGE . '.txt';

	$GLOBALS['AVE_Template']->config_load($lang_file);

	if (!empty($_REQUEST['moduleaction']))
	{
		switch ($_REQUEST['moduleaction'])
		{
			case '1':
				sysblock::ListBlock($tpl_dir);
				break;

			case 'del':
				sysblock::DelBlock();
				break;

			case 'edit':
				sysblock::EditBlock($tpl_dir);
				break;

			case 'saveedit':
				sysblock::SaveBlock();
				break;
		}
	}
}

?>