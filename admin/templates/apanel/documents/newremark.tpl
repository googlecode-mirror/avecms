{if check_permission("remarks")}
	<div id="pageHeaderTitle" style="padding-top:7px">
		<div class="h_docs">&nbsp;</div>
		<div class="HeaderTitle">
			<h2>{#DOC_NOTICE#}</h2>
		</div>
		<div class="HeaderText">{#DOC_NOTICE_NEW_LINK#}</div>
	</div>
	<div class="upPage">&nbsp;</div><br />

	<table width="100%" border="0" cellpadding="8" cellspacing="1">
		{foreach from=$answers item=answer}
			<tr>
				<td class="tableheader">{#DOC_NOTICE_AUTHOR#}{$answer.remark_author} ({$answer.remark_published|date_format:$TIME_FORMAT|pretty_date})</td>
			</tr>

			<tr>
				<td style="line-height:1.3em" class="first">
					{if $answer.remark_title}<strong>{$answer.remark_title}</strong><br />{/if}
					<br />
					{$answer.remark_text}<br />
					{if check_permission("remark_del")}
						<div align="right">&raquo;&nbsp;<strong><a href="index.php?do=docs&action=remark_del&Id={$smarty.request.Id|escape}&CId={$answer.Id}&remark_first={$answer.remark_first}&pop=1&cp={$sess}">{#DOC_NOTICE_DELETE_LINK#}</a></strong></div>
					{/if}
				</td>
			</tr>
		{/foreach}
	</table>

	{if check_permission("comments_openlose")}
		<form method="post" action="index.php?do=docs&action=remark_status&Id={$smarty.request.Id|escape}&pop=1&cp={$sess}">
			<div class="infobox">
				<input name="remark_status" type="checkbox" id="remark_status" value="1" {if $remark_status==1}checked="checked" {/if}/>
				{#DOC_ALLOW_NOTICE#}&nbsp;
				<input type="submit" class="button" value="{#DOC_BUTTON_NOTICE#}" />
			</div>
		</form>
	{/if}

	{if $page_nav}
		<div class="infobox">{$page_nav}</div>
	{/if}
	<p>&nbsp;</p>

{/if}

{if $reply==1}
	{if $remark_status==1 || $new ==1}
		{include file='documents/replyform.tpl'}
	{/if}
{/if}