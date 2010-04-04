<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * Подключаем файл шаблонизатора Smarty
 */
require('Smarty/Smarty.class.php');

/**
 * Расширение класса шаблонизатора Smarty
 *
 */
class AVE_Template extends Smarty
{
	function AVE_Template($template_dir)
	{
		global $config;

        /**
         * Это название директории шаблонов по умолчанию.
         * Если вы не передадите тип ресурса во время подключения файлов, они будут искаться здесь.
         */
		$this->template_dir = $template_dir;
        
        /**
         * Имя каталога, в котором хранятся компилированные шаблоны.
         */ 
        $this->compile_dir = BASE_DIR . '/templates_c';
        
        /**
         * Имя каталога, в котором хранится кэш шаблонов.
         */ 
        $this->cache_dir = BASE_DIR . '/cache';
        
        /**
         * При каждом вызове РНР-приложения Smarty проверяет, изменился или нет текущий шаблон
         * с момента последней компиляции. Если шаблон изменился, он перекомпилируется. 
         * В случае, если шаблон еще не был скомпилирован, его компиляция производится
         * с игнорированием значения этого параметра.
         */ 
		$this->compile_check = $config['compile_check'];

        /**
         * Активирует debugging console - порожденное при помощи javascript окно браузера,
         * содержащее информацию о подключенных шаблонах и загруженных переменных для текущей страницы. 
         */ 
		$this->debugging = $config['debugging'];

        /**
         * Регистрация плагинов-функций шаблонов Smarty. 
         * Передается наименование функции шаблона и имя функции, реализующей ее. 
         */ 
        $this->register_function('checkPermission', 'checkPermission');
        $this->register_function('redirectLink', 'redirectLink');
        $this->register_function('numFormat', 'numFormat');
        $this->register_function('homeLink', 'homeLink');

        /**
         * Присваиваем общие значения для шаблонов. 
         * Можно явно передавать пары имя/значение, или ассоциативные массивы, содержащие пары имя/значение.
         */ 
		$this->assign('tpl_path', 'templates/' . DEFAULT_THEME_FOLDER);
		$this->assign('base_dir', BASE_DIR);
		$this->assign('def_doc_start_year', gmmktime(0, 0, 0, gmdate("m"), gmdate("d"), gmdate("Y") - 10));
		$this->assign('def_doc_end_year', gmmktime(0, 0, 0, gmdate("m"), gmdate("d"), gmdate("Y") + 20));
		$this->assign('def_country', DEFAULT_COUNTRY);
	}
}

?>
