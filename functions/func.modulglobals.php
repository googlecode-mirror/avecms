<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * ������� ��������� ���������� ������ $mod � ����������:
 * <pre>
 *      tpl_dir      ���� � ����� � ��������� ������
 *      theme_folder ��� ����� � ������� �������
 *      config_vars  ������ � ��������� ����������� ������
 * </pre>
 * ��������� � ������� � ������������:
 * <pre>
 *      $tpl_dir     ���� � ����� � ��������� ������
 *      $mod_dir     ��� ����� � ��������
 *      $config_vars ������ � ��������� ����������� ������
 * </pre>
 * ������������ � ������������� ������� in_array
 *
 * @param string $modulepath ��� ����� ������
 * @param string $lang_section ������ ��������� �����
 */
function modulGlobals($modulepath, $lang_section = false)
{
	global $mod, $AVE_Template;

	$tpl_dir   = BASE_DIR . '/modules/' . $modulepath . '/templates/';
	$lang_file = BASE_DIR . '/modules/' . $modulepath
		. '/lang/' . DEFAULT_LANGUAGE . '.txt';

	if (!file_exists($lang_file))
	{
		$lang_file = BASE_DIR . '/modules/' . $modulepath . '/lang/ru.txt';
	}

	if (!file_exists($lang_file))
	{
		echo '������! ����������� �������� ����. ',
			'����������, ��������� ����, ������������� �� ���������, ',
			'� ����� inc/config.php';
		exit;
	}

	if ($lang_section === false)
	{
		$AVE_Template->config_load($lang_file);
	}
	else
	{
		$AVE_Template->config_load($lang_file, $lang_section);
	}
	$config_vars = $AVE_Template->get_config_vars();

	$AVE_Template->assign('tpl_dir', $tpl_dir);
	$AVE_Template->assign('mod_dir', BASE_DIR . '/modules');
	$AVE_Template->assign('config_vars', $config_vars);

	$mod['tpl_dir'] = $tpl_dir;
	$mod['theme_folder'] = defined('THEME_FOLDER') ? THEME_FOLDER : DEFAULT_THEME_FOLDER;
	$mod['config_vars'] = $config_vars;

	$AVE_Template->register_function('in_array', 'in_array');
}

?>