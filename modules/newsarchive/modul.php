<?php

/**
 * AVE.cms - Модуль Архив новостей
 *
 * @package AVE.cms
 * @subpackage module_Newsarchive
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Архив документов';
    $modul['ModulPfad'] = 'newsarchive';
    $modul['ModulVersion'] = '1.0';
    $modul['Beschreibung'] = 'Данный модуль предзназначен для организации архива документов по выбранным рубрикам в системе. Параметры модуля позволяют определить возможность пока пустых месяцев и ежедневное меню навигации.';
    $modul['Autor'] = 'Arcanum';
    $modul['MCopyright'] = '&copy; 2007-2008 Overdoze Team';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['ModulTemplate'] = 1;
    $modul['AdminEdit'] = 1;
    $modul['ModulFunktion'] = 'mod_newsarchive';
    $modul['CpEngineTagTpl'] = '[mod_newsarchive:XXX]';
    $modul['CpEngineTag'] = '#\\\[mod_newsarchive:(\\\d+)]#';
    $modul['CpPHPTag'] = "<?php mod_newsarchive(''$1''); ?>";
}

// Главная функция, которая отвечает за вывод блока архива на основании ID
function mod_newsarchive($id)
{
	global $AVE_Template;

	require_once(BASE_DIR . '/modules/newsarchive/class.newsarchive.php');

	$tpl_dir   = BASE_DIR . '/modules/newsarchive/templates/';
	$lang_file = BASE_DIR . '/modules/newsarchive/lang/' . DEFAULT_LANGUAGE . '.txt';

	$AVE_Template->config_load($lang_file, 'admin');
	$config_vars = $AVE_Template->get_config_vars();
	$AVE_Template->assign('config_vars', $config_vars);

	Newsarchive::showArchive($tpl_dir, stripslashes($id));
}

// Определяем функцию, которая будет выполнять выборку докуметов из БД
// на основании Месяца, Года и Дня (день может быть необязательным параметром)
function show_by($id, $month, $year, $day=0)
{
	global $AVE_Template;

	// Определяем, пришел ли в запросе номер дня
	if ($day == 0)
	{
		$db_day = '';
	}
	else
	{
		$db_day = "AND DAYOFMONTH(FROM_UNIXTIME(a.DokStart)) = '" . $day . "'";
	}

	$tpl_dir   = BASE_DIR . '/modules/newsarchive/templates/';
	$lang_file = BASE_DIR . '/modules/newsarchive/lang/' . DEFAULT_LANGUAGE . '.txt';
	$AVE_Template->config_load($lang_file, 'admin');
	$config_vars = $AVE_Template->get_config_vars();
	$AVE_Template->assign('config_vars', $config_vars);

	// Выбираем все параметры для запроса с текущим ID
	$sql = $GLOBALS['AVE_DB']->Query("SELECT *
		FROM ".PREFIX."_modul_newsarchive
		WHERE id = '" . $id . "'
	");
	$result = $sql->FetchRow();

	$AVE_Template->assign('results', $result);

	// Формирование условий сортировки выводимых документов
	$db_sort   = 'ORDER BY a.Titel ASC';
	if(isset($_REQUEST['sort']) && $_REQUEST['sort'] != '')
	{
		switch($_REQUEST['sort'])
		{
			case 'Titel' :
				$db_sort   = 'ORDER BY a.Titel ASC';
				break;

			case 'TitleDesc' :
				$db_sort   = 'ORDER BY a.Titel DESC';
				break;

			case 'Date' :
				$db_sort   = 'ORDER BY a.DokStart ASC';
				break;

			case 'DateDesc' :
				$db_sort   = 'ORDER BY a.DokStart DESC';
				break;

			case 'Rubric' :
				$db_sort   = 'ORDER BY b.RubrikName ASC';
				break;

			case 'RubricDesc' :
				$db_sort   = 'ORDER BY b.RubrikName DESC';
				break;

			default :
				$db_sort   = 'ORDER BY a.Titel ASC';
				break;
		}
	}

	$doctime = $AVE_Globals->mainSettings('use_doctime')
		? ("AND (DokEnde = 0 || DokEnde > '" . time() . "') AND (DokStart = 0 || DokStart < '" . time() . "')")
		: '';

	// Выбираем из БД документы. которые соответствуют условиям для запроса и модуля
	$query = $GLOBALS['AVE_DB']->Query("
		SELECT
		  	a.Id,
		  	a.RubrikId,
		  	a.Titel,
		  	a.DokStart,
		  	b.RubrikName
	  	FROM
	  		" . PREFIX . "_documents as a,
	  		" . PREFIX . "_rubrics as b
		WHERE RubrikId IN (" . $result->rubs . ")
		AND MONTH(FROM_UNIXTIME(a.DokStart)) = '" . $month . "'
		AND YEAR(FROM_UNIXTIME(a.DokStart))= '" . $year . "'
		" . $db_day . "
		AND a.RubrikId = b.Id
		AND a.Id != '2'
  		AND Geloescht != 1
  		AND DokStatus != 0
  		" . $doctime . "
		" . $db_sort . "
	");

	$documents = array();
	// Заполняем массив докуметов результатами из БД и передем в шаблон
	while($doc = $query->FetchRow())
	{
		$doc->Url = (CP_REWRITE==1)
			? cpRewrite('index.php?id=' . $doc->Id . '&amp;doc=' . cpParseLinkname($doc->Titel) )
			: 'index.php?id=' . $doc->Id . '&amp;doc=' . cpParseLinkname($doc->Titel);
		array_push($documents, $doc);
	}

	$AVE_Template->assign('documents',$documents);

	// Формируем меню навигации по дням
	$day_in_month = date('t', mktime(0, 0, 0, $month, 1, $year));
	$m_arr = array(null,'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь');
	$month_name = (substr($month,0,1) == 0) ? str_replace('0','',$month) : $month;
	$month_name = $m_arr[$month_name];

	$AVE_Template->assign('month_name',$month_name);
	$AVE_Template->assign('year',$year);
	$AVE_Template->assign('month',$month);
	$AVE_Template->assign('day',$day);

	for($i=1;$i < $day_in_month+1; $i++)
	{
		if (strlen($i) == 1)
		{
			$k = '0'.$i;
		}
		else
		{
			$k = $i;
		}
		$days[] = $k;
	}

	$AVE_Template->assign('days',$days);

	$tpl_out = $AVE_Template->fetch($tpl_dir.'archive_result.tpl');
	if(!defined('MODULE_CONTENT'))
	{
		define('MODULE_CONTENT', $tpl_out);
	}
	return true;
}

// Включаем проверку входных данных и показываем результаты в зависимости от запроса
if (isset($_GET['module']) && $_GET['module'] == 'newsarchive' && $_GET['month'] != '' && $_GET['year'] != '')
{
	$id    = addslashes($_GET['id']);
	$month = addslashes($_GET['month']);
	$year  = addslashes($_GET['year']);

	if (isset($_GET['day']) && $_GET['day'] != '')
	{
		$day = addslashes($_GET['day']);
		show_by($id, $month, $year, $day);
	}
	else
	{
		show_by($id, $month, $year);
	}
}

// Кусок кода, отвечающий за управление модулем в админке
if(defined('ACP') && !(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete'))
{
	require_once(BASE_DIR . '/modules/newsarchive/sql.php');
	require_once(BASE_DIR . '/modules/newsarchive/class.newsarchive.php');

	$tpl_dir   = BASE_DIR . '/modules/newsarchive/templates/';
	$lang_file = BASE_DIR . '/modules/newsarchive/lang/' . DEFAULT_LANGUAGE . '.txt';

	$AVE_Template->config_load($lang_file);
	$config_vars = $AVE_Template->get_config_vars();
	$AVE_Template->assign('config_vars', $config_vars);

	if(isset($_REQUEST['moduleaction']) && $_REQUEST['moduleaction'] != '')
	{
		switch($_REQUEST['moduleaction'])
		{
			case '1':
				Newsarchive::archiveList($tpl_dir);
				break;

			case 'add':
				Newsarchive::addArchive();
				break;

			case 'del':
				Newsarchive::delArchive();
				break;

			case 'savelist':
				Newsarchive::saveList();
				break;

			case 'edit':
				Newsarchive::editArchive($tpl_dir);
				break;

			case 'saveedit':
				Newsarchive::saveArchive();
				break;
		}
	}
}
?>