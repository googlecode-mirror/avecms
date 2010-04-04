<?php

if(!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'ѕоиск';
    $modul['ModulPfad'] = 'search';
    $modul['ModulVersion'] = '1.0';
    $modul['Beschreibung'] = 'ƒанный модуль позвол€ет организвать поиск необходимой информации на вашем сайте. ѕоиск информации осуществл€етс€ как по заголовкам документов, так и по содержимому. ƒл€ того, чтобы вывести форму дл€ поиска на вашем сайте, разместите системный тег <strong>[mod_search]</strong> в нужном месте вашего шаблона сайта.';
    $modul['Autor'] = 'Arcanum';
    $modul['MCopyright'] = '&copy; 2007 Overdoze Team';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['ModulTemplate'] = 1;
    $modul['AdminEdit'] = 1;
    $modul['ModulFunktion'] = 'mod_search';
    $modul['CpEngineTagTpl'] = '[mod_search]';
    $modul['CpEngineTag'] = '#\\\[mod_search]#';
    $modul['CpPHPTag'] = '<?php mod_search(); ?>';
}

function mod_search() {
//	if(!@require_once(BASE_DIR . '/modules/search/class.search.php')) moduleError();
//
//	$tpl_dir = BASE_DIR . '/modules/search/templates/';
//	$lang_file = BASE_DIR . '/modules/search/lang/' . DEFAULT_LANGUAGE . '.txt';
//	$search = new Search;
//	$search->fetchForm($tpl_dir, $lang_file);
	global $AVE_Template;

	$AVE_Template->assign('type_search', isset($_REQUEST['ts']) ? $_REQUEST['ts'] : '0');
	$AVE_Template->display(BASE_DIR . '/modules/search/templates/form.tpl');
}

if(isset($_REQUEST['module']) && $_REQUEST['module'] == 'search') {
	if(!@require_once(BASE_DIR . '/modules/search/class.search.php')) moduleError();
	if(!@require_once(BASE_DIR . '/modules/search/class.porter.php')) moduleError();

	$tpl_dir = BASE_DIR . '/modules/search/templates/';
	$lang_file = BASE_DIR . '/modules/search/lang/' . DEFAULT_LANGUAGE . '.txt';
	$search = new Search;
	$search->getSearchResults($tpl_dir, $lang_file);
}

if(defined('ACP') && !(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete')) {
	global $AVE_Template;

	require_once(BASE_DIR . '/modules/search/sql.php');
	if(!@require_once(BASE_DIR . '/modules/search/class.search.php')) moduleError();

	$tpl_dir   = BASE_DIR .'/modules/search/templates/';
	$lang_file = BASE_DIR .'/modules/search/lang/' . $_SESSION['admin_lang'] . '.txt';

	$search = new Search;

	$AVE_Template->config_load($lang_file);
	$config_vars = $AVE_Template->get_config_vars();
	$AVE_Template->assign('config_vars', $config_vars);

	if(!empty($_REQUEST['moduleaction'])) {
		switch($_REQUEST['moduleaction']) {
			case '1':
				$search->showWords($tpl_dir);
				break;

			case 'delwords':
				$search->delWords();
				break;
		}
	}
}
?>