<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * Класс управления Документами в административной части
 */
class AVE_Document
{

/**
 *	СВОЙСТВА
 */

	/**
	 * Количество Документов отображаемых на одной странице списка
	 *
	 * @var int
	 */
	var $_limit = 15;

	/**
	 * Ширина поля ввода
	 *
	 * @var string
	 */
	var $_field_width = '400px';

	/**
	 * Ширина многострочного поля ввода
	 *
	 * @var string
	 */
	var $_textarea_width = '98%';

	/**
	 * Высота многострочного поля ввода
	 *
	 * @var string
	 */
	var $_textarea_height = '400px';

	/**
	 * Ширина маленького многострочного поля ввода
	 *
	 * @var string
	 */
	var $_textarea_width_small = '98%';

	/**
	 * Высота маленького многострочного поля ввода
	 *
	 * @var string
	 */
	var $_textarea_height_small = '200px';

	/**
	 * Максимальное количество символов в Заметке к Документу
	 *
	 * @var int
	 */
	var $_max_comment_length = 5000;

/**
 *    ВНЕШНИЕ МЕТОДЫ
 */

	/**
	 *	Управление Документами
	 */

	/**
	 * Управление списком Документов
	 *
	 */
	function showDocs()
	{
		global $AVE_DB, $AVE_Template;

		$ex_titel = '';
		$nav_titel = '';
		$ex_zeit = '';
		$nav_zeit = '';
		$request = '';
		$ex_rub = '';
		$nav_rub = '';
		$ex_docstatus = '';
		$navi_docstatus = '';

		if (!empty($_REQUEST['QueryTitel']))
		{
			$request = $_REQUEST['QueryTitel'];
			$kette = explode(' ', $request);

			foreach ($kette as $suche)
			{
				$und = @explode(' +', $suche);
				foreach ($und as $und_wort)
				{
					if (strpos($und_wort, '+')!==false)
					$ex_titel .= " AND (Titel like '%" . substr($und_wort, 1) . "%')";
				}

				$und_nicht = @explode(' -', $suche);
				foreach ($und_nicht as $und_nicht_wort)
				{
					if (strpos($und_nicht_wort, '-') !== false)
					$ex_titel .= " AND (Titel not like '%" . substr($und_nicht_wort, 1) . "%')";
				}

				$start = explode(' +', $request);
				if (strpos($start[0], ' -') !== false)
				$start = explode(' -', $request);
				$start = $start[0];
			}

			$ex_titel = "AND (Titel like '%" . $start . "%') " . $ex_titel;
			$nav_titel = '&QueryTitel=' . urlencode($request);
		}

		if (isset($_REQUEST['RubrikId']) && $_REQUEST['RubrikId'] != 'all')
		{
			$ex_rub = " AND RubrikId = '" . $_REQUEST['RubrikId'] . "'";
			$nav_rub = '&RubrikId=' . $_REQUEST['RubrikId'];
		}

		if (!empty($_REQUEST['TimeSelect']))
		{
			$ex_zeit   = 'AND ((DokStart BETWEEN ' . $this->_selectStart() . ' AND ' . $this->_selectEnde() . ') OR DokStart = 0)';
			$nav_zeit  = '&DokStartMonth=' . $_REQUEST['DokStartMonth'] . '&DokStartDay=' . $_REQUEST['DokStartDay'] . '&DokStartYear=' . $_REQUEST['DokStartYear'];
			$nav_zeit .= '&DokEndeMonth=' . $_REQUEST['DokEndeMonth'] . '&DokEndeDay=' . $_REQUEST['DokEndeDay'] . '&DokEndeYear=' . $_REQUEST['DokEndeYear'] . '&TimeSelect=1';
		}

		if (!empty($_REQUEST['DokStatus']))
		{
			switch ($_REQUEST['DokStatus'])
			{
				case '':
				case 'All':
					break;

				case 'Opened':
					$ex_docstatus = 'AND DokStatus = 1';
					$navi_docstatus = '&DokStatus=Opened';
					break;

				case 'Closed':
					$ex_docstatus = 'AND DokStatus = 0';
					$navi_docstatus = '&DokStatus=Closed';
					break;

				case 'Deleted':
					$ex_docstatus = 'AND Geloescht = 1';
					$navi_docstatus = '&DokStatus=Deleted';
					break;
			}
		}

		$ex_Geloescht = (UGROUP != 1) ? 'AND Geloescht != 1' : '' ;
		$w_id = !empty($_REQUEST['doc_id']) ? " AND Id = '" . $_REQUEST['doc_id'] . "'" : '';

		$num = $AVE_DB->Query("
			SELECT COUNT(*)
			FROM " . PREFIX . "_documents
			WHERE Id > 0
			" . $ex_Geloescht . "
			" . $ex_zeit . "
			" . $ex_titel . "
			" . $ex_rub . "
			" . $ex_docstatus . "
			" . $w_id . "
		")
		->GetCell();

		if (!empty($_REQUEST['Datalimit']))
		{
			$limit = (int)$_REQUEST['Datalimit'];
		}
		else
		{
			$limit = $this->_limit;
		}
		$nav_limit = '&Datalimit=' . $limit;

		$seiten = ceil($num / $limit);
		$start = prepage() * $limit - $limit;

		$db_sort   = 'ORDER BY DokEdi DESC';
		$navi_sort = '&sort=ErstelltDesc';

		if (!empty($_REQUEST['sort']))
		{
			switch ($_REQUEST['sort'])
			{
				case 'Id' :
					$db_sort   = 'ORDER BY Id ASC';
					$navi_sort = '&sort=Id';
					break;

				case 'IdDesc' :
					$db_sort   = 'ORDER BY Id DESC';
					$navi_sort = '&sort=IdDesc';
					break;

				case 'Titel' :
					$db_sort   = 'ORDER BY Titel ASC';
					$navi_sort = '&sort=Titel';
					break;

				case 'TitelDesc' :
					$db_sort   = 'ORDER BY Titel DESC';
					$navi_sort = '&sort=TitelDesc';
					break;

				case 'Url' :
					$db_sort   = 'ORDER BY Url ASC';
					$navi_sort = '&sort=Url';
					break;

				case 'UrlDesc' :
					$db_sort   = 'ORDER BY Url DESC';
					$navi_sort = '&sort=UrlDesc';
					break;

				case 'Rubrik' :
					$db_sort   = 'ORDER BY RubrikId ASC';
					$navi_sort = '&sort=Rubrik';
					break;

				case 'RubrikDesc' :
					$db_sort   = 'ORDER BY RubrikId DESC';
					$navi_sort = '&sort=RubrikDesc';
					break;

				case 'Erstellt' :
					$db_sort   = 'ORDER BY DokEdi ASC';
					$navi_sort = '&sort=Erstellt';
					break;

				case 'ErstelltDesc' :
//					$db_sort   = 'ORDER BY DokEdi DESC';
//					$navi_sort = '&sort=ErstelltDesc';
					break;

				case 'Klicks' :
					$db_sort   = 'ORDER BY Geklickt ASC';
					$navi_sort = '&sort=Klicks';
					break;

				case 'KlicksDesc' :
					$db_sort   = 'ORDER BY Geklickt DESC';
					$navi_sort = '&sort=KlicksDesc';
					break;

				case 'Druck' :
					$db_sort   = 'ORDER BY Drucke ASC';
					$navi_sort = '&sort=Druck';
					break;

				case 'DruckDesc' :
					$db_sort   = 'ORDER BY Drucke DESC';
					$navi_sort = '&sort=DruckDesc';
					break;

				case 'Autor' :
					$db_sort   = 'ORDER BY Redakteur ASC';
					$navi_sort = '&sort=Autor';
					break;

				case 'AutorDesc' :
					$db_sort   = 'ORDER BY Redakteur DESC';
					$navi_sort = '&sort=AutorDesc';
					break;

				case 'Edits':
					$db_sort   = 'ORDER BY DokEdi ASC';
					$navi_sort = '&sort=Edits';
					break;

				case 'EditsDesc':
					$db_sort   = 'ORDER BY DokEdi DESC';
					$navi_sort = '&sort=EditsDesc';
					break;

				default :
					$db_sort   = 'ORDER BY DokEdi DESC';
					$navi_sort = '&sort=EditsDesc';
					break;
			}
		}

		$docs = array();
		$sql = $AVE_DB->Query("
			SELECT *
			FROM " . PREFIX . "_documents
			WHERE Id > 0
			" . $ex_Geloescht . "
			" . $ex_zeit . "
			" . $ex_titel . "
			" . $ex_rub . "
			" . $ex_docstatus . "
			" . $w_id . "
			" . $db_sort . "
			LIMIT " . $start . "," . $limit . "
		");
		while ($row = $sql->FetchRow())
		{
			$row->Kommentare = $AVE_DB->Query("
				SELECT COUNT(*)
				FROM " . PREFIX . "_document_comments
				WHERE DokumentId = '" . $row->Id . "'
			")->GetCell();

			$this->_fetchDocPerms($row->RubrikId);

			$row->RubName      = $this->_showRubName($row->RubrikId)->RubrikName;
			$row->RBenutzer    = getUserById($row->Redakteur);
			$row->cantEdit     = 0;
			$row->canDelete    = 0;
			$row->canEndDel    = 0;
			$row->canOpenClose = 0;

			// разрешаем редактирование и удаление
			// если автор имеет право изменять свои документы в рубрике
			// или пользователю разрешено изменять все документы в рубрике
			if ( ($row->Redakteur == @$_SESSION['user_id']
                && isset($_SESSION[$row->RubrikId . '_editown']) && @$_SESSION[$row->RubrikId . '_editown'] == 1)
                || (isset($_SESSION[$row->RubrikId . '_editall']) && $_SESSION[$row->RubrikId . '_editall'] == 1) )
			{
					$row->cantEdit  = 1;
					$row->canDelete = 1;
			}
			// запрещаем редактирование главной страницы и страницу ошибки 404 если требуется одобрение Администратора
			if ( ($row->Id == 1 || $row->Id == PAGE_NOT_FOUND_ID)
                && isset($_SESSION[$row->RubrikId . '_newnow']) && @$_SESSION[$row->RubrikId . '_newnow'] != 1)
			{
				$row->cantEdit = 0;
			}
			// разрешаем автору блокировать и разблокировать свои документы если не требуется одобрение Администратора
			if ($row->Redakteur == @$_SESSION['user_id']
                && isset($_SESSION[$row->RubrikId . '_newnow']) && @$_SESSION[$row->RubrikId . '_newnow'] == 1)
            {
				$row->canOpenClose = 1;
			}
			// разрешаем всё если пользователь принадлежит группе Администраторов или имеет все права на рубрику
			if (UGROUP == 1 || @$_SESSION[$row->RubrikId . '_alles'] == 1)
			{
				$row->cantEdit     = 1;
				$row->canDelete    = 1;
				$row->canEndDel    = 1;
				$row->canOpenClose = 1;
			}
			// Главную страницу и страницу ошибки 404 удалять нельзя
			if ($row->Id == 1 || $row->Id == PAGE_NOT_FOUND_ID)
			{
				$row->canDelete = 0;
				$row->canEndDel = 0;
			}

			array_push($docs, $row);
		}

		$AVE_Template->assign('docs', $docs);

		if ($num > $limit)
		{
			$nav_target = !empty($_REQUEST['target']) ? '&target=' . $_REQUEST['target'] : '';
			$nav_doc    = !empty($_REQUEST['doc']) ? '&doc=' . $_REQUEST['doc'] : '';
			$nav_alias  = !empty($_REQUEST['alias']) ? '&alias=' . $_REQUEST['alias'] : '';
			$pop        = (isset($_REQUEST['pop']) && $_REQUEST['pop'] == 1) ? '&pop=1' : '';
			$showsimple = (isset($_REQUEST['action']) && $_REQUEST['action'] == 'showsimple') ? '&action=' . $_REQUEST['action'] : '';
			$selurl     = (isset($_REQUEST['selurl']) && $_REQUEST['selurl'] == 1) ? '&selurl=1' : '';
			$idonly     = (isset($_REQUEST['idonly']) && $_REQUEST['idonly'] == 1) ? '&idonly=1' : '';

			$template_label = " <a class=\"pnav\" href=\"index.php?do=docs" . $nav_target . $nav_doc . $nav_alias . $navi_sort . $navi_docstatus
				. $nav_titel . $nav_rub . $nav_zeit . $nav_limit . $pop . $showsimple . $selurl . $idonly . "&page={s}&cp=" . SESSION . "\">{t}</a> ";
			$page_nav = pagenav($seiten, 'page', $template_label);
			$AVE_Template->assign('page_nav', $page_nav);
		}
	}

	/**
	 * Создать новый Документ
	 *
	 * @param int $rubric_id идентификатор Рубрики
	 */
	function newDoc($rubric_id)
	{
		global $AVE_DB, $AVE_Template, $AVE_Globals;

		$this->_fetchDocPerms($rubric_id);

		if ( (isset($_SESSION[$rubric_id . '_newnow'])  && $_SESSION[$rubric_id . '_newnow'] == 1)
			|| (isset($_SESSION[$rubric_id . '_new'])   && $_SESSION[$rubric_id . '_new']    == 1)
			|| (isset($_SESSION[$rubric_id . '_alles']) && $_SESSION[$rubric_id . '_alles']  == 1)
			|| (defined('UGROUP') && UGROUP == 1) )
		{
			switch ($_REQUEST['sub'])
			{
				case 'save':
					$innavi = 1;
					$ende = $this->_dokEnde();
					$start = $this->_dokStart();
					$document_status = !empty($_REQUEST['DokStatus']) ? (int)$_REQUEST['DokStatus'] : '';

					if (empty($document_status))
					{
						$innavi = 0;
						@reset($_POST);
						$newtext = "\n\n";

						foreach ($_POST['feld'] as $val)
						{
							if (!empty($val))
							{
								$newtext .= $val;
								$newtext .= "\n---------------------\n";
							}
						}
						$text = strip_tags($newtext);

						$system_mail = $AVE_Globals->mainSettings('mail_from');
						$system_mail_name = $AVE_Globals->mainSettings('mail_from_name');

						// Письмо админу
						$body_toadmin = $AVE_Template->get_config_vars('DOC_MAIL_BODY_CHECK');
						$body_toadmin = str_replace('%N%', "\n", $body_toadmin);
						$body_toadmin = str_replace('%TITLE%', stripslashes($_POST['Titel']), $body_toadmin);
						$body_toadmin = str_replace('%USER%', "'" . $_SESSION['user_name'] . "'", $body_toadmin);
						$AVE_Globals->cp_mail($system_mail, $body_toadmin . $text, $AVE_Template->get_config_vars('DOC_MAIL_SUBJECT_CHECK'), $system_mail, $system_mail_name, 'text', '');

						// Письмо автору
						$body_toauthor = str_replace('%N%', "\n", $AVE_Template->get_config_vars('DOC_MAIL_BODY_USER'));
						$body_toauthor = str_replace('%TITLE%', stripslashes($_POST['Titel']), $body_toauthor);
						$body_toauthor = str_replace('%USER%', "'" . $_SESSION['user_name'] . "'", $body_toauthor);
						$AVE_Globals->cp_mail($_SESSION['user_email'], $body_toauthor, $AVE_Template->get_config_vars('DOC_MAIL_SUBJECT_USER'), $system_mail, $system_mail_name, 'text', '');
					}

					if (! ((isset($_SESSION[$rubric_id . '_newnow']) && $_SESSION[$rubric_id . '_newnow'] == 1)
						|| (isset($_SESSION[$rubric_id . '_alles']) && $_SESSION[$rubric_id . '_alles'] == 1)
						|| (defined('UGROUP') && UGROUP == 1)) )
					{
						$document_status = 0;
					}

					$suche = (isset($_POST['Suche']) && $_POST['Suche'] == 1) ? 1 : 0;

					// формирование/проверка алиаса на уникальность
					$_REQUEST['Url'] = $tempurl = cpParseLinkname(empty($_POST['Url']) ? trim($_POST['prefix'] . '/' . $_POST['Titel'], '/') : $_POST['Url']);
					$cnt = 1;
					while (
						$AVE_DB->Query("
							SELECT COUNT(*)
							FROM " . PREFIX . "_documents
							WHERE Url = '" . $_REQUEST['Url'] . "'
							LIMIT 1
						")->GetCell() > 0)
					{
						$_REQUEST['Url'] = $tempurl . '-' . $cnt;
						$cnt++;
					}

					$AVE_DB->Query("
						INSERT
						INTO " . PREFIX . "_documents
						SET
							RubrikId        = '" . $rubric_id . "',
							Titel           = '" . preClear($_POST['Titel']) . "',
							Url             = '" . $_REQUEST['Url'] . "',
							DokStart        = '" . $start . "',
							DokEnde         = '" . $ende . "',
							DokEdi          = '" . time() . "',
							Redakteur       = '" . $_SESSION['user_id'] . "',
							Suche           = '" . $suche . "',
							MetaKeywords    = '" . preClear($_POST['MetaKeywords']) . "',
							MetaDescription = '" . preClear($_POST['MetaDescription']) . "',
							IndexFollow     = '" . $_POST['IndexFollow'] . "',
							DokStatus       = '" . $document_status . "',
							ElterNavi       = '" . (int)$_POST['ElterNavi'] . "'
					");
					$iid = $AVE_DB->InsertId();

					reportLog($_SESSION['user_name'] . ' - добавил документ (' . $iid . ')', 2, 2);

					foreach ($_POST['feld'] as $fld_id => $fld_val)
					{
						if (!$AVE_DB->Query("
								SELECT Id
								FROM " . PREFIX . "_rubric_fields
								WHERE Id = '" . $fld_id . "'
								AND RubrikId = '" . $rubric_id . "'
							")->GetCell())
						{
							continue;
						}

						if (!checkPermission('docs_php'))
						{
							if (isPhpCode($fld_val)) $fld_val = '';
						}

						$fld_val = preClear($fld_val);
						$fld_val = $this->_prettyChars($fld_val);

						$AVE_DB->Query("
							INSERT
							INTO " . PREFIX . "_document_fields
							SET
								RubrikFeld = '" . $fld_id . "',
								DokumentId = '" . $iid . "',
								Inhalt     = '" . $fld_val . "',
								Suche      = '" . $suche . "'
						");
					}

					$AVE_Template->assign('name_empty', $AVE_Template->get_config_vars('DOC_TOP_MENU_ITEM'));
					$AVE_Template->assign('Id', $iid);
					$AVE_Template->assign('innavi', $innavi);
					$AVE_Template->assign('RubrikId', $rubric_id);
					$AVE_Template->assign('content', $AVE_Template->fetch('documents/form_after.tpl'));
					break;

				case 'savenavi':
					$elter_pre = ($_REQUEST['Elter']=='0') ? 0 : explode('____', $_REQUEST['Elter']);
					$elter = is_array($elter_pre) ? $elter_pre[0] : 0;
					$ebene = is_array($elter_pre) ? $elter_pre[1] : 1;

					if ($elter != '0')
					{
						$rubrik = $AVE_DB->Query("
							SELECT Rubrik
							FROM " . PREFIX . "_navigation_items
							WHERE Id = '" . $elter . "'
						")
						->GetCell();
					}
					else
					{
						$rubrik = $_REQUEST['NaviRubric'];
					}

					$AVE_DB->Query("
						INSERT
						INTO " . PREFIX . "_navigation_items
						SET
							Titel  = '" . preClear($_REQUEST['Titel']) . "',
							Elter  = '" . $elter . "',
							Link   = 'index.php?id=" . (int)$_REQUEST['Id'] . "',
							Ziel   = '" . (empty($_REQUEST['Ziel']) ? '_self' : $_REQUEST['Ziel']) . "',
							Ebene  = '" . $ebene . "',
							Rang   = '" . empty($_REQUEST['Rang']) ? 1 : (int)$_REQUEST['Rang'] . "',
							Rubrik = '" . (int)$rubrik . "',
							Url    = '" . cpParseLinkname(empty($_REQUEST['Url']) ? $_REQUEST['Titel'] : $_REQUEST['Url']) . "'
					");

					if (isset($_REQUEST['pop']) && $_REQUEST['pop'] == 1)
					{
						echo '<script>window.opener.location.reload(); window.close();</script>';
					}
					else
					{
						echo '<script>window.opener.location.reload();</script>';
					}

					$AVE_Template->assign('innavi', 0);
					$AVE_Template->assign('Id', (int)$_REQUEST['Id']);
					$AVE_Template->assign('RubrikId', (int)$_REQUEST['RubrikId']);
					$AVE_Template->assign('content', $AVE_Template->fetch('documents/form_after.tpl'));
					break;

				case '':
					$document = '';
					$this->_fetchDocPerms($rubric_id);

					if (isset($_SESSION[$rubric_id . '_newnow']) && $_SESSION[$rubric_id . '_newnow'] == 1)
					{
						$document->dontChangeStatus = 0;
					}
					else
					{
						$document->dontChangeStatus = 1;
					}

					$fields = array();
					$sql = $AVE_DB->Query("
						SELECT *
						FROM " . PREFIX . "_rubric_fields
						WHERE RubrikId = '" . $rubric_id . "'
						ORDER BY rubric_position ASC
					");
					while ($row = $sql->FetchRow())
					{
						$row->Feld = $this->_getField($row->RubTyp, $row->StdWert, $row->Id, $row->StdWert);
						array_push($fields, $row);
					}

					$document->fields = $fields;
					$document->rubric_name = $this->_showRubName($rubric_id)->RubrikName;
					$document->rubric_url_prefix = $this->_showRubName($rubric_id)->UrlPrefix;
					$document->formaction = 'index.php?do=docs&action=new&sub=save&RubrikId=' . $rubric_id . ((isset($_REQUEST['pop']) && $_REQUEST['pop']==1) ? 'pop=1' : '') . '&cp=' . SESSION;

					$AVE_Template->assign('document', $document);
					$AVE_Template->assign('content', $AVE_Template->fetch('documents/form.tpl'));
					break;
			}
		}
		else
		{
			$AVE_Template->assign('content', $AVE_Template->get_config_vars('DOC_NO_PERMISSION_RUB'));
		}
	}

	/**
	 * Редактирование Документа
	 *
	 * @param int $id идентификатор Документа
	 */
	function editDoc($id)
	{
		global $AVE_DB, $AVE_Template, $AVE_Globals;

		switch ($_REQUEST['sub'])
		{
			case 'save':
				$row = $AVE_DB->Query("
					SELECT
						RubrikId,
						Redakteur
					FROM " . PREFIX . "_documents
					WHERE Id = '" . $id . "'
				")
				->FetchRow();

				$row->cantEdit = 0;

				$this->_fetchDocPerms($row->RubrikId);

				// разрешаем редактирование
				// если автор имеет право изменять свои документы в рубрике
				// или пользователю разрешено изменять все документы в рубрике
				if ( (isset($_SESSION['user_id']) && $row->Redakteur == $_SESSION['user_id'] &&
						isset($_SESSION[$row->RubrikId . '_editown']) && $_SESSION[$row->RubrikId . '_editown'] == 1)
					|| (isset($_SESSION[$row->RubrikId . '_editall']) && @$_SESSION[$row->RubrikId . '_editall'] == 1) )
				{
					$row->cantEdit = 1;
				}
				// запрещаем редактирование главной страницы и страницы ошибки 404 если требуется одобрение Администратора
				if ( ($id == 1 || $id == PAGE_NOT_FOUND_ID) && @$_SESSION[$row->RubrikId . '_newnow'] != 1 )
				{
					$row->cantEdit = 0;
				}
				// разрешаем редактирование если пользователь принадлежит группе Администраторов или имеет все права на рубрику
				if ( (defined('UGROUP') && UGROUP == 1)
					|| (isset($_SESSION[$row->RubrikId . '_alles']) && $_SESSION[$row->RubrikId . '_alles'] == 1) )
				{
					$row->cantEdit = 1;
				}

				if ($row->cantEdit == 1)
				{
					$suche     = (isset($_POST['Suche']) && $_POST['Suche'] == 1) ? 1 : 0;
					$docstatus = ( (isset($_SESSION[$row->RubrikId . '_newnow']) && $_SESSION[$row->RubrikId . '_newnow'] == 1)
								|| (isset($_SESSION[$row->RubrikId . '_alles']) && $_SESSION[$row->RubrikId . '_alles'] == 1)
								|| (defined('UGROUP') && UGROUP == 1) ) ? (int)$_REQUEST['DokStatus'] : 0;
					$docstatus = ($id == 1 || $id == PAGE_NOT_FOUND_ID) ? 1 : $docstatus;
					$docend    = ($id == 1 || $id == PAGE_NOT_FOUND_ID) ? 0 : $this->_dokEnde();
					$docstart  = ($id == 1 || $id == PAGE_NOT_FOUND_ID) ? 0 : $this->_dokStart();

					// формирование/проверка алиаса на уникальность
					$_REQUEST['Url'] = $tempurl = cpParseLinkname(empty($_POST['Url']) ? trim($_POST['prefix'] . '/' . $_POST['Titel'], '/') : $_POST['Url']);
					$cnt = 1;
					while ($AVE_DB->Query("
						SELECT COUNT(Id)
						FROM " . PREFIX . "_documents
						WHERE Id != '" . $id . "'
						AND Url = '" . $_REQUEST['Url'] . "'
						LIMIT 1
						")->GetCell() > 0)
					{
						$_REQUEST['Url'] = $tempurl . '-' . $cnt;
						$cnt++;
					}

					$AVE_DB->Query("
						UPDATE " . PREFIX . "_documents
						SET
							Titel           = '" . preClear($_POST['Titel']) . "',
							Url             = '" . $_REQUEST['Url'] . "',
							Suche           = '" . $suche . "',
							MetaKeywords    = '" . preClear($_POST['MetaKeywords']) . "',
							MetaDescription = '" . preClear($_POST['MetaDescription']) . "',
							IndexFollow     = '" . $_POST['IndexFollow'] . "',
							DokStatus       = '" . $docstatus . "',
							DokEnde         = '" . $docend . "',
							DokStart        = '" . $docstart . "',
							DokEdi          = '" . time() . "',
							ElterNavi       = '" . (int)$_POST['ElterNavi'] . "'
						WHERE
							Id = '" . $id . "'
					");

					$AVE_DB->Query("
						UPDATE " . PREFIX . "_navigation_items
						SET  Url  = '" . $_REQUEST['Url'] . "'
						WHERE Link = 'index.php?id=" . $id . "'
					");

					if (isset($_POST['feld']))
					{
						foreach ($_POST['feld'] as $fld_id => $fld_val)
						{
							$row_df = $AVE_DB->Query("
								SELECT
									Inhalt,
									Suche
								FROM " . PREFIX . "_document_fields
								WHERE Id = '" . $fld_id . "'
								AND DokumentId = '" . $id . "'
							")
							->FetchRow();

							if (!$row_df) continue;

							if ($row_df->Suche == $suche && $row_df->Inhalt == $this->_prettyChars(stripslashes($fld_val))) continue;

							if (!checkPermission('docs_php'))
							{
								if (isPhpCode($fld_val)) continue;
							}

							$fld_val = preClear($fld_val);
							$fld_val = $this->_prettyChars($fld_val);

							$AVE_DB->Query("
								UPDATE " . PREFIX . "_document_fields
								SET
									Inhalt = '" . $fld_val . "' ,
									Suche  = '" . $suche . "'
								WHERE
									Id = '" . $fld_id . "'
							");
						}
					}

					// Очищаем кэш шаблона
					$AVE_DB->Query("
						DELETE
						FROM " . PREFIX . "_rubric_template_cache
						WHERE doc_id = '" . $id . "'
					");

					reportLog($_SESSION['user_name'] . ' - отредактировал документ (' . $id . ')', 2, 2);
				}

				if (isset($_REQUEST['closeafter']) && $_REQUEST['closeafter']==1)
				{
					echo '<script>window.opener.location.reload(); window.close();</script>';
					exit;
				}

				echo '<script>window.opener.location.reload();</script>';

				$AVE_Template->assign('name_empty', $AVE_Template->get_config_vars('DOC_TOP_MENU_ITEM'));
				$AVE_Template->assign('innavi', 0);
				$AVE_Template->assign('Id', $id);
				$AVE_Template->assign('RubrikId', $row->RubrikId);
				$AVE_Template->assign('content', $AVE_Template->fetch('documents/form_after.tpl'));
				break;

			case '':
				$document = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_documents
					WHERE Id = '" . $id . "'
				")
				->FetchRow();

				$show = true;

				$this->_fetchDocPerms($document->RubrikId);

				// запрещаем доступ
				// если автору документа не разрешено изменять свои документы в рубрике
				// или пользователю не разрешено изменять все документы в рубрике
				if ( ($document->Redakteur == $_SESSION['user_id'] && @$_SESSION[$document->RubrikId . '_editown'] == 1)
					|| @$_SESSION[$document->RubrikId . '_editall'] == 1)
				{
				}
				else
				{
					$show = false;
				}
				// запрещаем доступ к главной странице и странице ошибки 404 если требуется одобрение Администратора
				if ( ($id == 1 || $id == PAGE_NOT_FOUND_ID) && @$_SESSION[$document->RubrikId . '_newnow'] != 1 )
				{
					$show = false;
				}
				// разрешаем доступ если пользователь принадлежит группе Администраторов или имеет все права на рубрику
				if ( (defined('UGROUP') && UGROUP == 1)
					|| (isset($_SESSION[$document->RubrikId . '_alles']) && $_SESSION[$document->RubrikId . '_alles'] == 1) )
				{
					$show = true;
				}

				if ($show)
				{
					$fields = array();

					if (isset($_SESSION[$document->RubrikId . '_newnow']) && $_SESSION[$document->RubrikId . '_newnow'] == 1)
					{
						$document->dontChangeStatus = 0;
					}
					else
					{
						$document->dontChangeStatus = 1;
					}

					$sql = $AVE_DB->Query("
						SELECT
							doc.Id AS df_id,
							rub.*,
							StdWert,
							Inhalt
						FROM " . PREFIX . "_rubric_fields AS rub
						LEFT JOIN " . PREFIX . "_document_fields AS doc ON RubrikFeld = rub.Id
						WHERE DokumentId = '" . $id . "'
						ORDER BY rubric_position ASC
					");
					while ($row = $sql->FetchRow())
					{
						$row->Feld = $this->_getField($row->RubTyp, $row->Inhalt, $row->df_id, $row->StdWert);
						array_push($fields, $row);
					}

					$document->fields = $fields;
					$document->rubric_name = $this->_showRubName($document->RubrikId)->RubrikName;
					$document->rubric_url_prefix = $this->_showRubName($document->RubrikId)->UrlPrefix;
					$document->formaction = 'index.php?do=docs&action=edit&sub=save&Id=' . $id . '&cp=' . SESSION;

					$AVE_Template->assign('document', $document);
					$AVE_Template->assign('content', $AVE_Template->fetch('documents/form.tpl'));
				}
				else
				{
					$AVE_Template->assign('content', $AVE_Template->get_config_vars('DOC_NO_PERMISSION'));
				}
				break;
		}
	}

	/**
	 * Пометить Документ для удаления
	 *
	 * @param int $id идентификатор Документа
	 */
	function delDoc($id)
	{
		global $AVE_DB;

		$row = $AVE_DB->Query("
			SELECT
				Id,
				RubrikId,
				Redakteur
			FROM " . PREFIX . "_documents
			WHERE Id = '" . $id . "'
		")
		->FetchRow();

		if ( (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row->Redakteur)
			&& (isset($_SESSION[$row->RubrikId . '_editown']) && $_SESSION[$row->RubrikId . '_editown'] == 1)
			|| (isset($_SESSION[$row->RubrikId . '_alles']) && $_SESSION[$row->RubrikId . '_alles'] == 1)
			|| (defined('UGROUP') && UGROUP == 1) )
		{
			if ($id != 1 && $id != PAGE_NOT_FOUND_ID)
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_documents
					SET Geloescht = 1
					WHERE Id = '" . $id . "'
				");
				reportLog($_SESSION['user_name'] . ' - временно удалил документ (' . $id . ')', 2, 2);
			}
		}
		header('Location:index.php?do=docs&cp=' . SESSION);

	}

	/**
	 * Отменить пометку удаления
	 *
	 * @param int $id идентификатор Документа
	 */
	function redelDoc($id)
	{
		global $AVE_DB;

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_documents
			SET Geloescht = 0
			WHERE Id = '" . $id . "'
		");

		reportLog($_SESSION['user_name'] . ' - восстановил удаленный документ (' . $id . ')', 2, 2);

		header('Location:index.php?do=docs&cp=' . SESSION);
	}

	/**
	 * Уничтожить Документ без возможности восстановления
	 *
	 * @param int $id идентификатор Документа
	 */
	function enddelDoc($id)
	{
		global $AVE_DB;

		if ($id != 1 && $id != PAGE_NOT_FOUND_ID)
		{
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_documents
				WHERE Id = '" . $id . "'
			");
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_document_fields
				WHERE DokumentId = '" . $id . "'
			");

			// Очищаем кэш шаблона
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_rubric_template_cache
				WHERE doc_id = '" . $id . "'
			");

			reportLog($_SESSION['user_name'] . ' - окончательно удалил документ (' . $id . ')', 2, 2);
		}

		header('Location:index.php?do=docs&cp=' . SESSION);
	}

	/**
	 * Опубликовать/Отменить публикацию Документа
	 *
	 * @param int $id идентификатор Документа
	 * @param string $openclose статус Документа {open|close}
	 */
	function openCloseDoc($id, $openclose)
	{
		global $AVE_DB;

		$row = $AVE_DB->Query("
			SELECT
				RubrikId,
				Redakteur
			FROM " . PREFIX . "_documents
			WHERE Id = '" . $id . "'
		")
		->FetchRow();

		if ( ($row->Redakteur == @$_SESSION['user_id'])
			&& (isset($_SESSION[$row->RubrikId . '_newnow']) && @$_SESSION[$row->RubrikId . '_newnow'] == 1)
			|| @$_SESSION[$row->RubrikId . '_alles'] == 1
			|| UGROUP == 1)
		{
			if ($id != 1 && $id != PAGE_NOT_FOUND_ID)
			{
				$AVE_DB->Query("
					UPDATE " . PREFIX . "_documents
					SET DokStatus = '" . $openclose . "'
					WHERE Id = '" . $id . "'
				");

				reportLog($_SESSION['user_name'] . ' - ' . (($openclose=='open') ? 'активировал' : 'деактивировал') . ' документ (' . $id . ')', 2, 2);
			}
		}

		header('Location:index.php?do=docs&cp=' . SESSION);
	}

	/**
	 * Передача в Smarty меток периода времени отображаемых в списке Документов
	 *
	 */
	function tplTimeAssign()
	{
		global $AVE_Template;

		if (!empty($_REQUEST['TimeSelect']))
		{
			$AVE_Template->assign('sel_start', $this->_selectStart());
			$AVE_Template->assign('sel_ende', $this->_selectEnde());
		}
	}

	/**
	 * Формирование прав доступа Групп пользователей на все Рубрики
	 *
	 */
	function rediRubs()
	{
		global $AVE_DB, $AVE_Template;

		$items = array();
		$sql = $AVE_DB->Query("
			SELECT
				Id,
				RubrikName
			FROM " . PREFIX . "_rubrics
		");
		while ($row = $sql->FetchRow())
		{
			$this->_fetchDocPerms($row->Id);

			if (defined('UGROUP') && UGROUP == 1) $row->Show = 1;
			elseif (isset($_SESSION[$row->Id . '_editown']) && $_SESSION[$row->Id . '_editown'] == 1) $row->Show = 1;
			elseif (isset($_SESSION[$row->Id . '_editall']) && $_SESSION[$row->Id . '_editall'] == 1) $row->Show = 1;
			elseif (isset($_SESSION[$row->Id . '_new'])     && $_SESSION[$row->Id . '_new']     == 1) $row->Show = 1;
			elseif (isset($_SESSION[$row->Id . '_newnow'])  && $_SESSION[$row->Id . '_newnow']  == 1) $row->Show = 1;
			elseif (isset($_SESSION[$row->Id . '_alles'])   && $_SESSION[$row->Id . '_alles']   == 1) $row->Show = 1;

			array_push($items, $row);
			unset($row);
		}
		$AVE_Template->assign('rubrics', $items);
	}

	/**
	 * Перенос Документа в другую рубрику
	 *
	 */
	function changeRubs()
	{
		global $AVE_DB, $AVE_Template;

		if ((!empty($_POST['NewRubr'])) and (!empty($_GET['Id'])))
		{
			foreach ($_POST as $key=>$value)
			{
				if (is_integer($key))
				{
					switch ($value)
					{
						case 0:
							$AVE_DB->Query("
								DELETE
								FROM " . PREFIX . "_document_fields
								WHERE DokumentId = '" . (int)$_REQUEST['Id'] . "'
								AND RubrikFeld = '" . $key . "'
							");
							break;

						case -1:
							//информация о старом поле
							$row_fd = $AVE_DB->Query("
								SELECT
									Titel,
									RubTyp
								FROM " . PREFIX . "_rubric_fields
								WHERE Id = '" . $key . "'
							")
							->FetchRow();

							//последняя позиция в новой рубрике
							$new_pos = $AVE_DB->Query("
								SELECT rubric_position
								FROM " . PREFIX . "_rubric_fields
								WHERE RubrikId = '" . (int)$_POST['NewRubr'] . "'
								ORDER BY rubric_position DESC
								LIMIT 1
							")
							->GetCell();
							++$new_pos;

							//создаем новое поле
							$AVE_DB->Query("
								INSERT
								INTO " . PREFIX . "_rubric_fields
								SET
									RubrikId        = '" . (int)$_POST['NewRubr'] . "',
									Titel           = '" . addslashes($row_fd->Titel) . "',
									RubTyp          = '" . $row_fd->RubTyp . "',
									rubric_position = '" . $new_pos . "'
							");

							//добавляем запись о поле в таблицу с полями документов
							$lastid = $AVE_DB->InsertId();
							$sql_docs = $AVE_DB->Query("
								SELECT Id
								FROM " . PREFIX . "_documents
								WHERE RubrikId = '" . (int)$_POST['NewRubr'] . "'
							");
							while ($row_docs = $sql_docs->FetchRow())
							{
								$AVE_DB->Query("
									INSERT
									INTO " . PREFIX . "_document_fields
									SET
										RubrikFeld = '" . $lastid . "',
										DokumentId = '" . $row_docs->Id . "',
										Inhalt     = '',
										Suche      = '1'
								");
							}

							//создаем новое поле для изменяемого документа
							$AVE_DB->Query("
								UPDATE " . PREFIX . "_document_fields
								SET RubrikFeld = '" . $lastid . "'
								WHERE RubrikFeld = '" . $key . "'
								AND DokumentId = '" . (int)$_REQUEST['Id'] . "'
							");

							break;

						default:
							$AVE_DB->Query("
								UPDATE " . PREFIX . "_document_fields
								SET RubrikFeld = '" . $value . "'
								WHERE RubrikFeld = '" . $key . "'
								AND DokumentId = '" . (int)$_REQUEST['Id'] . "'
							");
							break;
					}
				}
			}

			//получаем список всех полей новой рубрики
			$sql_rub = $AVE_DB->Query("
				SELECT Id
				FROM " . PREFIX . "_rubric_fields
				WHERE RubrikId = '" . (int)$_POST['NewRubr'] . "'
				ORDER BY Id ASC
			");

			//проверяем наличие нужных полей
			while ($row_rub = $sql_rub->FetchRow())
			{
				$num = $AVE_DB->Query("
					SELECT COUNT(*)
					FROM " . PREFIX . "_document_fields
					WHERE RubrikFeld = '" . $row_rub->Id . "'
					AND DokumentId = '" . (int)$_REQUEST['Id'] . "'
				")
				->GetCell();

				//если поля нет, тогда создадим его
				if ($num == 0)
				{
					$AVE_DB->Query("
						INSERT " . PREFIX . "_document_fields
						SET
							RubrikFeld = '" . $row_rub->Id . "',
							DokumentId = '" . (int)$_REQUEST['Id'] . "',
							Inhalt     = '',
							Suche      = '1'
					");
				}
			}
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_documents
				SET RubrikId = '" . (int)$_POST['NewRubr'] . "'
				WHERE Id = '" . (int)$_REQUEST['Id'] . "'
			");

			echo '<script>window.opener.location.reload(); window.close();</script>';
		}
		else
		{
			$fields = array();

			if ((!empty($_GET['NewRubr'])) and ((int)$_REQUEST['RubrikId'] != (int)$_GET['NewRubr']))
			{
				//выбираем все поля новой рубрики
				$sql_rub = $AVE_DB->Query("
					SELECT
						Id,
						Titel,
						RubTyp
					FROM " . PREFIX . "_rubric_fields
					WHERE RubrikId = '" . (int)$_GET['NewRubr'] . "'
					ORDER BY Id ASC
				");
				$mass_new_rubr = array();
				while ($row_rub = $sql_rub->FetchRow())
				{
					$mass_new_rubr[] = array('Id'=>$row_rub->Id, 'Titel'=>$row_rub->Titel, 'RubTyp'=>$row_rub->RubTyp);
				}

				//обрабатываем все поля старой рубрики
				$sql_old_rub = $AVE_DB->Query("
					SELECT
						Id,
						Titel,
						RubTyp
					FROM " . PREFIX . "_rubric_fields
					WHERE RubrikId = '" . (int)$_REQUEST['RubrikId'] . "'
					ORDER BY Id ASC
				");
				while ($row_nr = $sql_old_rub->FetchRow()) {
					$type = $row_nr->RubTyp;
					$option_arr = array('0'=>$AVE_Template->get_config_vars('DOC_CHANGE_DROP_FIELD'), '-1'=>$AVE_Template->get_config_vars('DOC_CHANGE_CREATE_FIELD'));
					$selected = -1;
					foreach ($mass_new_rubr as $row)
					{
						if ($row['RubTyp'] == $type)
						{
							$option_arr[$row['Id']] = $row['Titel'];
							if ($row_nr->Titel == $row['Titel'])
							{
								$selected = $row['Id'];
							}
						}
					}
					$fields[$row_nr->Id] = array('Titel'=>$row_nr->Titel, 'Options'=>$option_arr, 'Selected'=>$selected);
				}
			}

			$AVE_Template->assign('fields', $fields);
			$AVE_Template->assign('formaction', 'index.php?do=docs&action=change&Id=' . (int)$_REQUEST['Id'] . '&RubrikId=' . (int)$_REQUEST['RubrikId'] . '&pop=1&cp=' . SESSION);
			$AVE_Template->assign('content', $AVE_Template->fetch('documents/change.tpl'));
		}
	}

	/**
	 * Транслитерация URL
	 *
	 */
	function translit()
	{
		$alias = empty($_REQUEST['alias']) ? '' : cpParseLinkname(iconv("UTF-8", "WINDOWS-1251", $_REQUEST['alias']));
		$title = empty($_REQUEST['title']) ? '' : cpParseLinkname(iconv("UTF-8", "WINDOWS-1251", $_REQUEST['title']));
		$prefix = empty($_REQUEST['prefix']) ? '' : cpParseLinkname(iconv("UTF-8", "WINDOWS-1251", $_REQUEST['prefix']));

		if ($alias != $title && $alias != trim($prefix . '/' . $title, '/')) $alias = trim($alias . '/' . $title, '/');

		return $alias;
	}

	/**
	 * Контроль уникальности URL
	 *
	 */
	function checkurl()
	{
		global $AVE_DB, $AVE_Template;

		$id = (!empty($_REQUEST['id']) && is_numeric($_REQUEST['id'])) ? $_REQUEST['id'] : 0;
		$alias = (!empty($_REQUEST['alias'])) ? $_REQUEST['alias'] : '';

		$errors = array();

		if (!empty($alias))
		{
			if (preg_match('/[^0-9a-z\/-]+/', $alias)) $errors[] = $AVE_Template->get_config_vars('DOC_URL_ERROR_SYMBOL');

			if ($alias[0] == '/') $errors[] = $AVE_Template->get_config_vars('DOC_URL_ERROR_START');

			if (substr($alias, -1) == '/') $errors[] = $AVE_Template->get_config_vars('DOC_URL_ERROR_END');

			$matches = preg_grep('/^(apage-\d+|artpage-\d+|page-\d+|print)$/i', explode('/', $alias));
			if (!empty($matches)) $errors[] = $AVE_Template->get_config_vars('DOC_URL_ERROR_SEGMENT') . implode(', ', $matches);

			if (empty($errors))
			{
				$url_exist = $AVE_DB->Query("
					SELECT COUNT(*)
					FROM " . PREFIX . "_documents
					WHERE Url = '" . $alias . "'
					AND Id != " . $id . "
					LIMIT 1
				")->GetCell();
				if ($url_exist) $errors[] = $AVE_Template->get_config_vars('DOC_URL_ERROR_DUPLICATES');
			}
		}
		else
		{
			$errors[] = $AVE_Template->get_config_vars('DOC_URL_ERROR_EMTY');
		}

		if (empty($errors))
		{
			return '<font class="checkUrlOk">' . $AVE_Template->get_config_vars('DOC_URL_CHECK_OK') . '</font>';
		}
		else
		{
			return '<font class="checkUrlErr">' . implode(', ', $errors) . '</font>';
		}
	}

	/**
	 *	Управление Заметками
	 */

	/**
	 * Просмотр и Добавление Заметок к Документу
	 *
	 * @param int $reply признак ответа на Заметку
	 */
	function newComment($reply = '')
	{
		global $AVE_DB, $AVE_Template, $AVE_Globals;

		$doc_id = (int)$_REQUEST['Id'];
		if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			if (!empty($_REQUEST['Kommentar']) && checkPermission('docs_comments') && $_REQUEST['reply'] != 1)
			{
				$AVE_DB->Query("
					INSERT " . PREFIX . "_document_comments
					SET
						DokumentId     = '" . $doc_id . "',
						Titel          = '" . preClear($_REQUEST['Titel']) . "',
						Kommentar      = '" . substr(preClear($_REQUEST['Kommentar']), 0, $this->_max_comment_length) . "',
						Author         = '" . $_SESSION['user_name'] . "',
						Zeit           = '" . time() . "',
						KommentarStart = 1,
						AntwortEMail   = '" . $_SESSION['user_email'] . "'
				");
			}
			header('Location:index.php?do=docs&action=comment_reply&Id=' . $doc_id . '&pop=1&cp=' . SESSION);
		}

		if ($reply == 1)
		{
			if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
			{
				if (!empty($_REQUEST['Kommentar']) && checkPermission('docs_comments'))
				{
					$AntwortEMail = $AVE_DB->Query("
						SELECT AntwortEMail
						FROM  " . PREFIX . "_document_comments
						WHERE KommentarStart = 1
						AND DokumentId = '" . $doc_id . "'
					")
					->GetCell();

					$AVE_DB->Query("
						INSERT " . PREFIX . "_document_comments
						SET
							DokumentId     = '" . $doc_id . "',
							Titel          = '" . preClear($_REQUEST['Titel']) . "',
							Kommentar      = '" . substr(preClear($_REQUEST['Kommentar']), 0, $this->_max_comment_length) . "',
							Author         = '" . $_SESSION['user_name'] . "',
							Zeit           = '" . time() . "',
							KommentarStart = 0,
							AntwortEMail   = '" . $_SESSION['user_email'] . "'
					");
				}

				$system_mail = $AVE_Globals->mainSettings('mail_from');
				$system_mail_name = $AVE_Globals->mainSettings('mail_from_name');

				// Письмо автору
				$host = explode('?', redirectLink());
				$host_real .= substr($host[0], 0, -9) . 'index.php?do=docs&doc_id=' . $doc_id;

				$body_toadmin = $AVE_Template->get_config_vars('DOC_MAIL_BODY_NOTICE');
				$body_toadmin = str_replace('%N%', "\n", $body_toadmin);
				$body_toadmin = str_replace('%TITLE%', stripslashes($_POST['Titel']), $body_toadmin);
				$body_toadmin = str_replace('%USER%', $_SESSION['user_name'], $body_toadmin);
				$body_toadmin = str_replace('%LINK%', $host_real, $body_toadmin);
				$AVE_Globals->cp_mail($AntwortEMail, $body_toadmin, $AVE_Template->get_config_vars('DOC_MAIL_SUBJECT_NOTICE'), $system_mail, $system_mail_name, 'text', '');

				header('Location:index.php?do=docs&action=comment_reply&Id=' . $doc_id . '&pop=1&cp=' . SESSION);
			}

			$num = $AVE_DB->Query("
				SELECT COUNT(*)
				FROM " . PREFIX . "_document_comments
				WHERE DokumentId = '" . $doc_id . "'
			")
			->GetCell();

			$limit = 10;
			$seiten = ceil($num / $limit);
			$start = prepage() * $limit - $limit;

			$answers = array();
			$sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_document_comments
				WHERE DokumentId = '" . $doc_id . "'
				ORDER BY Id DESC
				LIMIT " . $start . "," . $limit
			);
			while ($row = $sql->FetchAssocArray())
			{
				$row['Kommentar'] = nl2br($row['Kommentar']);
				array_push($answers, $row);
			}

			$row_a = $AVE_DB->Query("
				SELECT Aktiv
				FROM " . PREFIX . "_document_comments
				WHERE DokumentId = '" . $doc_id . "'
				AND KommentarStart = 1
			")
			->FetchAssocArray();

			if ($num > $limit)
			{
				$template_label = " <a class=\"pnav\" href=\"index.php?do=docs&action=comment_reply&Id=" . $doc_id . "&page={s}&pop=1&cp=" . SESSION . "\">{t}</a> ";
				$page_nav = pagenav($seiten, 'page', $template_label);
				$AVE_Template->assign('page_nav', $page_nav);
			}

			$AVE_Template->assign('row_a', $row_a);
			$AVE_Template->assign('answers', $answers);
			$AVE_Template->assign('reply', 1);
			$AVE_Template->assign('formaction', 'index.php?do=docs&action=comment_reply&sub=save&Id=' . $doc_id . '&reply=1&cp=' . SESSION);
			$AVE_Template->assign('content', $AVE_Template->fetch('documents/newcomment.tpl'));
		}
		else
		{
			$AVE_Template->assign('reply', 1);
			$AVE_Template->assign('new', 1);
			$AVE_Template->assign('formaction', 'index.php?do=docs&action=comment&sub=save&Id=' . $doc_id . '&cp=' . SESSION);
			$AVE_Template->assign('content', $AVE_Template->fetch('documents/newcomment.tpl'));
		}
	}

	/**
	 * Разрешить/Запретить создавать Заметки
	 *
	 */
	function openCloseDiscussion()
	{
		global $AVE_DB;

		$AVE_DB->Query("
			UPDATE " . PREFIX . "_document_comments
			SET Aktiv = '" . (int)$_REQUEST['Aktiv'] . "'
			WHERE KommentarStart = 1
			AND DokumentId = '" . (int)$_REQUEST['Id'] . "'
		");

		header('Location:index.php?do=docs&action=comment_reply&Id=' . (int)$_REQUEST['Id'] . '&pop=1&cp=' . SESSION);
		exit;
	}

	/**
	 * Удаление Заметок и ответов на них
	 *
	 * @param int $start признак удаления всех Заметок (1 - удалить все)
	 */
	function delComment($start)
	{
		global $AVE_DB;

		if ($start == 1)
		{
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_document_comments
				WHERE DokumentId = '" . (int)$_REQUEST['Id'] . "'
			");

			header('Location:index.php?do=docs&action=comment&Id=' . (int)$_REQUEST['Id'] . '&pop=1&cp=' . SESSION);
			exit;
		}
		else
		{
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_document_comments
				WHERE DokumentId = '" . (int)$_REQUEST['Id'] . "'
				AND Id = '" . (int)$_REQUEST['CId'] . "'
			");

			header('Location:index.php?do=docs&action=comment_reply&Id=' . (int)$_REQUEST['Id'] . '&pop=1&cp=' . SESSION);
			exit;
		}
	}

/**
 *	ВНУТРЕННИЕ МЕТОДЫ
 */

	/**
	 * Формирование поля Документа с элементами управления этим полем
	 *
	 * @param string $rub_typ тип поля
	 * @param string $inhalt содержимое поля
	 * @param int $id идентификатор поля
	 * @param string $drop значения для поля типа "Выпадающий список"
	 * @return string HTML-код поля Документа
	 */
	function _getField($rub_typ, $inhalt, $id, $drop = '')
	{
		global $AVE_Globals, $AVE_Template;

		$img_pixel = 'templates/' . $_SESSION['admin_theme'] . '/images/blanc.gif';
		$feld = '';

		switch ($rub_typ)
		{
			case 'kurztext' :
				$feld  = '<a name="' . $id . '"></a>';
				$feld .= '<input id="feld_' . $id . '" type="text" style="width:' . $this->_field_width . '" name="feld[' . $id . ']" value="' . htmlspecialchars($inhalt, ENT_QUOTES) . '"> ';
				break;

			case 'langtext' :
				if (isset($_COOKIE['no_wysiwyg']) && $_COOKIE['no_wysiwyg'] == 1)
				{
					$feld  = '<a name="' . $id . '"></a>';
					$feld .= '<textarea style="width:' . $this->_textarea_width . ';height:' . $this->_textarea_height . '" name="feld[' . $id . ']">' . $inhalt . '</textarea>';
				}
				else
				{
					$oFCKeditor = new FCKeditor('feld[' . $id . ']') ;
					$oFCKeditor->Height = $this->_textarea_height;
					$oFCKeditor->Value  = $inhalt;
					$feld  = $oFCKeditor->Create($id);
				}
				break;

			case 'smalltext' :
				if (isset($_COOKIE['no_wysiwyg']) && $_COOKIE['no_wysiwyg'] == 1)
				{
					$feld  = "<a name=\"" . $id . "\"></a>";
					$feld .= "<textarea style=\"width:" . $this->_textarea_width_small . "; height:" . $this->_textarea_height_small . "\"  name=\"feld[" . $id . "]\">" . $inhalt . "</textarea>";
				}
				else
				{
					$oFCKeditor = new FCKeditor('feld[' . $id . ']') ;
					$oFCKeditor->Height = $this->_textarea_height_small;
					$oFCKeditor->Value  = $inhalt;
					$oFCKeditor->ToolbarSet = 'cpengine_small';
					$feld = $oFCKeditor->Create($id);
				}
				break;

//			case 'created' :
//				$inhalt = (isset($_REQUEST['action']) && $_REQUEST['action'] == 'new') ? strftime(TIME_FORMAT) : $inhalt;
//				$inhalt = pretty_date($inhalt, DEFAULT_LANGUAGE);
//				if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'new')
//				{
//					$feld  = "<a name=\"" . $id . "\"></a>";
//					$feld .= "<input id=\"feld_" . $id . "\" type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $id . "]\" value=\"" . htmlspecialchars($inhalt, ENT_QUOTES) . "\">";
//				}
//				else
//				{
//					$feld  = "<a name=\"" . $id . "\"></a>";
//					$feld .= "<input id=\"feld_" . $id . "\" type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $id . "]\" value=\"" . htmlspecialchars($inhalt, ENT_QUOTES) . "\">&nbsp;";
//					$feld .= "<input type=\"button\" value=\"Текущая дата\" class=\"button\" onclick=\"insert_now_date('feld_" . $id . "');\" />";
//				}
//				break;
//
//			case 'author':
//				$inhalt = (isset($_REQUEST['action']) && $_REQUEST['action'] == 'new') ? $_SESSION['user_name'] : $inhalt;
//				$feld  = "<a name=\"" . $id . "\"></a>";
//				$feld .= "<input id=\"feld_" . $id . "\" type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $id . "]\" value=\"" . htmlspecialchars($inhalt, ENT_QUOTES) . "\"> ";
//				break;
//
			case 'bild' :
			case 'bild_links' :
			case 'bild_rechts' :
				$massiv = explode('|', $inhalt);
				$feld  = "<a name=\"" . $id . "\"></a>";
				$feld .= "<div id=\"feld_" . $id . "\"><img id=\"_img_feld__" . $id . "\" src=\"" . (!empty($inhalt) ? '../index.php?thumb=' . htmlspecialchars($massiv[0], ENT_QUOTES) : $img_pixel) . "\" alt=\"" . (isset($massiv[1]) ? htmlspecialchars($massiv[1], ENT_QUOTES) : '') . "\" border=\"0\" /></div>";
				$feld .= "<div style=\"display:none\" id=\"span_feld__" . $id . "\">&nbsp;</div>" . (!empty($inhalt) ? "<br />" : '');
				$feld .= "<input type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $id . "]\" value=\"" . htmlspecialchars($inhalt, ENT_QUOTES) . "\" id=\"img_feld__" . $id . "\" />&nbsp;";
				$feld .= "<input value=\"" . $AVE_Template->get_config_vars('MAIN_OPEN_MEDIAPATH') . "\" class=\"button\" type=\"button\" onclick=\"cp_imagepop('img_feld__" . $id . "', '', '', '0');\" />";
				break;

			case 'javascript' :
			case 'php' :
			case 'code' :
			case 'html' :
			case 'js' :
				$feld  = "<a name=\"" . $id . "\"></a>";
				$feld .= "<textarea id=\"feld_" . $id . "\" style=\"width:" . $this->_textarea_width . "; height:" . $this->_textarea_height . "\"  name=\"feld[" . $id . "]\">" . $inhalt . "</textarea>";
				break;

			case 'flash' :
				$feld  = "<a name=\"" . $id . "\"></a>";
				$feld .= "<div style=\"display:none\" id=\"feld_" . $id . "\"><img style=\"display:none\" id=\"_img_feld__" . $id . "\" src=\"". (!empty($inhalt) ? htmlspecialchars($inhalt, ENT_QUOTES) : $img_pixel) . "\" alt=\"\" border=\"0\" /></div>";
				$feld .= "<div style=\"display:none\" id=\"span_feld__" . $id . "\"></div>";
				$feld .= "<input type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $id . "]\" value=\"" . htmlspecialchars($inhalt, ENT_QUOTES) . "\" id=\"img_feld__" . $id . "\" />&nbsp;";
				$feld .= "<input value=\"" . $AVE_Template->get_config_vars('MAIN_OPEN_MEDIAPATH') . "\" class=\"button\" type=\"button\" onclick=\"cp_imagepop('img_feld__" . $id . "', '', '', '0');\" />";
				$feld .= '<input style="margin-left:5px" class="button" type="button" value="?" onmouseover="return overlib(\'' . $AVE_Template->get_config_vars('DOC_FLASH_TYPE_HELP') . '\',ABOVE,WIDTH,300);" onmouseout="nd();" style="cursor: help;">';
				break;

			case 'download' :
				$feld  = "<div style=\"\" id=\"feld_" . $id . "\"><a name=\"" . $id . "\"></a>";
				$feld .= "<div style=\"display:none\" id=\"feld_" . $id . "\">";
				$feld .= "<img style=\"display:none\" id=\"_img_feld__" . $id . "\" src=\"" . (!empty($inhalt) ? htmlspecialchars($inhalt, ENT_QUOTES) : $img_pixel) . "\" alt=\"\" border=\"0\" /></div>";
				$feld .= "<div style=\"display:none\" id=\"span_feld__" . $id . "\"></div>";
				$feld .= "<input type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $id . "]\" value=\"" . htmlspecialchars($inhalt, ENT_QUOTES) . "\" id=\"img_feld__" . $id . "\" />&nbsp;";
				$feld .= "<input value=\"" . $AVE_Template->get_config_vars('MAIN_OPEN_MEDIAPATH') . "\" class=\"button\" type=\"button\" onclick=\"cp_imagepop('img_feld__" . $id . "', '', '', '0');\" />";
				$feld .= '<input style="margin-left:5px" class="button" type="button" value="?" onmouseover="return overlib(\'' . $AVE_Template->get_config_vars('DOC_FILE_TYPE_HELP') . '\',ABOVE,WIDTH,300);" onmouseout="nd();" style="cursor: help;">';
				$feld .= '</div>';
				break;

			case 'video_avi' :
			case 'video_wmf' :
			case 'video_wmv' :
			case 'video_mov' :
				$feld  = "<div style=\"\" id=\"feld_" . $id . "\"><a name=\"" . $id . "\"></a>";
				$feld .= "<div style=\"display:none\" id=\"feld_" . $id . "\"><img style=\"display:none\" id=\"_img_feld__" . $id . "\" src=\"". (!empty($inhalt) ? htmlspecialchars($inhalt, ENT_QUOTES) : $img_pixel) . "\" alt=\"\" border=\"0\" /></div>";
				$feld .= "<div style=\"display:none\" id=\"span_feld__" . $id . "\"></div>";
				$feld .= "<input type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $id . "]\" value=\"" . htmlspecialchars($inhalt, ENT_QUOTES) . "\" id=\"img_feld__" . $id . "\" />&nbsp;";
				$feld .= "<input value=\"" . $AVE_Template->get_config_vars('MAIN_OPEN_MEDIAPATH') . "\" class=\"button\" type=\"button\" onclick=\"cp_imagepop('img_feld__" . $id . "', '', '', '0');\" />";
				$feld .= '<input style="margin-left:5px" class="button" type="button" value="?" onmouseover="return overlib(\'' . $AVE_Template->get_config_vars('DOC_VIDEO_TYPE_HELP') . '\',ABOVE,WIDTH,300);" onmouseout="nd();" style="cursor: help;">';
				$feld .= '</div>';
				break;

			case 'dropdown' :
				$items = explode(',', $drop);
				$feld = "<select name=\"feld[" . $id . "]\">";
				$cnt = sizeof($items);
				for ($i=0;$i<$cnt;$i++)
				{
					$feld .= "<option value=\"" . htmlspecialchars($items[$i], ENT_QUOTES) . "\"" . ((trim($inhalt) == trim($items[$i])) ? " selected=\"selected\"" : "") . ">" . htmlspecialchars($items[$i], ENT_QUOTES) . "</option>";
				}
				$feld .= "</select>";
				break;

			case 'link' :
			case 'link_ex' :
				$feld  = "<a name=\"" . $id . "\"></a>";
				$feld .= "<input id=\"feld_" . $id . "\" type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $id . "]\" value=\"" . htmlspecialchars($inhalt, ENT_QUOTES) . "\">&nbsp;";
				$feld .= "<input value=\"" . $AVE_Template->get_config_vars('MAIN_BROWSE_DOCUMENTS') . "\" class=\"button\" type=\"button\" onclick=\"openLinkWin('feld_" . $id . "', 'feld_" . $id . "');\" />";
				break;
		}

		return $feld;
	}

	/**
	 * Формирование метки времени начала периода для списка Документов
	 *
	 * @return int метка времени Unix
	 */
	function _selectStart()
	{
		return mktime(0, 0, 1, $_REQUEST['DokStartMonth'], $_REQUEST['DokStartDay'], $_REQUEST['DokStartYear']);
	}

	/**
	 * Формирование метки времени окончания периода для списка Документов
	 *
	 * @return int метка времени Unix
	 */
	function _selectEnde()
	{
		return mktime(23, 59, 59, $_REQUEST['DokEndeMonth'], $_REQUEST['DokEndeDay'], $_REQUEST['DokEndeYear']);
	}

	/**
	 * Формирование метки времени начала публикации Документа
	 *
	 * @return int метка времени Unix
	 */
	function _dokStart()
	{
		$start = 0;
		if (!empty($_REQUEST['DokStartDay']) && !empty($_REQUEST['DokStartYear']) &&  !empty($_REQUEST['DokStartMonth']))
		{
			$start = mktime($_REQUEST['StartHour'], $_REQUEST['StartMinute'] , 0, $_REQUEST['DokStartMonth'], $_REQUEST['DokStartDay'], $_REQUEST['DokStartYear']);
		}

		return $start;
	}

	/**
	 * Формирование метки времени окончания публикации Документа
	 *
	 * @return int метка времени Unix
	 */
	function _dokEnde()
	{
		$ende = 0;
		if (!empty($_REQUEST['DokEndeDay']) && !empty($_REQUEST['DokEndeYear']) && !empty($_REQUEST['DokEndeMonth']))
		{
			$ende = mktime($_REQUEST['EndeHour'], $_REQUEST['EndeMinute'] , 0, $_REQUEST['DokEndeMonth'], $_REQUEST['DokEndeDay'], $_REQUEST['DokEndeYear']);
		}

		return $ende;
	}

	/**
	 * Замена некоторых HTML-тэгов на предпочтительные аналоги
	 *
	 * @param string $code текст который необходимо обработать
	 * @return string обработанный текст
	 */
	function _prettyChars($code)
	{
		return preg_replace(
			array("'<b>'i", "'</b>'i", "'<i>'i", "'</i>'i", "'<br>'i", "'<br/>'i"),
			array('<strong>', '</strong>', '<em>', '</em>', '<br />', '<br />'),
			$code);
	}

	/**
	 * Формирование прав доступа Группы пользователей на Документы определённой Рубрики
	 *
	 * @param int $rub_id идентификатор Рубрики
	 */
	function _fetchDocPerms($rub_id)
	{
		global $AVE_DB, $doc_perms;

		if (isset($doc_perms[$rub_id])) return;
		$sql = $AVE_DB->Query("
			SELECT
				RubrikId,
				Rechte
			FROM " . PREFIX . "_document_permissions
			WHERE BenutzerGruppe = " . UGROUP . "
		");
		while ($row = $sql->FetchRow())
		{
			$doc_perms[$row->RubrikId] = 1;
			$row->Rechte = explode('|', $row->Rechte);
			foreach ($row->Rechte as $perm)
			{
				if (!empty($perm)) $_SESSION[$row->RubrikId . '_' . $perm] = 1;
			}
		}
	}

	/**
	 * Получить наименование Рубрики
	 *
	 * @param int $id идентификатор Рубрики
	 * @return string наименование Рубрики
	 */
	function _showRubName($id)
	{
		global $AVE_DB;

		static $rubrics = array();

		if (!isset($rubrics[$id]))
		{
			$rubrics[$id] = $AVE_DB->Query("
				SELECT
					RubrikName,
					UrlPrefix
				FROM " . PREFIX . "_rubrics
				WHERE Id = '" . $id . "'
				LIMIT 1
			")->fetchRow();
		}

		return $rubrics[$id];
	}
}

?>