<?php

/**
 * AVE.cms
 *
 * �����, ��������������� ��� ������ � �������� � ������ ����������
 *
 * @package AVE.cms
 * @filesource
 */

class AVE_Module
{

/**
 *	�������� ������
 */

/**
 *	���������� ������
 */

/**
 *	������� ������
 */

	/**
	 * �����, �������������� ��� ��������� ������ ���� �������
	 *
	 */
	function moduleList()
	{
		global $AVE_DB, $AVE_Template;

		$assign                = array(); // ������ ��� �������� � Smarty
		$errors                = array(); // ������ � ��������
		$installed_modules     = array(); // ������ ������������� �������
		$not_installed_modules = array(); // ������ ��������������� �������

		$author_title = $AVE_Template->get_config_vars('MODULES_AUTHOR');

		// �������� ������ ���� ��������
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

		// �������� �� �� ���������� � ���� ������������� �������
		$modules = $this->moduleListGet();

		// ���������� ����������, ��� ��������� ������
//		$path = BASE_DIR . '/modules';
		$d = dir(BASE_DIR . '/modules');

		// ���������� ������������ ����������
		while (false !== ($entry = $d->read()))
		{
			if (substr($entry, 0, 1) == '.') continue;

			$module_dir = $d->path . '/' . $entry;
			if (!is_dir($module_dir)) continue;

			$modul = array();
			if (!(is_file($module_dir . '/modul.php') && @include($module_dir . '/modul.php')))
			{
				// ���� �� ������� ���������� �������� ���� ������ modul.php - ��������� ������
				$errors[] = $AVE_Template->get_config_vars('MODULES_ERROR') . $entry;
				continue;
			}

			// ��������� ������ � ����������� � ������
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

				// ������ � �������������� ��������
				$installed_modules[$mod->name] = $mod;
			}
			else
			{
				$mod->status   = false;
				$mod->id       = $modul['ModulPfad'];
				$mod->version  = $modul['ModulVersion'];
				$mod->template = isset($modul['ModulTemplate']) ? $modul['ModulTemplate'] : '';

				// ������ � ���������������� ��������
				$not_installed_modules[$mod->name] = $mod;
			}
		}
		$d->Close();

		// ���������� ������ � �������������� ��������
		ksort($installed_modules);
		$assign['installed_modules'] = $installed_modules;

		// ���������� ������ � ���������������� ��������
		ksort($not_installed_modules);
		$assign['not_installed_modules'] = $not_installed_modules;

		// ���������� ������ �� ������� ��������� ��������
		$assign['all_templates'] = $all_templates;

		// ������ � ��������
		$assign['errors'] = $errors;

		// �������� ������ � ������ � ���������� �������� �� ������� �������
		$AVE_Template->assign($assign);
		$AVE_Template->assign('content', $AVE_Template->fetch('modules/modules.tpl'));
	}

	/**
	 * �����, ��������������� ��� ���������� � �� ���������� � �������� �������
	 *
	 */
	function moduleOptionsSave()
	{
		global $AVE_DB;

		// ���������� ������������ ������ � ����������� � �������� �������
		foreach ($_POST['Template'] as $id => $template_id)
		{
			// ���������� ���������� � ������� ������
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_module
				SET Template = '" . (int)$template_id . "'
				WHERE Id = '" . (int)$id . "'
			");
		}

		// ��������� ���������� �������� �� ������� �������
		header('Location:index.php?do=modules&cp=' . SESSION);
		exit;
	}

	/**
	 * �����, ��������������� ��� ��������� ��� ������������� ������
	 *
	 */
	function moduleInstall()
	{
		global $AVE_DB, $AVE_Template;

		$modul = array();

		// ���������� �������� ����������� ���� ������
		$mod_file = BASE_DIR . '/modules/' . MODULE_PATH . '/modul.php';
		if (is_file($mod_file) && @include($mod_file))
		{
			// ������� ���������� � ������ � ������� module
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_module
				WHERE ModulPfad = '" . MODULE_PATH . "'
			");

			// ����������, ����� �� ������ ����������� ��������� � ������ ����������
			$modul['AdminEdit'] = (!empty($modul['AdminEdit'])) ? $modul['AdminEdit'] : 0;

			// ����������, ����� �� ������ ����������� ����� �������
			$modul['ModulTemplate'] = (!empty($modul['ModulTemplate'])) ? $modul['ModulTemplate'] : 0;

			// ��������� ���������� � ������ � ������� module
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

			// ���������� ���� � ��������� � �� ��� ������� ������
			$modul_sql_deinstall = array();
			$modul_sql_install = array();
			$sql_file = BASE_DIR . '/modules/' . MODULE_PATH . '/sql.php';
			if (is_file($sql_file) && @include($sql_file))
			{
				// ��������� ������� �������� ������ ������
				// �� ������� $modul_sql_deinstall ����� sql.php
				foreach ($modul_sql_deinstall as $sql)
				{
					$AVE_DB->Query(str_replace('CPPREFIX', PREFIX, $sql));
				}

				// ��������� ������� �������� ������ � ������ ������
				// �� ������� $modul_sql_install ����� sql.php
				foreach ($modul_sql_install as $sql)
				{
					$AVE_DB->Query(str_replace('CPPREFIX', PREFIX, $sql));
				}
			}

			// ��������� ��������� ��������� � ������
			reportLog($_SESSION['user_name'] . ' - ��������� ������ (' . $modul['ModulName'] . ')', 2, 2);
		}

		// ��������� ���������� �������� �� ������� �������
		header('Location:index.php?do=modules&cp=' . SESSION);
		exit;
	}

	/**
	 * �����, ��������������� ��� ���������� ������ ��� ���������� ������ ������ ������
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
			// ��������� ������� ���������� ������
			// �� ������� $modul_sql_update ����� sql.php
			foreach ($modul_sql_update as $sql)
			{
				$AVE_DB->Query(str_replace('CPPREFIX', PREFIX, $sql));
			}

			// ��������� ��������� ��������� � ������
			reportLog($_SESSION['user_name'] . ' - ������� ������ (' . MODULE_PATH . ')', 2, 2);
		}

		// ��������� ���������� �������� �� ������� �������
		header('Location:index.php?do=modules&cp=' . SESSION);
		exit;
	}

	/**
	 * �����, ��������������� ��� �������� ������
	 *
	 */
	function moduleDelete()
	{
		global $AVE_DB;

		// ���������� ���� � ��������� � �� ��� ������� ������
		$modul_sql_deinstall = array();
		$sql_file = BASE_DIR . '/modules/' . MODULE_PATH . '/sql.php';
		if (is_file($sql_file) && @include($sql_file))
		{
			// ��������� ������� �������� ������ ������
			// �� ������� $modul_sql_deinstall ����� sql.php
			foreach ($modul_sql_deinstall as $sql)
			{
				$AVE_DB->Query(str_replace('CPPREFIX', PREFIX, $sql));
			}
		}

		// ������� ���������� � ������ � ������� module
		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_module
			WHERE ModulPfad = '" . MODULE_PATH . "'
		");

		// ��������� ��������� ��������� � ������
		reportLog($_SESSION['user_name'] . ' - ������ ������ (' . MODULE_PATH . ')', 2, 2);

		// ��������� ���������� �������� �� ������� �������
		header('Location:index.php?do=modules&cp=' . SESSION);
		exit;
	}

	/**
	 * �����, ��������������� ��� ����������/��������� ������ � ������ ����������
	 *
	 */
	function moduleStatusChange()
	{
		global $AVE_DB;

		// ��������� ������ � �� �� ����� ������� ������
		$AVE_DB->Query("
			UPDATE " . PREFIX . "_module
			SET Status = ! Status
			WHERE ModulPfad = '" . MODULE_PATH . "'
		");

		// ��������� ���������� �������� �� ������� �������
		header('Location:index.php?do=modules&cp=' . SESSION);
		exit;
	}

	/**
	 * ����� ��������� ������ �������
	 *
	 * @param int $status ������ ������������ �������
	 * <ul>
	 * <li>1 - �������� ������</li>
	 * <li>0 - ���������� ������</li>
	 * </ul>
	 * ���� �� ������� ���������� ������ ��� ����� �������
	 * @return array
	 */
	function moduleListGet($status = null)
	{
		global $AVE_DB;

		// �������, ������������ ������ ��������� ��� ������� � ��
		$where_status = ($status !== null) ? "WHERE Status = '" . (int)$status . "'" : '';

		// ��������� ������ � �� � �������� ������ ����������,
		// �������� �������, ���� ��� ������, ���� ������ �� ������
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

		// ���������� ������ �������
		return $modules;
	}
}

?>