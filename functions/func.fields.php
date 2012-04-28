<?php
// Определяем пустое изображение
$img_pixel = 'templates/' . $_SESSION['admin_theme'] . '/images/blanc.gif';

function get_field_default($field_value,$type,$field_id='',$rubric_field_template='',$tpl_field_empty=0,&$maxlength = '',$document_fields=0,$rubric_id=0,$dropdown=''){
	global $AVE_Template, $AVE_Core, $AVE_Document;
	$res=0;
	switch ($type)
	{
		case 'edit' :
				$field  = '<a name="' . $field_id . '"></a>';
				$field .= '<input id="feld_' . $field_id . '" type="text" style="width:' . $AVE_Document->_field_width . '" name="feld[' . $field_id . ']" value="' . htmlspecialchars($field_value, ENT_QUOTES) . '"> ';
				$res=$field;
			break;

		case 'doc' :
			//$field_value = htmlspecialchars($field_value, ENT_QUOTES);
			$field_value = pretty_chars($field_value);
			$field_value = clean_php($field_value);
			$field_value = str_replace('"', '&quot;', $field_value);
			if (!$tpl_field_empty)
			{
				$field_param = explode('|', $field_value);
				$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $rubric_field_template);
			}
			$res=$field_value;
			break;

		case 'req' :
			$field_value = clean_php($field_value);
			$field_param = explode('|', $field_value);
			$field_param[1] = isset($field_param[1]) ? $field_param[1] : '';
			$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $document_fields[$rubric_id]['rubric_field_template_request']);	
			$res=$field_value;	
			break;
	}
	return ($res ? $res : $field_value);
}

function get_field_kurztext($field_value,$type,$field_id='',$rubric_field_template='',$tpl_field_empty=0,&$maxlength = '',$document_fields=0,$rubric_id=0,$dropdown=''){
	global $AVE_Template, $AVE_Core, $AVE_Document;
	$res=0;
	switch ($type)
	{
		case 'edit' :
				$field  = '<a name="' . $field_id . '"></a>';
				$field .= '<input id="feld_' . $field_id . '" type="text" style="width:' . $AVE_Document->_field_width . '" name="feld[' . $field_id . ']" value="' . htmlspecialchars($field_value, ENT_QUOTES) . '"> ';
				$res=$field;
			break;

		case 'doc' :
			//$field_value = htmlspecialchars($field_value, ENT_QUOTES);
			$field_value = pretty_chars($field_value);
			$field_value = clean_php($field_value);
			$field_value = str_replace('"', '&quot;', $field_value);
			if (!$tpl_field_empty)
			{
				$field_param = explode('|', $field_value);
				$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $rubric_field_template);
			}
			$res=$field_value;
			break;
			case 'req' :
				$res=get_field_default($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength,$document_fields,$rubric_id);
			break;
		case 'name' :
			$res='FIELD_TEXT';
		break;
	}
	return ($res ? $res : $field_value);
}

function get_field_smalltext($field_value,$type,$field_id='',$rubric_field_template='',$tpl_field_empty=0,&$maxlength = '',$document_fields=0,$rubric_id=0,$dropdown=''){
	global $AVE_Template, $AVE_Core, $AVE_Document;
	$res=0;
	switch ($type)
	{
		case 'edit' :
				if (isset($_COOKIE['no_wysiwyg']) && $_COOKIE['no_wysiwyg'] == 1)
				{
					$field  = "<a name=\"" . $field_id . "\"></a>";
					$field .= "<textarea style=\"width:" . $AVE_Document->_textarea_width_small . "; height:" . $AVE_Document->_textarea_height_small . "\"  name=\"feld[" . $field_id . "]\">" . $field_value . "</textarea>";
				}
				else
				{
					switch ($_SESSION['use_editor']) {
					case '0': // стандартный редактор
						$oFCKeditor = new FCKeditor('feld[' . $field_id . ']') ;
						$oFCKeditor->Height = $AVE_Document->_textarea_height_small;
						$oFCKeditor->Value  = $field_value;
						$oFCKeditor->ToolbarSet = 'cpengine_small';
						$field = $oFCKeditor->Create($field_id);
						break;
						
					case '1': // Elrte и Elfinder 
						$field  = '<a name="' . $field_id . '"></a>';
						$field  .='<textarea style="width:' . $AVE_Document->_textarea_width_small . ';height:' . $AVE_Document->_textarea_height_small . '" name="feld[' . $field_id . ']" class="small-editor">' . $field_value . '</textarea></div>';
						break;
						
					case '2': // Innova
						require(BASE_DIR . "/admin/redactor/innova/innova_settings.php");
						$field  = '<a name="' . $field_id . '"></a>';
						$field .= "<textarea style=\"width:" . $AVE_Document->_textarea_width_small . "; height:" . $AVE_Document->_textarea_height_small . "\"  name=\"feld[" . $field_id . "]\" Id=\"small-editor[" . $field_id . "]\">" . $field_value . "</textarea>";
						$field  .= $innova[2];
						break;	
					}		
				}
				$res=$field;
				break;
		case 'doc' :
			$field_value = document_pagination($field_value);
			$field_value = pretty_chars($field_value);
			if (!$tpl_field_empty)
			{
				$field_param = explode('|', $field_value);
				$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $rubric_field_template);
			}
			$res=$field_value;
			break;
		case 'req' :
				$res=get_field_default($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength,$document_fields,$rubric_id);
			break;
		case 'name' :
			$res='FIELD_TEXTAREA_S';
		break;
	}
	return ($res ? $res : $field_value);

}

function get_field_langtext($field_value,$type,$field_id='',$rubric_field_template='',$tpl_field_empty=0,&$maxlength = '',$document_fields=0,$rubric_id=0,$dropdown=''){
	global $AVE_Template, $AVE_Core, $AVE_Document;
	$res=0;
	switch ($type)
	{
		case 'edit' :
				if (isset($_COOKIE['no_wysiwyg']) && $_COOKIE['no_wysiwyg'] == 1)
				{
					$field  = '<a name="' . $field_id . '"></a>';
					$field .= '<textarea style="width:' . $AVE_Document->_textarea_width . ';height:' . $AVE_Document->_textarea_height . '" name="feld[' . $field_id . ']">' . $field_value . '</textarea>';
				}
				else
				{							
					switch ($_SESSION['use_editor']) {
					case '0': // стандартный редактор
						$oFCKeditor = new FCKeditor('feld[' . $field_id . ']') ;
						$oFCKeditor->Height = $AVE_Document->_textarea_height;
						$oFCKeditor->Value  = $field_value;
						$field  = $oFCKeditor->Create($field_id);
						break;
						
					case '1': // Elrte и Elfinder 
						$field  = '<a name="' . $field_id . '"></a>';
						$field  .='<textarea style="width:' . $AVE_Document->_textarea_width . ';height:' . $AVE_Document->_textarea_height . '" name="feld[' . $field_id . ']" class="editor">' . $field_value . '</textarea></div>';
						break;
						
					case '2': // Innova
						require(BASE_DIR . "/admin/redactor/innova/innova_settings.php");
						$field  = '<a name="' . $field_id . '"></a>';
						$field  .='<textarea style="width:' . $AVE_Document->_textarea_width . ';height:' . $AVE_Document->_textarea_height . '" name="feld[' . $field_id . ']" Id="editor[' . $field_id . ']">' . $field_value . '</textarea></div>';
						$field  .= $innova[1];
						break;	
					}					
				}
				$res=$field;
			break;
		case 'doc' :
			$res=get_field_smalltext($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength,$document_fields,$rubric_id);
			break;
		case 'req' :
				$res=get_field_default($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength,$document_fields,$rubric_id);
			break;
		case 'name' :
			$res='FIELD_TEXTAREA';
		break;
	}
	return ($res ? $res : $field_value);
}

function get_field_bild($field_value,$type,$field_id='',$rubric_field_template='',$tpl_field_empty=0,&$maxlength = '',$document_fields=0,$rubric_id=0,$dropdown=''){
	global $AVE_Template, $AVE_Core, $AVE_Document,$img_pixel;
	$res=0; 
	switch ($type)
	{
		case 'edit' :
				$massiv = explode('|', $field_value);
				$field  = "<a name=\"" . $field_id . "\"></a>";
				$field .= "<div id=\"images_feld_" . $field_id . "\"><img height=\"120px\"" . (!empty($field_value) ? '' : ' style="display:none"'). " id=\"_img_feld__" . $field_id . "\" src=\"" . (!empty($field_value) ? '../' . htmlspecialchars($massiv[0], ENT_QUOTES) : $img_pixel) . "\" alt=\"" . (isset($massiv[1]) ? htmlspecialchars($massiv[1], ENT_QUOTES) : '') . "\" border=\"0\" /></div>";
				$field .= "<div style=\"display:none\" id=\"span_feld__" . $field_id . "\">&nbsp;</div>" . (!empty($field_value) ? "<br />" : '');
								
				switch ($_SESSION['use_editor']) {
					case '0': // стандартный редактор
						$field .= "<div style=\"display:none\" id=\"span_feld__" . $field_id . "\">&nbsp;</div>" . (!empty($field_value) ? "<br />" : '');
						$field .= "<input type=\"text\" style=\"width:" . $AVE_Document->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\" id=\"img_feld__" . $field_id . "\" />&nbsp;";
						$field .= "<button class=\"button\" onclick=\"cp_imagepop('img_feld__" . $field_id . "', '', '', '0'); return false;\" name=\"feld[" . $field_id . "]\">" . $AVE_Template->get_config_vars('MAIN_OPEN_MEDIAPATH') . "</button>";
						break;
				
					case '1': // Elrte и Elfinder 
						$field .= "<input class=\"docm finder\" type=\"text\" style=\"width:" . $AVE_Document->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\" id=\"img_feld__" . $field_id . "\"/>&nbsp;";
						$field .= "<span class=\"button dialog_images\" rel=\"". $field_id ."\">" . $AVE_Template->get_config_vars('MAIN_OPEN_MEDIAPATH') . "</span>";
						break;
				}	
				$res=$field;
				break;
		case 'doc' :
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
			$res=$field_value;
			break;
		case 'req' :
			$field_value = clean_php($field_value);
			$field_param = explode('|', $field_value);
			$field_param[1] = isset($field_param[1]) ? $field_param[1] : '';
			if ($document_fields[$rubric_id]['tpl_req_empty'])
			{
				$field_value = '<img src="' . ABS_PATH . $field_param[0] . '" alt="' . $field_param[1] . '" border="0" />';
			}
			else
			{
				$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $document_fields[$rubric_id]['rubric_field_template_request']);
			}
			$maxlength = '';
			$res=$field_value;
			break;
		case 'name' :
			$res='FIELD_IMAGE';
		break;
	}	
	return ($res ? $res : $field_value);
}

function get_field_dropdown($field_value,$type,$field_id='',$rubric_field_template='',$tpl_field_empty=0,&$maxlength = '',$document_fields=0,$rubric_id=0,$dropdown=''){
	global $AVE_Template, $AVE_Core, $AVE_Document;
	$res=0;
	switch ($type)
	{
		case 'edit' :
				$items = explode(',', $dropdown);
				$field = "<select name=\"feld[" . $field_id . "]\">";
				$cnt = sizeof($items);
				for ($i=0;$i<$cnt;$i++)
				{
					$field .= "<option value=\"" . htmlspecialchars($items[$i], ENT_QUOTES) . "\"" . ((trim($field_value) == trim($items[$i])) ? " selected=\"selected\"" : "") . ">" . htmlspecialchars($items[$i], ENT_QUOTES) . "</option>";
				}
				$field .= "</select>";
				$res=$field;
			break;

		case 'doc' :
			$field_value = clean_php($field_value);
			if (!$tpl_field_empty)
			{
				$field_param = explode('|', $field_value);
				$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $rubric_field_template);
			}
			$res=$field_value;
			break;
			case 'req' :
				$res=get_field_default($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength,$document_fields,$rubric_id);
			break;
		case 'name' :
			$res='FIELD_DROPDOWN';
		break;
	
	}
	return ($res ? $res : $field_value);
}

function get_field_code($field_value,$type,$field_id='',$rubric_field_template='',$tpl_field_empty=0,&$maxlength = '',$document_fields=0,$rubric_id=0,$dropdown=''){
	global $AVE_Template, $AVE_Core, $AVE_Document;
	$res=0;
	switch ($type)
	{
		case 'edit' :
				$field  = "<a name=\"" . $field_id . "\"></a>";
				$field .= "<textarea id=\"feld_" . $field_id . "\" style=\"width:" . $AVE_Document->_textarea_width . "; height:" . $AVE_Document->_textarea_height . "\"  name=\"feld[" . $field_id . "]\">" . $field_value . "</textarea>";
				$res=$field;
			break;

		case 'doc' :
			$res=$field_value;
			break;
			case 'req' :
				$res=get_field_default($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength,$document_fields,$rubric_id);
			break;
	
		case 'name' :
			$res='FIELD_CODE';
		break;
	}
	return ($res ? $res : $field_value);
}

function get_field_link($field_value,$type,$field_id='',$rubric_field_template='',$tpl_field_empty=0,&$maxlength = '',$document_fields=0,$rubric_id=0,$dropdown=''){
	global $AVE_Template, $AVE_Core, $AVE_Document;
	$res=0;
	switch ($type)
	{
		case 'edit' :
				$field  = "<a name=\"" . $field_id . "\"></a>";
				$field .= "<input id=\"feld_" . $field_id . "\" type=\"text\" style=\"width:" . $AVE_Document->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\">&nbsp;";
				$field .= "<input value=\"" . $AVE_Template->get_config_vars('MAIN_BROWSE_DOCUMENTS') . "\" class=\"button\" type=\"button\" onclick=\"openLinkWin('feld_" . $field_id . "', 'feld_" . $field_id . "');\" />";
				$res=$field;
			break;

		case 'doc' :
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
			$res=$field_value;
			break;
			case 'req' :
			$field_value = clean_php($field_value);
			$field_param = explode('|', $field_value);
			if (empty($field_param[1])) $field_param[1] = $field_param[0];
			if ($document_fields[$rubric_id]['tpl_req_empty'])
			{
				$field_value = " <a target=\"_self\" href=\"" . ABS_PATH . $field_param[0] . "\">" . $field_param[1] . "</a>";
			}
			else
			{
				$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $document_fields[$rubric_id]['rubric_field_template_request']);
			}
			$maxlength = '';
			$res=$field_value;
			break;
		case 'name' :
			$res='FIELD_LINK';
		break;
	
	}
	return ($res ? $res : $field_value);
}

function get_field_flash($field_value,$type,$field_id='',$rubric_field_template='',$tpl_field_empty=0,&$maxlength = '',$document_fields=0,$rubric_id=0,$dropdown=''){
	global $AVE_Template, $AVE_Core, $AVE_Document,$img_pixel;
	$res=0;
	switch ($type)
	{
		case 'edit' :
				$field  = "<a name=\"" . $field_id . "\"></a>";
				$field .= "<div style=\"display:none\" id=\"feld_" . $field_id . "\"><img style=\"display:none\" id=\"_img_feld__" . $field_id . "\" src=\"". (!empty($field_value) ? htmlspecialchars($field_value, ENT_QUOTES) : $img_pixel) . "\" alt=\"\" border=\"0\" /></div>";
				$field .= "<div style=\"display:none\" id=\"span_feld__" . $field_id . "\"></div>";
				$field .= "<input type=\"text\" style=\"width:" . $AVE_Document->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\" id=\"img_feld__" . $field_id . "\" />&nbsp;";
				$field .= "<input value=\"" . $AVE_Template->get_config_vars('MAIN_OPEN_MEDIAPATH') . "\" class=\"button\" type=\"button\" onclick=\"cp_imagepop('img_feld__" . $field_id . "', '', '', '0');\" />";
				$field .= '<a class="button tooltip" title="'.$AVE_Template->get_config_vars('DOC_FLASH_TYPE_HELP').'" href="#">?</a>';
				$res=$field;
			break;

		case 'doc' :
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
			$res=$field_value;
			break;
			case 'req' :
				$res=get_field_default($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength,$document_fields,$rubric_id);
			break;
		case 'name' :
			$res='FIELD_FLASH';
		break;
	
	}
	return ($res ? $res : $field_value);
}

function get_field_download($field_value,$type,$field_id='',$rubric_field_template='',$tpl_field_empty=0,&$maxlength = '',$document_fields=0,$rubric_id=0,$dropdown=''){
	global $AVE_Template, $AVE_Core, $AVE_Document,$img_pixel;
	$res=0;
	switch ($type)
	{
		case 'edit' :
				$field  = "<div style=\"\" id=\"feld_" . $field_id . "\"><a name=\"" . $field_id . "\"></a>";
				$field .= "<div style=\"display:none\" id=\"feld_" . $field_id . "\">";
				$field .= "<img style=\"display:none\" id=\"_img_feld__" . $field_id . "\" src=\"" . (!empty($field_value) ? htmlspecialchars($field_value, ENT_QUOTES) : $img_pixel) . "\" alt=\"\" border=\"0\" /></div>";
				$field .= "<div style=\"display:none\" id=\"span_feld__" . $field_id . "\"></div>";
				$field .= "<input type=\"text\" style=\"width:" . $AVE_Document->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\" id=\"img_feld__" . $field_id . "\" />&nbsp;";
				$field .= "<input value=\"" . $AVE_Template->get_config_vars('MAIN_OPEN_MEDIAPATH') . "\" class=\"button\" type=\"button\" onclick=\"cp_imagepop('img_feld__" . $field_id . "', '', '', '0');\" />";
				$field .= '<a class="button tooltip" title="'.$AVE_Template->get_config_vars('DOC_FILE_TYPE_HELP').'" href="#">?</a>';
				$field .= '</div>';
				$res=$field;
			break;

		case 'doc' :
			$field_value = clean_php($field_value);
			$field_param = explode('|', $field_value);
			if ($tpl_field_empty)
			{
				$field_value = (!empty($field_param[1]) ? $field_param[1] . '<br />' : '')
					. '<form method="get" target="_blank" action="' . ABS_PATH . $field_param[0]
					. '"><input class="button" type="submit" value="Скачать" /></form>';
			}
			else
			{
				$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $rubric_field_template);
			}
			$res=$field_value;
			break;
			case 'req' :
				$res=get_field_default($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength,$document_fields,$rubric_id);
			break;
		case 'name' :
			$res='FIELD_DOWNLOAD';
		break;
	
	}
	return ($res ? $res : $field_value);
}

function get_field_video_mov($field_value,$type,$field_id='',$rubric_field_template='',$tpl_field_empty=0,&$maxlength = '',$document_fields=0,$rubric_id=0,$dropdown=''){
	global $AVE_Template, $AVE_Core, $AVE_Document,$img_pixel;
	$res=0;
	switch ($type)
	{
		case 'edit' :
				$field  = "<div style=\"\" id=\"feld_" . $field_id . "\"><a name=\"" . $field_id . "\"></a>";
				$field .= "<div style=\"display:none\" id=\"feld_" . $field_id . "\"><img style=\"display:none\" id=\"_img_feld__" . $field_id . "\" src=\"". (!empty($field_value) ? htmlspecialchars($field_value, ENT_QUOTES) : $img_pixel) . "\" alt=\"\" border=\"0\" /></div>";
				$field .= "<div style=\"display:none\" id=\"span_feld__" . $field_id . "\"></div>";
				$field .= "<input type=\"text\" style=\"width:" . $AVE_Document->_field_width . "\" name=\"feld[" . $field_id . "]\" value=\"" . htmlspecialchars($field_value, ENT_QUOTES) . "\" id=\"img_feld__" . $field_id . "\" />&nbsp;";
				$field .= "<input value=\"" . $AVE_Template->get_config_vars('MAIN_OPEN_MEDIAPATH') . "\" class=\"button\" type=\"button\" onclick=\"cp_imagepop('img_feld__" . $field_id . "', '', '', '0');\" />";
				$field .= '<a class="button tooltip" title="'.$AVE_Template->get_config_vars('DOC_VIDEO_TYPE_HELP').'" href="#">?</a>';
				$field .= '</div>';
				$res=$field;
			break;

		case 'doc' :
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
			$res=$field_value;
			break;
	
			case 'req' :
				$res=get_field_default($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength,$document_fields,$rubric_id);
			break;
		case 'name' :
			$res='FIELD_VIDEO_MOV';
		break;
	}
	return ($res ? $res : $field_value);
}
function get_field_video_avi($field_value,$type,$field_id='',$rubric_field_template='',$tpl_field_empty=0,&$maxlength = '',$document_fields=0,$rubric_id=0,$dropdown=''){
	$res=0;
	switch ($type)
	{
		case 'edit' :
			$res=get_field_video_mov($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength);
			break;
		case 'doc' :
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
			$res=$field_value;
			break;
			case 'req' :
				$res=get_field_default($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength,$document_fields,$rubric_id);
			break;
		case 'name' :
			$res='FIELD_VIDEO_AVI';
		break;

	}
	return ($res ? $res : $field_value);
}

function get_field_video_wmf($field_value,$type,$field_id='',$rubric_field_template='',$tpl_field_empty=0,&$maxlength = '',$document_fields=0,$rubric_id=0,$dropdown=''){
	$res=0;
	switch ($type)
	{
		case 'edit' :
			$res=get_field_video_mov($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength);
			break;
		case 'doc' :
			$res=get_field_video_avi($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength);
			break;

		case 'req' :
				$res=get_field_default($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength,$document_fields,$rubric_id);
			break;
		case 'name' :
			$res='FIELD_VIDEO_WMF';
		break;
	}
	
	return ($res ? $res : $field_value);
}

function get_field_video_wmv($field_value,$type,$field_id='',$rubric_field_template='',$tpl_field_empty=0,&$maxlength = '',$document_fields=0,$rubric_id=0,$dropdown=''){
	$res=0;
	switch ($type)
	{
		case 'edit' :
			$res=get_field_video_mov($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength);
			break;
		case 'doc' :
			$res=get_field_video_avi($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength);
			break;

		case 'req' :
				$res=get_field_default($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength,$document_fields,$rubric_id);
			break;
		case 'name' :
			$res='FIELD_VIDEO_WMV';
		break;
	}
	return ($res ? $res : $field_value);
}

function get_field_gps($field_value,$type,$field_id='',$rubric_field_template='',$tpl_field_empty=0,&$maxlength = '',$document_fields=0,$rubric_id=0,$dropdown=''){
	$res=0;
	switch ($type)
	{
		case 'edit' :
			$res=get_field_default($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength).'<input type="button" value="+" onclick="SetPlaceMarkCoords();return false;"/><input type="button" value="X" onclick="ErasePlaceMarkCoords();return false;"/>';
			$code='    <script src="http://api-maps.yandex.ru/1.1/index.xml?key='.YANDEX_MAP_API_KEY.'" type="text/javascript"></script>
    <script type="text/javascript">
        var map, geoResult, placemark;

        // Создание обработчика для события window.onLoad
        YMaps.jQuery(function () {
            // Создание экземпляра карты и его привязка к созданному контейнеру
            map = new YMaps.Map(YMaps.jQuery("#Map")[0]);

            // Установка для карты ее центра и масштаба
			if("<#--FIELD_VALUE--#>">""){var coord=new YMaps.GeoPoint(<#--FIELD_VALUE--#>);}else{var coord=new YMaps.GeoPoint(49.38,53.52);}
            map.setCenter(coord, 13);

            // Добавление элементов управления
            map.addControl(new YMaps.TypeControl());
			placemark = new YMaps.Placemark(coord, {draggable: true});
            placemark.name = "Результат";
            if("<#--FIELD_VALUE--#>">"")map.addOverlay(placemark);
 
            // При щелчке на карте показывается балун со значениями координат указателя мыши и масштаба
            YMaps.Events.observe(placemark, placemark.Events.DragEnd, function (obj) {
                // Задаем контент для балуна
				document.getElementById("feld_<#--FIELD_ID--#>").value=placemark.getGeoPoint();
                obj.update();
            });
        });

        // Функция для отображения результата геокодирования
        // Параметр value - адрес объекта для поиска
        function showAddress (value) {
            // Удаление предыдущего результата поиска
            map.removeOverlay(geoResult);

            // Запуск процесса геокодирования
            var geocoder = new YMaps.Geocoder(value, {results: 1, boundedBy: map.getBounds()});

            // Создание обработчика для успешного завершения геокодирования
            YMaps.Events.observe(geocoder, geocoder.Events.Load, function () {
                // Если объект был найден, то добавляем его на карту
                // и центрируем карту по области обзора найденного объекта
                if (this.length()) {
                    geoResult = this.get(0);
                    //map.addOverlay(geoResult);
                    map.setBounds(geoResult.getBounds());
                }else {
                    alert("Ничего не найдено")
                }
            });

            // Процесс геокодирования завершен неудачно
            YMaps.Events.observe(geocoder, geocoder.Events.Fault, function (geocoder, error) {
                alert("Произошла ошибка: " + error);
            })
        }
		function SetPlaceMarkCoords(){
			map.addOverlay(placemark);
			placemark.setGeoPoint(map.getCenter());
			document.getElementById("feld_<#--FIELD_ID--#>").value=placemark.getGeoPoint();
		}
		function ErasePlaceMarkCoords(){
			map.removeOverlay(placemark);
			document.getElementById("feld_<#--FIELD_ID--#>").value=\'\';
		}
    </script>';
			$code='<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript">
var geocoder = new google.maps.Geocoder();
var map=null;
var marker=null;

function updateMarkerPosition(latLng) {
  marker.setTitle([latLng].join(", "));
  document.getElementById("feld_<#--FIELD_ID--#>").value = [
    latLng.lat(),
    latLng.lng()
  ].join(", ");
}

function initialize() {
  if("<#--FIELD_VALUE--#>">""){
	var latlng = new google.maps.LatLng(<#--FIELD_VALUE--#>);
  }
  else
  {
    var latlng = new google.maps.LatLng(15.870, 100.992);
  }
  map = new google.maps.Map(document.getElementById("Map"), {
    zoom: 5,
    center: latlng,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  });
  if("<#--FIELD_VALUE--#>">""){
		SetPlaceMarkCoords();
	}
}

  function showAddress(address) {
    geocoder.geocode({
      "address": address,
      "partialmatch": true}, geocodeResult);
  }

  function geocodeResult(results, status) {
    if (status == "OK" && results.length > 0) {
      map.fitBounds(results[0].geometry.viewport);
    }
  }
  
function parseLatLng(value) {
  value.replace("/\s//g");
  var coords = value.split(",");
  var lat = parseFloat(coords[0]);
  var lng = parseFloat(coords[1]);
  if (isNaN(lat) || isNaN(lng)) {
    return null;
  } else {
    return new google.maps.LatLng(lat, lng);
  }
}


function ErasePlaceMarkCoords(){
   marker.setMap(null);
}
function SetPlaceMarkCoords(){
  if(marker==null){marker = new google.maps.Marker({
    position: map.getCenter(),
    title: "",
    map: map,
    draggable: true
  });}else {
	marker.setMap(map);
	marker.setPosition(map.getCenter());
	}
  
  // Update current position info.
  updateMarkerPosition(map.getCenter());
  
  // Add dragging event listeners.
  
  google.maps.event.addListener(marker, "drag", function() {
    updateMarkerPosition(marker.getPosition());
  });
  
  google.maps.event.addListener(marker, "dragend", function() {
    updateMarkerPosition(marker.getPosition());
  });
}  
// Onload handler to fire off the app.
google.maps.event.addDomListener(window, "load", initialize);



</script>
';
            $code.='<p>
			<input type="text" id="address" style="width:525px;" value="" />
            <input type="button" value="Искать" onclick="showAddress(document.getElementById(\'address\').value);return false;"/>
            <div id="Map" style="width:600px;height:400px"></div>';
			$res.=str_ireplace('<#--FIELD_ID--#>',$field_id,str_ireplace('<#--FIELD_VALUE--#>',$field_value,$code));
			break;
		case 'doc' :
			$res=get_field_default($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength);
			break;

		case 'req' :
				$res=get_field_default($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength,$document_fields,$rubric_id);
			break;
		case 'name' :
			$res='FIELD_GPS';
		break;
	}
	return ($res ? $res : $field_value);
}

function get_field_bild_multi($field_value,$type,$field_id='',$rubric_field_template='',$tpl_field_empty=0,&$maxlength = '',$document_fields=0,$rubric_id=0,$dropdown=''){
	global $AVE_Template, $AVE_Core, $AVE_Document;
	$res=0;
	
	switch ($_SESSION['use_editor']) {
		case '0': // стандартный редактор
		$img_js = 
			"'<img height=\"120px\" id=\"_img_feld__'+field_id+'_'+_id+'\" src=\"'+img_path+'\" alt=\"'+alt+'\" border=\"0\" />' +
			'<div style=\"display:none\" id=\"span_feld__'+field_id+ '_'+_id+'\">&nbsp;</div>' + (field_value ? '<br />' : '') + 
			'<input type=\"text\" style=\"width:70%;\" name=\"feld[' + field_id + '][]\" value=\"' + field_value + '\" id=\"img_feld__' + field_id +'_' + _id+'\" />&nbsp;'+
			'<input value=\"".$AVE_Template->get_config_vars('MAIN_OPEN_MEDIAPATH')."\" class=\"button\" type=\"button\" onclick=\"'+\"cp_imagepop('img_feld__\" + field_id + '_'+_id+\"', '', '', '0');\"+'\" />&nbsp;'";
		break;
    
		case '1': // Elrte и Elfinder 
		$img_js = 
			"'<div id=\"images_feld_'+field_id+'_'+_id+'\">' +
				'<img height=\"120px\" id=\"_img_feld__'+field_id+'_'+_id+'\" src=\"'+img_path+'\" alt=\"'+alt+'\" border=\"0\" />' +
			'</div>' +
			'<input class=\"docm finder\" type=\"text\" style=\"width:70%;\" name=\"feld[' + field_id + '][]\" value=\"' + field_value + '\" id=\"img_feld__' + field_id +'_' + _id+'\" />&nbsp;'+
			'<span class=\"button dialog_images\" rel=\"'+ field_id + '_'+_id+'\">".$AVE_Template->get_config_vars('MAIN_OPEN_MEDIAPATH')."</span>'";
		break;
    }
	$theme_folder =  '/admin/templates/'.DEFAULT_ADMIN_THEME_FOLDER;
	$jsCode = <<<BLOCK
		<script language="javascript" type="text/javascript">	
		function field_image_multi_add(field_id, field_value, img_path, alt){
			var
				_id = Math.round(Math.random()*1000);
				img_id = '__img_feld__' + field_id + '_' + _id;
		
			var html={$img_js}+
				'<input type="button" value="&#8593;" onclick="field_image_multi_move(' + field_id + ', ' + _id + ', \'up\')" />'+
				'<input type="button" value="&#8595;" onclick="field_image_multi_move(' + field_id + ', ' + _id + ', \'down\')" />'+
				'<input type="button" value="&#215;" onclick="if(window.confirm(\'Удалить?\'))field_image_multi_delete(' + field_id + ', ' + _id + ')" />'
								
				element=document.createElement("div");
				element.id=img_id;
				element.innerHTML=html;
				document.getElementById("feld_"+field_id).appendChild(element);

				$('.dialog_images').click(function() {
					var id = $(this).attr("rel");
					$('<div/>').dialogelfinder({
						url : ave_path+'admin/redactor/elfinder/php/connector.php',
						lang : 'ru',
						width : 1100,
						height: 600,
						modal : true, 
						title : 'Файловый менеджер',
						getFileCallback : function(files, fm) {
							$("#img_feld__"+id).val(files['url'].slice(1)); 
							$("#images_feld_"+id).html('<img height="120px" src='+files['url']+'>');
						},
						commandsOptions : {
							getfile : {
								oncomplete : 'destroy',
								folders : false
							}
						}
					})
				});
		}
		
		function field_image_multi_delete(field_id, id){
			img_id = '__img_feld__' + field_id + '_' + id;
			element=document.getElementById(img_id);
			element.parentNode.removeChild(element);
		}
		
		function field_image_multi_move(field_id, id, direction){ // direction: {up, down};
			img_id = '__img_feld__' + field_id + '_' + id;
			element=document.getElementById(img_id);
			
			if(direction=='up')
				neighbour=element.previousSibling;
			else
				neighbour=element.nextSibling;
			
			if(neighbour){
				if(direction=='up')
					neighbour.parentNode.insertBefore(element.parentNode.removeChild(element), neighbour);
				else{
					if( neighbour.nextSibling )
						neighbour.parentNode.insertBefore(element.parentNode.removeChild(element), neighbour.nextSibling);
					else
						neighbour.parentNode.appendChild(element.parentNode.removeChild(element));
				}
			}
		}
		
		function field_image_multi_opimport(field_id){	
			$("#on"+field_id).hide();
			var html='<br>Указывать нужно папку (Формат: uploads/images/samepath/)<br><input type="text" style="width:{$AVE_Document->_field_width}" value="uploads/images/" id="img_importfeld__' + field_id +'" />&nbsp;'+
				'<input type="button" class="button" onclick="field_image_multi_import(' + field_id + ');" value="Импорт" />';
				element=document.createElement("div");
				element.id=img_id;
				element.innerHTML=html; 
				document.getElementById("feld_"+field_id).appendChild(element);
		}
		
		function field_image_multi_import(field_id){
			
			var path_import = $("#img_importfeld__"+field_id).val(); 
			var html = '';	
		
			$.ajax({
				url: ave_path+'admin/index.php?do=docs&action=image_import', 
				data: {"path": path_import}, 
				dataType: "json",
				success: function(dat) {
					
					for (var p = 0, max = dat.respons.length; p < max; p++) {
						var field_value = path_import + dat.respons[p];
						var img_path = '../index.php?thumb=' + field_value;
						field_image_multi_add(field_id, field_value, img_path, '');
					}
				},
				error: function(data) {
					alert("Ошибка импорта");
				},
			}); 
		}
		</script>
BLOCK;

	static $jsCodeWritten; // статическая переменная, показывающая, были ли уже выведен JS для редактирования поля multi image

	switch ($type)
	{
		case 'edit' :
			$field='';
			// выводим JS-код, только один раз
			if($jsCodeWritten!==1){
				$field.=$jsCode;
				$jsCodeWritten=1;
			}
			
			$field.="
				<div id=\"feld_{$field_id}\">
				</div>
				<input type='button' onclick=\"field_image_multi_add({$field_id},'','','');\" value='Добавить' /> <input type='button' id='on".$field_id."' onclick=\"field_image_multi_opimport({$field_id});\" value='Импорт' />
				<script language=\"javascript\" type=\"text/javascript\">";
				$massa=unserialize($field_value);
				if($massa!=false){
					foreach($massa as $k=>$v){
						$massiv = explode('|', $v);
						if($v){
							$field.="
							field_image_multi_add(
								'{$field_id}',
								'" . htmlspecialchars($v, ENT_QUOTES) . "',
								'" . (!empty($v) ? '../index.php?thumb=' . htmlspecialchars($massiv[0], ENT_QUOTES) : $img_pixel) . "',
								'" . (isset($massiv[1]) ? htmlspecialchars($massiv[1], ENT_QUOTES) : '') . "');";
						}
					}
						/* $field.="
						field_image_multi_add_".$field_id."(
							'".$field_id."',
							'',
							'',
							'');"; */
				}
				else
				{
							$field.="
							field_image_multi_add({$field_id},'','','');";
				}
				$field.="</script>";
				$res=$field;
			break;

		case 'doc' :
			$massa=unserialize($field_value);
			$res='';
			if($massa!=false)
				foreach($massa as $k=>$v)
				{
					$v = clean_php($v);
					$field_param = explode('|', $v);
					if($v){
						if ($tpl_field_empty)
						{
							$v = '<li><img src="'.ABS_PATH.$field_param[0].'" alt="'.$field_param[1].'"/></li>';
						}
						else
						{
							$v = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $rubric_field_template);
						}
					}
					$res.=$v;
				}
			break;
			
			

		case 'req' :
			$massa=unserialize($field_value);
			$res='';
			$rubric_field_template_request = $document_fields[$rubric_id]['rubric_field_template_request'];	
			if($massa!=false)
				foreach($massa as $k=>$v)
				{
					$v = clean_php($v);
					$field_param = explode('|', $v);
					if($v){
						if (!$rubric_field_template_request)
						{
							$v = '<li><img src="'.ABS_PATH.$field_param[0].'" alt="'.$field_param[1].'"/></li>';
						}
						else
						{
							$v = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $rubric_field_template_request);
						}
					}
					$res.=$v;
				}
			break;
			
		case 'name' :
			$res='FIELD_BILD_MULTI';
		break;
	}
	return ($res ? $res : $field_value);
			
}

function get_field_docfromrub($field_value,$type,$field_id='',$rubric_field_template='',$tpl_field_empty=0,&$maxlength = '',$document_fields=0,$rubric_id=0,$dropdown=''){
	global $AVE_DB,$AVE_Template, $AVE_Core, $AVE_Document;
	$res=0;
	switch ($type)
	{
		case 'edit' :
				$field  = '<a name="' . $field_id . '"></a>';
				$sql="SELECT Id,document_title from ". PREFIX ."_documents WHERE rubric_id='".$dropdown."' ORDER BY document_title ASC";
				$res=$AVE_DB->Query($sql);
				$field = "<select name=\"feld[" . $field_id . "]\">";
				while($row = $res->FetchRow()){
					$field.="<option value=\"" . htmlspecialchars($row->Id, ENT_QUOTES) . "\"" . ((trim($field_value) == trim($row->Id)) ? " selected=\"selected\"" : "") . ">" . htmlspecialchars($row->document_title, ENT_QUOTES) . "</option>";
				}
				$field .= "</select>";
				
				$res=$field;
			break;

		case 'doc' :
			$field_value = htmlspecialchars($field_value, ENT_QUOTES);
			$field_value = pretty_chars($field_value);
			$field_value = clean_php($field_value);
			$field_value = str_replace('"', '&quot;', $field_value);
			if (!$tpl_field_empty)
			{
				$field_param = explode('|', $field_value);
				$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $rubric_field_template);
			}
			$res=$field_value;
			break;

			case 'req' :
			$res=get_field_default($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength,$document_fields,$rubric_id);

			break;
		case 'name' :
			$res='FIELD_DOCFROMRUB';
		break;
	}
	return ($res ? $res : $field_value);
			
}

function get_field_docfromrubcheck($field_value,$type,$field_id='',$rubric_field_template='',$tpl_field_empty=0,&$maxlength = '',$document_fields=0,$rubric_id=0,$dropdown=''){
	global $AVE_DB,$AVE_Template, $AVE_Core, $AVE_Document;

	$res=0;
	switch ($type)
	{
		case 'edit' :
				$sql="SELECT Id,document_title from ". PREFIX ."_documents WHERE rubric_id='".$dropdown."' order by document_title";
				$field_value=unserialize($field_value);
				$res=$AVE_DB->Query($sql);
				$field = "";
				while($row = $res->FetchRow()){
					$field.="<input name=\"feld[" . $field_id . "][]\" value=\"".$row->Id."\" type=\"checkbox\" ".((in_array($row->Id, $field_value)==false) ? "" : "checked=checked")."><label>".htmlspecialchars($row->document_title, ENT_QUOTES)."</label></br>";
				}
				$field .= "";
				
				$res=$field;
			break;

		case 'doc' :
			$field_value1=unserialize($field_value);
			if(is_array($field_value1)){
				$res=$AVE_DB->Query("SELECT Id,document_title FROM " . PREFIX . "_documents WHERE Id IN (".implode(', ',$field_value1).")");
				$result=Array();
				while ($mfa=$res->FetchArray())$result[$mfa['Id']]=$mfa['document_title'];
				$res='';
				if ($tpl_field_empty)$res.='<ul>';
				foreach($field_value1 as $k=>$v){	
					$field_value = htmlspecialchars($v, ENT_QUOTES);
					$field_value = pretty_chars($field_value);
					$field_value = clean_php($field_value);
					if (!$tpl_field_empty)
					{
						$field_param = explode('|', $field_value);
						$field_value = preg_replace('/\[tag:parametr:(\d+)\]/ie', '@$field_param[\\1]', $rubric_field_template);
					}
					else
					{
					  $field_value="<li>".$result[$field_value]."</li>";
					}
					$res.=$field_value;
				}
				if ($tpl_field_empty)$res.='</ul>';
			}
			break;

			case 'req' :
			$res=get_field_default($field_value,$type,$field_id,$rubric_field_template,$tpl_field_empty,$maxlength,$document_fields,$rubric_id);

			break;
		case 'name' :
			$res='FIELD_DOCFROMRUB_CHECK';
		break;
	}	return ($res ? $res : $field_value);
			
}


if(file_exists(BASE_DIR . '/functions/user.fields.php'))
	require(BASE_DIR . '/functions/user.fields.php');

function get_field_type()
{
	global $AVE_Template;
	static $felder;
	if(is_array($felder))return $felder;
	$arr = get_defined_functions();

	$AVE_Template->config_load(BASE_DIR . '/admin/lang/' . $_SESSION['admin_language'] . '/fields.txt', 'fields');
	$felder_vars = $AVE_Template->get_config_vars();
	$felder=Array();
	foreach($arr['user'] as $k=>$v)
	{
		if(trim(substr($v,0,strlen('get_field_')))=='get_field_')
		{
			$d='';
			$name=@$v('','name','','',0,$d);
			$id=substr($v,strlen ('get_field_'));
			if($name!=false && is_string($name))$felder[]=array('id' => $id,'name' => ($felder_vars[$name] ? $felder_vars[$name] : $name));
		}	
	}
/*	$felder = array(
	);
*/
	return $felder;
}

?>