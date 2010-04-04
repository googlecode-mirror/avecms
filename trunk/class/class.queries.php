<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * Класс работы с системой внутренних запросов
 */
class AVE_Query
{
	var $_limit = 15;

	function showQueries($extern = '')
	{
		global $AVE_DB, $AVE_Template;

		$sql = $AVE_DB->Query("SELECT Id FROM " . PREFIX . "_queries");
		$num = $sql->NumRows();

		$limit = $this->_limit;
		$seiten = ceil($num / $limit);
		$start = prepage() * $limit - $limit;

		if ($extern != '')
		{
			$start = 0;
			$limit = 10000;
		}

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_queries
			ORDER BY Titel ASC
			LIMIT " . $start . "," . $limit
		);
		while ($row = $sql->FetchRow())
		{
			$row->Autor = getUserById($row->Autor);
			array_push($items, $row);
		}

		if ($num > $limit)
		{
			$template_label = " <a class=\"pnav\" href=\"index.php?do=queries&page={s}&amp;cp=" . SESSION . "\">{t}</a> ";
			$page_nav = pagenav($seiten, 'page', $template_label);
			$AVE_Template->assign('page_nav', $page_nav);
		}

		if ($extern != '')
		{
			$AVE_Template->assign('conditions', $items);
		}
		else
		{
			$AVE_Template->assign('items', $items);
			$AVE_Template->assign('content', $AVE_Template->fetch('queries/queries.tpl'));
		}
	}

	function newQuery()
	{
		global $AVE_DB, $AVE_Template;

		switch ($_REQUEST['sub'])
		{
			case '':
				$AVE_Template->assign('formaction', 'index.php?do=queries&amp;action=new&amp;sub=save&amp;cp=' . SESSION);
				$AVE_Template->assign('content', $AVE_Template->fetch('queries/form.tpl'));
				break;

			case 'save':
				$AVE_DB->Query("
					INSERT " . PREFIX . "_queries
					SET
						RubrikId     = '" . $_REQUEST['RubrikId'] . "',
						Zahl         = '" . $_REQUEST['Zahl'] . "',
						Titel        = '" . $_REQUEST['Titel'] . "',
						Template     = '" . $_REQUEST['Template'] . "',
						AbGeruest    = '" . $_REQUEST['AbGeruest'] . "',
						Sortierung   = '" . $_REQUEST['Sortierung'] . "',
						Autor        = '" . $_SESSION['user_id'] . "',
						Erstellt     = '" . time() . "',
						Beschreibung = '" . $_REQUEST['Beschreibung'] . "',
						AscDesc      = '" . $_REQUEST['AscDesc'] . "',
						Navi         = '" . $_REQUEST['Navi'] . "'
				");

				$iid = $AVE_DB->InsertId();
				reportLog($_SESSION['user_name'] . ' - добавил новый запрос (' . $_REQUEST['Titel'] . ')', 2, 2);

				if ($_REQUEST['reedit'] == 1)
				{
					header('Location:index.php?do=queries&action=edit&Id=' . $iid . '&cp=' . SESSION . '&RubrikId=' . $_REQUEST['RubrikId']);
				}
				else
				{
					header('Location:index.php?do=queries&cp=' . SESSION);
				}
				exit;
				break;
		}
	}

	function copyQuery($id)
	{
		global $AVE_DB;

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_queries
			WHERE Id = '" . $id . "'
		");
		$row = $sql->FetchRow();

		$AVE_DB->Query("
			INSERT " . PREFIX . "_queries
			SET
				RubrikId     = '" . $row->RubrikId . "',
				Zahl         = '" . $row->Zahl . "',
				Titel        = '" . substr($_REQUEST['cname'], 0, 25) . "',
				Template     = '" . addslashes($row->Template) . "',
				AbGeruest    = '" . addslashes($row->AbGeruest) . "',
				Sortierung   = '" . $row->Sortierung . "',
				Autor        = '" . $_SESSION['user_id'] . "',
				Erstellt     = '" . time() . "',
				Beschreibung = '" . $row->Beschreibung . "',
				AscDesc      = '" . $row->AscDesc . "',
				Navi         = '" . $row->Navi . "'
		");

		$iid = $AVE_DB->InsertId();
		reportLog($_SESSION['user_name'] . ' - создал копию запроса (' . $id . ')', 2, 2);

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_queries_conditions
			WHERE Abfrage = '" . $id . "'
		");

		while ($row_ak = $sql->FetchRow())
		{
			$AVE_DB->Query("
				INSERT " . PREFIX . "_queries_conditions
				SET
					Abfrage  = '" . $iid . "',
					Operator = '" . $row_ak->Operator . "',
					Feld     = '" . $row_ak->Feld . "',
					Wert     = '" . $row_ak->Wert . "',
					Oper     = '" . $row_ak->Oper . "'
			");
		}
		$sql->Close();

		header('Location:index.php?do=queries&cp=' . SESSION);
		exit;
	}

	function deleteQuery($id)
	{
		global $AVE_DB;

		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_queries
			WHERE Id = '" . $id . "'
		");
		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_queries_conditions
			WHERE Abfrage = '" . $id . "'
		");

		reportLog($_SESSION['user_name'] . ' - удалил запрос (' . $id . ')', 2, 2);

		header('Location:index.php?do=queries&cp=' . SESSION);
		exit;
	}

	function editQuery($id)
	{
		global $AVE_DB, $AVE_Template;

		switch ($_REQUEST['sub'])
		{
			case '':
				$sql = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_queries
					WHERE Id = '" . $id . "'
				");
				$row = $sql->FetchRow();

//				$ak = array();
//				$sql = $AVE_DB->Query("
//					SELECT *
//					FROM " . PREFIX . "_queries_conditions
//					WHERE Abfrage = '" . $row->Id . "'
//				");
//				while ($row_ak = $sql->FetchRow()) {
//					array_push($ak, $row_ak);
//				}
//				$row->Ak = $ak;

				$AVE_Template->assign('row', $row);
				$AVE_Template->assign('formaction', 'index.php?do=queries&amp;action=edit&amp;sub=save&amp;Id=' . $id . '&amp;cp=' . SESSION);
				$AVE_Template->assign('content', $AVE_Template->fetch('queries/form.tpl'));
				break;

			case 'save':
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_queries
					SET
						Titel        = '" . $_REQUEST['Titel'] . "',
						RubrikId     = '" . $_REQUEST['RubrikId'] . "',
						Zahl         = '" . $_REQUEST['Zahl'] . "',
						Template     = '" . $_REQUEST['Template'] . "',
						AbGeruest    = '" . $_REQUEST['AbGeruest'] . "',
						Sortierung   = '" . $_REQUEST['Sortierung'] . "',
						Beschreibung = '" . $_REQUEST['Beschreibung'] . "',
						AscDesc      = '" . $_REQUEST['AscDesc'] . "',
						Navi         = '" . $_REQUEST['Navi'] . "'
					WHERE
						Id = '" . $_REQUEST['Id'] . "'
				");
				reportLog($_SESSION['user_name'] . ' - отредактировал запрос (' . $_REQUEST['Titel'] . ')', 2, 2);

				if ($_REQUEST['pop'] == 1)
				{
					echo '<script>self.close();</script>';
				}
				else
				{
					header('Location:index.php?do=queries&cp=' . SESSION);
					exit;
				}
				break;
		}
	}

	function editConditions($id)
	{
		global $AVE_DB, $AVE_Template;

		switch ($_REQUEST['sub'])
		{
			case '':
				$felder = array();
				$sql = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_rubric_fields
					WHERE RubrikId = '" . $_REQUEST['RubrikId'] . "'
				");
				while ($row = $sql->FetchRow())
				{
					array_push($felder, $row);
				}

				$afkonditionen = array();
				$sql = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_queries_conditions
					WHERE Abfrage = '" . $_REQUEST['Id'] . "'
				");
				while ($row = $sql->FetchRow())
				{
					array_push($afkonditionen, $row);
				}

				$sql = $AVE_DB->Query("
					SELECT Titel
					FROM " . PREFIX . "_queries
					WHERE id = '" . $id . "'
					LIMIT 1
				");
				$titel = $sql->GetCell();

				$AVE_Template->assign('QureyName', $titel);
				$AVE_Template->assign('felder', $felder);
				$AVE_Template->assign('afkonditionen', $afkonditionen);
				$AVE_Template->assign('content', $AVE_Template->fetch('queries/conditions.tpl'));
				break;

			case 'save':
				if (!empty($_POST['Wert_Neu']))
				{
					$AVE_DB->Query("
						INSERT " . PREFIX . "_queries_conditions
						SET
							Abfrage  = '" . $_REQUEST['Id'] . "',
							Operator = '" . $_POST['Operator_Neu'] . "',
							Feld     = '" . $_POST['Feld_Neu'] . "',
							Wert     = '" . $_POST['Wert_Neu'] . "',
							Oper     = '" . $_POST['Oper_Neu'] . "'
					");

					$iid = $AVE_DB->InsertId();
					reportLog($_SESSION['user_name'] . ' - добавил условие для запроса (' . $iid . ')', 2, 2);
				}

				if (is_array($_POST['Feld']))
				{
					foreach ($_POST['Feld'] as $id => $val)
					{
						if (!empty($_POST['Wert'][$id]))
						{
							$AVE_DB->Query("
								UPDATE " . PREFIX . "_queries_conditions
								SET
									Abfrage  = '" . $_REQUEST['Id'] . "',
									Operator = '" . $_POST['Operator'][$id] . "',
									Feld     = '" . $val . "',
									Wert     = '" . $_POST['Wert'][$id] . "',
									Oper     = '" . $_POST['Oper_Neu'] . "'
								WHERE
									Id = '" . $id . "'
							");

							reportLog($_SESSION['user_name'] . ' - изменил условия для запроса (' . $id . ')', 2, 2);
						}
					}
				}

				foreach ($_POST['del'] as $id => $val)
				{
					$AVE_DB->Query("
						DELETE
						FROM " . PREFIX . "_queries_conditions
						WHERE Id = '" . $id . "'
					");

					reportLog($_SESSION['user_name'] . ' - удалил условия для запроса (' . $id . ')', 2, 2);
				}

				include_once(BASE_DIR . '/functions/func.parserequest.php');
				$rez = query_condition($_REQUEST['Id']);

				header('Location:index.php?do=queries&action=konditionen&RubrikId=' . $_REQUEST['RubrikId'] . '&Id=' . $_REQUEST['Id'] . '&pop=1&cp=' . SESSION);
				exit;
				break;
		}
	}
}

?>