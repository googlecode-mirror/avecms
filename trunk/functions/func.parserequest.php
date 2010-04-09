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
 * @param int $id - идентификатор запроса
 * @return string
 */
function query_condition($id)
{
	global $AVE_DB;

	$where     = '';
	$from      = PREFIX . '_document_fields AS t0';
	$eq_string = '';
	$ueb       = '';
	$start     = 0;
	$defid     = currentDocId();
	$doc_query = 'doc' . $defid . '_query' . $id;

	if (!empty($_REQUEST['fld']))
	{
		$_SESSION[$doc_query]['fld'] = $_REQUEST['fld'];
	}
	else
	{
		if (!empty($_SESSION[$doc_query]['fld']))
		{
			$_REQUEST['fld'] = $_SESSION[$doc_query]['fld'];
		}
		else
		{
			$_REQUEST['fld'] = array();
		}
	}

	$sql_ak = $AVE_DB->Query("
		SELECT *
		FROM " . PREFIX . "_queries_conditions
		WHERE Abfrage = '" . $id . "'
	");

	while ($row_ak = $sql_ak->FetchRow())
	{
		$feld = $row_ak->Feld;

		if (!empty($_REQUEST['fld'][$feld]))
		{
			$wert = $_REQUEST['fld'][$feld];
			unset($_REQUEST['fld'][$feld]);
		}
		else
		{
			$wert = $row_ak->Wert;
		}

		if ($row_ak->Oper != 'OR')
		{
			$where = ' WHERE 1';
			$start_bracket = ' AND ';
			$lastb_bracket = '';
			$alias = 't' . $start;
			$from .= ($start != 0) ? ' JOIN ' . PREFIX . '_document_fields AS ' . $alias . ' USING(DokumentId)' : '';
		}
		else
		{
			$where = ' WHERE 0';
			$start_bracket = ' OR(';
			$lastb_bracket = ')';
			$alias = 't0';
		}

		switch ($row_ak->Operator)
		{
			case '%%':
				$eq_string .= $start_bracket . $alias . ".RubrikFeld = '" . $feld . "' AND " . $alias . ".Inhalt like '%" . $wert . "%' " . $lastb_bracket;
				break;

			case '%':
				$eq_string .= $start_bracket . $alias . ".RubrikFeld = '" . $feld . "' AND " . $alias . ".Inhalt like '" . $wert . "%' " . $lastb_bracket;
				break;

			case '<':
				$eq_string .= $start_bracket . $alias . ".RubrikFeld = '" . $feld . "' AND " . $alias . ".Inhalt < '" . $wert . "' " . $lastb_bracket;
				break;

			case '<=':
				$eq_string .= $start_bracket . $alias . ".RubrikFeld = '" . $feld . "' AND " . $alias . ".Inhalt <= '" . $wert . "' " . $lastb_bracket;
				break;

			case '>':
				$eq_string .= $start_bracket . $alias . ".RubrikFeld = '" . $feld . "' AND " . $alias . ".Inhalt > '" . $wert . "' " . $lastb_bracket;
				break;

			case '>=':
				$eq_string .= $start_bracket . $alias . ".RubrikFeld = '" . $feld . "' AND " . $alias . ".Inhalt >= '" . $wert . "' " . $lastb_bracket;
				break;

			case '==':
				$eq_string .= $start_bracket . $alias . ".RubrikFeld = '" . $feld . "' AND " . $alias . ".Inhalt = '" . $wert . "' " . $lastb_bracket;
				break;

			case '!=':
				$eq_string .= $start_bracket . $alias . ".RubrikFeld = '" . $feld . "' AND " . $alias . ".Inhalt != '" . $wert . "' " . $lastb_bracket;
				break;

			case '--':
				$eq_string .= $start_bracket . $alias . ".RubrikFeld = '" . $feld . "' AND " . $alias . ".Inhalt not like '%" . $wert . "%' " . $lastb_bracket;
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
			$from .= ($start != 0) ? ' JOIN ' . PREFIX . '_document_fields AS ' . $alias . ' USING(DokumentId)' : '';
			$eq_string .= ' AND ' . $alias . ".RubrikFeld = '" . $feld . "' AND " . $alias . ".Inhalt = '" . $wert . "'";
			++$start;
		}
	}

	if ($where != '')
	{
		$ueb = 'AND a.Id = ANY(SELECT DokumentId FROM ' . $from . $where . $eq_string . ')';
	}

	if (empty($_SESSION[$doc_query]['fld']))
	{
		$AVE_DB->Query("
			UPDATE " . PREFIX . "_queries
			SET	where_cond = '" . addslashes($ueb) . "'
			WHERE Id = '" . $id . "'
		");
	}

	return $ueb;
}

/**
 * Обработка тэга запроса.
 * Возвращает список документов удовлетворяющих параметрам запроса
 * оформленный с использованием шаблона
 *
 * @param int $id - идентификатор запроса
 * @return string
 */
function cpParseRequest($id)
{
	global $AVE_Core, $AVE_DB, $AVE_Globals;

	$return = '';

	if (is_array($id)) $id = $id[1];

	$row_ab = $AVE_DB->Query("
		SELECT *
		FROM " . PREFIX . "_queries
		WHERE Id = '" . $id . "'
	")
	->FetchRow();

	if (is_object($row_ab))
	{
		$eq = '';
		$wo = '';
		$suchart = '';

		$first = '';
		$second = '';

		$limit      = ($row_ab->Zahl < 1) ? 1 : $row_ab->Zahl;
		$template   = $row_ab->Template;
		$geruest    = $row_ab->AbGeruest;
		$sortierung = $row_ab->Sortierung;
		$asc_desc   = $row_ab->AscDesc;
		$ausgabe    = $template;
		$return     = '';
		$link       = '';
		$page_nav   = '';

		$doctime    = $AVE_Globals->mainSettings('use_doctime') ? ("AND (DokEnde = 0 || DokEnde > '" . time() . "') AND (DokStart = 0 || DokStart < '" . time() . "')") : '';

		$defid      = currentDocId();
		$where_cond = (!empty($_REQUEST['fld']) || !empty($_SESSION['doc' . $defid . '_query' . $id]['fld'])) ? query_condition($row_ab->Id) : $row_ab->where_cond;

		if ($row_ab->Navi == 1)
		{
			if (!empty($_SESSION['comments_enable']))
			{
				$num = $AVE_DB->Query("
					SELECT COUNT(*)
					FROM " . PREFIX . "_documents AS a
					WHERE a.Id != '1'
					AND a.Id != '" . PAGE_NOT_FOUND_ID . "'
					AND a.Id != '" . $AVE_Core->curentdoc->Id . "'
					AND a.RubrikId = '" . $row_ab->RubrikId . "'
					AND a.Geloescht != '1'
					AND a.DokStatus != '0'
					" . $where_cond . "
					" . $doctime . "
				")
				->GetCell();
			}
			else
			{
				$num = $AVE_DB->Query("
					SELECT COUNT(*)
					FROM " . PREFIX . "_documents AS a
					WHERE Id != '1'
					AND Id != '" . PAGE_NOT_FOUND_ID . "'
					AND Id != '" . $AVE_Core->curentdoc->Id . "'
					AND RubrikId = '" . $row_ab->RubrikId . "'
					AND Geloescht != 1
					AND DokStatus != 0
					" . $where_cond . "
					" . $doctime . "
				")
				->GetCell();
			}

			$seiten = ceil($num / $limit);
			$start  = prepage('apage') * $limit - $limit;
		}
		else
		{
			$start  = 0;
		}

		if (!empty($_SESSION['comments_enable']))
		{
			$q = $AVE_DB->Query("
				SELECT
					a.Id,
					a.Titel,
					a.Url,
					Geklickt,
					DokStart,
					COUNT(b.Id) AS nums
				FROM " . PREFIX . "_documents AS a
				LEFT JOIN " . PREFIX . "_modul_comment_info AS b ON document_id = a.Id
				WHERE a.Id != '1'
				AND a.Id != '" . PAGE_NOT_FOUND_ID . "'
				AND a.Id != '" . $AVE_Core->curentdoc->Id . "'
				AND RubrikId = '" . $row_ab->RubrikId . "'
				AND Geloescht != '1'
				AND DokStatus != '0'
				" . $where_cond . "
				" . $doctime . "
				GROUP BY a.Id
				ORDER BY " . $sortierung . " " . $asc_desc . "
				LIMIT " . $start . "," . $limit
			);
		}
		else
		{
			$q = $AVE_DB->Query("
				SELECT
					Id,
					Titel,
					Url,
					Geklickt,
					DokStart
				FROM " . PREFIX . "_documents AS a
				WHERE Id != '1'
				AND Id != '" . PAGE_NOT_FOUND_ID . "'
				AND Id != '" . $AVE_Core->curentdoc->Id . "'
				AND RubrikId = '" . $row_ab->RubrikId . "'
				AND Geloescht != 1
				AND DokStatus != 0
				" . $where_cond . "
				" . $doctime . "
				ORDER BY " . $sortierung . " " . $asc_desc . "
				LIMIT " . $start . "," . $limit
			);
		}

		if ($q->NumRows() > 0)
		{
			$geruest = preg_replace("/\[cp:if_empty](.*?)\[\/cp:if_empty]/si", '', $geruest);
			$geruest = str_replace (array('[cp:not_empty]','[/cp:not_empty]'), '', $geruest);
		}
		else
		{
			$geruest = preg_replace("/\[cp:not_empty](.*?)\[\/cp:not_empty]/si", '', $geruest);
			$geruest = str_replace (array('[cp:if_empty]','[/cp:if_empty]'), '', $geruest);
		}

		if ($row_ab->Navi == 1 && $seiten > 1)
		{
			$doc_titel = empty($AVE_Core->curentdoc->Url) ? cpParseLinkname(stripslashes($AVE_Core->curentdoc->Titel)) : $AVE_Core->curentdoc->Url;
			$art_page = (isset($_REQUEST['artpage']) && $_REQUEST['artpage'] > 1) ? '&amp;artpage=' . (int)$_REQUEST['artpage'] : '';
			$template_label = " <a class=\"pnav\" href=\"index.php?id=" . $defid . '&amp;doc=' . $doc_titel . $art_page . "&amp;apage={s}\">{t}</a> ";
			$page_nav = pagenav($seiten, 'apage', $template_label, trim($AVE_Globals->mainSettings('navi_box')));
			$page_nav = CP_REWRITE==1 ? cpRewrite($page_nav) : $page_nav;
		}

		while ($row = $q->FetchRow())
		{
			$link = 'index.php?id=' . $row->Id . '&amp;doc=' . (empty($row->Url) ? cpParseLinkname(stripslashes($row->Titel)) : $row->Url);
			$link = CP_REWRITE==1 ? cpRewrite($link) : $link;
			$return .= preg_replace('/\[cpabrub:(\d+)]\[(more|[0-9-]+)]/e', "getField(\"$1\", $row->Id, \"$2\")", $template);
			$return = str_replace('[link]', $link, $return);
			$return = str_replace('[docstart]', $row->DokStart, $return);
			$return = str_replace('[views]', $row->Geklickt, $return);
			$return = !empty($_SESSION['comments_enable']) ? str_replace('[comments]', $row->nums, $return) : str_replace('[comments]', '', $return);
		}

		$geruest = preg_replace("/\[cpctrlrub:([,0-9]+)\]/e", "getDropdown(\"$1\", " . $row_ab->RubrikId . ", " . $row_ab->Id . ");", $geruest);

		$return = str_replace('[content]', $return, $geruest);
		$return = str_replace('[pages]', $page_nav, $return);
		$return = str_replace('[cp:mediapath]', 'templates/' . THEME_FOLDER . '/', $return);
		$AVE_Core->parseModuleTag($return);
//		$return = stripslashes(hide($return));
	}
	return $return;
}

/**
 * Функция обработки тэгов полей с использованием шаблонов
 * в соответствии с типом поля
 *
 * @param int $rid - идентификатор рубрики
 * @param int $doc - идентификатор документа
 * @param int $maxlength - максимальное количество символов обрабатываемого поля
 * @return string
 */
function getField($rid, $doc, $maxlength = '')
{
	if (!is_numeric($rid) || $rid < 1 || !is_numeric($doc) || $doc < 1) return '';

	$document_fields = get_document_fields($doc);

	if (empty($document_fields[$rid])) return '';

	$inhalt = trim($document_fields[$rid]['Inhalt']);
	if ($inhalt == '' && $document_fields[$rid]['tpl_req_empty']) return '';

//	if ($maxlength != 'more')
//	{
//		$inhalt = strip_tags($inhalt, '<br /><strong><em><p><i>');
//	}

	switch ($document_fields[$rid]['RubTyp'])
	{
		case 'bild' :
			$inhalt = phpReplace($inhalt);
			$field_param = explode('|', $inhalt);
			$field_param[1] = isset($field_param[1]) ? $field_param[1] : '';
			if ($document_fields[$rid]['tpl_req_empty'])
			{
				$inhalt = '<img src="' . $field_param[0] . '" alt="' . $field_param[1] . '" border="0" />';
			}
			else
			{
				$inhalt = preg_replace('/\[field_param:(\d+)\]/ie', '@$field_param[\\1]', $document_fields[$rid]['tpl_req']);
			}
			$maxlength = '';
			break;

		case 'link' :
			$inhalt = phpReplace($inhalt);
			$field_param = explode('|', $inhalt);
			if (empty($field_param[1])) $field_param[1] = $field_param[0];
			if ($document_fields[$rid]['tpl_req_empty'])
			{
				$inhalt = " <a target=\"_self\" href=\"" . $field_param[0] . "\">" . $field_param[1] . "</a>";
			}
			else
			{
				$inhalt = preg_replace('/\[field_param:(\d+)\]/ie', '@$field_param[\\1]', $document_fields[$rid]['tpl_req']);
			}
			$maxlength = '';
			break;

		default:
			$inhalt = phpReplace($inhalt);
			$field_param = explode('|', $inhalt);
			$inhalt = $field_param[0];
			break;
	}

	if ($maxlength != '')
	{
		if ($maxlength == 'more')
		{
				$teaser = explode('<a name="more"></a>', $inhalt);
				$inhalt = $teaser[0];
		}
		else
		{
			if ($maxlength < 0)
			{
				$inhalt = str_replace(array("\r\n","\n","\r"), " ", $inhalt);
				$inhalt = strip_tags($inhalt);
				$inhalt = preg_replace('/(\s{2,})/', ' ', $inhalt);
				$inhalt = trim($inhalt);
				$maxlength = abs($maxlength);
			}
			$inhalt = substr($inhalt, 0, $maxlength) . ((strlen($inhalt) > $maxlength) ? '... ' : '');
		}
	}

	if (!$document_fields[$rid]['tpl_req_empty'])
	{
		$inhalt = preg_replace('/\[field_param:(\d+)\]/ie', '@$field_param[\\1]', $document_fields[$rid]['tpl_req']);
	}

	return $inhalt;
}

/**
 * Функция формирования выпадающих списков
 * для управления условиями запроса в публичной части
 *
 * @param string $dropdown_ids - идентификаторы полей
 * типа выпадающий список указанные через запятую
 * @param int $rid - идентификатор рубрики
 * @param int $qid - идентификатор запроса
 * @return string
 */
function getDropdown($dropdown_ids, $rid, $qid)
{
	global $AVE_DB, $AVE_Template;

	$dropdown_ids = explode(',', preg_replace('#[^,\d]#', '', $dropdown_ids));
	$dropdown_ids[] = 0;
	$dropdown_ids = implode(',', $dropdown_ids);
	$doc_query = 'doc' . currentDocId() . '_query' . $qid;
	$control = array();

	$sql = $AVE_DB->Query("
		SELECT
			Id,
			Titel,
			StdWert
		FROM " . PREFIX . "_rubric_fields
		WHERE Id IN(" . $dropdown_ids . ")
		AND RubrikId = '" . $rid . "'
		AND RubTyp = 'dropdown'
	");
	while ($row = $sql->FetchRow())
	{
		$dropdown['titel'] = $row->Titel;
		$dropdown['selected'] = !empty($_SESSION[$doc_query]['fld'][$row->Id]) ? $_SESSION[$doc_query]['fld'][$row->Id] : $row->Wert;
		$dropdown['options'] = explode(',', $row->StdWert);
		$control[$row->Id] = $dropdown;
	}

	$AVE_Template->assign('ctrlrequest', $control);
	return $AVE_Template->fetch(BASE_DIR . '/' . $AVE_Template->_tpl_vars['tpl_path'] . '/modules/request/remote.tpl');
}

/**
 * Функция получения содержимого поля для обработки в шаблоне запроса
 * <pre>
 * Пример использования в шаблоне:
 *   <li>
 *     <?php
 *      $r = getDbField(12, [cpabid]);
 *      echo $r . ' (' . strlen($r) . ')';
 *     ?>
 *   </li>
 * </pre>
 * @param int $rid - идентификатор поля, для [cpabrub:12][150] $rid=12
 * @param int $doc - идентификатор документа к которому принадлежит поле.
 * @param int $maxlength - необязательный параметр, количество возвращаемых символов содержимого поля.
 * Если данный параметр указать со знаком минус содержимое поля будет очищено от HTML-тэгов.
 * @return string
 */
function getDbField($rid, $doc, $maxlength = 0)
{
	if (!is_numeric($rid) || $rid < 1 || !is_numeric($doc) || $doc < 1) return '';

	$document_fields = get_document_fields($doc);

	$inhalt = isset($document_fields[$rid]) ? $document_fields[$rid]['Inhalt'] : '';

	if (!empty($inhalt))
	{
		$inhalt = strip_tags($inhalt, '<br /><strong><em><p><i>');
		$inhalt = str_replace('[cp:mediapath]', 'templates/' . THEME_FOLDER . '/', $inhalt);
	}

	if (is_numeric($maxlength) && $maxlength != 0)
	{
		if ($maxlength < 0)
		{
			$inhalt = str_replace(array("\r\n", "\n", "\r"), ' ', $inhalt);
			$inhalt = strip_tags($inhalt);
			$inhalt = preg_replace('#\s+#', ' ',$inhalt);
			$maxlength = abs($maxlength);
		}
		$inhalt = substr($inhalt, 0, $maxlength) . (strlen($inhalt) > $maxlength ? '... ' : '');
	}

	return $inhalt;
}

?>