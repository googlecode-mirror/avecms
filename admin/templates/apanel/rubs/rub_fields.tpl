<link rel="stylesheet" href="{$ABS_PATH}admin/codemirror/lib/codemirror.css">

<script src="{$ABS_PATH}admin/codemirror/lib/codemirror.js" type="text/javascript"></script>
    <script src="{$ABS_PATH}admin/codemirror/mode/xml/xml.js"></script>
    <script src="{$ABS_PATH}admin/codemirror/mode/javascript/javascript.js"></script>
    <script src="{$ABS_PATH}admin/codemirror/mode/css/css.js"></script>
    <script src="{$ABS_PATH}admin/codemirror/mode/clike/clike.js"></script>
    <script src="{$ABS_PATH}admin/codemirror/mode/php/php.js"></script>

{literal}
    <style type="text/css">
      .activeline {background: #e8f2ff !important;}
      .CodeMirror-scroll {height: 300px;}
    </style>
{/literal}

<script language="Javascript" type="text/javascript">
$(document).ready(function(){ldelim}
	$('form').hide();
	$('tr.tpls').hide();
	$('#kform').show();
{rdelim});
</script>

<div id="pageHeaderTitle" style="padding-top:7px;">
	<div class="h_rubs">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#RUBRIK_EDIT_FIELDS#}<span style="color:#000;"> &gt; {$rubric->rubric_title}</span></h2>
	</div>
	{if !$rub_fields}
		<div class="HeaderText">{#RUBRIK_NO_FIELDS#}</div>
	{else}
		<div class="HeaderText">{#RUBRIK_FIELDS_INFO#}</div>
	{/if}
</div>
<div class="upPage">&nbsp;</div><br />

{if $rub_fields}
<table cellspacing="1" cellpadding="8" border="0" width="100%">
	<tr>
		<td class="second">
			<div id="otherLinks">
				<a href="javascript:void(0);" onclick="$('#kform').toggle();">
					<div class="taskTitle">{#RUBRIK_FIELDS_TITLE#}</div>
				</a>
			</div>
		</td>
	</tr>
</table>

<form id="kform" name="kform" action="index.php?do=rubs&amp;action=edit&amp;Id={$smarty.request.Id|escape}&amp;cp={$sess}" method="post">
	{assign var=js_form value='kform'}
	<table width="100%" border="0" cellspacing="1" cellpadding="7" class="tableborder">
		<col width="20">
		<col width="100">
		<col width="220">
		<col width="220">
		<col>
		<col width="72">
		<col width="20">
		<tr class="tableheader">
			<td align="center"><input name="allbox" type="checkbox" id="d" onclick="selall();" value="" /></td>
			<td>{#RUBRIK_ID#}</td>
			<td>{#RUBRIK_FIELD_NAME#}</td>
			<td>{#RUBRIK_FIELD_TYPE#}</td>
			<td>{#RUBRIK_FIELD_DEFAULT#}</td>
			<td>{#RUBRIK_POSITION#}</td>
			<td align="center">
				<a title="{#RUBRIK_TEMPLATE_HIDE#}" href="javascript:void(0);" onclick="$('tr.tpls').hide();">
					<img src="{$tpl_dir}/images/icon_template.gif" alt="" border="0" />
				</a>
			</td>
		</tr>

		{foreach from=$rub_fields item=rf}
			<tr style="background-color:#eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td align="center"><input title="{#RUBRIK_MARK_DELETE#}" name="del[{$rf->Id}]" type="checkbox" id="del[{$rf->Id}]" value="1" /></td>
				<td>[tag:fld:{$rf->Id}]</td>
				<td><input name="title[{$rf->Id}]" type="text" id="title[{$rf->Id}]" value="{$rf->rubric_field_title|escape}" style="width:100%;" /></td>
				<td>
					<select name="rubric_field_type[{$rf->Id}]" id="rubric_field_type[{$rf->Id}]" style="width:100%;">
						{section name=feld loop=$felder}
							<option value="{$felder[feld].id}" {if $rf->rubric_field_type==$felder[feld].id}selected{/if}>{$felder[feld].name}</option>
						{/section}
					</select>
				</td>
				<td><input name="rubric_field_default[{$rf->Id}]" type="text" id="rubric_field_default[{$rf->Id}]" value="{$rf->rubric_field_default}" style="width:100%;" /></td>
				<td>
					<input name="rubric_field_position[{$rf->Id}]" type="text" id="rubric_field_position[{$rf->Id}]" value="{$rf->rubric_field_position}" size="4" maxlength="5" />
				</td>
				<td align="center">
					<a title="{#RUBRIK_TEMPLATE_TOGGLE#}" href="javascript:void(0);" onclick="$('#tpl_{$rf->Id}').toggle();">
						<img src="{$tpl_dir}/images/icon_template.gif" alt="" border="0" />
					</a>
				</td>
			</tr>
			<tr id="tpl_{$rf->Id}" class="tpls">
				<td colspan="7" class="second">

				<div style="width:50%; float:left">
					<div class="tableheader" style="padding:6px">{#RUBRIK_FIELDS_TPL#}</div>
					<textarea wrap="off" style="width:100%; height:70px" name="rubric_field_template[{$rf->Id}]" id="rubric_field_template[{$rf->Id}]">{$rf->rubric_field_template|escape}</textarea>
					<div class="infobox">|&nbsp;
						<a title="{#RUBRIK_PARAMETR#}" href="javascript:void(0);" onclick="javascript:cp_insert('[tag:parametr:]', 'rubric_field_template[{$rf->Id}]', 'kform');">[tag:parametr:XXX]</a>&nbsp;|&nbsp;
						<a title="{#RUBRIK_PATH_INFO#}" href="javascript:void(0);" onclick="javascript:cp_insert('[tag:path]', 'rubric_field_template[{$rf->Id}]', 'kform');">[tag:path]</a>&nbsp;|&nbsp;
						<a title="{#RUBRIK_IF_EMPTY#}" href="javascript:void(0);" onclick="javascript:cp_tag('tag:if_empty', 'rubric_field_template[{$rf->Id}]', 'kform');">[tag:if_empty]&nbsp;[/tag:if_empty]</a>&nbsp;|&nbsp;
						<a title="{#RUBRIK_NOT_EMPTY#}" href="javascript:void(0);" onclick="javascript:cp_tag('tag:if_notempty', 'rubric_field_template[{$rf->Id}]', 'kform');">[tag:if_notempty]&nbsp;[/tag:if_notempty]</a>
						&nbsp;|
						<br />
						|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_insert('<div class=&quot;&quot; id=&quot;&quot;></div>', 'rubric_field_template[{$rf->Id}]', 'kform');">DIV</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_insert('<a href=&quot;&quot; title=&quot;&quot;></a>', 'rubric_field_template[{$rf->Id}]', 'kform');">A</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_insert('<img src=&quot;&quot; alt=&quot;&quot; />', 'rubric_field_template[{$rf->Id}]', 'kform');">IMG</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_insert('<p class=&quot;&quot;></p>', 'rubric_field_template[{$rf->Id}]', 'kform');">P</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_code('strong', 'rubric_field_template[{$rf->Id}]', 'kform');">B</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_code('em', 'rubric_field_template[{$rf->Id}]', 'kform');">I</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_code('h1', 'rubric_field_template[{$rf->Id}]', 'kform');">H1</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_code('h2', 'rubric_field_template[{$rf->Id}]', 'kform');">H2</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_code('h3', 'rubric_field_template[{$rf->Id}]', 'kform');">H3</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_code('h4', 'rubric_field_template[{$rf->Id}]', 'kform');">H4</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_code('h5', 'rubric_field_template[{$rf->Id}]', 'kform');">H5</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_code('h6', 'rubric_field_template[{$rf->Id}]', 'kform');">H6</a>&nbsp;|&nbsp;						
						<a href="javascript:void(0);" onclick="javascript:cp_code('pre', 'rubric_field_template[{$rf->Id}]', 'kform');">PRE</a>&nbsp;|&nbsp;						
						<a href="javascript:void(0);" onclick="javascript:cp_code('span', 'rubric_field_template[{$rf->Id}]', 'kform');">SPAN</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_insert('<br />', 'rubric_field_template[{$rf->Id}]', 'kform');">BR</a>&nbsp;|
					</div>
				</div>
				<div style="width:50%; float:left">
					<div class="tableheader" style="padding:6px">{#RUBRIK_REQUEST_TPL#}</div>
					<textarea wrap="off" style="width:100%; height:70px" name="rubric_field_template_request[{$rf->Id}]" id="rubric_field_template_request[{$rf->Id}]">{$rf->rubric_field_template_request|escape}</textarea>
					<div class="infobox">|&nbsp;
						<a title="{#RUBRIK_PARAMETR#}" href="javascript:void(0);" onclick="javascript:cp_insert('[tag:parametr:]', 'rubric_field_template_request[{$rf->Id}]', 'kform');">[tag:parametr:XXX]</a>&nbsp;|&nbsp;
						<a title="{#RUBRIK_PATH_INFO#}" href="javascript:void(0);" onclick="javascript:cp_insert('[tag:path]', 'rubric_field_template_request[{$rf->Id}]', 'kform');">[tag:path]</a>&nbsp;|&nbsp;
						<a title="{#RUBRIK_IF_EMPTY#}" href="javascript:void(0);" onclick="javascript:cp_tag('tag:if_empty', 'rubric_field_template_request[{$rf->Id}]', 'kform');">[tag:if_empty]&nbsp;[/tag:if_empty]</a>&nbsp;|&nbsp;
						<a title="{#RUBRIK_NOT_EMPTY#}" href="javascript:void(0);" onclick="javascript:cp_tag('tag:if_notempty', 'rubric_field_template_request[{$rf->Id}]', 'kform');">[tag:if_notempty]&nbsp;[/tag:if_notempty]</a>
						&nbsp;|
						<br />
						|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_code('div', 'rubric_field_template_request[{$rf->Id}]', 'kform');">DIV</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_insert('<a href=&quot;&quot; title=&quot;&quot;></a>', 'rubric_field_template_request[{$rf->Id}]', 'kform');">A</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_insert('<img src=&quot;&quot; alt=&quot;&quot; />', 'rubric_field_template_request[{$rf->Id}]', 'kform');">IMG</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_insert('<p class=&quot;&quot;></p>', 'rubric_field_template_request[{$rf->Id}]', 'kform');">P</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_code('strong', 'rubric_field_template_request[{$rf->Id}]', 'kform');">B</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_code('em', 'rubric_field_template_request[{$rf->Id}]', 'kform');">I</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_code('h1', 'rubric_field_template_request[{$rf->Id}]', 'kform');">H1</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_code('h2', 'rubric_field_template_request[{$rf->Id}]', 'kform');">H2</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_code('h3', 'rubric_field_template_request[{$rf->Id}]', 'kform');">H3</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_code('h4', 'rubric_field_template_request[{$rf->Id}]', 'kform');">H4</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_code('h5', 'rubric_field_template_request[{$rf->Id}]', 'kform');">H5</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_code('h6', 'rubric_field_template_request[{$rf->Id}]', 'kform');">H6</a>&nbsp;|&nbsp;						
						<a href="javascript:void(0);" onclick="javascript:cp_code('pre', 'rubric_field_template_request[{$rf->Id}]', 'kform');">PRE</a>&nbsp;|&nbsp;						
						<a href="javascript:void(0);" onclick="javascript:cp_code('span', 'rubric_field_template_request[{$rf->Id}]', 'kform');">SPAN</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="javascript:cp_insert('<br />', 'rubric_field_template_request[{$rf->Id}]', 'kform');">BR</a>&nbsp;|
					</div>
				</div>
				</td>
			</tr>
		{/foreach}
		<tr>
			<td colspan="7" class="third">
				<input type="hidden" name="submit" value="" id="nf_save_next" />
				<input type="submit" class="button" value="{#RUBRIK_BUTTON_SAVE#}" onclick="document.getElementById('nf_save_next').value='save'" />&nbsp;
				<input type="submit" class="button" value="{#RUBRIK_BUTTON_TEMPL#}" onclick="document.getElementById('nf_save_next').value='next'" /><br />
			</td>
		</tr>
	</table>
</form><br />
<br />
{/if}


<table cellspacing="1" cellpadding="8" border="0" width="100%">
	<tr>
		<td class="second">
			<div id="otherLinks">
				<a href="javascript:void(0);" onclick="$('#coder').toggle();">
					<div class="taskTitle">{#RUBRIK_CODE#}</div>
				</a>
			</div>
		</td>
	</tr>
</table>

<form id="coder" action="index.php?do=rubs&amp;action=edit&amp;Id={$smarty.request.Id|escape}&amp;cp={$sess}" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="7" class="tableborder">
		<col class="second">
		<col class="second">
		<tr class="tableheader">
			<td>{#RUBRIK_CODE_START#}</td>
			<td>{#RUBRIK_CODE_END#}</td>
		</tr>

		<tr>
			<td>
				<div class="coder_in">
				<textarea name="rubric_code_start" type="text" id="code_start" value="" style="width:99%;height:300px;" />{$rubric->rubric_code_start}</textarea>
				</div>
			</td>

			<td>
				<div class="coder_in">
				<textarea name="rubric_code_end" type="text" id="code_end" value="" style="width:99%;height:300px;" />{$rubric->rubric_code_end}</textarea>
				</div>
			</td>
		</tr>

		<tr>
			<td colspan="2" class="third">
				<input type="hidden" name="submit" value="code" id="code" />
				<input class="button" type="submit" value="{#RUBRIK_BUTTON_SAVE#}" /><br />
			</td>
		</tr>
	</table>
</form><br />
<br />


<table cellspacing="1" cellpadding="8" border="0" width="100%">
	<tr>
		<td class="second">
			<div id="otherLinks">
				<a href="javascript:void(0);" onclick="$('#newfld').toggle();">
					<div class="taskTitle">{#RUBRIK_NEW_FIELD#}</div>
				</a>
			</div>
		</td>
	</tr>
</table>

<form id="newfld" action="index.php?do=rubs&amp;action=edit&amp;Id={$smarty.request.Id|escape}&amp;cp={$sess}" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="7" class="tableborder">
		<col width="356" class="second">
		<col width="220" class="second">
		<col class="second">
		<col width="100" class="second">
		<tr class="tableheader">
			<td>{#RUBRIK_FIELD_NAME#}</td>
			<td>{#RUBRIK_FIELD_TYPE#}</td>
			<td>{#RUBRIK_FIELD_DEFAULT#}</td>
			<td>{#RUBRIK_POSITION#}</td>
		</tr>

		<tr>
			<td>
				<input name="TitelNew" type="text" id="TitelNew" value="" style="width:100%;" />
			</td>

			<td>
				<select name="RubTypNew" id="RubTypNew" style="width:100%;">
					{section name=feld loop=$felder}
						<option value="{$felder[feld].id}">{$felder[feld].name}</option>
					{/section}
				</select>
			</td>

			<td>
				<input name="StdWertNew" type="text" id="StdWertNew" value="" style="width:100%;" />
			</td>

			<td>
				<input name="rubric_field_position_new" type="text" id="rubric_field_position_new" value="10" size="4" maxlength="5" />
			</td>
		</tr>

		<tr>
			<td colspan="4" class="third">
				<input type="hidden" name="submit" value="" id="nf_hidd" />
				<input class="button" type="submit" value="{#RUBRIK_BUTTON_ADD#}" onclick="document.getElementById('nf_hidd').value='newfield'" /><br />
			</td>
		</tr>
	</table>
</form><br />
<br />

{if check_permission('rubric_perms')}
<table cellspacing="1" cellpadding="8" border="0" width="100%">
	<tr>
		<td class="second">
			<div id="otherLinks">
				<a href="javascript:void(0);" onclick="$('#rubperm').toggle();">
					<div class="taskTitle">{#RUBRIK_SET_PERMISSION#}</div>
				</a>
			</div>
		</td>
	</tr>
</table>

<form id="rubperm" action="index.php?do=rubs&amp;action=edit&amp;Id={$smarty.request.Id|escape}&amp;cp={$sess}" method="post">
	<table width="100%" border="0" cellspacing="1" cellpadding="7" class="tableborder">
		<col width="10%" class="second">
		<col width="15%" class="first">
		<col width="15%" class="second">
		<col width="15%" class="first">
		<col width="15%" class="second">
		<col width="15%" class="first">
		<col width="15%" class="second">
		<tr class="tableheader">
			<td>{#RUBRIK_USER_GROUP#}</td>
			<td align="center">{#RUBRIK_DOC_READ#}</td>
			<td align="center">{#RUBRIK_ALL_PERMISSION#}</td>
			<td align="center">{#RUBRIK_CREATE_DOC#}</td>
			<td align="center">{#RUBRIK_CREATE_DOC_NOW#}</td>
			<td align="center">{#RUBRIK_EDIT_OWN#}</td>
			<td align="center">{#RUBRIK_EDIT_OTHER#}</td>
		</tr>

		{foreach from=$groups item=group}
			{assign var=doall value=$group->doall}
			<tr>
				<td>
					<strong>{$group->user_group_name|escape:html}</strong>
				</td>

				<td align="center">
					{if $group->doall_h==1}
						<input type="hidden" name="perm[{$group->user_group}][]" value="docread" />
						<input title="{#RUBRIK_VIEW_TIP#}" name="perm[{$group->user_group}][]" type="checkbox" value="docread" checked="checked" disabled="disabled" />
					{else}
						<input title="{#RUBRIK_VIEW_TIP#}" name="perm[{$group->user_group}][]" type="checkbox" value="docread"{if in_array('docread', $group->permissions) || in_array('alles', $group->permissions)} checked="checked"{/if} />
					{/if}
				</td>

				<td align="center">
					{if $group->doall_h==1}
						<input type="hidden" name="perm[{$group->user_group}][]" value="alles" />
						<input title="{#RUBRIK_ALL_TIP#}" name="perm[{$group->user_group}][]" type="checkbox" value="alles" checked="checked" disabled="disabled" />
					{else}
						<input title="{#RUBRIK_ALL_TIP#}" name="perm[{$group->user_group}][]" type="checkbox" value="alles"{if in_array('alles', $group->permissions)} checked="checked"{/if}{if $group->user_group==2} disabled="disabled"{/if} />
					{/if}
				</td>

				<td align="center">
					<input type="hidden" name="user_group[{$group->user_group}]" value="{$group->user_group}" />
					{if $group->doall_h==1}
						<input name="{$group->user_group}" type="checkbox" value="1"{$doall} />
						<input title="{#RUBRIK_DOC_TIP#}" type="hidden" name="perm[{$group->user_group}][]" value="new" />
					{else}
						<input title="{#RUBRIK_DOC_TIP#}" onclick="document.getElementById('newnow_{$group->user_group}').checked = '';" id="new_{$group->user_group}" name="perm[{$group->user_group}][]" type="checkbox" value="new"{if in_array('new', $group->permissions) || in_array('alles', $group->permissions)} checked="checked"{/if}{if $group->user_group==2} disabled="disabled"{/if} />
					{/if}
				</td>

				<td align="center">
					<input type="hidden" name="user_group[{$group->user_group}]" value="{$group->user_group}" />
					{if $group->doall_h==1}
						<input name="{$group->user_group}" type="checkbox" value="1"{$doall} />
						<input title="{#RUBRIK_DOC_NOW_TIP#}" type="hidden" name="perm[{$group->user_group}][]" value="newnow" />
					{else}
						<input title="{#RUBRIK_DOC_NOW_TIP#}" onclick="document.getElementById('new_{$group->user_group}').checked = '';" id="newnow_{$group->user_group}" name="perm[{$group->user_group}][]" type="checkbox" value="newnow"{if in_array('newnow', $group->permissions) || in_array('alles', $group->permissions)} checked="checked"{/if}{if $group->user_group==2} disabled="disabled"{/if} />
					{/if}
				</td>

				<td align="center">
					{if $group->doall_h==1}
						<input name="{$group->user_group}" type="checkbox" value="1"{$doall} />
						<input title="{#RUBRIK_OWN_TIP#}" type="hidden" name="perm[{$group->user_group}][]" value="editown" />
					{else}
						<input title="{#RUBRIK_OWN_TIP#}" id="editown_{$group->user_group}" name="perm[{$group->user_group}][]" type="checkbox" value="editown"{if in_array('editown', $group->permissions) || in_array('alles', $group->permissions)} checked="checked"{/if}{if $group->user_group==2} disabled="disabled"{/if} />
					{/if}
				</td>

				<td align="center">
					{if $group->doall_h==1}
						<input title="{#RUBRIK_OTHER_TIP#}" name="{$group->user_group}" type="checkbox" value="1"{$doall} />
					{else}
						<input title="{#RUBRIK_OTHER_TIP#}" name="perm[{$group->user_group}][]" type="checkbox" value="editall"{if in_array('editall', $group->permissions) || in_array('alles', $group->permissions)} checked="checked"{/if}{if $group->user_group==2} disabled="disabled"{/if} />
					{/if}
				</td>
			</tr>
		{/foreach}
		<tr>
			<td colspan="7" class="third">
				<input type="hidden" name="submit" value="" id="nf_sub" />
				<input type="submit" class="button" value="{#RUBRIK_BUTTON_PERM#}" onclick="document.getElementById('nf_sub').value='saveperms'" />
			</td>
		</tr>
	</table>
</form><br />
<br />
{/if}

    <script language="Javascript" type="text/javascript">
{literal}
      var editor = CodeMirror.fromTextArea(document.getElementById("code_start"), {
        lineNumbers: true,
		lineWrapping: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 4,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        onChange: function(){editor.save();},
		onCursorActivity: function() {
		  editor.setLineClass(hlLine, null, null);
		  hlLine = editor.setLineClass(editor.getCursor().line, null, "activeline");
		}
      });

      function getSelectedRange() {
        return { from: editor.getCursor(true), to: editor.getCursor(false) };
      }

      function textSelection(startTag,endTag) {
        var range = getSelectedRange();
        editor.replaceRange(startTag + editor.getRange(range.from, range.to) + endTag, range.from, range.to)
        editor.setCursor(range.from.line, range.from.ch + startTag.length);
      }

	  var hlLine = editor.setLineClass(0, "activeline");

      var editor2 = CodeMirror.fromTextArea(document.getElementById("code_end"), {
        lineNumbers: true,
		lineWrapping: true,
        matchBrackets: true,
        mode: "application/x-httpd-php",
        indentUnit: 4,
        indentWithTabs: true,
        enterMode: "keep",
        tabMode: "shift",
        onChange: function(){editor2.save();},
		onCursorActivity: function() {
		  editor2.setLineClass(hlLine, null, null);
		  hlLine = editor2.setLineClass(editor2.getCursor().line, null, "activeline");
		}
      });

      function getSelectedRange2() {
        return { from: editor2.getCursor(true), to: editor2.getCursor(false) };
      }

      function textSelection2(startTag,endTag) {
        var range = getSelectedRange2();
        editor2.replaceRange(startTag + editor2.getRange(range.from, range.to) + endTag, range.from, range.to)
        editor2.setCursor(range.from.line, range.from.ch + startTag.length);
      }

      var hlLine = editor2.setLineClass(0, "activeline");
{/literal}
    </script>