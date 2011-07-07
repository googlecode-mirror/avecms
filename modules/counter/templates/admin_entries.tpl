<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#COUNTER_FULL_STATISTIC#}</h2>
	</div>
	<div class="HeaderText">{#COUNTER_SHOW_INFO_BYID#} {$smarty.request.id|escape}</div>
</div><br />

<form method="post" action="index.php?do=modules&action=modedit&mod=counter&moduleaction=quicksave&cp={$sess}">
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<col width="120">
		<col>
		<col width="90">
		<col width="100">
		<col width="110">
		<tr class="tableheader">
			<td><a class="header" href="index.php?{if $smarty.request.page!=''}page={$smarty.request.page|escape}&{/if}do=modules&action=modedit&mod=counter&moduleaction=view_referer&id={$smarty.request.id|escape}&pop=1&cp={$sess}&sort={if $smarty.request.sort=='visit_asc'}visit_desc{else}visit_asc{/if}">{#COUNTER_USER_DATE#}</a></td>
			<td><a class="header" href="index.php?{if $smarty.request.page!=''}page={$smarty.request.page|escape}&{/if}do=modules&action=modedit&mod=counter&moduleaction=view_referer&id={$smarty.request.id|escape}&pop=1&cp={$sess}&sort={if $smarty.request.sort=='referer_desc'}referer_asc{else}referer_desc{/if}">{#COUNTER_USER_LINK#}</a></td>
			<td><a class="header" href="index.php?{if $smarty.request.page!=''}page={$smarty.request.page|escape}&{/if}do=modules&action=modedit&mod=counter&moduleaction=view_referer&id={$smarty.request.id|escape}&pop=1&cp={$sess}&sort={if $smarty.request.sort=='os_desc'}os_asc{else}os_desc{/if}">{#COUNTER_USER_OS#}</a></td>
			<td><a class="header" href="index.php?{if $smarty.request.page!=''}page={$smarty.request.page|escape}&{/if}do=modules&action=modedit&mod=counter&moduleaction=view_referer&id={$smarty.request.id|escape}&pop=1&cp={$sess}&sort={if $smarty.request.sort=='browser_desc'}browser_asc{else}browser_desc{/if}">{#COUNTER_USER_BROWSER#}</a></td>
			<td><a class="header" href="index.php?{if $smarty.request.page!=''}page={$smarty.request.page|escape}&{/if}do=modules&action=modedit&mod=counter&moduleaction=view_referer&id={$smarty.request.id|escape}&pop=1&cp={$sess}&sort={if $smarty.request.sort=='ip_asc'}ip_desc{else}ip_asc{/if}">{#COUNTER_USER_IP#}</a></td>
		</tr>

		{foreach from=$items item=item}
			<tr style="background-color:#eff3eb" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td>{$item->counter_visit_time|date_format:$TIME_FORMAT|pretty_date}</td>
				<td>
					{if $item->counter_client_referer != ''}
						<a target="_blank" href="{$item->counter_client_referer}">{$item->counter_client_referer|default:'-'}</a>
					{else}
						{$item->counter_client_referer|default:'-'}
					{/if}
				</td>
				<td>{$item->counter_client_os}</td>
				<td>{$item->counter_client_browser}</td>
				<td><a target="_blank" href="https://www.nic.ru/whois/?query={$item->counter_client_ip}" title="{#COUNTER_WHOIS#}">{$item->counter_client_ip}</a></td>
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