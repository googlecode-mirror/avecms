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
    $modul['ModulVersion'] = '1.1';
    $modul['Beschreibung'] = 'Данный модуль предназначен для вывода системных блоков с произвольным содержимым в шаблоне или документе.<br /><br />Можно использовать PHP и теги модулей<br /><br />Для вывода результатов используйте системный тег<br /><strong>[mod_sysblock:XXX]</strong>';
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
 * Обработка тега модуля
 *
 * @param int $sysblock_id идентификатор системного блока
 */
function mod_sysblock($sysblock_id)
{
	global $AVE_DB;

	if (is_numeric($sysblock_id))
	{
		
        $cache_file=BASE_DIR.'/cache/module/sysblock-'.$sysblock_id.'.cache';
        if(!file_exists(dirname($cache_file))) mkdir(dirname($cache_file),0766,true);
        if(file_exists($cache_file)) {
            $return=file_get_contents($cache_file);
       } else {
            $return = $AVE_DB->Query("
                SELECT sysblock_text
                FROM " . PREFIX . "_modul_sysblock
                WHERE id = '" . $sysblock_id . "'
                LIMIT 1
            ")->GetCell();
            file_put_contents($cache_file,$return);
        } 
		eval ('?>' . $return . '<?');
	}
}

/**
 * Администрирование
 */
if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	if (! @require_once(BASE_DIR . '/modules/sysblock/class.sysblock.php')) module_error();

	$tpl_dir   = BASE_DIR . '/modules/sysblock/templates/';
	$lang_file = BASE_DIR . '/modules/sysblock/lang/' . $_SESSION['user_language'] . '.txt';

	$AVE_Template->config_load($lang_file);

	switch ($_REQUEST['moduleaction'])
	{
		case '1':
			sysblock::sysblockList($tpl_dir);
			break;

		case 'del':
			sysblock::sysblockDelete($_REQUEST['id']);
			if(isset($_REQUEST['id'])) unlink(BASE_DIR.'/cache/module/sysblock-'.$_REQUEST['id'].'.cache'); 
			break;

		case 'edit':
			sysblock::sysblockEdit(isset($_REQUEST['id']) ? $_REQUEST['id'] : null, $tpl_dir);
			if(isset($_REQUEST['id'])) unlink(BASE_DIR.'/cache/module/sysblock-'.$_REQUEST['id'].'.cache'); 
			break;

		case 'saveedit':
			sysblock::sysblockSave(isset($_REQUEST['id']) ? $_REQUEST['id'] : null);
			if(isset($_REQUEST['id'])) unlink(BASE_DIR.'/cache/module/sysblock-'.$_REQUEST['id'].'.cache'); 
			break;
	}
}

?>