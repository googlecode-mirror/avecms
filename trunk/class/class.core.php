<?php

/**
 * AVE.cms
 *
 * �����, ��������������� ��� ����� � ������������ ����� �������� ����� ������� � ��������� �����.
 * ����������, ������ ����� �������� ����� �������, �� ������� ������� ������ �������� �� ��������� �����������,
 * ������ ��������� ����� ���������������� ���������, � ����� ������ url ���������� � ����� ���������� �� url.
 *
 *
 * @package AVE.cms
 * @filesource
 */

class AVE_Core
{

/**
 *	�������� ������
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
	 * ��������� �� ������, ���� �������� �� ������
	 *
	 * @var string
	 */
	var $_doc_not_found = '<center><h1>HTTP Error 404: Page not found</h1></center>';

	/**
	 * ��������� �� ������, ���� ��� ������� �� ������ ������
	 *
	 * @var string
	 */
	var $_rubric_template_empty = '<h1>������</h1><br />�� ����� ������ �������.';

	/**
	 * ��������� �� ������, ���� �������� �������� � ������
	 *
	 * @var string
	 */
	var $_doc_not_published = '������������� �������� �������� � ����������.';

	/**
	 * ��������� �� ������, ���� ������ �� ����� ���� ��������
	 *
	 * @var string
	 */
	var $_module_error = '������������� ������ �� ����� ���� ��������.';

	/**
	 * ��������� �� ������, ���� ������, ��������� � �������, �� ���������� � �������
	 *
	 * @var string
	 */
	var $_module_not_found = '������������� ������ �� ������.';

/**
 *	���������� ������ ������
 */

	/**
	 * �����, ��������������� ��� ��������� ��������
	 *
	 * @param int $rubrik_id ������������� �������
	 * @param string $template ������
	 * @param string $fetched ������ ������
	 * @return string
	 */
	function _coreDocumentTemplateGet($rubrik_id = '', $template = '', $fetched = '')
	{
		global $AVE_DB;

		// ���� ��������� ������ ���������� ������ ��� ��� ����� ���� (�������� �������� ��� ������),
        // ������ ���������� ����������.
        if (defined('ONLYCONTENT') || (isset ($_REQUEST['pop']) && $_REQUEST['pop'] == 1))
		{
			$out = '[tag:maincontent]';
		}
		else
		{
			// � ��������� ������, ���� � �������� ��������� ������� ������ ������, ���������� ���.
            if (!empty ($fetched))
			{
				$out = $fetched;
			}
			else
			{
				// � ��������� ������, ���� � �������� ��������� ������� ����� ������, ���������� ���
                if (!empty ($template))
				{
					$out = $template;
				}
				else // � ��������� ������, ���� ��������� �� ����������, ����� ���������
				{
					// ���� ��� �������� ��������� � �������� ������ $this->curentdoc ��������� ������, ����� ���������� ���
                    if (!empty ($this->curentdoc->template_text))
					{
						$out = stripslashes($this->curentdoc->template_text);
					}
					else
					{
    					// � ��������� ������, ���� �� ������ ������������� �������
                        if (empty ($rubrik_id))
						{
							// �������� id ��������� �� �������
                            $_REQUEST['id'] = (isset ($_REQUEST['id']) && is_numeric($_REQUEST['id'])) ? $_REQUEST['id'] : 1;

							// ��������� ������ � �� �� ��������� id ������� �� ��������� id ���������
                            $rubrik_id = $AVE_DB->Query("
								SELECT rubric_id
								FROM " . PREFIX . "_documents
								WHERE Id = '" . $_REQUEST['id'] . "'
								LIMIT 1
							")->GetCell();

							// ���� id ������� �� ������, ���������� ������ ������
                            if (!$rubrik_id) return '';
						}

						// ��������� ������ � �� �� ��������� ��������� �������, � ����� ������� �������
                        $tpl = $AVE_DB->Query("
							SELECT template_text
							FROM " . PREFIX . "_templates AS tpl
							LEFT JOIN " . PREFIX . "_rubrics AS rub ON tpl.Id = rubric_template_id
							WHERE rub.Id = '" . $rubrik_id . "'
							LIMIT 1
						")->GetCell();

						// ���� ������ ���������� � ������� �����������, ���������� ������ ������
                        $out = $tpl ? $tpl : '';
					}
				}
			}
		}

		return $out;
	}

	/**
	 * �����, ��������������� ��� ��������� ������� ������
	 *
	 * @return string
	 */
	function _coreModuleTemplateGet()
	{
		global $AVE_DB;

		// ���� �����, � ������������� ������� �� ����������, ��������� ��������
        // �� ������� �������� � ���������� ��������� � �������
        if (!is_dir(BASE_DIR . '/modules/' . $_REQUEST['module']))
		{
			echo '<meta http-equiv="Refresh" content="2;URL=' . get_home_link() . '" />';
			$out = $this->_module_not_found;
		}
		// � ��������� ������
        else
		{
			// ��������� ������ � �� �� ��������� ������ ����� �������� ��������� � �������
            // � �������, ������� ���������� ��� ������� ������
            // ��������, � ������� ���� ������� Template_1 � Template_2, � ��� ������ ���������� Template_3
            $out = $AVE_DB->Query("
				SELECT tmpl.template_text
				FROM " . PREFIX . "_templates AS tmpl
				LEFT JOIN " . PREFIX . "_module AS mdl ON tmpl.Id = mdl.Template
				WHERE ModulPfad = '" . $_REQUEST['module'] . "'
			")->GetCell();

			// ���� ������, ������������� ��� ������ �� ������ � �������, ������������� ������������� ��� ����
            // ������ ������ (id=1)
            if (empty ($out))
			{
				$out = $AVE_DB->Query("
					SELECT template_text
					FROM " . PREFIX . "_templates
					WHERE Id = '1'
					LIMIT 1
				")->GetCell();
			}
		}
        // ���������� ���������� � ���������� �������
		return $out;
	}

	/**
	 * �����, ��������������� ��� ��������� ���� ������� � ���������� �������
	 *
	 * @param int $rubrik_id ������������� �������
	 */
	function _coreRubricPermissionFetch($rubrik_id = '')
	{
		global $AVE_DB;

		unset ($_SESSION[$rubrik_id . '_docread']);

		// ���� ��� ��������� ��� �������� ����� �������, �����
        if (!empty ($this->curentdoc->rubric_permission))
		{
			// ��������� ������ � ������� �������
            $rubric_permissions = explode('|', $this->curentdoc->rubric_permission);

            // ���������� ������������ �������������� ������ � ������� � ������ �������������� ����������
            foreach ($rubric_permissions as $rubric_permission)
			{
				if (!empty ($rubric_permission))
				{
					$_SESSION[$rubrik_id . '_' . $rubric_permission] = 1;
				}
			}
		} // � ��������� ������
		else
		{
			// ��������� ������ � �� �� ��������� ������ ���� ��� ������� ���������
            $sql = $AVE_DB->Query("
				SELECT rubric_permission
				FROM " . PREFIX . "_rubric_permissions
				WHERE rubric_id = '" . $rubrik_id . "'
				AND user_group_id = '" . UGROUP . "'
			");

			// ������������ ���������� ������ � ������� � ������ �������������� ����������
            while ($row = $sql->FetchRow())
			{
				$row->rubric_permission = explode('|', $row->rubric_permission);
				foreach ($row->rubric_permission as $rubric_permission)
				{
					if (!empty ($rubric_permission))
					{
						$_SESSION[$rubrik_id . '_' . $rubric_permission] = 1;
					}
				}
			}
		}
	}

	/**
	 * �����, ��������������� ��� ��������� ������� 404 Not Found, �.�. ����� �������� �� �������.
	 *
	 * @return unknown
	 */
	function _coreErrorPage404()
	{
		global $AVE_DB;

		// ��������� ������ � �� �� �������� ������������� ��������, ������� �������� ���������� � ���, ���
        // ������������� �������� �� �������
        $available = $AVE_DB->Query("
			SELECT COUNT(*)
			FROM " . PREFIX . "_documents
			WHERE Id = '" . PAGE_NOT_FOUND_ID . "'
			LIMIT 1
		")->GetCell();

		// ���� ����� �������� � �� ����������, ��������� ������� �� �������� � �������
        if ($available)
		{
			header('Location:' . ABS_PATH . 'index.php?id=' . PAGE_NOT_FOUND_ID);
		}
		// ���� �� ����������, ����� ������ ������� �����, ������������ � �������� _doc_not_found
        else
		{
			echo $this->_doc_not_found;
		}

		exit;
	}

	/**
	 * �����, ��������������� ��� ������������ ���� ��������
	 *
	 * @return string
	 */
	function _get_cache_hash()
	{
		$hash  = 'g-' . UGROUP;
		$hash .= 'r-' . RUB_ID;
		$hash .= 'u-' . get_redirect_link();

		return md5($hash);
	}

    /**
     * �����, ��������������� ��� �������� ������������� ��������� � ��
     *
     * @param int $document_id - id ���������
     * @param int $user_group - ������ ������������
     * @return boolean
     */
    function _coreCurrentDocumentFetch($document_id = 1, $user_group = 2)
	{
		global $AVE_DB;

        // ��������� ���������  ������ � �� �� ��������� ���������� � ������������� ���������
		$this->curentdoc = $AVE_DB->Query("
			SELECT
				doc.*,
				rubric_permission,
				rubric_template,
				template_text
			FROM
				" . PREFIX . "_documents AS doc
			JOIN
				" . PREFIX . "_rubrics AS rub
					ON rub.Id = doc.rubric_id
			JOIN
				" . PREFIX . "_templates AS tpl
					ON tpl.Id = rubric_template_id
			JOIN
				" . PREFIX . "_rubric_permissions AS prm
					ON doc.rubric_id = prm.rubric_id
			WHERE
				user_group_id = '" . $user_group . "'
			AND
				doc.Id = '" . $document_id . "'
			LIMIT 1
		")->FetchRow();

		// ���������� 1, ���� �������� ������, ���� 0 � ��������� ������
        return (isset($this->curentdoc->Id) && $this->curentdoc->Id == $document_id);
	}

    /**
     * �����, ��������������� ��� ��������� ����������� �������� � 404 �������
     *
     *
     * @param int $page_not_found_id
     * @param int $user_group
     * @return int/boolean
     */
    function _corePageNotFoundFetch($page_not_found_id = 2, $user_group = 2)
	{
		global $AVE_DB;

		// ��������� ������ � �� �� ��������� ������ ���������� � �������� � 404 �������, �������
        // ����� �������, ������ ������� � �������� ������ �����
        $this->curentdoc = $AVE_DB->Query("
			SELECT
				doc.*,
				rubric_permission,
				rubric_template,
				template_text
			FROM
				" . PREFIX . "_documents AS doc
			JOIN
				" . PREFIX . "_rubrics AS rub
					ON rub.Id = doc.rubric_id
			JOIN
				" . PREFIX . "_templates AS tpl
					ON tpl.Id = rubric_template_id
			JOIN
				" . PREFIX . "_rubric_permissions AS prm
					ON doc.rubric_id = prm.rubric_id
			WHERE
				user_group_id = '" . $user_group . "'
			AND
				doc.Id = '" . $page_not_found_id . "'
			LIMIT 1
		")->FetchRow();

		return (isset($this->curentdoc->Id) && $this->curentdoc->Id == $page_not_found_id);
	}

    /**
     * �����, ��������������� ��� ��������� ����-����� ��� ��������� �������.
     * ����-���� ��� ������ �������
     *
     * @return boolean
     */
    function _coreModuleMetatagsFetch()
	{
		global $AVE_DB;

        // ���� � ������� �� ������ �������� module, ��������� ������
		if (! isset($_REQUEST['module'])) return false;

		// ���� � ������� ������ �������� shop, ��� ��������� module � �� ������ id ������, �����
        if ($_REQUEST['module'] == 'shop' && empty ($_REQUEST['product_id']))
		{
			// ��������� ������ � �� �� ��������� ����� �������� ����-�����, ������������� � ���������� ������ "�������"
            $this->curentdoc = $AVE_DB->Query("
				SELECT
					1 AS Id,
					0 AS document_published,
					a.document_meta_robots,
					b.ShopKeywords AS document_meta_keywords,
					b.ShopDescription AS document_meta_description
		        FROM
		        	" . PREFIX . "_documents AS a,
		        	" . PREFIX . "_modul_shop AS b
		        WHERE a.Id = 1
		        AND b.Id = 1
			")->FetchRow();
		}
		// � ��������� ������, ���� ������������ ������ "�������" � ������ id ������, �����
        elseif ($_REQUEST['module'] == 'shop' && !empty ($_REQUEST['product_id']) && is_numeric($_REQUEST['product_id']))
		{
			// ��������� ������ � �� � �������� �������� ����-����� ��� ����������� ������
            $this->curentdoc = $AVE_DB->Query("
				SELECT
					1 AS Id,
					0 AS document_published,
					a.document_meta_robots,
					b.ProdKeywords AS document_meta_keywords,
					b.ProdDescription AS document_meta_description
				FROM
					" . PREFIX . "_documents AS a,
					" . PREFIX . "_modul_shop_artikel AS b
				WHERE a.Id = 1
				AND b.Id = '" . $_REQUEST['product_id'] . "'
			")->FetchRow();
		}
		// ���� � ������� ������ �� ������, �������� ����� ����-����, ������������� ��� ������� (id=1) �������� �����
        else
		{
			$this->curentdoc = $AVE_DB->Query("
				SELECT
					1 AS Id,
					0 AS document_published,
					document_meta_robots,
					document_meta_keywords,
					document_meta_description,
					document_title
				FROM " . PREFIX . "_documents
				WHERE Id = 1
			")->FetchRow();
		}

		return (isset($this->curentdoc->Id) && $this->curentdoc->Id == 1);
	}

    /**
     * �����, ��������������� ��� ����������� ������� ��������� (�������� �� �� � ����������).
     *
     * @return int/boolean
     */
    function _coreDocumentIsPublished()
	{
		if (!empty ($this->curentdoc)																				// �������� ����
			&& $this->curentdoc->Id != PAGE_NOT_FOUND_ID															// �������� �� ��������� ������ 404
			&& ( $this->curentdoc->document_status != 1																// ������ ���������
				|| $this->curentdoc->document_deleted == 1															// ������� ��������
				|| ( get_settings('use_doctime')																	// ����� ���������� �������������� � ...
					&& ($this->curentdoc->document_expire != 0 && $this->curentdoc->document_expire < time())		// ����� ���������� �� ���������
					|| ($this->curentdoc->document_published != 0 && $this->curentdoc->document_published > time())	// ����� ���������� �������
					)
				)
			)
		{
			// ���� ������������ ����������� � ������ ���������� ��� ����� ������ ����� �� �������� ���������, �����
            if (isset ($_SESSION['adminpanel']) || isset ($_SESSION['alles']))
			{
				// ���������� �������������� ���� � ����������, ������������ � �������� _doc_not_published
                display_notice($this->_doc_not_published);
			}
	        else // � ��������� ������ ��������� ������
			{
				$this->curentdoc = false;
			}
		}

		return (! empty($this->curentdoc));
	}

/**
 *	������� ������ ������
 */

	/**
	 * �����, ��������������� ��� ��������� ��������� ����� �������. ����� ������������ ������ �� ����� �������,
	 * ��������� ���� ������� ���������� � ������� ��� ��������. ����� ��������� ������ ���� ������������� �������
     * � �������, �������������� �������� �� �����������.
	 *
	 * @param string $template ����� ������� � ������
	 * @return string ����� ������� � ������������� ������ �������
	 */
	function coreModuleTagParse($template)
	{
		global $AVE_DB, $AVE_Template;

		$pattern = array();  // ������ ��������� �����
		$replace = array();  // ������ �������, �� ������� ����� �������� ��������� ����

		// ���� ��� ������� ������ �� ������������� �������
        if (null !== $this->install_modules)
		{
			// ���������� ������������ ������ ������
            foreach ($this->install_modules as $row)
			{
				// ���� � ������� ������ ����� ������ ��� � ������ ���� ������� ���������� �����,
                // ������� ������������ � �������
                if ((isset($_REQUEST['module']) && $_REQUEST['module'] == $row->ModulPfad) ||
					(1 == $row->IstFunktion && !empty($row->CpEngineTag) && 1 == preg_match($row->CpEngineTag, $template)))
				{
					// ���������, ���������� �� ��� ������� ������ �������. ���� ��,
                    // �������� php ��� �������.
                    if (function_exists($row->ModulFunktion))
					{
						$pattern[] = $row->CpEngineTag;
						$replace[] = $row->CpPHPTag;
					}
					else // � ��������� ������
					{
						// ���������, ���������� �� ��� ������� ������ ���� modul.php � ��� ������������ ����������
						$mod_file = BASE_DIR . '/modules/' . $row->ModulPfad . '/modul.php';
                        if (is_file($mod_file) && include_once($mod_file))
						{
							// ���� ���� ������ ������, �����
                            if ($row->CpEngineTag)
							{
								$pattern[] = $row->CpEngineTag;  // �������� ��� ��������� ���

                                // ���������, ���������� �� ��� ������� ������ �������. ���� ��,
                                // �������� php ��� �������, � ��������� ������ ��������� ��������� � �������
                                $replace[] = function_exists($row->ModulFunktion)
									? $row->CpPHPTag
									: ($this->_module_error . ' &quot;' . $row->ModulName . '&quot;');
							}
						}
						// ���� ����� modul.php �� ����������, ��������� ��������� � �������
                        elseif ($row->CpEngineTag)
						{	$pattern[] = $row->CpEngineTag;
							$replace[] = $this->_module_error . ' &quot;' . $row->ModulName . '&quot;';
						}
					}
				}
			}

			// ��������� ������ ��������� ���� �� php ��� � ���������� ���������
            return preg_replace($pattern, $replace, $template);
		}
		else  // � ��������� ������, ���� ������ ������� ������
		{
			$this->install_modules = array();

            // ��������� ������ � �� �� ��������� ���������� � ���� �������, ������� ����������� � �������
            // (������ �����������, � �� ������ ���������� � ���� �����)
			$sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX. "_module
				WHERE Status = '1'
			");

            // ���������� ������������ ���������� ������
            while ($row = $sql->FetchRow())
			{
				// ���� � ������� ������ �������� module � ��� ������� �������� ������ ����������
                // ���������� ��� ������ ������ ����� ������� � ��� ��������� ��� ������ � �����-���� �������, �����
                if ((isset($_REQUEST['module']) && $_REQUEST['module'] == $row->ModulPfad) ||
					(1 == $row->IstFunktion && !empty($row->CpEngineTag) && 1 == preg_match($row->CpEngineTag, $template)))
				{
					// ���������, ���������� �� ��� ������� ������ ���� modul.php � ��� ������������ ����������
					$mod_file = BASE_DIR . '/modules/' . $row->ModulPfad . '/modul.php';
                    if (is_file($mod_file) && include_once($mod_file))
					{	// ���� ���� ������ ������, �����
						if (!empty($row->CpEngineTag))
						{
							$pattern[] = $row->CpEngineTag;  // �������� ��� ��������� ���

                            // ���������, ���������� �� ��� ������� ������ �������. ���� ��,
                            // �������� php ��� �������, � ��������� ������ ��������� ��������� � �������
                            $replace[] = function_exists($row->ModulFunktion)
								? $row->CpPHPTag
								: ($this->_module_error . ' &quot;' . $row->ModulName . '&quot;');
						}
						// ��������� ���������� � ������
                        $this->install_modules[$row->ModulPfad] = $row;
					}
					elseif ($row->CpEngineTag) // ���� ����� modul.php �� ����������, ��������� ��������� � �������
					{
                        $pattern[] = $row->CpEngineTag;
						$replace[] = $this->_module_error . ' &quot;' . $row->ModulName . '&quot;';
					}
				}
				else
				{	// ���� � ������ ��� ������� ��� ��� ������ �� ������������ - ������ �������� � ������ ���������� � ������
					$this->install_modules[$row->ModulPfad] = $row;
				}
			}
            // ��������� ������ ��������� ���� �� php ��� � ���������� ���������
			return preg_replace($pattern, $replace, $template);
		}
	}

	/**
	 * �����, ��������������� ��� ������ ���� �������� � ������ �����.
	 *
	 * @param int $id ������������� ���������
	 * @param int $rub_id ������������� �������
	 */
	function coreSiteFetch($id, $rub_id = '')
	{
		global $AVE_DB;

		// ���� ���������� ����� ������, �������� ��������������� ����-���� � �������� ������ ������
        if (!empty ($_REQUEST['module'])) {
			$out = $this->_coreModuleMetatagsFetch();
            $out = $this->_coreDocumentTemplateGet('', '', $this->_coreModuleTemplateGet());
		}
		else // � ��������� ������ �������� ����� ���������
		{
            if (! isset($this->curentdoc->Id) && ! $this->_coreCurrentDocumentFetch($id, UGROUP))
			{
				// ���������� �������� � 404 �������, � ������, ���� �������� �� ������
                if ($this->_corePageNotFoundFetch(PAGE_NOT_FOUND_ID, UGROUP))
				{
					$_REQUEST['id'] = $_GET['id'] = $id = PAGE_NOT_FOUND_ID;
				}
			}

			// ��������� ��������� ���������� ���������
			if (! $this->_coreDocumentIsPublished())
			{
				$this->_coreErrorPage404();
			}

			// ���������� ����� ������� � ���������� �������
			define('RUB_ID', !empty ($rub_id) ? $rub_id : $this->curentdoc->rubric_id);
			$this->_coreRubricPermissionFetch(RUB_ID);

			if (! ((isset ($_SESSION[RUB_ID . '_docread']) && $_SESSION[RUB_ID . '_docread'] == 1)
				|| (isset ($_SESSION[RUB_ID . '_alles']) && $_SESSION[RUB_ID . '_alles'] == 1)) )
			{	// ������ ��������� - ��������� ������������ � ����� ������ ��������
				$main_content = get_settings('message_forbidden');
			}
			else
			{
				if (isset ($_REQUEST['print']) && $_REQUEST['print'] == 1)
				{	// ����������� ������� ������ ��� ������
					$AVE_DB->Query("
						UPDATE " . PREFIX . "_documents
						SET document_count_print = document_count_print+1
						WHERE Id = '" . $id . "'
					");
				}
				else
				{
					if (!isset ($_SESSION['doc_view[' . $id . ']']))
					{	// ����������� ������� ���������� (1 ��� � �������� ������)
						$AVE_DB->Query("
							UPDATE " . PREFIX . "_documents
							SET document_count_view = document_count_view+1
							WHERE Id = '" . $id . "'
						");
						$_SESSION['doc_view[' . $id . ']'] = 1;
					}
				}

				if (CACHE_DOC_TPL && empty ($_POST) && !(isset ($_SESSION['user_adminmode']) && $_SESSION['user_adminmode'] == 1))
				{	// ����������� ���������
					// ��������� ���������������� ������ ��������� �� ����
					$main_content = $AVE_DB->Query("
						SELECT compiled
						FROM " . PREFIX . "_rubric_template_cache
						WHERE hash  = '" . $this->_get_cache_hash() . "'
						LIMIT 1
					")->GetCell();
				}
				else
				{	// ����������� ���������
					$main_content = false;
				}

				if (empty ($main_content))
				{	// ��� ������ ��� ��������, ��������� � ����������� ������
					if (!empty ($this->curentdoc->rubric_template))
					{
						$rubTmpl = $this->curentdoc->rubric_template;
					}
					else
					{
						$rubTmpl = $AVE_DB->Query("
							SELECT rubric_template
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
						$main_content = preg_replace_callback('/\[tag:fld:(\d+)\]/', 'document_get_field', $rubTmpl);

						// ������� ��������� ���� �����
						$main_content = preg_replace('/\[tag:fld:\d*\]/', '', $main_content);

						if (CACHE_DOC_TPL && empty ($_POST) && !(isset ($_SESSION['user_adminmode']) && $_SESSION['user_adminmode'] == 1))
						{	// ����������� ���������
							// ��������� ���������������� ������ � ���
							$AVE_DB->Query("
								INSERT " . PREFIX . "_rubric_template_cache
								SET
									hash     = '" . $this->_get_cache_hash() . "',
									rub_id   = '" . RUB_ID . "',
									grp_id   = '" . UGROUP . "',
									doc_id   = '" . $id . "',
									compiled = '" . addslashes($main_content) . "'
							");
						}
					}
				}
				$main_content = str_replace('[tag:docdate]', pretty_date(strftime(DATE_FORMAT, $this->curentdoc->document_published)), $main_content);
				$main_content = str_replace('[tag:doctime]', pretty_date(strftime(TIME_FORMAT, $this->curentdoc->document_published)), $main_content);
				$main_content = str_replace('[tag:docauthor]', get_username_by_id($this->curentdoc->document_author_id), $main_content);
			}
			$out = str_replace('[tag:maincontent]', $main_content, $this->_coreDocumentTemplateGet(RUB_ID));
		}	// /����� ���������

		// ���� � ������� ������ �������� print, �.�. �������� ��� ������, ������ �������, ������� ��������
        // ������ ������ ��� ������
		if (isset ($_REQUEST['print']) && $_REQUEST['print'] == 1)
		{
			$out = str_replace(array('[tag:if_print]', '[/tag:if_print]'), '', $out);
			$out = preg_replace('/\[tag:if_notprint\](.*?)\[\/tag:if_notprint\]/si', '', $out);
		}
		else
		{
			// � ��������� ������ ��������, ������ ������ ��� �������, ������� ������������ �� ��� ������
            $out = preg_replace('/\[tag:if_print\](.*?)\[\/tag:if_print\]/si', '', $out);
			$out = str_replace(array('[tag:if_notprint]', '[/tag:if_notprint]'), '', $out);
		}

		// �������� �� ������� ��������� ���, ������������ �������� ���� �������
		$match = '';
		preg_match('/\[tag:theme:(\w+)]/', $out, $match);
		define('THEME_FOLDER', empty ($match[1]) ? DEFAULT_THEME_FOLDER : $match[1]);
		$out = preg_replace('/\[tag:theme:(.*?)]/', '', $out);

		// ������ ���� �������
		$out = $this->coreModuleTagParse($out);

		if ( isset($_REQUEST['module'])
			&& ! (isset($this->install_modules[$_REQUEST['module']])
				&& '1' == $this->install_modules[$_REQUEST['module']]->Status) )
		{
			display_notice($this->_module_error);
		}

		// ������ ���� ������� ���������� ��������
		$out = preg_replace_callback('/\[tag:request:(\d+)\]/', 'request_parse', $out);

		// ������ ���� �������� ������
		$out = parse_hide($out);

		// ������ ��������� ���� ��������� �������
		$search = array(
			'[tag:mediapath]',
			'[tag:path]',
			'[tag:sitename]',
			'[tag:document]',
			'[tag:home]',
			'[tag:keywords]',
			'[tag:description]',
			'[tag:robots]',
			'[tag:docid]'
		);

		$replace = array(
			ABS_PATH . 'templates/' . THEME_FOLDER . '/',
			ABS_PATH,
			htmlspecialchars(get_settings('site_name'), ENT_QUOTES),
			get_redirect_link('print'),
			get_home_link(),
			(isset ($this->curentdoc->document_meta_keywords) ? htmlspecialchars($this->curentdoc->document_meta_keywords, ENT_QUOTES) : ''),
			(isset ($this->curentdoc->document_meta_description) ? htmlspecialchars($this->curentdoc->document_meta_description, ENT_QUOTES) : ''),
			(isset ($this->curentdoc->document_meta_robots) ? $this->curentdoc->document_meta_robots : ''),
			(isset ($this->curentdoc->Id) ? $this->curentdoc->Id : '')
		);

		if (defined('MODULE_CONTENT'))
		{	// ������� ����� ��� ������ �� ������
			$search[] = '[tag:maincontent]';
			$replace[] = MODULE_CONTENT;
			$search[] = '[tag:title]';
			$replace[] = htmlspecialchars(defined('MODULE_SITE') ? MODULE_SITE : '', ENT_QUOTES);
		}
		else
		{
			$search[] = '[tag:title]';
			$replace[] = htmlspecialchars(pretty_chars($this->curentdoc->document_title), ENT_QUOTES);
		}

		$search[] = '[tag:maincontent]';
		$replace[] = '';
		$search[] = '[tag:printlink]';
		$replace[] = get_print_link();
		$search[] = '[tag:version]';
		$replace[] = APP_INFO;
		$search[] = '[tag:docviews]';
		$replace[] = isset ($this->curentdoc->document_count_view) ? $this->curentdoc->document_count_view : '';

		$out = str_replace($search, $replace, $out);
		unset ($search, $replace);
		// /������ ��������� ���� ��������� �������

		// ���
		$out = rewrite_link($out);

		echo $out;
	}

	/**
	 * �����, ��������������� ��� ������������ ���, � ����� ��� ������ ��������� � �������
     * �������������� ���������� � URL
     *
     * @param string $get_url ������ ��������
	 *
	 */
	function coreUrlParse($get_url = '')
	{
		global $AVE_DB;

		$get_url = iconv("UTF-8", "WINDOWS-1251//IGNORE//TRANSLIT", rawurldecode($get_url));
		$get_url = substr($get_url, strlen(ABS_PATH));
		if (substr($get_url, - strlen(URL_SUFF)) == URL_SUFF)
		{
			$get_url = substr($get_url, 0, - strlen(URL_SUFF));
		}

		// ��������� ������ ����������� �� ��������� �����
        $get_url = explode('/', $get_url);

		$get_url = array_combine($get_url, $get_url);

		if (isset ($get_url['index']))
		{
			unset ($get_url['index']);
		}

		if (isset ($get_url['print']))
		{
			$_GET['print'] = $_REQUEST['print'] = 1;
			unset ($get_url['print']);
		}

        // ����������, ������������ �� � ��� ���������� ��������� �� ���������
		$pages = preg_grep('/^(a|art)?page-\d+$/i', $get_url);

        if (!empty ($pages))
		{
			$get_url = implode('/', array_diff($get_url, $pages));
			$pages = implode('/', $pages);

			preg_replace_callback(
				'/(page|apage|artpage)-(\d+)/i',
				create_function(
					'$matches',
					'$_GET[$matches[1]] = $matches[2]; $_REQUEST[$matches[1]] = $matches[2];'
				),
				$pages
			);
		}
		else // � ��������� ������ ��������� ������������� ������ ��� ���������
		{
			$get_url = implode('/', $get_url);
		}

//		if ($get_url == 'index.php') $get_url = '';

//		unset ($pages);

        // ��������� ������ � �� �� ���������
		$sql = $AVE_DB->Query("
			SELECT
				doc.*,
				rubric_permission,
				rubric_template,
				template_text
			FROM
				" . PREFIX . "_documents AS doc
			JOIN
				" . PREFIX . "_rubrics AS rub
					ON rub.Id = doc.rubric_id
			JOIN
				" . PREFIX . "_templates AS tpl
					ON tpl.Id = rubric_template_id
			JOIN
				" . PREFIX . "_rubric_permissions AS prm
					ON doc.rubric_id = prm.rubric_id
			WHERE
				user_group_id = '" . UGROUP . "'
			AND
				" . (!empty ($get_url) ? "document_alias = '" . $get_url . "'" : "doc.Id = 1") . "
			LIMIT 1
		");

		if ($this->curentdoc = $sql->FetchRow())
		{
			$_GET['id']  = $_REQUEST['id']  = $this->curentdoc->Id;
			$_GET['doc'] = $_REQUEST['doc'] = $this->curentdoc->document_alias;
		}
		else
		{
			$_GET['id'] = $_REQUEST['id'] = PAGE_NOT_FOUND_ID;
		}
	}
}

?>