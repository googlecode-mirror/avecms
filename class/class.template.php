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
         * ����������� ��������-������� �������� Smarty. 
         * ���������� ������������ ������� ������� � ��� �������, ����������� ��. 
         */ 
        $this->register_function('checkPermission', 'checkPermission');
        $this->register_function('redirectLink', 'redirectLink');
        $this->register_function('numFormat', 'numFormat');
        $this->register_function('homeLink', 'homeLink');

        /**
         * ����������� ����� �������� ��� ��������. 
         * ����� ���� ���������� ���� ���/��������, ��� ������������� �������, ���������� ���� ���/��������.
         */ 
		$this->assign('tpl_path', 'templates/' . DEFAULT_THEME_FOLDER);
		$this->assign('base_dir', BASE_DIR);
		$this->assign('def_doc_start_year', gmmktime(0, 0, 0, gmdate("m"), gmdate("d"), gmdate("Y") - 10));
		$this->assign('def_doc_end_year', gmmktime(0, 0, 0, gmdate("m"), gmdate("d"), gmdate("Y") + 20));
		$this->assign('def_country', DEFAULT_COUNTRY);
	}
}

?>
