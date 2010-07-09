<?php

/**
 * AVE.cms
 *
 * �����, �������������� ��� ������ � �������� �������� � ������ ����������
 * @package AVE.cms
 * @filesource
 */

class AVE_Request
{

/**
 *	�������� ������
 */

	/**
	 * ���������� �������� �� ��������
	 *
	 * @var int
	 */
	var $_limit = 15;

/**
 *	���������� ������
 */

	/**
	 * �����, ��������������� ��� ��������� � ������ ������ ��������
	 *
	 * @param boolean $pagination ������� ������������ ������������� ������
	 */
	function _requestListGet($pagination = true)
	{
		global $AVE_DB, $AVE_Template;

		$limit = '';

		// ���� ������������ ������������ ���������
        if ($pagination)
		{
			// ���������� ����� ������� �� �������� � ������ ��������� �������
            $limit = $this->_limit;
			$start = get_current_page() * $limit - $limit;

			// �������� ����� ���������� ��������
            $num = $AVE_DB->Query("SELECT COUNT(*) FROM " . PREFIX . "_request")->GetCell();

			// ���� ���������� ������, ��� ������������� �����, ����� ��������� ������������ ���������
            if ($num > $limit)
			{
				$page_nav = " <a class=\"pnav\" href=\"index.php?do=request&page={s}&amp;cp=" . SESSION . "\">{t}</a> ";
				$page_nav = get_pagination(ceil($num / $limit), 'page', $page_nav);
				$AVE_Template->assign('page_nav', $page_nav);
			}

			$limit = $pagination ? "LIMIT " . $start . "," . $limit : '';
		}

        // ��������� ������ � �� �� ��������� ������ �������� � ������ ������ ������ �� �������� (���� ����������)
		$items = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_request
			ORDER BY request_title ASC
			" . $limit . "
		");

        // ��������� ������ �� ���������� ������
        while ($row = $sql->FetchRow())
		{
			$row->request_author = get_username_by_id($row->request_author_id);
			array_push($items, $row);
		}

		// ���������� ������
        return $items;
	}

/**
 *	������� ������ ������
 */

	/**
	 * �����, ��������������� ��� ������������ ������ ��������
	 *
	 */
	function requestListFetch()
	{
		global $AVE_Template;

		$AVE_Template->assign('conditions', $this->_requestListGet(false));
	}

    /**
	 * �����, ��������������� ��� ����������� ������ ��������
	 *
	 */
	function requestListShow()
	{
		global $AVE_Template;

        // �������� ������ ��������
		$AVE_Template->assign('items', $this->_requestListGet());

        // �������� � ������ � ���������� �������� �� �������
		$AVE_Template->assign('content', $AVE_Template->fetch('request/request.tpl'));
	}

    /**
	 * �����, ��������������� ��� �������� ������ �������
	 *
	 */
	function requestNew()
	{
		global $AVE_DB, $AVE_Template;

		// ���������� �������� ������������
        switch ($_REQUEST['sub'])
		{
			// �������� �� ����������
            case '':
				// ���������� ������ ����� ��� �������� ������ �������
                $AVE_Template->assign('formaction', 'index.php?do=request&amp;action=new&amp;sub=save&amp;cp=' . SESSION);
				$AVE_Template->assign('content', $AVE_Template->fetch('request/form.tpl'));
				break;

            // ������ ������ ��������� ������
            case 'save':
                // ��������� ������ � �� � ��������� ��������� ������������� ����������
                $AVE_DB->Query("
					INSERT " . PREFIX . "_request
					SET
						rubric_id               = '" . $_REQUEST['rubric_id'] . "',
						request_title           = '" . $_REQUEST['request_title'] . "',
						request_items_per_page  = '" . $_REQUEST['request_items_per_page'] . "',
						request_template_item   = '" . $_REQUEST['request_template_item'] . "',
						request_template_main   = '" . $_REQUEST['request_template_main'] . "',
						request_order_by        = '" . $_REQUEST['request_order_by'] . "',
						request_asc_desc        = '" . $_REQUEST['request_asc_desc'] . "',
						request_author_id       = '" . (int)$_SESSION['user_id'] . "',
						request_created         = '" . time() . "',
						request_description     = '" . $_REQUEST['request_description'] . "',
						request_show_pagination = '" . $_REQUEST['request_show_pagination'] . "'
				");

                // �������� id ��������� ������
                $iid = $AVE_DB->InsertId();

				// ��������� ��������� ��������� � ������
                reportLog($_SESSION['user_name'] . ' - ������� ����� ������ (' . stripslashes($_REQUEST['request_title']) . ')', 2, 2);

                // ���� � ������� ������ �������� �� ����������� �������������� �������
                if ($_REQUEST['reedit'] == 1)
				{
					// ��������� ������� �� �������� � ��������������� �������
                    header('Location:index.php?do=request&action=edit&Id=' . $iid . '&rubric_id=' . $_REQUEST['rubric_id'] . '&cp=' . SESSION);
				}
				else
				{
					// � ��������� ������ ��������� ������� � ������ ��������
                    header('Location:index.php?do=request&cp=' . SESSION);
				}
				exit;
		}
	}

	/**
	 * �����, ��������������� ��� �������������� �������
	 *
	 * @param int $request_id ������������� �������
	 */
	function requestEdit($request_id)
	{
		global $AVE_DB, $AVE_Template;

		// ���������� �������� ������������
        switch ($_REQUEST['sub'])
		{
			// ���� �������� �� ����������
            case '':
				// ��������� ������ � �� � �������� ��� ���������� � �������
                $sql = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_request
					WHERE Id = '" . $request_id . "'
				");
				$row = $sql->FetchRow();

                // �������� ������ � ������ � ���������� �������� � ��������������� �������
				$AVE_Template->assign('row', $row);
				$AVE_Template->assign('formaction', 'index.php?do=request&amp;action=edit&amp;sub=save&amp;Id=' . $request_id . '&amp;cp=' . SESSION);
				$AVE_Template->assign('content', $AVE_Template->fetch('request/form.tpl'));
				break;

            // ������������ ����� ������ ��������� ���������
            case 'save':
				// ��������� ������ � �� � ��������� ��������� ������
                $AVE_DB->Query("
					UPDATE " . PREFIX . "_request
					SET
						rubric_id               = '" . $_REQUEST['rubric_id'] . "',
						request_title           = '" . $_REQUEST['request_title'] . "',
						request_items_per_page  = '" . $_REQUEST['request_items_per_page'] . "',
						request_template_item   = '" . $_REQUEST['request_template_item'] . "',
						request_template_main   = '" . $_REQUEST['request_template_main'] . "',
						request_order_by        = '" . $_REQUEST['request_order_by'] . "',
						request_description     = '" . $_REQUEST['request_description'] . "',
						request_asc_desc        = '" . $_REQUEST['request_asc_desc'] . "',
						request_show_pagination = '" . $_REQUEST['request_show_pagination'] . "'
					WHERE
						Id = '" . $request_id . "'
				");

                // ��������� ��������� ��������� � ������
                reportLog($_SESSION['user_name'] . ' - �������������� ������ (' . stripslashes($_REQUEST['request_title']) . ')', 2, 2);

				// ���� �������������� ���� � ��������� ����, ��������� ���
                if ($_REQUEST['pop'] == 1)
				{
					echo '<script>self.close();</script>';
				}
				else
				{
                    // � ��������� ������ ��������� ������� � ������ ��������
					header('Location:index.php?do=request&cp=' . SESSION);
					exit;
				}
				break;
		}
	}

	/**
	 * �����, ��������������� ��� �������� ����� �������
	 *
	 * @param int $request_id ������������� �������
	 */
	function requestCopy($request_id)
	{
		global $AVE_DB;

		// ��������� ������ � �� �� ��������� ���������� � ���������� �������
        $row = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_request
			WHERE Id = '" . $request_id . "'
		")->FetchRow();

        // ��������� ������ � �� �� ���������� ������ ������� �� ��������� ���������� ����� ������
        $AVE_DB->Query("
			INSERT " . PREFIX . "_request
			SET
				rubric_id               = '" . $row->rubric_id . "',
				request_items_per_page  = '" . $row->request_items_per_page . "',
				request_title           = '" . substr($_REQUEST['cname'], 0, 25) . "',
				request_template_item   = '" . addslashes($row->request_template_item) . "',
				request_template_main   = '" . addslashes($row->request_template_main) . "',
				request_order_by        = '" . addslashes($row->request_order_by) . "',
				request_author_id       = '" . (int)$_SESSION['user_id'] . "',
				request_created         = '" . time() . "',
				request_description     = '" . addslashes($row->request_description) . "',
				request_asc_desc        = '" . $row->request_asc_desc . "',
				request_show_pagination = '" . $row->request_show_pagination . "'
		");

        // �������� id ����������� ������
        $iid = $AVE_DB->InsertId();

		// ��������� ��������� ��������� � ������
        reportLog($_SESSION['user_name'] . ' - ������ ����� ������� (' . $request_id . ')', 2, 2);

        // ��������� ������ � �� � �������� ��� ������� ������� ��� ����������� �������
        $sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_request_conditions
			WHERE request_id = '" . $request_id . "'
		");

		// ������������ ���������� ������ �
        while ($row_ak = $sql->FetchRow())
		{
			// ��������� ������ � �� �� ���������� ������� ��� ������, �������������� �������
            $AVE_DB->Query("
				INSERT " . PREFIX . "_request_conditions
				SET
					request_id                  = '" . $iid . "',
					condition_compare   = '" . $row_ak->condition_compare . "',
					condition_field_id  = '" . $row_ak->condition_field_id . "',
					condition_value     = '" . $row_ak->condition_value . "',
					condition_join      = '" . $row_ak->condition_join . "'
			");
		}

        // ��������� ������� � ������ ��������
        header('Location:index.php?do=request&cp=' . SESSION);
		exit;
	}

    /**
	 * �����, ��������������� ��� �������� �������
	 *
	 * @param int $request_id ������������� �������
	 */
	function requestDelete($request_id)
	{
		global $AVE_DB;

		// ��������� ������ � �� �� �������� ����� ���������� � �������
        $AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_request
			WHERE Id = '" . $request_id . "'
		");

        // ��������� ������ � �� �� �������� ������� �������
        $AVE_DB->Query("
			DELETE
			FROM " . PREFIX . "_request_conditions
			WHERE request_id = '" . $request_id . "'
		");

		// ��������� ��������� ��������� � ������
        reportLog($_SESSION['user_name'] . ' - ������ ������ (' . $request_id . ')', 2, 2);

        // ��������� ������� � ������ ��������
        header('Location:index.php?do=request&cp=' . SESSION);
		exit;
	}

	/**
	 * �����, ��������������� ��� �������������� ������� �������
	 *
	 * @param int $request_id ������������� �������
	 */
	function requestConditionEdit($request_id)
	{
		global $AVE_DB, $AVE_Template;

		// ���������� �������� ������������
        switch ($_REQUEST['sub'])
		{
			// ���� �������� �� ����������
            case '':
				$felder = array();

                // ��������� ������ � �� � �������� ������ ����� � ��� �������, � ������� ��������� ������ ������
                $sql = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_rubric_fields
					WHERE rubric_id = '" . $_REQUEST['rubric_id'] . "'
				");

                // ������������ ���������� ������ � ��������� ������
                while ($row = $sql->FetchRow())
				{
					array_push($felder, $row);
				}

				$afkonditionen = array();

                // ��������� ������ � �� � �������� ������� �������
                $sql = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_request_conditions
					WHERE request_id = '" . $request_id . "'
				");

                // ������������ ���������� ������ � ��������� ������
                while ($row = $sql->FetchRow())
				{
					array_push($afkonditionen, $row);
				}

				// ��������� ������ � �� � �������� �������� �������
                $titel = $AVE_DB->Query("
					SELECT request_title
					FROM " . PREFIX . "_request
					WHERE Id = '" . $request_id . "'
					LIMIT 1
				")->GetCell();

                // �������� ������ � ������ � ���������� �������� � ��������������� �������
                $AVE_Template->assign('request_title', $titel);
				$AVE_Template->assign('fields', $felder);
				$AVE_Template->assign('afkonditionen', $afkonditionen);
				$AVE_Template->assign('content', $AVE_Template->fetch('request/conditions.tpl'));
				break;

            // ���� ������������ ����� ������ ��������� ���������
            case 'save':
                // ���� ������������ ������� ����� �������
                if (!empty($_POST['Wert_Neu']))
				{
					// ��������� ������ � �� �� ���������� ������ �������
                    $AVE_DB->Query("
						INSERT " . PREFIX . "_request_conditions
						SET
							request_id                  = '" . $request_id . "',
							condition_compare   = '" . $_POST['Operator_Neu'] . "',
							condition_field_id  = '" . $_POST['Feld_Neu'] . "',
							condition_value     = '" . $_POST['Wert_Neu'] . "',
							condition_join      = '" . $_POST['Oper_Neu'] . "'
					");

					// ��������� ��������� ��������� � ������
                    reportLog($_SESSION['user_name'] . ' - ������� ������� ������� (' . $request_id . ')', 2, 2);
				}

                // ���� ���������� ���� �� ���� �������, �����
                if (isset($_POST['condition_field_id']) && is_array($_POST['condition_field_id']))
				{
					$condition_edited = false;

					// ������������ ������ �����
                    foreach ($_POST['condition_field_id'] as $condition_id => $val)
					{
						if (!empty($_POST['condition_value'][$condition_id]))
						{
							// ��������� ������ � �� �� ���������� ���������� �� ��������
                            $AVE_DB->Query("
								UPDATE " . PREFIX . "_request_conditions
								SET
									request_id                  = '" . $request_id . "',
									condition_compare   = '" . $_POST['condition_compare'][$condition_id] . "',
									condition_field_id  = '" . $val . "',
									condition_value     = '" . $_POST['condition_value'][$condition_id] . "',
									condition_join      = '" . $_POST['Oper_Neu'] . "'
								WHERE
									Id = '" . $condition_id . "'
							");

							$condition_edited = true;
						}
					}

					// ���� ��������� ����, ��������� ��������� ��������� � ������
                    if ($condition_edited) reportLog($_SESSION['user_name'] . ' - ������� ������� ������� (' . $request_id . ')', 2, 2);
				}

                // ���� ��������� �� ������� ���� �������� �� ��������
                if (isset($_POST['del']) && is_array($_POST['del']))
				{
					// ������������ ��� ���� ���������� �� ��������
                    foreach ($_POST['del'] as $condition_id => $val)
					{
						// ��������� ������ � �� �� �������� �������
                        $AVE_DB->Query("
							DELETE
							FROM " . PREFIX . "_request_conditions
							WHERE Id = '" . $condition_id . "'
						");
					}

					// ��������� ��������� ��������� � ������
                    reportLog($_SESSION['user_name'] . ' - ������ ������� ������� (' . $request_id . ')', 2, 2);
				}

				// ��� ������ ������ ��� ����������� SQL-������ � ��������� �������
				// ������� ��������� SQL-������ ������ ��� ��������� �������
				require(BASE_DIR . '/functions/func.parserequest.php');
				request_get_condition_sql_string($request_id);

				// ��������� ���������� ��������
                header('Location:index.php?do=request&action=konditionen&rubric_id=' . $_REQUEST['rubric_id'] . '&Id=' . $request_id . '&pop=1&cp=' . SESSION);
				exit;
		}
	}
}

?>