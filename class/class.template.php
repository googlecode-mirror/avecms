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
require(BASE_DIR . '/lib/Smarty/Smarty.class.php');

/**
 * Расширение класса шаблонизатора Smarty
 *
 */
class AVE_Template extends Smarty
{
/**
 *	СВОЙСТВА
 */

	/**
	 * Конструктор
	 *
	 * @param string $template_dir путь к директории шаблонов по умолчанию
	 * @return AVE_Template
	 */
	function AVE_Template($template_dir)
	{
        /**
         * Путь к директории шаблонов по умолчанию.
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
		$this->compile_check = SMARTY_COMPILE_CHECK;

        /**
         * Активирует debugging console - порожденное при помощи javascript окно браузера,
         * содержащее информацию о подключенных шаблонах и загруженных переменных для текущей страницы.
         */
		$this->debugging = SMARTY_DEBUGGING;

        /**
         * Регистрация плагинов-функций Smarty.
         * Передается наименование функции шаблона и имя функции, реализующей ее.
         */
        $this->register_function('check_permission', 'check_permission');
        $this->register_function('get_redirect_link', 'get_redirect_link');
        $this->register_function('get_home_link', 'get_home_link');
        $this->register_function('num_format', 'num_format');

        /**
         * Регистрация плагинов-модификаторов Smarty.
         * Передается имя модификатора и имя функции, реализующей его.
         */
        $this->register_modifier('pretty_date', 'pretty_date');

// плагин позволяющий поставить метки шаблонов
// для быстрого поиска шаблона отвечающего за вывод
// перед использованием очистить templates_c
// $this->register_postfilter('add_template_comment');

        /**
         * Присваиваем общие значения для шаблонов.
         * Можно явно передавать пары имя/значение,
         * или ассоциативные массивы, содержащие пары имя/значение.
         */
		$assign['BASE_DIR']          = BASE_DIR;
		$assign['ABS_PATH']          = ABS_PATH;
		$assign['DATE_FORMAT']       = DATE_FORMAT;
		$assign['TIME_FORMAT']       = TIME_FORMAT;
		$assign['PAGE_NOT_FOUND_ID'] = PAGE_NOT_FOUND_ID;

		$this->assign($assign);
	}

/**
 *	ВНУТРЕННИЕ МЕТОДЫ
 */


/**
 *	ВНЕШНИЕ МЕТОДЫ
 */

	/**
	 * Метод очистки кэша
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

		reportLog($_SESSION['user_name'] . ' - очистил кэш', 2, 2);
	}

	/**
	 * Метод удаления скомпилированных шаблонов
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

		reportLog($_SESSION['user_name'] . ' - удалил скомпилированные шаблоны', 2, 2);
	}
}

?>
