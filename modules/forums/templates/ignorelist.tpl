{include file="$inc_path/userpanel_forums.tpl"}
{include file="$inc_path/header_sthreads.tpl"}
<br />

<table width="100%" border="0" cellpadding="3" cellspacing="1" class="forum_tableborder">
	<tr>
		<td colspan="5" class="forum_header"><strong>{#IgnoreList#}</strong></td>
	</tr>

	<tr>
		<td colspan="5" class="forum_info_meta">{#IngnoreNewText#}</td>
	</tr>

	<tr>
		<td class="forum_header">{#IgnoreName#}</td>
		<td align="center">{#IgnoreId#}</td>
		<td align="center">{#IgnoreTime#}</td>
		<td align="center">{#IgnoreReason#}</td>
		<td align="center">{#IgnoreRemove#}</td>
	</tr>

	{foreach from=$ignored item=i}
		<tr class="{cycle name='il' values='forum_post_second,forum_post_first'}">
			<td><a href="index.php?module=forums&show=userprofile&user_id={$i.ignore_id}"><strong>{$i.user_group_name|escape}</strong></a></td>
			<td align="center">{$i.ignore_id}</td>
			<td align="center">{$i.ignore_date|date_format:$smarty.config.DateFormatMemberSince}</td>
			<td>{$i.ignore_reason|escape:html|stripslashes}</td>
			<td align="center"><strong><a href="index.php?module=forums&amp;show=ignorelist&amp;remove={$i.ignore_id}">{#IgnoreLink#}</a></strong></td>
		</tr>
	{/foreach}
</table><br />

<form method="get" action="index.php">
	<table width="100%" border="0" cellpadding="4" cellspacing="1" class="forum_tableborder">
		<tr>
			<td colspan="2" class="forum_header">
				<a name="new"></a>
				<strong>{#IgnoreNew#}</strong>
			</td>
		</tr>
		<tr>
			<td width="150" class="forum_post_first">{#IgnoreId#}</td>
			<td class="forum_post_second"><input type="text" name="insert" value="" /></td>
		</tr>
		<tr>
			<td width="150" class="forum_post_first">{#IgnoreOrName#}</td>
			<td class="forum_post_second"><input name="uname" type="text" id="uname" /></td>
		</tr>
		<tr>
			<td width="150" class="forum_post_first">{#IgnoreReason#}</td>
			<td class="forum_post_second"><input name="reason" type="text" id="reason" /></td>
		</tr>
		<tr>
			<td width="150" class="forum_post_first">&nbsp;</td>
			<td class="forum_post_second">
				<input type="submit" class="button" value="{#IgnoreButton#}" />
				<input type="hidden" name="module" value="forums" />
				<input type="hidden" name="show" value="ignorelist" />
			</td>
		</tr>
	</table>
</form>