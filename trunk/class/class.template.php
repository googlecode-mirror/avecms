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
require('Smarty/Smarty.class.php');

/**
 * ���������� ������ ������������� Smarty
 *
 */
class AVE_Template extends Smarty
{
	function AVE_Template($template_dir)
	{
		global $config;

        /**
         * ��� �������� ���������� �������� �� ���������.
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
		$this->compile_check = $config['compile_check'];

        /**
         * ���������� debugging console - ����������� ��� ������ javascript ���� ��������,
         * ���������� ���������� � ������������ �������� � ����������� ���������� ��� ������� ��������.
         */
		$this->debugging = $config['debugging'];

        /**
         * ����������� ��������-������� Smarty.
         * ���������� ������������ ������� ������� � ��� �������, ����������� ��.
         */
        $this->register_function('checkPermission', 'checkPermission');
        $this->register_function('redirectLink', 'redirectLink');
        $this->register_function('numFormat', 'numFormat');
        $this->register_function('homeLink', 'homeLink');

        /**
         * ����������� ��������-������������� Smarty.
         * ���������� ��� ������������ � ��� �������, ����������� ���.
         */
        $this->register_modifier('pretty_date', 'pretty_date');

        /**
         * ����������� ����� �������� ��� ��������.
         * ����� ���� ���������� ���� ���/��������, ��� ������������� �������, ���������� ���� ���/��������.
         */
		$this->assign('tpl_path', 'templates/' . DEFAULT_THEME_FOLDER);
		$this->assign('BASE_DIR', BASE_DIR);
		$this->assign('BASE_PATH', BASE_PATH);
		$this->assign('DEF_DOC_START_YEAR', mktime(0, 0, 0, date("m"), date("d"), date("Y") - 10));
		$this->assign('DEF_DOC_END_YEAR', mktime(0, 0, 0, date("m"), date("d"), date("Y") + 20));
		$this->assign('DEF_COUNTRY', DEFAULT_COUNTRY);
		$this->assign('DEF_LANGUAGE', DEFAULT_LANGUAGE);
		$this->assign('DATE_FORMAT', DATE_FORMAT);
		$this->assign('TIME_FORMAT', TIME_FORMAT);
		$this->assign('PAGE_NOT_FOUND_ID', PAGE_NOT_FOUND_ID);
	}
}

?>
