<script type="text/javascript" language="JavaScript">
function check_name() {ldelim}
	if (document.getElementById('newsarchive_name_new').value == '') {ldelim}
		alert("{#ARCHIVE_ENTER_NAME#}");
		document.getElementById('newsarchive_name_new').focus();
		return false;
	{rdelim}
	return true;
{rdelim}
</script>

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#ARCHIVE_LIST#}</h2></div>
	<div class="HeaderText">{#ARCHIVE_LIST_TIP#}</div>
</div><br />

{if $archives}
	<form method="post" action="index.php?do=modules&action=modedit&mod=newsarchive&moduleaction=savelist&cp={$sess}">
		<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
			<tr class="tableheader">
				<td width="1%">{#ARCHIVE_NAME#}</td>
				<td width="1%">{#ARCHIVE_TAG#}</td>
				<td width="96%">{#ARCHIVE_USE_RUBRIKS#}</td>
				<td width="1%" colspan="2">{#ARCHIVE_ACTIONS#}</td>
			</tr>
			{foreach from=$archives item=archive}
				<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
					<td>
						<input name="newsarchive_name[{$archive->id}]" type="text" id="newsarchive_name[{$archive->id}]" value="{$archive->newsarchive_name|escape:html|stripslashes}" size="40" />
					</td>
					<td width="100"><input name="textfield" type="text" value="[mod_newsarchive:{$archive->id}]" readonly /></td>
					<td>{if !$archive->rubric_title}{#ARCHIVE_NO_RUBRIKS#}{else}{$archive->rubric_title}{/if}</td>
					<td align="center">
						<a title="{#ARCHIVE_EDIT_HINT#}" href="index.php?do=modules&action=modedit&mod=newsarchive&moduleaction=edit&cp={$sess}&id={$archive->id}">
						<img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a>
					</td>
					<td align="center">
						<a title="{#ARCHIVE_DELETE_HINT#}" href="index.php?do=modules&action=modedit&mod=newsarchive&moduleaction=del&cp={$sess}&id={$archive->id}">
						<img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0" />
					</td>
				</tr>
			{/foreach}
		</table><br />
		<input type="submit" class="button" value="{#ARCHIVE_BUTTON_SAVE#}" />
	</form>
{else}
	{#ARCHIVE_NO_ITEMS#}
{/if}<br />
<br />

<h4>{#ARCHIVE_ADD#}</h4>

<form action="index.php?do=modules&action=modedit&mod=newsarchive&moduleaction=add&cp={$sess}" method="post" onSubmit="return check_name();">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr>
			<td class="tableheader">{#ARCHIVE_NAME#}</td>
		</tr>
		<tr>
			<td class="second">
				<input name="newsarchive_name_new" type="text" id="newsarchive_name_new" size="60" />
				<input name="submit" type="submit" class="button" value="{#ARCHIVE_BUTTON_ADD#}" />
			</td>
		</tr>
	</table>
</form>