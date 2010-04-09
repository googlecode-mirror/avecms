{strip}

<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#POLL_COMMENTS_TITLE#}</h2></div>
	<div class="HeaderText">{#POLL_COMMENTS_INFO#}</div>
</div><br />

<form method="post" action="index.php?do=modules&action=modedit&mod=poll&moduleaction=comments&id={$smarty.request.id}&cp={$sess}&pop=1&sub=save&page={$smarty.request.page}">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr class="tableheader">
			<td width="1%" align="center"><img src="{$tpl_dir}/images/icon_del.gif" alt="" border="0"  /></td>
			<td width="350">{#POLL_COMMENT_TITLE#}</td>
			<td>{#POLL_COMMENT_INFO#}</td>
		</tr>
		{foreach from=$items item=item}
			<tr style="background-color: #eff3eb;" onmouseover="this.style.backgroundColor='#dae0d8';" onmouseout="this.style.backgroundColor='#eff3eb';" id="table_rows">
				<td width="1%" valign="top">
					<input title="{#POLL_MARK_DELETE#}"  name="del[{$item->id}]" type="checkbox" id="del[{$item->id}]" value="1">
				</td>
				<td valign="top">
					<input name="comment_title[{$item->id}]" type="text" style="width:350px"  id="comment_title[{$item->id}]" value="{$item->title}"><br />
					<textarea name="comment_text[{$item->id}]" cols="40" rows="4" style="width:350px" id="comment_text[{$item->id}]">{$item->comment}</textarea>
				</td>
				<td valign="top">
					{#POLL_COMMENT_AUTHOR#} {$item->lastname} {$item->firstname}<br />
					{#POLL_COMMENT_DATE#} {$item->ctime|date_format:$DATE_FORMAT|pretty_date:$DEF_LANGUAGE}
				</td>
			</tr>
		{/foreach}
	</table><br />

	<input class="button" type="submit" value="{#POLL_BUTTON_SAVE#}" />
</form>

<p>{$page_nav}</p>

<p><div align="center"><input class="button" onClick="window.close();" type="button" value="{#POLL_BUTTON_CLOSE#}" /></div></p>

{/strip}