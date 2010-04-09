<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * ����� ������ � ���������
 */
class AVE_Rubric
{

/**
 *	��������
 */

	var $_limit = 15;
	var $_tpl = 'rubs/form.tpl';

/**
 *	������� ������
 */

	/**
	 * �������� �������
	 *
	 */
	function delRub()
	{
		global $AVE_DB;

		$sql = $AVE_DB->Query("
			SELECT Id
			FROM " . PREFIX . "_documents
			WHERE RubrikId = '" . $_REQUEST['Id'] . "'
		");
		$count = $sql->NumRows();

		if ($count < 1 && $_REQUEST['Id'] != 1)
		{
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_rubrics
				WHERE Id = '" . $_REQUEST['Id'] . "'
			");
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_rubric_fields
				WHERE RubrikId = '" . $_REQUEST['Id'] . "'
			");
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_document_permissions
				WHERE RubrikId = '" . $_REQUEST['Id'] . "'
			");
			// ������� ��� ������� ���������� �������
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_rubric_template_cache
				WHERE rub_id = '" . $_REQUEST['Id'] . "'
			");
			reportLog($_SESSION['user_name'] . ' - ������ ������� (' . $_REQUEST['Id'] . ')', 2, 2);
		}
		header('Location:index.php?do=rubs&cp=' . SESSION);
	}

	/**
	 * �������� �������
	 *
	 */
	function newRub()
	{
		global $AVE_DB, $AVE_Template;

		switch ($_REQUEST['sub'])
		{
			case '':
				$AVE_Template->assign('AlleVorlagen', getAllTemplates());
				$AVE_Template->assign('content', $AVE_Template->fetch('rubs/rubnew.tpl'));
				break;

			case 'save':
				$errors = array();

				if (empty($_POST['RubrikName']))
				{
					array_push($errors, $AVE_Template->get_config_vars('RUBRIK_NO_NAME'));
//					header('Location:index.php?do=rubs&action=new&cp=' . SESSION . '&error=noname');
//					exit;
				}
				else
				{
					$name_exist = $AVE_DB->Query("
						SELECT COUNT(*)
						FROM " . PREFIX . "_rubrics
						WHERE RubrikName = '" . $_POST['RubrikName'] . "'
						LIMIT 1
					")->GetCell();
					if ($name_exist) array_push($errors, $AVE_Template->get_config_vars('RUBRIK_NAME_EXIST'));
//					if ($name_exist)
//					{
//						header('Location:index.php?do=rubs&action=new&cp=' . SESSION . '&error=name');
//						exit;
//					}

					if (!empty($_POST['UrlPrefix']))
					{
						$prefix_exist = $AVE_DB->Query("
							SELECT COUNT(*)
							FROM " . PREFIX . "_rubrics
							WHERE UrlPrefix = '" . $_POST['UrlPrefix'] . "'
							LIMIT 1
						")->GetCell();
						if ($prefix_exist) array_push($errors, $AVE_Template->get_config_vars('RUBRIK_PREFIX_EXIST'));
//						if ($prefix_exist)
//						{
//							header('Location:index.php?do=rubs&action=new&cp=' . SESSION . '&error=prefix');
//							exit;
//						}
					}

					if (!empty($errors))
					{
						$AVE_Template->assign('errors', $errors);
						$AVE_Template->assign('AlleVorlagen', getAllTemplates());
						$AVE_Template->assign('content', $AVE_Template->fetch('rubs/rubnew.tpl'));
					}
					else
					{
						$sql = $AVE_DB->Query("
							INSERT " . PREFIX . "_rubrics
							SET
								RubrikName = '" . $_POST['RubrikName'] . "',
								UrlPrefix  = '" . $_POST['UrlPrefix'] . "',
								Vorlage    = '" . intval($_POST['Vorlage']) . "',
								RBenutzer  = '" . $_SESSION['user_id'] . "',
								RDatum     = '" . time() . "'
						");
						$iid = $AVE_DB->InsertId();

						reportLog($_SESSION['user_name'] . ' - ������� ������� (' . $_POST['RubrikName'] . ')', 2, 2);
						header('Location:index.php?do=rubs&action=edit&Id=' . $iid . '&cp=' . SESSION);
						exit;
					}
				}
				break;
		}
	}

	/**
	 * �������������� ������� �������
	 *
	 * @param string $data
	 */
	function saveRubTpl($data)
	{
		global $AVE_DB;

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_rubrics
			SET RubrikTemplate = '" . $data . "'
			WHERE Id = '" . (int)$_REQUEST['Id'] . "'
		");
		// ������� ��� ������� ���������� �������
		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_rubric_template_cache
			WHERE rub_id = '" . (int)$_REQUEST['Id'] . "'
		");

		reportLog($_SESSION['user_name'] . ' - �������������� ������ ������� (' . $_REQUEST['Id'] . ')', 2, 2);
		header('Location:index.php?do=rubs&cp=' . SESSION);
	}

	/**
	 * ����� ������ ����� �������
	 *
	 */
	function fetchRubDetails()
	{
		global $AVE_DB, $AVE_Template;

		$rub_fields = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_rubric_fields
			WHERE RubrikId = '" . $_REQUEST['Id'] . "'
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
				AND RubrikId = '" . $_REQUEST['Id'] . "'
			");
			$row_doc_perm = $sql_doc_perm->FetchRow();
			$permissions = @explode('|', $row_doc_perm->Rechte);
			$row->permissions = $permissions;

			array_push($groups,$row);
		}
		$sql = $AVE_DB->Query("
			SELECT RubrikName
			FROM " . PREFIX . "_rubrics
			WHERE id = '" . (int)$_REQUEST['Id'] . "'
			LIMIT 1
		");
		$rubrikName = $sql->GetCell();
		$AVE_Template->assign('RubrikName', $rubrikName);
		$AVE_Template->assign('groups', $groups);
		$AVE_Template->assign('felder', fetchFields());
		$AVE_Template->assign('content', $AVE_Template->fetch('rubs/rub_fields.tpl'));
	}

	/**
	 * ����� ������� �������
	 *
	 * @param int $show
	 * @param int $extern
	 */
	function showRubTpl($show = '', $extern = '0')
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

		fetchFields(1);

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
			$AVE_Template->assign('content', $AVE_Template->fetch($this->_tpl));
		}
	}

	/**
	 * ����� ������ ������
	 *
	 */
	function showRubs()
	{
		global $AVE_DB, $AVE_Template;

		$rubrics = array();
		$num_tpl = $AVE_DB->Query("SELECT COUNT(*) FROM " . PREFIX . "_rubrics")->GetCell();

//		$num_tpl = $sql->NumRows();

		$page_limit = $this->_limit;
		$seiten = ceil($num_tpl / $page_limit);
		$set_start = prepage() * $page_limit - $page_limit;

//		if ($navi == 1)
//		{
//			$set_start = 0;
//			$page_limit = 30;
//		}

		if ($num_tpl > $page_limit)
		{
			$page_nav = pagenav($seiten, 'page',
				" <a class=\"pnav\" href=\"index.php?do=rubs&page={s}&cp=" . SESSION . "\">{t}</a> ");
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
//			$sql_rcount = $AVE_DB->Query("
//				SELECT Id
//				FROM " . PREFIX . "_documents
//				WHERE RubrikId = '" . $row->Id . "'
//			");
//			$count_r = $sql_rcount->NumRows();
//			$sql_rcount->Close();
//
//			$row->can_deleted = ($count_r >= 1) ? 0 : 1;
//
//			$row->doc_count = $count_r;
			array_push($rubrics, $row);
		}

		$AVE_Template->assign('rubrics', $rubrics);
	}

	/**
	 * ����������� �������
	 *
	 */
	function duplicate()
	{
		global $AVE_DB, $AVE_Template;

		$errors = array();

		$row = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_rubrics
			WHERE Id = '" . (int)$_REQUEST['Id'] . "'
		")->FetchRow();

		if (!$row) array_push($errors, $AVE_Template->get_config_vars('RUBRIK_NO_RUBRIK'));

		if (empty($_REQUEST['RubrikName']))
		{
			array_push($errors, $AVE_Template->get_config_vars('RUBRIK_NO_NAME'));
		}
		else
		{
			$name_exist = $AVE_DB->Query("
				SELECT COUNT(*)
				FROM " . PREFIX . "_rubrics
				WHERE RubrikName = '" . $_REQUEST['RubrikName'] . "'
				LIMIT 1
			")->GetCell();

			if ($name_exist) array_push($errors, $AVE_Template->get_config_vars('RUBRIK_NAME_EXIST'));
		}

		if (!empty($_POST['UrlPrefix']))
		{
			$prefix_exist = $AVE_DB->Query("
				SELECT COUNT(*)
				FROM " . PREFIX . "_rubrics
				WHERE UrlPrefix = '" . $_POST['UrlPrefix'] . "'
				LIMIT 1
			")->GetCell();

			if ($prefix_exist) array_push($errors, $AVE_Template->get_config_vars('RUBRIK_PREFIX_EXIST'));
		}

		if (!empty($errors))
		{
			$AVE_Template->assign('errors', $errors);
		}
		else
		{
			reportLog($_SESSION['user_name'] . ' - ������ ����� ������� (' . (int)$_REQUEST['Id'] . ')', 2, 2);

			$AVE_DB->Query("
				INSERT " . PREFIX . "_rubrics
				SET
					RubrikName     = '" . $_REQUEST['RubrikName'] . "',
					UrlPrefix      = '" . $_REQUEST['UrlPrefix'] . "',
					RubrikTemplate = '" . $row->RubrikTemplate . "',
					Vorlage        = '" . $row->Vorlage . "',
					RBenutzer      = '" . $_SESSION['user_id'] . "',
					RDatum         = '" . time() . "'
			");
			$iid = $AVE_DB->InsertId();

			$sql = $AVE_DB->Query("
				SELECT
					BenutzerGruppe,
					Rechte
				FROM " . PREFIX . "_document_permissions
				WHERE RubrikId = '" . (int)$_REQUEST['Id'] . "'
			");
			while ($row = $sql->FetchRow())
			{
				$AVE_DB->Query("
					INSERT " . PREFIX . "_document_permissions
					SET
						RubrikId       = '" . $iid . "',
						BenutzerGruppe = '" . $row->BenutzerGruppe . "',
						Rechte         = '" . $row->Rechte . "'
				");
			}

			$sql = $AVE_DB->Query("
				SELECT
					Titel,
					RubTyp,
					rubric_position,
					StdWert
				FROM " . PREFIX . "_rubric_fields
				WHERE RubrikId = '" . (int)$_REQUEST['Id'] . "'
				ORDER BY rubric_position ASC
			");
			while ($row = $sql->FetchRow())
			{
				$AVE_DB->Query("
					INSERT " . PREFIX . "_rubric_fields
					SET
						RubrikId        = '" . $iid . "',
						Titel           = '" . $row->Titel . "',
						RubTyp          = '" . $row->RubTyp . "',
						rubric_position = '" . $row->rubric_position . "',
						StdWert         = '" . $row->StdWert . "'
				");
			}
			echo '<script>window.opener.location.reload();window.close();</script>';
		}
	}

	/**
	 * ���������� ������� ������� � ���������� ������
	 *
	 */
	function savePerms()
	{
		global $AVE_DB;

		if (checkPermission('rub_perms'))
		{
			foreach ($_POST['Benutzergruppe'] as $id => $Bg)
			{
				$sql = $AVE_DB->Query("
					SELECT Id
					FROM " . PREFIX . "_document_permissions
					WHERE Benutzergruppe = '" . $Bg . "'
					AND RubrikId = '" . $_REQUEST['Id'] . "'
				");
				$count = $sql->NumRows();

				if ($count < 1)
				{
					$rechte = @implode('|', $_POST['perm'][$id]);
					$AVE_DB->Query("
						INSERT " . PREFIX . "_document_permissions
						SET
							RubrikId       = '" . $_REQUEST['Id'] . "',
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
							RubrikId = '" . $_REQUEST['Id'] . "'
						AND
							BenutzerGruppe = '" . $Bg . "'
					");
				}
			}
			header('Location:index.php?do=rubs&action=edit&Id=' . $_REQUEST['Id'] . '&cp=' . SESSION);
		}
		else
		{
			define('NOPERM', 1);
		}
	}

	/**
	 * ���������� ������ �������
	 *
	 */
	function saveFields()
	{
		global $AVE_DB;

		foreach ($_POST['Titel'] as $id => $Titel)
		{
			if (!empty($Titel))
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_rubric_fields
					SET
						Titel           = '" . htmlspecialchars($Titel) . "',
						RubTyp          = '" . $_POST['RubTyp'][$id] . "',
						rubric_position = '" . $_POST['RubPosition'][$id] . "',
						StdWert         = '" . $_POST['StdWert'][$id] . "',
						tpl_field       = '" . $_POST['tpl_field'][$id] . "',
						tpl_req         = '" . $_POST['tpl_req'][$id] . "'
					WHERE
						Id = '" . $id . "'
				");
				// ������� ��� ������� ���������� �������
				$AVE_DB->Query("
					DELETE
					FROM " . PREFIX . "_rubric_template_cache
					WHERE rub_id = '" . $_REQUEST['Id'] . "'
				");
				reportLog($_SESSION['user_name'] . ' - �������������� ���� ������� (' . $Titel . ')', 2, 2);
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
					AND RubrikId = '" . $_REQUEST['Id'] . "'
				");
				$AVE_DB->Query("
					DELETE
					FROM " . PREFIX . "_document_fields
					WHERE RubrikFeld = '" . $id . "'
				");
				// ������� ��� ������� ���������� �������
				$AVE_DB->Query("
					DELETE
					FROM " . PREFIX . "_rubric_template_cache
					WHERE rub_id = '" . $_REQUEST['Id'] . "'
				");

				reportLog($_SESSION['user_name'] . ' - ������ ���� ������� (' . $_POST['Titel'][$id] . ')', 2, 2);
			}
		}

		header('Location:index.php?do=rubs&action=edit&Id=' . $_REQUEST['Id'] . '&cp=' . SESSION);
		exit;
	}

	/**
	 * �������� ������ ���� �������
	 *
	 */
	function newField()
	{
		global $AVE_DB;

		if (!empty($_POST['TitelNew']))
		{
			$pos = (!empty($_POST['RubPositionNew'])) ? $_POST['RubPositionNew'] : 1;
			reportLog($_SESSION['user_name'] . ' - ������� ���� ������� (' . $_POST['TitelNew'] . ')', 2, 2);

			$AVE_DB->Query("
				INSERT " . PREFIX . "_rubric_fields
				SET
					RubrikId        = '" . (int)$_REQUEST['Id'] . "',
					Titel           = '" . $_POST['TitelNew'] . "',
					RubTyp          = '" . $_POST['RubTypNew'] . "',
					rubric_position = '" . $pos . "',
					StdWert         = '" . $_POST['StdWertNew'] . "'
			");

			$Update_RubrikFeld = $AVE_DB->InsertId();
			$sql = $AVE_DB->Query("
				SELECT Id
				FROM " . PREFIX . "_documents
				WHERE RubrikId = '" . $_REQUEST['Id'] . "'
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
		}

		header('Location:index.php?do=rubs&action=edit&Id=' . $_REQUEST['Id'] . 'cp=' . SESSION);
		exit;
	}

	/**
	 * ������ �������� �������
	 *
	 */
	function quickSave()
	{
		global $AVE_DB;

		if (checkPermission('rub_edit'))
		{
			foreach ($_POST['RubrikName'] as $id => $Rn)
			{
				if (!empty($Rn))
				{
					$new_name = '';
					$new_prefix = '';

					$name_exist = $AVE_DB->Query("
						SELECT COUNT(*)
						FROM " . PREFIX . "_rubrics
						WHERE
							RubrikName = '" . $Rn . "'
						AND
							Id != '" . $id . "'
						LIMIT 1
					")->GetCell();
					if (!$name_exist) $new_name = "RubrikName = '" . $Rn . "',";

					if (!empty($_POST['UrlPrefix'][$id]))
					{
						$prefix_exist = $AVE_DB->Query("
							SELECT COUNT(*)
							FROM " . PREFIX . "_rubrics
							WHERE
								UrlPrefix = '" . $_POST['UrlPrefix'][$id] . "'
							AND
								Id != '" . $id . "'
							LIMIT 1
						")->GetCell();
						if (!$prefix_exist) $new_prefix = $_POST['UrlPrefix'][$id];
					}

					$AVE_DB->Query("
						UPDATE " . PREFIX . "_rubrics
						SET
							" . $name . "
							UrlPrefix = '" . $new_prefix . "',
							Vorlage = '" . $_POST['Vorlage'][$id] . "'
						WHERE
							Id = '" . $id . "'
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
 *	���������� ������
 */

}

?>