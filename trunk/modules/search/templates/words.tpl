
<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#SEARCH_MODULE_NAME#}</h2></div>
	<div class="HeaderText">{#SEARCH_MODULE_DESCRIPTION#}</div>
</div>
<br>

<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<tr class="tableheader">
		<td><a class="header" href="index.php?do=modules&action=modedit&mod=search&moduleaction=1&cp={$sess}&sort={if $smarty.request.sort=='begriff_desc'}begriff_asc{else}begriff_desc{/if}">{#SEARCH_WORD#} </a></td>
		<td><a class="header" href="index.php?do=modules&action=modedit&mod=search&moduleaction=1&cp={$sess}&sort={if $smarty.request.sort=='anzahl_desc'}anzahl_asc{else}anzahl_desc{/if}">{#SEARCH_QUERIES#}</a></td>
		<td><a class="header" href="index.php?do=modules&action=modedit&mod=search&moduleaction=1&cp={$sess}&sort={if $smarty.request.sort=='gefunden_desc'}gefunden_asc{else}gefunden_desc{/if}">{#SEARCH_FOUND_DOCS#}</a></td>
	</tr>

	{foreach from=$items item=item}
		<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
			<td><strong>{$item->search_query|escape}</strong></td>
			<td>{$item->search_count}</td>
			<td>{$item->search_found}</td>
		</tr>
	{/foreach}
</table>
<br />

<form method="post" action="index.php?do=modules&action=modedit&mod=search&moduleaction=delwords&cp={$sess}">
	<input class="button" type="submit" value="{#SEARCH_DELETE_ITEMS#}" />
</form>
<br />

{if $page_nav}<div class="infobox">{$page_nav}</div>{/if}
