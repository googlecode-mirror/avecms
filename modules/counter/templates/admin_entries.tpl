
<!-- admin_entries.tpl -->
{strip}

<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#COUNTER_FULL_STATISTIC#}</h2>
	</div>
	<div class="HeaderText">{#COUNTER_SHOW_INFO_BYID#} {$smarty.request.id}</div>
</div><br />

<form method="post" action="index.php?do=modules&action=modedit&mod=counter&moduleaction=quicksave&cp={$sess}">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<col width="120">
		<col>
		<col width="90">
		<col width="100">
		<col width="110">
		<tr class="tableheader">
			<td><a class="header" href="index.php?{if $smarty.request.page!=''}page={$smarty.request.page}&{/if}do=modules&action=modedit&mod=counter&moduleaction=view_referer&id={$smarty.request.id}&pop=1&cp={$sess}&sort={if $smarty.request.sort=='visit_asc'}visit_desc{else}visit_asc{/if}">{#COUNTER_USER_DATE#}</a></td>
			<td><a class="header" href="index.php?{if $smarty.request.page!=''}page={$smarty.request.page}&{/if}do=modules&action=modedit&mod=counter&moduleaction=view_referer&id={$smarty.request.id}&pop=1&cp={$sess}&sort={if $smarty.request.sort=='referer_desc'}referer_asc{else}referer_desc{/if}">{#COUNTER_USER_LINK#}</a></td>
			<td><a class="header" href="index.php?{if $smarty.request.page!=''}page={$smarty.request.page}&{/if}do=modules&action=modedit&mod=counter&moduleaction=view_referer&id={$smarty.request.id}&pop=1&cp={$sess}&sort={if $smarty.request.sort=='os_desc'}os_asc{else}os_desc{/if}">{#COUNTER_USER_OS#}</a></td>
			<td><a class="header" href="index.php?{if $smarty.request.page!=''}page={$smarty.request.page}&{/if}do=modules&action=modedit&mod=counter&moduleaction=view_referer&id={$smarty.request.id}&pop=1&cp={$sess}&sort={if $smarty.request.sort=='browser_desc'}browser_asc{else}browser_desc{/if}">{#COUNTER_USER_BROWSER#}</a></td>
			<td><a class="header" href="index.php?{if $smarty.request.page!=''}page={$smarty.request.page}&{/if}do=modules&action=modedit&mod=counter&moduleaction=view_referer&id={$smarty.request.id}&pop=1&cp={$sess}&sort={if $smarty.request.sort=='ip_asc'}ip_desc{else}ip_asc{/if}">{#COUNTER_USER_IP#}</a></td>
		</tr>

		{foreach from=$items item=item}
			<tr style="background-color:#eff3eb" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td>{$item->visit|date_format:#COUNTER_DATE_FORMAT#}</td>
				<td>
					{if $item->client_referer != ''}
						<a target="_blank" href="{$item->client_referer}">{$item->client_referer|default:'-'}</a>
					{else}
						{$item->client_referer|default:'-'}
					{/if}
				</td>
				<td>{$item->client_os}</td>
				<td>{$item->client_browser}</td>
				<td><a target="_blank" href="https://www.nic.ru/whois/?query={$item->client_ip}" title="{#COUNTER_WHOIS#}">{$item->client_ip}</a></td>
			</tr>
		{/foreach}
	</table>
</form><br />

<input onclick="self.close();" class="button" type="button" value="{#COUNTER_BUTTON_CLOSE#}"><br />
<br />

{if $page_nav}
	<div class="infobox">
		{$page_nav}
	</div>
{/if}

{/strip}
<!-- /admin_entries.tpl -->
