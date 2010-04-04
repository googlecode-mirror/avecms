<?php

/**
 * AVE.cms
 *
 * @package AVE.cms
 * @filesource
 */

function stringLimiter($string, $maxlength)
{
	return substr($string, 0, $maxlength) . '... ';
	return substr($string, 0, $maxlength) . ((strlen($string) > $maxlength) ? '... ' : '');
}

function docPages($text)
{
	global $AVE_Globals, $AVE_Core;

	$pages = explode('<div style="page-break-after: always;"><span style="display: none;">&nbsp;</span></div>', $text);
	$total_page = @sizeof($pages);

	if ($total_page > 1)
	{
		$text = @$pages[prepage('artpage')-1];
		$doc = empty($_REQUEST['doc']) ? (empty($AVE_Core->curentdoc->Url) ? 'index' : $AVE_Core->curentdoc->Url) : $_REQUEST['doc'];
		$template_label = " <a class=\"pnav\" href=\"index.php?id=" . $AVE_Core->curentdoc->Id . "&amp;doc=" . $doc . "&amp;artpage={s}\">{t}</a> ";
		$page_nav = pagenav($total_page, 'artpage', $template_label, $AVE_Globals->mainSettings('navi_box'));
		$text .= (CP_REWRITE == 1) ? cpRewrite($page_nav) : $page_nav;
	}

	return $text;
}

/**
 * Функция получения содержимого поля для обработки в шаблоне рубрики
 *
 * @param int $id - идентификатор поля, для [cprub:12] $id=12
 * @param int $maxlength - необязательный параметр,
 * количество возвращаемых символов содержимого поля.
 * если данный параметр указать со знаком минус
 * содержимое поля будет очищено от HTML-тэгов.
 * @return string
 */
function getRubField($id, $maxlength = 0)
{
	if (!is_numeric($id)) return '';

	$document_fields = get_document_fields(currentDocId());

	$field = trim($document_fields[$id]['Inhalt']);

	if ($field != '')
	{
//		$field = strip_tags($field, "<br /><strong><em><p><i>");

		if (is_numeric($maxlength) && $maxlength != 0)
		{
			if ($maxlength < 0)
			{
				$field = strip_tags($field);
				$field = preg_replace('/(\s+)/', ' ', $field);
				$field = trim($field);
				$maxlength = abs($maxlength);
			}
			$field = stringLimiter($field, $maxlength);
		}
	}

	return $field;
}

function parseFields($id, $width='', $height='', $length='')
{
	global $AVE_DB, $docs_fields;

	if (is_array($id)) $id = $id[1];
	$doc_id = currentDocId();

	$document_fields = get_document_fields($doc_id);

	if (empty($document_fields[$id])) return '';
	$inhalt = trim($document_fields[$id]['Inhalt']);
	$tpl_field_empty = $document_fields[$id]['tpl_field_empty'];
	if ($inhalt == '' && $tpl_field_empty) return '<!-- EMPTY -->';

	$rub_type  = $document_fields[$id]['RubTyp'];
	$tpl_field = trim($document_fields[$id]['tpl_field']);

//	$inhalt = stripslashes(hide($inhalt));
	$inhalt = ($length != '') ? stringLimiter($inhalt, $length) : $inhalt;

	$disfirst = false;
	switch ($rub_type)
	{
		case 'kurztext' :
			$inhalt = phpReplace(prettyChars($inhalt));
			if (!$tpl_field_empty)
			{
				$field_param = explode('|', $inhalt);
				$inhalt = preg_replace('/\[field_param:(\d+)\]/ie', '@$field_param[\\1]', $tpl_field);
			}
			break;

		case 'langtext' :
		case 'smalltext' :
			$inhalt = docPages($inhalt);
			$inhalt = prettyChars($inhalt);
			if (!$tpl_field_empty)
			{
				$field_param = explode('|', $inhalt);
				$inhalt = preg_replace('/\[field_param:(\d+)\]/ie', '@$field_param[\\1]', $tpl_field);
			}
			break;

		case 'dropdown' :
			$inhalt = phpReplace($inhalt);
			if (!$tpl_field_empty)
			{
				$field_param = explode('|', $inhalt);
				$inhalt = preg_replace('/\[field_param:(\d+)\]/ie', '@$field_param[\\1]', $tpl_field);
			}
			break;

		case 'bild' :
			$inhalt = phpReplace($inhalt);
			$field_param = explode('|', $inhalt);
			if ($tpl_field_empty)
			{
				$inhalt = '<img alt="' . (isset($field_param[1]) ? $field_param[1] : '')
					. '" src="' . $field_param[0] . '" border="0" />';
			}
			else
			{
				$inhalt = preg_replace('/\[field_param:(\d+)\]/ie', '@$field_param[\\1]', $tpl_field);
			}
			$disfirst = true;
			break;

		case 'download' :
			$inhalt = phpReplace($inhalt);
			$field_param = explode('|', $inhalt);
			if ($tpl_field_empty)
			{
				$inhalt = (!empty($field_param[1]) ? $field_param[1] . '<br />' : '')
					. '<form method="get" target="_blank" action="' . $field_param[0]
					. '"><input class="button" type="submit" value="Скачать" /></form>';
			}
			else
			{
				$inhalt = preg_replace('/\[field_param:(\d+)\]/ie', '@$field_param[\\1]', $tpl_field);
			}
			break;

		case 'link' :
			$inhalt = phpReplace($inhalt);
			$field_param = explode('|', $inhalt);
			$field_param[1] = empty($field_param[1]) ? $field_param[0] : $field_param[1];
			if ($tpl_field_empty)
			{
				$inhalt = ' <a target="_self" href="' . $field_param[0] . '">' . $field_param[1] . '</a>';
			}
			else
			{
				$inhalt = preg_replace('/\[field_param:(\d+)\]/ie', '@$field_param[\\1]', $tpl_field);
			}
			break;

		case 'video_avi' :
		case 'video_wmf' :
		case 'video_wmv' :
			$inhalt = phpReplace($inhalt);
			$field_param = explode('|', $inhalt);
			$field_param[1] = (!empty($field_param[1]) && is_numeric($field_param[1])) ? $field_param[1] : 470;
			$field_param[2] = (!empty($field_param[2]) && is_numeric($field_param[2])) ? $field_param[2] : 320;
			if ($tpl_field_empty)
			{
				$inhalt = '<object id="MediaPlayer" classid="CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6" '
					. 'codebase="http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112" height="'
					. $field_param[2] . '" width="' . $field_param[1] . '">'
					. '<param name="animationatStart" value="false">'
					. '<param name="autostart" value="false">'
					. '<param name="url" value="' . $field_param[0] . '">'
					. '<param name="volume" value="-200">'
					. '<embed type="application/x-mplayer2" pluginspage="http://www.microsoft.com/Windows/MediaPlayer/" name="MediaPlayer" src="'
					. $field_param[0] . '" autostart="0" displaysize="0" showcontrols="1" showdisplay="0" showtracker="1" showstatusbar="1" height="'
					. $field_param[2] . '" width="' . $field_param[1] . '">'
					. '</object>';
			}
			else
			{
				$inhalt = preg_replace('/\[field_param:(\d+)\]/ie', '@$field_param[\\1]', $tpl_field);
			}
			break;

		case 'video_mov' :
			$inhalt = phpReplace($inhalt);
			$field_param = explode('|', $inhalt);
			$field_param[1] = (!empty($field_param[1]) && is_numeric($field_param[1])) ? $field_param[1] : 470;
			$field_param[2] = (!empty($field_param[2]) && is_numeric($field_param[2])) ? $field_param[2] : 320;
			if ($tpl_field_empty)
			{
				$inhalt = '<object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" width="' . $field_param[1]
					. '" height="' . $field_param[2] . '" codebase="http://www.apple.com/qtactivex/qtplugin.cab">'
					. '<param name="src" value="' . $field_param[0] . '">'
					. '<param name="autoplay" value="false">'
					. '<param name="controller" value="true">'
					. '<param name="target" value="myself">'
					. '<param name="type" value="video/quicktime">'
					. '<embed target="myself" src="' . $field_param[0] . '" width="' . $field_param[1] . '" height="' . $field_param[2]
					. '" autoplay="false" controller="true" type="video/quicktime" pluginspage="http://www.apple.com/quicktime/download/">'
					. '</embed>'
					. '</object>';
			}
			else
			{
				$inhalt = preg_replace('/\[field_param:(\d+)\]/ie', '@$field_param[\\1]', $tpl_field);
			}
			break;

		case 'flash' :
			$inhalt = phpReplace($inhalt);
			$field_param = explode('|', $inhalt);
			$field_param[1] = (!empty($field_param[1]) && is_numeric($field_param[1])) ? $field_param[1] : 470;
			$field_param[2] = (!empty($field_param[2]) && is_numeric($field_param[2])) ? $field_param[2] : 320;
			if ($tpl_field_empty)
			{
				$inhalt = '<embed scale="exactfit" width="' . $field_param[1] . '" height="' . $field_param[2]
					. '" type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" src="'
					. $field_param[0] . '" play="true" loop="true" menu="true"></embed>';
			}
			else
			{
				$inhalt = preg_replace('/\[field_param:(\d+)\]/ie', '@$field_param[\\1]', $tpl_field);
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
				isset($_SESSION['user_id']) && $_SESSION['user_id'] == $document_fields[$id]['Redakteur']) $wysmode = true;

		if ($wysmode)
		{
			$inhalt .= "<a href=\"javascript:;\" onclick=\"window.open('admin/index.php?do=docs&action=edit&closeafter=1&RubrikId="
				. RUB_ID . "&Id=" . addslashes((int)$_REQUEST['id']) . "&pop=1&feld=" . $document_fields[$id]['Id']
				. "#" . $document_fields[$id]['Id'] . "','EDIT','left=0,top=0,width=950,height=700,scrollbars=1');\">"
				. "<img style=\"vertical-align:middle\" src=\"inc/stdimage/edit.gif\" border=\"0\" alt=\"\" /></a>";
			if ($disfirst) {
				$inhalt = '<p style="width:100%;float:left;border:1px dashed #ccc;border-top:0px;line-heigth:0.1em;padding:3px">'
					. $inhalt . '</p><p style="line-height:0.1em;clear:both"></p>';
			}
		}
	}

	return $inhalt;
}

?>