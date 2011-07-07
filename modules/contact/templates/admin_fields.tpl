<script type="text/javascript" language="JavaScript">
function check_name() {ldelim}
	if (document.getElementById('contact_field_title').value == '') {ldelim}
		alert("{#CONTACT_ENTER_NAME#}");
		document.getElementById('contact_field_title').focus();
		return false;
	{rdelim}
	return true;
{rdelim}
</script>

<div class="pageHeaderTitle">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{if $smarty.request.moduleaction=='new'}{#CONTACT_CREATE_FORM2#}{else}{#CONTACT_FORM_FIELDS#}{/if}</h2></div>
	<div class="HeaderText">{#CONTACT_FIELD_INFO#}</div>
</div>
<div class="upPage">&nbsp;</div>

<form method="post" action="{$formaction}">
	{include file="$include_path/admin_formsettings.tpl"}<br />

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
					<td colspan="2" nowrap="nowrap">
						<input style="width:200px;" name="contact_field_title[{$item->Id}]" type="text" id="contact_field_title[{$item->Id}]" value="{$item->contact_field_title|escape|stripslashes}" />&nbsp;
						<select style="width:165px;" name="contact_field_type[{$item->Id}]" id="contact_field_type[{$item->Id}]">
							<option value="text"{if $item->contact_field_type == 'text'} selected{/if}>{#CONTACT_TEXT_FILED#}</option>
							<option value="textfield"{if $item->contact_field_type == 'textfield'} selected{/if}>{#CONTACT_MULTI_FIELD#}</option>
							<option value="checkbox"{if $item->contact_field_type == 'checkbox'} selected{/if}>{#CONTACT_CHECKBOX_FIELD#}</option>
							<option value="dropdown"{if $item->contact_field_type == 'dropdown'} selected{/if}>{#CONTACT_DROPDOWN_FIELD#}</option>
							<option value="fileupload"{if $item->contact_field_type == 'fileupload'} selected{/if}>{#CONTACT_UPLOAD_FIELD#}</option>
						</select><br />
						<input style="width:373px;" type="text" name="contact_field_default[{$item->Id}]" value="{$item->contact_field_default|escape|stripslashes}"{if $item->contact_field_type == 'fileupload'} disabled{/if} />
					</td>
					<td colspan="2" align="center" nowrap="nowrap">
						<input style="width:56px;" type="text" name="contact_field_position[{$item->Id}]" id="contact_field_position[{$item->Id}]" size="5" maxlength="3" value="{$item->contact_field_position}" />&nbsp;
						<input style="width:56px;" type="text" name="contact_field_size[{$item->Id}]" id="contact_field_size[{$item->Id}]" size="5" maxlength="4" value="{$item->contact_field_size}" /><br />
						<input type="radio" name="contact_field_newline[{$item->Id}]" value="1"{if $item->contact_field_newline==1} checked{/if} />{#CONTACT_YES#} <input type="radio" name="contact_field_newline[{$item->Id}]" value="0"{if $item->contact_field_newline!=1} checked{/if} />{#CONTACT_NO#}
					</td>
					<td colspan="3">
						<select style="width:100px;" name="contact_field_datatype[{$item->Id}]" id="contact_field_datatype[{$item->Id}]"{if $item->contact_field_type != 'textfield' && $item->contact_field_type != 'text'} disabled{/if}>
							<option value="anysymbol"{if $item->contact_field_datatype == 'anysymbol'} selected{/if}>{#CONTACT_ANY_SYMBOL#}</option>
							<option value="onlydecimal"{if $item->contact_field_datatype == 'onlydecimal'} selected{/if}>{#CONTACT_ONLY_DECIMAL#}</option>
							<option value="onlychars"{if $item->contact_field_datatype == 'onlychars'} selected{/if}>{#CONTACT_ONLY_CHARS#}</option>
						</select>&nbsp;
						<input style="width:62px;" type="text" name="contact_field_max_chars[{$item->Id}]" id="contact_field_max_chars[{$item->Id}]" size="5" maxlength="20" value="{$item->contact_field_max_chars}"{if $item->contact_field_type != 'textfield' && $item->contact_field_type != 'text'} disabled{/if} />&nbsp;
						<input type="radio" name="contact_field_required[{$item->Id}]" value="1"{if $item->contact_field_required==1} checked{/if} />{#CONTACT_YES#} <input type="radio" name="contact_field_required[{$item->Id}]" value="0"{if $item->contact_field_required!=1} checked{/if} />{#CONTACT_NO#}<br />
						<input style="width:264px;" type="text" name="contact_field_value[{$item->Id}]" value="{$item->contact_field_value|escape|stripslashes}"{if $item->contact_field_type != 'textfield' && $item->contact_field_type != 'text' && $item->contact_field_required != 1} disabled{/if} />
					</td>
					<td><input type="radio" name="contact_field_status[{$item->Id}]" value="1"{if $item->contact_field_status==1} checked{/if} />{#CONTACT_YES#} <input type="radio" name="contact_field_status[{$item->Id}]" value="0"{if $item->contact_field_status!=1} checked{/if} />{#CONTACT_NO#}</td>
				</tr>
			{/foreach}
		</table><br />
	{/if}

	<input type="submit" class="button" value="{#CONTACT_BUTTON_SAVE#}" />
</form><br />
<br />

{if $smarty.request.id != ''}
	<h4>{#CONTACT_NEW_FILED_ADD#}</h4>

	<form method="post" action="index.php?do=modules&action=modedit&mod=contact&moduleaction=save_new&cp={$sess}&id={$smarty.request.id|escape}&pop=1" name="new" onSubmit='return check_name()'>
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
				<td colspan="2" nowrap="nowrap">
					<input style="width:200px" name="contact_field_title" type="text" id="contact_field_title" value="" />&nbsp;
					<select style="width:165px;" name="contact_field_type" id="contact_field_type">
						<option value="text">{#CONTACT_TEXT_FILED#}</option>
						<option value="textfield">{#CONTACT_MULTI_FIELD#}</option>
						<option value="checkbox">{#CONTACT_CHECKBOX_FIELD#}</option>
						<option value="dropdown">{#CONTACT_DROPDOWN_FIELD#}</option>
						<option value="fileupload">{#CONTACT_UPLOAD_FIELD#}</option>
					</select><br />
					<input style="width:373px;" type="text" name="contact_field_default" id="contact_field_default" value="" />
				</td>
				<td colspan="2" align="center" nowrap="nowrap">
					<input style="width:56px;" type="text" name="contact_field_position" id="contact_field_position" size="5" maxlength="3" value="1" />&nbsp;
					<input style="width:56px;" type="text" name="contact_field_size" id="contact_field_size" size="5" maxlength="4" value="300" /><br />
					<input type="radio" name="contact_field_newline" value="1" checked="checked" />{#CONTACT_YES#} <input type="radio" name="contact_field_newline" value="0" />{#CONTACT_NO#}
				</td>
				<td colspan="3">
					<select style="width:100px;" name="contact_field_datatype" id="contact_field_datatype">
						<option value="anysymbol" selected>{#CONTACT_ANY_SYMBOL#}</option>
						<option value="onlydecimal">{#CONTACT_ONLY_DECIMAL#}</option>
						<option value="onlychars">{#CONTACT_ONLY_CHARS#}</option>
					</select>&nbsp;
					<input style="width:62px;" type="text" name="contact_field_max_chars" id="contact_field_max_chars" size="5" maxlength="20" value="1,25" />&nbsp;
					<input type="radio" name="contact_field_required" value="1" />{#CONTACT_YES#} <input type="radio" name="contact_field_required" value="0" checked="checked" />{#CONTACT_NO#}<br />
					<input style="width:264px;" type="text" name="contact_field_value" id="contact_field_value" value="{#CONTACT_DEFAULT_MESSAGE#}" />
				</td>
				<td><input type="radio" name="contact_field_status" value="1" checked="checked" />{#CONTACT_YES#} <input type="radio" name="contact_field_status" value="0" />{#CONTACT_NO#}</td>
			</tr>
		</table><br />

		<input type="submit" class="button" value="{#CONTACT_BUTTON_ADD#}" />
	</form>
{/if}