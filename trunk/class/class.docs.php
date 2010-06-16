<?php

/**
 * AVE.cms
 *
 * Класс, предназначенный для управления документами в Панели управления
 *
 *
 * @package AVE.cms
 * @filesource
 */

class AVE_Document
{

/**
 *	Свойства класса
 */

	/**
	 * Количество документов отображаемых на одной странице
	 *
	 * @var int
	 */
	var $_limit = 15;

	/**
	 * Ширина поля ввода (для элементов input)
	 *
	 * @var string
	 */
	var $_field_width = '400px';

	/**
	 * Ширина многострочного поля ввода (для элементов textarea)
	 *
	 * @var string
	 */
	var $_textarea_width = '98%';

	/**
	 * Высота многострочного поля ввода (для элементов textarea)
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
	 * Высота маленького многострочного поля ввода (для элементов textarea)
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
 *	Внутренние методы класса
 */

	/**
	 * Метод, предназначенный для формирование метки времени, которая будет определять
     * начало периода показа списка Документов. Т.е. с какого числа/времени начать вывод списка документов.
	 *
	 * @return int	метка времени Unix
	 */
	function _documentListStart()
	{
		return mktime(0, 0, 1, $_REQUEST['DokStartMonth'], $_REQUEST['DokStartDay'], $_REQUEST['DokStartYear']);
	}

	/**
	 * Метод, предназначенный для формирование метки времени, которая будет определять
     * окончание периода показа списка Документов. Т.е. по какое число/время ограничить вывод списка документов.
	 *
	 * @return int	метка времени Unix
	 */
	function _documentListEnd()
	{
		return mktime(23, 59, 59, $_REQUEST['DokEndeMonth'], $_REQUEST['DokEndeDay'], $_REQUEST['DokEndeYear']);
	}

	/**
	 * Метод, предназначенный для формирование метки времени начала публикации Документа
	 *
	 * @return int	метка времени Unix
	 */
	function _documentStart()
	{
		$start = 0;
		if (!empty($_REQUEST['DokStartDay']) && !empty($_REQUEST['DokStartYear']) &&  !empty($_REQUEST['DokStartMonth']))
		{
			$start = mktime($_REQUEST['StartHour'], $_REQUEST['StartMinute'] , 0, $_REQUEST['DokStartMonth'], $_REQUEST['DokStartDay'], $_REQUEST['DokStartYear']);
		}

		return $start;
	}

	/**
	 * Метод, предназначенный для формирование метки времени окончания публикации Документа
	 *
	 * @return int	метка времени Unix
	 */
	function _documentEnd()
	{
		$ende = 0;
		if (!empty($_REQUEST['DokEndeDay']) && !empty($_REQUEST['DokEndeYear']) && !empty($_REQUEST['DokEndeMonth']))
		{
			$ende = mktime($_REQUEST['EndeHour'], $_REQUEST['EndeMinute'] , 0, $_REQUEST['DokEndeMonth'], $_REQUEST['DokEndeDay'], $_REQUEST['DokEndeYear']);
		}

		return $ende;
	}

	/**
	 * Метод, предназначенный для получения типа поля (изображения, однострочное поле, многострочный текст и т.д.),
     * а также формирования вспомогательных элементов управления этим полем (например кнопка)
	 *
	 * @param string $field_type	тип поля
	 * @param string $field_value	содержимое поля
	 * @param int    $field_id		идентификатор поля
	 * @param string $dropdown		значения для поля типа "Выпадающий список"
	 * @return string				HTML-код поля Документа
	 */
	function _documentFieldGet($field_type, $field_value, $field_id, $dropdown = '')
	{
		global $AVE_Template;

		// Определяем пустое изображение
        $img_pixel = ABS_PATH . 'templates/' . $_SESSION['admin_theme'] . '/images/blanc.gif';
		$feld = '';

		switch ($field_type)
		{
			// Правила формирования однострочного поля (input)
            case 'kurztext' :
				$feld  = '<a name="' . $field_id . '"></a>';
				$feld .= '<input id="feld_' . $field_id . '" type="text" style="width:' . $this->_field_width . '" name="feld[' . $field_id . ']" value="' . htmlspecialchars($field_value, ENT_QUOTES) . '"> ';
				break;

			// Правила формирования многострочного поля (textarea или FCKEditor в зависимости от настроек)
            case 'langtext' :
				if (isset($_COOKIE['no_wysiwyg']) && $_COOKIE['no_wysiwyg'] == 1)
				{
					$feld  = '<a name="' . $field_id . '"></a>';
					$feld .= '<textarea style="width:' . $this->_textarea_width . ';height:' . $this->_textarea_height . '" name="feld[' . $field_id . ']">' . $field_value . '</textarea>';
				}
				else
				{
					$oFCKeditor = new FCKeditor('feld[' . $field_id . ']') ;
					$oFCKeditor->Height = $this->_textarea_height;
					$oFCKeditor->Value  = $field_value;
					$feld  = $oFCKeditor->Create($field_id);
				}
				break;

			// Правила формирования упрощенного многострочного поля (textarea или FCKEditor в зависимости от настроек)
            case 'smalltext' :
				if (isset($_COOKIE['no_wysiwyg']) && $_COOKIE['no_wysiwyg'] == 1)
				{
					$feld  = "<a name=\"" . $field_id . "\"></a>";
					$feld .= "<textarea style=\"width:" . $this->_textarea_width_small . "; height:" . $this->_textarea_height_small . "\"  name=\"feld[" . $field_id . "]\">" . $field_value . "</textarea>";
				}
				else
				{
					$oFCKeditor = new FCKeditor('feld[' . $field_id . ']') ;
					$oFCKeditor->Height = $this->_textarea_height_small;
					$oFCKeditor->Value  = $field_value;
					$oFCKeditor->ToolbarSet = 'cpengine_small';
					$feld = $oFCKeditor->Create($field_id);
				}
				break;

//			case 'created' :
//				$field_value = (isset($_REQUEST['action']) && $_REQUEST['action'] == 'new') ? strftime(TIME_FORMAT) : $field_value;
//				$field_value = pretty_date($field_value, $_SESSION['user_language']);
//				if (isset($_REQUEST['action']) && $_REQUEST['action'] == 'new')
//				{
//					$feld  = "<a name=\"" . $field_id . "\"></a>";
//					$feld .= "<input id=\"feld_" . $field_id . "\" type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\">";
//				}
//				else
//				{
//					$feld  = "<a name=\"" . $field_id . "\"></a>";
//					$feld .= "<input id=\"feld_" . $field_id . "\" type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\">&nbsp;";
//					$feld .= "<input type=\"button\" value=\"Текущая дата\" class=\"button\" onclick=\"insert_now_date('feld_" . $field_id . "');\" />";
//				}
//				break;
//
//			case 'author':
//				$field_value = (isset($_REQUEST['action']) && $_REQUEST['action'] == 'new') ? $_SESSION['user_name'] : $field_value;
//				$feld  = "<a name=\"" . $field_id . "\"></a>";
//				$feld .= "<input id=\"feld_" . $field_id . "\" type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\"> ";
//				break;
//
			// Правила формирования поля типа Изображение
            case 'bild' :
			case 'bild_links' :
			case 'bild_rechts' :
				$massiv = explode('|', $field_value);
				$feld  = "<a name=\"" . $field_id . "\"></a>";
				$feld .= "<div id=\"feld_" . $field_id . "\"><img id=\"_img_feld__" . $field_id . "\" src=\"" . (!empty($field_value) ? '../index.php?thumb=' . htmlspecialchars($massiv[0], ENT_QUOTES) : $img_pixel) . "\" alt=\"" . (isset($massiv[1]) ? htmlspecialchars($massiv[1], ENT_QUOTES) : '') . "\" border=\"0\" /></div>";
				$feld .= "<div style=\"display:none\" id=\"span_feld__" . $field_id . "\">&nbsp;</div>" . (!empty($field_value) ? "<br />" : '');
				$feld .= "<input type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\" id=\"img_feld__" . $field_id . "\" />&nbsp;";
				$feld .= "<input value=\"" . $AVE_Template->get_config_vars('MAIN_OPEN_MEDIAPATH') . "\" class=\"button\" type=\"button\" onclick=\"cp_imagepop('img_feld__" . $field_id . "', '', '', '0');\" />";
				break;


            // Правила формирования поля типа Код языка программирования
            case 'javascript' :
			case 'php' :
			case 'code' :
			case 'html' :
			case 'js' :
				$feld  = "<a name=\"" . $field_id . "\"></a>";
				$feld .= "<textarea id=\"feld_" . $field_id . "\" style=\"width:" . $this->_textarea_width . "; height:" . $this->_textarea_height . "\"  name=\"feld[" . $field_id . "]\">" . $field_value . "</textarea>";
				break;


            // Правила формирования поля для Flash ролика или какой-либо анимации
            case 'flash' :
				$feld  = "<a name=\"" . $field_id . "\"></a>";
				$feld .= "<div style=\"display:none\" id=\"feld_" . $field_id . "\"><img style=\"display:none\" id=\"_img_feld__" . $field_id . "\" src=\"". (!empty($field_value) ? htmlspecialchars($field_value, ENT_QUOTES) : $img_pixel) . "\" alt=\"\" border=\"0\" /></div>";
				$feld .= "<div style=\"display:none\" id=\"span_feld__" . $field_id . "\"></div>";
				$feld .= "<input type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\" id=\"img_feld__" . $field_id . "\" />&nbsp;";
				$feld .= "<input value=\"" . $AVE_Template->get_config_vars('MAIN_OPEN_MEDIAPATH') . "\" class=\"button\" type=\"button\" onclick=\"cp_imagepop('img_feld__" . $field_id . "', '', '', '0');\" />";
				$feld .= '<input style="margin-left:5px" class="button" type="button" value="?" onmouseover="return overlib(\'' . $AVE_Template->get_config_vars('DOC_FLASH_TYPE_HELP') . '\',ABOVE,WIDTH,300);" onmouseout="nd();" style="cursor: help;">';
				break;

			// Правила формирования поля типа Файл
            case 'download' :
				$feld  = "<div style=\"\" id=\"feld_" . $field_id . "\"><a name=\"" . $field_id . "\"></a>";
				$feld .= "<div style=\"display:none\" id=\"feld_" . $field_id . "\">";
				$feld .= "<img style=\"display:none\" id=\"_img_feld__" . $field_id . "\" src=\"" . (!empty($field_value) ? htmlspecialchars($field_value, ENT_QUOTES) : $img_pixel) . "\" alt=\"\" border=\"0\" /></div>";
				$feld .= "<div style=\"display:none\" id=\"span_feld__" . $field_id . "\"></div>";
				$feld .= "<input type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\" id=\"img_feld__" . $field_id . "\" />&nbsp;";
				$feld .= "<input value=\"" . $AVE_Template->get_config_vars('MAIN_OPEN_MEDIAPATH') . "\" class=\"button\" type=\"button\" onclick=\"cp_imagepop('img_feld__" . $field_id . "', '', '', '0');\" />";
				$feld .= '<input style="margin-left:5px" class="button" type="button" value="?" onmouseover="return overlib(\'' . $AVE_Template->get_config_vars('DOC_FILE_TYPE_HELP') . '\',ABOVE,WIDTH,300);" onmouseout="nd();" style="cursor: help;">';
				$feld .= '</div>';
				break;


            // Правила формирования поля типа Видео-файл
            case 'video_avi' :
			case 'video_wmf' :
			case 'video_wmv' :
			case 'video_mov' :
				$feld  = "<div style=\"\" id=\"feld_" . $field_id . "\"><a name=\"" . $field_id . "\"></a>";
				$feld .= "<div style=\"display:none\" id=\"feld_" . $field_id . "\"><img style=\"display:none\" id=\"_img_feld__" . $field_id . "\" src=\"". (!empty($field_value) ? htmlspecialchars($field_value, ENT_QUOTES) : $img_pixel) . "\" alt=\"\" border=\"0\" /></div>";
				$feld .= "<div style=\"display:none\" id=\"span_feld__" . $field_id . "\"></div>";
				$feld .= "<input type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\" id=\"img_feld__" . $field_id . "\" />&nbsp;";
				$feld .= "<input value=\"" . $AVE_Template->get_config_vars('MAIN_OPEN_MEDIAPATH') . "\" class=\"button\" type=\"button\" onclick=\"cp_imagepop('img_feld__" . $field_id . "', '', '', '0');\" />";
				$feld .= '<input style="margin-left:5px" class="button" type="button" value="?" onmouseover="return overlib(\'' . $AVE_Template->get_config_vars('DOC_VIDEO_TYPE_HELP') . '\',ABOVE,WIDTH,300);" onmouseout="nd();" style="cursor: help;">';
				$feld .= '</div>';
				break;


            // Правила формирования поля типа Выпадающий список
            case 'dropdown' :
				$items = explode(',', $dropdown);
				$feld = "<select name=\"feld[" . $field_id . "]\">";
				$cnt = sizeof($items);
				for ($i=0;$i<$cnt;$i++)
				{
					$feld .= "<option value=\"" . htmlspecialchars($items[$i], ENT_QUOTES) . "\"" . ((trim($field_value) == trim($items[$i])) ? " selected=\"selected\"" : "") . ">" . htmlspecialchars($items[$i], ENT_QUOTES) . "</option>";
				}
				$feld .= "</select>";
				break;


            // Правила формирования поля типа Ссылка
            case 'link' :
			case 'link_ex' :
				$feld  = "<a name=\"" . $field_id . "\"></a>";
				$feld .= "<input id=\"feld_" . $field_id . "\" type=\"text\" style=\"width:" . $this->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\">&nbsp;";
				$feld .= "<input value=\"" . $AVE_Template->get_config_vars('MAIN_BROWSE_DOCUMENTS') . "\" class=\"button\" type=\"button\" onclick=\"openLinkWin('feld_" . $field_id . "', 'feld_" . $field_id . "');\" />";
				break;
		}

		return $feld;
	}

/**
 *	Внутренние методы
 */

	/**
	 *	Управление Документами
	 */

	/**
	 * Метод, предназначенный для получения списка документов в Панели управления
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

        // Если в запросе пришел параметр на поиск документа по названию
		if (!empty($_REQUEST['QueryTitel']))
		{
			$request = $_REQUEST['QueryTitel'];
			$kette = explode(' ', $request);  // Получаем список слов, разделяя по пробелу (если их несколько)

			// Циклически обрабатываем слова, формируя условия, которые будут применены в запросе к БД
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


        // Если в запросе пришел id определенной рубрики
        if (isset($_REQUEST['RubrikId']) && $_REQUEST['RubrikId'] != 'all')
		{
			// Формируем условия, которые будут применены в запросе к БД
            $ex_rub = " AND RubrikId = '" . $_REQUEST['RubrikId'] . "'";

            // формируем условия, которые будут применены в ссылках
            $nav_rub = '&RubrikId=' . $_REQUEST['RubrikId'];
		}


        // Если в запросе пришел параметр на фильтрацию документов по определенному временному интервалу
        if (!empty($_REQUEST['TimeSelect']))
		{
			// Формируем условия, которые будут применены в запросе к БД
            $ex_zeit = 'AND ((DokStart BETWEEN ' . $this->_documentListStart() . ' AND ' . $this->_documentListEnd() . ') OR DokStart = 0)';
			
            // формируем условия, которые будут применены в ссылках
            $nav_zeit = '&TimeSelect=1'
				. '&DokStartMonth=' . $_REQUEST['DokStartMonth']
				. '&DokStartDay='   . $_REQUEST['DokStartDay']
				. '&DokStartYear='  . $_REQUEST['DokStartYear']
				. '&DokEndeMonth='  . $_REQUEST['DokEndeMonth']
				. '&DokEndeDay='    . $_REQUEST['DokEndeDay']
				. '&DokEndeYear='   . $_REQUEST['DokEndeYear'];
		}


        // Если в запросе пришел параметр на фильтрацию документов по статусу
        if (!empty($_REQUEST['DokStatus']))
		{
			// Определяем, какой статус запрашивается и формируем условия, которые будут применены в запросе к БД,
            // а также в ссылках, для дальнейшей навигации
            switch ($_REQUEST['DokStatus'])
			{
                // С любым статусом
				case '':
				case 'All':
					break;

				// Только опубликованные
                case 'Opened':
					$ex_docstatus = 'AND DokStatus = 1';
					$navi_docstatus = '&DokStatus=Opened';
					break;

				// Только неопубликованные
                case 'Closed':
					$ex_docstatus = 'AND DokStatus = 0';
					$navi_docstatus = '&DokStatus=Closed';
					break;

				// Помеченные на удаление
                case 'Deleted':
					$ex_docstatus = 'AND Geloescht = 1';
					$navi_docstatus = '&DokStatus=Deleted';
					break;
			}
		}

		// Определяем группу пользоваеля и id документа, если он присутствует в запросе
        $ex_Geloescht = (UGROUP != 1) ? 'AND Geloescht != 1' : '' ;
		$w_id = !empty($_REQUEST['doc_id']) ? " AND Id = '" . $_REQUEST['doc_id'] . "'" : '';


        // Выполняем запрос к БД на получение количества документов соответствующих вышеопределенным условиям
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

		// Определяем лимит документов, который будет показан на 1 странице
        $limit = (isset($_REQUEST['Datalimit']) && is_numeric($_REQUEST['Datalimit']) && $_REQUEST['Datalimit'] > 0)
			? $_REQUEST['Datalimit']
			: $limit = $this->_limit;

		$nav_limit = '&Datalimit=' . $limit;

		// Определяем количество страниц, которые будут сформированы на основании количества полученных документов
        $seiten = ceil($num / $limit);
		$start = get_current_page() * $limit - $limit;

		$db_sort   = 'ORDER BY DokEdi DESC';
		$navi_sort = '&sort=EditsDesc';

		// Если в запросе используется параметр сортировки
        if (!empty($_REQUEST['sort']))
		{
			// Определяем, по какому параметру происходит сортировка
            switch ($_REQUEST['sort'])
			{
				// По id документа, по возрастанию
                case 'Id' :
					$db_sort   = 'ORDER BY Id ASC';
					$navi_sort = '&sort=Id';
					break;

				// По id документа, по убыванию
                case 'IdDesc' :
					$db_sort   = 'ORDER BY Id DESC';
					$navi_sort = '&sort=IdDesc';
					break;

				// По названию документа, по алфавитному возрастанию
                case 'Titel' :
					$db_sort   = 'ORDER BY Titel ASC';
					$navi_sort = '&sort=Titel';
					break;

				// По названию документа, по алфавитному убыванию
                case 'TitelDesc' :
					$db_sort   = 'ORDER BY Titel DESC';
					$navi_sort = '&sort=TitelDesc';
					break;


                // По url-адресу, по алфавитному возрастанию
                case 'Url' :
					$db_sort   = 'ORDER BY Url ASC';
					$navi_sort = '&sort=Url';
					break;

				// По url-адресу, по алфавитному убыванию
                case 'UrlDesc' :
					$db_sort   = 'ORDER BY Url DESC';
					$navi_sort = '&sort=UrlDesc';
					break;

				// По id рубрики, по возрастанию
                case 'Rubrik' :
					$db_sort   = 'ORDER BY RubrikId ASC';
					$navi_sort = '&sort=Rubrik';
					break;

				// По id рубрики, по убыванию
                case 'RubrikDesc' :
					$db_sort   = 'ORDER BY RubrikId DESC';
					$navi_sort = '&sort=RubrikDesc';
					break;


                // По дате публикации, по возрастанию
                case 'Erstellt' :
					$db_sort   = 'ORDER BY DokStart ASC';
					$navi_sort = '&sort=Erstellt';
					break;

				// По дате публикации, по убыванию
                case 'ErstelltDesc' :
					$db_sort   = 'ORDER BY DokStart DESC';
					$navi_sort = '&sort=ErstelltDesc';
					break;

				
                // По количеству просмотров, по возрастанию
                case 'Klicks' :
					$db_sort   = 'ORDER BY Geklickt ASC';
					$navi_sort = '&sort=Klicks';
					break;

				// По количеству просмотров, по убыванию
                case 'KlicksDesc' :
					$db_sort   = 'ORDER BY Geklickt DESC';
					$navi_sort = '&sort=KlicksDesc';
					break;


                // По количеству печати документа, по возрастанию
                case 'Druck' :
					$db_sort   = 'ORDER BY Drucke ASC';
					$navi_sort = '&sort=Druck';
					break;

				// По количеству печати документа, по убыванию
                case 'DruckDesc' :
					$db_sort   = 'ORDER BY Drucke DESC';
					$navi_sort = '&sort=DruckDesc';
					break;


                // По автору, по алфавитному возрастанию
                case 'Autor' :
					$db_sort   = 'ORDER BY Redakteur ASC';
					$navi_sort = '&sort=Autor';
					break;

				// По автору, по алфавитному убыванию
                case 'AutorDesc' :
					$db_sort   = 'ORDER BY Redakteur DESC';
					$navi_sort = '&sort=AutorDesc';
					break;


                // По дате последнего редактирования, по возрастанию
                case 'Edits':
					$db_sort   = 'ORDER BY DokEdi ASC';
					$navi_sort = '&sort=Edits';
					break;


                // По дате последнего редактирования, по убыванию
                case 'EditsDesc':
					$db_sort   = 'ORDER BY DokEdi DESC';
					$navi_sort = '&sort=EditsDesc';
					break;


                // По умолчанию, по дате последнего редактирования по убыванию. Т.е. последний отредактированный
                // документ, будет самым первым в списке.
                default :
					$db_sort   = 'ORDER BY DokEdi DESC';
					$navi_sort = '&sort=EditsDesc';
					break;
			}
		}

		$docs = array();

        // Выполняем запрос к БД на получение уже не количества документов, отвечающих условиям, а уже на
        // получение всех данных, с учетом всех условий, а также типа сортировки и лимита для вывода на
        // одну страницу.
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

        // Циклически обрабатываем полученные данные с целью приведения некоторых из них к удобочитаемому виду
        while ($row = $sql->FetchRow())
		{

            // Определяем количество комментариев, оставленных для данного документа
            $row->Kommentare = $AVE_DB->Query("
				SELECT COUNT(*)
				FROM " . PREFIX . "_document_comments
				WHERE DokumentId = '" . $row->Id . "'
			")->GetCell();

			$this->documentPermissionFetch($row->RubrikId);

			// Получаем название рубрики по ее Id
            $row->RubName      = $AVE_Rubric->rubricNameByIdGet($row->RubrikId)->RubrikName;
			$row->RBenutzer    = get_username_by_id($row->Redakteur); // Получаем имя пользователя (Автора)
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
			// разрешаем всё, если пользователь принадлежит группе Администраторов или имеет все права на рубрику
			if (UGROUP == 1 || @$_SESSION[$row->RubrikId . '_alles'] == 1)
			{
				$row->cantEdit     = 1;
				$row->canDelete    = 1;
				$row->canEndDel    = 1;
				$row->canOpenClose = 1;
			}
			// Запрещаем удаление Главной страницы и страницы с 404 ошибкой
			if ($row->Id == 1 || $row->Id == PAGE_NOT_FOUND_ID)
			{
				$row->canDelete = 0;
				$row->canEndDel = 0;
			}

			array_push($docs, $row);
		}


        // Передаем полученные данные в шаблон для вывода
        $AVE_Template->assign('docs', $docs);


        // Если количество полученных документов превышает лимит на одной странице, тогда формируем
        // постраничную навигацию
        if ($num > $limit)
		{
			$nav_target = !empty($_REQUEST['target'])                                         ? '&target=' . $_REQUEST['target'] : '';
			$nav_doc    = !empty($_REQUEST['doc'])                                            ? '&doc=' . $_REQUEST['doc'] : '';
			$nav_alias  = !empty($_REQUEST['alias'])                                          ? '&alias=' . $_REQUEST['alias'] : '';
			$pop        = (isset($_REQUEST['pop']) && $_REQUEST['pop'] == 1)                  ? '&pop=1' : '';
			$showsimple = (isset($_REQUEST['action']) && $_REQUEST['action'] == 'showsimple') ? '&action=showsimple' : '';
			$selurl     = (isset($_REQUEST['selurl']) && $_REQUEST['selurl'] == 1)            ? '&selurl=1' : '';
			$idonly     = (isset($_REQUEST['idonly']) && $_REQUEST['idonly'] == 1)            ? '&idonly=1' : '';

			$page_nav = " <a class=\"pnav\" href=\"index.php?do=docs"
				. $nav_target . $nav_doc . $nav_alias . $navi_sort
				. $navi_docstatus . $nav_titel . $nav_rub . $nav_zeit
				. $nav_limit . $pop . $showsimple . $selurl . $idonly
				. "&page={s}&cp=" . SESSION . "\">{t}</a> ";
			$page_nav = get_pagination($seiten, 'page', $page_nav);
			$AVE_Template->assign('page_nav', $page_nav);
		}
	}

	/**
	 * Метод, предназначенный для добавления нового документа в БД
	 *
	 * @param int $rubric_id	идентификатор Рубрики
	 */
	function documentNew($rubric_id)
	{
		global $AVE_DB, $AVE_Rubric, $AVE_Template;

		$this->documentPermissionFetch($rubric_id);

        // Если пользователь имеет права на добавление документов в указанную рубрику, тогда
		if ( (isset($_SESSION[$rubric_id . '_newnow'])  && $_SESSION[$rubric_id . '_newnow'] == 1)
			|| (isset($_SESSION[$rubric_id . '_new'])   && $_SESSION[$rubric_id . '_new']    == 1)
			|| (isset($_SESSION[$rubric_id . '_alles']) && $_SESSION[$rubric_id . '_alles']  == 1)
			|| (defined('UGROUP') && UGROUP == 1) )
		{

            // Определяем вид действия, переданный в параметре sub
            switch ($_REQUEST['sub'])
			{

                // Сохранение документа в БД
                case 'save':
					$innavi = 1;
					$start = $this->_documentStart(); // Дата/время начала публикации документа
                    $ende = $this->_documentEnd();    // Дата/время окончания публикации документа
					
                    // Определяем статус документа
                    $document_status = !empty($_REQUEST['DokStatus']) ? (int)$_REQUEST['DokStatus'] : '';

					// Если статус документа не определен
                    if (empty($document_status))
					{
						$innavi = 0;
						@reset($_POST);
						$newtext = "\n\n";

                        // Формируем текст сообщения, в котором хранятся те данные, которые пользователь
                        // ввел в поля документа
						foreach ($_POST['feld'] as $val)
						{
							if (!empty($val))
							{
								$newtext .= $val;
								$newtext .= "\n---------------------\n";
							}
						}
						$text = strip_tags($newtext);

						// Получаем e-mail адрес из Общих настроек системы
                        $system_mail = get_settings('mail_from');
						$system_mail_name = get_settings('mail_from_name');

						// И высылаем письмо администартору с информацией, что необходимо проверить документ
						$body_to_admin = $AVE_Template->get_config_vars('DOC_MAIL_BODY_CHECK');
						$body_to_admin = str_replace('%N%', "\n", $body_to_admin);
						$body_to_admin = str_replace('%TITLE%', stripslashes($_POST['Titel']), $body_to_admin);
						$body_to_admin = str_replace('%USER%', "'" . $_SESSION['user_name'] . "'", $body_to_admin);
						send_mail(
							$system_mail,
							$body_to_admin . $text,
							$AVE_Template->get_config_vars('DOC_MAIL_SUBJECT_CHECK'),
							$system_mail,
							$system_mail_name,
							'text',
							''
						);

						// Формируем и отправляем письмо автору, что документ находится на проверке
						$body_to_author = str_replace('%N%', "\n", $AVE_Template->get_config_vars('DOC_MAIL_BODY_USER'));
						$body_to_author = str_replace('%TITLE%', stripslashes($_POST['Titel']), $body_to_author);
						$body_to_author = str_replace('%USER%', "'" . $_SESSION['user_name'] . "'", $body_to_author);
						send_mail(
							$_SESSION['user_email'],
							$body_to_author,
							$AVE_Template->get_config_vars('DOC_MAIL_SUBJECT_USER'),
							$system_mail,
							$system_mail_name,
							'text',
							''
						);
					}

					if (! ((isset($_SESSION[$rubric_id . '_newnow']) && $_SESSION[$rubric_id . '_newnow'] == 1)
						|| (isset($_SESSION[$rubric_id . '_alles']) && $_SESSION[$rubric_id . '_alles'] == 1)
						|| (defined('UGROUP') && UGROUP == 1)) )
					{
						$document_status = 0;
					}

					$suche = (isset($_POST['Suche']) && $_POST['Suche'] == 1) ? 1 : 0;

					// Формируем/проверяем алиас адреса на уникальность
					$_REQUEST['Url'] = $_url = prepare_url(empty($_POST['Url']) ? trim($_POST['prefix'] . '/' . $_POST['Titel'], '/') : $_POST['Url']);
					$cnt = 1;
					while (
						$AVE_DB->Query("
							SELECT 1
							FROM " . PREFIX . "_documents
							WHERE Url = '" . $_REQUEST['Url'] . "'
							LIMIT 1
						")->NumRows())
					{
						$_REQUEST['Url'] = $_url . '-' . $cnt;
						$cnt++;
					}

                    // Выполняем запрос к БД на добавлние нового документа
					$AVE_DB->Query("
						INSERT
						INTO " . PREFIX . "_documents
						SET
							RubrikId        = '" . $rubric_id . "',
							Titel           = '" . clean_no_print_char($_POST['Titel']) . "',
							Url             = '" . $_REQUEST['Url'] . "',
							DokStart        = '" . $start . "',
							DokEnde         = '" . $ende . "',
							DokEdi          = '" . time() . "',
							Redakteur       = '" . $_SESSION['user_id'] . "',
							Suche           = '" . $suche . "',
							MetaKeywords    = '" . clean_no_print_char($_POST['MetaKeywords']) . "',
							MetaDescription = '" . clean_no_print_char($_POST['MetaDescription']) . "',
							IndexFollow     = '" . $_POST['IndexFollow'] . "',
							DokStatus       = '" . $document_status . "',
							ElterNavi       = '" . (int)$_POST['ElterNavi'] . "'
					");
					
                    // Получаем id последней записи
                    $iid = $AVE_DB->InsertId();

                    // Сохраняем системное сообщение в журнал
					reportLog($_SESSION['user_name'] . ' - добавил документ (' . $iid . ')', 2, 2);

					// Циклически обрабатываем поля документа
                    foreach ($_POST['feld'] as $fld_id => $fld_val)
					{
						if (!$AVE_DB->Query("
								SELECT 1
								FROM " . PREFIX . "_rubric_fields
								WHERE Id = '" . $fld_id . "'
								AND RubrikId = '" . $rubric_id . "'
								LIMIT 1
							")->NumRows())
						{
							continue;
						}

						// Если запрещено использование php кода, тогда обнуляем данные поля
                        if (!check_permission('docs_php'))
						{
							if (is_php_code($fld_val)) $fld_val = '';
						}

						// Убираем из текста непчатбемые символы
                        $fld_val = clean_no_print_char($fld_val);
						$fld_val = pretty_chars($fld_val);

						// Выполняем запрос к БД на добавление нового поля с его содержимым
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
                    // Фромируем рд перемены, которые передаем в шаблон (для последующих операций)
					$AVE_Template->assign('name_empty', $AVE_Template->get_config_vars('DOC_TOP_MENU_ITEM'));
					$AVE_Template->assign('Id', $iid);
					$AVE_Template->assign('innavi', $innavi);
					$AVE_Template->assign('RubrikId', $rubric_id);
                    // Отображаем страницу
					$AVE_Template->assign('content', $AVE_Template->fetch('documents/form_after.tpl'));
					break;

                    // Привязка документа к уже существующему пункту навигации
                    case 'savenavi':
					// Получаем id пункта меню из запроса
                    $elter_pre = ($_REQUEST['Elter']=='0') ? 0 : explode('____', $_REQUEST['Elter']);
					$elter = is_array($elter_pre) ? $elter_pre[0] : 0;
					$ebene = is_array($elter_pre) ? $elter_pre[1] : 1;

					// Если id не равен нулю, т.е. пункт не родительский, а какой-либо дочерний
                    if ($elter != '0')
					{
						// Выполняем запрос к БД на получение id рубрики
                        $rubrik = $AVE_DB->Query("
							SELECT Rubrik
							FROM " . PREFIX . "_navigation_items
							WHERE Id = '" . $elter . "'
						")->GetCell();
					}
					else
					{
						$rubrik = $_REQUEST['NaviRubric'];
					}

					// Выполняем запрос к БД на добавление информации о новой связке Документ<->Пункт меню, 
                    // в таблицу БД с навигацией
                    $AVE_DB->Query("
						INSERT
						INTO " . PREFIX . "_navigation_items
						SET
							Titel  = '" . clean_no_print_char($_REQUEST['Titel']) . "',
							Elter  = '" . $elter . "',
							Link   = 'index.php?id=" . (int)$_REQUEST['Id'] . "',
							Ziel   = '" . (empty($_REQUEST['Ziel']) ? '_self' : $_REQUEST['Ziel']) . "',
							Ebene  = '" . $ebene . "',
							Rang   = '" . empty($_REQUEST['Rang']) ? 1 : (int)$_REQUEST['Rang'] . "',
							Rubrik = '" . (int)$rubrik . "',
							Url    = '" . prepare_url(empty($_REQUEST['Url']) ? $_REQUEST['Titel'] : $_REQUEST['Url']) . "'
					");

                    // Если у нас было вызвано отдельное окно, закрываем его и обновляем страницу
					if (isset($_REQUEST['pop']) && $_REQUEST['pop'] == 1)
					{
						echo '<script>window.opener.location.reload(); window.close();</script>';
					}
					else
					{
						// В противном случае просто обновляем страницу
                        echo '<script>window.opener.location.reload();</script>';
					}

					$AVE_Template->assign('innavi', 0);
					$AVE_Template->assign('Id', (int)$_REQUEST['Id']);
					$AVE_Template->assign('RubrikId', (int)$_REQUEST['RubrikId']);
					$AVE_Template->assign('content', $AVE_Template->fetch('documents/form_after.tpl'));
					break;


                // Действия по умолчанию, если не задано
                case '':
					$document = '';
					// Получаем список прав доступа на добавление документов в определенную рубрику
                    $this->documentPermissionFetch($rubric_id);

					// Определяем флаг, который будет активировать или запрещать смену статуса у документа
                    if (isset($_SESSION[$rubric_id . '_newnow']) && $_SESSION[$rubric_id . '_newnow'] == 1)
					{
						$document->dontChangeStatus = 0;
					}
					else
					{
						$document->dontChangeStatus = 1;
					}

					$fields = array();

                    // Выполняем запрос к БД на получение списка полей, которые относятся к данному документу
                    $sql = $AVE_DB->Query("
						SELECT *
						FROM " . PREFIX . "_rubric_fields
						WHERE RubrikId = '" . $rubric_id . "'
						ORDER BY rubric_position ASC
					");
					while ($row = $sql->FetchRow())
					{
						$row->Feld = $this->_documentFieldGet($row->RubTyp, $row->StdWert, $row->Id, $row->StdWert);
						array_push($fields, $row);
					}

                    // Формируем данные и передаем в шаблон
					$document->fields = $fields;
					$document->rubric_name = $AVE_Rubric->rubricNameByIdGet($rubric_id)->RubrikName;
					$document->rubric_url_prefix = strftime($AVE_Rubric->rubricNameByIdGet($rubric_id)->UrlPrefix);
					$document->formaction = 'index.php?do=docs&action=new&sub=save&RubrikId=' . $rubric_id . ((isset($_REQUEST['pop']) && $_REQUEST['pop']==1) ? 'pop=1' : '') . '&cp=' . SESSION;

					$AVE_Template->assign('document', $document);
					$AVE_Template->assign('DEF_DOC_START_YEAR', mktime(0, 0, 0, date("m"), date("d"), date("Y") - 10));
					$AVE_Template->assign('DEF_DOC_END_YEAR', mktime(0, 0, 0, date("m"), date("d"), date("Y") + 20));
					$AVE_Template->assign('content', $AVE_Template->fetch('documents/form.tpl'));
					break;
			}
		}
		// В противном случае, если пользователь не имеет прав на создание документа, формируем сообщение с ошибкой
        else
		{
			$AVE_Template->assign('content', $AVE_Template->get_config_vars('DOC_NO_PERMISSION_RUB'));
		}
	}


    /**
	 * Метод, предназначенный для редактирования документа
	 *
	 * @param int $document_id	идентификатор Документа
	 */
	function documentEdit($document_id)
	{
		global $AVE_DB, $AVE_Rubric, $AVE_Template;


        // Определяем действие, выбранное пользователем
        switch ($_REQUEST['sub'])
		{
			// Если была нажата кнопка Сохранить изменения
            case 'save':

                // Выполняем запрос к БД на получение автора документа и id Рубрики
                $row = $AVE_DB->Query("
					SELECT
						RubrikId,
						Redakteur
					FROM " . PREFIX . "_documents
					WHERE Id = '" . $document_id . "'
				")->FetchRow();

				$row->cantEdit = 0;

				// Определяем права доступа к документам в данной рубрики
                $this->documentPermissionFetch($row->RubrikId);

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
				if ( ($document_id == 1 || $document_id == PAGE_NOT_FOUND_ID) && @$_SESSION[$row->RubrikId . '_newnow'] != 1 )
				{
					$row->cantEdit = 0;
				}
				// разрешаем редактирование, если пользователь принадлежит группе Администраторов или имеет все права на рубрику
				if ( (defined('UGROUP') && UGROUP == 1)
					|| (isset($_SESSION[$row->RubrikId . '_alles']) && $_SESSION[$row->RubrikId . '_alles'] == 1) )
				{
					$row->cantEdit = 1;
				}


                // Если редактирование разрешено для данного пользователя
                if ($row->cantEdit == 1)
				{
					// Обрабатываем все данные, пришедшие в запросе
                    $suche     = (isset($_POST['Suche']) && $_POST['Suche'] == 1) ? '1' : '0';
					$docstatus = ( (isset($_SESSION[$row->RubrikId . '_newnow']) && $_SESSION[$row->RubrikId . '_newnow'] == 1)
								|| (isset($_SESSION[$row->RubrikId . '_alles']) && $_SESSION[$row->RubrikId . '_alles'] == 1)
								|| (defined('UGROUP') && UGROUP == 1) ) ? (isset($_REQUEST['DokStatus']) ? $_REQUEST['DokStatus'] : '0') : '0';
					$docstatus = ($document_id == 1 || $document_id == PAGE_NOT_FOUND_ID) ? '1' : $docstatus;
					$docend    = ($document_id == 1 || $document_id == PAGE_NOT_FOUND_ID) ? '0' : $this->_documentEnd();
					$docstart  = ($document_id == 1 || $document_id == PAGE_NOT_FOUND_ID) ? '0' : $this->_documentStart();

					// Формируем/проверяем адрес на уникальность
					$_REQUEST['Url'] = $_url = prepare_url(empty($_POST['Url'])
						? trim($_POST['prefix'] . '/' . $_POST['Titel'], '/')
						: $_POST['Url']);
					$cnt = 1;
					while ($AVE_DB->Query("
						SELECT 1
						FROM " . PREFIX . "_documents
						WHERE Id != '" . $document_id . "'
						AND Url = '" . $_REQUEST['Url'] . "'
						LIMIT 1
						")->NumRows() == 1)
					{
						$_REQUEST['Url'] = $_url . '-' . $cnt;
						$cnt++;
					}


                    // Выполняем запрос к БД на сохранение изменений в таблице документов
                    $AVE_DB->Query("
						UPDATE " . PREFIX . "_documents
						SET
							Titel           = '" . clean_no_print_char($_POST['Titel']) . "',
							Url             = '" . $_REQUEST['Url'] . "',
							Suche           = '" . $suche . "',
							MetaKeywords    = '" . clean_no_print_char($_POST['MetaKeywords']) . "',
							MetaDescription = '" . clean_no_print_char($_POST['MetaDescription']) . "',
							IndexFollow     = '" . $_POST['IndexFollow'] . "',
							DokStatus       = '" . $docstatus . "',
							DokEnde         = '" . $docend . "',
							DokStart        = '" . $docstart . "',
							DokEdi          = '" . time() . "',
							ElterNavi       = '" . (int)$_POST['ElterNavi'] . "'
						WHERE
							Id = '" . $document_id . "'
					");


                    // Выполняем запрос к БД на сохранение изменений в таблице навигации
                    $AVE_DB->Query("
						UPDATE " . PREFIX . "_navigation_items
						SET Url  = '" . $_REQUEST['Url'] . "'
						WHERE Link = 'index.php?id=" . $document_id . "'
					");


                    // Если документ содержит поля
                    if (isset($_POST['feld']))
					{
						// Циклически обрабатываем каждое поле
                        foreach ($_POST['feld'] as $fld_id => $fld_val)
						{
							$row_df = $AVE_DB->Query("
								SELECT
									Inhalt,
									Suche
								FROM " . PREFIX . "_document_fields
								WHERE Id = '" . $fld_id . "'
								AND DokumentId = '" . $document_id . "'
							")->FetchRow();

							if (!$row_df) continue;

							if ($row_df->Suche == $suche && $row_df->Inhalt == pretty_chars(stripslashes($fld_val))) continue;

							// Если запрещено использование php-кода в полях, пропускаем это поле
                            if (!check_permission('docs_php'))
							{
								if (is_php_code($fld_val)) continue;
							}

							// Удаляем непечатаемые символы
                            $fld_val = clean_no_print_char($fld_val);
							$fld_val = pretty_chars($fld_val);

							
                            // Выполняем запрос к БД на сохранение изменений в таблице полей документов
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
						WHERE doc_id = '" . $document_id . "'
					");

					// Сохраняем системное сообщение в журнал
                    reportLog($_SESSION['user_name'] . ' - отредактировал документ (' . $document_id . ')', 2, 2);
				}

				// Закрываем окно и обновляем страницу
                if (isset($_REQUEST['closeafter']) && $_REQUEST['closeafter']==1)
				{
					echo '<script>window.opener.location.reload(); window.close();</script>';
					exit;
				}

				echo '<script>window.opener.location.reload();</script>';

				// Формируем ряд переменных, передаем в шаблон и отображаем страницу со списком дальнейших действий
                $AVE_Template->assign('name_empty', $AVE_Template->get_config_vars('DOC_TOP_MENU_ITEM'));
				$AVE_Template->assign('innavi', 0);
				$AVE_Template->assign('Id', $document_id);
				$AVE_Template->assign('RubrikId', $row->RubrikId);
				$AVE_Template->assign('content', $AVE_Template->fetch('documents/form_after.tpl'));
				break;


            // Если пользователь не выполнял никаких действий, а просто открыл документ для редактирования
            case '':

                // Выполняем запрос к БД на получение данных о документе
                $document = $AVE_DB->Query("
					SELECT *
					FROM " . PREFIX . "_documents
					WHERE Id = '" . $document_id . "'
				")->FetchRow();

				$show = true;

				// Проверяем права доступа к документу
                $this->documentPermissionFetch($document->RubrikId);

				// запрещаем доступ,
				// если автору документа не разрешено изменять свои документы в рубрике
				// или пользователю не разрешено изменять все документы в рубрике
				if (!( (isset($_SESSION['user_id']) && $document->Redakteur == $_SESSION['user_id']
					&& isset($_SESSION[$document->RubrikId . '_editown']) && $_SESSION[$document->RubrikId . '_editown'] == 1)
					|| (isset($_SESSION[$document->RubrikId . '_editall']) && $_SESSION[$document->RubrikId . '_editall'] == 1)))
				{
					$show = false;
				}
				// запрещаем доступ к главной странице и странице ошибки 404, если требуется одобрение Администратора
				if ( ($document_id == 1 || $document_id == PAGE_NOT_FOUND_ID) &&
					!(isset($_SESSION[$document->RubrikId . '_newnow']) && $_SESSION[$document->RubrikId . '_newnow'] == 1) )
				{
					$show = false;
				}
				// разрешаем доступ, если пользователь принадлежит группе Администраторов или имеет все права на рубрику
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

					// Выполняем запрос к БД и получаем все данные для полей документа
                    $sql = $AVE_DB->Query("
						SELECT
							doc.Id AS df_id,
							rub.*,
							StdWert,
							Inhalt
						FROM " . PREFIX . "_rubric_fields AS rub
						LEFT JOIN " . PREFIX . "_document_fields AS doc ON RubrikFeld = rub.Id
						WHERE DokumentId = '" . $document_id . "'
						ORDER BY rubric_position ASC
					");
					while ($row = $sql->FetchRow())
					{
						$row->Feld = $this->_documentFieldGet($row->RubTyp, $row->Inhalt, $row->df_id, $row->StdWert);
						array_push($fields, $row);
					}

					// Формируем ряд переменных и передаем их в шаблон для вывода
                    $document->fields = $fields;
					$document->rubric_name = $AVE_Rubric->rubricNameByIdGet($document->RubrikId)->RubrikName;
					$document->rubric_url_prefix = $AVE_Rubric->rubricNameByIdGet($document->RubrikId)->UrlPrefix;
					$document->formaction = 'index.php?do=docs&action=edit&sub=save&Id=' . $document_id . '&cp=' . SESSION;

					$AVE_Template->assign('document', $document);
					$AVE_Template->assign('DEF_DOC_START_YEAR', mktime(0, 0, 0, date("m"), date("d"), date("Y") - 10));
					$AVE_Template->assign('DEF_DOC_END_YEAR', mktime(0, 0, 0, date("m"), date("d"), date("Y") + 20));
					
                    // Отображаем страницу для редактирования
                    $AVE_Template->assign('content', $AVE_Template->fetch('documents/form.tpl'));
				}
				else // Если пользователь не имеет прав на редактирование, формируем сообщение об ошибке
				{
					$AVE_Template->assign('content', $AVE_Template->get_config_vars('DOC_NO_PERMISSION'));
				}
				break;
		}
	}



    /**
	 * Метод, предназначенный для пометки документа к удалению
	 *
	 * @param int $document_id	идентификатор Документа
	 */
	function documentMarkDelete($document_id)
	{
		global $AVE_DB;

        // Выполняем запрос к БД на получение информации о документе (id, id рубрики, автор)
		$row = $AVE_DB->Query("
			SELECT
				Id,
				RubrikId,
				Redakteur
			FROM " . PREFIX . "_documents
			WHERE Id = '" . $document_id . "'
		")->FetchRow();

		// Если у пользователя достаточно прав на выполнение данной операции
        if ( (isset($_SESSION['user_id']) && $_SESSION['user_id'] == $row->Redakteur)
			&& (isset($_SESSION[$row->RubrikId . '_editown']) && $_SESSION[$row->RubrikId . '_editown'] == 1)
			|| (isset($_SESSION[$row->RubrikId . '_alles']) && $_SESSION[$row->RubrikId . '_alles'] == 1)
			|| (defined('UGROUP') && UGROUP == 1) )
		{
			// и это не главная страница и не страница с ошибкой 404
            if ($document_id != 1 && $document_id != PAGE_NOT_FOUND_ID)
			{
				// Выполняем запрос к БД на обновление данных (пометка на удаление)
                $AVE_DB->Query("
					UPDATE " . PREFIX . "_documents
					SET Geloescht = '1'
					WHERE Id = '" . $document_id . "'
				");

                // Сохраняем системное сообщение в журнал
                reportLog($_SESSION['user_name'] . ' - временно удалил документ (' . $document_id . ')', 2, 2);
			}
		}

        // Выполняем обновление страницы
        header('Location:index.php?do=docs&cp=' . SESSION);

	}



    /**
	 * Метод, предназначенный для снятия отметки об удаления
	 *
	 * @param int $document_id	идентификатор Документа
	 */
	function documentUnmarkDelete($document_id)
	{
		global $AVE_DB;

		// Выполняем запрос к БД на обновление информации (снятие отметки об удалении)
        $AVE_DB->Query("
			UPDATE " . PREFIX . "_documents
			SET Geloescht = '0'
			WHERE Id = '" . $document_id . "'
		");

		// Сохраняем системное сообщение в журнал
        reportLog($_SESSION['user_name'] . ' - восстановил удаленный документ (' . $document_id . ')', 2, 2);

		// Выполняем обновление страницы
        header('Location:index.php?do=docs&cp=' . SESSION);
	}



    /**
	 * Метод, предназначенный для полного удаления документа без возможности восстановления
	 *
	 * @param int $document_id	идентификатор Документа
	 */
	function documentDelete($document_id)
	{
		global $AVE_DB;

		// Проверяем, чтобы удаляемый документ не являлся главной страницей и не страницей с 404 ощибкой
        if ($document_id != 1 && $document_id != PAGE_NOT_FOUND_ID)
		{

            // Выполняем запрос к БД на удаление информации о документе
            $AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_documents
				WHERE Id = '" . $document_id . "'
			");

            // Выполняем запрос к БД на удаление полей, которые относились к документу
            $AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_document_fields
				WHERE DokumentId = '" . $document_id . "'
			");

			// Очищаем кэш шаблона
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_rubric_template_cache
				WHERE doc_id = '" . $document_id . "'
			");


            // Сохраняем системное сообщение в журнал
            reportLog($_SESSION['user_name'] . ' - окончательно удалил документ (' . $document_id . ')', 2, 2);
		}

		// Выполняем обновление страницы
        header('Location:index.php?do=docs&cp=' . SESSION);
	}



    /**
	 * Метод, предназначенный для публикации или отмены публикации документа
	 *
	 * @param int $document_id	идентификатор Документа
	 * @param string $openclose	статус Документа {open|close}
	 */
	function documentStatusSet($document_id, $openclose)
	{
		global $AVE_DB;

		// Выполняем запрос к БД на получение id автора документа, чтобы проверить уровень прав доступа
        $row = $AVE_DB->Query("
			SELECT
				RubrikId,
				Redakteur
			FROM " . PREFIX . "_documents
			WHERE Id = '" . $document_id . "'
		")->FetchRow();

		// Проверем, чтобы у пользователя было достаточно прав на выполнение данной операции
        if ( ($row->Redakteur == @$_SESSION['user_id'])
			&& (isset($_SESSION[$row->RubrikId . '_newnow']) && @$_SESSION[$row->RubrikId . '_newnow'] == 1)
			|| @$_SESSION[$row->RubrikId . '_alles'] == 1
			|| UGROUP == 1)
		{

            // Если это не главная страница и не страница с 404 ошибкой
            if ($document_id != 1 && $document_id != PAGE_NOT_FOUND_ID)
			{
				// Выполянем запрос к БД на смену статуса у документа
                $AVE_DB->Query("
					UPDATE " . PREFIX . "_documents
					SET DokStatus = '" . $openclose . "'
					WHERE Id = '" . $document_id . "'
				");

				// Сохраняем системное сообщение в журнал
                reportLog($_SESSION['user_name'] . ' - ' . (($openclose=='open') ? 'активировал' : 'деактивировал') . ' документ (' . $document_id . ')', 2, 2);
			}
		}

		// Выполняем обновление страницы
        header('Location:index.php?do=docs&cp=' . SESSION);
	}

	/**
	 * Метод, предназначенный для передачи в Smarty шаблонизатор меток периода времени отображаемых
     * в списке документов
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
	 * Метод, предназначенный для переноса документа в другую рубрику
	 *
	 */
	function documentRubricChange()
	{
		global $AVE_DB, $AVE_Template;

		$document_id = (int)$_REQUEST['Id'];       // идентификатор документа
		$rubric_id   = (int)$_REQUEST['RubrikId']; // идентификатор текущей рубрики

        // Если в запросе пришел идентификатор новой рубрики и id документа, тогда
        // выполняем автоматический перенос документа из одной рубрики в другую
		if ((!empty($_POST['NewRubr'])) and (!empty($_GET['Id'])))
		{
			$new_rubric_id = (int)$_POST['NewRubr']; // идентификатор целевой рубрики

			// Циклически обрабатываем данные, пришедшие в запросе методо POST
            foreach ($_POST as $key => $value)
			{
				if (is_integer($key))
				{
					// Определяем флаг поля
                    switch ($value)
					{
						// Если 0, тогда
                        case 0:
							// Выполняем запрос к БД на удаление старого поля (лишнее или не требует переноса)
                            $AVE_DB->Query("
								DELETE
								FROM " . PREFIX . "_document_fields
								WHERE DokumentId = '" . $document_id . "'
								AND RubrikFeld = '" . $key . "'
							");
							break;

						// Если -1, тогда
                        case -1:
							// Выполняем запрос на получение данных для этого (старого) поля
							$row_fd = $AVE_DB->Query("
								SELECT
									Titel,
									RubTyp
								FROM " . PREFIX . "_rubric_fields
								WHERE Id = '" . $key . "'
							")->FetchRow();

							// Выполняем запрос к БД и получаем последнюю позицию полей в рубрики КУДА переносим
							$new_pos = $AVE_DB->Query("
								SELECT rubric_position
								FROM " . PREFIX . "_rubric_fields
								WHERE RubrikId = '" . $new_rubric_id . "'
								ORDER BY rubric_position DESC
								LIMIT 1
							")->GetCell();
							++$new_pos;

							// Выполняем запрос к БД и добавляем новое поле в новую рубрику
							$AVE_DB->Query("
								INSERT
								INTO " . PREFIX . "_rubric_fields
								SET
									RubrikId        = '" . $new_rubric_id . "',
									Titel           = '" . addslashes($row_fd->Titel) . "',
									RubTyp          = '" . addslashes($row_fd->RubTyp) . "',
									rubric_position = '" . $new_pos . "'
							");

                            $lastid = $AVE_DB->InsertId();

							// Выполняем запрос к БД и добавляем запись о поле в таблицу с полями документов
							$sql_docs = $AVE_DB->Query("
								SELECT Id
								FROM " . PREFIX . "_documents
								WHERE RubrikId = '" . $new_rubric_id . "'
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

							// Выполняем запрос к БД и создаем новое поле для изменяемого документа
							$AVE_DB->Query("
								UPDATE " . PREFIX . "_document_fields
								SET RubrikFeld = '" . $lastid . "'
								WHERE RubrikFeld = '" . $key . "'
								AND DokumentId = '" . $document_id . "'
							");
							break;

						// По умолчанию
                        default:
							
                            // Выполняем запрос к БД и просто обновляем имеющиеся данные
                            $AVE_DB->Query("
								UPDATE " . PREFIX . "_document_fields
								SET RubrikFeld = '" . $value . "'
								WHERE RubrikFeld = '" . $key . "'
								AND DokumentId = '" . $document_id . "'
							");
							break;
					}
				}
			}

			// Выполняем запрос к БД и получаем список всех полей у новой рубрики
			$sql_rub = $AVE_DB->Query("
				SELECT Id
				FROM " . PREFIX . "_rubric_fields
				WHERE RubrikId = '" . $new_rubric_id . "'
				ORDER BY Id ASC
			");

			// Выполняем запросы к БД на проверку наличия нужных полей.
			while ($row_rub = $sql_rub->FetchRow())
			{
				$num = $AVE_DB->Query("
					SELECT 1
					FROM " . PREFIX . "_document_fields
					WHERE RubrikFeld = '" . $row_rub->Id . "'
					AND DokumentId = '" . $document_id . "'
					LIMIT 1
				")->NumRows();

				// Если в новой рубрики требуемого поля нет, выполняем запрос к БД на добавление нового типа поля
				if ($num != 1)
				{
					$AVE_DB->Query("
						INSERT " . PREFIX . "_document_fields
						SET
							RubrikFeld = '" . $row_rub->Id . "',
							DokumentId = '" . $document_id . "',
							Inhalt     = '',
							Suche      = '1'
					");
				}
			}

            // Выполянем запрос к БД на обновление информации, в котором устанавливаем для перенесенного документа
            // новое значение id рубрики
			$AVE_DB->Query("
				UPDATE " . PREFIX . "_documents
				SET RubrikId = '" . $new_rubric_id . "'
				WHERE Id = '" . $document_id . "'
			");

			// Выполняем запрос к БД и очищаем кэш шаблона документа
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_rubric_template_cache
				WHERE doc_id = '" . $document_id . "'
			");

			echo '<script>window.opener.location.reload(); window.close();</script>';
		}
		else  // Если в запросе не был указан id рубрики и id документа
		{
			// Формируем и отображаем форму, где пользователь самостоятельно определяет перенос
			$fields = array();

			if ((!empty($_GET['NewRubr'])) and ($rubric_id != (int)$_GET['NewRubr']))
			{
				// Выполняем запрос к БД  и выбираем все поля новой рубрики
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
					$mass_new_rubr[] = array('Id'     => $row_rub->Id,
											 'Titel'  => $row_rub->Titel,
											 'RubTyp' => $row_rub->RubTyp
					);
				}

				// Выполняем запрос к БД и выбираем все поля старой рубрики
				$sql_old_rub = $AVE_DB->Query("
					SELECT
						Id,
						Titel,
						RubTyp
					FROM " . PREFIX . "_rubric_fields
					WHERE RubrikId = '" . $rubric_id . "'
					ORDER BY Id ASC
				");

                // Циклически обрабатываем полученные данные
                while ($row_nr = $sql_old_rub->FetchRow()) {
					$type = $row_nr->RubTyp;
					$option_arr = array('0'  => $AVE_Template->get_config_vars('DOC_CHANGE_DROP_FIELD'),
										'-1' => $AVE_Template->get_config_vars('DOC_CHANGE_CREATE_FIELD')
					);
					$selected = -1;
					foreach ($mass_new_rubr as $row)
					{
						if ($row['RubTyp'] == $type)
						{
							$option_arr[$row['Id']] = $row['Titel'];
							if ($row_nr->Titel == $row['Titel']) $selected = $row['Id'];
						}
					}
					$fields[$row_nr->Id] = array('Titel'    => $row_nr->Titel,
												 'Options'  => $option_arr,
												 'Selected' => $selected
					);
				}
			}

			// Формируем ряд переменых и отображаем страницу с выбором рубрики
            $AVE_Template->assign('fields', $fields);
			$AVE_Template->assign('formaction', 'index.php?do=docs&action=change&Id=' . $document_id . '&RubrikId=' . $rubric_id . '&pop=1&cp=' . SESSION);
			$AVE_Template->assign('content', $AVE_Template->fetch('documents/change.tpl'));
		}
	}

	/**
	 * Метод, предназначенный для формирования URL
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
	 * Метод, предназначенный для контроля уникальности URL
	 *
	 */
	function documentAliasCheck()
	{
		global $AVE_DB, $AVE_Template;

		$document_id = (isset($_REQUEST['id']) && is_numeric($_REQUEST['id'])) ? $_REQUEST['id'] : 0;
		$alias = (isset($_REQUEST['alias'])) ? iconv("UTF-8", "WINDOWS-1251", $_REQUEST['alias']) : '';

		$errors = array();

		// Если указанный URL пользователем не пустой
        if (!empty($alias))
		{

			// Проверяем, чтобы данный URL соответствовал требованиям
			if (preg_match(TRANSLIT_URL ? '/[^a-z0-9\/-]+/' : '/[^a-zа-яёїєі0-9\/-]+/', $alias))
			{
				$errors[] = $AVE_Template->get_config_vars('DOC_URL_ERROR_SYMBOL');
			}

			// Если URL начинается с "/" - фиксируем ошибку
            if ($alias[0] == '/') $errors[] = $AVE_Template->get_config_vars('DOC_URL_ERROR_START');

			// Если URL заканчивается на "/" - фиксируем ошибку
            if (substr($alias, -1) == '/') $errors[] = $AVE_Template->get_config_vars('DOC_URL_ERROR_END');

			// Если в URL используются слова apage-XX, artpage-XX,page-XX,print, фиксируем ошибку, где ХХ - число
            $matches = preg_grep('/^(apage-\d+|artpage-\d+|page-\d+|print)$/i', explode('/', $alias));
			if (!empty($matches)) $errors[] = $AVE_Template->get_config_vars('DOC_URL_ERROR_SEGMENT') . implode(', ', $matches);

			// Выполняем запрос к БД на получение ивсе URL и проверку на уникальность
            if (empty($errors))
			{
				$alias_exist = $AVE_DB->Query("
					SELECT 1
					FROM " . PREFIX . "_documents
					WHERE Url = '" . $alias . "'
					AND Id != " . $document_id . "
					LIMIT 1
				")->NumRows();

				if ($alias_exist) $errors[] = $AVE_Template->get_config_vars('DOC_URL_ERROR_DUPLICATES');
			}
		}
		else
		{  // В противном случае, если URL пустой, формируем сообщение об ошибке
			$errors[] = $AVE_Template->get_config_vars('DOC_URL_ERROR_EMTY');
		}


        // Если ошибок не найдено, формируем сообщение об успешной операции
        if (empty($errors))
		{
			return '<font class="checkUrlOk">' . $AVE_Template->get_config_vars('DOC_URL_CHECK_OK') . '</font>';
		}
		else
		{ // В противном случае формируем сообщение с ошибкой
			return '<font class="checkUrlErr">' . implode(', ', $errors) . '</font>';
		}
	}



    /**
	 * Метод, предназначенный для формирования прав доступа Группы пользователей на Документы определённой Рубрики
	 *
	 * @param int $rubric_id	идентификатор Рубрики
	 */
	function documentPermissionFetch($rubric_id)
	{
		global $AVE_DB;

		// Массив прав пользователей
        static $rubric_permissions = array();

		// Если у нас уже имеются полученные права для данной рубрики, просто прерываем проверку
        if (isset($rubric_permissions[$rubric_id])) return;


        // Выполняем запрос к БД на получение прав для данной рубрики
        $sql = $AVE_DB->Query("
			SELECT
				RubrikId,
				Rechte
			FROM " . PREFIX . "_document_permissions
			WHERE BenutzerGruppe = " . UGROUP . "
		");

        // Циклически обрабатываем полученные данные и формируем массив прав
        while ($row = $sql->FetchRow())
		{
			$rubric_permissions[$row->RubrikId] = 1;

			$permissions = explode('|', $row->Rechte);

			foreach ($permissions as $permission)
			{
				if (!empty($permission))
				{
					$_SESSION[$row->RubrikId . '_' . $permission] = 1;
				}
			}
		}
	}




    /**
	 * Метод, предназначенный для просмотра и добавления Заметок к Документу
	 *
	 * @param int $reply	признак ответа на Заметку
	 */
	function documentRemarkNew($document_id = 0, $reply = 0)
	{
		global $AVE_DB, $AVE_Template;

        // Если id документа не число или 0, прерываем выполнение
		if (!(is_numeric($document_id) && $document_id > 0)) exit;

		// Если в запросе пришел параметр на Сохранение
        if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
		{
			// Если пользователь оставил комментарий и у него имеются права и это не ответ, а новая заметка, тогда
            if (!empty($_REQUEST['Kommentar']) && check_permission('docs_comments') && $_REQUEST['reply'] != 1)
			{
				// Выполняем запрос к БД на добавление новой заметки для документа
                $AVE_DB->Query("
					INSERT " . PREFIX . "_document_comments
					SET
						DokumentId     = '" . $document_id . "',
						Titel          = '" . clean_no_print_char($_REQUEST['Titel']) . "',
						Kommentar      = '" . substr(clean_no_print_char($_REQUEST['Kommentar']), 0, $this->_max_comment_length) . "',
						Author         = '" . $_SESSION['user_name'] . "',
						Zeit           = '" . time() . "',
						KommentarStart = 1,
						AntwortEMail   = '" . $_SESSION['user_email'] . "'
				");
			}

            // Выполняем обновление страницы
            header('Location:index.php?do=docs&action=comment_reply&Id=' . $document_id . '&pop=1&cp=' . SESSION);
		}

        // Если это ответ на уже существующую заметку
		if ($reply == 1)
		{
			if (isset($_REQUEST['sub']) && $_REQUEST['sub'] == 'save')
			{
				// Если пользователь оставил ответ и имеет на это права
                if (!empty($_REQUEST['Kommentar']) && check_permission('docs_comments'))
				{

                    // Выполняем запрос на получение e-mail адреса автора заметки
                    $AntwortEMail = $AVE_DB->Query("
						SELECT AntwortEMail
						FROM  " . PREFIX . "_document_comments
						WHERE KommentarStart = 1
						AND DokumentId = '" . $document_id . "'
					")->GetCell();

					
                    // Выполняем запрос к БД на добавление заметки в БД
                    $AVE_DB->Query("
						INSERT " . PREFIX . "_document_comments
						SET
							DokumentId     = '" . $document_id . "',
							Titel          = '" . clean_no_print_char($_REQUEST['Titel']) . "',
							Kommentar      = '" . substr(clean_no_print_char($_REQUEST['Kommentar']), 0, $this->_max_comment_length) . "',
							Author         = '" . $_SESSION['user_name'] . "',
							Zeit           = '" . time() . "',
							KommentarStart = 0,
							AntwortEMail   = '" . $_SESSION['user_email'] . "'
					");
				}

				// Формируем сообщение и отправляем письмо автору, с информацией о том, что на его заметку есть ответ
				$system_mail = get_settings('mail_from');
				$system_mail_name = get_settings('mail_from_name');
				$link = get_home_link() . 'index.php?do=docs&doc_id=' . $document_id;

				$body_to_admin = $AVE_Template->get_config_vars('DOC_MAIL_BODY_NOTICE');
				$body_to_admin = str_replace('%N%', "\n", $body_to_admin);
				$body_to_admin = str_replace('%TITLE%', stripslashes($_POST['Titel']), $body_to_admin);
				$body_to_admin = str_replace('%USER%', $_SESSION['user_name'], $body_to_admin);
				$body_to_admin = str_replace('%LINK%', $link, $body_to_admin);
				send_mail(
					$AntwortEMail,
					$body_to_admin,
					$AVE_Template->get_config_vars('DOC_MAIL_SUBJECT_NOTICE'),
					$system_mail,
					$system_mail_name,
					'text',
					''
				);

				// Выполняем обновление страницы
                header('Location:index.php?do=docs&action=comment_reply&Id=' . $document_id . '&pop=1&cp=' . SESSION);
			}


            // Получаем общее количество заметок для документа
            $num = $AVE_DB->Query("
				SELECT COUNT(*)
				FROM " . PREFIX . "_document_comments
				WHERE DokumentId = '" . $document_id . "'
			")->GetCell();

			// Определяыем лимит заметок на 1 странице и подсчитываем количество страниц
            $limit = 10;
			$seiten = ceil($num / $limit);
			$start = get_current_page() * $limit - $limit;

			$answers = array();

            // Выполняем запрос к БД на получение заметок с учетом количества на 1 странцу
            $sql = $AVE_DB->Query("
				SELECT *
				FROM " . PREFIX . "_document_comments
				WHERE DokumentId = '" . $document_id . "'
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
				WHERE DokumentId = '" . $document_id . "'
				AND KommentarStart = 1
			")->FetchAssocArray();


            // Если количество заметок превышает допустимое значение, определенное в переменной $limit, тогда
            // формируем постраничную навигацию
            if ($num > $limit)
			{
				$page_nav = " <a class=\"pnav\" href=\"index.php?do=docs&action=comment_reply&Id=" . $document_id . "&page={s}&pop=1&cp=" . SESSION . "\">{t}</a> ";
				$page_nav = get_pagination($seiten, 'page', $page_nav);
				$AVE_Template->assign('page_nav', $page_nav);
			}

			// Передаем данные  в шаблон и отображаем страницу со списком заметок
            $AVE_Template->assign('row_a', $row_a);
			$AVE_Template->assign('answers', $answers);
			$AVE_Template->assign('reply', 1);
			$AVE_Template->assign('formaction', 'index.php?do=docs&action=comment_reply&sub=save&Id=' . $document_id . '&reply=1&cp=' . SESSION);
			$AVE_Template->assign('content', $AVE_Template->fetch('documents/newcomment.tpl'));
		}
		else
		{ // В противном случае, если заметок еще нет, открываем форму для добавление заметки
			$AVE_Template->assign('reply', 1);
			$AVE_Template->assign('new', 1);
			$AVE_Template->assign('formaction', 'index.php?do=docs&action=comment&sub=save&Id=' . $document_id . '&cp=' . SESSION);
			$AVE_Template->assign('content', $AVE_Template->fetch('documents/newcomment.tpl'));
		}
	}



    /**
	 * Метод, предназначенный для управления статусами дискусии (разрешить или запретить оставлять
     * ответы на заметки для других пользователей)
	 *
	 * @param int $document_id	идентификатор документа
	 * @param int $status		статус дискусии
	 */
	function documentRemarkStatus($document_id = 0, $status = 0)
	{
		global $AVE_DB;

		// Если id документа число и оно больше 0, тогда
        if (is_numeric($document_id) && $document_id > 0)
		{

            // Выполняем запрос к БД на обновление статуса у заметок
            $AVE_DB->Query("
				UPDATE " . PREFIX . "_document_comments
				SET Aktiv = '" . ($status != 1 ? 0 : 1) . "'
				WHERE KommentarStart = 1
				AND DokumentId = '" . $document_id . "'
			");
		}

		// Выполняем обновление данных
        header('Location:index.php?do=docs&action=comment_reply&Id=' . $document_id . '&pop=1&cp=' . SESSION);
		exit;
	}



    /**
	 * Метод, предназначенный для удаление заметок
	 *
	 * @param int $all	признак удаления всех Заметок (1 - удалить все)
	 */
	function documentRemarkDelete($document_id = 0, $all = 0)
	{
		global $AVE_DB;

        // Если id документа не число или 0, прерываем выполнение
		if (!(is_numeric($document_id) && $document_id > 0)) exit;

		// Если в запросе пришел параметр на полное удаление всех заметок
        if ($all == 1)
		{
			// Выполянем запрос к БД и удалаем заметки
            $AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_document_comments
				WHERE DokumentId = '" . $document_id . "'
			");

            // Выполняем обновление страницы
			header('Location:index.php?do=docs&action=comment&Id=' . $document_id . '&pop=1&cp=' . SESSION);
			exit;
		}
		else
		{
			if (!(isset($_REQUEST['CId']) && is_numeric($_REQUEST['CId']) && $_REQUEST['CId'] > 0)) exit;

            // В противном случае, выполняем запрос к БД и удаляем только ту заметку, которая была выбрана
			$AVE_DB->Query("
				DELETE
				FROM " . PREFIX . "_document_comments
				WHERE DokumentId = '" . $document_id . "'
				AND Id = '" . $_REQUEST['CId'] . "'
			");

			// Выполняем обновление страницы
            header('Location:index.php?do=docs&action=comment_reply&Id=' . $document_id . '&pop=1&cp=' . SESSION);
			exit;
		}
	}
}

?>