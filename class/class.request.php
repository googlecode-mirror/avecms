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
class AVE_Request
{

/**
 *	СВОЙСТВА
 */

	/**
	 * Количество Запросов на странице
	 *
	 * @var int
	 */
	var $_limit = 15;

/**
 *	ВНУТРЕННИЕ МЕТОДЫ
 */

	/**
	 * Метод получения списка Запросов
	 *
	 * @param boolean $pagination признак формирования постраничного списка
	 */
	function _requestListGet($pagination = true)
	{
		global $AVE_DB, $AVE_Template;

		$limit = '';

		if ($pagination)
		{
			$limit = $this->_limit;
			$start = get_current_page() * $limit - $limit;

			$num = $AVE_DB->Query("SELECT COUNT(*) FROM " . PREFIX . "_queries")->GetCell();

			if ($num > $limit)
			{
				$page_nav = " <a class=\"pnav\" href=\"index.php?do=request&page={s}&amp;cp=" . SESSION . "\">{t}</a> ";
				$page_nav = get_pagination(ceil($num / $limit), 'page', $page_nav);
				$AVE_Template->assign('page_nav', $page_nav);
			}

			$limit = $pagination ? "LIMIT " . $start . "," . $limit : '';
		}

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_queries
			ORDER BY Titel ASC
			" . $limit . "
		");
		while ($row = $sql->FetchRow())
		{
			$row->Autor = get_username_by_id($row->Autor);
			array_push($items, $row);
		}

		return $items;
	}

/**
 *	ВНЕШНИЕ МЕТОДЫ
 */

	/**
	 * Метод формирования списка Запросов
	 *
	 */
	function requestListFetch()
	{
		global $AVE_Template;

		$AVE_Template->assign('conditions', $this->_requestListGet(false));
	}

	/**
	 * Метод отображения списка Запросов
	 *
	 */
	function requestListShow()
	{
		global $AVE_Template;

		$AVE_Template->assign('items', $this->_requestListGet());
		$AVE_Template->assign('content', $AVE_Template->fetch('request/request.tpl'));
	}

	/**
	 * Метод создания нового Запроса
	 *
	 */
	function requestNew()
	{
		global $AVE_DB, $AVE_Template;

		switch ($_REQUEST['sub'])
		{
			case '':
				$AVE_Template->assign('formaction', 'index.php?do=request&amp;action=new&amp;sub=save&amp;cp=' . SESSION);
				$AVE_Template->assign('content', $AVE_Template->fetch('request/form.tpl'));
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

				reportLog($_SESSION['user_name'] . ' - добавил новый запрос (' . stripslashes($_REQUEST['Titel']) . ')', 2, 2);

				if ($_REQUEST['reedit'] == 1)
				{
					header('Location:index.php?do=request&action=edit&Id=' . $iid . '&RubrikId=' . $_REQUEST['RubrikId'] . '&cp=' . SESSION);
				}
				else
				{
					header('Location:index.php?do=request&cp=' . SESSION);
				}
				exit;
		}
	}

	/**
	 * Метод редактирования Запроса
	 *
	 * @param int $request_id идентификатор запроса
	 */
	function requestEdit($request_id)
	{
		global $AVE_DB, $AVE_Template;

		switch ($_REQUEST['sub'])
		{
			case '':
				$sql = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_queries
					WHERE Id = '" . $request_id . "'
				");
				$row = $sql->FetchRow();

				$AVE_Template->assign('row', $row);
				$AVE_Template->assign('formaction', 'index.php?do=request&amp;action=edit&amp;sub=save&amp;Id=' . $request_id . '&amp;cp=' . SESSION);
				$AVE_Template->assign('content', $AVE_Template->fetch('request/form.tpl'));
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
						Id = '" . $request_id . "'
				");
				reportLog($_SESSION['user_name'] . ' - отредактировал запрос (' . stripslashes($_REQUEST['Titel']) . ')', 2, 2);

				if ($_REQUEST['pop'] == 1)
				{
					echo '<script>self.close();</script>';
				}
				else
				{
					header('Location:index.php?do=request&cp=' . SESSION);
					exit;
				}
				break;
		}
	}

	/**
	 * Метод создания копии Запроса
	 *
	 * @param int $request_id идентификатор запроса
	 */
	function requestCopy($request_id)
	{
		global $AVE_DB;

		$row = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_queries
			WHERE Id = '" . $request_id . "'
		")->FetchRow();

		$AVE_DB->Query("
			INSERT " . PREFIX . "_queries
			SET
				RubrikId     = '" . $row->RubrikId . "',
				Zahl         = '" . $row->Zahl . "',
				Titel        = '" . substr($_REQUEST['cname'], 0, 25) . "',
				Template     = '" . $row->Template . "',
				AbGeruest    = '" . $row->AbGeruest . "',
				Sortierung   = '" . $row->Sortierung . "',
				Autor        = '" . $_SESSION['user_id'] . "',
				Erstellt     = '" . time() . "',
				Beschreibung = '" . $row->Beschreibung . "',
				AscDesc      = '" . $row->AscDesc . "',
				Navi         = '" . $row->Navi . "'
		");
		$iid = $AVE_DB->InsertId();

		reportLog($_SESSION['user_name'] . ' - создал копию запроса (' . $request_id . ')', 2, 2);

		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_queries_conditions
			WHERE Abfrage = '" . $request_id . "'
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

		header('Location:index.php?do=request&cp=' . SESSION);
		exit;
	}

	/**
	 * Метод удаления запроса
	 *
	 * @param int $request_id идентификатор запроса
	 */
	function requestDelete($request_id)
	{
		global $AVE_DB;

		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_queries
			WHERE Id = '" . $request_id . "'
		");
		$AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_queries_conditions
			WHERE Abfrage = '" . $request_id . "'
		");

		reportLog($_SESSION['user_name'] . ' - удалил запрос (' . $request_id . ')', 2, 2);

		header('Location:index.php?do=request&cp=' . SESSION);
		exit;
	}

	/**
	 * Метод редактирования условий Запроса
	 *
	 * @param int $request_id идентификатор запроса
	 */
	function requestConditionEdit($request_id)
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
					WHERE Abfrage = '" . $request_id . "'
				");
				while ($row = $sql->FetchRow())
				{
					array_push($afkonditionen, $row);
				}

				$titel = $AVE_DB->Query("
					SELECT Titel
					FROM " . PREFIX . "_queries
					WHERE id = '" . $request_id . "'
					LIMIT 1
				")->GetCell();

				$AVE_Template->assign('QureyName', $titel);
				$AVE_Template->assign('felder', $felder);
				$AVE_Template->assign('afkonditionen', $afkonditionen);
				$AVE_Template->assign('content', $AVE_Template->fetch('request/conditions.tpl'));
				break;

			case 'save':
				if (!empty($_POST['Wert_Neu']))
				{
					$AVE_DB->Query("
						INSERT " . PREFIX . "_queries_conditions
						SET
							Abfrage  = '" . $request_id . "',
							Operator = '" . $_POST['Operator_Neu'] . "',
							Feld     = '" . $_POST['Feld_Neu'] . "',
							Wert     = '" . $_POST['Wert_Neu'] . "',
							Oper     = '" . $_POST['Oper_Neu'] . "'
					");

					reportLog($_SESSION['user_name'] . ' - добавил условие запроса (' . $request_id . ')', 2, 2);
				}

				if (isset($_POST['Feld']) && is_array($_POST['Feld']))
				{
					$condition_edited = false;

					foreach ($_POST['Feld'] as $condition_id => $val)
					{
						if (!empty($_POST['Wert'][$condition_id]))
						{
							$AVE_DB->Query("
								UPDATE " . PREFIX . "_queries_conditions
								SET
									Abfrage  = '" . $request_id . "',
									Operator = '" . $_POST['Operator'][$condition_id] . "',
									Feld     = '" . $val . "',
									Wert     = '" . $_POST['Wert'][$condition_id] . "',
									Oper     = '" . $_POST['Oper_Neu'] . "'
								WHERE
									Id = '" . $condition_id . "'
							");

							$condition_edited = true;
						}
					}

					if ($condition_edited) reportLog($_SESSION['user_name'] . ' - изменил условия запроса (' . $request_id . ')', 2, 2);
				}

				if (isset($_POST['del']) && is_array($_POST['del']))
				{
					foreach ($_POST['del'] as $condition_id => $val)
					{
						$AVE_DB->Query("
							DELETE
							FROM " . PREFIX . "_queries_conditions
							WHERE Id = '" . $condition_id . "'
						");
					}

					reportLog($_SESSION['user_name'] . ' - удалил условия запроса (' . $request_id . ')', 2, 2);
				}

				// Нет смысла каждый раз формировать SQL-запрос с условиями Запроса
				// поэтому формируем SQL-запрос только при изменении условий
				require(BASE_DIR . '/functions/func.parserequest.php');
				request_get_condition_sql_string($request_id);

				header('Location:index.php?do=request&action=konditionen&RubrikId=' . $_REQUEST['RubrikId'] . '&Id=' . $request_id . '&pop=1&cp=' . SESSION);
				exit;
		}
	}
}

?>