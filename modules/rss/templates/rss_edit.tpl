<script type="text/javascript" language="JavaScript">
function check_name() {ldelim}
	if (document.getElementById('rss_name').value == '') {ldelim}
		alert("{#RSS_ENTER_NAME#}");
		document.getElementById('rss_name').focus();
		return false;
	{rdelim}
    return true;
{rdelim}

function changeRub(select) {ldelim}
	location.href='index.php?do=modules&action=modedit&mod=rss&moduleaction=edit&id={$channel->id}&RubrikId=' + select.options[select.selectedIndex].value + '&cp={$sess}';
{rdelim}
</script>
{strip}

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#RSS_EDIT#}</h2></div>
	<div class="HeaderText">{#RSS_EDIT_TIP#}</div>
</div><br />

<div class="infobox">
	<a href="index.php?do=modules&action=modedit&mod=rss&moduleaction=1&cp={$sess}">&raquo;&nbsp;{#RSS_RETURN#}</a>
</div><br />

<form method="post" action="index.php?do=modules&action=modedit&mod=rss&moduleaction=saveedit&cp={$sess}" onSubmit="return check_name();">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr class="tableheader">
			<td colspan="3"><strong>{#RSS_TITLE_EDIT#}</strong></td>
		</tr>

		<tr>
			<td width="1%" class="first"><a title="{#RSS_EDIT_TIP_RUBRIC#}" href="#"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first" width="15%"><strong>{#RSS_RUBS_NAME#}</strong></td>
			<td class="second">
				<select name="rub_id" onChange="changeRub(this)" id="rub_id">
					{foreach from=$rubriks item=rubs}
						<option value="{$rubs->Id}" {if $channel->rub_id == $rubs->Id}selected{/if}>{$rubs->RubrikName}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td width="1%" class="first"><a title="{#RSS_EDIT_TIP_NAME#}" href="#"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first" width="20%"><strong>{#RSS_ITEM_NAME#}</strong></td>
			<td class="second"><input name="rss_name" type="text" id="rss_name" size="60" value="{$channel->rss_name}" /></td>
		</tr>

		<tr>
			<td width="1%" class="first"><a title="{#RSS_EDIT_TIP_ADD#}" href="#"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first" width="20%"><strong>{#RSS_CHANNEL_URL#}:</strong></td>
			<td class="second">http:// <input name="site_url" type="text" id="site_url" size="52" value="{$channel->site_url}" /> /</td>
		</tr>

		<tr>
			<td width="1%" class="first"><a title="{#RSS_EDIT_TIP_TITLE#}" href="#"><img src="{$tpl_dir}/images/icon_help.gif" alt="" border="0" /></a></td>
			<td class="first" width="20%"><strong>{#RSS_CHANNEL_DESCR#}</strong></td>
			<td class="second"><textarea name="site_descr" cols="60" rows="4">{$channel->rss_descr}</textarea></td>
		</tr>

		<tr>
			<td width="1%" class="first">&nbsp;</td>
			<td class="first" width="20%"><strong>{#RSS_CHANNEL_TITLE#}</strong></td>
			<td class="second">
				<select name="field_title">
					{foreach from=$fields item=fids}
						<option value="{$fids->Id}" {if $fids->Id == $channel->title_id}selected{/if}>{$fids->Titel}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td width="1%" class="first">&nbsp;</td>
			<td class="first" width="20%"><strong>{#RSS_CHANNEL_DESC#}</strong></td>
			<td class="second">
				<select name="field_descr">
					{foreach from=$fields item=fids}
						<option value="{$fids->Id}" {if $fids->Id == $channel->descr_id}selected{/if}>{$fids->Titel}</option>
					{/foreach}
				</select>
			</td>
		</tr>

		<tr>
			<td width="1%" class="first">&nbsp;</td>
			<td class="first" width="20%"><strong>{#RSS_LIMIT_NAME#}</strong></td>
			<td class="second"><input name="rss_on_page" type="text" id="rss_on_page" size="10" value="{$channel->on_page}" /></td>
		</tr>

		<tr>
			<td width="1%" class="first">&nbsp;</td>
			<td class="first" width="20%"><strong>{#RSS_DESCR_LIMIT#}:</strong></td>
			<td class="second"><input name="rss_lenght" type="text" id="rss_lenght" size="10" value="{$channel->lenght}" /> {#RSS_SYMBOLS#}</td>
		</tr>

		<tr>
			<td class="third" colspan="3"><input type="submit" class="button" value="{#RSS_BUTTON_SAVE#}" /></td>
		</tr>

		<input type="hidden" name="id" value="{$channel->id}" />

	</table>
</form>

{/strip}