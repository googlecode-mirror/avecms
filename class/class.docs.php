<?php

/**
 * AVE.cms
 *
 * �����, ��������������� ��� ���������� ����������� � ������ ����������
 *
 *
 * @package AVE.cms
 * @filesource
 */

class AVE_Document
{

/**
 *	�������� ������
 */

	/**
	 * ���������� ���������� ������������ �� ����� ��������
	 *
	 * @var int
	 */
	var $_limit = 15;

	/**
	 * ������ ���� ����� (��� ��������� input)
	 *
	 * @var string
	 */
	var $_field_width = '400px';

	/**
	 * ������ �������������� ���� ����� (��� ��������� textarea)
	 *
	 * @var string
	 */
	var $_textarea_width = '98%';

	/**
	 * ������ �������������� ���� ����� (��� ��������� textarea)
	 *
	 * @var string
	 */
	var $_textarea_height = '400px';

	/**
	 * ������ ���������� �������������� ���� �����
	 *
	 * @var string
	 */
	var $_textarea_width_small = '98%';

	/**
	 * ������ ���������� �������������� ���� ����� (��� ��������� textarea)
	 *
	 * @var string
	 */
	var $_textarea_height_small = '200px';

	/**
	 * ������������ ���������� �������� � ������� � ���������
	 *
	 * @var int
	 */
	var $_max_remark_length = 5000;

/**
 *	���������� ������ ������
 */

	/**
	 * �����, ��������������� ��� ������������ ����� �������,
	 * ������� ����� ���������� ������ ������� ������ ������ ����������.
	 * �.�. � ������ �����/������� ������ ����� ������ ����������.
	 *
	 * @return int	����� ������� Unix
	 */
	function _documentListStart()
	{
		return mktime(0, 0, 0, $_REQUEST['publishedMonth'], $_REQUEST['publishedDay'], $_REQUEST['publishedYear']);
	}

	/**
	 * �����, ��������������� ��� ������������ ����� �������,
	 * ������� ����� ���������� ��������� ������� ������ ������ ����������.
	 * �.�. �� ����� �����/����� ���������� ����� ������ ����������.
	 *
	 * @return int	����� ������� Unix
	 */
	function _documentListEnd()
	{
		return mktime(23, 59, 59, $_REQUEST['expireMonth'], $_REQUEST['expireDay'], $_REQUEST['expireYear']);
	}

	/**
	 * �����, ��������������� ��� ������������ ����� ������� ������ ���������� ���������
	 *
	 * @return int	����� ������� Unix
	 */
	function _documentStart()
	{
		$timestamp = 0;
		if (!empty($_REQUEST['publishedDay']))
		{
			$timestamp = mktime(
				$_REQUEST['publishedHour'],
				$_REQUEST['publishedMinute'] ,
				0,
				$_REQUEST['publishedMonth'],
				$_REQUEST['publishedDay'],
				$_REQUEST['publishedYear']
			);
		}

		return $timestamp;
	}

	/**
	 * �����, ��������������� ��� ������������ ����� ������� ��������� ���������� ���������
	 *
	 * @return int	����� ������� Unix
	 */
	function _documentEnd()
	{
		$timestamp = 0;
		if (!empty($_REQUEST['expireDay']))
		{
			$timestamp = mktime(
				$_REQUEST['expireHour'],
				$_REQUEST['expireMinute'],
				0,
				$_REQUEST['expireMonth'],
				$_REQUEST['expireDay'],
				$_REQUEST['expireYear']
			);
		}

		return $timestamp;
	}

	/**
	 * �����, ��������������� ��� ��������� ���� ����
	 * (�����������, ������������ ����, ������������� ����� � �.�.),
	 * � ����� ������������ ��������������� ��������� ���������� ���� ����� (�������� ������)
	 *
	 * @param string $field_type	��� ����
	 * @param string $field_value	���������� ����
	 * @param int    $field_id		������������� ����
	 * @param string $dropdown		�������� ��� ���� ���� "���������� ������"
	 * @return string				HTML-��� ���� ���������
	 */
	function _documentFieldGet($field_type, $field_value, $field_id, $dropdown = '')
	{
		global $AVE_Template;

		// ���������� ������ �����������
		$img_pixel = 'templates/' . $_SESSION['admin_theme'] . '/images/blanc.gif';
		$field = '';

		switch ($field_type)
		{
			// ������� ������������ ������������� ���� (input)
			case 'kurztext' :
				$field  = '<a name="' . $field_id . '"></a>';
				$field .= '<input id="feld_' . $field_id . '" type="text" style="width:' . $this->_field_width . '" name="feld[' . $field_id . ']" value="' . htmlspecialchars($field_value, ENT_QUOTES) . '"> ';
				break;

			// ������� ������������ �������������� ���� (textarea ��� FCKEditor � ����������� �� ��������)
			case 'langtext' :
				if (isset($_COOKIE['no_wysiwyg']) && $_COOKIE['no_wysiwyg'] == 1)
				{
					$field  = '<a name="' . $field_id . '"></a>';
					$field .= '<textarea style="width:' . $this->_textarea_width . ';height:' . $this->_textarea_height . '" name="feld[' . $field_id . ']">' . $field_value . '</textarea>';
				}
				else
				{
					$oFCKeditor = new FCKeditor('feld[' . $field_id . ']') ;
					$oFCKeditor->Height = $this->_textarea_height;
					$oFCKeditor->Value  = $field_value;
					$field  = $oFCKeditor->Create($field_id);
				}
				break;

			// ������� ������������ ����������� �������������� ���� (textarea ��� FCKEditor � ����������� �� ��������)
			case 'smalltext' :
				if (isset($_COOKIE['no_wysiwyg']) && $_COOKIE['no_wysiwyg'] == 1)
				{
					$field  = "<a name=\"" . $field_id . "\"></a>";
					$field .= "<textarea style=\"width:" . $this->_textarea_width_small . "; height:" . $this->_textarea_height_small . "\"  name=\"feld[" . $field_id . "]\">" . $field_value . "</textarea>";
				}
				else
				{
					$oFCKeditor = new FCKeditor('feld[' . $field_id . ']') ;
					$oFCKeditor->Height = $this->_textarea_height_small;
					$oFCKeditor->Value  = $field_value;
					$oFCKeditor->ToolbarSet = 'cpengine_small';
					$field = $oFCKeditor->Create($field_id);
				}
				break;

//			case 'created' :
//				$field_value = (isset($_REQUEST['action']) && $_REQUEST['action'] == 'new') ? strftime(TIME_FORMAT) : $field_value;
//				$field_value = pretty_date($field_value, $_SESSION['user_language']);
//				if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'new')
//				{
//					$field  = "<a name=\"" . $field_id . "\"></a>";
//					$field .= "<input id=\"feld_" . $field_id . "\" type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\">";
//				}
//				else
//				{
//					$field  = "<a name=\"" . $field_id . "\"></a>";
//					$field .= "<input id=\"feld_" . $field_id . "\" type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\">&nbsp;";
//					$field .= "<input type=\"button\" value=\"������� ����\" class=\"button\" onclick=\"insert_now_date('feld_" . $field_id . "');\" />";
//				}
//				break;
//
//			case 'author':
//				$field_value = (isset($_REQUEST['action']) && $_REQUEST['action'] == 'new') ? $_SESSION['user_name'] : $field_value;
//				$field  = "<a name=\"" . $field_id . "\"></a>";
//				$field .= "<input id=\"feld_" . $field_id . "\" type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\"> ";
//				break;
//
			// ������� ������������ ���� ���� �����������
			case 'bild' :
			case 'bild_links' :
			case 'bild_rechts' :
				$massiv = explode('|', $field_value);
				$field  = "<a name=\"" . $field_id . "\"></a>";
				$field .= "<div id=\"feld_" . $field_id . "\"><img id=\"_img_feld__" . $field_id . "\" src=\"" . (!empty($field_value) ? '../index.php?thumb=' . htmlspecialchars($massiv[0], ENT_QUOTES) : $img_pixel) . "\" alt=\"" . (isset($massiv[1]) ? htmlspecialchars($massiv[1], ENT_QUOTES) : '') . "\" border=\"0\" /></div>";
				$field .= "<div style=\"display:none\" id=\"span_feld__" . $field_id . "\">&nbsp;</div>" . (!empty($field_value) ? "<br />" : '');
				$field .= "<input type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\" id=\"img_feld__" . $field_id . "\" />&nbsp;";
				$field .= "<input value=\"" . $AVE_Template->get_config_vars('MAIN_OPEN_MEDIAPATH') . "\" class=\"button\" type=\"button\" onclick=\"cp_imagepop('img_feld__" . $field_id . "', '', '', '0');\" />";
				break;

			// ������� ������������ ���� ���� ��� ����� ����������������
			case 'javascript' :
			case 'php' :
			case 'code' :
			case 'html' :
			case 'js' :
				$field  = "<a name=\"" . $field_id . "\"></a>";
				$field .= "<textarea id=\"feld_" . $field_id . "\" style=\"width:" . $this->_textarea_width . "; height:" . $this->_textarea_height . "\"  name=\"feld[" . $field_id . "]\">" . $field_value . "</textarea>";
				break;

			// ������� ������������ ���� ��� Flash ������ ��� �����-���� ��������
			case 'flash' :
				$field  = "<a name=\"" . $field_id . "\"></a>";
				$field .= "<div style=\"display:none\" id=\"feld_" . $field_id . "\"><img style=\"display:none\" id=\"_img_feld__" . $field_id . "\" src=\"". (!empty($field_value) ? htmlspecialchars($field_value, ENT_QUOTES) : $img_pixel) . "\" alt=\"\" border=\"0\" /></div>";
				$field .= "<div style=\"display:none\" id=\"span_feld__" . $field_id . "\"></div>";
				$field .= "<input type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\" id=\"img_feld__" . $field_id . "\" />&nbsp;";
				$field .= "<input value=\"" . $AVE_Template->get_config_vars('MAIN_OPEN_MEDIAPATH') . "\" class=\"button\" type=\"button\" onclick=\"cp_imagepop('img_feld__" . $field_id . "', '', '', '0');\" />";
				$field .= '<input style="margin-left:5px" class="button" type="button" value="?" onmouseover="return overlib(\'' . $AVE_Template->get_config_vars('DOC_FLASH_TYPE_HELP') . '\',ABOVE,WIDTH,300);" onmouseout="nd();" style="cursor: help;">';
				break;

			// ������� ������������ ���� ���� ����
			case 'download' :
				$field  = "<div style=\"\" id=\"feld_" . $field_id . "\"><a name=\"" . $field_id . "\"></a>";
				$field .= "<div style=\"display:none\" id=\"feld_" . $field_id . "\">";
				$field .= "<img style=\"display:none\" id=\"_img_feld__" . $field_id . "\" src=\"" . (!empty($field_value) ? htmlspecialchars($field_value, ENT_QUOTES) : $img_pixel) . "\" alt=\"\" border=\"0\" /></div>";
				$field .= "<div style=\"display:none\" id=\"span_feld__" . $field_id . "\"></div>";
				$field .= "<input type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\" id=\"img_feld__" . $field_id . "\" />&nbsp;";
				$field .= "<input value=\"" . $AVE_Template->get_config_vars('MAIN_OPEN_MEDIAPATH') . "\" class=\"button\" type=\"button\" onclick=\"cp_imagepop('img_feld__" . $field_id . "', '', '', '0');\" />";
				$field .= '<input style="margin-left:5px" class="button" type="button" value="?" onmouseover="return overlib(\'' . $AVE_Template->get_config_vars('DOC_FILE_TYPE_HELP') . '\',ABOVE,WIDTH,300);" onmouseout="nd();" style="cursor: help;">';
				$field .= '</div>';
				break;

			// ������� ������������ ���� ���� �����-����
			case 'video_avi' :
			case 'video_wmf' :
			case 'video_wmv' :
			case 'video_mov' :
				$field  = "<div style=\"\" id=\"feld_" . $field_id . "\"><a name=\"" . $field_id . "\"></a>";
				$field .= "<div style=\"display:none\" id=\"feld_" . $field_id . "\"><img style=\"display:none\" id=\"_img_feld__" . $field_id . "\" src=\"". (!empty($field_value) ? htmlspecialchars($field_value, ENT_QUOTES) : $img_pixel) . "\" alt=\"\" border=\"0\" /></div>";
				$field .= "<div style=\"display:none\" id=\"span_feld__" . $field_id . "\"></div>";
				$field .= "<input type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\" id=\"img_feld__" . $field_id . "\" />&nbsp;";
				$field .= "<input value=\"" . $AVE_Template->get_config_vars('MAIN_OPEN_MEDIAPATH') . "\" class=\"button\" type=\"button\" onclick=\"cp_imagepop('img_feld__" . $field_id . "', '', '', '0');\" />";
				$field .= '<input style="margin-left:5px" class="button" type="button" value="?" onmouseover="return overlib(\'' . $AVE_Template->get_config_vars('DOC_VIDEO_TYPE_HELP') . '\',ABOVE,WIDTH,300);" onmouseout="nd();" style="cursor: help;">';
				$field .= '</div>';
				break;

			// ������� ������������ ���� ���� ���������� ������
			case 'dropdown' :
				$items = explode(',', $dropdown);
				$field = "<select name=\"feld[" . $field_id . "]\">";
				$cnt = sizeof($items);
				for ($i=0;$i<$cnt;$i++)
				{
					$field .= "<option value=\"" . htmlspecialchars($items[$i], ENT_QUOTES) . "\"" . ((trim($field_value) == trim($items[$i])) ? " selected=\"selected\"" : "") . ">" . htmlspecialchars($items[$i], ENT_QUOTES) . "</option>";
				}
				$field .= "</select>";
				break;

			// ������� ������������ ���� ���� ������
			case 'link' :
			case 'link_ex' :
				$field  = "<a name=\"" . $field_id . "\"></a>";
				$field .= "<input id=\"feld_" . $field_id . "\" type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\">&nbsp;";
				$field .= "<input value=\"" . $AVE_Template->get_config_vars('MAIN_BROWSE_DOCUMENTS') . "\" class=\"button\" type=\"button\" onclick=\"openLinkWin('feld_" . $field_id . "', 'feld_" . $field_id . "');\" />";
				break;
		}

		return $field;
	}

/**
 *	���������� ������
 */

	/**
	 *	���������� �����������
	 */

	/**
	 * �����, ��������������� ��� ��������� ������ ���������� � ������ ����������
	 *
	 */
	function documentListGet()
	{
		global $AVE_DB, $AVE_Rubric, $AVE_Template;

		$ex_titel = '';
		$nav_titel = '';
		$ex_zeit = '';
		$nav_zeit = '';
		$request = '';
		$ex_rub = '';
		$nav_rub = '';
		$ex_docstatus = '';
		$navi_docstatus = '';

		// ���� � ������� ������ �������� �� ����� ��������� �� ��������
		if (!empty($_REQUEST['QueryTitel']))
		{
			$request = $_REQUEST['QueryTitel'];
			$kette = explode(' ', $request);  // �������� ������ ����, �������� �� ������� (���� �� ���������)

			// ���������� ������������ �����, �������� �������, ������� ����� ��������� � ������� � ��
			foreach ($kette as $suche)
			{
				$und = @explode(' +', $suche);
				foreach ($und as $und_wort)
				{
					if (strpos($und_wort, '+') !== false)
					{
						$ex_titel .= " AND (document_title LIKE '%" . substr($und_wort, 1) . "%')";
					}
				}

				$und_nicht = @explode(' -', $suche);
				foreach ($und_nicht as $und_nicht_wort)
				{
					if (strpos($und_nicht_wort, '-') !== false)
					{
						$ex_titel .= " AND (document_title NOT LIKE '%" . substr($und_nicht_wort, 1) . "%')";
					}
				}

				$start = explode(' +', $request);
				if (strpos($start[0], ' -') !== false) $start = explode(' -', $request);
				$start = $start[0];
			}

			$ex_titel = "AND (document_title LIKE '%" . $start . "%')" . $ex_titel;
			$nav_titel = '&QueryTitel=' . urlencode($request);
		}

		// ���� � ������� ������ id ������������ �������
		if (isset($_REQUEST['rubric_id']) && $_REQUEST['rubric_id'] != 'all')
		{
			// ��������� �������, ������� ����� ��������� � ������� � ��
			$ex_rub = " AND rubric_id = '" . $_REQUEST['rubric_id'] . "'";

			// ��������� �������, ������� ����� ��������� � �������
			$nav_rub = '&rubric_id=' . (int)$_REQUEST['rubric_id'];
		}

		// ���� � ������� ������ �������� �� ���������� ���������� �� ������������� ���������� ���������
		if (!empty($_REQUEST['TimeSelect']))
		{
			// ��������� �������, ������� ����� ��������� � ������� � ��
			$ex_zeit = 'AND ((document_published BETWEEN ' . $this->_documentListStart() . ' AND ' . $this->_documentListEnd() . ') OR document_published = 0)';

			// ��������� �������, ������� ����� ��������� � �������
			$nav_zeit = '&TimeSelect=1'
				. '&publishedMonth=' . (int)$_REQUEST['publishedMonth']
				. '&publishedDay='   . (int)$_REQUEST['publishedDay']
				. '&publishedYear='  . (int)$_REQUEST['publishedYear']
				. '&expireMonth='    . (int)$_REQUEST['expireMonth']
				. '&expireDay='      . (int)$_REQUEST['expireDay']
				. '&expireYear='     . (int)$_REQUEST['expireYear'];
		}

		// ���� � ������� ������ �������� �� ���������� ���������� �� �������
		if (!empty($_REQUEST['status']))
		{
			// ����������, ����� ������ ������������� � ��������� �������, ������� ����� ��������� � ������� � ��,
			// � ����� � �������, ��� ���������� ���������
			switch ($_REQUEST['status'])
			{
				// � ����� ��������
				case '':
				case 'All':
					break;

				// ������ ��������������
				case 'Opened':
					$ex_docstatus = "AND document_status = '1'";
					$navi_docstatus = '&status=Opened';
					break;

				// ������ ����������������
				case 'Closed':
					$ex_docstatus = "AND document_status = '0'";
					$navi_docstatus = '&status=Closed';
					break;

				// ���������� �� ��������
				case 'Deleted':
					$ex_docstatus = "AND document_deleted = '1'";
					$navi_docstatus = '&status=Deleted';
					break;
			}
		}

		// ���������� ������ ����������� � id ���������, ���� �� ������������ � �������
		$ex_Geloescht = (UGROUP != 1) ? "AND document_deleted != '1'" : '' ;
		$w_id = !empty($_REQUEST['doc_id']) ? " AND Id = '" . $_REQUEST['doc_id'] . "'" : '';

		// ��������� ������ � �� �� ��������� ���������� ���������� ��������������� ���������������� ��������
		$num = $AVE_DB->Query("
			SELECT COUNT(*)
			FROM " . PREFIX . "_documents
			WHERE 1
			" . $ex_Geloescht . "
			" . $ex_zeit . "
			" . $ex_titel . "
			" . $ex_rub . "
			" . $ex_docstatus . "
			" . $w_id . "
		")->GetCell();

		// ���������� ����� ����������, ������� ����� ������� �� 1 ��������
		$limit = (isset($_REQUEST['Datalimit']) && is_numeric($_REQUEST['Datalimit']) && $_REQUEST['Datalimit'] > 0)
			? $_REQUEST['Datalimit']
			: $limit = $this->_limit;

		$nav_limit = '&Datalimit=' . $limit;

		// ���������� ���������� �������, ������� ����� ������������ �� ��������� ���������� ���������� ����������
		$seiten = ceil($num / $limit);
		$start = get_current_page() * $limit - $limit;

		$db_sort   = 'ORDER BY document_changed DESC';
		$navi_sort = '&sort=changed_desc';

		// ���� � ������� ������������ �������� ����������
		if (!empty($_REQUEST['sort']))
		{
			// ����������, �� ������ ��������� ���������� ����������
			switch ($_REQUEST['sort'])
			{
				// �� id ���������, �� �����������
				case 'id' :
					$db_sort   = 'ORDER BY Id ASC';
					$navi_sort = '&sort=id';
					break;

				// �� id ���������, �� ��������
				case 'id_desc' :
					$db_sort   = 'ORDER BY Id DESC';
					$navi_sort = '&sort=id_desc';
					break;

				// �� �������� ���������, � ���������� �������
				case 'title' :
					$db_sort   = 'ORDER BY document_title ASC';
					$navi_sort = '&sort=title';
					break;

				// �� �������� ���������, � �������� ���������� �������
				case 'title_desc' :
					$db_sort   = 'ORDER BY document_title DESC';
					$navi_sort = '&sort=title_desc';
					break;

				// �� url-������, � ���������� �������
				case 'alias' :
					$db_sort   = 'ORDER BY document_alias ASC';
					$navi_sort = '&sort=alias';
					break;

				// �� url-������, � �������� ���������� �������
				case 'alias_desc' :
					$db_sort   = 'ORDER BY document_alias DESC';
					$navi_sort = '&sort=alias_desc';
					break;

				// �� id �������, �� �����������
				case 'rubric' :
					$db_sort   = 'ORDER BY rubric_id ASC';
					$navi_sort = '&sort=rubric';
					break;

				// �� id �������, �� ��������
				case 'rubric_desc' :
					$db_sort   = 'ORDER BY rubric_id DESC';
					$navi_sort = '&sort=rubric_desc';
					break;

				// �� ���� ����������, �� �����������
				case 'published' :
					$db_sort   = 'ORDER BY document_published ASC';
					$navi_sort = '&sort=published';
					break;

				// �� ���� ����������, �� ��������
				case 'published_desc' :
					$db_sort   = 'ORDER BY document_published DESC';
					$navi_sort = '&sort=published_desc';
					break;

				// �� ���������� ����������, �� �����������
				case 'view' :
					$db_sort   = 'ORDER BY document_count_view ASC';
					$navi_sort = '&sort=view';
					break;

				// �� ���������� ����������, �� ��������
				case 'view_desc' :
					$db_sort   = 'ORDER BY document_count_view DESC';
					$navi_sort = '&sort=view_desc';
					break;

				// �� ���������� ������ ���������, �� �����������
				case 'print' :
					$db_sort   = 'ORDER BY document_count_print ASC';
					$navi_sort = '&sort=print';
					break;

				// �� ���������� ������ ���������, �� ��������
				case 'print_desc' :
					$db_sort   = 'ORDER BY document_count_print DESC';
					$navi_sort = '&sort=print_desc';
					break;

				// �� ������, �� ����������� �����������
				case 'author' :
					$db_sort   = 'ORDER BY document_author_id ASC';
					$navi_sort = '&sort=author';
					break;

				// �� ������, �� ����������� ��������
				case 'author_desc' :
					$db_sort   = 'ORDER BY document_author_id DESC';
					$navi_sort = '&sort=author_desc';
					break;

				// �� ���� ���������� ��������������, �� �����������
				case 'changed':
					$db_sort   = 'ORDER BY document_changed ASC';
					$navi_sort = '&sort=changed';
					break;

				// �� ���� ���������� ��������������, �� ��������
				case 'changed_desc':
					$db_sort   = 'ORDER BY document_changed DESC';
					$navi_sort = '&sort=changed_desc';
					break;

				// �� ���������, �� ���� ���������� �������������� �� ��������.
				// ��������� ����������������� ��������, ����� ������ � ������.
				default :
					$db_sort   = 'ORDER BY document_changed DESC';
					$navi_sort = '&sort=changed_desc';
					break;
			}
		}

		$docs = array();

		// ��������� ������ � �� �� ��������� ��� �� ���������� ����������, ���������� ��������, � ��� ��
		// ��������� ���� ������, � ������ ���� �������, � ����� ���� ���������� � ������ ��� ������ ��
		// ���� ��������.
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_documents
			WHERE 1
			" . $ex_Geloescht . "
			" . $ex_zeit . "
			" . $ex_titel . "
			" . $ex_rub . "
			" . $ex_docstatus . "
			" . $w_id . "
			" . $db_sort . "
			LIMIT " . $start . "," . $limit . "
		");

		// ���������� ������������ ���������� ������ � ����� ���������� ��������� �� ��� � �������������� ����
		while ($row = $sql->FetchRow())
		{
			// ���������� ���������� ������������, ����������� ��� ������� ���������
			$row->ist_remark = $AVE_DB->Query("
				SELECT COUNT(*)
				FROM " . PREFIX . "_document_remarks
				WHERE document_id = '" . $row->Id . "'
			")->GetCell();

			$this->documentPermissionFetch($row->rubric_id);

			// �������� �������� ������� �� �� Id
			$row->RubName         = $AVE_Rubric->rubricNameByIdGet($row->rubric_id)->rubric_title;
			$row->document_author = get_username_by_id($row->document_author_id); // �������� ��� ������������ (������)
			$row->cantEdit        = 0;
			$row->canDelete       = 0;
			$row->canEndDel       = 0;
			$row->canOpenClose    = 0;

			// ��������� �������������� � ��������
			// ���� ����� ����� ����� �������� ���� ��������� � �������
			// ��� ������������ ��������� �������� ��� ��������� � �������
			if ( ($row->document_author_id == @$_SESSION['user_id']
				&& isset($_SESSION[$row->rubric_id . '_editown']) && @$_SESSION[$row->rubric_id . '_editown'] == 1)
				|| (isset($_SESSION[$row->rubric_id . '_editall']) && $_SESSION[$row->rubric_id . '_editall'] == 1) )
			{
					$row->cantEdit  = 1;
					$row->canDelete = 1;
			}
			// ��������� �������������� ������� �������� � �������� ������ 404 ���� ��������� ��������� ��������������
			if ( ($row->Id == 1 || $row->Id == PAGE_NOT_FOUND_ID)
				&& isset($_SESSION[$row->rubric_id . '_newnow']) && @$_SESSION[$row->rubric_id . '_newnow'] != 1)
			{
				$row->cantEdit = 0;
			}
			// ��������� ������ ����������� � �������������� ���� ��������� ���� �� ��������� ��������� ��������������
			if ($row->document_author_id == @$_SESSION['user_id']
				&& isset($_SESSION[$row->rubric_id . '_newnow']) && @$_SESSION[$row->rubric_id . '_newnow'] == 1)
			{
				$row->canOpenClose = 1;
			}
			// ��������� ��, ���� ������������ ����������� ������ ��������������� ��� ����� ��� ����� �� �������
			if (UGROUP == 1 || @$_SESSION[$row->rubric_id . '_alles'] == 1)
			{
				$row->cantEdit     = 1;
				$row->canDelete    = 1;
				$row->canEndDel    = 1;
				$row->canOpenClose = 1;
			}
			// ��������� �������� ������� �������� � �������� � 404 �������
			if ($row->Id == 1 || $row->Id == PAGE_NOT_FOUND_ID)
			{
				$row->canDelete = 0;
				$row->canEndDel = 0;
			}

			array_push($docs, $row);
		}

		// �������� ���������� ������ � ������ ��� ������
		$AVE_Template->assign('docs', $docs);

		$link  = "index.php?do=docs";
		$link .= (isset($_REQUEST['action']) && $_REQUEST['action'] == 'showsimple') ? '&action=showsimple' : '';
		$link .= !empty($_REQUEST['target']) ? '&target=' . urlencode($_REQUEST['target']) : '';
		$link .= !empty($_REQUEST['doc']) ? '&doc=' . urlencode($_REQUEST['doc']) : '';
		$link .= !empty($_REQUEST['document_alias']) ? '&document_alias=' . urlencode($_REQUEST['document_alias']) : '';
		$link .= !empty($_REQUEST['navi_item_target']) ? '&navi_item_target=' . urlencode($_REQUEST['navi_item_target']) : '';
		$link .= $navi_docstatus;
		$link .= $nav_titel;
		$link .= $nav_rub;
		$link .= $nav_zeit;
		$link .= $nav_limit;
		$link .= (isset($_REQUEST['selurl']) && $_REQUEST['selurl'] == 1) ? '&selurl=1' : '';
		$link .= (isset($_REQUEST['idonly']) && $_REQUEST['idonly'] == 1) ? '&idonly=1' : '';
		$link .= (isset($_REQUEST['pop']) && $_REQUEST['pop'] == 1) ? '&pop=1' : '';

		$AVE_Template->assign('link', $link);

		// ���� ���������� ���������� ���������� ��������� ����� �� ����� �������� - ��������� ������������ ���������
		if ($num > $limit)
		{
			$page_nav = get_pagination($seiten, 'page', ' <a class="pnav" href="' . $link . $navi_sort . '&page={s}&cp=' . SESSION . '">{t}</a> ');
			$AVE_Template->assign('page_nav', $page_nav);
		}

		$AVE_Template->assign('DEF_DOC_START_YEAR', mktime(0, 0, 0, date("m"), date("d"), date("Y") - 10));
		$AVE_Template->assign('DEF_DOC_END_YEAR', mktime(0, 0, 0, date("m"), date("d"), date("Y") + 10));
	}

	/**
	 * �����, ��������������� ��� ���������� ������ ��������� � ��
	 *
	 * @param int $rubric_id	������������� �������
	 */
	function documentNew($rubric_id)
	{
		global $AVE_DB, $AVE_Rubric, $AVE_Template;

		$this->documentPermissionFetch($rubric_id);

		// ���� ������������ ����� ����� �� ���������� ���������� � ��������� �������, �����
		if ( (isset($_SESSION[$rubric_id . '_newnow'])  && $_SESSION[$rubric_id . '_newnow'] == 1)
			|| (isset($_SESSION[$rubric_id . '_new'])   && $_SESSION[$rubric_id . '_new']    == 1)
			|| (isset($_SESSION[$rubric_id . '_alles']) && $_SESSION[$rubric_id . '_alles']  == 1)
			|| (defined('UGROUP') && UGROUP == 1) )
		{
			// ���������� ��� ��������, ���������� � ��������� sub
			switch ($_REQUEST['sub'])
			{
				case 'save': // ���������� ��������� � ��
					$start  = $this->_documentStart(); // ����/����� ������ ���������� ���������
					$ende   = $this->_documentEnd();   // ����/����� ��������� ���������� ���������
					$innavi = check_permission_acp('navigation_new') ? '&innavi=1' : '';

					// ���������� ������ ���������
					$document_status = !empty($_REQUEST['document_status']) ? (int)$_REQUEST['document_status'] : '';

					// ���� ������ ��������� �� ���������
					if (empty($document_status))
					{
						$innavi = '';
						@reset($_POST);
						$newtext = "\n\n";

						// ��������� ����� ���������, ��������� �� ������,
						// ������� ������������ ���� � ���� ���������
						foreach ($_POST['feld'] as $val)
						{
							if (!empty($val))
							{
								$newtext .= $val;
								$newtext .= "\n---------------------\n";
							}
						}
						$text = strip_tags($newtext);

						// �������� e-mail ����� �� ����� �������� �������
						$system_mail = get_settings('mail_from');
						$system_mail_name = get_settings('mail_from_name');

						// ���������� �������������� �����������, � ��� ��� ���������� ��������� ��������
						$body_to_admin = $AVE_Template->get_config_vars('DOC_MAIL_BODY_CHECK');
						$body_to_admin = str_replace('%N%', "\n", $body_to_admin);
						$body_to_admin = str_replace('%TITLE%', stripslashes($_POST['doc_title']), $body_to_admin);
						$body_to_admin = str_replace('%USER%', "'" . $_SESSION['user_name'] . "'", $body_to_admin);
						send_mail(
							$system_mail,
							$body_to_admin . $text,
							$AVE_Template->get_config_vars('DOC_MAIL_SUBJECT_CHECK'),
							$system_mail,
							$system_mail_name,
							'text'
						);

						// ���������� ����������� ������, � ��� ��� �������� ��������� �� ��������
						$body_to_author = str_replace('%N%', "\n", $AVE_Template->get_config_vars('DOC_MAIL_BODY_USER'));
						$body_to_author = str_replace('%TITLE%', stripslashes($_POST['doc_title']), $body_to_author);
						$body_to_author = str_replace('%USER%', "'" . $_SESSION['user_name'] . "'", $body_to_author);
						send_mail(
							$_SESSION['user_email'],
							$body_to_author,
							$AVE_Template->get_config_vars('DOC_MAIL_SUBJECT_USER'),
							$system_mail,
							$system_mail_name,
							'text'
						);
					}

					if (! ((isset($_SESSION[$rubric_id . '_newnow']) && $_SESSION[$rubric_id . '_newnow'] == 1)
						|| (isset($_SESSION[$rubric_id . '_alles']) && $_SESSION[$rubric_id . '_alles'] == 1)
						|| (defined('UGROUP') && UGROUP == 1)) )
					{
						$document_status = 0;
					}

					$suche = (isset($_POST['document_in_search']) && $_POST['document_in_search'] == 1) ? 1 : 0;

					// ���������/��������� ����� ������ �� ������������
					$_REQUEST['document_alias'] = $_url = prepare_url(empty($_POST['document_alias']) ? trim($_POST['prefix'] . '/' . $_POST['doc_title'], '/') : $_POST['document_alias']);
					$cnt = 1;
					while (
						$AVE_DB->Query("
							SELECT 1
							FROM " . PREFIX . "_documents
							WHERE document_alias = '" . $_REQUEST['document_alias'] . "'
							LIMIT 1
						")->NumRows())
					{
						$_REQUEST['document_alias'] = $_url . '-' . $cnt;
						$cnt++;
					}

					// ��������� ������ � �� �� ��������� ������ ���������
					$AVE_DB->Query("
						INSERT
						INTO " . PREFIX . "_documents
						SET
							rubric_id                 = '" . $rubric_id . "',
							document_title            = '" . clean_no_print_char($_POST['doc_title']) . "',
							document_alias            = '" . $_REQUEST['document_alias'] . "',
							document_published        = '" . $start . "',
							document_expire           = '" . $ende . "',
							document_changed          = '" . time() . "',
							document_author_id        = '" . $_SESSION['user_id'] . "',
							document_in_search        = '" . $suche . "',
							document_meta_keywords    = '" . clean_no_print_char($_POST['document_meta_keywords']) . "',
							document_meta_description = '" . clean_no_print_char($_POST['document_meta_description']) . "',
							document_meta_robots      = '" . $_POST['document_meta_robots'] . "',
							document_status           = '" . $document_status . "',
							document_linked_navi_id   = '" . (int)$_POST['document_linked_navi_id'] . "'
					");

					// �������� id ����������� ������
					$iid = $AVE_DB->InsertId();

					// ��������� ��������� ��������� � ������
					reportLog($_SESSION['user_name'] . ' - ������� �������� (' . $iid . ')', 2, 2);

					// ���������� ������������ ���� ���������
					foreach ($_POST['feld'] as $fld_id => $fld_val)
					{
						if (!$AVE_DB->Query("
								SELECT 1
								FROM " . PREFIX . "_rubric_fields
								WHERE Id = '" . $fld_id . "'
								AND rubric_id = '" . $rubric_id . "'
								LIMIT 1
							")->NumRows())
						{
							continue;
						}

						// ���� ��������� ������������� php ����, ����� �������� ������ ����
						if (!check_permission('document_php'))
						{
							if (is_php_code($fld_val)) $fld_val = '';
						}

						// ������� �� ������ ����������� �������
						$fld_val = clean_no_print_char($fld_val);
						$fld_val = pretty_chars($fld_val);

						// ��������� ������ � �� �� ���������� ������ ���� � ��� ����������
						$AVE_DB->Query("
							INSERT
							INTO " . PREFIX . "_document_fields
							SET
								rubric_field_id    = '" . $fld_id . "',
								document_id        = '" . $iid . "',
								field_value        = '" . $fld_val . "',
								document_in_search = '" . $suche . "'
						");
					}

					header('Location:index.php?do=docs&action=after&document_id=' . $iid . '&rubric_id=' . $rubric_id . '&cp=' . SESSION . $innavi);
					exit;

				case '': // �������� �� ���������, ���� �� ������
					$document = new stdClass();

					// �������� ������ ���� ������� �� ���������� ���������� � ������������ �������
					$this->documentPermissionFetch($rubric_id);

					// ���������� ����, ������� ����� ������������ ��� ��������� ����� ������� � ���������
					if ( (defined('UGROUP') && UGROUP == 1)
						|| (isset($_SESSION[$rubric_id . '_alles']) && $_SESSION[$rubric_id . '_alles'] == 1)
						|| (isset($_SESSION[$rubric_id . '_newnow']) && $_SESSION[$rubric_id . '_newnow'] == 1) )
					{
						$document->dontChangeStatus = 0;
					}
					else
					{
						$document->dontChangeStatus = 1;
					}

					$fields = array();

					// ��������� ������ � �� �� ��������� ������ �����, ������� ��������� � ������� ���������
					$sql = $AVE_DB->Query("
						SELECT *
						FROM " . PREFIX . "_rubric_fields
						WHERE rubric_id = '" . $rubric_id . "'
						ORDER BY rubric_field_position ASC
					");
					while ($row = $sql->FetchRow())
					{
						$row->Feld = $this->_documentFieldGet($row->rubric_field_type, $row->rubric_field_default, $row->Id, $row->rubric_field_default);
						array_push($fields, $row);
					}

					// ��������� ������ � �������� � ������
					$document->fields = $fields;
					$document->rubric_title = $AVE_Rubric->rubricNameByIdGet($rubric_id)->rubric_title;
					$document->rubric_url_prefix = strftime($AVE_Rubric->rubricNameByIdGet($rubric_id)->rubric_alias);
					$document->formaction = 'index.php?do=docs&action=new&sub=save&rubric_id=' . $rubric_id . ((isset($_REQUEST['pop']) && $_REQUEST['pop']==1) ? 'pop=1' : '') . '&cp=' . SESSION;
					$document->document_published = time();
					$document->document_expire = mktime(date("H"), date("i"), 0, date("m"), date("d"), date("Y") + 10);

					$AVE_Template->assign('document', $document);
					$AVE_Template->assign('content', $AVE_Template->fetch('documents/form.tpl'));
					break;
			}
		}
		else
		{	// ������������ �� ����� ���� �� �������� ���������, ��������� ��������� � �������
			$AVE_Template->assign('content', $AVE_Template->get_config_vars('DOC_NO_PERMISSION_RUB'));
		}
	}

	/**
	 * �����, ��������������� ��� �������������� ���������
	 *
	 * @param int $document_id	������������� ���������
	 */
	function documentEdit($document_id)
	{
		global $AVE_DB, $AVE_Rubric, $AVE_Template;

		// ���������� ��������, ��������� �������������
		switch ($_REQUEST['sub'])
		{
			// ���� ���� ������ ������ ��������� ���������
			case 'save':

				// ��������� ������ � �� �� ��������� ������ ��������� � id �������
				$row = $AVE_DB->Query("
					SELECT
						rubric_id,
						document_author_id
					FROM " . PREFIX . "_documents
					WHERE Id = '" . $document_id . "'
				")->FetchRow();

				$row->cantEdit = 0;

				// ���������� ����� ������� � ���������� � ������ �������
				$this->documentPermissionFetch($row->rubric_id);

				// ��������� ��������������
				// ���� ����� ����� ����� �������� ���� ��������� � �������
				// ��� ������������ ��������� �������� ��� ��������� � �������
				if ( (isset($_SESSION['user_id']) && $row->document_author_id == $_SESSION['user_id'] &&
						isset($_SESSION[$row->rubric_id . '_editown']) && $_SESSION[$row->rubric_id . '_editown'] == 1)
					|| (isset($_SESSION[$row->rubric_id . '_editall']) && @$_SESSION[$row->rubric_id . '_editall'] == 1) )
				{
					$row->cantEdit = 1;
				}
				// ��������� �������������� ������� �������� � �������� ������ 404 ���� ��������� ��������� ��������������
				if ( ($document_id == 1 || $document_id == PAGE_NOT_FOUND_ID) && @$_SESSION[$row->rubric_id . '_newnow'] != 1 )
				{
					$row->cantEdit = 0;
				}
				// ��������� ��������������, ���� ������������ ����������� ������ ��������������� ��� ����� ��� ����� �� �������
				if ( (defined('UGROUP') && UGROUP == 1)
					|| (isset($_SESSION[$row->rubric_id . '_alles']) && $_SESSION[$row->rubric_id . '_alles'] == 1) )
				{
					$row->cantEdit = 1;
				}

				// ���� �������������� ��������� ��� ������� ������������
				if ($row->cantEdit == 1)
				{
					// ������������ ��� ������, ��������� � �������
					$suche     = (isset($_POST['document_in_search']) && $_POST['document_in_search'] == 1) ? '1' : '0';
					$docstatus = ( (isset($_SESSION[$row->rubric_id . '_newnow']) && $_SESSION[$row->rubric_id . '_newnow'] == 1)
								|| (isset($_SESSION[$row->rubric_id . '_alles']) && $_SESSION[$row->rubric_id . '_alles'] == 1)
								|| (defined('UGROUP') && UGROUP == 1) ) ? (isset($_REQUEST['document_status']) ? $_REQUEST['document_status'] : '0') : '0';
					$docstatus = ($document_id == 1 || $document_id == PAGE_NOT_FOUND_ID) ? '1' : $docstatus;
					$docend    = ($document_id == 1 || $document_id == PAGE_NOT_FOUND_ID) ? '0' : $this->_documentEnd();
					$docstart  = ($document_id == 1 || $document_id == PAGE_NOT_FOUND_ID) ? '0' : $this->_documentStart();

					// ���������/��������� ����� �� ������������
					$_REQUEST['document_alias'] = $_url = prepare_url(empty($_POST['document_alias'])
						? trim($_POST['prefix'] . '/' . $_POST['doc_title'], '/')
						: $_POST['document_alias']);
					$cnt = 1;
					while ($AVE_DB->Query("
						SELECT 1
						FROM " . PREFIX . "_documents
						WHERE Id != '" . $document_id . "'
						AND document_alias = '" . $_REQUEST['document_alias'] . "'
						LIMIT 1
						")->NumRows() == 1)
					{
						$_REQUEST['document_alias'] = $_url . '-' . $cnt;
						$cnt++;
					}

					// ��������� ������ � �� �� ���������� ��������� � ������� ����������
					$AVE_DB->Query("
						UPDATE " . PREFIX . "_documents
						SET
							document_title            = '" . clean_no_print_char($_POST['doc_title']) . "',
							document_alias            = '" . $_REQUEST['document_alias'] . "',
							document_in_search        = '" . $suche . "',
							document_meta_keywords    = '" . clean_no_print_char($_POST['document_meta_keywords']) . "',
							document_meta_description = '" . clean_no_print_char($_POST['document_meta_description']) . "',
							document_meta_robots      = '" . $_POST['document_meta_robots'] . "',
							document_status           = '" . $docstatus . "',
							document_expire           = '" . $docend . "',
							document_published        = '" . $docstart . "',
							document_changed          = '" . time() . "',
							document_linked_navi_id   = '" . (int)$_POST['document_linked_navi_id'] . "'
						WHERE
							Id = '" . $document_id . "'
					");

					// ��������� ������ � �� �� ���������� ��������� � ������� ���������
					$AVE_DB->Query("
						UPDATE " . PREFIX . "_navigation_items
						SET document_alias = '" . $_REQUEST['document_alias'] . "'
						WHERE navi_item_link = 'index.php?id=" . $document_id . "'
					");

					// ���� �������� �������� ����
					if (isset($_POST['feld']))
					{
						// ���������� ������������ ������ ����
						foreach ($_POST['feld'] as $fld_id => $fld_val)
						{
							$row_df = $AVE_DB->Query("
								SELECT
									field_value,
									document_in_search
								FROM " . PREFIX . "_document_fields
								WHERE Id = '" . $fld_id . "'
								AND document_id = '" . $document_id . "'
							")->FetchRow();

							if (!$row_df) continue;

							if ($row_df->document_in_search == $suche && $row_df->field_value == pretty_chars(stripslashes($fld_val))) continue;

							// ���� ��������� ������������� php-���� � �����, ���������� ��� ����
							if (!check_permission('document_php'))
							{
								if (is_php_code($fld_val)) continue;
							}

							// ������� ������������ �������
							$fld_val = clean_no_print_char($fld_val);
							$fld_val = pretty_chars($fld_val);

							// ��������� ������ � �� �� ���������� ��������� � ������� ����� ����������
							$AVE_DB->Query("
								UPDATE " . PREFIX . "_document_fields
								SET
									field_value = '" . $fld_val . "' ,
									document_in_search  = '" . $suche . "'
								WHERE
									Id = '" . $fld_id . "'
							");
						}
					}

					// ������� ��� �������
					$AVE_DB->Query("
						DELETE
						FROM " . PREFIX . "_rubric_template_cache
						WHERE doc_id = '" . $document_id . "'
					");

					// ��������� ��������� ��������� � ������
					reportLog($_SESSION['user_name'] . ' - �������������� �������� (' . $document_id . ')', 2, 2);
				}

				header('Location:index.php?do=docs&action=after&document_id=' . $document_id . '&rubric_id=' . $row->rubric_id . '&cp=' . SESSION);
				exit;

			// ���� ������������ �� �������� ������� ��������, � ������ ������ �������� ��� ��������������
			case '':
				// ��������� ������ � �� �� ��������� ������ � ���������
				$document = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_documents
					WHERE Id = '" . $document_id . "'
				")->FetchRow();

				$show = true;

				// ��������� ����� ������� � ���������
				$this->documentPermissionFetch($document->rubric_id);

				// ��������� ������,
				// ���� ������ ��������� �� ��������� �������� ���� ��������� � �������
				// ��� ������������ �� ��������� �������� ��� ��������� � �������
				if (!( (isset($_SESSION['user_id']) && $document->document_author_id == $_SESSION['user_id']
					&& isset($_SESSION[$document->rubric_id . '_editown']) && $_SESSION[$document->rubric_id . '_editown'] == 1)
					|| (isset($_SESSION[$document->rubric_id . '_editall']) && $_SESSION[$document->rubric_id . '_editall'] == 1)))
				{
					$show = false;
				}
				// ��������� ������ � ������� �������� � �������� ������ 404, ���� ��������� ��������� ��������������
				if ( ($document_id == 1 || $document_id == PAGE_NOT_FOUND_ID) &&
					!(isset($_SESSION[$document->rubric_id . '_newnow']) && $_SESSION[$document->rubric_id . '_newnow'] == 1) )
				{
					$show = false;
				}
				// ��������� ������, ���� ������������ ����������� ������ ��������������� ��� ����� ��� ����� �� �������
				if ( (defined('UGROUP') && UGROUP == 1)
					|| (isset($_SESSION[$document->rubric_id . '_alles']) && $_SESSION[$document->rubric_id . '_alles'] == 1) )
				{
					$show = true;
				}

				if ($show)
				{
					$fields = array();

					if ( (defined('UGROUP') && UGROUP == 1)
						|| (isset($_SESSION[$document->rubric_id . '_newnow']) && $_SESSION[$document->rubric_id . '_newnow'] == 1) )
					{
						$document->dontChangeStatus = 0;
					}
					else
					{
						$document->dontChangeStatus = 1;
					}

					// ��������� ������ � �� � �������� ��� ������ ��� ����� ���������
					$sql = $AVE_DB->Query("
						SELECT
							doc.Id AS df_id,
							rub.*,
							rubric_field_default,
							field_value
						FROM " . PREFIX . "_rubric_fields AS rub
						LEFT JOIN " . PREFIX . "_document_fields AS doc ON rubric_field_id = rub.Id
						WHERE document_id = '" . $document_id . "'
						ORDER BY rubric_field_position ASC
					");
					while ($row = $sql->FetchRow())
					{
						$row->Feld = $this->_documentFieldGet($row->rubric_field_type, $row->field_value, $row->df_id, $row->rubric_field_default);
						array_push($fields, $row);
					}

					// ��������� ��� ���������� � �������� �� � ������ ��� ������
					$document->fields = $fields;
					$document->rubric_title = $AVE_Rubric->rubricNameByIdGet($document->rubric_id)->rubric_title;
					$document->rubric_url_prefix = $AVE_Rubric->rubricNameByIdGet($document->rubric_id)->rubric_alias;
					$document->formaction = 'index.php?do=docs&action=edit&sub=save&Id=' . $document_id . '&cp=' . SESSION;

					$AVE_Template->assign('document', $document);
//					$AVE_Template->assign('DEF_DOC_END_YEAR', mktime(date("H"), date("i"), 0, date("m"), date("d"), date("Y") + 10));

					// ���������� �������� ��� ��������������
					$AVE_Template->assign('content', $AVE_Template->fetch('documents/form.tpl'));
				}
				else // ���� ������������ �� ����� ���� �� ��������������, ��������� ��������� �� ������
				{
					$AVE_Template->assign('content', $AVE_Template->get_config_vars('DOC_NO_PERMISSION'));
				}
				break;
		}
	}

	/**
	 * �����, ��������������� ��� ������� ��������� � ��������
	 *
	 * @param int $document_id	������������� ���������
	 */
	function documentMarkDelete($document_id)
	{
		global $AVE_DB;

		// ��������� ������ � �� �� ��������� ���������� � ��������� (id, id �������, �����)
		$row = $AVE_DB->Query("
			SELECT
				Id,
				rubric_id,
				document_author_id
			FROM " . PREFIX . "_documents
			WHERE Id = '" . $document_id . "'
		")->FetchRow();

		// ���� � ������������ ���������� ���� �� ���������� ������ ��������
		if ( (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row->document_author_id)
			&& (isset($_SESSION[$row->rubric_id . '_editown']) && $_SESSION[$row->rubric_id . '_editown'] == 1)
			|| (isset($_SESSION[$row->rubric_id . '_alles']) && $_SESSION[$row->rubric_id . '_alles'] == 1)
			|| (defined('UGROUP') && UGROUP == 1) )
		{
			// � ��� �� ������� �������� � �� �������� � ������� 404
			if ($document_id != 1 && $document_id != PAGE_NOT_FOUND_ID)
			{
				// ��������� ������ � �� �� ���������� ������ (������� �� ��������)
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_documents
					SET document_deleted = '1'
					WHERE Id = '" . $document_id . "'
				");

				// ��������� ��������� ��������� � ������
				reportLog($_SESSION['user_name'] . ' - �������� ������ �������� (' . $document_id . ')', 2, 2);
			}
		}

		// ��������� ���������� ��������
		header('Location:index.php?do=docs&cp=' . SESSION);
	}

	/**
	 * �����, ��������������� ��� ������ ������� �� ��������
	 *
	 * @param int $document_id	������������� ���������
	 */
	function documentUnmarkDelete($document_id)
	{
		global $AVE_DB;

		// ��������� ������ � �� �� ���������� ���������� (������ ������� �� ��������)
		$AVE_DB->Query("
			UPDATE " . PREFIX . "_documents
			SET document_deleted = '0'
			WHERE Id = '" . $document_id . "'
		");

		// ��������� ��������� ��������� � ������
		reportLog($_SESSION['user_name'] . ' - ����������� ��������� �������� (' . $document_id . ')', 2, 2);

		// ��������� ���������� ��������
		header('Location:index.php?do=docs&cp=' . SESSION);
	}

	/**
	 * �����, ��������������� ��� ������� �������� ��������� ��� ����������� ��������������
	 *
	 * @param int $document_id	������������� ���������
	 */
	function documentDelete($document_id)
	{
		global $AVE_DB;

		// ���������, ����� ��������� �������� �� ������� ������� ��������� � �� ��������� � 404 �������
		if ($document_id != 1 && $document_id != PAGE_NOT_FOUND_ID)
		{
			// ��������� ������ � �� �� �������� ���������� � ���������
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_documents
				WHERE Id = '" . $document_id . "'
			");

			// ��������� ������ � �� �� �������� �����, ������� ���������� � ���������
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_document_fields
				WHERE document_id = '" . $document_id . "'
			");

			// ������� ��� �������
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_rubric_template_cache
				WHERE doc_id = '" . $document_id . "'
			");

			// ��������� ��������� ��������� � ������
			reportLog($_SESSION['user_name'] . ' - ������������ ������ �������� (' . $document_id . ')', 2, 2);
		}

		// ��������� ���������� ��������
		header('Location:index.php?do=docs&cp=' . SESSION);
	}

	/**
	 * �����, ��������������� ��� ���������� ��� ������ ���������� ���������
	 *
	 * @param int $document_id	������������� ���������
	 * @param string $openclose	������ ��������� {open|close}
	 */
	function documentStatusSet($document_id, $openclose = 0)
	{
		global $AVE_DB;

		// ��������� ������ � �� �� ��������� id ������ ���������, ����� ��������� ������� ���� �������
		$row = $AVE_DB->Query("
			SELECT
				rubric_id,
				document_author_id
			FROM " . PREFIX . "_documents
			WHERE Id = '" . $document_id . "'
		")->FetchRow();

		// ��������, ����� � ������������ ���� ���������� ���� �� ���������� ������ ��������
		if ( ($row->document_author_id == @$_SESSION['user_id'])
			&& (isset($_SESSION[$row->rubric_id . '_newnow']) && @$_SESSION[$row->rubric_id . '_newnow'] == 1)
			|| @$_SESSION[$row->rubric_id . '_alles'] == 1
			|| UGROUP == 1)
		{
			// ���� ��� �� ������� �������� � �� �������� � 404 �������
			if ($document_id != 1 && $document_id != PAGE_NOT_FOUND_ID)
			{
				// ��������� ������ � �� �� ����� ������� � ���������
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_documents
					SET document_status = '" . $openclose . "'
					WHERE Id = '" . $document_id . "'
				");

				// ��������� ��������� ��������� � ������
				reportLog($_SESSION['user_name'] . ' - ' . (($openclose==1) ? '�����������' : '�������������') . ' �������� (' . $document_id . ')', 2, 2);
			}
		}

		// ��������� ���������� ��������
		header('Location:index.php?do=docs&cp=' . SESSION);
		exit;
	}

	/**
	 * �����, ��������������� ��� �������� � Smarty ������������ ����� ������� ������� ������������
	 * � ������ ����������
	 *
	 */
	function documentTemplateTimeAssign()
	{
		global $AVE_Template;

		if (!empty($_REQUEST['TimeSelect']))
		{
			$AVE_Template->assign('sel_start', $this->_documentListStart());
			$AVE_Template->assign('sel_ende', $this->_documentListEnd());
		}
	}

	/**
	 * �����, ��������������� ��� �������� ��������� � ������ �������
	 *
	 */
	function documentRubricChange()
	{
		global $AVE_DB, $AVE_Template;

		$document_id = (int)$_REQUEST['Id'];        // ������������� ���������
		$rubric_id   = (int)$_REQUEST['rubric_id']; // ������������� ������� �������

		// ���� � ������� ������ ������������� ����� ������� � id ���������, �����
		// ��������� �������������� ������� ��������� �� ����� ������� � ������
		if ((!empty($_POST['NewRubr'])) and (!empty($_GET['Id'])))
		{
			$new_rubric_id = (int)$_POST['NewRubr']; // ������������� ������� �������

			// ���������� ������������ ������, ��������� � ������� ������ POST
			foreach ($_POST as $key => $value)
			{
				if (is_integer($key))
				{
					// ���������� ���� ����
					switch ($value)
					{
						// ���� 0, �����
						case 0:
							// ��������� ������ � �� �� �������� ������� ���� (������ ��� �� ������� ��������)
							$AVE_DB->Query("
								DELETE
								FROM " . PREFIX . "_document_fields
								WHERE document_id = '" . $document_id . "'
								AND rubric_field_id = '" . $key . "'
							");
							break;

						// ���� -1, �����
						case -1:
							// ��������� ������ �� ��������� ������ ��� ����� (�������) ����
							$row_fd = $AVE_DB->Query("
								SELECT
									rubric_field_title,
									rubric_field_type
								FROM " . PREFIX . "_rubric_fields
								WHERE Id = '" . $key . "'
							")->FetchRow();

							// ��������� ������ � �� � �������� ��������� ������� ����� � ������� ���� ���������
							$new_pos = $AVE_DB->Query("
								SELECT rubric_field_position
								FROM " . PREFIX . "_rubric_fields
								WHERE rubric_id = '" . $new_rubric_id . "'
								ORDER BY rubric_field_position DESC
								LIMIT 1
							")->GetCell();
							++$new_pos;

							// ��������� ������ � �� � ��������� ����� ���� � ����� �������
							$AVE_DB->Query("
								INSERT
								INTO " . PREFIX . "_rubric_fields
								SET
									rubric_id             = '" . $new_rubric_id . "',
									rubric_field_title    = '" . addslashes($row_fd->rubric_field_title) . "',
									rubric_field_type     = '" . addslashes($row_fd->rubric_field_type) . "',
									rubric_field_position = '" . $new_pos . "'
							");

							$lastid = $AVE_DB->InsertId();

							// ��������� ������ � �� � ��������� ������ � ���� � ������� � ������ ����������
							$sql_docs = $AVE_DB->Query("
								SELECT Id
								FROM " . PREFIX . "_documents
								WHERE rubric_id = '" . $new_rubric_id . "'
							");

							while ($row_docs = $sql_docs->FetchRow())
							{
								$AVE_DB->Query("
									INSERT
									INTO " . PREFIX . "_document_fields
									SET
										rubric_field_id    = '" . $lastid . "',
										document_id        = '" . $row_docs->Id . "',
										field_value        = '',
										document_in_search = '1'
								");
							}

							// ��������� ������ � �� � ������� ����� ���� ��� ����������� ���������
							$AVE_DB->Query("
								UPDATE " . PREFIX . "_document_fields
								SET rubric_field_id   = '" . $lastid . "'
								WHERE rubric_field_id = '" . $key . "'
								AND document_id       = '" . $document_id . "'
							");
							break;

						// �� ���������
						default:
							// ��������� ������ � �� � ������ ��������� ��������� ������
							$AVE_DB->Query("
								UPDATE " . PREFIX . "_document_fields
								SET rubric_field_id   = '" . $value . "'
								WHERE rubric_field_id = '" . $key . "'
								AND document_id       = '" . $document_id . "'
							");
							break;
					}
				}
			}

			// ��������� ������ � �� � �������� ������ ���� ����� � ����� �������
			$sql_rub = $AVE_DB->Query("
				SELECT Id
				FROM " . PREFIX . "_rubric_fields
				WHERE rubric_id = '" . $new_rubric_id . "'
				ORDER BY Id ASC
			");

			// ��������� ������� � �� �� �������� ������� ������ �����.
			while ($row_rub = $sql_rub->FetchRow())
			{
				$num = $AVE_DB->Query("
					SELECT 1
					FROM " . PREFIX . "_document_fields
					WHERE rubric_field_id = '" . $row_rub->Id . "'
					AND document_id = '" . $document_id . "'
					LIMIT 1
				")->NumRows();

				// ���� � ����� ������� ���������� ���� ���, ��������� ������ � �� �� ���������� ������ ���� ����
				if ($num != 1)
				{
					$AVE_DB->Query("
						INSERT " . PREFIX . "_document_fields
						SET
							rubric_field_id    = '" . $row_rub->Id . "',
							document_id        = '" . $document_id . "',
							field_value        = '',
							document_in_search = '1'
					");
				}
			}

			// ��������� ������ � �� �� ���������� ����������, � ������� ������������� ��� ������������� ���������
			// ����� �������� id �������
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_documents
				SET rubric_id = '" . $new_rubric_id . "'
				WHERE Id = '" . $document_id . "'
			");

			// ��������� ������ � �� � ������� ��� ������� ���������
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_rubric_template_cache
				WHERE doc_id = '" . $document_id . "'
			");

			echo '<script>window.opener.location.reload(); window.close();</script>';
		}
		else  // ���� � ������� �� ��� ������ id ������� � id ���������
		{
			// ��������� � ���������� �����, ��� ������������ �������������� ���������� �������
			$fields = array();

			if ((!empty($_GET['NewRubr'])) and ($rubric_id != (int)$_GET['NewRubr']))
			{
				// ��������� ������ � ��  � �������� ��� ���� ����� �������
				$sql_rub = $AVE_DB->Query("
					SELECT
						Id,
						rubric_field_title,
						rubric_field_type
					FROM " . PREFIX . "_rubric_fields
					WHERE rubric_id = '" . (int)$_GET['NewRubr'] . "'
					ORDER BY Id ASC
				");
				$mass_new_rubr = array();
				while ($row_rub = $sql_rub->FetchRow())
				{
					$mass_new_rubr[] = array('Id'                => $row_rub->Id,
											 'title'             => $row_rub->rubric_field_title,
											 'rubric_field_type' => $row_rub->rubric_field_type
					);
				}

				// ��������� ������ � �� � �������� ��� ���� ������ �������
				$sql_old_rub = $AVE_DB->Query("
					SELECT
						Id,
						rubric_field_title,
						rubric_field_type
					FROM " . PREFIX . "_rubric_fields
					WHERE rubric_id = '" . $rubric_id . "'
					ORDER BY Id ASC
				");

				// ���������� ������������ ���������� ������
				while ($row_nr = $sql_old_rub->FetchRow()) {
					$type = $row_nr->rubric_field_type;
					$option_arr = array('0'  => $AVE_Template->get_config_vars('DOC_CHANGE_DROP_FIELD'),
										'-1' => $AVE_Template->get_config_vars('DOC_CHANGE_CREATE_FIELD')
					);
					$selected = -1;
					foreach ($mass_new_rubr as $row)
					{
						if ($row['rubric_field_type'] == $type)
						{
							$option_arr[$row['Id']] = $row['title'];
							if ($row_nr->rubric_field_title == $row['title']) $selected = $row['Id'];
						}
					}
					$fields[$row_nr->Id] = array('title'    => $row_nr->rubric_field_title,
												 'Options'  => $option_arr,
												 'Selected' => $selected
					);
				}
			}

			// ��������� ��� ��������� � ���������� �������� � ������� �������
			$AVE_Template->assign('fields', $fields);
			$AVE_Template->assign('formaction', 'index.php?do=docs&action=change&Id=' . $document_id . '&rubric_id=' . $rubric_id . '&pop=1&cp=' . SESSION);
			$AVE_Template->assign('content', $AVE_Template->fetch('documents/change.tpl'));
		}
	}

	/**
	 * �����, ��������������� ��� ������������ URL
	 *
	 */
	function documentAliasCreate()
	{
		$alias  = empty($_REQUEST['alias'])  ? '' : prepare_url(iconv("UTF-8", "WINDOWS-1251", $_REQUEST['alias']));
		$title  = empty($_REQUEST['title'])  ? '' : prepare_url(iconv("UTF-8", "WINDOWS-1251", $_REQUEST['title']));
		$prefix = empty($_REQUEST['prefix']) ? '' : prepare_url(iconv("UTF-8", "WINDOWS-1251", $_REQUEST['prefix']));

		if ($alias != $title && $alias != trim($prefix . '/' . $title, '/')) $alias = trim($alias . '/' . $title, '/');

		return $alias;
	}

	/**
	 * �����, ��������������� ��� �������� ������������ URL
	 *
	 */
	function documentAliasCheck()
	{
		global $AVE_DB, $AVE_Template;

		$document_id = (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) ? $_REQUEST['id'] : 0;
		$document_alias = (isset($_REQUEST['alias'])) ? iconv("UTF-8", "WINDOWS-1251", $_REQUEST['alias']) : '';

		$errors = array();

		// ���� ��������� URL ������������� �� ������
		if (!empty($document_alias))
		{

			// ���������, ����� ������ URL �������������� �����������
			if (preg_match(TRANSLIT_URL ? '/[^a-z0-9\/-]+/' : '/[^a-z�-�����0-9\/-]+/', $document_alias))
			{
				$errors[] = $AVE_Template->get_config_vars('DOC_URL_ERROR_SYMBOL');
			}

			// ���� URL ���������� � "/" - ��������� ������
			if ($document_alias[0] == '/') $errors[] = $AVE_Template->get_config_vars('DOC_URL_ERROR_START');

			// ���� URL ������������� �� "/" - ��������� ������
			if (substr($document_alias, -1) == '/') $errors[] = $AVE_Template->get_config_vars('DOC_URL_ERROR_END');

			// ���� � URL ������������ ����� apage-XX, artpage-XX,page-XX,print, ��������� ������, ��� �� - �����
			$matches = preg_grep('/^(apage-\d+|artpage-\d+|page-\d+|print)$/i', explode('/', $document_alias));
			if (!empty($matches)) $errors[] = $AVE_Template->get_config_vars('DOC_URL_ERROR_SEGMENT') . implode(', ', $matches);

			// ��������� ������ � �� �� ��������� ���� URL � �������� �� ������������
			if (empty($errors))
			{
				$alias_exist = $AVE_DB->Query("
					SELECT 1
					FROM " . PREFIX . "_documents
					WHERE document_alias = '" . $document_alias . "'
					AND Id != '" . $document_id . "'
					LIMIT 1
				")->NumRows();

				if ($alias_exist) $errors[] = $AVE_Template->get_config_vars('DOC_URL_ERROR_DUPLICATES');
			}
		}
		else
		{  // � ��������� ������, ���� URL ������, ��������� ��������� �� ������
			$errors[] = $AVE_Template->get_config_vars('DOC_URL_ERROR_EMTY');
		}

		// ���� ������ �� �������, ��������� ��������� �� �������� ��������
		if (empty($errors))
		{
			return '<font class="checkUrlOk">' . $AVE_Template->get_config_vars('DOC_URL_CHECK_OK') . '</font>';
		}
		else
		{ // � ��������� ������ ��������� ��������� � �������
			return '<font class="checkUrlErr">' . implode(', ', $errors) . '</font>';
		}
	}

	/**
	 * �����, ��������������� ��� ������������ ���� ������� ������ ������������� �� ��������� ����������� �������
	 *
	 * @param int $rubric_id	������������� �������
	 */
	function documentPermissionFetch($rubric_id)
	{
		global $AVE_DB;

		// ������ ���� �������������
		static $rubric_permissions = array();

		// ���� � ��� ��� ������� ���������� ����� ��� ������ �������, ������ ��������� ��������
		if (isset($rubric_permissions[$rubric_id])) return;

		// ��������� ������ � �� �� ��������� ���� ��� ������ �������
		$sql = $AVE_DB->Query("
			SELECT
				rubric_id,
				rubric_permission
			FROM " . PREFIX . "_rubric_permissions
			WHERE user_group_id = '" . UGROUP . "'
		");

		// ���������� ������������ ���������� ������ � ��������� ������ ����
		while ($row = $sql->FetchRow())
		{
			$rubric_permissions[$row->rubric_id] = 1;

			$permissions = explode('|', $row->rubric_permission);

			foreach ($permissions as $rubric_permission)
			{
				if (!empty($rubric_permission))
				{
					$_SESSION[$row->rubric_id . '_' . $rubric_permission] = 1;
				}
			}
		}
	}

	/**
	 * �����, ��������������� ��� ��������� � ���������� ������� � ���������
	 *
	 * @param int $reply	������� ������ �� �������
	 */
	function documentRemarkNew($document_id = 0, $reply = 0)
	{
		global $AVE_DB, $AVE_Template;

		// ���� id ��������� �� ����� ��� 0, ��������� ����������
		if (!(is_numeric($document_id) && $document_id > 0)) exit;

		// ���� � ������� ������ �������� �� ����������
		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			// ���� ������������ ������� ����������� � � ���� ������� ����� � ��� �� �����, � ����� �������, �����
			if (!empty($_REQUEST['remark_text']) && check_permission('remarks') && empty($_REQUEST['reply']))
			{
				// ��������� ������ � �� �� ���������� ����� ������� ��� ���������
				$AVE_DB->Query("
					INSERT " . PREFIX . "_document_remarks
					SET
						document_id         = '" . $document_id . "',
						remark_title        = '" . clean_no_print_char($_REQUEST['remark_title']) . "',
						remark_text         = '" . substr(clean_no_print_char($_REQUEST['remark_text']), 0, $this->_max_remark_length) . "',
						remark_author_id    = '" . $_SESSION['user_id'] . "',
						remark_published    = '" . time() . "',
						remark_first        = '1',
						remark_author_email = '" . $_SESSION['user_email'] . "'
				");
			}

			// ��������� ���������� ��������
			header('Location:index.php?do=docs&action=remark_reply&Id=' . $document_id . '&pop=1&cp=' . SESSION);
		}

		// ���� ��� ����� �� ��� ������������ �������
		if ($reply == 1)
		{
			if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
			{
				// ���� ������������ ������� ����� � ����� �� ��� �����
				if (!empty($_REQUEST['remark_text']) && check_permission('remarks'))
				{
					// ��������� ������ �� ��������� e-mail ������ ������ �������
					$remark_author_email = $AVE_DB->Query("
						SELECT remark_author_email
						FROM  " . PREFIX . "_document_remarks
						WHERE remark_first = '1'
						AND document_id = '" . $document_id . "'
					")->GetCell();

					// ��������� ������ � �� �� ���������� ������� � ��
					$AVE_DB->Query("
						INSERT " . PREFIX . "_document_remarks
						SET
							document_id         = '" . $document_id . "',
							remark_title        = '" . clean_no_print_char($_REQUEST['remark_title']) . "',
							remark_text         = '" . substr(clean_no_print_char($_REQUEST['remark_text']), 0, $this->_max_remark_length) . "',
							remark_author_id    = '" . $_SESSION['user_id'] . "',
							remark_published    = '" . time() . "',
							remark_first        = '0',
							remark_author_email = '" . $_SESSION['user_email'] . "'
					");
				}

				// ��������� ��������� � ���������� ������ ������, � ����������� � ���, ��� �� ��� ������� ���� �����
				$system_mail = get_settings('mail_from');
				$system_mail_name = get_settings('mail_from_name');
				$link = get_home_link() . 'index.php?do=docs&doc_id=' . $document_id;

				$body_to_admin = $AVE_Template->get_config_vars('DOC_MAIL_BODY_NOTICE');
				$body_to_admin = str_replace('%N%', "\n", $body_to_admin);
				$body_to_admin = str_replace('%TITLE%', stripslashes($_POST['remark_title']), $body_to_admin);
				$body_to_admin = str_replace('%USER%', get_username_by_id($_SESSION['user_id']), $body_to_admin);
				$body_to_admin = str_replace('%LINK%', $link, $body_to_admin);
				send_mail(
					$remark_author_email,
					$body_to_admin,
					$AVE_Template->get_config_vars('DOC_MAIL_SUBJECT_NOTICE'),
					$system_mail,
					$system_mail_name,
					'text'
				);

				// ��������� ���������� ��������
				header('Location:index.php?do=docs&action=remark_reply&Id=' . $document_id . '&pop=1&cp=' . SESSION);
			}

			// �������� ����� ���������� ������� ��� ���������
			$num = $AVE_DB->Query("
				SELECT COUNT(*)
				FROM " . PREFIX . "_document_remarks
				WHERE document_id = '" . $document_id . "'
			")->GetCell();

			// ����������� ����� ������� �� 1 �������� � ������������ ���������� �������
			$limit = 10;
			$seiten = ceil($num / $limit);
			$start = get_current_page() * $limit - $limit;

			$answers = array();

			// ��������� ������ � �� �� ��������� ������� � ������ ���������� �� 1 �������
			$sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_document_remarks
				WHERE document_id = '" . $document_id . "'
				ORDER BY Id DESC
				LIMIT " . $start . "," . $limit
			);
			while ($row = $sql->FetchAssocArray())
			{
				$row['remark_author'] = get_username_by_id($row['remark_author_id']);
				$row['remark_text'] = nl2br($row['remark_text']);
				array_push($answers, $row);
			}

			$remark_status = $AVE_DB->Query("
				SELECT remark_status
				FROM " . PREFIX . "_document_remarks
				WHERE document_id = '" . $document_id . "'
				AND remark_first = '1'
			")->GetCell();

			// ���� ���������� ������� ��������� ���������� ��������, ������������ � ���������� $limit, �����
			// ��������� ������������ ���������
			if ($num > $limit)
			{
				$page_nav = " <a class=\"pnav\" href=\"index.php?do=docs&action=remark_reply&Id=" . $document_id . "&page={s}&pop=1&cp=" . SESSION . "\">{t}</a> ";
				$page_nav = get_pagination($seiten, 'page', $page_nav);
				$AVE_Template->assign('page_nav', $page_nav);
			}

			// �������� ������  � ������ � ���������� �������� �� ������� �������
			$AVE_Template->assign('remark_status', $remark_status);
			$AVE_Template->assign('answers', $answers);
			$AVE_Template->assign('reply', 1);
			$AVE_Template->assign('formaction', 'index.php?do=docs&action=remark_reply&sub=save&Id=' . $document_id . '&reply=1&cp=' . SESSION);
			$AVE_Template->assign('content', $AVE_Template->fetch('documents/newremark.tpl'));
		}
		else
		{ // � ��������� ������, ���� ������� ��� ���, ��������� ����� ��� ���������� �������
			$AVE_Template->assign('reply', 1);
			$AVE_Template->assign('new', 1);
			$AVE_Template->assign('formaction', 'index.php?do=docs&action=remark&sub=save&Id=' . $document_id . '&cp=' . SESSION);
			$AVE_Template->assign('content', $AVE_Template->fetch('documents/newremark.tpl'));
		}
	}

	/**
	 * �����, ��������������� ��� ���������� ��������� �������� (��������� ��� ��������� ���������
	 * ������ �� ������� ��� ������ �������������)
	 *
	 * @param int $document_id	������������� ���������
	 * @param int $status		������ ��������
	 */
	function documentRemarkStatus($document_id = 0, $status = 0)
	{
		global $AVE_DB;

		// ���� id ��������� ����� � ��� ������ 0, �����
		if (is_numeric($document_id) && $document_id > 0)
		{
			// ��������� ������ � �� �� ���������� ������� � �������
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_document_remarks
				SET remark_status  = '" . ($status != 1 ? 0 : 1) . "'
				WHERE remark_first = '1'
				AND document_id    = '" . $document_id . "'
			");
		}

		// ��������� ���������� ������
		header('Location:index.php?do=docs&action=remark_reply&Id=' . $document_id . '&pop=1&cp=' . SESSION);
		exit;
	}

	/**
	 * �����, ��������������� ��� �������� �������
	 *
	 * @param int $all	������� �������� ���� ������� (1 - ������� ���)
	 */
	function documentRemarkDelete($document_id = 0, $all = 0)
	{
		global $AVE_DB;

		// ���� id ��������� �� ����� ��� 0, ��������� ����������
		if (!(is_numeric($document_id) && $document_id > 0)) exit;

		// ���� � ������� ������ �������� �� �������� ���� �������
		if ($all == 1)
		{
			// ��������� ������ � �� � ������� �������
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_document_remarks
				WHERE document_id = '" . $document_id . "'
			");

			// ��������� ���������� ��������
			header('Location:index.php?do=docs&action=remark&Id=' . $document_id . '&pop=1&cp=' . SESSION);
			exit;
		}
		else
		{
			if (!(isset($_REQUEST['CId']) && is_numeric($_REQUEST['CId']) && $_REQUEST['CId'] > 0)) exit;

			// � ��������� ������, ��������� ������ � �� � ������� ������ �� �������, ������� ���� �������
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_document_remarks
				WHERE document_id = '" . $document_id . "'
				AND Id = '" . $_REQUEST['CId'] . "'
			");

			// ��������� ���������� ��������
			header('Location:index.php?do=docs&action=remark_reply&Id=' . $document_id . '&pop=1&cp=' . SESSION);
			exit;
		}
	}

	/**
	 * �������� � ��������� ����� ����������� �� ��������
	 *
	 */
	function documentInNavi()
	{
		global $AVE_DB;

		$document_id = isset($_REQUEST['document_id']) ? (int)$_REQUEST['document_id'] : 0;
		$rubric_id = isset($_REQUEST['rubric_id']) ? (int)$_REQUEST['rubric_id'] : 0;
		$title  = isset($_REQUEST['navi_title']) ? clean_no_print_char($_REQUEST['navi_title']) : '';

		if ($document_id > 0 && $rubric_id > 0 && $title != '' && check_permission_acp('navigation_new'))
		{
			$document_alias = $AVE_DB->Query("
				SELECT document_alias
				FROM " . PREFIX . "_documents
				WHERE Id = '" . $document_id . "'
				AND rubric_id = '" . $rubric_id . "'
				LIMIT 1
			")->GetCell();
		}

		if (isset($document_alias) && $document_alias !== false)
		{
			// �������� id ������ ���� �� �������
			$parent_id = isset($_REQUEST['parent_id']) ? (int)$_REQUEST['parent_id'] : 0;

			// ���� ����� �� ������������, � �����-���� ��������
			if ($parent_id > 0)
			{
				// ��������� ������ � �� �� ��������� id ���� ��������� � ������
				list($navi_id, $status, $level) = $AVE_DB->Query("
					SELECT
						navi_id,
						navi_item_status,
						navi_item_level+1
					FROM " . PREFIX . "_navigation_items
					WHERE Id = '" . $parent_id . "'
					LIMIT 1
				")->FetchArray();
			}
			else
			{
				$navi_id = (isset($_REQUEST['navi_id']) && (int)$_REQUEST['navi_id'] > 0) ? (int)$_REQUEST['navi_id'] : 1;
				$status  = 1;
				$level   = 1;
			}

			$target = (isset($_REQUEST['navi_item_target']) && $_REQUEST['navi_item_target'] == '_blank') ? '_blank' : '_self';

			$position = empty($_REQUEST['navi_item_position']) ? 1 : (int)$_REQUEST['navi_item_position'];

			// ��������� ���������� � ����� ������ ��������<->����� ����
			$AVE_DB->Query("
				INSERT
				INTO " . PREFIX . "_navigation_items
				SET
					title              = '" . $title . "',
					document_alias     = '" . $document_alias . "',
					parent_id          = '" . $parent_id . "',
					navi_id            = '" . $navi_id . "',
					navi_item_level    = '" . $level . "',
					navi_item_target   = '" . $target . "',
					navi_item_position = '" . $position . "',
					navi_item_status   = '" . $status . "',
					navi_item_link     = 'index.php?id=" . $document_id . "'
			");
		}

		header('Location:index.php?do=docs&action=after&document_id=' . $document_id . '&rubric_id=' . $rubric_id . '&cp=' . SESSION);
		exit;
	}

	/**
	 * ����� ����� �������������� �������� � ����� ��� ����������������� ����������
	 *
	 */
	function documentFormAfter()
	{
		global $AVE_DB, $AVE_Template;

		$document_id = isset($_REQUEST['document_id']) ? (int)$_REQUEST['document_id'] : 0;
		$rubric_id = isset($_REQUEST['rubric_id']) ? (int)$_REQUEST['rubric_id'] : 0;
		$innavi = (isset($_REQUEST['innavi']) && check_permission_acp('navigation_new')) ? 1 : 0;

		if ($document_id > 0 && $rubric_id > 0)
		{
			$document = $AVE_DB->Query("
				SELECT
					Id AS document_id,
					rubric_id,
					document_title AS document_title,
					'" . $innavi . "' AS innavi
				FROM " . PREFIX . "_documents
				WHERE Id = '" . $document_id . "'
				AND rubric_id = '" . $rubric_id . "'
				LIMIT 1
			")->FetchAssocArray();
		}

		if (empty($document))
		{
			header('Location:index.php?do=docs&cp=' . SESSION);
			exit;
		}

		$AVE_Template->assign($document);
		$AVE_Template->assign('content', $AVE_Template->fetch('documents/form_after.tpl'));
	}
}

?>