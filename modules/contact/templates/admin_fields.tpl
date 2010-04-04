<script type="text/javascript" language="JavaScript">
function check_name() {ldelim}
	if (document.getElementById('field_title').value == '') {ldelim}
		alert("{#CONTACT_ENTER_NAME#}");
		document.getElementById('field_title').focus();
		return false;
	{rdelim}
	return true;
{rdelim}
</script>
{strip}

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{if $smarty.request.moduleaction=='new'}{#CONTACT_CREATE_FORM2#}{else}{#CONTACT_FORM_FIELDS#}{/if}</h2></div>
	<div class="HeaderText">{#CONTACT_FIELD_INFO#}</div>
</div><br />

<form method="post" action="{$formaction}">
	{include file="$tpl_path/admin_formsettings.tpl"}<br />

	{if $smarty.request.id != ''}
		<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
			<tr class="tableheader">
				<td width="1%" rowspan="2" align="center"><img src="{$tpl_dir}/images/icon_del.gif" alt="" /></td>
				<td style="width:194px;" align="center">{#CONTACT_FILED_NAME#}</td>
				<td style="width:162px;" align="center">{#CONTACT_FIELD_TYPE#}</td>
				<td style="width:50px;" align="center">{#CONTACT_FIELD_POSITION#}</td>
				<td style="width:50px;" align="center">{#CONTACT_FIELD_SIZE#}</td>
				<td style="width:95px;" align="center">{#CONTACT_DATA_TYPE#}</td>
				<td style="width:45px;" align="center">{#CONTACT_MAX_CHARS#}</td>
				<td style="width:90px;" align="center">{#CONTACT_REQUIRED_FIELD#}</td>
				<td rowspan="2">{#CONTACT_FIELD_ACTIVE#}</td>
			</tr>
			<tr class="tableheader">
				<td colspan="2" align="center">{#CONTACT_DEFAULT_VALUE#}</td>
				<td colspan="2" align="center">{#CONTACT_NEW_LINE#}</td>
				<td colspan="3" align="center">{#CONTACT_REG_STRING#}</td>
			</tr>

			{foreach from=$items item=item}
				<tr style="background-color:#eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
					<td><input title="{#CONTACT_MARK_DELETE#}" name="del[{$item->Id}]" type="checkbox" id="del[{$item->Id}]" value="1" /></td>
					<td colspan="2">
						<input style="width:200px;" name="field_title[{$item->Id}]" type="text" id="field_title[{$item->Id}]" value="{$item->field_title|escape:html|stripslashes}" />&nbsp;
						<select style="width:168px;" name="field_type[{$item->Id}]" id="field_type[{$item->Id}]">
							<option value="text"{if $item->field_type == 'text'} selected{/if}>{#CONTACT_TEXT_FILED#}</option>
							<option value="textfield"{if $item->field_type == 'textfield'} selected{/if}>{#CONTACT_MULTI_FIELD#}</option>
							<option value="checkbox"{if $item->field_type == 'checkbox'} selected{/if}>{#CONTACT_CHECKBOX_FIELD#}</option>
							<option value="dropdown"{if $item->field_type == 'dropdown'} selected{/if}>{#CONTACT_DROPDOWN_FIELD#}</option>
							<option value="fileupload"{if $item->field_type == 'fileupload'} selected{/if}>{#CONTACT_UPLOAD_FIELD#}</option>
						</select><br />
						<input style="width:373px;" type="text" name="field_default[{$item->Id}]" value="{$item->field_default|escape:html|stripslashes}"{if $item->field_type == 'fileupload'} disabled{/if} />
					</td>
					<td colspan="2" align="center">
						<input style="width:56px;" type="text" name="field_position[{$item->Id}]" id="field_position[{$item->Id}]" size="5" maxlength="3" value="{$item->field_position}" />&nbsp;
						<input style="width:56px;" type="text" name="field_size[{$item->Id}]" id="field_size[{$item->Id}]" size="5" maxlength="4" value="{$item->field_size}" /><br />
						<input type="radio" name="field_newline[{$item->Id}]" value="1"{if $item->field_newline==1} checked{/if} />{#CONTACT_YES#} <input type="radio" name="field_newline[{$item->Id}]" value="0"{if $item->field_newline!=1} checked{/if} />{#CONTACT_NO#}
					</td>
					<td colspan="3">
						<select style="width:100px;" name="field_datatype[{$item->Id}]" id="field_datatype[{$item->Id}]"{if $item->field_type != 'textfield' && $item->field_type != 'text'} disabled{/if}>
							<option value="anysymbol"{if $item->field_datatype == 'anysymbol'} selected{/if}>{#CONTACT_ANY_SYMBOL#}</option>
							<option value="onlydecimal"{if $item->field_datatype == 'onlydecimal'} selected{/if}>{#CONTACT_ONLY_DECIMAL#}</option>
							<option value="onlychars"{if $item->field_datatype == 'onlychars'} selected{/if}>{#CONTACT_ONLY_CHARS#}</option>
						</select>&nbsp;
						<input style="width:62px;" type="text" name="field_maxchars[{$item->Id}]" id="field_maxchars[{$item->Id}]" size="5" maxlength="20" value="{$item->field_maxchars}"{if $item->field_type != 'textfield' && $item->field_type != 'text'} disabled{/if} />&nbsp;
						<input type="radio" name="field_required[{$item->Id}]" value="1"{if $item->field_required==1} checked{/if} />{#CONTACT_YES#} <input type="radio" name="field_required[{$item->Id}]" value="0"{if $item->field_required!=1} checked{/if} />{#CONTACT_NO#}<br />
						<input style="width:264px;" type="text" name="field_message[{$item->Id}]" value="{$item->field_message|escape:html|stripslashes}"{if $item->field_type != 'textfield' && $item->field_type != 'text' && $item->field_required != 1} disabled{/if} />
					</td>
					<td><input type="radio" name="field_status[{$item->Id}]" value="1"{if $item->field_status==1} checked{/if} />{#CONTACT_YES#} <input type="radio" name="field_status[{$item->Id}]" value="0"{if $item->field_status!=1} checked{/if} />{#CONTACT_NO#}</td>
				</tr>
			{/foreach}
		</table><br />
	{/if}

	<input type="submit" class="button" value="{#CONTACT_BUTTON_SAVE#}" />
</form><br />
<br />

{if $smarty.request.id != ''}
	<h4>{#CONTACT_NEW_FILED_ADD#}</h4>

	<form method="post" action="index.php?do=modules&action=modedit&mod=contact&moduleaction=save_new&cp={$sess}&id={$smarty.request.id}&pop=1" name="new" onSubmit='return check_name()'>
		<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
			<tr class="tableheader">
				<td width="20" rowspan="2" align="center">&nbsp;</td>
				<td style="width:194px;" align="center">{#CONTACT_FILED_NAME#}</td>
				<td style="width:162px;" align="center">{#CONTACT_FIELD_TYPE#}</td>
				<td style="width:50px;" align="center">{#CONTACT_FIELD_POSITION#}</td>
				<td style="width:50px;" align="center">{#CONTACT_FIELD_SIZE#}</td>
				<td style="width:95px;" align="center">{#CONTACT_DATA_TYPE#}</td>
				<td style="width:45px;" align="center">{#CONTACT_MAX_CHARS#}</td>
				<td style="width:90px;" align="center">{#CONTACT_REQUIRED_FIELD#}</td>
				<td rowspan="2">{#CONTACT_FIELD_ACTIVE#}</td>
			</tr>
			<tr class="tableheader">
				<td colspan="2" align="center">{#CONTACT_DEFAULT_VALUE#}</td>
				<td colspan="2" align="center">{#CONTACT_NEW_LINE#}</td>
				<td colspan="3" align="center">{#CONTACT_REG_STRING#}</td>
			</tr>

			<tr style="background-color:#eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td width="20">&nbsp;</td>
				<td colspan="2">
					<input style="width:200px" name="field_title" type="text" id="field_title" value="" />&nbsp;
					<select style="width:168px;" name="field_type" id="field_type">
						<option value="text">{#CONTACT_TEXT_FILED#}</option>
						<option value="textfield">{#CONTACT_MULTI_FIELD#}</option>
						<option value="checkbox">{#CONTACT_CHECKBOX_FIELD#}</option>
						<option value="dropdown">{#CONTACT_DROPDOWN_FIELD#}</option>
						<option value="fileupload">{#CONTACT_UPLOAD_FIELD#}</option>
					</select><br />
					<input style="width:373px;" type="text" name="field_default" id="field_default" value="" />
				</td>
				<td colspan="2" align="center">
					<input style="width:56px;" type="text" name="field_position" id="field_position" size="5" maxlength="3" value="1" />&nbsp;
					<input style="width:56px;" type="text" name="field_size" id="field_size" size="5" maxlength="4" value="300" /><br />
					<input type="radio" name="field_newline" value="1" checked="checked" />{#CONTACT_YES#} <input type="radio" name="field_newline" value="0" />{#CONTACT_NO#}
				</td>
				<td colspan="3">
					<select style="width:100px;" name="field_datatype" id="field_datatype">
						<option value="anysymbol" selected>{#CONTACT_ANY_SYMBOL#}</option>
						<option value="onlydecimal">{#CONTACT_ONLY_DECIMAL#}</option>
						<option value="onlychars">{#CONTACT_ONLY_CHARS#}</option>
					</select>&nbsp;
					<input style="width:62px;" type="text" name="field_maxchars" id="field_maxchars" size="5" maxlength="20" value="1,25" />&nbsp;
					<input type="radio" name="field_required" value="1" />{#CONTACT_YES#} <input type="radio" name="field_required" value="0" checked="checked" />{#CONTACT_NO#}<br />
					<input style="width:264px;" type="text" name="field_message" id="field_message" value="{#CONTACT_DEFAULT_MESSAGE#}" />
				</td>
				<td><input type="radio" name="field_status" value="1" checked="checked" />{#CONTACT_YES#} <input type="radio" name="field_status" value="0" />{#CONTACT_NO#}</td>
			</tr>
		</table><br />

		<input type="submit" class="button" value="{#CONTACT_BUTTON_ADD#}" />
	</form>
{/if}

{/strip}