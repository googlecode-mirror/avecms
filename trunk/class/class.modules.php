<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * Класс работы с модулями
 */
class AVE_Module
{

/**
 *	СВОЙСТВА
 */


/**
 *	ВНУТРЕННИЕ МЕТОДЫ
 */


/**
 *	ВНЕШНИЕ МЕТОДЫ
 */

	/**
	 * Список доступных модулей
	 *
	 */
	function moduleList()
	{
		global $AVE_DB, $AVE_Template;

		$assign = array();
		$installed_modules = array();
		$not_installed_modules = array();
		$errors = array();
		$skip_dirs = array('.', '..', '.svn', '_svn');

		$author_title = $AVE_Template->get_config_vars('MODULES_AUTHOR');

		$all_templates = array();
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

		$modules = $this->moduleListGet();

		$dir = BASE_DIR . '/modules';
		$d = dir($dir);
		while (false !== ($entry = $d->read()))
		{
			if (!in_array($entry, $skip_dirs))
			{
				$entry = $dir . '/' . $entry;
				if (is_dir($entry))
				{
					$modul = $mod = '';

					if (@ !include($entry . '/modul.php'))
					{
						$errors[] = $AVE_Template->get_config_vars('MODULES_ERROR') . $entry;
					}
					else
					{
						$row = !empty($modules[$modul['ModulName']])
							? $modules[$modul['ModulName']]
							: false;

						$mod->permission = check_permission('mod_' . $modul['ModulPfad']);
						$mod->adminedit  = !empty($modul['AdminEdit']);
						$mod->path       = $modul['ModulPfad'];
						$mod->name       = $modul['ModulName'];
						$mod->tag        = $modul['CpEngineTagTpl'];
						$mod->info       = $modul['Beschreibung']
											. '<br><br><b>' . $author_title . '</b>'
											. '<br>' . $modul['Autor']
											. '<br><em>' . $modul['MCopyright'] . '</em>';

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

		ksort($installed_modules);
		$assign['installed_modules'] = $installed_modules;

		ksort($not_installed_modules);
		$assign['not_installed_modules'] = $not_installed_modules;

		$assign['all_templates'] = $all_templates;

		if (!empty($errors)) $assign['errors'] = $errors;

		$AVE_Template->assign($assign);
		$AVE_Template->assign('content', $AVE_Template->fetch('modules/modules.tpl'));
	}

	/**
	 * Запись настроек
	 *
	 */
	function moduleOptionsSave()
	{
		global $AVE_DB;

		foreach ($_POST['Template'] as $id => $template)
		{
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_module
				SET Template = '" . $template . "'
				WHERE Id = '" . $id . "'
			");
		}

		header('Location:index.php?do=modules&cp=' . SESSION);
		exit;
	}

	/**
	 * Установка модуля
	 *
	 */
	function moduleInstall()
	{
		global $AVE_DB, $AVE_Template;

		$modul = array();
		$modul_sql_deinstall = array();
		$modul_sql_install = array();

		@include(BASE_DIR . '/modules/' . MODULE_PATH . '/modul.php');
		@include(BASE_DIR . '/modules/' . MODULE_PATH . '/sql.php');

		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_module
			WHERE ModulPfad = '" . MODULE_PATH . "'
		");

		foreach ($modul_sql_deinstall as $sql)
		{
			$AVE_DB->Query(str_replace('CPPREFIX', PREFIX, $sql));
		}

		foreach ($modul_sql_install as $sql)
		{
			$AVE_DB->Query(str_replace('CPPREFIX', PREFIX, $sql));
		}

		$modul['AdminEdit'] = (!empty($modul['AdminEdit'])) ? $modul['AdminEdit'] : 0;
		$modul['ModulTemplate'] = (!empty($modul['ModulTemplate'])) ? $modul['ModulTemplate'] : 0;

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

		reportLog($_SESSION['user_name'] . ' - установил модуль (' . $modul['ModulName'] . ')', 2, 2);

		header('Location:index.php?do=modules&cp=' . SESSION);
		exit;
	}

	/**
	 * Обновление модуля
	 *
	 */
	function moduleUpdate()
	{
		global $AVE_DB;

		$modul_sql_update = array();

		@include(BASE_DIR . '/modules/' . MODULE_PATH . '/modul.php');
		@include(BASE_DIR . '/modules/' . MODULE_PATH . '/sql.php');

		foreach ($modul_sql_update as $sql)
		{
			$AVE_DB->Query(str_replace('CPPREFIX', PREFIX, $sql));
		}

		reportLog($_SESSION['user_name'] . ' - обновил модуль (' . MODULE_PATH . ')', 2, 2);

		header('Location:index.php?do=modules&cp=' . SESSION);
		exit;
	}

	/**
	 * Удаление модуля
	 *
	 */
	function moduleDelete()
	{
		global $AVE_DB;

		$modul_sql_deinstall = array();

		@include(BASE_DIR . '/modules/' . MODULE_PATH . '/modul.php');
		@include(BASE_DIR . '/modules/' . MODULE_PATH . '/sql.php');

		foreach ($modul_sql_deinstall as $sql)
		{
			$AVE_DB->Query(str_replace('CPPREFIX', PREFIX, $sql));
		}

		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_module
			WHERE ModulPfad = '" . MODULE_PATH . "'
		");

		reportLog($_SESSION['user_name'] . ' - удалил модуль (' . MODULE_PATH . ')', 2, 2);

		header('Location:index.php?do=modules&cp=' . SESSION);
		exit;
	}

	/**
	 * Отключение/включение модуля
	 *
	 */
	function moduleStatusChange()
	{
		global $AVE_DB;

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_module
			SET Status = ! Status
			WHERE ModulPfad = '" . MODULE_PATH . "'
		");

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

		$where_status = ($status !== null)
			? "WHERE Status = '" . $status . "'"
			: '';

		$modules = array();
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

		return $modules;
	}
}

?>