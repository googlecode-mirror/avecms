<?php

/**
 * AVE.cms - ������ ������-�����
 *
 * @package AVE.cms
 * @subpackage module_FAQ
 * @since 2.0
 * @filesource
 */
if (!defined('BASE_DIR')) exit;

if (defined('ACP'))
{
    $modul['ModulName'] = '������/�����';
    $modul['ModulPfad'] = 'faq';
    $modul['ModulVersion'] = '1.0';
    $modul['description'] = '������ �������� ���������� ���������� ������� �� ������ �����.';
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

/**
 * ��������� ���� ������
 *
 * @param int $id ������������� ������� �������� � �������
 */
function mod_faq($id)
{
	global $AVE_Template;

	$AVE_Template->caching = 1;         // �������� �����������
	$AVE_Template->cache_lifetime = -1; // �������������� ����� ����� ����
//	$AVE_Template->cache_dir .= '/faq'; // ����� ��� ���� ������

	$tpl_dir = BASE_DIR . '/modules/faq/templates/'; // ���� � ������� ������

	// ���� ���� � ����, �� �������� ������������
	if (!$AVE_Template->is_cached($tpl_dir . 'show_faq.tpl', $id))
	{
		// ���������, ���� �� ����� ��� ����, ���� ��� (������ ���) � �������
		if (!is_dir($AVE_Template->cache_dir))
		{
			$oldumask = umask(0);
			@mkdir($AVE_Template->cache_dir, 0777);
			umask($oldumask);
		}

		require_once(BASE_DIR . '/modules/faq/class.faq.php');

		Faq::faqShow($id);
	}

	echo rewrite_link($AVE_Template->fetch($tpl_dir . 'show_faq.tpl', $id));

	$AVE_Template->caching = false; // ��������� �����������
}

/**
 * �����������������
 */
if (defined('ACP') && !empty($_REQUEST['moduleaction']))
{
	require_once(BASE_DIR . '/modules/faq/class.faq.php');

	$tpl_dir   = BASE_DIR . '/modules/faq/templates/';
	$lang_file = BASE_DIR . '/modules/faq/lang/' . $_SESSION['user_language'] . '.txt';

	$AVE_Template->config_load($lang_file);

	switch ($_REQUEST['moduleaction'])
	{
		case '1':
			Faq::faqList($tpl_dir);
			break;

		case 'new':
			Faq::faqNew();
			break;

		case 'del':
			Faq::faqDelete($tpl_dir);
			break;

		case 'save':
			Faq::faqListSave($tpl_dir);
			break;

		case 'questlist':
			Faq::faqQuestionList($tpl_dir);
			break;

		case 'questedit':
			Faq::faqQuestionEdit($tpl_dir);
			break;

		case 'questsave':
			Faq::faqQuestionSave($tpl_dir);
			break;

		case 'questdel':
			Faq::faqQuestionDelete($tpl_dir);
			break;
	}
}

?>