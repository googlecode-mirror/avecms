{strip}

<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<tr>
		<td colspan="3" class="tableheader">{if $smarty.request.moduleaction=='new'}{#CONTACT_CREATE_FORM2#}{else}{#CONTACT_FORM_FIELDS#}{/if}</td>
	</tr>

	<tr>
		<td width="1%" class="first"><a title="{#CONTACT_FORM_TITEL#}" href="#"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
		<td width="200" class="first">{#CONTACT_FORM_NAME2#}</td>
		<td class="second"><input name="form_name" type="text" id="form_name" value="{$row->form_name}" size="50" /></td>
	</tr>

	<tr>
		<td width="1%" class="first"><a title="{#CONTACT_MAX_CHARS#}" href="#"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
		<td width="200" class="first">{#CONTACT_MAX_CHARS_FIELD#}</td>
		<td class="second"><input name="form_mail_max_chars" type="text" id="form_mail_max_chars" value="{$row->form_mail_max_chars|default:20000}" size="10" maxlength="10" /></td>
	</tr>

	<tr>
		<td width="1%" class="first"><a title="{#CONTACT_DEFAULT_EMAIL#}" href="#"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
		<td width="200" class="first">{#CONTACT_DEFAULT_RECIVER#}</td>
		<td class="second"><input name="form_receiver" type="text" id="form_receiver" value="{$row->form_receiver}" size="50" /></td>
	</tr>

	<tr>
		<td width="1%" class="first"><a title="{#CONTACT_MULTI_LIST#}" href="#"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
		<td width="200" class="first">{#CONTACT_MULTI_LIST_FIELD#}</td>
		<td class="second"><input name="form_receiver_multi" type="text" id="form_receiver_multi" value="{$row->form_receiver_multi}" style="width:90%" /></td>
	</tr>

	<tr>
		<td width="1%" class="first"><a title="{#CONTACT_SCODE_INFO#}" href="#"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
		<td width="200" class="first">{#COUNACT_USE_SCODE_FIELD#}</td>
		<td class="second"><input type="radio" name="form_antispam" value="1" {if $row->form_antispam==1}checked{/if} />{#CONTACT_YES#}<input type="radio" name="form_antispam" value="0" {if $row->form_antispam!=1}checked{/if} />{#CONTACT_NO#}</td>
	</tr>

	<tr>
		<td class="first"><a title="{#CONTACT_MAX_SIZE_INFO#}" href="#"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
		<td width="200" class="first">{#CONTACT_MAX_UPLOAD_FIELD#}</td>
		<td class="second"><input name="form_max_upload" type="text" id="form_max_upload" value="{$row->form_max_upload|default:120}" size="10" maxlength="5" /></td>
	</tr>

	<tr>
		<td class="first"><a title="{#CONTACT_SUBJECT_FIELD_INFO#}" href="#"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a> </td>
		<td width="200" class="first">{#CONTACT_USE_SUBJECT_FIELD#}</td>
		<td class="second"><input type="radio" name="form_show_subject" value="1" {if $row->form_show_subject==1}checked{/if} />{#CONTACT_YES#}<input type="radio" name="form_show_subject" value="0" {if $row->form_show_subject!=1}checked{/if} />{#CONTACT_NO#}</td>
	</tr>

	<tr>
		<td class="first"><a title="{#CONTACT_DEFAULT_SUBJ_INFO#}" href="#"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a> </td>
		<td width="200" class="first">{#CONTACT_DEFAULT_SUBJECT#}</td>
		<td class="second"><input name="form_default_subject" type="text" id="form_default_subject" value="{$row->form_default_subject|stripslashes|escape:html}" size="50" /></td>
	</tr>

	<tr>
		<td class="first">&nbsp;</td>
		<td class="first">{#CONTACT_USE_COPY_FIELD#}</td>
		<td class="second"><input type="radio" name="form_send_copy" value="1" {if $row->form_send_copy==1}checked{/if} />{#CONTACT_YES#}<input type="radio" name="form_send_copy" value="0" {if $row->form_send_copy!=1}checked{/if} />{#CONTACT_NO#}</td>
	</tr>

	<tr>
		<td class="first">&nbsp;</td>
		<td width="200" valign="top" class="first">{#CONTACT_PERMISSIONS_FIELD#}<br /><small>{#CONTACT_GROUPS_INFO#}</small></td>
		<td class="second">
			<select style="width:200px" name="form_allow_group[]" size="5" multiple="multiple">
				{foreach from=$groups item=group}
					<option value="{$group->Benutzergruppe}" {if @in_array($group->Benutzergruppe, $groups_form) || $smarty.request.moduleaction=="new"}selected="selected"{/if}>{$group->Name}</option>
				{/foreach}
			</select>
		</td>
	</tr>

	<tr>
		<td class="first">&nbsp;</td>
		<td width="200" valign="top" class="first">{#CONTACT_TEXT_NO_PERMISSION#}</td>
		<td class="second"><textarea style="width:500px; height:100px" name="form_message_noaccess" id="form_message_noaccess">{$row->form_message_noaccess|escape:html|stripslashes}</textarea></td>
	</tr>
</table>

{/strip}