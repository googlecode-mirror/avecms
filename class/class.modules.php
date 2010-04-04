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
 *	ВНЕШНИЕ МЕТОДЫ
 */

	/**
	 * Список доступных модулей
	 *
	 */
	function showModules()
	{
		global $AVE_DB, $AVE_Template, $config_vars;

		$dir     = BASE_DIR . '/modules';
		$d       = dir($dir);

		$modules = array();

		$all_templates = array();
		$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_templates");
		while ($row = $sql->FetchRow())
		{
			array_push($all_templates, $row);
		}

		$install_modules = array();
		$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_module");
		while ($row = $sql->FetchRow())
		{
			$install_modules[$row->ModulName] = $row;
		}

		while (false !== ($entry = $d->read()))
		{
			if ($entry!='.' && $entry!='..' && $entry!='.svn' && $entry!='_svn')
			{
				$entry = $dir.'/'.$entry;
				if (is_dir($entry))
				{
					if (!include($entry . '/modul.php')) echo $config_vars['MODULES_ERROR'] . $entry . '<br />';

					$row = !empty($install_modules[$modul['ModulName']]) ? $install_modules[$modul['ModulName']] : false;

					if ($row)
					{
						$mod->status     = $row->Status;
						$mod->id         = $row->Id;
						$mod->mod_id     = $row->Id;
						$mod->version    = $row->Version;
						$mod->mod_update = ($row->Version < $modul['ModulVersion']) ? 1 : 0;
					}
					else
					{
						$mod->status     = 0;
						$mod->id         = $modul['ModulPfad'];
						$mod->mod_id     = '';
						$mod->version    = $modul['ModulVersion'];
						$mod->mod_update = 0;
					}

					if (!empty($modul['ModulTemplate']))
					{
						$mod->mt       = $modul['ModulTemplate'];
						$mod->tid      = !empty($row) ? $row->Template : '';
					}
					else
					{
						$mod->mt = '';
					}

					$mod->adminedit = (!empty($modul['AdminEdit'])) ? 1 : 0;
					$mod->copyright = $modul['MCopyright'];
					$mod->pfad      = $modul['ModulPfad'];
					$mod->mod_r     = 'mod_' . $modul['ModulPfad'];
					$mod->name      = $modul['ModulName'];
					$mod->tag       = $modul['CpEngineTagTpl'];
					$mod->autor     = $modul['Autor'];
					$mod->descr     = $modul['Beschreibung'];
					$mod->all_tmpl  = $all_templates;
					$mod->ol_info   = $mod->descr
									. '<br><br><b>' . $config_vars['MODULES_AUTHOR'] . '</b><br>'
									. $mod->autor . '<br><em>' . $mod->copyright . '</em>';

					$modules[$mod->name] = $mod;

					unset($modul, $mod, $row);
				}
			}
		}

		$d->Close();
		ksort($modules);
		$AVE_Template->assign('modules', $modules);
		$AVE_Template->assign('content', $AVE_Template->fetch('modules/modules.tpl'));
	}

	/**
	 * Запись настроек
	 *
	 */
	function quickSave()
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
	function installModule()
	{
		global $AVE_DB;

		include(BASE_DIR . '/modules/' . MODULE_PATH . '/modul.php');
		@include_once(BASE_DIR . '/modules/' . MODULE_PATH . '/sql.php');

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

		$modul['ModulTemplate'] = (!empty($modul['ModulTemplate'])) ? $modul['ModulTemplate'] : 0;

		$AVE_DB->Query("
			INSERT " . PREFIX . "_module
			SET
				ModulName     = '" . $modul['ModulName'] . "',
				`Status`      = 1,
				CpEngineTag   = '" . $modul['CpEngineTag'] . "',
				CpPHPTag      = '" . $modul['CpPHPTag'] . "',
				ModulFunktion = '" . $modul['ModulFunktion'] . "',
				IstFunktion   = '" . $modul['IstFunktion'] . "',
				ModulPfad     = '" . $modul['ModulPfad'] . "',
				Version       = '" . $modul['ModulVersion'] . "',
				Template      = '" . $modul['ModulTemplate'] . "'
		");

		reportLog($_SESSION['user_name'] . ' - установил модуль (' . $modul['ModulName'] . ')', 2, 2);

		header('Location:index.php?do=modules&cp=' . SESSION);
		exit;
	}

	/**
	 * Обновление модуля
	 *
	 */
	function updateModule()
	{
		global $AVE_DB;

		include(BASE_DIR . '/modules/' . MODULE_PATH . '/modul.php');
		@include_once(BASE_DIR . '/modules/' . MODULE_PATH . '/sql.php');

		foreach ($modul_sql_update as $update)
		{
			$update = str_replace('CPPREFIX', PREFIX, $update);
			$AVE_DB->Query($update);
			reportLog($_SESSION['user_name'] . ' - обновил модуль (' . MODULE_PATH . ')', 2, 2);
		}

		header('Location:index.php?do=modules&cp=' . SESSION);
		exit;
	}

	/**
	 * Удаление модуля
	 *
	 */
	function deleteModule()
	{
		global $AVE_DB;

		include(BASE_DIR . '/modules/' . MODULE_PATH . '/modul.php');
		@include_once(BASE_DIR . '/modules/' . MODULE_PATH . '/sql.php');

		foreach ($modul_sql_deinstall as $deinstall)
		{
			$deinstall = str_replace('CPPREFIX', PREFIX, $deinstall);
			$AVE_DB->Query($deinstall);
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
	function OnOff()
	{
		global $AVE_DB;

	    $sql = $AVE_DB->Query("SELECT `Status`
	    	FROM " . PREFIX . "_module
			WHERE ModulPfad = '" . MODULE_PATH . "'
	    ");
	    $row = $sql->fetchrow();

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_module
			SET Status = '" . (($row->Status == 0) ? 1 : 0) . "'
			WHERE ModulPfad = '" . MODULE_PATH . "'
		");

		header('Location:index.php?do=modules&cp=' . SESSION);
		exit;
	}

/**
 *	ВНУТРЕННИЕ МЕТОДЫ
 */

}

?>