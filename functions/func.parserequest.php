<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * Обработка условий запроса.
 * Возвращает строку условий в SQL-формате
 *
 * @param int $id	идентификатор запроса
 * @return string
 */
function request_get_condition_sql_string($id)
{
	global $AVE_DB, $AVE_Core;

	$where = '';
	$from = PREFIX . '_document_fields AS t0';
	$eq_string = '';
	$ueb = '';
	$start = 0;
	$doc_request = 'doc' . $AVE_Core->curentdoc->Id . '_request' . $id;

	if (!empty($_REQUEST['fld']))
	{
		$_SESSION[$doc_request]['fld'] = $_REQUEST['fld'];
	}
	else
	{
		if (!empty($_SESSION[$doc_request]['fld']))
		{
			$_REQUEST['fld'] = $_SESSION[$doc_request]['fld'];
		}
		else
		{
			$_REQUEST['fld'] = array();
		}
	}

	$sql_ak = $AVE_DB->Query("
		SELECT *
		FROM " . PREFIX . "_request_conditions
		WHERE request_id = '" . $id . "'
	");

	while ($row_ak = $sql_ak->FetchRow())
	{
		$feld = $row_ak->condition_field_id;

		if (!empty($_REQUEST['fld'][$feld]))
		{
			$wert = $_REQUEST['fld'][$feld];
			unset($_REQUEST['fld'][$feld]);
		}
		else
		{
			$wert = $row_ak->condition_value;
		}

		if ($row_ak->condition_join != 'OR')
		{
			$where = ' WHERE 1';
			$start_bracket = ' AND ';
			$lastb_bracket = '';
			$alias = 't' . $start;
			$from .= ($start != 0) ? ' JOIN ' . PREFIX . '_document_fields AS ' . $alias . ' ON ' . $alias . '.document_id = t0.document_id' : '';
		}
		else
		{
			$where = ' WHERE 0';
			$start_bracket = ' OR(';
			$lastb_bracket = ')';
			$alias = 't0';
		}

		switch ($row_ak->condition_compare)
		{
			case '%%':
				$eq_string .= $start_bracket . $alias . ".rubric_field_id = '" . $feld . "' AND " . $alias . ".field_value LIKE '%" . $wert . "%' " . $lastb_bracket;
				break;

			case '%':
				$eq_string .= $start_bracket . $alias . ".rubric_field_id = '" . $feld . "' AND " . $alias . ".field_value LIKE '" . $wert . "%' " . $lastb_bracket;
				break;

			case '<':
				$eq_string .= $start_bracket . $alias . ".rubric_field_id = '" . $feld . "' AND " . $alias . ".field_value < '" . $wert . "' " . $lastb_bracket;
				break;

			case '<=':
				$eq_string .= $start_bracket . $alias . ".rubric_field_id = '" . $feld . "' AND " . $alias . ".field_value <= '" . $wert . "' " . $lastb_bracket;
				break;

			case '>':
				$eq_string .= $start_bracket . $alias . ".rubric_field_id = '" . $feld . "' AND " . $alias . ".field_value > '" . $wert . "' " . $lastb_bracket;
				break;

			case '>=':
				$eq_string .= $start_bracket . $alias . ".rubric_field_id = '" . $feld . "' AND " . $alias . ".field_value >= '" . $wert . "' " . $lastb_bracket;
				break;

			case '==':
				$eq_string .= $start_bracket . $alias . ".rubric_field_id = '" . $feld . "' AND " . $alias . ".field_value = '" . $wert . "' " . $lastb_bracket;
				break;

			case '!=':
				$eq_string .= $start_bracket . $alias . ".rubric_field_id = '" . $feld . "' AND " . $alias . ".field_value != '" . $wert . "' " . $lastb_bracket;
				break;

			case '--':
				$eq_string .= $start_bracket . $alias . ".rubric_field_id = '" . $feld . "' AND " . $alias . ".field_value NOT LIKE '%" . $wert . "%' " . $lastb_bracket;
				break;
		}
		++$start;
	}

	if (!empty($_REQUEST['fld']) && is_array($_REQUEST['fld']))
	{
		arsort($_REQUEST['fld']);
		foreach ($_REQUEST['fld'] as $feld => $wert)
		{
			$where = ' WHERE 1';
			$alias = 't' . $start;
			$from .= ($start != 0) ? ' JOIN ' . PREFIX . '_document_fields AS ' . $alias . ' ON ' . $alias . '.document_id = t0.document_id' : '';
			$eq_string .= ' AND ' . $alias . ".rubric_field_id = '" . $feld . "' AND " . $alias . ".field_value = '" . $wert . "'";
			++$start;
		}
	}

	if ($where != '')
	{
		$ueb = 'AND a.Id = ANY(SELECT t0.document_id FROM ' . $from . $where . $eq_string . ')';
	}

	if (empty($_SESSION[$doc_request]['fld']))
	{
		$AVE_DB->Query("
			UPDATE " . PREFIX . "_request
			SET	request_where_cond = '" . addslashes($ueb) . "'
			WHERE Id = '" . $id . "'
		");
	}

	return $ueb;
}

/**
 * Функция обработки тэгов полей с использованием шаблонов
 * в соответствии с типом поля
 *
 * @param int $rubric_id	идентификатор рубрики
 * @param int $document_id	идентификатор документа
 * @param int $maxlength	максимальное количество символов обрабатываемого поля
 * @return string
 */
function request_get_document_field($rubric_id, $document_id, $maxlength = '')
{
	if (!is_numeric($rubric_id) || $rubric_id < 1 || !is_numeric($document_id) || $document_id < 1) return '';

	$document_fields = get_document_fields($document_id);

	if (empty($document_fields[$rubric_id])) return '';

	$field_value = trim($document_fields[$rubric_id]['field_value']);
	if ($field_value == '' && $document_fields[$rubric_id]['tpl_req_empty']) return '';

//	if ($maxlength != 'more')
//	{
//		$field_value = strip_tags($field_value, '<br /><strong><em><p><i>');
//	}

	switch ($document_fields[$rubric_id]['rubric_field_type'])
	{
		case 'bild' :
			$field_value = clean_php($field_value);
			$field_param = explode('|', $field_value);
			$field_param[1] = isset($field_param[1]) ? $field_param[1] : '';
			if ($document_fields[$rubric_id]['tpl_req_empty'])
			{
				$field_value = '<img src="' . $field_param[0] . '" alt="' . $field_param[1] . '" border="0" />';
			}
			else
			{
				$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $document_fields[$rubric_id]['rubric_field_template_request']);
			}
			$maxlength = '';
			break;

		case 'link' :
			$field_value = clean_php($field_value);
			$field_param = explode('|', $field_value);
			if (empty($field_param[1])) $field_param[1] = $field_param[0];
			if ($document_fields[$rubric_id]['tpl_req_empty'])
			{
				$field_value = " <a target=\"_self\" href=\"" . $field_param[0] . "\">" . $field_param[1] . "</a>";
			}
			else
			{
				$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $document_fields[$rubric_id]['rubric_field_template_request']);
			}
			$maxlength = '';
			break;

		default:
			$field_value = clean_php($field_value);
			$field_param = explode('|', $field_value);
			$field_value = $field_param[0];
			break;
	}

	if ($maxlength != '')
	{
		if ($maxlength == 'more')
		{
				$teaser = explode('<a name="more"></a>', $field_value);
				$field_value = $teaser[0];
		}
		else
		{
			if ($maxlength < 0)
			{
				$field_value = str_replace(array("\r\n","\n","\r"), " ", $field_value);
				$field_value = strip_tags($field_value);
				$field_value = preg_replace('/  +/', ' ', $field_value);
				$field_value = trim($field_value);
				$maxlength = abs($maxlength);
			}
			$field_value = substr($field_value, 0, $maxlength) . ((strlen($field_value) > $maxlength) ? '... ' : '');
		}
	}

	if (!$document_fields[$rubric_id]['tpl_req_empty'])
	{
		$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $document_fields[$rubric_id]['rubric_field_template_request']);
	}

	return $field_value;
}

/**
 * Обработка тэга запроса.
 * Возвращает список документов удовлетворяющих параметрам запроса
 * оформленный с использованием шаблона
 *
 * @param int $id	идентификатор запроса
 * @return string
 */
function request_parse($id)
{
	global $AVE_Core, $AVE_DB;

	$return = '';

	if (is_array($id)) $id = $id[1];

	$row_ab = $AVE_DB->Query("
		SELECT *
		FROM " . PREFIX . "_request
		WHERE Id = '" . $id . "'
	")->FetchRow();

	if (is_object($row_ab))
	{
//		$eq = '';
//		$wo = '';
//		$suchart = '';
//		$first = '';
//		$second = '';

		$limit = ($row_ab->request_items_per_page < 1) ? 1 : $row_ab->request_items_per_page;
		$main_template = $row_ab->request_template_main;
		$item_template = $row_ab->request_template_item;
		$request_order_by = $row_ab->request_order_by;
		$request_asc_desc = $row_ab->request_asc_desc;

		$doctime = get_settings('use_doctime') ? ("AND (a.document_expire = 0 OR a.document_expire >= '" . time() . "') AND a.document_published <= '" . time() . "'") : '';

		$lbl = 'doc' . $AVE_Core->curentdoc->Id . '_request' . $id;
		$where_cond = (empty($_REQUEST['fld']) && empty($_SESSION[$lbl]['fld']))
			? $row_ab->request_where_cond
			: request_get_condition_sql_string($row_ab->Id);

		if ($row_ab->request_show_pagination == 1)
		{
			if (!empty($AVE_Core->install_modules['comment']->Status))
			{
				$num = $AVE_DB->Query("
					SELECT COUNT(*)
					FROM " . PREFIX . "_documents AS a
					WHERE
						a.Id != '1'
					AND a.Id != '" . PAGE_NOT_FOUND_ID . "'
					AND a.Id != '" . $AVE_Core->curentdoc->Id . "'
					AND a.rubric_id = '" . $row_ab->rubric_id . "'
					AND a.document_deleted != '1'
					AND a.document_status != '0'
					" . $where_cond . "
					" . $doctime . "
				")->GetCell();
			}
			else
			{
				$num = $AVE_DB->Query("
					SELECT COUNT(*)
					FROM " . PREFIX . "_documents AS a
					WHERE
						a.Id != '1'
					AND a.Id != '" . PAGE_NOT_FOUND_ID . "'
					AND a.Id != '" . $AVE_Core->curentdoc->Id . "'
					AND a.rubric_id = '" . $row_ab->rubric_id . "'
					AND a.document_deleted != '1'
					AND a.document_status != '0'
					" . $where_cond . "
					" . $doctime . "
				")->GetCell();
			}

			$seiten = ceil($num / $limit);
			$start  = get_current_page('apage') * $limit - $limit;
		}
		else
		{
			$start  = 0;
		}

		if (!empty($AVE_Core->install_modules['comment']->Status))
		{
			$q = $AVE_DB->Query("
				SELECT
					a.Id,
					a.document_title,
					a.document_alias,
					a.document_count_view,
					a.document_published,
					COUNT(b.document_id) AS nums
				FROM
					" . PREFIX . "_documents AS a
				LEFT JOIN
					" . PREFIX . "_modul_comment_info AS b
						ON b.document_id = a.Id
				WHERE
					a.Id != '1'
				AND a.Id != '" . PAGE_NOT_FOUND_ID . "'
				AND a.Id != '" . $AVE_Core->curentdoc->Id . "'
				AND a.rubric_id = '" . $row_ab->rubric_id . "'
				AND a.document_deleted != '1'
				AND a.document_status != '0'
				" . $where_cond . "
				" . $doctime . "
				GROUP BY a.Id
				ORDER BY a." . $request_order_by . " " . $request_asc_desc . "
				LIMIT " . $start . "," . $limit
			);
		}
		else
		{
			$q = $AVE_DB->Query("
				SELECT
					a.Id,
					a.document_title,
					a.document_alias,
					a.document_count_view,
					a.document_published
				FROM
					" . PREFIX . "_documents AS a
				WHERE
					a.Id != '1'
				AND a.Id != '" . PAGE_NOT_FOUND_ID . "'
				AND a.Id != '" . $AVE_Core->curentdoc->Id . "'
				AND a.rubric_id = '" . $row_ab->rubric_id . "'
				AND a.document_deleted != '1'
				AND a.document_status != '0'
				" . $where_cond . "
				" . $doctime . "
				ORDER BY a." . $request_order_by . " " . $request_asc_desc . "
				LIMIT " . $start . "," . $limit
			);
		}

		if ($q->NumRows() > 0)
		{
			$main_template = preg_replace('/\[tag:if_empty](.*?)\[\/tag:if_empty]/si', '', $main_template);
			$main_template = str_replace (array('[tag:if_notempty]','[/tag:if_notempty]'), '', $main_template);
		}
		else
		{
			$main_template = preg_replace('/\[tag:if_notempty](.*?)\[\/tag:if_notempty]/si', '', $main_template);
			$main_template = str_replace (array('[tag:if_empty]','[/tag:if_empty]'), '', $main_template);
		}

		$page_nav   = '';
		if ($row_ab->request_show_pagination == 1 && $seiten > 1)
		{
			$page_nav = ' <a class="pnav" href="index.php?id=' . $AVE_Core->curentdoc->Id
				. '&amp;doc=' . (empty($AVE_Core->curentdoc->document_alias) ? prepare_url($AVE_Core->curentdoc->document_title) : $AVE_Core->curentdoc->document_alias)
				. ((isset($_REQUEST['artpage']) && is_numeric($_REQUEST['artpage'])) ? '&amp;artpage=' . $_REQUEST['artpage'] : '')
				. '&amp;apage={s}'
				. ((isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) ? '&amp;page=' . $_REQUEST['page'] : '')
				. '">{t}</a> ';
			$page_nav = get_pagination($seiten, 'apage', $page_nav, get_settings('navi_box'));
			$page_nav = rewrite_link($page_nav);
		}

		$items = '';
		while ($row = $q->FetchRow())
		{
			$link = rewrite_link('index.php?id=' . $row->Id . '&amp;doc=' . (empty($row->document_alias) ? prepare_url($row->document_title) : $row->document_alias));
			$items .= preg_replace('/\[tag:rfld:(\d+)]\[(more|[0-9-]+)]/e', "request_get_document_field(\"$1\", $row->Id, \"$2\")", $item_template);
			$items = str_replace('[tag:link]', $link, $items);
			$items = str_replace('[tag:docid]', $row->Id, $items);
			$items = str_replace('[tag:docdate]', pretty_date(strftime(TIME_FORMAT, $row->document_published)), $items);
			$items = str_replace('[tag:docviews]', $row->document_count_view, $items);
			$items = str_replace('[tag:doccomments]', isset($row->nums) ? $row->nums : '', $items);
		}

		$main_template = str_replace('[tag:pages]', $page_nav, $main_template);
		$main_template = str_replace('[tag:docid]', $AVE_Core->curentdoc->Id, $main_template);
		$main_template = str_replace('[tag:docdate]', $AVE_Core->curentdoc->document_published, $main_template);
		$main_template = preg_replace('/\[tag:dropdown:([,0-9]+)\]/e', "request_get_dropdown(\"$1\", " . $row_ab->rubric_id . ", " . $row_ab->Id . ");", $main_template);

		$return = str_replace('[tag:content]', $items, $main_template);
		$return = str_replace('[tag:path]', ABS_PATH, $return);
		$return = str_replace('[tag:mediapath]', ABS_PATH . 'templates/' . THEME_FOLDER . '/', $return);

		$return = $AVE_Core->coreModuleTagParse($return);
	}

	return $return;
}

/**
 * Функция получения содержимого поля для обработки в шаблоне запроса
 * <pre>
 * Пример использования в шаблоне:
 *   <li>
 *     <?php
 *      $r = request_get_document_field_value(12, [tag:docid]);
 *      echo $r . ' (' . strlen($r) . ')';
 *     ?>
 *   </li>
 * </pre>
 *
 * @param int $rubric_id	идентификатор поля, для [tag:rfld:12][150] $rubric_id = 12
 * @param int $document_id	идентификатор документа к которому принадлежит поле.
 * @param int $maxlength	необязательный параметр, количество возвращаемых символов.
 * 							Если данный параметр указать со знаком минус
 * 							содержимое поля будет очищено от HTML-тэгов.
 * @return string
 */
function request_get_document_field_value($rubric_id, $document_id, $maxlength = 0)
{
	if (!is_numeric($rubric_id) || $rubric_id < 1 || !is_numeric($document_id) || $document_id < 1) return '';

	$document_fields = get_document_fields($document_id);

	$field_value = isset($document_fields[$rubric_id]) ? $document_fields[$rubric_id]['field_value'] : '';

	if (!empty($field_value))
	{
		$field_value = strip_tags($field_value, '<br /><strong><em><p><i>');
		$field_value = str_replace('[tag:mediapath]', ABS_PATH . 'templates/' . THEME_FOLDER . '/', $field_value);
	}

	if (is_numeric($maxlength) && $maxlength != 0)
	{
		if ($maxlength < 0)
		{
			$field_value = str_replace(array("\r\n", "\n", "\r"), ' ', $field_value);
			$field_value = strip_tags($field_value);
			$field_value = preg_replace('/  +/', ' ', $field_value);
			$maxlength = abs($maxlength);
		}
		$field_value = substr($field_value, 0, $maxlength) . (strlen($field_value) > $maxlength ? '... ' : '');
	}

	return $field_value;
}

/**
 * Функция формирования выпадающих списков
 * для управления условиями запроса в публичной части
 *
 * @param string $dropdown_ids	идентификаторы полей
 * 								типа выпадающий список указанные через запятую
 * @param int $rubric_id		идентификатор рубрики
 * @param int $request_id		идентификатор запроса
 * @return string
 */
function request_get_dropdown($dropdown_ids, $rubric_id, $request_id)
{
	global $AVE_Core, $AVE_DB, $AVE_Template;

	$dropdown_ids = explode(',', preg_replace('/[^,\d]/', '', $dropdown_ids));
	$dropdown_ids[] = 0;
	$dropdown_ids = implode(',', $dropdown_ids);
	$doc_request = 'doc' . $AVE_Core->curentdoc->Id . '_request' . $request_id;
	$control = array();

	$sql = $AVE_DB->Query("
		SELECT
			Id,
			rubric_field_title,
			rubric_field_default
		FROM " . PREFIX . "_rubric_fields
		WHERE Id IN(" . $dropdown_ids . ")
		AND rubric_id = '" . $rubric_id . "'
		AND rubric_field_type = 'dropdown'
	");
	while ($row = $sql->FetchRow())
	{
		$dropdown['titel'] = $row->rubric_field_title;
		$dropdown['selected'] = !empty($_SESSION[$doc_request]['fld'][$row->Id]) ? $_SESSION[$doc_request]['fld'][$row->Id] : $row->condition_value;
		$dropdown['options'] = explode(',', $row->rubric_field_default);
		$control[$row->Id] = $dropdown;
	}

	$AVE_Template->assign('ctrlrequest', $control);
	return $AVE_Template->fetch(BASE_DIR . ABS_PATH . 'templates/' . THEME_FOLDER . '/modules/request/remote.tpl');
}

?>