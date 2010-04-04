<?php

if(!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = '¬опрос/ответ';
    $modul['ModulPfad'] = 'faq';
    $modul['ModulVersion'] = '1.0';
    $modul['Beschreibung'] = 'ћодуль создани€ раширенной справочной системы на основе тегов.';
    $modul['Autor'] = 'Freeon';
    $modul['MCopyright'] = '&copy; 2007-2008 Overdoze Team';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['AdminEdit'] = 1;
    $modul['ModulFunktion'] = 'mod_faq';
    $modul['CpEngineTagTpl'] = '[mod_faq:XXX]';
    $modul['CpEngineTag'] = '#\\\[mod_faq:(\\\d+)]#';
    $modul['CpPHPTag'] = "<?php mod_faq(''$1''); ?>";
}

// show faq
function mod_faq($id)
{
	require_once(BASE_DIR . '/modules/faq/class.faq.php');

	$tpl_dir   = BASE_DIR . '/modules/faq/templates/';
	$lang_file = BASE_DIR . '/modules/faq/lang/' . DEFAULT_LANGUAGE . '.txt';
	faq::ShowFaq($tpl_dir, stripslashes($id));
}

// admin edit
if(defined('ACP') && !(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete'))
{
	require_once(BASE_DIR . '/modules/faq/sql.php');
	require_once(BASE_DIR . '/modules/faq/class.faq.php');

	$tpl_dir   = BASE_DIR . '/modules/faq/templates/';
	$lang_file = BASE_DIR . '/modules/faq/lang/' . DEFAULT_LANGUAGE . '.txt';

	$GLOBALS['AVE_Template']->config_load($lang_file);
	$config_vars = $GLOBALS['AVE_Template']->get_config_vars();
	$GLOBALS['AVE_Template']->assign('config_vars', $config_vars);

	if(isset($_REQUEST['moduleaction']) && $_REQUEST['moduleaction'] != '')
	{
		switch($_REQUEST['moduleaction'])
		{
			case '1':
				faq::faqList($tpl_dir);
				break;

			case 'add':
				faq::Addfaq();
				break;

			case 'del':
				faq::Delfaq();
				break;

			case 'savelist':
				faq::SaveList();
				break;

			case 'edit':
				faq::Editfaq($tpl_dir);
				break;

			case 'saveedit':
				faq::Savequest();
				break;
			case 'edit_quest':
				faq::edit_quest($tpl_dir);
				break;
			case 'del_quest':
				faq::del_quest();
				break;
		}
	}
}

?>