<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module">&nbsp;</div>
	<div class="HeaderTitle"><h2>{#SNL_MODULE_NAME#}</h2></div>
	<div class="HeaderText">&nbsp;</div>
</div><br />
<br />
{*
<div class="infobox">
	<a href="javascript:void(0);" onclick="window.open('index.php?do=modules&amp;action=modedit&amp;mod=newsletter&amp;moduleaction=new&amp;cp={$sess}&pop=1','newnl','top=0,left=0,width=980,height=750,scrollbars=1,resizable=1');">{#SNL_SEND_NEW#}</a>
</div><br />

<div class="infobox">
	<form method="post" action="index.php?do=modules&action=modedit&mod=newsletter&moduleaction=1&cp=$sess">
		<input name="q" type="text" value="{$smarty.request.q|escape}" size="40" />
		<input type="submit" class="button" value="{#SNL_BUTTON_SEARCH#}" />
	</form>
</div>
*}
<table cellspacing="1" cellpadding="8" border="0" width="100%">
	<col width="50%" />
	<col width="50%" />
	<tr>
		<td class="second" nowrap="nowrap">
			<div id="otherLinks">
				<form method="post" action="index.php?do=modules&action=modedit&mod=newsletter&moduleaction=1&cp=$sess">
					<input name="q" type="text" value="{$smarty.request.q|escape}" size="50" />
					<input type="submit" class="button" value="{#SNL_BUTTON_SEARCH#}" />
				</form>
			</div>
		</td>
		<td class="second">
			<div id="otherLinks">
				<a href="javascript:void(0);" onclick="window.open('index.php?do=modules&amp;action=modedit&amp;mod=newsletter&amp;moduleaction=new&amp;cp={$sess}&pop=1','newnl','top=0,left=0,width=980,height=750,scrollbars=1,resizable=1');">
					<div class="taskTitle">{#SNL_SEND_NEW#}</div>
				</a>
			</div>
		</td>
	</tr>
</table>

<form method="post" action="index.php?do=modules&action=modedit&mod=newsletter&moduleaction=delete&cp=$sess">
	{if $smarty.request.file_not_found==1}
		<br />
		<div class="infobox">{#SNL_FILE_NOT_FOUND#}</div><br />
	{/if}

	<h4>{#SNL_SENDING_LIST#}</h4>

	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<col width="30" />
		<col />
		<col width="80" />
		<tr class="tableheader">
			<td align="center"><img src="{$tpl_dir}/images/icon_del.gif" alt="" /></td>
			<td>{#SNL_SEND_TITLE#}</td>
			<td align="center">{#SNL_SEND_TEXT#}</td>
			<td align="center" class="second">{#SNL_SEND_DATE#}</td>
			<td>{#SNL_SEND_AUTHOR#}</td>
			<td align="center">{#SNL_SEND_FORMAT#}</td>
			<td>{#SNL_SEND_RECIVERS#}</td>
			<td>{#SNL_SEND_ATTACHS#}</td>
		</tr>

		{foreach from=$items item=nl}
			<tr style="background-color:#eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td align="center"><input title="{#SNL_MARK_DELETE#}" name="del[{$nl->id}]" type="checkbox" id="del[]" value="checkbox" /></td>
				<td>{$nl->newsletter_title|escape}</td>
				<td align="center"><input onclick="window.open('index.php?id={$nl->id}&do=modules&action=modedit&mod=newsletter&moduleaction=shownewsletter&cp={$sess}&pop=1&nl_format={$nl->newsletter_format}','showtext','top=0,left=0,scrollbars=1,width=980,height=750')" type="button" class="button" value="{#SNL_SEND_SHOW#}" /></td>
				<td align="center" class="time">{$nl->newsletter_send_date|date_format:$TIME_FORMAT|pretty_date}</td>
				<td>{$nl->newsletter_sender|escape}</td>
				<td align="center">{$nl->newsletter_format|upper}</td>
				<td>{foreach from=$nl->newsletter_groups item=e name=eg}{$e->user_group_name|escape}{if !$smarty.foreach.eg.last}, {/if}{/foreach}</td>
				<td>
					{foreach from=$nl->newsletter_attach item=attachments name=att}
						<a href="index.php?do=modules&action=modedit&mod=newsletter&moduleaction=getfile&cp={$sess}&file={$attachments}">{$attachments}</a>{if !$smarty.foreach.att.last}, {/if}
					{/foreach}
				</td>
			</tr>
		{/foreach}
	</table><br />

	<input type="submit" class="button" value="{#SNL_DELETE_MARKED#}" />
</form><br />

{if $page_nav}<div class="infobox">{$page_nav}</div>{/if}