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
         * Регистрация плагинов-функций Smarty.
         * Передается наименование функции шаблона и имя функции, реализующей ее.
         */
        $this->register_function('checkPermission', 'checkPermission');
        $this->register_function('redirectLink', 'redirectLink');
        $this->register_function('numFormat', 'numFormat');
        $this->register_function('homeLink', 'homeLink');

        /**
         * Регистрация плагинов-модификаторов Smarty.
         * Передается имя модификатора и имя функции, реализующей его.
         */
        $this->register_modifier('pretty_date', 'pretty_date');

        /**
         * Присваиваем общие значения для шаблонов.
         * Можно явно передавать пары имя/значение, или ассоциативные массивы, содержащие пары имя/значение.
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
