<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * Основной класс собирающий шаблон для вывода страницы
 */
class AVE_Core
{

/**
 *	СВОЙСТВА
 */

    /**
     * Текущий документ
     *
     * @var object
     */
    var $curentdoc = null;

	/**
	 * Установленные модули
	 *
	 * @var array
	 */
	var $install_modules = null;

	/**
	 * Сообщение об ошибке
	 *
	 * @var string
	 */
	var $_doc_not_found = '<center><h1>HTTP Error 404: Page not found</h1></center>';

	/**
	 * Сообщение об ошибке
	 *
	 * @var string
	 */
	var $_rubric_template_empty = '<h1>Ошибка</h1><br />Не задан шаблон рубрики.';

	/**
	 * Сообщение об ошибке
	 *
	 * @var string
	 */
	var $_doc_not_published = 'Запрашиваемый документ запрещен к публикации.';

	/**
	 * Сообщение об ошибке
	 *
	 * @var string
	 */
	var $_module_error = 'Запрашиваемый модуль не может быть загружен.';

	/**
	 * Сообщение об ошибке
	 *
	 * @var string
	 */
	var $_module_not_found = 'Запрашиваемый модуль не найден.';

/**
 *	ВНУТРЕННИЕ МЕТОДЫ
 */

	/**
	 * Получить основной шаблон страницы
	 *
	 * @param int $rubrik_id идентификатор рубрики
	 * @param string $template шаблон
	 * @param string $fetched шаблон модуля
	 * @return string
	 */
	function _coreDocumentTemplateGet($rubrik_id = '', $template = '', $fetched = '')
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
							$_REQUEST['id'] = (isset ($_REQUEST['id']) && is_numeric($_REQUEST['id'])) ? $_REQUEST['id'] : 1;

							$rubrik_id = $AVE_DB->Query("
								SELECT RubrikId
								FROM " . PREFIX . "_documents
								WHERE Id = '" . $_REQUEST['id'] . "'
								LIMIT 1
							")->GetCell();

							if (!$rubrik_id) return '';
						}

						$tpl = $AVE_DB->Query("
							SELECT Template
							FROM " . PREFIX . "_templates AS tpl
							LEFT JOIN " . PREFIX . "_rubrics AS rub ON tpl.Id = Vorlage
							WHERE rub.Id = '" . $rubrik_id . "'
							LIMIT 1
						")->GetCell();

						$out = $tpl ? $tpl : '';
					}
				}
			}
		}

		return $out;
	}

	/**
	 * Получить шаблон модуля
	 *
	 * @return string
	 */
	function _coreModuleTemplateGet()
	{
		global $AVE_DB;

		if (!is_dir(BASE_DIR . '/modules/' . $_REQUEST['module']))
		{
			echo '<meta http-equiv="Refresh" content="2;URL=' . get_home_link() . '" />';
			$out = $this->_module_not_found;
		}
		else
		{
			$out = $AVE_DB->Query("
				SELECT tmpl.Template
				FROM " . PREFIX . "_templates AS tmpl
				LEFT JOIN " . PREFIX . "_module AS mdl ON tmpl.Id = mdl.Template
				WHERE ModulPfad = '" . $_REQUEST['module'] . "'
			")->GetCell();

			if (empty ($out))
			{
				$out = $AVE_DB->Query("
					SELECT Template
					FROM " . PREFIX . "_templates
					WHERE Id = '1'
					LIMIT 1
				")->GetCell();
			}
		}

		return $out;
	}

	/**
	 * Формирование прав доступа к документам рубрики
	 *
	 * @param int $rubrik_id идентификатор рубрики
	 */
	function _coreRubricPermissionFetch($rubrik_id = '')
	{
		global $AVE_DB;

		unset ($_SESSION[$rubrik_id . '_docread']);

		if (!empty ($this->curentdoc->Rechte))
		{
			$Rechte = explode('|', $this->curentdoc->Rechte);
			foreach ($Rechte as $perm)
			{
				if (!empty ($perm)) $_SESSION[$rubrik_id . '_' . $perm] = 1;
			}
		}
		else
		{
			$sql = $AVE_DB->Query("
				SELECT Rechte
				FROM " . PREFIX . "_document_permissions
				WHERE RubrikId = '" . $rubrik_id . "'
				AND BenutzerGruppe = '" . UGROUP . "'
			");

			while ($row = $sql->FetchRow())
			{
				$row->Rechte = explode('|', $row->Rechte);
				foreach ($row->Rechte as $perm)
				{
					if (!empty ($perm)) $_SESSION[$rubrik_id . '_' . $perm] = 1;
				}
			}
		}
	}

	/**
	 * Обработка события 404 Not Found
	 *
	 * @return unknown
	 */
	function _coreErrorPage404()
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
			header('Location:' . ABS_PATH . 'index.php?id=' . PAGE_NOT_FOUND_ID);
		}
		else
		{
			echo $this->_doc_not_found;
		}

		exit;
	}

	/**
	 * Формирование хэша страницы
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

	function _coreCurrentDocumentFetch($document_id = 1, $user_group = 2)
	{
		global $AVE_DB;

		$this->curentdoc = $AVE_DB->Query("/*1*/
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
				BenutzerGruppe = '" . $user_group . "'
			AND
				doc.Id = '" . $document_id . "'
			LIMIT 1
		")->FetchRow();

		return (isset($this->curentdoc->Id) && $this->curentdoc->Id == $document_id);
	}

	function _corePageNotFoundFetch($page_not_found_id = 2, $user_group = 2)
	{
		global $AVE_DB;

		$this->curentdoc = $AVE_DB->Query("/*2*/
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
				BenutzerGruppe = '" . $user_group . "'
			AND
				doc.Id = '" . $page_not_found_id . "'
			LIMIT 1
		")->FetchRow();

		return (isset($this->curentdoc->Id) && $this->curentdoc->Id == $page_not_found_id);
	}

	function _coreModuleMetatagsFetch()
	{
		global $AVE_DB;

		if (! isset($_REQUEST['module'])) return false;

		if ($_REQUEST['module'] == 'shop' && empty ($_REQUEST['product_id']))
		{
			$this->curentdoc = $AVE_DB->Query("
				SELECT
					a.IndexFollow,
					b.ShopKeywords AS MetaKeywords,
					b.ShopDescription AS MetaDescription
		        FROM
		        	" . PREFIX . "_documents AS a,
		        	" . PREFIX . "_modul_shop AS b
		        WHERE a.Id = 1
		        AND b.Id = 1
			")->FetchRow();
		}
		elseif ($_REQUEST['module'] == 'shop' && !empty ($_REQUEST['product_id']) && is_numeric($_REQUEST['product_id']))
		{
			$this->curentdoc = $AVE_DB->Query("
				SELECT
					a.IndexFollow,
					b.ProdKeywords AS MetaKeywords,
					b.ProdDescription AS MetaDescription
				FROM
					" . PREFIX . "_documents AS a,
					" . PREFIX . "_modul_shop_artikel AS b
				WHERE a.Id = 1
				AND b.Id = '" . $_REQUEST['product_id'] . "'
			")->FetchRow();
		}
		else
		{
			$this->curentdoc = $AVE_DB->Query("
				SELECT
					IndexFollow,
					MetaKeywords,
					MetaDescription,
					Titel
				FROM " . PREFIX . "_documents
				WHERE Id = 1
			")->FetchRow();
		}

		return (isset($this->curentdoc->Id) && $this->curentdoc->Id == 1);
	}

	function _coreDocumentIsPublished()
	{
		if (!empty ($this->curentdoc)															// документ есть
			&& $this->curentdoc->Id != PAGE_NOT_FOUND_ID										// документ не сообщение ошибки 404
			&& ( $this->curentdoc->DokStatus != 1												// статус документа
				|| $this->curentdoc->Geloescht == 1												// пометка удаления
				|| ( get_settings('use_doctime')												// время публикации контролируется и ...
					&& ($this->curentdoc->DokEnde != 0 && $this->curentdoc->DokEnde < time())	// время публикации не наступило
					|| ($this->curentdoc->DokStart != 0 && $this->curentdoc->DokStart > time())	// время публикации истекло
					)
				)
			)
		{
			if (isset ($_SESSION['adminpanel']) || isset ($_SESSION['alles']))
			{
				display_notice($this->_doc_not_published);
			}
			else
			{
				$this->curentdoc = false;
			}
		}

		return (! empty($this->curentdoc));
	}

/**
 *	ВНЕШНИЕ МЕТОДЫ
 */

	/**
	 * Обработка тэгов модулей
	 * Подключаются файлы модулей тэги которых обнаружены в шаблоне
	 * Формирует массив всех установленных модулей проверяя их доступность
	 *
	 * @param string $template текст шаблона с тэгами
	 * @return string текст шаблона с обработанными тэгами модулей
	 */
	function coreModuleTagParse($template)
	{
		global $AVE_DB;

		$pattern = array();
		$replace = array();

		if (null !== $this->install_modules)
		{
			foreach ($this->install_modules as $row)
			{
				if ((isset($_REQUEST['module']) && $_REQUEST['module'] == $row->ModulPfad) ||
					(1 == $row->IstFunktion && 1 == preg_match($row->CpEngineTag, $template)))
				{	// выводится модуль или у модуля есть функция вызываемая тэгом присутствующим в шаблоне
					if (function_exists($row->ModulFunktion))
					{
						$pattern[] = $row->CpEngineTag;
						$replace[] = $row->CpPHPTag;
					}
					else
					{
						if (require_once(BASE_DIR . '/modules/' . $row->ModulPfad . '/modul.php'))
						{	// файл модуля есть
							if ($row->CpEngineTag)
							{
								$pattern[] = $row->CpEngineTag;
								$replace[] = function_exists($row->ModulFunktion)
									? $row->CpPHPTag
									: ($this->_module_error . ' &quot;' . $row->ModulName . '&quot;');
							}
						}
						elseif ($row->CpEngineTag)
						{	// файла модуля нет - ругаемся
							$pattern[] = $row->CpEngineTag;
							$replace[] = $this->_module_error . ' &quot;' . $row->ModulName . '&quot;';
						}
					}
				}
			}

			return preg_replace($pattern, $replace, $template);
		}
		else
		{
			$this->install_modules = array();

			$sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX. "_module
				WHERE Status = '1'
			");
			while ($row = $sql->FetchRow())
			{
				if ((isset($_REQUEST['module']) && $_REQUEST['module'] == $row->ModulPfad) ||
					(1 == $row->IstFunktion && 1 == preg_match($row->CpEngineTag, $template)))
				{	// выводится модуль или у модуля есть функция вызываемая тэгом присутствующим в шаблоне
					if (require_once(BASE_DIR . '/modules/' . $row->ModulPfad . '/modul.php'))
					{	// файл модуля есть
						if ($row->CpEngineTag)
						{
							$pattern[] = $row->CpEngineTag;
							$replace[] = function_exists($row->ModulFunktion)
								? $row->CpPHPTag
								: ($this->_module_error . ' &quot;' . $row->ModulName . '&quot;');
						}
						$this->install_modules[$row->ModulPfad] = $row;
					}
					elseif ($row->CpEngineTag)
					{	// файла модуля нет - ругаемся
						$pattern[] = $row->CpEngineTag;
						$replace[] = $this->_module_error . ' &quot;' . $row->ModulName . '&quot;';
					}
				}
				else
				{	// у модуля нет функции или тэг модуля не используется - просто помещаем в массив информацию о модуле
					$this->install_modules[$row->ModulPfad] = $row;
				}
			}

			return preg_replace($pattern, $replace, $template);
		}
	}

	/**
	 * Сборка страницы
	 *
	 * @param int $id идентификатор документа
	 * @param int $rub_id идентификатор рубрики
	 */
	function coreSiteFetch($id, $rub_id = '')
	{
		global $AVE_DB;

		if (!empty ($_REQUEST['module']))
		{	// вывод модуля
			$out = $this->_coreModuleMetatagsFetch();

			$out = $this->_coreDocumentTemplateGet('', '', $this->_coreModuleTemplateGet());
		}	// /вывод модуля
		else
		{	// вывод документа
			if (! isset($this->curentdoc->Id) && ! $this->_coreCurrentDocumentFetch($id, UGROUP))
			{
				if ($this->_corePageNotFoundFetch(PAGE_NOT_FOUND_ID, UGROUP))
				{
					$_REQUEST['id'] = $_GET['id'] = $id = PAGE_NOT_FOUND_ID;
				}
			}

			// проверяем параметры публикации документа
			if (! $this->_coreDocumentIsPublished())
			{
				$this->_coreErrorPage404();
			}

			// права доступа к документам рубрики
			define('RUB_ID', !empty ($rub_id) ? $rub_id : $this->curentdoc->RubrikId);
			$this->_coreRubricPermissionFetch(RUB_ID);

			if (! ((isset ($_SESSION[RUB_ID . '_docread']) && $_SESSION[RUB_ID . '_docread'] == 1)
				|| (isset ($_SESSION[RUB_ID . '_alles']) && $_SESSION[RUB_ID . '_alles'] == 1)) )
			{	// читать запрещено - извлекаем ругательство и отдаём вместо контента
				$main_content = get_settings('message_forbidden');
			}
			else
			{
				if (isset ($_REQUEST['print']) && $_REQUEST['print'] == 1)
				{	// увеличиваем счетчик версий для печати
					$AVE_DB->Query("
						UPDATE " . PREFIX . "_documents
						SET Drucke = Drucke+1
						WHERE Id = '" . $id . "'
					");
				}
				else
				{
					if (!isset ($_SESSION['doc_view[' . $id . ']']))
					{	// увеличиваем счетчик просмотров (1 раз в пределах сессии)
						$AVE_DB->Query("
							UPDATE " . PREFIX . "_documents
							SET Geklickt = Geklickt+1
							WHERE Id = '" . $id . "'
						");
						$_SESSION['doc_view[' . $id . ']'] = 1;
					}
				}

				if (CACHE_DOC_TPL && empty ($_POST) && !(isset ($_SESSION['user_adminmode']) && $_SESSION['user_adminmode'] == 1))
				{	// кэширование разрешено
					// извлекаем скомпилированный шаблон документа из кэша
					$main_content = $AVE_DB->Query("
						SELECT compiled
						FROM " . PREFIX . "_rubric_template_cache
						WHERE hash  = '" . $this->_get_cache_hash() . "'
						LIMIT 1
					")->GetCell();
				}
				else
				{	// кэширование запрещено
					$main_content = false;
				}

				if (empty ($main_content))
				{	// кэш пустой или отключен, извлекаем и компилируем шаблон
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
					{	// не задан шаблон рубрики
						$main_content = $this->_rubric_template_empty;
					}
					else
					{
						// парсим тэги полей в шаблоне документа
						$main_content = preg_replace_callback('/\[cprub:(\d+)\]/', 'document_get_field', $rubTmpl);

						// удаляем ошибочные тэги полей
						$main_content = preg_replace('/\[cprub:\d*\]/', '', $main_content);

						if (CACHE_DOC_TPL && empty ($_POST) && !(isset ($_SESSION['user_adminmode']) && $_SESSION['user_adminmode'] == 1))
						{	// кэширование разрешено
							// сохраняем скомпилированный шаблон в кэш
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
			}
			$out = str_replace('[cp:maincontent]', $main_content, $this->_coreDocumentTemplateGet(RUB_ID));
		}	// /вывод документа

		// рахитизм от которого надо избавится и сделать всё на CSS
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

		// извлекаем из шаблона название темы дизайна
		$match = '';
		preg_match('/\[cp:theme:(\w+)]/', $out, $match);
		define('THEME_FOLDER', empty ($match[1]) ? DEFAULT_THEME_FOLDER : $match[1]);
		$out = preg_replace('/\[cp:theme:(.*?)]/', '', $out);

		// парсим тэги модулей
		$out = $this->coreModuleTagParse($out);

		if ( isset($_REQUEST['module'])
			&& ! (isset($this->install_modules[$_REQUEST['module']])
				&& '1' == $this->install_modules[$_REQUEST['module']]->Status) )
		{
			display_notice($this->_module_error);
		}

		// парсим тэги системы внутренних запросов
		$out = preg_replace_callback('/\[cprequest:(\d+)\]/', 'request_parse', $out);

		// парсим тэги скрытого текста
		$out = parse_hide($out);

		// парсим остальные тэги основного шаблона
		$search = array(
			'[cp:mediapath]',
			'[cp:path]',
			'[cp:pagename]',
			'[cp:document]',
			'[cp:home]',
			'[cp:keywords]',
			'[cp:description]',
			'[cp:indexfollow]'
		);

		$replace = array(
			ABS_PATH . 'templates/' . THEME_FOLDER . '/',
			ABS_PATH,
			htmlspecialchars(get_settings('site_name'), ENT_QUOTES),
			get_redirect_link('print'),
			get_home_link(),
			(isset ($this->curentdoc->MetaKeywords) ? htmlspecialchars($this->curentdoc->MetaKeywords, ENT_QUOTES) : ''),
			(isset ($this->curentdoc->MetaDescription) ? htmlspecialchars($this->curentdoc->MetaDescription, ENT_QUOTES) : ''),
			(isset ($this->curentdoc->IndexFollow) ? $this->curentdoc->IndexFollow : '')
		);

		if (defined('MODULE_CONTENT'))
		{	// парсинг тэгов при выводе из модуля
			$search[] = '[cp:maincontent]';
			$replace[] = MODULE_CONTENT;
			$search[] = '[cp:title]';
			$replace[] = htmlspecialchars(defined('MODULE_SITE') ? MODULE_SITE : '', ENT_QUOTES);
		}
		else
		{
			$search[] = '[cp:title]';
			$replace[] = htmlspecialchars(pretty_chars($this->curentdoc->Titel), ENT_QUOTES);
		}

		$search[] = '[cp:maincontent]';
		$replace[] = '';
		$search[] = '[cp:printlink]';
		$replace[] = get_print_link();
		$search[] = '[cp:version]';
		$replace[] = APP_INFO;
		$search[] = '[views]';
		$replace[] = isset ($this->curentdoc->Geklickt) ? $this->curentdoc->Geklickt : '';

		$out = str_replace($search, $replace, $out);
		unset ($search, $replace);
		// /парсим остальные тэги основного шаблона

		// ЧПУ
		$out = rewrite_link($out);

		echo $out;
	}

	/**
	 * ЧПУ: поиск документа и разбор дополнительных параметров URL
	 *
	 */
	function coreUrlParse($get_url = '')
	{
		global $AVE_DB;

		$get_url = iconv("UTF-8", "WINDOWS-1251", urldecode($get_url));
//		list($get_url) = explode('#', $get_url);
		$get_url = substr($get_url, strlen(ABS_PATH));
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
			$_GET['print'] = $_REQUEST['print'] = 1;
			unset ($get_url['print']);
		}

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
		else
		{
			$get_url = implode('/', $get_url);
		}

//		if ($get_url == 'index.php') $get_url = '';

//		unset ($pages);

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
			$_GET['id']  = $_REQUEST['id']  = $this->curentdoc->Id;
			$_GET['doc'] = $_REQUEST['doc'] = $this->curentdoc->Url;
		}
		else
		{
			$_GET['id'] = $_REQUEST['id'] = PAGE_NOT_FOUND_ID;
		}
	}
}

?>