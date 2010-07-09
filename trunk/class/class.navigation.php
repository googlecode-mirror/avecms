<?php

/**
 * AVE.cms
 *
 * �����, ��������������� ��� ������ ��������� � �������� ���� ���������
 *
 * @package AVE.cms
 * @filesource
 */

class AVE_Navigation
{

/**
 *	�������� ������
 */


/**
 *	���������� ������ ������
 */

	/**
	 * �����, ��������������� ��� �������� ����������� ��������
     * � �������������� ����������� �������� � HTML ��������
	 *
	 * @param string $text
	 * @return string
	 */
	function _replace_wildcode($text)
	{
		$text = preg_replace('#[^(\w)|(\x7F-\xFF)|(\s)]#', '', $text);
//		$text = htmlspecialchars($text, ENT_QUOTES);

		return $text;
	}

/**
 *	���������� ������
 */

	/**
	 * �����, ��������������� ��� ������ ������ ���� ������������ ���� ��������� � ����� ����������
	 *
	 */
	function navigationList()
	{
		global $AVE_DB, $AVE_Template;

		$mod_navis = array();

        // ��������� ������ � �� �� ��������� ������ ���� ���� ���������
		$sql = $AVE_DB->Query("
			SELECT
				id,
				navi_titel
			FROM " . PREFIX . "_navigation
			ORDER BY id ASC
		");

        // ��������� ������ � ������
		while ($row = $sql->fetchrow())
		{
			array_push($mod_navis, $row);
		}
		$sql->Close();

        // �������� ������ � ������ ��� ������ � ���������� �������� �� ������� ����
		$AVE_Template->assign('mod_navis', $mod_navis);
		$AVE_Template->assign('content', $AVE_Template->fetch('navigation/overview.tpl'));
	}



    /**
	 * �����, ��������������� ��� ���������� ������ ����
	 *
	 */
	function navigationNew()
	{
		global $AVE_DB, $AVE_Template, $AVE_User;

		// ���������� �������� ������������
        switch($_REQUEST['sub'])
		{
			// ���� �������� �� ����������, ���������� ������ ����� ��� �������� ������� ���������
            case '':
				// �������� ������ ���� ����� �������������
                $row->AvGroups = $AVE_User->userGroupListGet();

                // �������� ������ � ������ � ���������� �������� ��� ���������� ������ ������� ����
                $AVE_Template->assign('row', $row);
				$AVE_Template->assign('formaction', 'index.php?do=navigation&amp;action=new&amp;sub=save&amp;cp=' . SESSION);
				$AVE_Template->assign('content', $AVE_Template->fetch('navigation/template.tpl'));
				break;


            // ���� ������������ ����� �� ������ �������� (���������)
            case 'save':

                // ���������� �������� ���� ���������
                $navi_titel   = (empty($_POST['navi_titel']))   ? 'title' : $_POST['navi_titel'];

                // ���������� ������ ���������� 1-�� ������ ������ � ����. ���� ������ �� ������ �������������,�����
                // ���������� ������� "�� ���������"
                $navi_level1  = (empty($_POST['navi_level1']))  ? "<a target=\"[tag:target]\" href=\"[tag:link]\">[tag:linkname]</a>" : $_POST['navi_level1'];
				$navi_level1active = (empty($_POST['navi_level1active'])) ? "<a target=\"[tag:target]\" href=\"[tag:link]\" class=\"first_active\">[tag:linkname]</a>" : $_POST['navi_level1active'];

                // ��������� ������ � �� �� ���������� ������ ����
				$AVE_DB->Query("
					INSERT
					INTO " . PREFIX . "_navigation
					SET
						id       = '',
						navi_titel    = '" . $navi_titel . "',
						navi_level1   = '" . $navi_level1 . "',
						navi_level1active  = '" . $navi_level1active . "',
						navi_level2   = '" . $_POST['navi_level2'] . "',
						navi_level2active  = '" . $_POST['navi_level2active'] . "',
						navi_level3   = '" . $_POST['navi_level3'] . "',
						navi_level3active  = '" . $_POST['navi_level3active'] . "',
						navi_level1begin = '" . $_POST['navi_level1begin'] . "',
						navi_level2begin = '" . $_POST['navi_level2begin'] . "',
						navi_level3begin = '" . $_POST['navi_level3begin'] . "',
						navi_level1end = '" . $_POST['navi_level1end'] . "',
						navi_level2end = '" . $_POST['navi_level2end'] . "',
						navi_level3end = '" . $_POST['navi_level3end'] . "',
						navi_begin      = '" . $_POST['navi_begin'] . "',
						navi_end     = '" . $_POST['navi_end'] . "',
						navi_user_group  = '" . (empty($_REQUEST['navi_user_group']) ? '' : implode(',', $_REQUEST['navi_user_group'])) . "',
						navi_expand   = '" . (empty($_POST['navi_expand']) ? '0' : $_POST['navi_expand']) . "'
				");

				// ��������� ��������� ��������� � ������
                reportLog($_SESSION['user_name'] . " - ������ ���� ��������� (" . stripslashes($navi_titel) . ")", 2, 2);

				// ��������� ������� � ������ ���� ���������
                header('Location:index.php?do=navigation&cp=' . SESSION);
				break;
		}
	}



    /**
	 * �����, ��������������� ��� �������������� ������� ���������
	 *
	 * @param int $navigation_id ������������� ���� ���������
	 */
	function navigationEdit($navigation_id)
	{
		global $AVE_DB, $AVE_Template, $AVE_User;

		// �������� id ����
        $navigation_id = (int)$navigation_id;

		// ���������� �������� ������������
        switch ($_REQUEST['sub'])
		{
			// ���� �������� �� ����������, ���������� ����� � ������� ��� ��������������
            case '':

                // ��������� ������ � �� � �������� ��� ���������� � ������ ����
                $row = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_navigation
					WHERE id = '" . $navigation_id . "'
				")->fetchrow();

				// ��������� ������ ����� �������������
                $row->navi_user_group = explode(',', $row->navi_user_group);
				$row->AvGroups = $AVE_User->userGroupListGet();

                // ��������� ��� ���������� ��� ������������� � ������� � ���������� ���� � ������� ��� ��������������
                $AVE_Template->assign('nav', $row);
				$AVE_Template->assign('formaction', 'index.php?do=navigation&amp;action=templates&amp;sub=save&amp;id=' . $navigation_id . '&amp;cp=' . SESSION);
				$AVE_Template->assign('content', $AVE_Template->fetch('navigation/template.tpl'));
				break;


            // ���� ������������ ����� �� ������ ��������� ���������
            case 'save':

                // ��������� ������ � �� � ��������� ���������� � ������� ��� ������� ����
                $AVE_DB->Query("
					UPDATE " . PREFIX . "_navigation
					SET
						navi_titel    = '" . $_POST['navi_titel'] . "',
						navi_level1   = '" . $_POST['navi_level1'] . "',
						navi_level1active  = '" . $_POST['navi_level1active'] . "',
						navi_level2   = '" . $_POST['navi_level2'] . "',
						navi_level2active  = '" . $_POST['navi_level2active'] . "',
						navi_level3   = '" . $_POST['navi_level3'] . "',
						navi_level3active  = '" . $_POST['navi_level3active'] . "',
						navi_level1begin = '" . $_POST['navi_level1begin'] . "',
						navi_level1end = '" . $_POST['navi_level1end'] . "',
						navi_level2begin = '" . $_POST['navi_level2begin'] . "',
						navi_level2end = '" . $_POST['navi_level2end'] . "',
						navi_level3begin = '" . $_POST['navi_level3begin'] . "',
						navi_level3end = '" . $_POST['navi_level3end'] . "',
						navi_begin      = '" . $_POST['navi_begin'] . "',
						navi_end     = '" . $_POST['navi_end'] . "',
						navi_user_group  = '" . (empty($_REQUEST['navi_user_group']) ? '' : implode(',', $_REQUEST['navi_user_group'])) . "',
						navi_expand   = '" . (empty($_POST['navi_expand']) ? '0' : (int)$_POST['navi_expand']) . "'
					WHERE
						id = '" . $navigation_id . "'
				");

				// ��������� ��������� ��������� � ������
                reportLog($_SESSION['user_name'] . ' - ������� ������ ���� ��������� (' . stripslashes($_POST['navi_titel']) . ')', 2, 2);

				// ��������� ������� � ������ ���� ���������
                header('Location:index.php?do=navigation&cp=' . SESSION);
				exit;
				break;
		}
	}



    /**
	 * �����, ��������������� ��� ����������� ������� ����
	 *
	 * @param int $navigation_id ������������� ���� ��������� ���������
	 */
	function navigationCopy($navigation_id)
	{
		global $AVE_DB, $AVE_Template;


        // ���� � ������� ������� �������� �������� id ����
        if (is_numeric($navigation_id))
		{
			// ��������� ������ � �� �� ��������� ���������� � ���������� ����
            $row = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_navigation
				WHERE id = '" . $navigation_id . "'
			")->fetchrow();


            // ���� ������ ��������, �����
            if ($row)
			{

                // ��������� ������ � �� �� ���������� ������ ���� � ��������� ���������� � ������ ������,
                // ���������� � ���������� ������� � ��
                $AVE_DB->Query("
					INSERT
					INTO " . PREFIX . "_navigation
					SET
						id       = '',
						navi_titel    = '" . addslashes($row->navi_titel . ' ' . $AVE_Template->get_config_vars('CopyT')) . "',
						navi_level1   = '" . addslashes($row->navi_level1) . "',
						navi_level1active  = '" . addslashes($row->navi_level1active) . "',
						navi_level2   = '" . addslashes($row->navi_level2) . "',
						navi_level2active  = '" . addslashes($row->navi_level2active) . "',
						navi_level3   = '" . addslashes($row->navi_level3) . "',
						navi_level3active  = '" . addslashes($row->navi_level3active) . "',
						navi_begin      = '" . addslashes($row->navi_begin) . "',
						navi_end     = '" . addslashes($row->navi_end) . "',
						navi_level1begin = '" . addslashes($row->navi_level1begin) . "',
						navi_level2begin = '" . addslashes($row->navi_level2begin) . "',
						navi_level3begin = '" . addslashes($row->navi_level3begin) . "',
						navi_level1end = '" . addslashes($row->navi_level1end) . "',
						navi_level2end = '" . addslashes($row->navi_level2end) . "',
						navi_level3end = '" . addslashes($row->navi_level3end) . "',
						navi_user_group  = '" . addslashes($row->navi_user_group) . "',
						navi_expand   = '" . addslashes($row->navi_expand) . "'
				");


                // ��������� ��������� ��������� � ������
                reportLog($_SESSION['user_name'] . " - ������ ����� ���� ��������� (" . $row->navi_titel . ")", 2, 2);
			}
		}


        // ��������� ������� � ������ ���� ���������
        header('Location:index.php?do=navigation&cp=' . SESSION);
	}



    /**
	 * �����, ��������������� ��� �������� ���� ��������� � ���� ������� ����������� � ����
	 *
	 * @param int $navigation_id ������������� ���� ���������
	 */
	function navigationDelete($navigation_id)
	{
		global $AVE_DB;

		// ���� id ���� �������� � ��� �� ������ ���� (id �� 1)
        if (is_numeric($navigation_id) && $navigation_id != 1)
		{
			// ��������� ������ � �� �� �������� ����� ���������� � ������� ���������� ����
            $AVE_DB->Query("DELETE FROM " . PREFIX . "_navigation WHERE id = '" . $navigation_id . "'");
			// ��������� ������ � �� �� �������� ���� ������� ��� ������� ����
            $AVE_DB->Query("DELETE FROM " . PREFIX . "_navigation_items WHERE navi_id = '" . $navigation_id . "'");

            // ��������� ��������� ��������� � ������
            reportLog($_SESSION['user_name'] . " - ������ ���� ��������� (" . $navigation_id . ")", 2, 2);
		}

		// ��������� ������� � ������ ���� ���������
        header('Location:index.php?do=navigation&cp=' . SESSION);
	}



    /**
	 * �����, ��������������� ��� ��������� ������ ���� ������� � ���� ���� ���������
	 *
	 */
	function navigationAllItemList()
	{
		global $AVE_DB, $AVE_Template;

        $navigation_item = array();
		$navigations = array();

        // ��������� ������ � �� �� ��������� id � �������� ���� ���������
		$sql = $AVE_DB->Query("
			SELECT
				id,
				navi_titel
			FROM " . PREFIX . "_navigation
		");


        // ���������� ������������ ���������� ������
        while ($navigation = $sql->fetchrow())
		{
			// ��������� ������ � �� �� ��������� ���� ������� ��� ������� ����.
            // ���������� �������� ������ ������� ������.
            $sql_navis = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_navigation_items
				WHERE navi_id = '" . $navigation->id . "'
				AND parent_id = 0
				AND navi_item_level = 1
				ORDER BY navi_item_position ASC
			");

			// ���������� ������������ ��������� ������
            while ($row_1 = $sql_navis->fetchrow())
			{
				$navigation_item_2 = array();

                // ��������� ������ � �� �� ��������� ���������� ����.
                // ���������� �������� ������ ������� ������.
				$sql_2 = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_navigation_items
					WHERE navi_id = '" . $navigation->id . "'
					AND parent_id = '" . $row_1->Id . "'
					AND navi_item_level = 2
					ORDER BY navi_item_position ASC
				");

                // ���������� ������������ ��������� ������
    			while ($row_2 = $sql_2->fetchrow())
				{
					$navigation_item_3 = array();

                    // ��������� ������ � �� �� ��������� ���������� ����.
                    // ���������� �������� ������ �������� ������.
		            $sql_3 = $AVE_DB->Query("
						SELECT *
						FROM " . PREFIX . "_navigation_items
						WHERE navi_id = '" . $navigation->id . "'
						AND parent_id = '" . $row_2->Id . "'
						AND navi_item_level = 3
						ORDER BY navi_item_position ASC
					");

                    while ($row_3 = $sql_3->fetchrow())
					{
						array_push($navigation_item_3, $row_3);
					}

					$row_2->ebene_3 = $navigation_item_3;
					array_push($navigation_item_2, $row_2);
				}

				$row_1->ebene_2 = $navigation_item_2;
				$row_1->RubId = $navigation->id;
				$row_1->Rubname = $navigation->navi_titel;
				array_push($navigation_item, $row_1);
			}
			array_push($navigations, $navigation);
		}

		// �������� ���������� ������ � ������ ��� ������
        $AVE_Template->assign('navis', $navigations);
		$AVE_Template->assign('navi_items', $navigation_item);
	}


    /**
	 * �����, ��������������� ��� ������ ������� ���� ��������� � ������ ����������
	 *
	 * @param int $id ������������� ���� ���������
	 */
	function navigationItemList($id)
	{
		global $AVE_DB, $AVE_Template;

		$id = (int)$id;

		$navigation_item = array();

		// ��������� ������ � �� � �������� ������ ������� ������� ������ ��� ���������� ����
        $sql_navis = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_navigation_items
			WHERE navi_id = '" . $id . "'
			AND parent_id = 0
			AND navi_item_level = 1
			ORDER BY navi_item_position ASC
		");

		while ($row_1 = $sql_navis->fetchrow())
		{
			$navigation_item_2 = array();
            // ��������� ������ � �� � �������� ������ ������� ������� ������ ��� ���������� ����
			$sql_2 = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_navigation_items
				WHERE navi_id = '" . $id . "'
				AND parent_id = '" . $row_1->Id . "'
				AND navi_item_level = 2
				ORDER BY navi_item_position ASC
			");
			while ($row_2 = $sql_2->fetchrow())
			{
				$navigation_item_3 = array();

                // ��������� ������ � �� � �������� ������ ������� �������� ������ ��� ���������� ����
				$sql_3 = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_navigation_items
					WHERE navi_id = '" . $id . "'
					AND parent_id = '" . $row_2->Id . "'
					AND navi_item_level = 3
					ORDER BY navi_item_position ASC
				");
				while ($row_3 = $sql_3->fetchrow())
				{
					array_push($navigation_item_3, $row_3);
				}

				$row_2->ebene_3 = $navigation_item_3;
				array_push($navigation_item_2, $row_2);
			}
			$row_1->ebene_2 = $navigation_item_2;
			array_push($navigation_item, $row_1);
		}

        // ��������� ������ � �� � �������� �������� ���� ���������
		$sql = $AVE_DB->Query("
			SELECT navi_titel
			FROM " . PREFIX . "_navigation
			WHERE id = '" . $id . "'
		");
		$row = $sql->fetchrow();

        // �������� ������ � ������ ��� ������ � ���������� �������� � �������� ����
		$AVE_Template->assign('NavigatonName', $row->navi_titel);
		$AVE_Template->assign('entries', $navigation_item);
		$AVE_Template->assign('content', $AVE_Template->fetch('navigation/entries.tpl'));
	}



    /**
	 * �����, ��������������� ��� ���������� �������� ���� ��������� � ������ ����������
	 *
	 * @param int $id ������������� ���� ���������
	 */
	function navigationItemEdit($nav_id)
	{
		global $AVE_DB;

		$nav_id = (int)$nav_id;

		// ���������� ������������ ��� ���������, ��������� ������� POST ��� ���������� ���������
		foreach ($_POST['title'] as $id => $title)
		{
			// ���� �������� ������ ���� �� ������
            if (!empty($title))
			{
				$id = (int)$id;

                $_POST['navi_item_link'][$id] = (strpos($_POST['navi_item_link'][$id], 'javascript') !== false)
					? str_replace(array(' ', '%'), '-', $_POST['navi_item_link'][$id])
					: $_POST['navi_item_link'][$id];

				// ���������� ���� ������� ������ ���� (�������/���������)
                $navi_item_status = (empty($_POST['navi_item_status'][$id]) || empty($_POST['navi_item_link'][$id])) ? 0 : 1;

				$link_url = '';
				$matches = array();
				// ���� ������ ��������� ��� index.php?id=XX, ��� XX - ����� (id ���������)
                preg_match('/^index\.php\?id=(\d+)$/', trim($_POST['navi_item_link'][$id]), $matches);

                // �����
                if (isset($matches[1]))
				{
					// ��������� ������ � �� � �������� URL (���) ���  ������� ���������
                    $link_url = $AVE_DB->Query("
						SELECT document_alias
						FROM " . PREFIX . "_documents
						WHERE id = '" . $matches[1] . "'
					")->GetCell();
				}

				// ��������� ������ � �� �� ���������� ����������
                $AVE_DB->Query("
					UPDATE " . PREFIX . "_navigation_items
					SET
						title = '" . $this->_replace_wildcode($title) . "',
						navi_item_link  = '" . $_POST['navi_item_link'][$id] . "',
						navi_item_position  = '" . intval($_POST['navi_item_position'][$id]) . "',
						navi_item_target  = '" . $_POST['navi_item_target'][$id] . "',
						navi_item_status = '" . $navi_item_status . "',
						document_alias   = '" . ($link_url == '' ? $_POST['navi_item_link'][$id] : $link_url) . "'
					WHERE
						Id = '" . $id . "'
				");
			}
		}

		// ���� � ������� ������ �������� �� ���������� ������ ������ ���� ������� ������
		if (!empty($_POST['Titel_N'][0]))
		{
			// ��������� ������ � �� � ��������� ����� �����
            $AVE_DB->Query("
				INSERT
				INTO " . PREFIX . "_navigation_items
				SET
					Id     = '',
					title  = '" . $this->_replace_wildcode($_POST['Titel_N'][0]) . "',
					parent_id  = '0',
					navi_item_link   = '" . $_POST['Link_N'][0] . "',
					navi_item_target   = '" . $_POST['Ziel_N'][0] . "',
					navi_item_level  = '1',
					navi_item_position   = '" . intval($_POST['Rang_N'][0]) . "',
					navi_id = '" . intval($_POST['navi_id']) . "',
					navi_item_status  = '" . (empty($_POST['Link_N'][0]) ? '0' : '1') . "',
					document_alias    = '" . prepare_url(empty($_POST['Url_N'][0]) ? $_POST['Titel_N'][0] : $_POST['Url_N'][0]) . "'
			");

            // ��������� ��������� ��������� � ������
			reportLog($_SESSION['user_name'] . " - ������� ����� ���� ��������� (" . stripslashes($_POST['Titel_N'][0]) . ") - �� ������ �������", 2, 2);
		}

		// ������������ ������ � ����� ���������� ������� ���� ������� ������
		foreach ($_POST['Titel_Neu_2'] as $new2_id => $title)
		{
			// ���� �������� ������ �� ������
            if (!empty($title))
			{
				$new2_id = (int)$new2_id;

                // ��������� ������ � �� � ��������� ����� ��������
                $AVE_DB->Query("
					INSERT
					INTO " . PREFIX . "_navigation_items
					SET
						Id     = '',
						title  = '" . $this->_replace_wildcode($title) . "',
						parent_id  = '" . $new2_id . "',
						navi_item_link   = '" . $_POST['Link_Neu_2'][$new2_id] . "',
						navi_item_target   = '" . $_POST['Ziel_Neu_2'][$new2_id] . "',
						navi_item_level  = '2',
						navi_item_position   = '" . intval($_POST['Rang_Neu_2'][$new2_id]) . "',
						navi_id = '" . intval($_POST['navi_id']) . "',
						navi_item_status  = '" . (empty($_POST['Link_Neu_2'][$new2_id]) ? '0' : '1') . "',
						document_alias    = '" . prepare_url(empty($_POST['Url_Neu_2'][$new2_id]) ? $title : $_POST['Url_Neu_2'][$new2_id]) . "'
				");

                // ��������� ��������� ��������� � ������
				reportLog($_SESSION['user_name'] . " - ������� ����� ���� ��������� (" . stripslashes($title) . ") - ������ �������", 2, 2);
			}
		}

		// ������������ ������ � ����� ���������� ������� ���� �������� ������
		foreach ($_POST['Titel_Neu_3'] as $new3_id => $title)
		{
			// ���� �������� ������ �� ������
            if (!empty($title))
			{
				$new3_id = (int)$new3_id;
				// ��������� ������ � �� � ��������� ����� ��������
                $AVE_DB->Query("
					INSERT
					INTO " . PREFIX . "_navigation_items
					SET
						Id     = '',
						title  = '" . $this->_replace_wildcode($title) . "',
						parent_id  = '" . $new3_id . "',
						navi_item_link   = '" . $_POST['Link_Neu_3'][$new3_id] . "',
						navi_item_target   = '" . $_POST['Ziel_Neu_3'][$new3_id] . "',
						navi_item_level  = '3',
						navi_item_position   = '" . intval($_POST['Rang_Neu_3'][$new3_id]) . "',
						navi_id = '" . intval($_POST['navi_id']) . "',
						navi_item_status  = '" . (empty($_POST['Link_Neu_3'][$new3_id]) ? '0' : '1') . "',
						document_alias    = '" . prepare_url(empty($_POST['Url_Neu_3'][$new3_id]) ? $title : $_POST['Url_Neu_3'][$new3_id]) . "'
				");

				// ��������� ��������� ��������� � ������
                reportLog($_SESSION['user_name'] . " - ������� ����� ���� ��������� (" . stripslashes($title) . ") - ������ �������", 2, 2);
			}
		}

		// ���� � ������� ���� �������� ������ ����, ������� ���������� �������, �����
		if (!empty($_POST['del']) && is_array($_POST['del']))
		{
			// ���������� ������������ ���������� ������
            foreach ($_POST['del'] as $del_id => $del)
			{
				if (!empty($del))
				{
					$del_id = (int)$del_id;

                    // ��������� ������ � �� ��� ����������� � ���������� ������ ����������
                    $num = $AVE_DB->Query("
						SELECT Id
						FROM " . PREFIX . "_navigation_items
						WHERE parent_id = '" . $del_id . "'
						LIMIT 1
					")->NumRows();

					// ���� ������ ����� ����� ���������, �����
                    if ($num==1)
					{
						// ��������� ������ � �� � ������������ ����� ����
                        $AVE_DB->Query("
							UPDATE " . PREFIX . "_navigation_items
							SET navi_item_status = '0'
							WHERE Id = '" . $del_id . "'
						");

						// ��������� ��������� ��������� � ������
                        reportLog($_SESSION['user_name'] . " - ������������� ����� ���� ��������� (" . $del_id . ")", 2, 2);
					}
					else
					{ // � ��������� ������, ���� ������ ����� �� ����� ����������, �����

                        // ��������� ������ � �� � ������� ���������� �����
                        $AVE_DB->Query("
							DELETE
							FROM " . PREFIX . "_navigation_items
							WHERE Id = '" . $del_id . "'
						");

                        // ��������� ��������� ��������� � ������
						reportLog($_SESSION['user_name'] . " - ������ ����� ���� ��������� (" . $del_id . ")", 2, 2);
					}
				}
			}
		}

		// ��������� ���������� ��������
        header('Location:index.php?do=navigation&action=entries&id=' . $nav_id . '&cp=' . SESSION);
		exit;
	}



    /**
	 * �����, ��������������� ��� �������� ������� ���� ��������� ��������� � ��������� ����������.
	 * ������ ����� ���������� ��� �������� ��������� � ��������������� $document_id.
	 * ���� � ������ ���� ��� �������� - ����� ���������, � ��������� ������ ����� ��������������
	 *
	 * @param int $document_id ������������� ���������� ���������
	 */
	function navigationItemDelete($document_id)
	{
		global $AVE_DB;

		$document_id = (int)$document_id;

        // ��������� ������ � �� � �������� ID ������ ����, � ������� ������ ��������
		$sql = $AVE_DB->Query("
			SELECT Id
			FROM " . PREFIX . "_navigation_items
			WHERE navi_item_link = 'index.php?id=" . $document_id . "'
		");

        while ($row = $sql->fetchrow())
		{
			// ��������� ������ � �� ��� ����������� � ���������� ������ ����������
            $num = $AVE_DB->Query("
				SELECT Id
				FROM " . PREFIX . "_navigation_items
				WHERE parent_id = '" . $row->Id . "'
				LIMIT 1
			")->NumRows();

            // ���� ������ ����� ����� ���������, �����
			if ($num==1)
			{
				// ��������� ������ � �� � ������������ ����� ����
                $AVE_DB->Query("
					UPDATE " . PREFIX . "_navigation_items
					SET navi_item_status = '0'
					WHERE Id = '" . $row->Id . "'
				");

				// ��������� ��������� ��������� � ������
                reportLog($_SESSION['user_name'] . " - ������������� ����� ���� ��������� (" . $row->Id . ")", 2, 2);
			}
			else
			{ // � ��������� ������, ���� ������ ����� �� ����� ����������, �����

                // ��������� ������ � �� � ������� ���������� �����
				$AVE_DB->Query("
					DELETE
					FROM " . PREFIX . "_navigation_items
					WHERE Id = '" . $row->Id . "'
				");

                // ��������� ��������� ��������� � ������
				reportLog($_SESSION['user_name'] . " - ������ ����� ���� ��������� (" . $row->Id . ")", 2, 2);
			}
		}
	}



    /**
	 * �����, ��������������� ��� ��������� ������ ���� ���������.
	 * ������ ����� ������������ ��� ��������� ������� ��������� � ��������������� $document_id
	 *
	 * @param int $document_id ������������� ��������� �� ������� ��������� ����� ����
	 */
	function navigationItemStatusOn($document_id)
	{
		global $AVE_DB;

		if (!is_numeric($document_id)) return;

		// ��������� ������ � �� � �������� id ������ ����, ������� ������������� �������������� ��������� � ������
        $sql = $AVE_DB->Query("
			SELECT Id
			FROM " . PREFIX . "_navigation_items
			WHERE navi_item_link = 'index.php?id=" . $document_id . "'
			AND navi_item_status = '0'
		");

		while ($row = $sql->fetchrow())
		{
			// ��������� ������ � �� �������� ������ ������ ���� �� �������� (1)
            $AVE_DB->Query("
				UPDATE " . PREFIX . "_navigation_items
				SET navi_item_status = '1'
				WHERE Id = '" . $row->Id . "'
			");

			// ��������� ��������� ��������� � ������
            reportLog($_SESSION['user_name'] . " - ����������� ����� ���� ��������� (" . $row->Id . ")", 2, 2);
		}
	}

	/**
	 * �����, ��������������� ��� ����������� ������ ���� ���������.
	 * ������ ����� ������������ ��� ��������� ������� ��������� � ��������������� $document_id
	 *
	 * @param int $document_id ������������� ��������� �� ������� ��������� ����� ����
	 */
	function navigationItemStatusOff($document_id)
	{
		global $AVE_DB;

		if (!is_numeric($document_id)) return;

		// ��������� ������ � �� � �������� id ������ ����, ������� ������������� �������������� ��������� � ������
        $sql = $AVE_DB->Query("
			SELECT Id
			FROM " . PREFIX . "_navigation_items
			WHERE navi_item_link = 'index.php?id=" . $document_id . "'
			AND navi_item_status = '1'
		");

		while ($row = $sql->fetchrow())
		{
			// ��������� ������ � �� �������� ������ ������ ���� �� ���������� (0)
            $AVE_DB->Query("
				UPDATE " . PREFIX . "_navigation_items
				SET navi_item_status = '0'
				WHERE Id = '" . $row->Id . "'
			");

			// ��������� ��������� ��������� � ������
            reportLog($_SESSION['user_name'] . " - ������������� ����� ���� ��������� (" . $row->Id . ")", 2, 2);
		}
	}
}

?>