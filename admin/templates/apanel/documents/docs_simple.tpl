<script language="javascript" type="text/javascript">
function insertLink(o) {ldelim}
	for (var key in o) {ldelim}
		$('#'+key, window.opener.document).val(o[key]);
	{rdelim}
	window.close();
{rdelim}
</script>

<div id="pageHeaderTitle" style="padding-top:7px">
	<div class="h_docs">&nbsp;</div>
	<div class="HeaderTitle">
		<h2>{#DOC_SUB_TITLE#}</h2>
	</div>
	<div class="HeaderText">{#DOC_INSERT_LINK_TIP#}</div>
</div>
<div class="upPage">&nbsp;</div><br />

<form enctype="multipart/form-data">
	<table width="100%" border="0" cellpadding="6" cellspacing="1" class="tableborder">
		<tr>
			<td width="10" class="tableheader"><a class="header" href="index.php?do=docs&amp;action=showsimple&amp;selurl=1&amp;target=txtUrl&amp;pop=1&amp;sort={if $smarty.request.sort=='Id'}IdDesc{else}Id{/if}">{#DOC_ID#}</a></td>
			<td width="11" class="tableheader">&nbsp;</td>
			<td class="tableheader"><a class="header" href="index.php?do=docs&amp;action=showsimple&amp;selurl=1&amp;target=txtUrl&amp;pop=1&amp;sort={if $smarty.request.sort=='Titel'}TitelDesc{else}Titel{/if}">{#DOC_TITLE#}</a></td>
			<td width="10%" class="tableheader"><a class="header" href="index.php?do=docs&amp;action=showsimple&amp;selurl=1&amp;target=txtUrl&amp;pop=1&amp;sort={if $smarty.request.sort=='Rubrik'}RubrikDesc{else}Rubrik{/if}">{#DOC_IN_RUBRIK#}</a></td>
			<td class="tableheader">&nbsp;</td>
		</tr>

		{foreach from=$docs item=item}
			<tr style="background-color:#eff3eb" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td width="10" class="itcen">{$item->Id}</td>
				<td width="11">
					{if ($item->DokStart > $smarty.now && $item->DokStart != '0') || ($item->DokEnde < $smarty.now && $item->DokEnde != '0')}
						&nbsp;
					{else}
						<a title="{#DOC_SHOW_TITLE#}" href="../index.php?id={$item->Id}&amp;cp={$sess}" target="_blank"><img src="{$tpl_dir}/images/icon_search.gif" alt="" border="0" /></a>
					{/if}
				</td>
				<td><strong>{$item->Titel}</strong><br />{$item->Url}</td>
				<td nowrap="nowrap">{$item->RubName|escape:html}</td>
				<td nowrap="nowrap" width="1%" align="right">
					{if $smarty.request.idonly==1}
						<input onclick="insertLink({ldelim}{$smarty.request.target}:'{$item->Id}'{rdelim});" class="button" type="button" value="{#DOC_BUTTON_INSERT_LINK#}" />
					{elseif $smarty.request.selurl==1}
						<input onclick="insertLink({ldelim}{$smarty.request.target}:'index.php?id={$item->Id}&doc={$item->Url}'{rdelim});" class="button" type="button" value="{#DOC_BUTTON_INSERT_LINK#}" />
					{else}
						<input onclick="insertLink({ldelim}{$smarty.request.target}:'index.php?id={$item->Id}',{$smarty.request.doc}:'{$item->Titel}',{$smarty.request.alias}:'{$item->Url}'{rdelim});" class="button" type="button" value="{#DOC_BUTTON_INSERT_LINK#}" />&nbsp;
						<input onclick="insertLink({ldelim}{$smarty.request.target}:'javascript:popup(\'index.php?id={$item->Id}&doc={$item->Url}\',\'{$item->Titel}\',\'800\',\'700\')',{$smarty.request.doc}:'{$item->Titel}',{$smarty.request.alias}:'{$item->Url}'{rdelim});" class="button" type="button" value="{#DOC_BUTTON_LINK_POPUP#}" />
					{/if}
				</td>
			</tr>
		{/foreach}
	</table><br />

	{if $page_nav}
		<div class="infobox">{$page_nav}</div>
		<br />
	{/if}<br />

</form>