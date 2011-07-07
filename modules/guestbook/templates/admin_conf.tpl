<div class="pageHeaderTitle" style="padding-top:7px">
	<div class="h_module"></div>
	<div class="HeaderTitle"><h2>{#GUEST_CONFIG#}</h2></div>
	<div class="HeaderText">{#GUEST_INFO#}</div>
</div><br />

<form name="form2" method="post" action="index.php?do=modules&action=modedit&mod=guestbook&moduleaction=1&sub=save&cp={$sess}">
	<table width="100%" border="0" align="center" cellpadding="8" cellspacing="1" class="tableborder">
		<col width="250" class="first" />
		<col class="second" />
		<tr class="tableheader">
			<td>{#GUEST_SETTINGS_PARAM#}</td>
			<td>{#GUEST_SETTINGS_VALUE#}</td>
		</tr>
		<tr>
			<td>{#GUEST_MAXLENGHT#}</td>
			<td><input name="post_max_length" type="text" value="{$settings.guestbook_post_max_length}" /></td>
		</tr>
		<tr>
			<td>{#GUEST_SPAM#}</td>
			<td><input name="antispam" type="checkbox" value="1" {if $settings.guestbook_antispam==1}checked="checked" {/if}/></td>
		</tr>
		<tr>
			<td>{#GUEST_SPAM_TIME#}</td>
			<td><input name="antispam_time" type="text" value="{$settings.guestbook_antispam_time}" /></td>
		</tr>
		<tr>
			<td>{#GUEST_MUST_CENSORED#}</td>
			<td><input name="need_approve" type="checkbox" value="1" {if $settings.guestbook_need_approve==1}checked="checked" {/if}/></td>
		</tr>
		<tr>
			<td>{#GUEST_MESSAGE_EMAIL#}</td>
			<td><input name="send_copy" type="checkbox" value="1" {if $settings.guestbook_send_copy==1}checked="checked" {/if}/></td>
		</tr>
		<tr>
			<td>{#GUEST_MAILSEND#}</td>
			<td><input name="email_copy" type="text" value="{$settings.guestbook_email_copy}" /></td>
		</tr>
		<tr>
			<td>{#GUEST_ENABLE_BBCODE#}</td>
			<td><input name="use_bbcode" type="checkbox" value="1" {if $settings.guestbook_use_bbcode==1}checked="checked" {/if}/></td>
		</tr>
		<tr>
			<td colspan="2" class="third">
				<input name="Submit" type="submit" class="button" value="{#GUEST_B_SAVE#}">
			</td>
		</tr>
	</table>
</form>

{if $comments_array}
	<h4>{#GUEST_NEW_POST#}</h4>

	<form action="index.php?do=modules&action=modedit&mod=guestbook&moduleaction=1&cp={$sess}" method="post" name="pp" style="display:inline">
		<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
			<tr>
				<td class="second">
					<select name="sort" id="sort">
						<option value="desc" {if $smarty.request.sort == desc} selected="selected" {/if}>{#GUEST_SORTBYDESC#}</option>
						<option value="asc" {if $smarty.request.sort == asc} selected="selected" {/if}>{#GUEST_SORTBYASC#}</option>
					</select>

					<select name="pp" id="pp">
						{section name=pp loop=95 step=5}
							<option value="{$smarty.section.pp.index+10}" {if $smarty.request.pp == $smarty.section.pp.index+10}selected{/if}>{#GUEST_ON#} {$smarty.section.pp.index+10} {#GUEST_ONPAGE#}</option>
						{/section}
					</select>

					<input type="submit" class="button" value="{#GUEST_B_SORT#}" />
				</td>
			</tr>
		</table>
	</form>

	{if $pnav}{$pnav}{/if}

	<form name="form1" method="post" action="index.php?do=modules&action=modedit&mod=guestbook&moduleaction=medit&cp={$sess}">
		<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
			{foreach name=ca from=$comments_array item=item}
				<tr class="tableheader">
					<td>{#GUEST_AUTOR_NAME#}</td>
					<td>{#GUEST_AUTOR_EMAIL#}</td>
					<td>{#GUEST_AUTOR_SITE#}</td>
					<td>{#GUEST_AUTOR_FROM#}</td>
				</tr>
				<tr class="second" {if $item->guestbook_post_approve != 1}style="background-color:#ffcccc"{/if} id="table_rows">
					<td><input name="author[{$item->id}]" type="text" value="{$item->guestbook_post_author_name}" size="30" style="width:100%" /></td>
					<td><input name="email[{$item->id}]" type="text" value="{$item->guestbook_post_author_email}" size="30" style="width:100%" /></td>
					<td><input name="web[{$item->id}]" type="text" value="{$item->guestbook_post_author_web}" size="30" style="width:100%" /></td>
					<td><input name="sity[{$item->id}]" type="text" value="{$item->guestbook_post_author_sity}" size="30" style="width:100%" /></td>
				</tr>
				<tr class="second" {if $item->guestbook_post_approve != 1}style="background-color:#ffcccc"{/if} id="table_rows">
					<td valign="middle">
						<strong>{#GUEST_TEXT#}</strong><br />
						{$item->guestbook_post_created|date_format:$TIME_FORMAT|pretty_date}<br />
						<br />
						<input name="del[{$item->id}]" type="checkbox" id="d" value="1" />{#GUEST_DELETE#}<br />
						{if $item->guestbook_post_approve != 1}
							<input name="approve[{$item->id}]" type="checkbox" value="1" />{#GUEST_ACTIVE_MESSAGE#}
						{else}
							<input name="approve[{$item->id}]" type="checkbox" value="0" />{#GUEST_INACTIVE_MESSAGE#}
						{/if}
					</td>
					<td colspan="3"><textarea name="post_text[{$item->id}]" cols="50" rows="5" id="post_text[{$item->id}]" style="width:100%">{$item->guestbook_post_text|escape }</textarea></td>
				</tr>
				{if $smarty.foreach.ca.iteration%5 == 0}
					<tr>
						<td colspan="4" class="third">
							<input name="Submit" type="submit" class="button" value="{#GUEST_B_CHANGE#}">
						</td>
					</tr>
				{/if}
			{/foreach}
			{if $smarty.foreach.ca.iteration%5 != 0}
				<tr>
					<td colspan="4" class="third">
						<input name="Submit" type="submit" class="button" value="{#GUEST_B_CHANGE#}">
					</td>
				</tr>
			{/if}
		</table>
	</form>

	{if $pnav}{$pnav}{/if}
{else}
	<h4>{#GUEST_NO_POST#}</h4>
{/if}