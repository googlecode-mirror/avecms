<script type="text/javascript" language="JavaScript">
function check_name() {ldelim}
	if (document.getElementById('new_rss').value == '') {ldelim}
		alert("{#RSS_ENTER_NAME#}");
		document.getElementById('new_rss').focus();
		return false;
	{rdelim}
	return true;
{rdelim}
</script>

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#RSS_LIST#}</h2></div>
	<div class="HeaderText">{#RSS_LIST_TIP#}</div>
</div><br />
<br />

{if $channels}
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr class="tableheader">
			<td width="1%">{#RSS_ID#}</td>
			<td width="30%">{#RSS_CHANNEL_NAME#}</td>
			<td width="15%">{#RSS_ONPAGE_LIMIT#}</td>
			<td width="15%">{#RSS_DESCR_LIMIT#}</td>
			<td width="20%">{#RSS_CHANNEL_URL#}</td>
			<td width="10%">{#RSS_TAG#}</td>
			<td width="5%" colspan="2" align="center">{#RSS_ACTIONS#}</td>
		</tr>

		{foreach from=$channels item=channel}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td class="itcen">{$channel->id}</td>
				<td><a title="{#RSS_EDIT_HINT#}" href="index.php?do=modules&action=modedit&mod=rss&moduleaction=edit&cp={$sess}&id={$channel->id}">{$channel->rss_site_name|escape}</a></td>
				<td>{$channel->rss_item_on_page}</td>
				<td>{$channel->rss_description_lenght} {#RSS_SYMBOLS#}</td>
				<td>{if $channel->rss_site_url == ''}{#RSS_SITE_NAME_NO#}{else}{$channel->rss_site_url}{/if}</td>
				<td><input name="textfield" type="text" value="{$channel->tag}" readonly /></td>
				<td align="center">
					<a title="{#RSS_EDIT_HINT#}" href="index.php?do=modules&action=modedit&mod=rss&moduleaction=edit&cp={$sess}&id={$channel->id}">
					<img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a>
				</td>
				<td align="center">
					<a title="{#RSS_DELETE_HINT#}" href="index.php?do=modules&action=modedit&mod=rss&moduleaction=del&cp={$sess}&id={$channel->id}">
					<img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0" />
				</td>
			</tr>
		{/foreach}
	</table>
{else}
	{#RSS_NO_ITEMS#}
{/if}

<h4>{#RSS_ADD#}</h4>

<form action="index.php?do=modules&action=modedit&mod=rss&moduleaction=add&cp={$sess}" method="post" onSubmit="return check_name();">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr class="tableheader">
			<td colspan="2">{#RSS_NAME#}</td>
		</tr>

		<tr>
			<td class="second" width="350"><input name="new_rss" type="text" id="new_rss" size="60" /></td>
			<td class="second"><input name="submit" type="submit" class="button" value="{#RSS_BUTTON_ADD#}" /></td>
		</tr>
	</table>
</form>