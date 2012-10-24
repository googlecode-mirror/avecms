{include file="$inc_path/userpanel_forums.tpl"}
{include file="$inc_path/header_sthreads.tpl"}

{if $public==1}
<form method="post" action="index.php?module=forums&show=userprofile&user_id=1{$smarty.get.user_id}">
	<table width="100%" border="0" cellpadding="5" cellspacing="1" class="forum_tableborder">
		<tr>
			<td colspan="2" class="forum_header"><strong>{#FORUMS_PR_USER_PROFILE_FROM#} &#8222;{$user->uname}&#8220;</strong></td>
		</tr>
		<tr>
			<td width="200" class="forum_post_first">{#FORUMS_PR_ONLINE_STATUS#}</td>
			<td class="forum_post_second">{$user->OnlineStatus}</td>
		</tr>
		<tr>
			<td class="forum_post_first">{#FORUMS_IGNORE_LIST#}</td>
			<td class="forum_post_second">
			{if $Ignored=='1'}
				{#FORUMS_IS_IN_IGNORE#}<a href="index.php?module=forums&amp;show=ignorelist&amp;remove={$smarty.get.user_id}"><strong>{#FORUMS_REMOVE_IGNORE#}</strong></a>
			{else}
				<a href="index.php?module=forums&amp;show=ignorelist&amp;insert={$smarty.get.user_id}"><strong>{#FORUMS_INSERT_IGNORE#}</strong></a>
			{/if}
			 </td>
		</tr>
	{if $user->pn_receipt==1}
		<tr>
			<td width="200" class="forum_post_first">{#FORUMS_PN_SEND_PN#}</td>
			<td class="forum_post_second"><a href="index.php?module=forums&show=pn&action=new&to={cpencode val=$user->uname}"><strong>{#FORUMS_USER_SEND_PN#}</strong></a></td>
		</tr>
	{/if}
		<tr>
			<td width="200" class="forum_post_first">{#FORUMS_PR_REG_DATE#}</td>
			<td class="forum_post_second">{$user->reg_time|date_format:$TIME_FORMAT|pretty_date}&nbsp;</td>
		</tr>
	{if $user->avatar}
		<tr>
			<td width="200" class="forum_post_first">{#FORUMS_PR_AVATAR#}</td>
			<td class="forum_post_second">{$user->avatar}</td>
		</tr>
	{/if}
		<tr>
			<td width="200" class="forum_post_first">{#FORUMS_PR_GROUP#}</td>
			<td class="forum_post_second">{$user->group_name}</td>
		</tr>
	{if $user->postings > 0}
		<tr>
			<td width="200" class="forum_post_first">{#FORUMS_THREAD_VIEW_POSTS#}</td>
			<td class="forum_post_second">{$user->postings} - <a href="index.php?module=forums&amp;show=userpostings&amp;user_id={$user->uid}"><strong>{#FORUMS_SHOW_ALL_POSTINGS#}</strong></a></td>
		</tr>
	{/if}
	{if $user->interests_show==1 && $user->interests}
		<tr>
			<td width="200" class="forum_post_first">{#FORUMS_PR_INTERESTS#}</td>
			<td class="forum_post_second">{$user->interests}</td>
		</tr>
	{/if}
	{if $user->signature_show==1 && $user->signature}
		<tr>
			<td width="200" class="forum_post_first">{#FORUMS_PR_SIGNATURE#}</td>
			<td class="forum_post_second">{$user->signature}</td>
		</tr>
	{/if}
	{if $user->web_site_show==1 && $user->web_site}
		<tr>
			<td width="200" class="forum_post_first">{#FORUMS_PR_WEB#}</td>
			<td class="forum_post_second"><a href="{$user->web_site|escape:html|stripslashes}" target="_blank"><strong>{$user->web_site|escape:html|stripslashes}</strong></a></td>
		</tr>
	{/if}
	{if $user->email_show==1}
		<tr>
			<td width="200" class="forum_post_first">{#FORUMS_PR_EMAIL#}</td>
			<td class="forum_post_second">{$user->email|escape:html|stripslashes}</td>
		</tr>
	{/if}
	{if $user->birthday_show && $user->birthday}
		<tr>
			<td width="200" class="forum_post_first">{#FORUMS_PR_BIRTHDAY#}</td>
			<td class="forum_post_second">{$user->birthday|escape:html|stripslashes}</td>
		</tr>
	{/if}
	{if $user->icq_show==1 && $user->icq}
		<tr>
			<td width="200" class="forum_post_first">{#FORUMS_PR_ICQ#}</td>
			<td class="forum_post_second">{$user->Icq|escape:html|stripslashes}</td>
		</tr>
	{/if}
	{if $user->skype_show==1 && $user->skype}
		<tr>
			<td class="forum_post_first">{#FORUMS_PR_SKYPE#}</td>
			<td class="forum_post_second">{$user->Skype|escape:html|stripslashes}</td>
		</tr>
	{/if}
	{if $user->aim_show==1 && $user->aim}
		<tr>
			<td class="forum_post_first">{#FORUMS_PR_AIM#}</td>
			<td class="forum_post_second">{$user->aim|escape:html|stripslashes}</td>
		</tr>
	{/if}
	{if $user->email_receipt==1 && $smarty.session.user_id}
		<tr>
			<td colspan="2" class="forum_header"><strong>{#FORUMS_PR_SENDMAIL#}</strong></td>
		</tr>
		<tr>
			<td class="forum_post_first">{#FORUMS_PR_MAILSUBJECT#}</td>
			<td class="forum_post_second"><input name="subject" type="text" id="subject" size="40" /></td>
		</tr>
		<tr>
			<td class="forum_post_first">{#FORUMS_PR_MAILTEXT#}</td>
			<td class="forum_post_second"><textarea name="message" cols="40" rows="6" id="message"></textarea></td>
		</tr>
		<tr>
			<td class="forum_post_first">&nbsp;</td>
			<td class="forum_post_second">
				<input type="submit" class="button" value="{#FORUMS_PR_BUTTON_SEND_2#}" />
				<input name="SendMail" type="hidden" id="SendMail" value="1" />
				<input name="ToUser" type="hidden" id="ToUser" value="{$smarty.get.user_id}" />
			</td>
		</tr>
	{/if}
	</table>
</form>
{else}
	{#FORUMS_NO_PUBLIC_PROFILE#}
{/if}