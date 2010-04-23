
<!-- rub_fields.tpl -->
{strip}

<script language="Javascript" type="text/javascript" src="editarea/edit_area_full.js"></script>

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
		<h2>{#RUBRIK_EDIT_FIELDS#}<span style="color:#000;"> &gt; {$RubrikName}</span></h2>
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
					<div class="taskTitle">Поля рубрики</div>
				</a>
			</div>
		</td>
	</tr>
</table>

<form id="kform" name="kform" action="index.php?do=rubs&amp;action=edit&amp;Id={$smarty.request.Id}&amp;cp={$sess}" method="post">
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
				<td>[cprub:{$rf->Id}]</td>
				<td><input name="Titel[{$rf->Id}]" type="text" id="Titel[{$rf->Id}]" value="{$rf->Titel|escape:html}" style="width:100%;" /></td>
				<td>
					<select name="RubTyp[{$rf->Id}]" id="RubTyp[{$rf->Id}]" style="width:100%;">
						{section name=feld loop=$felder}
							<option value="{$felder[feld].id}" {if $rf->RubTyp==$felder[feld].id}selected{/if}>{$felder[feld].name}</option>
						{/section}
					</select>
				</td>
				<td><input name="StdWert[{$rf->Id}]" type="text" id="StdWert[{$rf->Id}]" value="{$rf->StdWert}" style="width:100%;" /></td>
				<td>
					<input name="RubPosition[{$rf->Id}]" type="text" id="RubPosition[{$rf->Id}]" value="{$rf->rubric_position}" size="4" maxlength="5" />
				</td>
				<td align="center">
					<a title="{#RUBRIK_TEMPLATE_TOGGLE#}" href="javascript:void(0);" onclick="$('#tpl_{$rf->Id}').toggle();">
						<img src="{$tpl_dir}/images/icon_template.gif" alt="" border="0" />
					</a>
				</td>
			</tr>
			<tr id="tpl_{$rf->Id}" class="tpls">
				<td colspan="7" class="second">
				<script language="Javascript" type="text/javascript">
				editAreaLoader.init({ldelim}id: "tpl_field[{$rf->Id}]",allow_toggle: false,display: "later"{rdelim});
				editAreaLoader.init({ldelim}id: "tpl_req[{$rf->Id}]",allow_toggle: false,display: "later"{rdelim});
				</script>
				<div style="width:50%; float:left">
					<div class="tableheader" style="padding:6px">Шаблон вывода поля в документе</div>
					<textarea wrap="off" style="width:100%; height:70px" name="tpl_field[{$rf->Id}]" id="tpl_field[{$rf->Id}]">{$rf->tpl_field|default:''|escape:html}</textarea>
					<div class="infobox">|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_field[{$rf->Id}]', '<div>', '</div>');">DIV</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_field[{$rf->Id}]', '<p>', '</p>');">P</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_field[{$rf->Id}]', '<strong>', '</strong>');">B</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_field[{$rf->Id}]', '<em>', '</em>');">I</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_field[{$rf->Id}]', '<h1>', '</h1>');">H1</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_field[{$rf->Id}]', '<h2>', '</h2>');">H2</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_field[{$rf->Id}]', '<h3>', '</h3>');">H3</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_field[{$rf->Id}]', '<pre>', '</pre>');">PRE</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_field[{$rf->Id}]', '<br />', '');">BR</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_field[{$rf->Id}]', '<br />', '');">BR</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_field[{$rf->Id}]', '[field_param:', ']');">[field_param:XXX]</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_field[{$rf->Id}]', '[cp:path]', '');">[cp:path]</a>&nbsp;|
					</div>
				</div>
				<div style="width:50%; float:left">
					<div class="tableheader" style="padding:6px">Шаблон вывода поля в запросе</div>
					<textarea wrap="off" style="width:100%; height:70px" name="tpl_req[{$rf->Id}]" id="tpl_req[{$rf->Id}]">{$rf->tpl_req|default:''|escape:html}</textarea>
					<div class="infobox">|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_req[{$rf->Id}]', '<div>', '</div>');">DIV</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_req[{$rf->Id}]', '<p>', '</p>');">P</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_req[{$rf->Id}]', '<strong>', '</strong>');">B</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_req[{$rf->Id}]', '<em>', '</em>');">I</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_req[{$rf->Id}]', '<h1>', '</h1>');">H1</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_req[{$rf->Id}]', '<h2>', '</h2>');">H2</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_req[{$rf->Id}]', '<h3>', '</h3>');">H3</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_req[{$rf->Id}]', '<pre>', '</pre>');">PRE</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_req[{$rf->Id}]', '[field_param:', ']');">[field_param:XXX]</a>&nbsp;|&nbsp;
						<a href="javascript:void(0);" onclick="editAreaLoader.insertTags('tpl_req[{$rf->Id}]', '[cp:path]', '');">[cp:path]</a>&nbsp;|
					</div>
				</div>
				</td>
			</tr>
		{/foreach}
	</table><br />

	<input type="hidden" name="submit" value="" id="nf_save_next" />
	<input type="submit" class="button" value="{#RUBRIK_BUTTON_SAVE#}" onclick="document.getElementById('nf_save_next').value='save'" />&nbsp;
	<input type="submit" class="button" value="{#RUBRIK_BUTTON_TEMPL#}" onclick="document.getElementById('nf_save_next').value='next'" /><br />
	<br />
</form>
{/if}

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

<form id="newfld" action="index.php?do=rubs&amp;action=edit&amp;Id={$smarty.request.Id}&amp;cp={$sess}" method="post">
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
				<input name="RubPositionNew" type="text" id="RubPositionNew" value="10" size="4" maxlength="5" />
			</td>
		</tr>
	</table><br />

	<input type="hidden" name="submit" value="" id="nf_hidd" />
	<input class="button" type="submit" value="{#RUBRIK_BUTTON_ADD#}" onclick="document.getElementById('nf_hidd').value='newfield'" /><br />
	<br />
</form>

{if checkPermission('rub_perms')}
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

<form id="rubperm" action="index.php?do=rubs&amp;action=edit&amp;Id={$smarty.request.Id}&amp;cp={$sess}" method="post">
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
					<strong>{$group->Name|escape:html}</strong>
				</td>

				<td align="center">
					{if $group->doall_h==1}
						<input type="hidden" name="perm[{$group->Benutzergruppe}][]" value="docread" />
						<input title="{#RUBRIK_VIEW_TIP#}" name="perm[{$group->Benutzergruppe}][]" type="checkbox" value="docread" checked="checked" disabled="disabled" />
					{else}
						<input title="{#RUBRIK_VIEW_TIP#}" name="perm[{$group->Benutzergruppe}][]" type="checkbox" value="docread"{if in_array('docread', $group->permissions) || in_array('alles', $group->permissions)} checked="checked"{/if} />
					{/if}
				</td>

				<td align="center">
					{if $group->doall_h==1}
						<input type="hidden" name="perm[{$group->Benutzergruppe}][]" value="alles" />
						<input title="{#RUBRIK_ALL_TIP#}" name="perm[{$group->Benutzergruppe}][]" type="checkbox" value="alles" checked="checked" disabled="disabled" />
					{else}
						<input title="{#RUBRIK_ALL_TIP#}" name="perm[{$group->Benutzergruppe}][]" type="checkbox" value="alles"{if in_array('alles', $group->permissions)} checked="checked"{/if}{if $group->Benutzergruppe==2} disabled="disabled"{/if} />
					{/if}
				</td>

				<td align="center">
					<input type="hidden" name="Benutzergruppe[{$group->Benutzergruppe}]" value="{$group->Benutzergruppe}" />
					{if $group->doall_h==1}
						<input name="{$group->Benutzergruppe}" type="checkbox" value="1"{$doall} />
						<input title="{#RUBRIK_DOC_TIP#}" type="hidden" name="perm[{$group->Benutzergruppe}][]" value="new" />
					{else}
						<input title="{#RUBRIK_DOC_TIP#}" onclick="document.getElementById('newnow_{$group->Benutzergruppe}').checked = '';" id="new_{$group->Benutzergruppe}" name="perm[{$group->Benutzergruppe}][]" type="checkbox" value="new"{if in_array('new', $group->permissions) || in_array('alles', $group->permissions)} checked="checked"{/if}{if $group->Benutzergruppe==2} disabled="disabled"{/if} />
					{/if}
				</td>

				<td align="center">
					<input type="hidden" name="Benutzergruppe[{$group->Benutzergruppe}]" value="{$group->Benutzergruppe}" />
					{if $group->doall_h==1}
						<input name="{$group->Benutzergruppe}" type="checkbox" value="1"{$doall} />
						<input title="{#RUBRIK_DOC_NOW_TIP#}" type="hidden" name="perm[{$group->Benutzergruppe}][]" value="newnow" />
					{else}
						<input title="{#RUBRIK_DOC_NOW_TIP#}" onclick="document.getElementById('new_{$group->Benutzergruppe}').checked = '';" id="newnow_{$group->Benutzergruppe}" name="perm[{$group->Benutzergruppe}][]" type="checkbox" value="newnow"{if in_array('newnow', $group->permissions) || in_array('alles', $group->permissions)} checked="checked"{/if}{if $group->Benutzergruppe==2} disabled="disabled"{/if} />
					{/if}
				</td>

				<td align="center">
					{if $group->doall_h==1}
						<input name="{$group->Benutzergruppe}" type="checkbox" value="1"{$doall} />
						<input title="{#RUBRIK_OWN_TIP#}" type="hidden" name="perm[{$group->Benutzergruppe}][]" value="editown" />
					{else}
						<input title="{#RUBRIK_OWN_TIP#}" id="editown_{$group->Benutzergruppe}" name="perm[{$group->Benutzergruppe}][]" type="checkbox" value="editown"{if in_array('editown', $group->permissions) || in_array('alles', $group->permissions)} checked="checked"{/if}{if $group->Benutzergruppe==2} disabled="disabled"{/if} />
					{/if}
				</td>

				<td align="center">
					{if $group->doall_h==1}
						<input title="{#RUBRIK_OTHER_TIP#}" name="{$group->Benutzergruppe}" type="checkbox" value="1"{$doall} />
					{else}
						<input title="{#RUBRIK_OTHER_TIP#}" name="perm[{$group->Benutzergruppe}][]" type="checkbox" value="editall"{if in_array('editall', $group->permissions) || in_array('alles', $group->permissions)} checked="checked"{/if}{if $group->Benutzergruppe==2} disabled="disabled"{/if} />
					{/if}
				</td>
			</tr>
		{/foreach}
	</table><br />

	<input type="hidden" name="submit" value="" id="nf_sub" />
	<input type="submit" class="button" value="{#RUBRIK_BUTTON_PERM#}" onclick="document.getElementById('nf_sub').value='saveperms'" />

</form>
{/if}

{/strip}
<!-- /rub_fields.tpl -->
