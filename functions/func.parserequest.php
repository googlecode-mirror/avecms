<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */


/**
 * ���������� ����������� php ��� � ����������
 *
 * @param int $id	������������� �������
 * @return string
 */
function eval2var( $expression ) {
	ob_start();
	eval( $expression );
	$content = ob_get_clean();
	return $content;
}
 
/**
 * ��������� ������� �������.
 * ���������� ������ ������� � SQL-�������
 *
 * @param int $id	������������� �������
 * @return string
 */
 function request_get_condition_sql_string($id)
{
	global $AVE_DB, $AVE_Core;

	$from = array();
	$where = array();
	$retval = '';
	$i = 0;

	if (!defined('ACP'))
	{
		$doc = 'doc_' . $AVE_Core->curentdoc->Id;

		if (isset($_POST['req_' . $id]))
		{
			$_SESSION[$doc]['req_' . $id] = $_POST['req_' . $id];
		}
		elseif (isset($_SESSION[$doc]['req_' . $id]))
		{
			$_POST['req_' . $id] = $_SESSION[$doc]['req_' . $id];
		}
	}

	$sql_ak = $AVE_DB->Query("
		SELECT *
		FROM " . PREFIX . "_request_conditions
		WHERE request_id = '" . $id . "'
	");

	//��������� � ����� ��� ����� ���� ������� ��� ������������ ������� ... ����� ������ ������ �� ��������� �� '='?
	if (!empty($_POST['req_' . $id]) && is_array($_POST['req_' . $id]))
	{
		foreach ($_POST['req_' . $id] as $fid => $val)
		{
			if (!($val != '' && isset($_SESSION['val_' . $fid]) && in_array($val, $_SESSION['val_' . $fid]))) continue;

			if ($i) $from[] = "%%PREFIX%%_document_fields AS t$i, ";
			$where[] = "((t$i.document_id = t0.document_id)AND(t$i.rubric_field_id = $fid AND t$i.field_value = '$val'))";

			++$i;
		}
	}
        $i=1;
		$vvv='';
	while ($row_ak = $sql_ak->FetchRow())
	{
		$fid = $row_ak->condition_field_id;

		if (isset($_POST['req_' . $id]) && isset($_POST['req_' . $id][$fid])) continue;


		$val = $row_ak->condition_value;
		
		if($val>''){
			$val = addcslashes ($val, "'");
			if ($i) $from[] = "<?php \$vv=eval2var(' ?>$val<? '); echo \$vv>'' ? \"%%PREFIX%%_document_fields AS t$i,  \" : ''; ?>";
			$vvv.="$val";
			switch ($row_ak->condition_compare)
			{
				
				case  'N<': $where[] = "<?php \$vv=eval2var(' ?>$val<? '); echo \$vv>'' ? \" ((t$i.document_id = a.id)AND(t$i.rubric_field_id = $fid AND CAST(t$i.field_value AS UNSIGNED) < '\$vv')) \" : ''; ?>"; break;
				case  'N>': $where[] = "<?php \$vv=eval2var(' ?>$val<? '); echo \$vv>'' ? \" ((t$i.document_id = a.id)AND(t$i.rubric_field_id = $fid AND CAST(t$i.field_value AS UNSIGNED) > '\$vv')) \" : ''; ?>"; break;
				case 'N<=': $where[] = "<?php \$vv=eval2var(' ?>$val<? '); echo \$vv>'' ? \" ((t$i.document_id = a.id)AND(t$i.rubric_field_id = $fid AND CAST(t$i.field_value AS UNSIGNED) <= '\$vv')) \" : ''; ?>"; break;
				case 'N>=': $where[] = "<?php \$vv=eval2var(' ?>$val<? '); echo \$vv>'' ? \" ((t$i.document_id = a.id)AND(t$i.rubric_field_id = $fid AND CAST(t$i.field_value AS UNSIGNED) >= '\$vv')) \" : ''; ?>"; break;

				case  '<': $where[] = "<?php \$vv=eval2var(' ?>$val<? '); echo \$vv>'' ? \" ((t$i.document_id = a.id)AND(t$i.rubric_field_id = $fid AND UPPER(t$i.field_value) < UPPER('\$vv'))) \" : ''; ?>"; break;
				case  '>': $where[] = "<?php \$vv=eval2var(' ?>$val<? '); echo \$vv>'' ? \" ((t$i.document_id = a.id)AND(t$i.rubric_field_id = $fid AND UPPER(t$i.field_value) > UPPER('\$vv'))) \" : ''; ?>"; break;
				case '<=': $where[] = "<?php \$vv=eval2var(' ?>$val<? '); echo \$vv>'' ? \" ((t$i.document_id = a.id)AND(t$i.rubric_field_id = $fid AND UPPER(t$i.field_value) <= UPPER('\$vv'))) \" : ''; ?>"; break;
				case '>=': $where[] = "<?php \$vv=eval2var(' ?>$val<? '); echo \$vv>'' ? \" ((t$i.document_id = a.id)AND(t$i.rubric_field_id = $fid AND UPPER(t$i.field_value) >= UPPER('\$vv'))) \" : ''; ?>"; break;

				case '==': $where[] = "<?php \$vv=eval2var(' ?>$val<? '); echo \$vv>'' ? \" ((t$i.document_id = a.id)AND(t$i.rubric_field_id = $fid AND UPPER(t$i.field_value) = UPPER('\$vv'))) \" : ''; ?>"; break;
				case '!=': $where[] = "<?php \$vv=eval2var(' ?>$val<? '); echo \$vv>'' ? \" ((t$i.document_id = a.id)AND(t$i.rubric_field_id = $fid AND UPPER(t$i.field_value) != UPPER('\$vv')) \" : ''; ?>"; break;
				case '%%': $where[] = "<?php \$vv=eval2var(' ?>$val<? '); echo \$vv>'' ? \" ((t$i.document_id = a.id)AND(t$i.rubric_field_id = $fid AND UPPER(t$i.field_value) LIKE UPPER('%\$vv%'))) \" : ''; ?>"; break;
				case  '%': $where[] = "<?php \$vv=eval2var(' ?>$val<? '); echo \$vv>'' ? \" ((t$i.document_id = a.id)AND(t$i.rubric_field_id = $fid AND UPPER(t$i.field_value) LIKE UPPER('\$vv%'))) \" : ''; ?>"; break;
				case '--': $where[] = "<?php \$vv=eval2var(' ?>$val<? '); echo \$vv>'' ? \" ((t$i.document_id = a.id)AND(t$i.rubric_field_id = $fid AND UPPER(t$i.field_value) NOT LIKE UPPER('%\$vv%'))) \" : ''; ?>"; break;
				case '!-': $where[] = "<?php \$vv=eval2var(' ?>$val<? '); echo \$vv>'' ? \" ((t$i.document_id = a.id)AND(t$i.rubric_field_id = $fid AND UPPER(t$i.field_value) NOT LIKE UPPER('\$vv%'))) \" : ''; ?>"; break;
			}

			if ($i || $row_ak->condition_join == 'AND') ++$i;
		}
	}

	if (!empty($where))
	{
		$from = implode(' ', $from);
		$where =  (($i) ? implode(' AND ', $where) : '(' . implode(') OR(', $where) . ')');
		$retval = serialize(array('from'=>$from,'where'=>"<?php echo (trim(eval2var(' ?>$vvv<? '))>'' ? \" AND  \" :\"\") ?>".$where));
	}

	if (defined('ACP'))
	{
		$AVE_DB->Query("
			UPDATE " . PREFIX . "_request
			SET	request_where_cond = '" . addslashes($retval) . "'
			WHERE Id = '" . $id . "'
		");
	}

	return $retval;
}

 

/**
 * ������� ��������� ����� ����� � �������������� ��������
 * � ������������ � ����� ����
 *
 * @param int $rubric_id	������������� �������
 * @param int $document_id	������������� ���������
 * @param int $maxlength	������������ ���������� �������� ��������������� ����
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

	$func='get_field_'.$document_fields[$rubric_id]['rubric_field_type'];
	if(is_callable($func)){
			$field_value=$func($field_value,'req',"","","",$maxlength,$document_fields,$rubric_id);
		}else{
			$field_value=get_field_default($field_value,'req',"","","",$maxlength,$document_fields,$rubric_id);
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
				$field_value = strip_tags($field_value, "<a>");
				$field_value = preg_replace('/  +/', ' ', $field_value);
				$field_value = trim($field_value);
				$maxlength = abs($maxlength);
			}
			$field_value = substr($field_value, 0, $maxlength) . ((strlen($field_value) > $maxlength) ? '... ' : '');
		}
	}

/*	if (!$document_fields[$rubric_id]['tpl_req_empty'])
	{
		$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $document_fields[$rubric_id]['rubric_field_template_request']);
	}
*/
	return $field_value;
}

/**
 * ��������� ���� �������.
 * ���������� ������ ���������� ��������������� ���������� �������
 * ����������� � �������������� �������
 *
 * @param int $id	������������� �������
 * @return string
 */
function request_parse($id)
{
	global $AVE_Core, $AVE_DB, $request_documents;

	$return = '';

	if (is_array($id)) $id = $id[1];

	$row_ab = $AVE_DB->Query("
		SELECT *
		FROM " . PREFIX . "_request
		WHERE Id = '" . $id . "'
	")->FetchRow();

	if (is_object($row_ab))
	{
		$limit = ($row_ab->request_items_per_page < 1) ? 1 : $row_ab->request_items_per_page;
		$main_template = $row_ab->request_template_main;
		$item_template = $row_ab->request_template_item;
		$request_order_by = $row_ab->request_order_by;
		$request_asc_desc = $row_ab->request_asc_desc;

		$doctime = get_settings('use_doctime')
			? ("AND a.document_published <= " . time() . " AND (a.document_expire = 0 OR a.document_expire >= " . time() . ")") : '';

		$where_cond = (empty($_POST['req_' . $id]) && empty($_SESSION['doc_' . $AVE_Core->curentdoc->Id]['req_' . $id]))
			? unserialize($row_ab->request_where_cond)
			: unserialize(request_get_condition_sql_string($row_ab->Id));
		$where_cond['from'] = str_replace('%%PREFIX%%', PREFIX, $where_cond['from']);
		$where_cond['where'] = str_replace('%%PREFIX%%', PREFIX, $where_cond['where']);
		
		// ���� �� ���� �������� ������
		// AND a.Id != '" . $AVE_Core->curentdoc->Id . "'
		
		if ($row_ab->request_show_pagination == 1)
		{
			if (!empty($AVE_Core->install_modules['comment']->Status))
			{
				$num = $AVE_DB->Query( eval2var( " ?> 
					SELECT COUNT(*)
					FROM 
					".($where_cond['from'] ? $where_cond['from'] : '')."
					" . PREFIX . "_documents AS a
					WHERE
						a.Id != '1'
					AND a.Id != '" . PAGE_NOT_FOUND_ID . "'
					AND a.rubric_id = '" . $row_ab->rubric_id . "'
					AND a.document_deleted != '1'
					AND a.document_status != '0'
					" . $where_cond['where'] . "
					" . $doctime . "
				<?php " ) )->GetCell();
			}
			else
			{
				$num = $AVE_DB->Query( eval2var( " ?>
					SELECT COUNT(*)
					FROM 
					".($where_cond['from'] ? $where_cond['from'] : '')."
					" . PREFIX . "_documents AS a
					WHERE
						a.Id != '1'
					AND a.Id != '" . PAGE_NOT_FOUND_ID . "'
					
					AND a.rubric_id = '" . $row_ab->rubric_id . "'
					AND a.document_deleted != '1'
					AND a.document_status != '0'
					" . $where_cond['where'] . "
					" . $doctime . "
				<?php " ) )->GetCell();
			}

			$seiten = ceil($num / $limit);
			if (isset($_REQUEST['apage']) && is_numeric($_REQUEST['apage']) && $_REQUEST['apage'] > $seiten)
			{
				$redirect_link = rewrite_link('index.php?id=' . $AVE_Core->curentdoc->Id
					. '&amp;doc=' . (empty($AVE_Core->curentdoc->document_alias) ? prepare_url($AVE_Core->curentdoc->document_title) : $AVE_Core->curentdoc->document_alias)
					. ((isset($_REQUEST['artpage']) && is_numeric($_REQUEST['artpage'])) ? '&amp;artpage=' . $_REQUEST['artpage'] : '')
					. ((isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) ? '&amp;page=' . $_REQUEST['page'] : ''));

				header('Location:' . $redirect_link);
				exit;
			}
			$start  = get_current_page('apage') * $limit - $limit;
		}
		else
		{
			$start  = 0;
		}

		if (!empty($AVE_Core->install_modules['comment']->Status))
		{
			$q = $AVE_DB->Query( eval2var( " ?>
				SELECT
					a.Id,
					a.document_title,
					a.document_alias,
					a.document_author_id,
					a.document_count_view,
					a.document_published,
					COUNT(b.document_id) AS nums
				FROM
					".($where_cond['from'] ? $where_cond['from'] : '')."
					" . PREFIX . "_documents AS a
				LEFT JOIN
					" . PREFIX . "_modul_comment_info AS b
						ON b.document_id = a.Id
				WHERE
					a.Id != '1'
				AND a.Id != '" . PAGE_NOT_FOUND_ID . "'
				AND a.rubric_id = '" . $row_ab->rubric_id . "'
				AND a.document_deleted != '1'
				AND a.document_status != '0'
				" . $where_cond['where'] . "
				" . $doctime . "
				GROUP BY a.Id
				ORDER BY " . $request_order_by . " " . $request_asc_desc . "
				LIMIT " . $start . "," . $limit .
			" <?php " ) );
		}
		else
		{
			$q = $AVE_DB->Query( eval2var( " ?>
				SELECT
					a.Id,
					a.document_title,
					a.document_alias,
					a.document_author_id,
					a.document_count_view,
					a.document_published
				FROM
					".($where_cond['from'] ? $where_cond['from'] : '')."
					" . PREFIX . "_documents AS a
				WHERE
					a.Id != '1'
				AND a.Id != '" . PAGE_NOT_FOUND_ID . "'
				AND a.rubric_id = '" . $row_ab->rubric_id . "'
				AND a.document_deleted != '1'
				AND a.document_status != '0'
				" . $where_cond['where'] . "
				" . $doctime . "
				ORDER BY " . $request_order_by . " " . $request_asc_desc . "
				LIMIT " . $start . "," . $limit .
			" <?php " ) );
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

		$rows = array();
		$request_documents = array();
		while ($row = $q->FetchRow())
		{
			array_push($request_documents, $row->Id);
			array_push($rows, $row);
		}
		$items = '';
		foreach ($rows as $row)
		{
			$link = rewrite_link('index.php?id=' . $row->Id . '&amp;doc=' . (empty($row->document_alias) ? prepare_url($row->document_title) : $row->document_alias));
			$items .= preg_replace('/\[tag:rfld:(\d+)]\[(more|[0-9-]+)]/e', "request_get_document_field(\"$1\", $row->Id, \"$2\")", $item_template);
			$items = str_replace('[tag:link]', $link, $items);
			$items = str_replace('[tag:docid]', $row->Id, $items);
			$items = str_replace('[tag:doctitle]', $row->document_title, $items);
			$items = str_replace('[tag:docdate]', pretty_date(strftime(DATE_FORMAT, $row->document_published)), $items);
			$items = str_replace('[tag:doctime]', pretty_date(strftime(TIME_FORMAT, $row->document_published)), $items);
			$items = str_replace('[tag:docauthor]', get_username_by_id($row->document_author_id), $items);
			$items = str_replace('[tag:docviews]', $row->document_count_view, $items);
			$items = str_replace('[tag:doccomments]', isset($row->nums) ? $row->nums : '', $items);
		}

		$main_template = str_replace('[tag:pages]', $page_nav, $main_template);
		$main_template = str_replace('[tag:docid]', $AVE_Core->curentdoc->Id, $main_template);
		$main_template = str_replace('[tag:docdate]', pretty_date(strftime(DATE_FORMAT, $AVE_Core->curentdoc->document_published)), $main_template);
		$main_template = str_replace('[tag:doctime]', pretty_date(strftime(TIME_FORMAT, $AVE_Core->curentdoc->document_published)), $main_template);
		$main_template = str_replace('[tag:docauthor]', get_username_by_id($AVE_Core->curentdoc->document_author_id), $main_template);
		$main_template = preg_replace('/\[tag:dropdown:([,0-9]+)\]/e', "request_get_dropdown(\"$1\", " . $row_ab->rubric_id . ", " . $row_ab->Id . ");", $main_template);

		$return = str_replace('[tag:content]', $items, $main_template);
		$return = str_replace('[tag:path]', ABS_PATH, $return);
		$return = str_replace('[tag:mediapath]', ABS_PATH . 'templates/' . THEME_FOLDER . '/', $return);

		$return = $AVE_Core->coreModuleTagParse($return);
	}
	return $return;
}

/**
 * ������� ��������� ����������� ���� ��� ��������� � ������� �������
 * <pre>
 * ������ ������������� � �������:
 *   <li>
 *     <?php
 *      $r = request_get_document_field_value(12, [tag:docid]);
 *      echo $r . ' (' . strlen($r) . ')';
 *     ?>
 *   </li>
 * </pre>
 *
 * @param int $rubric_id	������������� ����, ��� [tag:rfld:12][150] $rubric_id = 12
 * @param int $document_id	������������� ��������� � �������� ����������� ����.
 * @param int $maxlength	�������������� ��������, ���������� ������������ ��������.
 * 							���� ������ �������� ������� �� ������ �����
 * 							���������� ���� ����� ������� �� HTML-�����.
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
 * ������� ������������ ���������� �������
 * ��� ���������� ��������� ������� � ��������� �����
 *
 * @param string $dropdown_ids	�������������� �����
 * 								���� ���������� ������ ��������� ����� �������
 * @param int $rubric_id		������������� �������
 * @param int $request_id		������������� �������
 * @return string
 */
function request_get_dropdown($dropdown_ids, $rubric_id, $request_id)
{
	global $AVE_Core, $AVE_DB, $AVE_Template;

	$dropdown_ids = explode(',', preg_replace('/[^,\d]/', '', $dropdown_ids));
	$dropdown_ids[] = 0;
	$dropdown_ids = implode(',', $dropdown_ids);
	$doc = 'doc_' . $AVE_Core->curentdoc->Id;
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
		$dropdown['selected'] = isset($_SESSION[$doc]['req_' . $request_id][$row->Id]) ? $_SESSION[$doc]['req_' . $request_id][$row->Id] : '';
		$dropdown['options'] = $_SESSION['val_' . $row->Id] = explode(',', $row->rubric_field_default);
		$control[$row->Id] = $dropdown;
	}

	$AVE_Template->assign('request_id', $request_id);
	$AVE_Template->assign('ctrlrequest', $control);
	return $AVE_Template->fetch(BASE_DIR . '/templates/' . THEME_FOLDER . '/modules/request/remote.tpl');
}

?>