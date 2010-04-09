<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * �������� ����� ���������� ������ ��� ������ ��������
 */
class AVE_Core
{

/**
 *	��������
 */

    /**
     * ������� ��������
     *
     * @var object
     */
    var $curentdoc = null;

	/**
	 * ������������� ������
	 *
	 * @var array
	 */
	var $install_modules = null;

	/**
	 * ��������� �� ������
	 *
	 * @var string
	 */
	var $_doc_not_found = '<center><h1>HTTP Error 404: Page not found</h1></center>';

	/**
	 * ��������� �� ������
	 *
	 * @var string
	 */
	var $_rubric_template_empty = '<h1>������</h1><br />�� ����� ������ �������.';

	/**
	 * ��������� �� ������
	 *
	 * @var string
	 */
	var $_doc_not_published = '������������� �������� �������� � ����������.';

	/**
	 * ��������� �� ������
	 *
	 * @var string
	 */
	var $_module_error = '������������� ������ �� ����� ���� ��������.';

	/**
	 * ��������� �� ������
	 *
	 * @var string
	 */
	var $_module_not_found = '������������� ������ �� ������.';

/**
 *	������� ������
 */

    /**
     * ����������� ������
     *
     */
    function AVE_Core()
    {
        global $AVE_Template;

    }

	/**
	 * ������ ��������
	 *
	 * @param int $id ������������� ���������
	 * @param int $rub_id ������������� �������
	 */
	function displaySite($id, $rub_id = '')
	{
		global $AVE_DB, $AVE_Globals, $AVE_Template;

		if (!empty ($_REQUEST['module']))
		{	// ����� ������
			if ($_REQUEST['module'] == 'shop' && empty ($_REQUEST['product_id']))
			{
				$sql = $AVE_DB->Query("
					SELECT
						a.IndexFollow,
						b.ShopKeywords AS MetaKeywords,
						b.ShopDescription AS MetaDescription
			        FROM " . PREFIX . "_documents AS a, " . PREFIX . "_modul_shop AS b
			        WHERE a.Id = 1
			        AND b.Id = 1
				");
			}
			elseif ($_REQUEST['module'] == 'shop' && !empty ($_REQUEST['product_id']) && is_numeric($_REQUEST['product_id']))
			{
				$sql = $AVE_DB->Query("
					SELECT
						a.IndexFollow,
						b.ProdKeywords AS MetaKeywords,
						b.ProdDescription AS MetaDescription
					FROM " . PREFIX . "_documents AS a, " . PREFIX . "_modul_shop_artikel AS b
					WHERE a.Id = 1
					AND b.Id = '" . $_REQUEST['product_id'] . "'
				");
			}
			else
			{
				$sql = $AVE_DB->Query("
					SELECT
						IndexFollow,
						MetaKeywords,
						MetaDescription,
						Titel
					FROM " . PREFIX . "_documents
					WHERE Id = 1
				");
			}
			$this->curentdoc = $sql->FetchRow();

			$out = $this->_fetchMainTemplate('', '', $this->_fetchModuleTemplate());
		}	// /����� ������
		else
		{	// ����� ���������
			if (! (!empty ($this->curentdoc->Id) && $this->curentdoc->Id == $id))
			{
				$sql = $AVE_DB->Query("
					SELECT
						doc.*,
						Rechte,
						RubrikTemplate,
						Template
					FROM
						" . PREFIX . "_documents AS doc
					JOIN
						" . PREFIX . "_rubrics AS rub
							ON rub.Id = doc.RubrikId
					JOIN
						" . PREFIX . "_templates AS tpl
							ON tpl.Id = Vorlage
					JOIN
						" . PREFIX . "_document_permissions AS prm
							ON doc.RubrikId = prm.RubrikId
					WHERE
						BenutzerGruppe = '" . UGROUP . "'
					AND
						doc.Id = '" . $id . "'
					LIMIT 1
				");
				$this->curentdoc = $sql->FetchRow();

				if (empty ($this->curentdoc))
				{
					$sql = $AVE_DB->Query("
						SELECT
							doc.*,
							Rechte,
							RubrikTemplate,
							Template
						FROM
							" . PREFIX . "_documents AS doc
						JOIN
							" . PREFIX . "_rubrics AS rub
								ON rub.Id = doc.RubrikId
						JOIN
							" . PREFIX . "_templates AS tpl
								ON tpl.Id = Vorlage
						JOIN
							" . PREFIX . "_document_permissions AS prm
								ON doc.RubrikId = prm.RubrikId
						WHERE
							BenutzerGruppe = '" . UGROUP . "'
						AND
							doc.Id = '" . PAGE_NOT_FOUND_ID . "'
						LIMIT 1
					");
					$this->curentdoc = $sql->FetchRow();

					if (!empty ($this->curentdoc))
					{
						$_REQUEST['id'] = $_GET['id'] = $_POST['id'] = $id = PAGE_NOT_FOUND_ID;
					}
				}
			}

			// ��������� ����������� ����������
			if (!empty ($this->curentdoc)															// �������� ����
				&& $id != PAGE_NOT_FOUND_ID															// �������� �� ��������� ������ 404
				&& ( $this->curentdoc->DokStatus != 1												// ������ ���������
					|| $this->curentdoc->Geloescht == 1												// ������� ��������
					|| ( $AVE_Globals->mainSettings('use_doctime')									// ����� ���������� �������������� � ...
						&& ($this->curentdoc->DokEnde != 0 && $this->curentdoc->DokEnde < time())	// ����� ���������� �� ���������
						|| ($this->curentdoc->DokStart != 0 && $this->curentdoc->DokStart > time())	// ����� ���������� �������
						)
					)
				)
			{
				if (isset ($_SESSION['adminpanel']) || isset ($_SESSION['alles']))
				{
					displayNotice($this->_doc_not_published);
				}
				else
				{
					$this->curentdoc = false;
				}
			}

			if (empty ($this->curentdoc)) $this->_notFound(); // ��������� ��� ��� �� �����������

			// ����� ������� � ���������� �������
			define('RUB_ID', !empty ($rub_id) ? $rub_id : $this->curentdoc->RubrikId);
			$this->_fetchDocPerms(RUB_ID);

			if (! (isset ($_SESSION[RUB_ID . '_docread']) && $_SESSION[RUB_ID . '_docread'] == 1))
			{	// ������ ��������� - ��������� ������������ � ����� ������ ��������
				$main_content = $AVE_Globals->mainSettings('message_forbidden');
			}
			else
			{
				if (isset ($_REQUEST['print']) && $_REQUEST['print'] == 1)
				{	// ����������� ������� ������ ��� ������
					$AVE_DB->Query("
						UPDATE " . PREFIX . "_documents
						SET Drucke = Drucke+1
						WHERE Id = '" . $id . "'
					");
				}
				else
				{
					if (!isset ($_SESSION['doc_view[' . $id . ']']))
					{	// ����������� ������� ���������� (1 ��� � �������� ������)
						$AVE_DB->Query("
							UPDATE " . PREFIX . "_documents
							SET Geklickt = Geklickt+1
							WHERE Id = '" . $id . "'
						");
						$_SESSION['doc_view[' . $id . ']'] = 1;
					}
				}

				if (CACHE_DOC_TPL)
				{	// ����������� ���������
					// ��������� ���������������� ������ ��������� �� ����
					$main_content = $AVE_DB->Query("
						SELECT compiled
						FROM " . PREFIX . "_rubric_template_cache
						WHERE rub_id = '" . RUB_ID . "'
						AND grp_id   = '" . UGROUP . "'
						AND doc_id   = '" . $id . "'
						AND wysiwyg  = '" . (!empty ($_SESSION['user_adminmode']) ? 1 : 0) . "'
						LIMIT 1
					")->GetCell();
				}
				else
				{	// ����������� ���������
					$main_content = false;
				}

				if (empty ($main_content))
				{	// ��� ������ ��� ��������, ��������� � ����������� ������
					if (!empty ($this->curentdoc->RubrikTemplate))
					{
						$rubTmpl = $this->curentdoc->RubrikTemplate;
					}
					else
					{
						$rubTmpl = $AVE_DB->Query("
							SELECT RubrikTemplate
							FROM " . PREFIX . "_rubrics
							WHERE Id = '" . RUB_ID . "'
							LIMIT 1
						")->GetCell();
					}
					$rubTmpl = trim($rubTmpl);
					if (empty ($rubTmpl))
					{	// �� ����� ������ �������
						$main_content = $this->_rubric_template_empty;
					}
					else
					{
						// ������ ���� ����� � ������� ���������
						$main_content = $this->_parseDocTemplate($rubTmpl, $id);

						// ������� ��������� ���� �����
						$main_content = preg_replace('/\[cprub:\d*\]/', '', $main_content);

						if (CACHE_DOC_TPL)
						{	// ����������� ���������
							// ��������� ���������������� ������ � ���
							$AVE_DB->Query("
								INSERT " . PREFIX . "_rubric_template_cache
								SET
									rub_id   = '" . RUB_ID . "',
									grp_id   = '" . UGROUP . "',
									doc_id   = '" . $id . "',
									wysiwyg  = '" . (!empty ($_SESSION['user_adminmode']) ? 1 : 0) . "',
									compiled = '" . addslashes($main_content) . "'
							");
						}
					}
				}
			}
			$out = str_replace('[cp:maincontent]', $main_content, $this->_fetchMainTemplate(RUB_ID));
		}	// /����� ���������

		// �������� �� �������� ���� ��������� � ������� �� �� CSS
		if (isset ($_REQUEST['print']) && $_REQUEST['print'] == 1)
		{
			$out = str_replace(array('[cp:if_print]', '[/cp:if_print]'), '', $out);
			$out = preg_replace('/\[cp:donot_print\](.*?)\[\/cp:donot_print\]/si', '', $out);
		}
		else
		{
			$out = preg_replace('/\[cp:if_print\](.*?)\[\/cp:if_print\]/si', '', $out);
			$out = str_replace(array('[cp:donot_print]', '[/cp:donot_print]'), '', $out);
		}

		$match = '';
		//	// ��������� �� ������� ������������ ���� ����������
		//	preg_match('/\[cp_lang:([a-zA-Z]+)\]/', $out, $match);
		//	$_SESSION['lang'] = isset($match[1]) ? $match[1] : DEFAULT_LANGUAGE;
		//	$out = preg_replace('/\[cp_lang:(.*?)\]/', '', $out);

		// ��������� �� ������� �������� ���� �������
		preg_match('/\[theme_folder:(\w+)]/', $out, $match);
		define('THEME_FOLDER', empty ($match[1]) ? DEFAULT_THEME_FOLDER : $match[1]);
		$AVE_Template->assign('img_path', 'templates/' . THEME_FOLDER . '/images/');
		$out = preg_replace('/\[theme_folder:(.*?)]/', '', $out);

		// ������ ���� �������
		$this->parseModuleTag($out);

		// ��������� ������� �������������� ������ "�����������"
		if (isset ($this->install_modules['comment']))
		{
			$_SESSION['comments_enable'] = 1;
		}
		elseif (isset ($_SESSION['comments_enable']))
		{
			unset ($_SESSION['comments_enable']);
		}

		// ������ ���� ������� ���������� ��������
		$out = preg_replace_callback('/\[cprequest:(\d+)\]/', 'parseRequest', $out);
//		$out = preg_replace_callback('/\[cprequest:(\d+)\]/', array(&$this, 'cpParseRequest'), $out);

		// ������ ��������� ���� ��������� �������
		$search = array(
			'[cp:mediapath]',
			'[cp:pagename]',
			'[cp:document]',
			'[cp:home]',
			'[cp:keywords]',
			'[cp:description]',
			'[cp:indexfollow]'
		);

		$replace = array(
			'templates/' . THEME_FOLDER . '/',
			htmlspecialchars($AVE_Globals->mainSettings('site_name'), ENT_QUOTES),
			redirectLink('print'),
			homeLink(),
			(isset ($this->curentdoc->MetaKeywords) ? htmlspecialchars($this->curentdoc->MetaKeywords, ENT_QUOTES) : ''),
			(isset ($this->curentdoc->MetaDescription) ? htmlspecialchars($this->curentdoc->MetaDescription, ENT_QUOTES) : ''),
			(isset ($this->curentdoc->IndexFollow) ? $this->curentdoc->IndexFollow : '')
		);

		if (defined('MODULE_CONTENT'))
		{	// ������� ����� ��� ������ �� ������
			$search[] = '[cp:maincontent]';
			$replace[] = MODULE_CONTENT;
			$search[] = '[cp:title]';
			$replace[] = htmlspecialchars(defined('MODULE_SITE') ? MODULE_SITE : '', ENT_QUOTES);
		}
		else
		{
			$search[] = '[cp:title]';
			$replace[] = htmlspecialchars(prettyChars($this->curentdoc->Titel), ENT_QUOTES);
		}

		$search[] = '[cp:maincontent]';
		$replace[] = '';
		$search[] = '[cp:printlink]';
		$replace[] = printLink();
		$search[] = '[cp:version]';
		$replace[] = APP_INFO;
		$search[] = '[views]';
		$replace[] = isset ($this->curentdoc->Geklickt) ? $this->curentdoc->Geklickt : '';

		$out = str_replace($search, $replace, $out);
		unset ($search, $replace);
		// /������ ��������� ���� ��������� �������

		// ������� �����
		$out = stripslashes(hide($out));

		// ���
		$out = (CP_REWRITE == 1) ? cpRewrite($out) : $out;

		echo $out;
	}

	/**
	 * ���: ����� ��������� � ������ �������������� ���������� URL
	 *
	 */
	function parseUrl()
	{
		global $AVE_DB, $AVE_Globals;

		$get_url = $_GET['url'];

		if (substr($get_url, - strlen(URL_SUFF)) == URL_SUFF)
		{
			$get_url = substr($get_url, 0, - strlen(URL_SUFF));
		}
		$get_url = explode('/', $get_url);
		$get_url = array_combine($get_url, $get_url);
		if (isset ($get_url['index']))
		{
			unset ($get_url['index']);
		}

		if (isset ($get_url['print']))
		{
			$_REQUEST['print'] = 1;
			unset ($get_url['print']);
		}

		$pages = preg_grep('/^(a|art)?page-\d+$/i', $get_url);
		if (!empty ($pages))
		{
			$get_url = implode('/', array_diff($get_url, $pages));
			$pages = implode('/', $pages);

			preg_replace_callback('/(page|apage|artpage)-(\d+)/i', create_function('$matches', '$_REQUEST[$matches[1]] = $matches[2];'), $pages);
		}
		else
		{
			$get_url = implode('/', $get_url);
		}

		unset ($pages);

		$sql = $AVE_DB->Query("
			SELECT
				doc.*,
				Rechte,
				RubrikTemplate,
				Template
			FROM
				" . PREFIX . "_documents AS doc
			JOIN
				" . PREFIX . "_rubrics AS rub
					ON rub.Id = doc.RubrikId
			JOIN
				" . PREFIX . "_templates AS tpl
					ON tpl.Id = Vorlage
			JOIN
				" . PREFIX . "_document_permissions AS prm
					ON doc.RubrikId = prm.RubrikId
			WHERE
				BenutzerGruppe = '" . UGROUP . "'
			AND
				" . (!empty ($get_url) ? "Url = '" . $get_url . "'" : "doc.Id = 1") . "
			LIMIT 1
		");

		if ($this->curentdoc = $sql->FetchRow())
		{
			$_REQUEST['id'] = $_GET['id'] = $_POST['id'] = $this->curentdoc->Id;
			$_REQUEST['doc'] = $_GET['doc'] = $_POST['doc'] = $this->curentdoc->Url;
		}
		else
		{
			$_REQUEST['id'] = $_GET['id'] = $_POST['id'] = PAGE_NOT_FOUND_ID;
		}
	}

/**
 *	���������� ������
 */

	/**
	 * ������� ������� ���������
	 *
	 * @param string $rub_template ������
	 * @return string
	 */
	function _parseDocTemplate(& $rub_template)
	{
		require_once (BASE_DIR . '/functions/func.parsefields.php');
		return preg_replace_callback('/\[cprub:(\d+)\]/', 'parseFields', $rub_template);
	}

	/**
	 * �������� ������ ������
	 *
	 * @return string
	 */
	function _fetchModuleTemplate()
	{
		global $AVE_DB;

		if (!is_dir(BASE_DIR . '/modules/' . $_REQUEST['module']))
		{
			echo '<meta http-equiv="Refresh" content="2;URL=index.php" />';
			$fetched = $this->_module_not_found;
		}
		else
		{
			$fetched = $AVE_DB->Query("
				SELECT tmpl.Template
				FROM " . PREFIX . "_templates AS tmpl
				LEFT JOIN " . PREFIX . "_module AS mdl ON tmpl.Id = mdl.Template
				WHERE ModulPfad = '" . $_REQUEST['module'] . "'
			")->GetCell();
			if (empty ($fetched))
			{
				$fetched = $AVE_DB->Query("
					SELECT Template
					FROM " . PREFIX . "_templates
					WHERE Id = 1
					LIMIT 1
				")->GetCell();
			}
		}

		return $fetched;
	}

	/**
	 * �������� �������� ������ ��������
	 *
	 * @param int $rub_id ������������� �������
	 * @param string $template ������
	 * @param string $fetched ������ ������
	 * @return string
	 */
	function _fetchMainTemplate($rubrik_id = '', $template = '', $fetched = '')
	{
		global $AVE_DB;

		if (defined('ONLYCONTENT') || (isset ($_REQUEST['pop']) && $_REQUEST['pop'] == 1))
		{
			$out = '[cp:maincontent]';
		}
		else
		{
			if (!empty ($fetched))
			{
				$out = $fetched;
			}
			else
			{
				if (!empty ($template))
				{
					$out = $template;
				}
				else
				{
					if (!empty ($this->curentdoc->Template))
					{
						$out = stripslashes($this->curentdoc->Template);
					}
					else
					{
						if (empty ($rubrik_id))
						{
							if (empty ($_REQUEST['id']) || !is_numeric($_REQUEST['id']))
								$_REQUEST['id'] = 1;
							$rub_id = $AVE_DB->Query("
								SELECT RubrikId
								FROM " . PREFIX . "_documents
								WHERE Id = '" . $_REQUEST['id'] . "'
								LIMIT 1
							")->GetCell();
							$rubrik_id = ($rub_id) ? $rub_id : '';
						}
						$tpl = $AVE_DB->Query("
							SELECT Template
							FROM " . PREFIX . "_templates AS tpl
							LEFT JOIN " . PREFIX . "_rubrics AS rub ON tpl.Id = Vorlage
							WHERE rub.Id = '" . $rubrik_id . "'
							LIMIT 1
						")->GetCell();
						$out = $tpl ? stripslashes($tpl) : '';
					}
				}
			}
		}

		return $out;
	}

	/**
	 * ������������ ���� ������� � ���������� �������
	 *
	 * @param int $rub_id ������������� �������
	 */
	function _fetchDocPerms($rub_id = '')
	{
		global $AVE_DB;

		unset ($_SESSION[$rub_id . '_docread']);
		if (!empty ($this->curentdoc->Rechte))
		{
			$Rechte = explode('|', $this->curentdoc->Rechte);
			foreach ($Rechte as $perm)
			{
				if (!empty ($perm))
					$_SESSION[$rub_id . '_' . $perm] = 1;
			}
		}
		else
		{
			$sql = $AVE_DB->Query("
				SELECT Rechte
				FROM " . PREFIX . "_document_permissions
				WHERE RubrikId = '" . $rub_id . "'
				AND BenutzerGruppe = '" . UGROUP . "'
			");
			while ($row = $sql->FetchRow())
			{
				$row->Rechte = explode('|', $row->Rechte);
				foreach ($row->Rechte as $perm)
				{
					if (!empty ($perm))
						$_SESSION[$rub_id . '_' . $perm] = 1;
				}
			}
		}
	}

	/**
	 * ��������� ������� 404 Not Found
	 *
	 * @return unknown
	 */
	function _notFound()
	{
		global $AVE_DB;

		$available = $AVE_DB->Query("
			SELECT COUNT(*)
			FROM " . PREFIX . "_documents
			WHERE Id = '" . PAGE_NOT_FOUND_ID . "'
			LIMIT 1
		")->GetCell();

		if ($available)
		{
			header('Location:index.php?id=' . PAGE_NOT_FOUND_ID);
		}
		else
		{
			echo $this->_doc_not_found;
		}
		exit;
	}

	/**
	 * ��������� ����� �������
	 * ������������ ����� ������� ���� ������� ���������� � �������
	 * ��������� ������ ���� ������������� ������� �������� �� �����������
	 *
	 * @param string $template ����� ������� � ������
	 * @return string ����� ������� � ������������� ������ �������
	 */
	function parseModuleTag(&$template)
	{
		global $AVE_DB;

		$pattern = $replace = array();
		if (!empty($this->install_modules))
		{
			foreach ($this->install_modules as $row_module)
			{
				if ((isset($_REQUEST['module']) && $_REQUEST['module'] == $row_module->ModulPfad) ||
					(1 == $row_module->IstFunktion && 1 == preg_match($row_module->CpEngineTag, $template)))
				{	// ��������� ������ ��� � ������ ���� ������� ���������� ����� �������������� � �������
					if (function_exists($row_module->ModulFunktion))
					{
						$pattern[] = $row_module->CpEngineTag;
						$replace[] = $row_module->CpPHPTag;
					}
					else
					{
						if (include_once(BASE_DIR . '/modules/' . $row_module->ModulPfad . '/modul.php'))
						{	// ���� ������ ����
							if ($row_module->CpEngineTag)
							{
								$pattern[] = $row_module->CpEngineTag;
								$replace[] = function_exists($row_module->ModulFunktion)
									? $row_module->CpPHPTag
									: ($this->_module_error . ' &quot;' . $row_module->ModulName . '&quot;');
							}
						}
						else
						{	// ����� ������ ��� - ��������
							if ($row_module->CpEngineTag)
							{
								$pattern[] = $row_module->CpEngineTag;
								$replace[] = $this->_module_error . ' &quot;' . $row_module->ModulName . '&quot;';
							}
						}
						unset($modul);
					}
				}
			}
			$template = preg_replace($pattern, $replace, $template);
		}
		else
		{
			$sql_module = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX. "_module
				WHERE Status = 1
			");
//			$install_modules = array();
			while ($row_module = $sql_module->FetchRow())
			{
				if ((isset($_REQUEST['module']) && $_REQUEST['module'] == $row_module->ModulPfad) ||
					(1 == $row_module->IstFunktion && 1 == preg_match($row_module->CpEngineTag, $template)))
				{	// ��������� ������ ��� � ������ ���� ������� ���������� ����� �������������� � �������
					if (include_once(BASE_DIR . '/modules/' . $row_module->ModulPfad . '/modul.php'))
					{	// ���� ������ ����
						if ($row_module->CpEngineTag)
						{
							$pattern[] = $row_module->CpEngineTag;
							$replace[] = function_exists($row_module->ModulFunktion)
								? $row_module->CpPHPTag
								: ($this->_module_error . ' &quot;' . $row_module->ModulName . '&quot;');
						}
						$this->install_modules[$row_module->ModulPfad] = $row_module;
					}
					else
					{	// ����� ������ ��� - ��������
						if ($row_module->CpEngineTag)
						{
							$pattern[] = $row_module->CpEngineTag;
							$replace[] = $this->_module_error . ' &quot;' . $row_module->ModulName . '&quot;';
						}
					}
//					unset($modul);
				}
				else
				{	// � ������ ��� ������� ��� ��� ������ �� ������������ - ������ �������� � ������ ���������� � ������
					$this->install_modules[$row_module->ModulPfad] = $row_module;
				}
			}
			$template = preg_replace($pattern, $replace, $template);
		}
	}
}

?>