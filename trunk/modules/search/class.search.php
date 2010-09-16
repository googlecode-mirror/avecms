<?php

/**
 * AVE.cms - Ìîäóëü Ïîèñê
 *
 * @package AVE.cms
 * @subpackage module_Search
 * @since 1.4
 * @filesource
 */
class Search
{

/**
 *	ÑÂÎÉÑÒÂÀ
 */

	var $_limit           = 15;
	var $_adminlimit      = 15;
	var $_highlight       = 1;
	var $_allowed_tags    = '';
	var $_disallowed_tags = '';
	var $_search_string   = '';
	var $_stem_words      = array();
	var $_like = "( (field_value LIKE '%%%s%%') OR (field_value LIKE '%%%s%%') )";
	var $_not_like = "( (field_value NOT LIKE '%%%s%%') OR (field_value NOT LIKE '%%%s%%') )";

/**
 *	ÂÍÓÒÐÅÍÍÈÅ ÌÅÒÎÄÛ
 */

	function _searchSpecialchars($string)
	{
		$string = str_replace ( '"', '&quot;', $string );
		$string = urldecode($string);

		return $string;
	}

	function _create_string_like(&$word, $key, $type='')
	{
		global $stemmer;

		switch ($type)
		{
			case '-':
				$word = $stemmer->stem_word(substr($word, 1));
				$format_string = $this->_not_like;
				break;

			case '+':
				$word = $stemmer->stem_word(substr($word, 1));
				$format_string = $this->_like;
				$this->_stem_words[] = $word;
				break;

			default:
				$word = $stemmer->stem_word($word);
				$format_string = $this->_like;
				$this->_stem_words[] = $word;
				break;
		}

		$word = sprintf($format_string, $word, $this->_searchSpecialchars($word));
	}

/**
 *	ÂÍÅØÍÈÅ ÌÅÒÎÄÛ
 */

	function searchResultGet($tpl_dir, $lang_file)
	{
		global $AVE_DB, $AVE_Template;

		$AVE_Template->config_load($lang_file);

		define('MODULE_SITE', $AVE_Template->get_config_vars('SEARCH_RESULTS'));

		$stem_words = array();

		$tmp = preg_replace('/[^\x20-\xFF]|[><!?.,;=—]/', ' ', $_GET['query']);
		$this->_search_string = trim(preg_replace('/  +/', ' ', stripslashes($tmp)));

		if (strlen($this->_search_string) > 2)
		{
			$sw  = addslashes(strtolower($this->_search_string));
			$exist = $AVE_DB->Query("
				SELECT 1
				FROM " . PREFIX . "_modul_search
				WHERE search_query = '" . $sw . "'
				LIMIT 1
			")->NumRows();

			if ($exist)
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_search
					SET search_count = search_count+1
					WHERE search_query = '" . $sw . "'
				");
			}
			else
			{
				$AVE_DB->Query("
					INSERT
					INTO " . PREFIX . "_modul_search
					SET
						Id = '',
						search_query = '" . $sw . "',
						search_count = 1
				");
			}

			// ýêðàíèðîâàíèå äëÿ LIKE
			$tmp = str_replace('\\', '\\\\', $this->_search_string);
			$tmp = addcslashes(addslashes($tmp), '%_');

//			$tmp = preg_replace('/  +/', ' ', $tmp);
			$tmp = preg_split('/\s+/', $tmp);

			$where = '';
			if (sizeof($tmp))
			{
				$_tmp = preg_grep('/^[^\+|-].{3,}/', $tmp);
				array_walk($_tmp, array(&$this,'_create_string_like'));
				// +
				$__tmp = preg_grep('/^\+.{3,}/', $tmp);
				array_walk($__tmp, array(&$this,'_create_string_like'), '+');
				// -
				$___tmp = preg_grep('/^-.{3,}/', $tmp);
				array_walk($___tmp, array(&$this,'_create_string_like'), '-');

				if (!empty($_tmp))
				{
					$where = 'WHERE (' . implode((isset($_REQUEST['or']) && 1 == $_REQUEST['or']) ? ' OR ' : ' AND ', $_tmp) . ')';
					if (!empty($__tmp))
					{
						$where .= ' AND ' . implode(' AND ', array_merge($__tmp, $___tmp));
					}
				}
				else
				{
					$where = 'WHERE ' . implode(' AND ', array_merge($__tmp, $___tmp));
				}
			}

			$num = 0;
			if ($where != '')
			{
				if (isset($_REQUEST['ts']) && 1 == $_REQUEST['ts'])
				{
					$type_search = "WHERE rubric_field_type = 'kurztext'";
					$type_navi = '&amp;ts=1';
				}
				else
				{
					$type_search = "WHERE rubric_field_type = 'langtext'";
					$type_navi = '';
				}

				$sql_rf = $AVE_DB->Query("
					SELECT Id
					FROM " . PREFIX . "_rubric_fields
					" . $type_search
				);
				$w_rf = array();
				while ($row = $sql_rf->FetchRow())
				{
					$w_rf[] = "rubric_field_id = " . $row->Id;
				}
				$w_rf = ' AND (' . implode(' OR ', $w_rf) . ')';

				$num = $AVE_DB->Query("
					SELECT
						document_id,
						field_value
					FROM " . PREFIX . "_document_fields
					" . $where . "
					" . $w_rf . "
					AND document_in_search = '1'
				")->numrows();

				$limit = $this->_limit;
				$seiten = ceil($num / $limit);
				$start = get_current_page() * $limit - $limit;

				$query_feld = $AVE_DB->Query("
					SELECT
						document_id,
						field_value
					FROM " . PREFIX . "_document_fields
					" . $where . "
					" . $w_rf . "
					AND document_in_search = '1'
					LIMIT " . $start . "," . $limit
				);

				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_search
					SET search_found = '" . $num . "'
					WHERE search_query = '" . $sw . "'
				");

				if ($num > $limit)
				{
					$page_nav = " <a class=\"pnav\" href=\"index.php?module=search&amp;query="
						. urlencode($this->_search_string)
						. $type_navi
						. ((isset($_REQUEST['or']) && 1 == $_REQUEST['or']) ? "&amp;or=1" : "")
						. "&amp;page={s}\">{t}</a> ";
					$page_nav = get_pagination($seiten, 'page', $page_nav, trim(get_settings('navi_box')));
					$AVE_Template->assign('q_navi', $page_nav);
				}
			}

			if ($num > 0)
			{
				$modul_search_results = array();

				array_walk($this->_stem_words, create_function('&$val','$val=preg_quote(stripslashes(stripslashes(str_replace("\"","&quot;",$val))),"/");'));
				$regex_snapshot  = '/.{0,100}[^\s]*' . implode('[^\s]*.{0,100}|.{0,100}[^\s]*', $this->_stem_words) . '[^\s]*.{0,100}/is';
				$regex_highlight = '/[^\s]*' . implode('[^\s]*|[^\s]*', $this->_stem_words) . '[^\s]*/is';

				$doctime = get_settings('use_doctime')
					? ("AND document_published <= " . time() . " AND (document_expire = 0 OR document_expire >= " . time() . ")") : '';

				while ($row_feld = $query_feld->FetchRow())
				{
					$sql = $AVE_DB->Query("
						SELECT
							Id,
							document_title,
							document_alias
						FROM " . PREFIX . "_documents
						WHERE Id = '" . $row_feld->document_id . "'
						AND document_deleted = '0'
						AND document_status = '1'
						" . $doctime
					);
					while ($row = $sql->FetchRow())
					{
						$row->Text = $row_feld->field_value;
						$row->Text = strip_tags($row->Text, $this->_allowed_tags);

						$fo = array();
						preg_match($regex_snapshot, $row->Text, $fo);

						$row->Text = ' ... ';
						while (list($key, $val) = @each($fo))
						{
							$row->Text .= $val . ' ... ';
						}

						if (1 == $this->_highlight && !empty($this->_stem_words))
						{
							$row->Text = @preg_replace($regex_highlight, "<span class=\"mod_search_highlight\">$0</span>", $row->Text);
						}
						$row->document_alias = rewrite_link('index.php?id=' . $row->Id . '&amp;doc=' . (empty($row->document_alias) ? prepare_url($row->document_title) : $row->document_alias));

						array_push($modul_search_results, $row);
					}
				}

				$AVE_Template->assign('searchresults', $modul_search_results);
			}
			else
			{
				$AVE_Template->assign('no_results', 1);
			}
		}
		else
		{
			$AVE_Template->assign('no_results', 1);
		}

		if (!defined('MODULE_CONTENT'))
		{
			$AVE_Template->assign('inc_path', BASE_DIR . '/modules/search/templates');
			define('MODULE_CONTENT', $AVE_Template->fetch($tpl_dir . 'results.tpl'));
		}
	}

	function searchWordsShow($tpl_dir)
	{
		global $AVE_DB, $AVE_Template;

		$limit = $this->_adminlimit;

		$sort      = ' ORDER BY search_query ASC';
		$sort_navi = '';

		if (!empty($_REQUEST['sort']))
		{
			switch ($_REQUEST['sort'])
			{
				case 'begriff_desc' :
					$sort      = ' ORDER BY search_query DESC';
					$sort_navi = '&amp;sort=begriff_desc';
					break;

				case 'begriff_asc' :
					$sort      = ' ORDER BY search_query ASC';
					$sort_navi = '&amp;sort=begriff_asc';
					break;

				case 'anzahl_desc' :
					$sort      = ' ORDER BY search_count DESC';
					$sort_navi = '&amp;sort=anzahl_desc';
					break;

				case 'anzahl_asc' :
					$sort      = ' ORDER BY search_count ASC';
					$sort_navi = '&amp;sort=anzahl_asc';
					break;

				case 'gefunden_desc' :
					$sort      = ' ORDER BY search_found DESC';
					$sort_navi = '&amp;sort=gefunden_desc';
					break;

				case 'gefunden_asc' :
					$sort      = ' ORDER BY search_found ASC';
					$sort_navi = '&amp;sort=gefunden_asc';
					break;
			}
		}

		$num = $AVE_DB->Query("
			SELECT Id
			FROM " . PREFIX . "_modul_search
			" . $sort
		)->NumRows();

		$seiten = ceil($num / $limit);
		$start = get_current_page() * $limit - $limit;

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_search
			" . $sort . "
			LIMIT " . $start . "," . $limit
		);
		while ($row = $sql->FetchRow())
		{
			array_push($items,$row);
		}

		if ($num > $limit)
		{
			$page_nav = " <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=search&moduleaction=1" . $sort_navi . "&cp=" . SESSION . "&page={s}\">{t}</a> ";
			$page_nav = get_pagination($seiten, 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}

		$AVE_Template->assign('items', $items);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'words.tpl'));
	}

	function searchWordsDelete()
	{
		global $AVE_DB;

		$AVE_DB->Query("DELETE FROM " . PREFIX . "_modul_search");

		header('Location:index.php?do=modules&action=modedit&mod=search&moduleaction=1&cp=' . SESSION);
		exit;
	}
}
?>