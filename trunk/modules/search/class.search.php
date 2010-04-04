<?php
class Search {

/**
 *	СВОЙСТВА
 */

	var $_limit        = 15;
	var $_adminlimit   = 15;
	var $_highlight    = 1;
	var $_allowed_tags = '';

/**
 *	ВНЕШНИЕ МЕТОДЫ
 */

	function fetchForm($tpl_dir,$lang_file) {
		global $AVE_Template;

		$AVE_Template->config_load($lang_file);
		$config_vars = $AVE_Template->get_config_vars();
		$AVE_Template->assign('config_vars', $config_vars);
		$AVE_Template->display($tpl_dir . 'form.tpl');
	}

	function getSearchResults($tpl_dir, $lang_file) {
		global $AVE_DB, $AVE_Template, $AVE_Globals;

		$AVE_Template->config_load($lang_file);
		$config_vars = $AVE_Template->get_config_vars();
		$AVE_Template->assign('config_vars', $config_vars);

		define('MODULE_SITE', $config_vars['SEARCH_RESULTS']);

		$find = true;

		// Двойные пробелы в один
		$query = ereg_replace(' +', ' ', $_GET['query']);

		// Удаляем пробел в начале и конце
		$query = trim($query);

		$query = (isset($query) && $query != '' && $query != ' ') ? $query : '';
		$query = ereg_replace('([^ +_A-Za-zА-Яа-яЁё0-9-])', '', $query);

		if (strlen($query) < 3) {
			$find = false;
		}
		else {
			if (!strpos($query, ' ')) {
				// Пропускаем через Стеммер Портера
				$stemmer = new Lingua_Stem_Ru();
				$query = $stemmer->stem_word($query);
			}
		}

		if ($find == true) {
			$sw  = strtolower($query);
			$sql = $AVE_DB->Query("
				SELECT Suchbegriff
				FROM " . PREFIX . "_modul_search
				WHERE Suchbegriff = '" . $sw . "'
			");
			$num = $sql->NumRows();
			$sql->Close();

			if ($num < 1) {
				$AVE_DB->Query("
					INSERT
					INTO " . PREFIX . "_modul_search
						(Id,Suchbegriff,Anzahl)
					VALUES
						('','" . $sw . "','1')
				");
			}
			else {
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_modul_search
					SET Anzahl = Anzahl+1
					WHERE Suchbegriff = '" . $sw . "'
				");
			}

			$kette = @explode(' ', $query);

			$ex_inhalt = '';

			$or_and = (isset($_REQUEST['or']) && $_REQUEST['or'] == 1) ? ' OR ' : ' AND ';

			foreach ($kette as $suche) {
				$und = @explode(' +', $suche);
				foreach ($und as $und_wort) {
					if (strpos($und_wort, '+') !== false) {
						$ex_inhalt .= " $or_and ( (Inhalt like '%" . substr($und_wort, 1) . "%') OR (Inhalt like '%" . $this->_specialchars(substr($und_wort, 1)) . "%') )";
					}
				}

				$und_nicht = @explode(' -', $suche);

				foreach ($und_nicht as $und_nicht_wort) {
					if (strpos($und_nicht_wort, '-') !== false) {
						$ex_inhalt .= " $or_and ( (Inhalt not like '%" . substr($und_nicht_wort,1) . "%') OR (Inhalt not like '%" . $this->_specialchars(substr($und_nicht_wort,1)) . "%') )";
					}
				}

				$start = explode(' +', $query);
				if (strpos($start[0], ' -') !== false) {
					$start = explode(' -', $query);
				}
				$start = $start[0];
			}

			$ex_inhalt = " WHERE ( (Inhalt like '%" . $start . "%') OR (Inhalt like '%" . $this->_specialchars($start) . "%') ) $ex_inhalt ";

			$count_match = 0;
			$w_rf = '';

			if (isset($_REQUEST['ts']) && $_REQUEST['ts'] == 1) {
				$type_search = "WHERE RubTyp = 'kurztext'";
				$type_navi = '&amp;ts=1';
			}
			else {
				$type_search = "WHERE RubTyp = 'langtext'";
				$type_navi = '';
			}

			$i = 0;

			$w_rf = ' AND (';

			$sql_rf = $AVE_DB->Query("
				SELECT Id
				FROM " . PREFIX . "_rubric_fields
				" . $type_search
			);

			while ($row = $sql_rf->FetchRow()) {
				$w_rf .= (($i >= 1) ? 'OR ' : '') . "RubrikFeld = $row->Id ";
				$i++;
			}

			$w_rf .= ')';

			$exclude_tag = '';

			// $exclude_tag = " AND (Inhalt NOT LIKE '[cp:replacement]%%')";
			// echo "SELECT DokumentId,Inhalt FROM " . PREFIX . "_document_fields $ex_inhalt $w_rf AND Suche=1 {$exclude_tag}";

			$query_feld = $AVE_DB->Query("
				SELECT
					DokumentId,
					Inhalt
				FROM " . PREFIX . "_document_fields
				" . $ex_inhalt . "
				" . $w_rf . "
				AND Suche = 1
				" . $exclude_tag
			);
			$count_match = $query_feld->NumRows();
			$num_erg = $count_match;

			$limit = $this->_limit;
			$seiten = ceil($count_match / $limit);
			$start = prepage() * $limit - $limit;

			$query_feld = $AVE_DB->Query("
				SELECT
					DokumentId,
					Inhalt
				FROM " . PREFIX . "_document_fields
				" . $ex_inhalt . "
				" . $w_rf . "
				AND Suche = 1
				" . $exclude_tag . "
				LIMIT " . $start . "," . $limit
			);
			$count_match = $query_feld->NumRows();

			$AVE_DB->Query("
				UPDATE " . PREFIX . "_modul_search
				SET Gefunden = '" . $count_match . "'
				WHERE Suchbegriff = '" . $sw . "'
			");

			if ($limit < $num_erg) {
				$template_label = " <a class=\"pnav\" href=\"index.php?module=search&amp;query=" . urlencode($query) . $type_navi . ((isset($_REQUEST['or']) && $_REQUEST['or'] == 1) ? "&amp;or=1" : "") . "&amp;page={s}\">{t}</a> ";
				$nav = pagenav($seiten, 'page', $template_label, trim($AVE_Globals->mainSettings('navi_box')));
				$AVE_Template->assign('q_navi', $nav);
			}

			if ($num_erg < 1) {
				$AVE_Template->assign('no_results', 1);
			}


			$p_begriff = $query;

			if ($count_match > 0) {
				$modul_search_results = array();
//				$match = array();
				$num = '';
				$doctime = $AVE_Globals->mainSettings('use_doctime')
					? ("AND ((DokStart = 0 AND DokEnde = 0) OR (DokStart <= " . time() . " AND DokEnde >= " . time() . "))")
					: '';

				while ($row_feld = $query_feld->FetchRow()) {
					$sql = $AVE_DB->Query("
						SELECT
							Id,
							Titel,
							Url
						FROM " . PREFIX . "_documents
						WHERE Id = '" . $row_feld->DokumentId . "'
						AND Geloescht = 0
						AND DokStatus = 1
						" . $doctime
					);
					while ($row = $sql->FetchRow()) {
						$row->Text = $this->_getContent($row->Id);
						$row->Text = stripslashes(strip_tags($row->Text, $this->_allowed_tags));
						$row->Text = str_replace('[cp:sitemap]', ' ', $row->Text);

						$fo = array();
						preg_match("/.{0,100}".$p_begriff.".*?\b.{0,100}/i", $row->Text, $fo);

						$row->Text = ' ... ';
						while (list($key, $val) = @each($fo)) {
							$row->Text .= $val . ' ... ';
						}

//						$row->Doc = cpParseLinkname($row->Titel);

						if ($this->_highlight == 1) {
							$row->Text = @preg_replace("/".$p_begriff.".*?\b/i", "<span class=\"mod_search_highlight\">$0</span>", $row->Text);
						}
						$row->Url = (CP_REWRITE==1)
							? cpRewrite('index.php?id=' . $row->Id . '&amp;doc=' . (empty($row->Url) ? cpParseLinkname($row->Titel) : $row->Url))
							: 'index.php?id=' . $row->Id . '&amp;doc=' . (empty($row->Url) ? cpParseLinkname($row->Titel) : $row->Url);

						array_push($modul_search_results, $row);
					}
				}

				$AVE_Template->assign('searchresults', $modul_search_results);
			}
		}
		else {
			$AVE_Template->assign('no_results', 1);
		}

		$AVE_Template->assign('inc_path', BASE_DIR . '/modules/search/templates');
		$tpl_out = $AVE_Template->fetch($tpl_dir . 'results.tpl');

		if (!defined('MODULE_CONTENT')) define('MODULE_CONTENT', $tpl_out);
	}

	function showWords($tpl_dir) {
		global $AVE_DB, $AVE_Template;

		$limit = $this->_adminlimit;

		$sort      = ' ORDER BY Suchbegriff ASC';
		$sort_navi = '';

		if (!empty($_REQUEST['sort'])) {
			switch ($_REQUEST['sort']) {
				case 'begriff_desc' :
					$sort      = ' ORDER BY Suchbegriff DESC';
					$sort_navi = '&amp;sort=begriff_desc';
					break;

				case 'begriff_asc' :
					$sort      = ' ORDER BY Suchbegriff ASC';
					$sort_navi = '&amp;sort=begriff_asc';
					break;

				case 'anzahl_desc' :
					$sort      = ' ORDER BY Anzahl DESC';
					$sort_navi = '&amp;sort=anzahl_desc';
					break;

				case 'anzahl_asc' :
					$sort      = ' ORDER BY Anzahl ASC';
					$sort_navi = '&amp;sort=anzahl_asc';
					break;

				case 'gefunden_desc' :
					$sort      = ' ORDER BY Gefunden DESC';
					$sort_navi = '&amp;sort=gefunden_desc';
					break;

				case 'gefunden_asc' :
					$sort      = ' ORDER BY Gefunden ASC';
					$sort_navi = '&amp;sort=gefunden_asc';
					break;
			}
		}

		$sql = $AVE_DB->Query("
			SELECT Id
			FROM " . PREFIX . "_modul_search
			" . $sort
		);
		$num = $sql->NumRows();

		$seiten = ceil($num / $limit);
		$start = prepage() * $limit - $limit;

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_modul_search
			" . $sort . "
			LIMIT " . $start . "," . $limit
		);

		while ($row = $sql->FetchRow()) {
			array_push($items,$row);
		}

		if ($num > $limit) {
			$page_nav = pagenav($seiten, 'page',
				" <a class=\"pnav\" href=\"index.php?do=modules&action=modedit&mod=search&moduleaction=1" . $sort_navi . "&cp=" . SESSION . "&page={s}\">{t}</a> ");
			$AVE_Template->assign('page_nav', $page_nav);
		}

		$AVE_Template->assign('items', $items);
		$AVE_Template->assign('content', $AVE_Template->fetch($tpl_dir . 'words.tpl'));
	}

	function delWords() {
		global $AVE_DB;

		$AVE_DB->Query("DELETE FROM " . PREFIX . "_modul_search");
		header('Location:index.php?do=modules&action=modedit&mod=search&moduleaction=1&cp=' . SESSION);

		exit;
	}

/**
 *	ВНУТРЕННИЕ МЕТОДЫ
 */

	function _getContent($id) {
		global $AVE_DB;

		$query = !empty($_GET['query']) ? $_GET['query'] : '';
		$query = ereg_replace('([^ ;+_A-Za-zА-Яа-яЁё0-9-])', '', $query);

		// Двойные пробелы в один
		$query = ereg_replace(' +', ' ', $_GET['query']);

		// Удаляем пробел в начале и конце
		$query = trim($query);

		if (!strpos($query, ' ')) {
			// Пропускаем через Стеммер Портера
			$stemmer = new Lingua_Stem_Ru();
			$query = $stemmer->stem_word($query);
		}

		$sql = $AVE_DB->Query("
			SELECT Inhalt
			FROM " . PREFIX . "_document_fields
			WHERE DokumentId = '" . $id . "'
			AND Inhalt like '%" . $query . "%'
		--	AND (Inhalt NOT LIKE '[cp:replacement]%%')
		");
		$row = $sql->FetchRow();
		$sql->Close();

		return @$row->Inhalt;
	}

	function _specialchars($string) {
		$string = str_replace ( '"', '&quot;', $string );
		$string = urldecode($string);

		return $string;
	}
}
?>