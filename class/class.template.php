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
        $this->register_function('get_redirect_link', 'get_redirect_link');
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
 *	������� ������
 */

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
