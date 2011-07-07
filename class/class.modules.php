<?php

/**
 * AVE.cms
 *
 * Класс, предназначенный для работы с модулями в Панели управления
 *
 * @package AVE.cms
 * @filesource
 */

class AVE_Module
{

/**
 *	Свойства класса
 */

/**
 *	Внутренние методы
 */

/**
 *	Внешние методы
 */

	/**
	 * Метод, преданзначеный для получения списка всех модулей
	 *
	 */
	function moduleList()
	{
		global $AVE_DB, $AVE_Template;

		$assign                = array(); // Массив для передачи в Smarty
		$errors                = array(); // Массив с ошибками
		$installed_modules     = array(); // Массив установленных модулей
		$not_installed_modules = array(); // Массив неустановленных модулей

		$author_title = $AVE_Template->get_config_vars('MODULES_AUTHOR');

		// Получаем список всех шаблонов
		$sql = $AVE_DB->Query("
			SELECT
				Id,
				template_title
			FROM " . PREFIX . "_templates
		");
		$all_templates = array();
		while ($row = $sql->FetchRow())
		{
			$all_templates[$row->Id] = htmlspecialchars($row->template_title, ENT_QUOTES);
		}

		// Получаем из БД информацию о всех установленных модулях
		$modules = $this->moduleListGet();

		// Определяем директорию, где храняться модули
//		$path = BASE_DIR . '/modules';
		$d = dir(BASE_DIR . '/modules');

		// Циклически обрабатываем директории
		while (false !== ($entry = $d->read()))
		{
			if (substr($entry, 0, 1) == '.') continue;

			$module_dir = $d->path . '/' . $entry;
			if (!is_dir($module_dir)) continue;

			$modul = array();
			if (!(is_file($module_dir . '/modul.php') && @include($module_dir . '/modul.php')))
			{
				// Если не удалось подключить основной файл модуля modul.php - Фиксируем ошибку
				$errors[] = $AVE_Template->get_config_vars('MODULES_ERROR') . $entry;
				continue;
			}

			// Формируем объект с информацией о модуле
			$mod = new stdClass();
			$mod->mod_permission = check_permission('mod_' . $modul['ModulPfad']);
			$mod->adminedit      = !empty($modul['AdminEdit']);
			$mod->path           = $modul['ModulPfad'];
			$mod->name           = $modul['ModulName'];
			$mod->tag            = $modul['CpEngineTagTpl'];
			$mod->info           = $modul['description']
								. '<br><br><b>' . $author_title . '</b>'
								. '<br>' . $modul['Autor']
								. '<br><em>' . $modul['MCopyright'] . '</em>';

			$row = isset($modules[$modul['ModulName']]) ? $modules[$modul['ModulName']] : false;

			if ($row)
			{
				$mod->status      = $row->Status;
				$mod->id          = $row->Id;
				$mod->version     = $row->Version;
				$mod->need_update = ($row->Version != $modul['ModulVersion']);
				$mod->template    = isset($row->Template) ? $row->Template : 0;

				// массив с установленными модулями
				$installed_modules[$mod->name] = $mod;
			}
			else
			{
				$mod->status   = false;
				$mod->id       = $modul['ModulPfad'];
				$mod->version  = $modul['ModulVersion'];
				$mod->template = isset($modul['ModulTemplate']) ? $modul['ModulTemplate'] : '';

				// массив с неустановленными модулями
				$not_installed_modules[$mod->name] = $mod;
			}
		}
		$d->Close();

		// Определяем массив с установленными модулями
		ksort($installed_modules);
		$assign['installed_modules'] = $installed_modules;

		// Определяем массив с неустановленными модулями
		ksort($not_installed_modules);
		$assign['not_installed_modules'] = $not_installed_modules;

		// Определяем массив со списком доступных шаблонов
		$assign['all_templates'] = $all_templates;

		// Массив с ошибками
		$assign['errors'] = $errors;

		// Передаем аднные в шаблон и отображаем страницу со списком модулей
		$AVE_Template->assign($assign);
		$AVE_Template->assign('content', $AVE_Template->fetch('modules/modules.tpl'));
	}

	/**
	 * Метод, предназначенный для обновления в БД информации о шаблонах модулей
	 *
	 */
	function moduleOptionsSave()
	{
		global $AVE_DB;

		// Циклически обрабатываем массив с информацией о шаблонах модулей
		foreach ($_POST['Template'] as $id => $template_id)
		{
			// Обновление информации о шаблоне модуля
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_module
				SET Template = '" . (int)$template_id . "'
				WHERE Id = '" . (int)$id . "'
			");
		}

		// Выполянем обновление страницы со списком модулей
		header('Location:index.php?do=modules&cp=' . SESSION);
		exit;
	}

	/**
	 * Метод, предназанченный для установки или переустановки модуля
	 *
	 */
	function moduleInstall()
	{
		global $AVE_DB, $AVE_Template;

		$modul = array();

		// Подключаем основной управляющий файл модуля
		$mod_file = BASE_DIR . '/modules/' . MODULE_PATH . '/modul.php';
		if (is_file($mod_file) && @include($mod_file))
		{
			// Удаляем информацию о модуле в таблице module
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_module
				WHERE ModulPfad = '" . MODULE_PATH . "'
			");

			// Определяем, имеет ли модуль возможность настройки в Панели управления
			$modul['AdminEdit'] = (!empty($modul['AdminEdit'])) ? $modul['AdminEdit'] : 0;

			// Определяем, имеет ли модуль возможность смены шаблона
			$modul['ModulTemplate'] = (!empty($modul['ModulTemplate'])) ? $modul['ModulTemplate'] : 0;

			// Дабовляем информацию о модуле в таблицу module
			$AVE_DB->Query("
				INSERT " . PREFIX . "_module
				SET
					ModulName     = '" . $modul['ModulName'] . "',
					`Status`      = '1',
					CpEngineTag   = '" . $modul['CpEngineTag'] . "',
					CpPHPTag      = '" . $modul['CpPHPTag'] . "',
					ModulFunktion = '" . $modul['ModulFunktion'] . "',
					IstFunktion   = '" . $modul['IstFunktion'] . "',
					ModulPfad     = '" . MODULE_PATH . "',
					Version       = '" . $modul['ModulVersion'] . "',
					Template      = '" . $modul['ModulTemplate'] . "',
					AdminEdit     = '" . $modul['AdminEdit'] . "'
			");

			// Подключаем файл с запросами к БД для данного модуля
			$modul_sql_deinstall = array();
			$modul_sql_install = array();
			$sql_file = BASE_DIR . '/modules/' . MODULE_PATH . '/sql.php';
			if (is_file($sql_file) && @include($sql_file))
			{
				// Выполняем запросы удаления таблиц модуля
				// из массива $modul_sql_deinstall файла sql.php
				foreach ($modul_sql_deinstall as $sql)
				{
					$AVE_DB->Query(str_replace('CPPREFIX', PREFIX, $sql));
				}

				// Выполняем запросы создания таблиц и данных модуля
				// из массива $modul_sql_install файла sql.php
				foreach ($modul_sql_install as $sql)
				{
					$AVE_DB->Query(str_replace('CPPREFIX', PREFIX, $sql));
				}
			}

			// Сохраняем системное сообщение в журнал
			reportLog($_SESSION['user_name'] . ' - установил модуль (' . $modul['ModulName'] . ')', 2, 2);
		}

		// Выполняем обновление страницы со списком модулей
		header('Location:index.php?do=modules&cp=' . SESSION);
		exit;
	}

	/**
	 * Метод, предназначенный для обновления модуля при увеличении номера версии модуля
	 *
	 */
	function moduleUpdate()
	{
		global $AVE_DB, $AVE_Template;

		$modul_sql_update = array();

		$mod_file = BASE_DIR . '/modules/' . MODULE_PATH . '/modul.php';
		$sql_file = BASE_DIR . '/modules/' . MODULE_PATH . '/sql.php';
		if (is_file($mod_file) && is_file($sql_file) && @include($mod_file) && @include($sql_file))
		{
			// Выполняем запросы обновления модуля
			// из массива $modul_sql_update файла sql.php
			foreach ($modul_sql_update as $sql)
			{
				$AVE_DB->Query(str_replace('CPPREFIX', PREFIX, $sql));
			}

			// Сохраняем системное сообщение в журнад
			reportLog($_SESSION['user_name'] . ' - обновил модуль (' . MODULE_PATH . ')', 2, 2);
		}

		// Выполянем обновление страницы со списком модулей
		header('Location:index.php?do=modules&cp=' . SESSION);
		exit;
	}

	/**
	 * Метод, предназанченный для удаление модуля
	 *
	 */
	function moduleDelete()
	{
		global $AVE_DB;

		// Подключаем файл с запросами к БД для данного модуля
		$modul_sql_deinstall = array();
		$sql_file = BASE_DIR . '/modules/' . MODULE_PATH . '/sql.php';
		if (is_file($sql_file) && @include($sql_file))
		{
			// Выполняем запросы удаления таблиц модуля
			// из массива $modul_sql_deinstall файла sql.php
			foreach ($modul_sql_deinstall as $sql)
			{
				$AVE_DB->Query(str_replace('CPPREFIX', PREFIX, $sql));
			}
		}

		// Удаляем информацию о модуле в таблице module
		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_module
			WHERE ModulPfad = '" . MODULE_PATH . "'
		");

		// Сохраняем системное сообщение в журнал
		reportLog($_SESSION['user_name'] . ' - удалил модуль (' . MODULE_PATH . ')', 2, 2);

		// Выполянем обновление страницы со списком модулей
		header('Location:index.php?do=modules&cp=' . SESSION);
		exit;
	}

	/**
	 * Метод, предназначенный для отключения/включение модуля в Панели управления
	 *
	 */
	function moduleStatusChange()
	{
		global $AVE_DB;

		// Выполняем запрос к БД на смену статуса модуля
		$AVE_DB->Query("
			UPDATE " . PREFIX . "_module
			SET Status = ! Status
			WHERE ModulPfad = '" . MODULE_PATH . "'
		");

		// Выполняем обновление страницы со списком модулей
		header('Location:index.php?do=modules&cp=' . SESSION);
		exit;
	}

	/**
	 * Метод получения списка модулей
	 *
	 * @param int $status статус возвращаемых модулей
	 * <ul>
	 * <li>1 - активные модули</li>
	 * <li>0 - неактивные модули</li>
	 * </ul>
	 * если не указано возвращает модули без учета статуса
	 * @return array
	 */
	function moduleListGet($status = null)
	{
		global $AVE_DB;

		// Условие, определяющее статус документа для запроса к БД
		$where_status = ($status !== null) ? "WHERE Status = '" . (int)$status . "'" : '';

		// Выполняем запрос к БД и получаем список документов,
		// согласно статусу, либо все модули, если статус не указан
		$sql = $AVE_DB->Query("
			SELECT
				*,
				CONCAT('mod_', ModulPfad) AS mod_path
			FROM
				" . PREFIX . "_module
			" . $where_status . "
		");
		$modules = array();
		while ($row = $sql->FetchRow())
		{
			$modules[$row->ModulName] = $row;
		}

		// Возвращаем список модулей
		return $modules;
	}
}

?>