<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#FORUMS_MODULE_NAME#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div><br />
{include file="$source/forum_topnav.tpl"}
<h4>{#FORUMS_ATTACH_MANAGER#}</h4>
<form action="index.php?do=modules&action=modedit&mod=forums&moduleaction=attachment_manager&cp={$sess}&save=1" method="post">
<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<tr class="tableheader">
		<td>{#FORUMS_HEADER_ALLOWED_FILE#}</td>
		<td>{#FORUMS_HEADER_MAX_FILE#}</td>
		<td>{#FORUMS_HEADER_ACTIONS#}</td>
	</tr>
{foreach from=$allowed_files item=allowed_file}
	<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
		<td width="20%">{$allowed_file->filetype}</td>
		<td><input type="text" name="filesize[{$allowed_file->id}]" value="{$allowed_file->filesize}" size="6" maxlength="6" />&nbsp;{#FORUMS_KB_FILE#}</td>
		<td width="1%" align="center"><a href="index.php?do=modules&action=modedit&mod=forums&moduleaction=attachment_manager&cp={$sess}&del=1&id={$allowed_file->id}"><img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0" /></a></td>
	</tr>
{/foreach}
	<tr>
		<td class="second" colspan="3">
			<input class="button" type="submit" value="{#FORUMS_BUTTON_SAVE#}" />
		</td>
	</tr>
</table>
</form>
<h4>{#FORUMS_ADD_TYPE_FILE#}</h4>
<form action="index.php?do=modules&action=modedit&mod=forums&moduleaction=attachment_manager&cp={$sess}&new=1" method="post">
<table width="100%" border="0" cellpadding="5" cellspacing="1" class="tableborder">
	<tr>
		<td width="20%" class="first">
			<select name="filetype">
			{foreach from=$possible_files_keys item=possible_files_key}
				{assign var=mime_type value=$possible_files.$possible_files_key}
				<option value="{$possible_files.$possible_files_key}">{* {$possible_files.$possible_files_key} *}{$possible_files_key}</option>
			{/foreach}
			</select>
		</td>
		<td width="20%" class="second">
			<input type="text" name="filesize" value="{$smarty.post.filesize|default:"1024"}" size="6" maxlength="6" />&nbsp;{#FORUMS_KB_FILE#} 
		</td>
		<td class="first">
			<input class="button" type="submit" value="{#FORUMS_BUTTON_ADD#}" /></td>
	</tr>
</table>
</form>