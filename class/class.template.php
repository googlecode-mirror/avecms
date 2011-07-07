<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * ���������� ���� ������������� Smarty
 */
require(BASE_DIR . '/lib/Smarty/Smarty.class.php');

/**
 * ���������� ������ ������������� Smarty
 *
 */
class AVE_Template extends Smarty
{
/**
 *	��������
 */

	/**
	 * �����������
	 *
	 * @param string $template_dir ���� � ���������� �������� �� ���������
	 * @return AVE_Template
	 */
	function AVE_Template($template_dir)
	{
        /**
         * ���� � ���������� �������� �� ���������.
         * ���� �� �� ���������� ��� ������� �� ����� ����������� ������, ��� ����� �������� �����.
         */
		$this->template_dir = $template_dir;

        /**
         * ��� ��������, � ������� �������� ��������������� �������.
         */
        $this->compile_dir = BASE_DIR . '/templates_c';

        /**
         * ��� ��������, � ������� �������� ��� ��������.
         */
        $this->cache_dir = BASE_DIR . '/cache';

        /**
         * ������������� ������������� ��� �������� ���� � ���������������� ��������.
         */
        $this->use_sub_dirs = SMARTY_USE_SUB_DIRS;

        /**
         * ��� ������ ������ ���-���������� Smarty ���������, ��������� ��� ��� ������� ������
         * � ������� ��������� ����������. ���� ������ ���������, �� �����������������.
         * � ������, ���� ������ ��� �� ��� �������������, ��� ���������� ������������
         * � �������������� �������� ����� ���������.
         */
		$this->compile_check = SMARTY_COMPILE_CHECK;

        /**
         * ���������� debugging console - ����������� ��� ������ javascript ���� ��������,
         * ���������� ���������� � ������������ �������� � ����������� ���������� ��� ������� ��������.
         */
		$this->debugging = SMARTY_DEBUGGING;

        /**
         * ����������� ��������-������� Smarty.
         * ���������� ������������ ������� ������� � ��� �������, ����������� ��.
         */
        $this->register_function('check_permission', 'check_permission');
        $this->register_function('get_home_link', 'get_home_link');
        $this->register_function('num_format', 'num_format');

        /**
         * ����������� ��������-������������� Smarty.
         * ���������� ��� ������������ � ��� �������, ����������� ���.
         */
        $this->register_modifier('pretty_date', 'pretty_date');

// ������ ����������� ��������� ����� ��������
// ��� �������� ������ ������� ����������� �� �����
// ����� �������������� �������� templates_c
// $this->register_postfilter('add_template_comment');

        /**
         * ����������� ����� �������� ��� ��������.
         * ����� ���� ���������� ���� ���/��������,
         * ��� ������������� �������, ���������� ���� ���/��������.
         */
		$assign['BASE_DIR']          = BASE_DIR;
		$assign['ABS_PATH']          = ABS_PATH;
		$assign['DATE_FORMAT']       = DATE_FORMAT;
		$assign['TIME_FORMAT']       = TIME_FORMAT;
		$assign['PAGE_NOT_FOUND_ID'] = PAGE_NOT_FOUND_ID;

		$this->assign($assign);
	}

/**
 *	���������� ������
 */

	/**
	 * �������� ������� ������������ ������� � ���������� ���� �������.
	 * ��� ������� ������� � ���������� ���� ������� ������������ ���� ������.
	 *
	 * @param string $tpl	���� � �������
	 * @return string
	 */
	function _redefine_template($tpl)
	{
		if (!defined('THEME_FOLDER')) return $tpl;

		$r_tpl = str_replace(BASE_DIR, BASE_DIR . '/templates/' . THEME_FOLDER, $tpl);

		return (file_exists($r_tpl) && is_file($r_tpl)) ? $r_tpl : $tpl;
	}

/**
 *	������� ������
 */

	/**
	 * ��������������� ������������ ������ Smarty
	 * ��� ���������������� ������ ��������� � ���� �������.
	 *
	 * @param string $file
	 * @param string $section
	 * @param string $scope
	 */
	function config_load($file, $section = null, $scope = 'global')
	{
		Smarty::config_load($this->_redefine_template($file), $section, $scope);
	}

	/**
	 * ��������������� ������������ ������ Smarty
	 * ��� ���������������� �������� ��������� � ���� �������.
	 *
	 * @param string $tpl_file name of template file
	 * @param string $cache_id
	 * @param string $compile_id
	 * @return string|false results of {@link _read_cache_file()}
	 */
    function is_cached($tpl_file, $cache_id = null, $compile_id = null)
    {
    	return Smarty::is_cached($this->_redefine_template($tpl_file), $cache_id, $compile_id);
    }

	/**
	 * ��������������� ������������ ������ Smarty
	 * ��� ���������������� �������� ��������� � ���� �������.
	 *
	 * @param string $resource_name
	 * @param string $cache_id
	 * @param string $compile_id
	 * @param boolean $display
	 */
	function fetch($resource_name, $cache_id = null, $compile_id = null, $display = false)
	{
		return Smarty::fetch($this->_redefine_template($resource_name), $cache_id, $compile_id, $display);
	}

	/**
	 * ��������������� ������������ ������ Smarty
	 * ��� ���������������� �������� ��������� � ���� �������.
	 *
	 * @param string $resource_name
	 * @param string $cache_id
	 * @param string $compile_id
	 */
	function display($resource_name, $cache_id = null, $compile_id = null)
	{
		$this->fetch($resource_name, $cache_id, $compile_id, true);
	}

	/**
	 * ����� ������� ����
	 *
	 */
	function templateCacheClear()
	{
		$this->clear_all_cache();

		$filename = $this->cache_dir . '/.htaccess';
		if (!file_exists($filename))
		{
			$fp = @fopen($filename, 'w');
			if ($fp)
			{
				fputs($fp, 'Deny from all');
				fclose($fp);
			}
		}

		reportLog($_SESSION['user_name'] . ' - ������� ���', 2, 2);
	}

	/**
	 * ����� �������� ���������������� ��������
	 *
	 */
	function templateCompiledTemplateClear()
	{
		$this->clear_compiled_tpl();

		$filename = $this->compile_dir . '/.htaccess';
		if (!file_exists($filename))
		{
			$fp = @fopen($filename, 'w');
			if ($fp)
			{
				fputs($fp, 'Deny from all');
				fclose($fp);
			}
		}

		reportLog($_SESSION['user_name'] . ' - ������ ���������������� �������', 2, 2);
	}
}

?>
