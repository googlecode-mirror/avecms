<div class="pageHeaderTitle" style="padding-top: 7px;">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#CONTACT_SHOW_ANSWER2#}</h2></div>
	{if $smarty.request.reply=='no'}
		<div class="HeaderText">{#CONTACT_MODULE_TIP#} {#CONTACT_ALLREADY_REPLIED#}</div>
	{else}
		<div class="HeaderText">{#CONTACT_MODULE_TIP#}</div>
	{/if}
</div><br />

<form name="replay" enctype="multipart/form-data" method="post" action="index.php?do=modules&action=modedit&mod=contact&moduleaction=reply&cp={$sess}&id={$smarty.request.id}&pop=1">
	<table width="100%" border="0" cellspacing="1" cellpadding="8" class="tableborder">
		<tr class="tableheader">
			<td colspan="2">{#CONTACT_AUTHOR#}{$row->in_email} ({$row->in_date|date_format:$TIME_FORMAT|pretty_date})</td>
		</tr>

		<tr>
			<td colspan="2" class="first"><textarea readonly style="width:98%;height:200px">{$row->in_message}</textarea></td>
		</tr>

		{if $attachments}
			<tr>
				<td colspan="2" class="first"><strong>{#CONTACT_ATTACHMENTS#}</strong>
					{foreach name=am from=$attachments item=att}
						<img class="absmiddle" src="{$tpl_dir}/images/attachment.gif" alt="" />
						<a href="index.php?do=modules&action=modedit&mod=contact&moduleaction=get_attachment&cp={$sess}&file={$att->name}&pop=1">{$att->name}</a> ({$att->size} {#CONTACT_FILE_SIZE#}){if !$smarty.foreach.am.last}, {/if}
					{/foreach}
				</td>
			</tr>
		{/if}

		<tr>
			<td colspan="2">&nbsp;</td>
		</tr>

		<tr>
			<td colspan="2" class="tableheader">{#CONTACT_YOUR_REPLY#}</td>
		</tr>

		<tr>
			<td class="first">{#CONTACT_RECIVER_EMAIL#}</td>
			<td class="second"><input name="to" type="text" id="to" value="{$row->in_email}" size="50" /></td>
		</tr>

		<tr>
			<td width="150" class="first">{#CONTACT_SUJECT_EMAIL#}</td>
			<td class="second"><input name="subject" type="text" id="subject" value="RE:{$row->in_subject|escape:html|stripslashes}" size="50" /></td>
		</tr>

		<tr>
			<td width="150" class="first">{#CONTACT_REPLY_NAME#}</td>
			<td class="second"><input name="fromname" type="text" id="fromname" value="{$smarty.session.user_name}" size="50" /></td>
		</tr>

		<tr>
			<td width="150" class="first">{#CONTACT_REPLY_EMAIL#}</td>
			<td class="second"><input name="fromemail" type="text" id="fromemail" value="{$smarty.session.user_email}" size="50" /></td>
		</tr>

		<tr>
			<td width="150" class="first">{#CONTACT_REPLY_MESSAGE#}</td>
			<td class="second">
				<textarea name="message" id="message" style="width:98%;height:200px">
      {#CONTACT_MESSAGE_HEADER#}
      {#CONTACT_MESSAGE_YOUR_TEXT#}
      {#CONTACT_YOUR_INFO#}{$smarty.session.user_name}
---------------------------------------------------
---------------------------------------------------
{#CONTACT_YOUR_DATE#} {$row->in_date|date_format:$TIME_FORMAT|pretty_date}

{$row->replytext}
				</textarea>
			</td>
		</tr>

		{section name=atta loop=3}
			<tr>
				<td class="first">{#CONTACT_ATTACHMENT#}</td>
				<td class="second"><input name="upfile[]" type="file" id="upfile[]" /></td>
			</tr>
		{/section}
	</table><br />

	<input type="submit" value="{#CONTACT_BUTTON_SEND#}" class="button" />&nbsp;
	<input type="button" class="button" value="{#CONTACT_BUTTON_CLOSE#}" onclick="self.close();" />
</form>