<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * Класс работы с рубриками
 */
class AVE_Rubric
{

/**
 *	СВОЙСТВА
 */

	/**
	 * Количество рубрик на странице
	 *
	 * @var int
	 */
	var $_limit = 15;

/**
 *	ВНУТРЕННИЕ МЕТОДЫ
 */


/**
 *	ВНЕШНИЕ МЕТОДЫ
 */

	/**
	 * Вывод списка рубрик
	 *
	 */
	function rubricList()
	{
		global $AVE_DB, $AVE_Template;

		$rubrics = array();
		$num = $AVE_DB->Query("SELECT COUNT(*) FROM " . PREFIX . "_rubrics")->GetCell();

		$page_limit = $this->_limit;
		$seiten = ceil($num / $page_limit);
		$set_start = get_current_page() * $page_limit - $page_limit;

		if ($num > $page_limit)
		{
			$page_nav = " <a class=\"pnav\" href=\"index.php?do=rubs&page={s}&cp=" . SESSION . "\">{t}</a> ";
			$page_nav = get_pagination($seiten, 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}

		$sql = $AVE_DB->Query("
			SELECT
				rub.*,
				COUNT(doc.Id) AS doc_count
			FROM
				" . PREFIX . "_rubrics AS rub
			LEFT JOIN
				" . PREFIX . "_documents AS doc
					ON RubrikId = rub.Id
			GROUP BY rub.Id
			LIMIT " . $set_start . "," . $page_limit
		);
		while ($row = $sql->FetchRow())
		{
			array_push($rubrics, $row);
		}

		$AVE_Template->assign('rubrics', $rubrics);
	}

	/**
	 * создание рубрики
	 *
	 */
	function rubricNew()
	{
		global $AVE_DB, $AVE_Template;

		switch ($_REQUEST['sub'])
		{
			case '':
				$AVE_Template->assign('AlleVorlagen', get_all_templates());
				$AVE_Template->assign('content', $AVE_Template->fetch('rubs/rubnew.tpl'));
				break;

			case 'save':
				$errors = array();

				if (empty($_POST['RubrikName']))
				{
					array_push($errors, $AVE_Template->get_config_vars('RUBRIK_NO_NAME'));
				}
				else
				{
					$name_exist = $AVE_DB->Query("
						SELECT 1
						FROM " . PREFIX . "_rubrics
						WHERE RubrikName = '" . $_POST['RubrikName'] . "'
						LIMIT 1
					")->NumRows();

					if ($name_exist) array_push($errors, $AVE_Template->get_config_vars('RUBRIK_NAME_EXIST'));

					if (!empty($_POST['UrlPrefix']))
					{
						if (preg_match(TRANSLIT_URL ? '/[^\%HYa-z0-9\/-]+/' : '/[^\%HYa-zа-яёїєі0-9\/-]+/', $_POST['UrlPrefix']))
						{
							array_push($errors, $AVE_Template->get_config_vars('RUBRIK_PREFIX_BAD_CHAR'));
						}
						else
						{
							$prefix_exist = $AVE_DB->Query("
								SELECT 1
								FROM " . PREFIX . "_rubrics
								WHERE UrlPrefix = '" . $_POST['UrlPrefix'] . "'
								LIMIT 1
							")->NumRows();

							if ($prefix_exist) array_push($errors, $AVE_Template->get_config_vars('RUBRIK_PREFIX_EXIST'));
						}
					}

					if (!empty($errors))
					{
						$AVE_Template->assign('errors', $errors);
						$AVE_Template->assign('AlleVorlagen', get_all_templates());
						$AVE_Template->assign('content', $AVE_Template->fetch('rubs/rubnew.tpl'));
					}
					else
					{
						$AVE_DB->Query("
							INSERT " . PREFIX . "_rubrics
							SET
								RubrikName = '" . $_POST['RubrikName'] . "',
								UrlPrefix  = '" . $_POST['UrlPrefix'] . "',
								Vorlage    = '" . intval($_POST['Vorlage']) . "',
								RBenutzer  = '" . $_SESSION['user_id'] . "',
								RDatum     = '" . time() . "'
						");
						$iid = $AVE_DB->InsertId();

						reportLog($_SESSION['user_name'] . ' - добавил рубрику (' . stripslashes($_POST['RubrikName']) . ')', 2, 2);

						header('Location:index.php?do=rubs&action=edit&Id=' . $iid . '&cp=' . SESSION);
						exit;
					}
				}
				break;
		}
	}

	/**
	 * Запись настроек рубрики
	 *
	 */
	function quickSave()
	{
		global $AVE_DB;

		if (check_permission('rub_edit'))
		{
			foreach ($_POST['RubrikName'] as $rubric_id => $rubric_name)
			{
				if (!empty($rubric_name))
				{
					$set_rubric_name = '';
					$new_prefix = '';

					$name_exist = $AVE_DB->Query("
						SELECT 1
						FROM " . PREFIX . "_rubrics
						WHERE
							RubrikName = '" . $rubric_name . "'
						AND
							Id != '" . $rubric_id . "'
						LIMIT 1
					")->NumRows();

					if (!$name_exist)
					{
						$set_rubric_name = "RubrikName = '" . $rubric_name . "',";
					}

					if (!empty($_POST['UrlPrefix'][$rubric_id]))
					{
						if (!(preg_match((TRANSLIT_URL ? '/[^\%HYa-z0-9\/-]+/' : '/[^\%HYa-zа-яёїєі0-9\/-]+/'), $_POST['UrlPrefix'][$rubric_id])))
						{
							$prefix_exist = $AVE_DB->Query("
								SELECT 1
								FROM " . PREFIX . "_rubrics
								WHERE
									UrlPrefix = '" . $_POST['UrlPrefix'][$rubric_id] . "'
								AND
									Id != '" . $rubric_id . "'
								LIMIT 1
							")->NumRows();

							if (!$prefix_exist)
							{
								$new_prefix = "UrlPrefix = '" . $_POST['UrlPrefix'][$rubric_id] . "',";
							}
						}
					}

					$AVE_DB->Query("
						UPDATE " . PREFIX . "_rubrics
						SET
							" . $set_rubric_name . "
							" . $new_prefix . "
							Vorlage = '" . $_POST['Vorlage'][$rubric_id] . "'
						WHERE
							Id = '" . $rubric_id . "'
					");
				}
			}

			$page = !empty($_REQUEST['page']) ? '&page=' . $_REQUEST['page'] : '' ;
			header('Location:index.php?do=rubs' . $page . '&cp=' . SESSION);
		}
		else
		{
			define('NOPERM', 1);
		}
	}

	/**
	 * Копирование рубрики
	 *
	 */
	function rubricCopy()
	{
		global $AVE_DB, $AVE_Template;

		$rubric_id = (int)$_REQUEST['Id'];

		$errors = array();

		if (empty($_REQUEST['RubrikName']))
		{
			array_push($errors, $AVE_Template->get_config_vars('RUBRIK_NO_NAME'));
		}
		else
		{
			$name_exist = $AVE_DB->Query("
				SELECT 1
				FROM " . PREFIX . "_rubrics
				WHERE RubrikName = '" . $_POST['RubrikName'] . "'
				LIMIT 1
			")->NumRows();

			if ($name_exist) array_push($errors, $AVE_Template->get_config_vars('RUBRIK_NAME_EXIST'));
		}

		if (!empty($_POST['UrlPrefix']))
		{
			if (preg_match(TRANSLIT_URL ? '/[^\%HYa-z0-9\/-]+/' : '/[^\%HYa-zа-яёїєі0-9\/-]+/', $_POST['UrlPrefix']))
			{
				array_push($errors, $AVE_Template->get_config_vars('RUBRIK_PREFIX_BAD_CHAR'));
			}
			else
			{
				$prefix_exist = $AVE_DB->Query("
					SELECT 1
					FROM " . PREFIX . "_rubrics
					WHERE UrlPrefix = '" . $_POST['UrlPrefix'] . "'
					LIMIT 1
				")->NumRows();

				if ($prefix_exist) array_push($errors, $AVE_Template->get_config_vars('RUBRIK_PREFIX_EXIST'));
			}
		}

		$row = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_rubrics
			WHERE Id = '" . $rubric_id . "'
		")->FetchRow();

		if (!$row) array_push($errors, $AVE_Template->get_config_vars('RUBRIK_NO_RUBRIK'));

		if (!empty($errors))
		{
			$AVE_Template->assign('errors', $errors);
		}
		else
		{
			$AVE_DB->Query("
				INSERT " . PREFIX . "_rubrics
				SET
					RubrikName     = '" . $_POST['RubrikName'] . "',
					UrlPrefix      = '" . $_POST['UrlPrefix'] . "',
					RubrikTemplate = '" . addslashes($row->RubrikTemplate) . "',
					Vorlage        = '" . addslashes($row->Vorlage) . "',
					RBenutzer      = '" . (int)$_SESSION['user_id'] . "',
					RDatum         = '" . time() . "'
			");
			$iid = $AVE_DB->InsertId();

			$sql = $AVE_DB->Query("
				SELECT
					BenutzerGruppe,
					Rechte
				FROM " . PREFIX . "_document_permissions
				WHERE RubrikId = '" . $rubric_id . "'
			");
			while ($row = $sql->FetchRow())
			{
				$AVE_DB->Query("
					INSERT " . PREFIX . "_document_permissions
					SET
						RubrikId       = '" . $iid . "',
						BenutzerGruppe = '" . (int)$row->BenutzerGruppe . "',
						Rechte         = '" . addslashes($row->Rechte) . "'
				");
			}

			$sql = $AVE_DB->Query("
				SELECT
					Titel,
					RubTyp,
					rubric_position,
					StdWert
				FROM " . PREFIX . "_rubric_fields
				WHERE RubrikId = '" . $rubric_id . "'
				ORDER BY rubric_position ASC
			");
			while ($row = $sql->FetchRow())
			{
				$AVE_DB->Query("
					INSERT " . PREFIX . "_rubric_fields
					SET
						RubrikId        = '" . $iid . "',
						Titel           = '" . addslashes($row->Titel) . "',
						RubTyp          = '" . addslashes($row->RubTyp) . "',
						rubric_position = '" . (int)$row->rubric_position . "',
						StdWert         = '" . addslashes($row->StdWert) . "'
				");
			}

			reportLog($_SESSION['user_name'] . ' - создал копию рубрики (' . $rubric_id . ')', 2, 2);

			echo '<script>window.opener.location.reload();window.close();</script>';
		}
	}

	/**
	 * Удаление рубрики
	 *
	 */
	function rubricDelete()
	{
		global $AVE_DB;

		$rubric_id = (int)$_REQUEST['Id'];

		if ($rubric_id <= 1)
		{
			header('Location:index.php?do=rubs&cp=' . SESSION);
			exit;
		}

		$rubric_not_empty = $AVE_DB->Query("
			SELECT 1
			FROM " . PREFIX . "_documents
			WHERE RubrikId = '" . $rubric_id . "'
			LIMIT 1
		")->GetCell();

		if (!$rubric_not_empty)
		{
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_rubrics
				WHERE Id = '" . $rubric_id . "'
			");
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_rubric_fields
				WHERE RubrikId = '" . $rubric_id . "'
			");
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_document_permissions
				WHERE RubrikId = '" . $rubric_id . "'
			");
			// Очищаем кэш шаблона документов рубрики
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_rubric_template_cache
				WHERE rub_id = '" . $rubric_id . "'
			");

			reportLog($_SESSION['user_name'] . ' - удалил рубрику (' . $rubric_id . ')', 2, 2);
		}

		header('Location:index.php?do=rubs&cp=' . SESSION);
		exit;
	}

	/**
	 * Вывод списка полей рубрики
	 *
	 */
	function rubricFieldShow()
	{
		global $AVE_DB, $AVE_Template;

		$rubric_id = (int)$_REQUEST['Id'];

		$rub_fields = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_rubric_fields
			WHERE RubrikId = '" . $rubric_id . "'
			ORDER BY rubric_position ASC
		");

		while ($row = $sql->FetchRow())
		{
			array_push($rub_fields,$row);
		}

		$AVE_Template->assign('rub_fields', $rub_fields);

		$groups = array();
		$sql = $AVE_DB->Query("SELECT * FROM " . PREFIX . "_user_groups");

		while ($row = $sql->FetchRow())
		{
			$row->doall = ($row->Benutzergruppe == 1) ? ' disabled="disabled" checked="checked"' : '';
			$row->doall_h = ($row->Benutzergruppe == 1) ? 1 : '';

			$sql_doc_perm = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_document_permissions
				WHERE Benutzergruppe = '" . $row->Benutzergruppe . "'
				AND RubrikId = '" . $rubric_id . "'
			");
			$row_doc_perm = $sql_doc_perm->FetchRow();
			$permissions = @explode('|', $row_doc_perm->Rechte);
			$row->permissions = $permissions;

			array_push($groups,$row);
		}
		$sql = $AVE_DB->Query("
			SELECT RubrikName
			FROM " . PREFIX . "_rubrics
			WHERE id = '" . $rubric_id . "'
			LIMIT 1
		");
		$rubrikName = $sql->GetCell();
		$AVE_Template->assign('RubrikName', $rubrikName);
		$AVE_Template->assign('groups', $groups);
		$AVE_Template->assign('felder', get_field_type());
		$AVE_Template->assign('content', $AVE_Template->fetch('rubs/rub_fields.tpl'));
	}

	/**
	 * Создание нового поля рубрики
	 *
	 */
	function rubricFieldNew()
	{
		global $AVE_DB;

		$rubric_id = (int)$_REQUEST['Id'];

		if (!empty($_POST['TitelNew']))
		{
			$position = (!empty($_POST['RubPositionNew'])) ? $_POST['RubPositionNew'] : 1;

			$AVE_DB->Query("
				INSERT " . PREFIX . "_rubric_fields
				SET
					RubrikId        = '" . $rubric_id . "',
					Titel           = '" . $_POST['TitelNew'] . "',
					RubTyp          = '" . $_POST['RubTypNew'] . "',
					rubric_position = '" . $position . "',
					StdWert         = '" . $_POST['StdWertNew'] . "'
			");
			$Update_RubrikFeld = $AVE_DB->InsertId();

			$sql = $AVE_DB->Query("
				SELECT Id
				FROM " . PREFIX . "_documents
				WHERE RubrikId = '" . $rubric_id . "'
			");

			while ($row = $sql->FetchRow())
			{
				$AVE_DB->Query("
					INSERT " . PREFIX . "_document_fields
					SET
						RubrikFeld = '" . $Update_RubrikFeld . "',
						DokumentId = '" . $row->Id . "'
				");
			}

			reportLog($_SESSION['user_name'] . ' - добавил поле рубрики (' . stripslashes($_POST['TitelNew']) . ')', 2, 2);
		}

		header('Location:index.php?do=rubs&action=edit&Id=' . $rubric_id . 'cp=' . SESSION);
		exit;
	}

	/**
	 * Управление полями рубрики
	 *
	 */
	function rubricFieldSave()
	{
		global $AVE_DB;

		$rubric_id = (int)$_REQUEST['Id'];

		foreach ($_POST['Titel'] as $id => $Titel)
		{
			if (!empty($Titel))
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_rubric_fields
					SET
						Titel           = '" . $Titel . "',
						RubTyp          = '" . $_POST['RubTyp'][$id] . "',
						rubric_position = '" . $_POST['RubPosition'][$id] . "',
						StdWert         = '" . $_POST['StdWert'][$id] . "',
						tpl_field       = '" . $_POST['tpl_field'][$id] . "',
						tpl_req         = '" . $_POST['tpl_req'][$id] . "'
					WHERE
						Id = '" . $id . "'
				");
				// Очищаем кэш шаблона документов рубрики
				$AVE_DB->Query("
					DELETE
					FROM " . PREFIX . "_rubric_template_cache
					WHERE rub_id = '" . $rubric_id . "'
				");
				reportLog($_SESSION['user_name'] . ' - отредактировал поле рубрики (' . stripslashes($Titel) . ')', 2, 2);
			}
		}

		foreach ($_POST['del'] as $id => $Del)
		{
			if (!empty($Del))
			{
				$AVE_DB->Query("
					DELETE
					FROM " . PREFIX . "_rubric_fields
					WHERE Id = '" . $id . "'
					AND RubrikId = '" . $rubric_id . "'
				");
				$AVE_DB->Query("
					DELETE
					FROM " . PREFIX . "_document_fields
					WHERE RubrikFeld = '" . $id . "'
				");
				// Очищаем кэш шаблона документов рубрики
				$AVE_DB->Query("
					DELETE
					FROM " . PREFIX . "_rubric_template_cache
					WHERE rub_id = '" . $rubric_id . "'
				");

				reportLog($_SESSION['user_name'] . ' - удалил поле рубрики (' . stripslashes($_POST['Titel'][$id]) . ')', 2, 2);
			}
		}

		header('Location:index.php?do=rubs&action=edit&Id=' . $rubric_id . '&cp=' . SESSION);
		exit;
	}

	/**
	 * Вывод шаблона рубрики
	 *
	 * @param int $show
	 * @param int $extern
	 */
	function rubricTemplateShow($show = '', $extern = '0')
	{
		global $AVE_DB, $AVE_Template;

		if ($extern==1)
		{
			$fetchId = (isset($_REQUEST['RubrikId']) && is_numeric($_REQUEST['RubrikId'])) ? $_REQUEST['RubrikId'] : 0;
		}
		else
		{
			$fetchId = (isset($_REQUEST['Id']) && is_numeric($_REQUEST['Id'])) ? $_REQUEST['Id'] : 0;
		}

		$row = $AVE_DB->Query("
			SELECT
				RubrikName,
				RubrikTemplate
			FROM " . PREFIX . "_rubrics
			WHERE Id = '" . $fetchId . "'
		")
		->FetchRow();

		$tags = array();
		$ddid = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_rubric_fields
			WHERE RubrikId = '" . $fetchId . "'
			ORDER BY rubric_position ASC
		");

		while ($row_rf = $sql->FetchRow())
		{
			array_push($tags, $row_rf);
			if ($row_rf->RubTyp == 'dropdown') array_push($ddid, $row_rf->Id);
		}
		$sql->Close();

		$AVE_Template->assign('feld_array', get_field_type());

		if ($show == 1 ) $row->RubrikTemplate = stripslashes($_POST['RubrikTemplate']);

		if ($extern == 1)
		{
			$AVE_Template->assign('tags_row', $row);
			$AVE_Template->assign('tags', $tags);
			$AVE_Template->assign('ddid', implode(',', $ddid));
		}
		else
		{
			$AVE_Template->assign('row', $row);
			$AVE_Template->assign('tags', $tags);
			$AVE_Template->assign('formaction', 'index.php?do=rubs&action=template&sub=save&Id=' . $fetchId . '&cp=' . SESSION);
			$AVE_Template->assign('content', $AVE_Template->fetch('rubs/form.tpl'));
		}
	}

	/**
	 * Редактирование шаблона рубрики
	 *
	 * @param string $data
	 */
	function rubricTemplateSave($data)
	{
		global $AVE_DB;

		$rubric_id = (int)$_REQUEST['Id'];

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_rubrics
			SET RubrikTemplate = '" . $data . "'
			WHERE Id = '" . $rubric_id . "'
		");
		// Очищаем кэш шаблона документов рубрики
		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_rubric_template_cache
			WHERE rub_id = '" . $rubric_id . "'
		");

		reportLog($_SESSION['user_name'] . ' - отредактировал шаблон рубрики (' . $rubric_id . ')', 2, 2);
		header('Location:index.php?do=rubs&cp=' . SESSION);
	}

	/**
	 * Управление правами доступа к документам рубрик
	 *
	 */
	function rubricPermissionSave()
	{
		global $AVE_DB;

		$rubric_id = (int)$_REQUEST['Id'];

		if (check_permission('rub_perms'))
		{
			foreach ($_POST['Benutzergruppe'] as $id => $Bg)
			{
				$sql = $AVE_DB->Query("
					SELECT Id
					FROM " . PREFIX . "_document_permissions
					WHERE Benutzergruppe = '" . $Bg . "'
					AND RubrikId = '" . $rubric_id . "'
				");
				$count = $sql->NumRows();

				if ($count < 1)
				{
					$rechte = @implode('|', $_POST['perm'][$id]);
					$AVE_DB->Query("
						INSERT " . PREFIX . "_document_permissions
						SET
							RubrikId       = '" . $rubric_id . "',
							BenutzerGruppe = '" . $Bg . "',
							Rechte         = '" . $rechte . "'
					");
				}
				else
				{
					$rechte = @implode('|', $_POST['perm'][$id]);
					$AVE_DB->Query("
						UPDATE " . PREFIX . "_document_permissions
						SET
							Rechte = '" . $rechte . "'
						WHERE
							RubrikId = '" . $rubric_id . "'
						AND
							BenutzerGruppe = '" . $Bg . "'
					");
				}
			}

			header('Location:index.php?do=rubs&action=edit&Id=' . $rubric_id . '&cp=' . SESSION);
			exit;
		}
		else
		{
			define('NOPERM', 1);
		}
	}

	/**
	 * Получить наименование и URL-префикс Рубрики по идентификатору
	 *
	 * @param int $rubric_id идентификатор Рубрики
	 * @return object наименование Рубрики
	 */
	function rubricNameByIdGet($rubric_id)
	{
		global $AVE_DB;

		static $rubrics = array();

		if (!isset($rubrics[$rubric_id]))
		{
			$rubrics[$rubric_id] = $AVE_DB->Query("
				SELECT
					RubrikName,
					UrlPrefix
				FROM " . PREFIX . "_rubrics
				WHERE Id = '" . $rubric_id . "'
				LIMIT 1
			")->fetchRow();
		}

		return $rubrics[$rubric_id];
	}

	/**
	 * Формирование прав доступа Групп пользователей на все Рубрики
	 *
	 */
	function rubricPermissionFetch()
	{
		global $AVE_DB, $AVE_Document, $AVE_Template;

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT
				Id,
				RubrikName
			FROM " . PREFIX . "_rubrics
		");
		while ($row = $sql->FetchRow())
		{
			$AVE_Document->documentPermissionFetch($row->Id);

			if (defined('UGROUP') && UGROUP == 1) $row->Show = 1;
			elseif (isset($_SESSION[$row->Id . '_editown']) && $_SESSION[$row->Id . '_editown'] == 1) $row->Show = 1;
			elseif (isset($_SESSION[$row->Id . '_editall']) && $_SESSION[$row->Id . '_editall'] == 1) $row->Show = 1;
			elseif (isset($_SESSION[$row->Id . '_new'])     && $_SESSION[$row->Id . '_new']     == 1) $row->Show = 1;
			elseif (isset($_SESSION[$row->Id . '_newnow'])  && $_SESSION[$row->Id . '_newnow']  == 1) $row->Show = 1;
			elseif (isset($_SESSION[$row->Id . '_alles'])   && $_SESSION[$row->Id . '_alles']   == 1) $row->Show = 1;

			array_push($items, $row);
		}

		$AVE_Template->assign('rubrics', $items);
	}
}

?>