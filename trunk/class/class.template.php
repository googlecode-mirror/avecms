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
         * Имя каталога, в котором хранится кэш.
         */
        $this->cache_dir_root = BASE_DIR . '/cache';
        
        /**
         * Имя каталога, в котором хранится кэш шаблонов.
         */
        $this->cache_dir = BASE_DIR . '/cache/tpl';
        
        /**
         * Имя каталога, в котором хранится кэш модулей.
         */
        $this->module_cache_dir = BASE_DIR . '/cache/module';     
        
        /**
         * Имя каталога, в котором хранится сессии пользователей.
         */
        $this->session_dir = BASE_DIR . '/cache/session';  
         
        /**
         * Имя каталога, в котором хранится сессии пользователей.
         */
        $this->sql_cache_dir = BASE_DIR . '/cache/sql';                    

        /**
         * Использование поддиректорий для хранения кэша и скомпилированных шаблонов.
         */
        $this->use_sub_dirs = SMARTY_USE_SUB_DIRS;

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
	 * Проверка наличия одноименного шаблона в директории темы дизайна.
	 * При наличии шаблона в директории темы дизайна используется этот шаблон.
	 *
	 * @param string $tpl	путь к шаблону
	 * @return string
	 */
	function _redefine_template($tpl)
	{
		if (!defined('THEME_FOLDER')) return $tpl;

		$r_tpl = str_replace(BASE_DIR, BASE_DIR . '/templates/' . THEME_FOLDER, $tpl);

		return (file_exists($r_tpl) && is_file($r_tpl)) ? $r_tpl : $tpl;
	}

/**
 *	ВНЕШНИЕ МЕТОДЫ
 */

	/**
	 * Переопределение одноименного метода Smarty
	 * для конфигурационных файлов созданных в теме дизайна.
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
	 * Переопределение одноименного метода Smarty
	 * для пользовательских шаблонов созданных в теме дизайна.
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
	 * Переопределение одноименного метода Smarty
	 * для пользовательских шаблонов созданных в теме дизайна.
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
	 * Переопределение одноименного метода Smarty
	 * для пользовательских шаблонов созданных в теме дизайна.
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

		if($_REQUEST['ajax'] && Memcached_Server && Memcached_Port) {
			$memcache = new Memcache;
			$memcache->connect(Memcached_Server, Memcached_Port);
			$memcache->flush();
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
	
	/**
	 * Метод удаления скомпилированных шаблонов модулей
	 *
	 */	
	function moduleCacheClear()
    {

        $_params = array('auto_base' => $this->module_cache_dir,
                        'auto_source' => null,
                        'auto_id' => null,
                        'exp_time' => null,
                        'extensions' => array('.inc', '.php'));
        
      $filename = $this->module_cache_dir . '/.htaccess';
		if (!file_exists($filename))
		{
			$fp = @fopen($filename, 'w');
			if ($fp)
			{
				fputs($fp, 'Deny from all');
				fclose($fp);
			}
		}

		reportLog($_SESSION['user_name'] . ' - удалил скомпилированные шаблоны модулей', 2, 2);
		
		require_once(SMARTY_CORE_DIR . 'core.rm_auto.php');
		return smarty_core_rm_auto($_params, $this);
    }
    
	/**
	 * Метод удаления всех сессий
	 *
	 */	
	function sessionClear()
    {

        $_params = array('auto_base' => $this->session_dir,
                        'auto_source' => null,
                        'auto_id' => null,
                        'exp_time' => null,
                        'extensions' => array('.inc', '.php'));
        
      $filename = $this->session_dir . '/.htaccess';
		if (!file_exists($filename))
		{
			$fp = @fopen($filename, 'w');
			if ($fp)
			{
				fputs($fp, 'Deny from all');
				fclose($fp);
			}
		}

		reportLog($_SESSION['user_name'] . ' - удалил сессии пользователей', 2, 2);
		
		require_once(SMARTY_CORE_DIR . 'core.rm_auto.php');
		return smarty_core_rm_auto($_params, $this);
    }
    
    /**
	 * Метод удаления кэша запросов
	 *
	 */	
	function sqlCacheClear()
    {

        $_params = array('auto_base' => $this->sql_cache_dir,
                        'auto_source' => null,
                        'auto_id' => null,
                        'exp_time' => null,
                        'extensions' => array('.inc', '.php'));
        
      $filename = $this->sql_cache_dir . '/.htaccess';
		if (!file_exists($filename))
		{
			$fp = @fopen($filename, 'w');
			if ($fp)
			{
				fputs($fp, 'Deny from all');
				fclose($fp);
			}
		}

		reportLog($_SESSION['user_name'] . ' - удалил кэш sql запросов', 2, 2);
		
		require_once(SMARTY_CORE_DIR . 'core.rm_auto.php');
		return smarty_core_rm_auto($_params, $this);
    }
	
}
?>
