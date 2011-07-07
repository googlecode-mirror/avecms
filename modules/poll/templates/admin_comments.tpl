<div class="pageHeaderTitle" style="padding-top:7px;">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#POLL_COMMENTS_TITLE#}</h2></div>
	<div class="HeaderText">{#POLL_COMMENTS_INFO#}</div>
</div><br />

{if $page_nav}<p>{$page_nav}</p>{/if}

<form method="post" action="index.php?do=modules&action=modedit&mod=poll&moduleaction=comments&id={$smarty.request.id|escape}&cp={$sess}&pop=1&sub=save&page={$smarty.request.page|escape}">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<col width="10" />
		<col width="150" />
		<tr class="tableheader">
			<td align="center" valign="middle"><img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0"  /></td>
			<td>{#POLL_COMMENT_INFO#}</td>
			<td>{#POLL_COMMENT_TITLE#}</td>
		</tr>
		{foreach from=$items item=item}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td>
					<input title="{#POLL_MARK_DELETE#}"  name="del[{$item->id}]" type="checkbox" id="del[{$item->id}]" value="1">
				</td>
				<td nowrap="nowrap" valign="top">
					{#POLL_COMMENT_AUTHOR#}<br />
					<strong>{$item->poll_comment_author|escape}</strong><br />
					<br />
					{#POLL_COMMENT_DATE#}<br />
					<strong>{$item->poll_comment_time|date_format:$DATE_FORMAT|pretty_date}</strong>
				</td>
				<td>
					<input name="comment_title[{$item->id}]" type="text" style="width:98%" id="comment_title[{$item->id}]" value="{$item->poll_comment_title|escape}"><br />
					<textarea name="comment_text[{$item->id}]" cols="50" rows="5" style="width:98%" id="comment_text[{$item->id}]">{$item->poll_comment_text|escape}</textarea>
				</td>
			</tr>
		{/foreach}
		<tr>
			<td class="third" colspan="3">
				<input class="button" type="submit" value="{#POLL_BUTTON_SAVE#}" />
				<input class="button" onClick="window.close();" type="button" value="{#POLL_BUTTON_CLOSE#}" />
			</td>
		</tr>
	</table>
</form>

{if $page_nav}<p>{$page_nav}</p>{/if}

{*<p><div align="center"><input class="button" onClick="window.close();" type="button" value="{#POLL_BUTTON_CLOSE#}" /></div></p>*}