<?php

/**
 * AVE.cms - ������ ����������
 *
 * @package AVE.cms
 * @subpackage module_Counter
 * @filesource
 */

if(!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul = array();
    $modul['ModulName'] = '����������';
    $modul['ModulPfad'] = 'counter';
    $modul['ModulVersion'] = '1.2';
    $modul['Beschreibung'] = '������ ������ ������������ ��� ����� ���������� ��������� ������� ������ �����, � ����� �������������� ������ � �����������. ��� ����, ����� ������ ���� ����������, ���������� ��������� ��� <strong>[mod_counter:XXX]</strong> �� ������ ��� �������� ��� ������� �����. ��� - ��� ���������� ����� �������� � �������. ��� ����������� ���������� � ��������� �����, ���������� ��������� ��� <strong>[mod_counter:show]</strong> � ������ ����� ������ �������.';
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
 * ������� ����� � ����������� ����������
 *
 * @access public
 * @param string $id �������� ������������� ��������
 * � ����������� ������ show ��� ����������� ����������
 */
function mod_counter($id, $action = '')
{
    $id = intval(preg_replace('/(\D+)/', '', $id));

	if ($id > 0 && $action == '-show')
	{
		require_once(BASE_DIR . '/modules/counter/class.browser.php');
		$counter = new Counter;

		$tpl_dir   = BASE_DIR . '/modules/counter/templates/';
		$lang_file = BASE_DIR . '/modules/counter/lang/' . DEFAULT_LANGUAGE . '.txt';

		$counter->showStat($tpl_dir, $lang_file, $id);
	}
	elseif ($id > 0 &&
		!(empty($_SERVER['REMOTE_ADDR']) && empty($_SERVER['HTTP_CLIENT_IP'])) &&
		!(isset($_COOKIE['counter_' . $id]) && $_COOKIE['counter_' . $id] == '1'))
	{
		require_once(BASE_DIR . '/modules/counter/class.browser.php');
		$counter = new Counter;

		$counter->InsertNew($id);
	}
}

if (defined('ACP') && !(isset($_REQUEST['action']) && $_REQUEST['action'] == 'delete'))
{
	global $AVE_Template;

	require_once(BASE_DIR . '/modules/counter/sql.php');
	require_once(BASE_DIR . '/modules/counter/class.browser.php');
	$counter = new Counter;

	if (!empty($_REQUEST['moduleaction']))
	{
		$tpl_dir   = BASE_DIR . '/modules/counter/templates/';
		$lang_file = BASE_DIR . '/modules/counter/lang/' . $_SESSION['admin_lang'] . '.txt';

		switch ($_REQUEST['moduleaction'])
		{
			case '1':
				$counter->showCounter($tpl_dir, $lang_file);
				break;

			case 'view_referer':
				$counter->showReferer($tpl_dir, $lang_file);
				break;

			case 'quicksave':
				$counter->quickSave();
				break;

			case 'new_counter':
				$counter->newCounter();
				break;
		}
	}
}

?>