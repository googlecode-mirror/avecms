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

		$assign = array();
		$installed_modules = array(); // Массив установленных модулей
		$not_installed_modules = array();  // Массив неустановленных модулей
		$errors = array(); // Массив с ошибками
		$skip_dirs = array('.', '..', '.svn', '_svn'); // Список директорий запрещеных к просмотру

		$author_title = $AVE_Template->get_config_vars('MODULES_AUTHOR');

		$all_templates = array();

        // Выполняем запрос к БД на получение списка всех имеющихся шаблонов в системе
        $sql = $AVE_DB->Query("
			SELECT
				Id,
				TplName
			FROM " . PREFIX . "_templates
		");
		while ($row = $sql->FetchRow())
		{
			$all_templates[$row->Id] = htmlspecialchars($row->TplName, ENT_QUOTES);
		}

		// Получаем из БД информацию о всех установленных модулях в системе
        $modules = $this->moduleListGet();

		// Определяем директорию, где храняться модули
        $dir = BASE_DIR . '/modules';
		$d = dir($dir);
		
        // Циклически обрабатываем директории
        while (false !== ($entry = $d->read()))
		{
			if (!in_array($entry, $skip_dirs))
			{
				$entry = $dir . '/' . $entry;
				if (is_dir($entry))
				{
					$modul = $mod = '';

					// Если не удалось найти (подключить) основной файл каждого модуля modul.php
                    if (@ !include($entry . '/modul.php'))
					{
						// Фиксируем ошибку
                        $errors[] = $AVE_Template->get_config_vars('MODULES_ERROR') . $entry;
					}
					else
					{ // Если файл modul.php удалось подключить

                        // Получаем название модуля
                        $row = !empty($modules[$modul['ModulName']])
							? $modules[$modul['ModulName']]
							: false;

                        // Определяем рад переменных, хранящих информацию о модуле
						$mod->permission = check_permission('mod_' . $modul['ModulPfad']);
						$mod->adminedit  = !empty($modul['AdminEdit']);
						$mod->path       = $modul['ModulPfad'];
						$mod->name       = $modul['ModulName'];
						$mod->tag        = $modul['CpEngineTagTpl'];
						$mod->info       = $modul['Beschreibung']
											. '<br><br><b>' . $author_title . '</b>'
											. '<br>' . $modul['Autor']
											. '<br><em>' . $modul['MCopyright'] . '</em>';

						// Если название модул получено, заносим информацию о данном модуле в общий массив с 
                        // установленными модулями
                        if ($row)
						{
							$mod->status      = $row->Status;
							$mod->id          = $row->Id;
							$mod->version     = $row->Version;
							$mod->need_update = ($row->Version < $modul['ModulVersion']);
							$mod->template    = isset($row->Template) ? $row->Template : '';

							$installed_modules[$mod->name] = $mod;
						}
						else
						{
							$mod->status      = false;
							$mod->id          = $modul['ModulPfad'];
							$mod->version     = $modul['ModulVersion'];
							$mod->template    = isset($modul['ModulTemplate']) ? $modul['ModulTemplate'] : '';

							$not_installed_modules[$mod->name] = $mod;
						}
					}
				}
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

		// Если есть ошибки, фиксируем их
        if (!empty($errors)) $assign['errors'] = $errors;

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

		// Циклически обрабатываем мессив, содержащий информацию о шаблоне для каждого модуля
        foreach ($_POST['Template'] as $id => $template)
		{

            // Выполняем запрос к БД на обновление информации о шаблонах для модулей
            $AVE_DB->Query("
				UPDATE " . PREFIX . "_module
				SET Template = '" . $template . "'
				WHERE Id = '" . $id . "'
			");
		}

		// Выполянем обновление страницы со списком модулей
        header('Location:index.php?do=modules&cp=' . SESSION);
		exit;
	}

	/**
	 * Метод, предназанченный для установка модуля
	 *
	 */
	function moduleInstall()
	{
		global $AVE_DB, $AVE_Template;

		$modul = array();
		$modul_sql_deinstall = array();
		$modul_sql_install = array();

		// Подключаем основной управляющий файл модуля
        @include(BASE_DIR . '/modules/' . MODULE_PATH . '/modul.php');

        // Подключаем файл с запросами к БД для данного модуля
		@include(BASE_DIR . '/modules/' . MODULE_PATH . '/sql.php');


        // Выполняем запрос к БД на удаление имеющейся информации о данном модуле
        $AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_module
			WHERE ModulPfad = '" . MODULE_PATH . "'
		");


        // Выполняем все запросы на удаление данных о модуле из массива $modul_sql_deinstall, из файла sql.php
        foreach ($modul_sql_deinstall as $sql)
		{
			$AVE_DB->Query(str_replace('CPPREFIX', PREFIX, $sql));
		}

		// Выполняем все запросы на установку данных о модуле из массива $modul_sql_install, из файла sql.php
        foreach ($modul_sql_install as $sql)
		{
			$AVE_DB->Query(str_replace('CPPREFIX', PREFIX, $sql));
		}

		// Определаем, имеет лиданный модуль возможность управления в Панели управления
        $modul['AdminEdit'] = (!empty($modul['AdminEdit'])) ? $modul['AdminEdit'] : 0;

        // Определяем, имеет ли данный модуль возможность смены шаблона
        $modul['ModulTemplate'] = (!empty($modul['ModulTemplate'])) ? $modul['ModulTemplate'] : 0;

		// Выполняем запрос к БД на дабовление общей информации о модуле
        $AVE_DB->Query("
			INSERT " . PREFIX . "_module
			SET
				ModulName     = '" . $modul['ModulName'] . "',
				`Status`      = '1',
				CpEngineTag   = '" . $modul['CpEngineTag'] . "',
				CpPHPTag      = '" . $modul['CpPHPTag'] . "',
				ModulFunktion = '" . $modul['ModulFunktion'] . "',
				IstFunktion   = '" . $modul['IstFunktion'] . "',
				ModulPfad     = '" . $modul['ModulPfad'] . "',
				Version       = '" . $modul['ModulVersion'] . "',
				Template      = '" . $modul['ModulTemplate'] . "',
				AdminEdit     = '" . $modul['AdminEdit'] . "'
		");

		// Сохраняем системное сообщение в журнал
        reportLog($_SESSION['user_name'] . ' - установил модуль (' . $modul['ModulName'] . ')', 2, 2);

		// Выполняем обновление страницы со списком модулей
        header('Location:index.php?do=modules&cp=' . SESSION);
		exit;
	}



    /**
	 * Метод, предназначенный для переустановки модуля 
	 *
	 */
	function moduleUpdate()
	{
		global $AVE_DB;

		$modul_sql_update = array();

		// Подключаем основной управляющий файл модуля
        @include(BASE_DIR . '/modules/' . MODULE_PATH . '/modul.php');

        // Подключаем файл с запросами к БД для данного модуля
		@include(BASE_DIR . '/modules/' . MODULE_PATH . '/sql.php');

		// Выполняем все запросы из массива $modul_sql_update, из файла sql.php
        foreach ($modul_sql_update as $sql)
		{
			$AVE_DB->Query(str_replace('CPPREFIX', PREFIX, $sql));
		}


        // Сохраняем системное сообщение в журнад
        reportLog($_SESSION['user_name'] . ' - обновил модуль (' . MODULE_PATH . ')', 2, 2);

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

		$modul_sql_deinstall = array();

		// Подключаем основной управляющий файл модуля
        @include(BASE_DIR . '/modules/' . MODULE_PATH . '/modul.php');

        // Подключаем файл с запросами к БД для данного модуля
		@include(BASE_DIR . '/modules/' . MODULE_PATH . '/sql.php');

		// Выполняем все запросы из массива $modul_sql_deinstall, из файла sql.php
        foreach ($modul_sql_deinstall as $sql)
		{
			$AVE_DB->Query(str_replace('CPPREFIX', PREFIX, $sql));
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
        $where_status = ($status !== null)
			? "WHERE Status = '" . $status . "'"
			: '';

		$modules = array();

        // Выполняем запрос к БД и получаем список документов, согласно статусу, либо все модули, если статус не указан
        $sql = $AVE_DB->Query("
			SELECT
				*,
				CONCAT('mod_', ModulPfad) AS mod_path
			FROM
				" . PREFIX . "_module
			" . $where_status . "
		");

		while ($row = $sql->FetchRow())
		{
			$modules[$row->ModulName] = $row;
		}

		// Возвращаем массив данных
        return $modules;
	}
}

?>