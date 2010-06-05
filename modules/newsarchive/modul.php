<?php

/**
 * AVE.cms - ������ ����� ��������
 *
 * @package AVE.cms
 * @subpackage module_Newsarchive
 * @filesource
 */

if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = '����� ����������';
    $modul['ModulPfad'] = 'newsarchive';
    $modul['ModulVersion'] = '1.1';
    $modul['Beschreibung'] = '������ ������ ������������� ��� ����������� ������ ���������� �� ��������� �������� � �������. ��������� ������ ��������� ���������� ����������� ���� ������ ������� � ���������� ���� ���������.';
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
 * ��������� ���� ������
 *
 * @param int $newsarchive_id - ������������� ������
 */
function mod_newsarchive($newsarchive_id)
{
	global $AVE_Template;

    $newsarchive_id = preg_replace('/\D/', '', $newsarchive_id);

	if (is_numeric($newsarchive_id) && $newsarchive_id > 0)
	{
		require_once(BASE_DIR . '/modules/newsarchive/class.newsarchive.php');

		$tpl_dir   = BASE_DIR . '/modules/newsarchive/templates/';
		$lang_file = BASE_DIR . '/modules/newsarchive/lang/' . $_SESSION['user_language'] . '.txt';

		$AVE_Template->config_load($lang_file, 'admin');

		Newsarchive::showArchive($tpl_dir, $newsarchive_id);
	}
}

/**
 * ������� ��������� �� �� �� ��������� ������, ���� � ���
 * ���� �������������� ��������
 *
 * @param int $newsarchive_id	������������� ������
 * @param int $month			�����
 * @param int $year				���
 * @param int $day				����
 */
function show_by($newsarchive_id, $month, $year, $day = 0)
{
	global $AVE_DB, $AVE_Template;

	if(defined('MODULE_CONTENT')) return;

	$assign = array();

	$tpl_dir   = BASE_DIR . '/modules/newsarchive/templates/';
	$lang_file = BASE_DIR . '/modules/newsarchive/lang/' . $_SESSION['user_language'] . '.txt';
	$AVE_Template->config_load($lang_file, 'admin');

	// ����������, ������ �� � ������� ����� ���
	$db_day = (is_numeric($day) && $day != 0) ? "AND DAYOFMONTH(FROM_UNIXTIME(a.DokStart)) = '" . $day . "'" : '';

	// �������� ��� ��������� ��� ������� � ������� ID
	$newsarchive = $AVE_DB->Query("
		SELECT *
		FROM ".PREFIX."_modul_newsarchive
		WHERE id = '" . (int)$newsarchive_id . "'
	")->FetchRow();

	// ������������ ������� ���������� ��������� ����������
	$db_sort = 'ORDER BY a.Titel ASC';
	if(isset($_REQUEST['sort']))
	{
		switch($_REQUEST['sort'])
		{
			case 'Titel':      $db_sort = 'ORDER BY a.Titel ASC';       break;
			case 'TitleDesc':  $db_sort = 'ORDER BY a.Titel DESC';      break;
			case 'Date':       $db_sort = 'ORDER BY a.DokStart ASC';    break;
			case 'DateDesc':   $db_sort = 'ORDER BY a.DokStart DESC';   break;
			case 'Rubric':     $db_sort = 'ORDER BY b.RubrikName ASC';  break;
			case 'RubricDesc': $db_sort = 'ORDER BY b.RubrikName DESC'; break;
			default:           $db_sort = 'ORDER BY a.Titel ASC';       break;
		}
	}

	$doctime = get_settings('use_doctime') ? ("AND (DokEnde = 0 || DokEnde > '" . time() . "') AND DokStart < '" . time() . "'") : '';

	// �������� �� �� ���������. ������� ������������� �������� ��� ������� � ������
	$query = $AVE_DB->Query("
		SELECT
		  	a.Id,
		  	a.RubrikId,
		  	a.Titel,
		  	a.DokStart,
		  	b.RubrikName
	  	FROM
	  		" . PREFIX . "_documents as a,
	  		" . PREFIX . "_rubrics as b
		WHERE RubrikId IN (" . $newsarchive->newsarchive_rubrics . ")
		AND MONTH(FROM_UNIXTIME(a.DokStart)) = '" . (int)$month . "'
		AND YEAR(FROM_UNIXTIME(a.DokStart))= '" . (int)$year . "'
		" . $db_day . "
		AND a.RubrikId = b.Id
		AND a.Id != '". PAGE_NOT_FOUND_ID . "'
  		AND Geloescht != '1'
  		AND DokStatus != '0'
  		" . $doctime . "
		" . $db_sort . "
	");

	// ��������� ������ ��������� ������������ �� ��
	$documents = array();
	while($doc = $query->FetchRow())
	{
		$doc->Url = rewrite_link('index.php?id=' . $doc->Id . '&amp;doc=' . prepare_url($doc->Titel));
		array_push($documents, $doc);
	}

	// ��������� ���� ��������� �� ����
	$day_in_month = date('t', mktime(0, 0, 0, (int)$month, 1, (int)$year));
	$m_arr = array(null, '������', '�������', '����', '������', '���', '����', '����', '������', '��������', '�������', '������', '�������');

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

// �������� �������� ������� ������ � ���������� ���������� � ����������� �� �������
if (isset($_GET['module']) && $_GET['module'] == 'newsarchive' && !empty($_GET['month']) && !empty($_GET['year']))
{
	show_by($_GET['id'], $_GET['month'], $_GET['year'], isset($_GET['day']) ? $_GET['day'] : 0);
}

// ����� ����, ���������� �� ���������� ������� � �������
if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	require_once(BASE_DIR . '/modules/newsarchive/class.newsarchive.php');

	$tpl_dir   = BASE_DIR . '/modules/newsarchive/templates/';
	$lang_file = BASE_DIR . '/modules/newsarchive/lang/' . $_SESSION['user_language'] . '.txt';
	$AVE_Template->config_load($lang_file);

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

?>