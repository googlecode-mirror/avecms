<?php

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = '¬опрос/ответ';
    $modul['ModulPfad'] = 'faq';
    $modul['ModulVersion'] = '1.0';
    $modul['description'] = 'ћодуль создани€ раширенной справочной системы на основе тегов.';
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
	$Faq = new Faq;

	$tpl_dir   = BASE_DIR . '/modules/faq/templates/';

	$Faq->faqShow($tpl_dir, $id);
}

// admin edit
if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	require_once(BASE_DIR . '/modules/faq/class.faq.php');
	$Faq = new Faq;

	$tpl_dir   = BASE_DIR . '/modules/faq/templates/';
	$lang_file = BASE_DIR . '/modules/faq/lang/' . $_SESSION['user_language'] . '.txt';

	$AVE_Template->config_load($lang_file);

	switch ($_REQUEST['moduleaction'])
	{
		case '1':
			$Faq->faqList($tpl_dir);
			break;

		case 'new':
			$Faq->faqNew();
			break;

		case 'del':
			$Faq->faqDelete();
			break;

		case 'save':
			$Faq->faqListSave();
			break;

		case 'questlist':
			$Faq->faqQuestList($tpl_dir);
			break;

		case 'questedit':
			$Faq->faqQuestEdit($tpl_dir);
			break;

		case 'questsave':
			$Faq->faqQuestSave();
			break;

		case 'questdel':
			$Faq->faqQuestDelete();
			break;
	}
}

?>