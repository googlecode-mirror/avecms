<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

/**
 * ѕостранична€ навигаци€ документа
 *
 * @param string $text	текст многострочной части документа
 * @return string
 */
function document_pagination($text)
{
	global $AVE_Core;

// IE8                    <div style="page-break-after: always"><span style="display: none">&nbsp;</span></div>
// Chrome                 <div style="page-break-after: always; "><span style="DISPLAY:none">&nbsp;</span></div>
// FF                     <div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>
	$pages = preg_split('#<div style="page-break-after: always[; ]*"><span style="display:[ ]*none[;]*">&nbsp;</span></div>#i', $text);
	$total_page = @sizeof($pages);

	if ($total_page > 1)
	{
		$text = @$pages[get_current_page('artpage')-1];

		$page_nav = ' <a class="pnav" href="index.php?id=' . $AVE_Core->curentdoc->Id
			. '&amp;doc=' . (empty($AVE_Core->curentdoc->document_alias) ? prepare_url($AVE_Core->curentdoc->document_title) : $AVE_Core->curentdoc->document_alias)
			. '&amp;artpage={s}'
//			. ((isset($_REQUEST['apage']) && is_numeric($_REQUEST['apage'])) ? '&amp;apage=' . $_REQUEST['apage'] : '')
//			. ((isset($_REQUEST['page']) && is_numeric($_REQUEST['page'])) ? '&amp;page=' . $_REQUEST['page'] : '')
			. '">{t}</a> ';
		$page_nav = get_pagination($total_page, 'artpage', $page_nav, get_settings('navi_box'));

		$text .= rewrite_link($page_nav);
	}

	return $text;
}

/**
 * ‘ормирование пол€ документа в соответствии с шаблоном отображени€
 *
 * @param int $field_id	идентификатор пол€
 * @return string
 */
function document_get_field($field_id)
{
	global $AVE_Core;

	if (is_array($field_id)) $field_id = $field_id[1];

	$document_fields = get_document_fields($AVE_Core->curentdoc->Id);

	if (empty($document_fields[$field_id])) return '';

	$field_value = trim($document_fields[$field_id]['field_value']);

	$tpl_field_empty = $document_fields[$field_id]['tpl_field_empty'];

	if ($field_value == '' && $tpl_field_empty) return '<!-- EMPTY -->';

	$field_type = $document_fields[$field_id]['rubric_field_type'];

	$rubric_field_template = trim($document_fields[$field_id]['rubric_field_template']);

//	$field_value = parse_hide($field_value);
//	$field_value = ($length != '') ? truncate_text($field_value, $length, 'Е', true) : $field_value;

	switch ($field_type)
	{
		case 'kurztext' :
			$field_value = htmlspecialchars($field_value, ENT_QUOTES);
			$field_value = pretty_chars($field_value);
			$field_value = clean_php($field_value);
			if (!$tpl_field_empty)
			{
				$field_param = explode('|', $field_value);
				$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $rubric_field_template);
			}
			break;

		case 'langtext' :
		case 'smalltext' :
			$field_value = document_pagination($field_value);
			$field_value = pretty_chars($field_value);
			if (!$tpl_field_empty)
			{
				$field_param = explode('|', $field_value);
				$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $rubric_field_template);
			}
			break;

		case 'dropdown' :
			$field_value = clean_php($field_value);
			if (!$tpl_field_empty)
			{
				$field_param = explode('|', $field_value);
				$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $rubric_field_template);
			}
			break;

		case 'bild' :
			$field_value = clean_php($field_value);
			$field_param = explode('|', $field_value);
			if ($tpl_field_empty)
			{
				$field_value = '<img alt="' . (isset($field_param[1]) ? $field_param[1] : '')
					. '" src="' . ABS_PATH . $field_param[0] . '" border="0" />';
			}
			else
			{
				$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $rubric_field_template);
			}
			break;

		case 'download' :
			$field_value = clean_php($field_value);
			$field_param = explode('|', $field_value);
			if ($tpl_field_empty)
			{
				$field_value = (!empty($field_param[1]) ? $field_param[1] . '<br />' : '')
					. '<form method="get" target="_blank" action="' . ABS_PATH . $field_param[0]
					. '"><input class="button" type="submit" value="—качать" /></form>';
			}
			else
			{
				$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $rubric_field_template);
			}
			break;

		case 'link' :
			$field_value = clean_php($field_value);
			$field_param = explode('|', $field_value);
			$field_param[1] = empty($field_param[1]) ? $field_param[0] : $field_param[1];
			if ($tpl_field_empty)
			{
				$field_value = ' <a target="_self" href="' . ABS_PATH . $field_param[0] . '">' . $field_param[1] . '</a>';
			}
			else
			{
				$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $rubric_field_template);
			}
			break;

		case 'video_avi' :
		case 'video_wmf' :
		case 'video_wmv' :
			$field_value = clean_php($field_value);
			$field_param = explode('|', $field_value);
			$field_param[1] = (!empty($field_param[1]) && is_numeric($field_param[1])) ? $field_param[1] : 470;
			$field_param[2] = (!empty($field_param[2]) && is_numeric($field_param[2])) ? $field_param[2] : 320;
			if ($tpl_field_empty)
			{
				$field_value = '<object id="MediaPlayer" classid="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6" '
					. 'codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112" height="'
						. $field_param[2] . '" width="' . $field_param[1] . '">'
					. '<param name="animationatStart" value="false">'
					. '<param name="autostart" value="false">'
					. '<param name="url" value="' . ABS_PATH . $field_param[0] . '">'
					. '<param name="volume" value="-200">'
					. '<embed type="application/x-mplayer2" pluginspage="http://www.microsoft.com/Windows/MediaPlayer/" name="MediaPlayer" src="'
						. ABS_PATH . $field_param[0] . '" autostart="0" displaysize="0" showcontrols="1" showdisplay="0" showtracker="1" showstatusbar="1" height="'
						. $field_param[2] . '" width="' . $field_param[1] . '">'
					. '</object>';
			}
			else
			{
				$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $rubric_field_template);
			}
			break;

		case 'video_mov' :
			$field_value = clean_php($field_value);
			$field_param = explode('|', $field_value);
			$field_param[1] = (!empty($field_param[1]) && is_numeric($field_param[1])) ? $field_param[1] : 470;
			$field_param[2] = (!empty($field_param[2]) && is_numeric($field_param[2])) ? $field_param[2] : 320;
			if ($tpl_field_empty)
			{
				$field_value = '<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" width="' . $field_param[1]
						. '" height="' . $field_param[2] . '" codebase="http://www.apple.com/qtactivex/qtplugin.cab">'
					. '<param name="src" value="' . ABS_PATH . $field_param[0] . '">'
					. '<param name="autoplay" value="false">'
					. '<param name="controller" value="true">'
					. '<param name="target" value="myself">'
					. '<param name="type" value="video/quicktime">'
					. '<embed target="myself" src="' . ABS_PATH . $field_param[0] . '" width="' . $field_param[1] . '" height="' . $field_param[2]
						. '" autoplay="false" controller="true" type="video/quicktime" pluginspage="http://www.apple.com/quicktime/download/">'
					. '</embed>'
					. '</object>';
			}
			else
			{
				$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $rubric_field_template);
			}
			break;

		case 'flash' :
			$field_value = clean_php($field_value);
			$field_param = explode('|', $field_value);
			$field_param[1] = (!empty($field_param[1]) && is_numeric($field_param[1])) ? $field_param[1] : 470;
			$field_param[2] = (!empty($field_param[2]) && is_numeric($field_param[2])) ? $field_param[2] : 320;
			if ($tpl_field_empty)
			{
				$field_value = '<embed scale="exactfit" width="' . $field_param[1] . '" height="' . $field_param[2]
					. '" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" src="'
					. ABS_PATH . $field_param[0] . '" play="true" loop="true" menu="true"></embed>';
			}
			else
			{
				$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $rubric_field_template);
			}
			break;
	}

	if (isset($_SESSION['user_adminmode']) && $_SESSION['user_adminmode'] == 1)
	{
		$wysmode = false;

		if (defined('UGROUP') && UGROUP == 1) $wysmode = true;
		elseif (isset($_SESSION[RUB_ID . '_alles'])   && $_SESSION[RUB_ID . '_alles']   == 1) $wysmode = true;
		elseif (isset($_SESSION[RUB_ID . '_editall']) && $_SESSION[RUB_ID . '_editall'] == 1) $wysmode = true;
		elseif (isset($_SESSION[RUB_ID . '_editown']) && $_SESSION[RUB_ID . '_editown'] == 1 &&
				isset($_SESSION['user_id']) && $_SESSION['user_id'] == $document_fields[$field_id]['document_author_id']) $wysmode = true;

		if ($wysmode)
		{
			$field_value .= "<a href=\"javascript:;\" onclick=\"window.open('" . ABS_PATH
				. "admin/index.php?do=docs&action=edit&closeafter=1&rubric_id=" . RUB_ID . "&Id=" . ((int)$_REQUEST['id'])
				. "&pop=1&feld=" . $document_fields[$field_id]['Id'] . "#" . $document_fields[$field_id]['Id']
				. "','EDIT','left=0,top=0,width=950,height=700,scrollbars=1');\">"
				. "<img style=\"vertical-align:middle\" src=\"" . ABS_PATH . "inc/stdimage/edit.gif\" border=\"0\" alt=\"\" /></a>";
			if ($field_type == 'bild')
			{
				$field_value =	'<p style="width:100%;float:left;border:1px dashed #ccc;border-top:0px;line-heigth:0.1em;padding:3px">'
								. $field_value .
								'</p><p style="line-height:0.1em;clear:both"></p>';
			}
		}
	}

	return $field_value;
}

/**
 * ‘ункци€ получени€ содержимого пол€ дл€ обработки в шаблоне рубрики
 *
 * @param int $field_id	идентификатор пол€, дл€ [tag:fld:12] $field_id = 12
 * @param int $length	необ€зательный параметр,
 * 						количество возвращаемых символов содержимого пол€.
 * 						если данный параметр указать со знаком минус
 * 						содержимое пол€ будет очищено от HTML-тэгов.
 * @return string
 */
function document_get_field_value($field_id, $length = 0)
{
	if (!is_numeric($field_id)) return '';

	$document_fields = get_document_fields(get_current_document_id());

	$field_value = trim($document_fields[$field_id]['field_value']);

	if ($field_value != '')
	{
//		$field_value = strip_tags($field_value, "<br /><strong><em><p><i>");

		if (is_numeric($length) && $length != 0)
		{
			if ($length < 0)
			{
				$field_value = strip_tags($field_value);
				$field_value = preg_replace('/  +/', ' ', $field_value);
				$field_value = trim($field_value);
				$length = abs($length);
			}
			$field_value = truncate_text($field_value, $length, 'Е', true);
		}
	}

	return $field_value;
}

?>