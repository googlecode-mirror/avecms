<?php

/**
 * AVE.cms - ������ RSS
 *
 * @package AVE.cms
 * @subpackage module_RSS
 * @filesource
 */

if(!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = 'RSS ������';
    $modul['ModulPfad'] = 'rss';
    $modul['ModulVersion'] = '1.0beta2';
    $modul['Beschreibung'] = '������ ������ ������������� ��� ����������� RSS ������� �� ����� �����.';
    $modul['Autor'] = 'Arcanum';
    $modul['MCopyright'] = '&copy; 2007-2008 Overdoze Team';
    $modul['Status'] = 1;
    $modul['IstFunktion'] = 1;
    $modul['AdminEdit'] = 1;
    $modul['ModulFunktion'] = 'mod_rss';
    $modul['CpEngineTagTpl'] = '[mod_rss:XXX]';
    $modul['CpEngineTag'] = '#\\\[mod_rss:(\\\d+)]#';
    $modul['CpPHPTag'] = "<?php mod_rss(''$1''); ?>";
}

/**
 * ��������� ���� ������ RSS
 *
 * @param int $id ������������� RSS-�����
 */
function mod_rss($id)
{
	$id = stripslashes($id);
	if (is_numeric($id))
	{
		echo '<a href="rss/rss-', $id,
			'.xml" target="blank"><img src="modules/rss/templates/feed.gif" border="0" title="RSS ����� ��������" /></a>';
	}
}

if (isset($_REQUEST['module']) && $_REQUEST['module'] == 'rss'
	&& isset($_REQUEST['do']) && $_REQUEST['do'] == 'show')
{
	header('Location:rss/index.php?id=' . $_GET['id']);
}

if (defined('ACP')
	&& (empty($_REQUEST['action'])
		|| (isset($_REQUEST['action']) && $_REQUEST['action'] != 'delete')))
{
	global $AVE_Template;

//	require_once(BASE_DIR . '/modules/rss/sql.php');
	require_once(BASE_DIR . '/modules/rss/class.rss.php');

	if (!empty($_REQUEST['moduleaction']))
	{
		switch ($_REQUEST['moduleaction'])
		{
			case '1':
				$tpl_dir   = BASE_DIR . '/modules/rss/templates/';
				$lang_file = BASE_DIR . '/modules/rss/lang/' . DEFAULT_LANGUAGE . '.txt';
				Rss::rssList($tpl_dir, $lang_file);
				break;

			case 'add':
				Rss::rssAdd();
				break;

			case 'del':
				Rss::rssDelete();
				break;

			case 'edit':
				$tpl_dir   = BASE_DIR . '/modules/rss/templates/';
				$lang_file = BASE_DIR . '/modules/rss/lang/' . DEFAULT_LANGUAGE . '.txt';
				Rss::rssEdit($tpl_dir, $lang_file);
				break;

			case 'saveedit':
				Rss::rssSave();
				break;
		}
	}
}

?>