<?php

/**
 * AVE.cms - Модуль Поиск
 *
 * @package AVE.cms
 * @subpackage module_Search
 * @since 1.4
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Поиск';
    $modul['ModulPfad'] = 'search';
    $modul['ModulVersion'] = '2.0';
    $modul['description'] = 'Данный модуль позволяет организвать поиск необходимой информации на вашем сайте. Поиск информации осуществляется как по заголовкам документов, так и по содержимому. Для того, чтобы вывести форму для поиска на вашем сайте, разместите системный тег <strong>[mod_search]</strong> в нужном месте вашего шаблона сайта.';
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

function mod_search()
{
	global $AVE_Template;

	$AVE_Template->display(BASE_DIR . '/modules/search/templates/form.tpl');
}

if (isset($_REQUEST['module']) && $_REQUEST['module'] == 'search')
{
	global $stemmer;

	if (! @require_once(BASE_DIR . '/modules/search/class.search.php')) module_error();
	if (! @require_once(BASE_DIR . '/modules/search/class.porter.php')) module_error();

	$tpl_dir   = BASE_DIR . '/modules/search/templates/';
	$lang_file = BASE_DIR . '/modules/search/lang/' . $_SESSION['user_language'] . '.txt';

	$search = new Search;
	$stemmer = new Lingua_Stem_Ru();

	$search->searchResultGet($tpl_dir, $lang_file);
}

if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	if (! (is_file(BASE_DIR . '/modules/search/class.search.php') &&
		@require_once(BASE_DIR . '/modules/search/class.search.php'))) module_error();

	$tpl_dir   = BASE_DIR .'/modules/search/templates/';
	$lang_file = BASE_DIR .'/modules/search/lang/' . $_SESSION['admin_language'] . '.txt';

	$search = new Search;

	$AVE_Template->config_load($lang_file);

	switch ($_REQUEST['moduleaction'])
	{
		case '1':
			$search->searchWordsShow($tpl_dir);
			break;

		case 'delwords':
			$search->searchWordsDelete();
			break;
	}
}

?>