<?php

/**
 * AVE.cms - Модуль Архив новостей
 *
 * @package AVE.cms
 * @subpackage module_Newsarchive
 * @author Arcanum
 * @since 2.0
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'Архив документов';
    $modul['ModulPfad'] = 'newsarchive';
    $modul['ModulVersion'] = '1.1';
    $modul['description'] = 'Данный модуль предзназначен для организации архива документов по выбранным рубрикам в системе. Параметры модуля позволяют определить возможность пока пустых месяцев и ежедневное меню навигации.';
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

/**
 * Обработка тега модуля
 *
 * @param int $newsarchive_id - идентификатор архива
 */
function mod_newsarchive($newsarchive_id)
{
	global $AVE_Template;

    $newsarchive_id = preg_replace('/\D/', '', $newsarchive_id);

	if (is_numeric($newsarchive_id) && $newsarchive_id > 0)
	{
		require_once(BASE_DIR . '/modules/newsarchive/class.newsarchive.php');
		$Newsarchive = new Newsarchive;

		$tpl_dir   = BASE_DIR . '/modules/newsarchive/templates/';
		$lang_file = BASE_DIR . '/modules/newsarchive/lang/' . $_SESSION['user_language'] . '.txt';

		$AVE_Template->config_load($lang_file, 'admin');

		$Newsarchive->newsarchiveShow($tpl_dir, $newsarchive_id);
	}
}

/**
 * Выборка докуметов из БД на основании Месяца, Года и Дня
 * День необязательный параметр
 *
 * @param int $newsarchive_id	идентификатор архива
 * @param int $month			месяц
 * @param int $year				год
 * @param int $day				день
 */
function show_by($newsarchive_id, $month, $year, $day = 0)
{
	global $AVE_DB, $AVE_Template;

	if(defined('MODULE_CONTENT')) return;

	$assign = array();

	$tpl_dir   = BASE_DIR . '/modules/newsarchive/templates/';
	$lang_file = BASE_DIR . '/modules/newsarchive/lang/' . $_SESSION['user_language'] . '.txt';
	$AVE_Template->config_load($lang_file, 'admin');

	// Определяем, пришел ли в запросе номер дня
	$db_day = (is_numeric($day) && $day != 0) ? "AND DAYOFMONTH(FROM_UNIXTIME(a.document_published)) = '" . $day . "'" : '';

	// Выбираем все параметры для запроса с текущим ID
	$newsarchive = $AVE_DB->Query("
		SELECT *
		FROM ".PREFIX."_modul_newsarchive
		WHERE id = '" . (int)$newsarchive_id . "'
	")->FetchRow();

	// Формирование условий сортировки выводимых документов
	$db_sort = 'ORDER BY a.document_published ASC';
	if(isset($_REQUEST['sort']))
	{
		switch($_REQUEST['sort'])
		{
			case 'title':       $db_sort = 'ORDER BY a.document_title ASC';      break;
			case 'title_desc':  $db_sort = 'ORDER BY a.document_title DESC';     break;
			case 'date':        $db_sort = 'ORDER BY a.document_published ASC';  break;
			case 'date_desc':   $db_sort = 'ORDER BY a.document_published DESC'; break;
			case 'rubric':      $db_sort = 'ORDER BY b.rubric_title ASC';        break;
			case 'rubric_desc': $db_sort = 'ORDER BY b.rubric_title DESC';       break;
			default:            $db_sort = 'ORDER BY a.document_published ASC';  break;
		}
	}

	$doctime = get_settings('use_doctime')
		? ("AND document_published <= " . time() . " AND (document_expire = 0 OR document_expire >= " . time() . ")") : '';

	// Выбираем из БД документы. которые соответствуют условиям для запроса и модуля
	$query = $AVE_DB->Query("
		SELECT
		  	a.Id,
		  	a.rubric_id,
		  	a.document_title,
		  	a.document_alias,
		  	a.document_published,
		  	b.rubric_title
	  	FROM
	  		" . PREFIX . "_documents as a,
	  		" . PREFIX . "_rubrics as b
		WHERE rubric_id IN (" . $newsarchive->newsarchive_rubrics . ")
		AND MONTH(FROM_UNIXTIME(a.document_published)) = '" . (int)$month . "'
		AND YEAR(FROM_UNIXTIME(a.document_published))= '" . (int)$year . "'
		" . $db_day . "
		AND a.rubric_id = b.Id
		AND a.Id != '". PAGE_NOT_FOUND_ID . "'
  		AND document_deleted != '1'
  		AND document_status != '0'
  		" . $doctime . "
		" . $db_sort . "
	");

	// Заполняем массив докуметов результатами из БД
	$documents = array();
	while($doc = $query->FetchRow())
	{
		$doc->document_alias = rewrite_link('index.php?id=' . $doc->Id . '&amp;doc=' . (empty($doc->document_alias) ? prepare_url($doc->document_title) : $doc->document_alias));
		array_push($documents, $doc);
	}

	// Формируем меню навигации по дням
	$day_in_month = date('t', mktime(0, 0, 0, (int)$month, 1, (int)$year));
	$m_arr = array(null, 'Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь');

	$assign['newsarchive'] = $newsarchive;
	$assign['documents']   = $documents;
	$assign['days']        = range(1, $day_in_month);
	$assign['month_name']  = $m_arr[(int)$month];
	$assign['year']        = (int)$year;
	$assign['month']       = (int)$month;
	$assign['day']         = (int)$day;

	$AVE_Template->assign($assign);

	define('MODULE_CONTENT', $AVE_Template->fetch($tpl_dir . 'archive_result.tpl'));
}

// Включаем проверку входных данных и показываем результаты в зависимости от запроса
if (isset($_GET['module']) && $_GET['module'] == 'newsarchive' && !empty($_GET['month']) && !empty($_GET['year']))
{
	show_by($_GET['id'], $_GET['month'], $_GET['year'], isset($_GET['day']) ? $_GET['day'] : 0);
}

// Кусок кода, отвечающий за управление модулем в админке
if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	require_once(BASE_DIR . '/modules/newsarchive/class.newsarchive.php');
	$Newsarchive = new Newsarchive;

	$tpl_dir   = BASE_DIR . '/modules/newsarchive/templates/';
	$lang_file = BASE_DIR . '/modules/newsarchive/lang/' . $_SESSION['user_language'] . '.txt';
	$AVE_Template->config_load($lang_file);

	switch($_REQUEST['moduleaction'])
	{
		case '1':
			$Newsarchive->newsarchiveList($tpl_dir);
			break;

		case 'add':
			$Newsarchive->newsarchiveNew();
			break;

		case 'del':
			$Newsarchive->newsarchiveDelete();
			break;

		case 'savelist':
			$Newsarchive->newsarchiveListSave();
			break;

		case 'edit':
			$Newsarchive->newsarchiveEdit($tpl_dir);
			break;

		case 'saveedit':
			$Newsarchive->newsarchiveSave();
			break;
	}
}

?>