
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
		<col width="30" />
		<col width="30" />
		<col />
		<col width="150" />
		<col width="75" />
		<tr>
			<td class="tableheader"><a class="header" href="index.php?do=docs&amp;action=showsimple&amp;target=txtUrl&amp;pop=1&amp;sort=id{if $smarty.request.sort=='id'}_desc{/if}">{#DOC_ID#}</a></td>
			<td class="tableheader">&nbsp;</td>
			<td class="tableheader"><a class="header" href="index.php?do=docs&amp;action=showsimple&amp;target=txtUrl&amp;pop=1&amp;sort=title{if $smarty.request.sort=='title'}_desc{/if}">{#DOC_TITLE#}</a></td>
			<td class="tableheader"><a class="header" href="index.php?do=docs&amp;action=showsimple&amp;target=txtUrl&amp;pop=1&amp;sort=rubric{if $smarty.request.sort=='rubric'}_desc{/if}">{#DOC_IN_RUBRIK#}</a></td>
			<td class="tableheader">&nbsp;</td>
		</tr>

		{foreach from=$docs item=item}
			<tr style="background-color:#eff3eb" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td class="itcen">{$item->Id}</td>
				<td>
					{if $item->document_published < $smarty.now && ($item->document_expire == '0' || $item->document_expire > $smarty.now)}
						<a title="{#DOC_SHOW_TITLE#}" href="../index.php?id={$item->Id}&amp;cp={$sess}" target="_blank"><img src="{$tpl_dir}/images/icon_search.gif" alt="" border="0" /></a>
					{else}
						&nbsp;
					{/if}
				</td>
				<td><strong>{$item->document_title}</strong><br />{$item->document_alias}</td>
				<td nowrap="nowrap">{$item->RubName|escape}</td>
				<td nowrap="nowrap">
					{if $smarty.request.idonly==1}
						<input onclick="insertLink({ldelim}{$smarty.request.target|escape}:'{$item->Id}'{rdelim});" class="button" type="button" value="{#DOC_BUTTON_INSERT_LINK#}" />
					{elseif $smarty.request.selurl==1}
						<input onclick="insertLink({ldelim}{$smarty.request.target|escape}:'index.php?id={$item->Id}&doc={$item->document_alias}'{rdelim});" class="button" type="button" value="{#DOC_BUTTON_INSERT_LINK#}" />
					{else}
						<input onclick="insertLink({ldelim}{$smarty.request.target|escape}:'index.php?id={$item->Id}',{$smarty.request.doc|escape}:'{$item->document_title}',{$smarty.request.document_alias|escape}:'{$item->document_alias}'{rdelim});" class="button" type="button" value="{#DOC_BUTTON_INSERT_LINK#}" />&nbsp;
						<input onclick="insertLink({ldelim}{$smarty.request.target|escape}:'javascript:popup(\'index.php?id={$item->Id}&doc={$item->document_alias}\',\'{$item->document_title}\',\'800\',\'700\')',{$smarty.request.doc|escape}:'{$item->document_title}',{$smarty.request.document_alias|escape}:'{$item->document_alias}'{rdelim});" class="button" type="button" value="{#DOC_BUTTON_LINK_POPUP#}" />
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