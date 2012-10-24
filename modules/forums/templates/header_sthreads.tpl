{if $smarty.request.print!=1}
	<table width="100%" border="0" cellpadding="2" cellspacing="1" class="forum_tableborder">
		<tr>
			<td align="center" class="forum_info_meta">
				<a href="index.php?module=forums">{#FORUMS_PAGE_NAME_FORUMS#}</a>
			</td>
			<td align="center" class="forum_info_meta">
				<a href="index.php?module=forums&amp;show=userlist">{#FORUMS_USERS#}</a>
			</td>
			<td align="center" class="forum_info_meta">
				<a {popup trigger="onclick" timeout="20000" sticky=true text=$SearchPop} href="javascript:void(0);">{#FORUMS_FORUMS_SEARCH#}</a>
			</td>
			<td align="center" class="forum_info_meta">
				<a href="index.php?module=forums&amp;show=last24">{#FORUMS_SHOW_LAST_24#}</a>
			</td>
		{if $smarty.session.user_group != 2}
			<td align="center" class="forum_info_meta">
				<a href="index.php?module=forums&amp;show=userpostings&amp;user_id={$smarty.session.user_id}">{#FORUMS_SHOW_MY_POSTINGS#}</a>
			</td>
			<td align="center" class="forum_info_meta">
				<a href="index.php?module=forums&amp;show=showforums&amp;action=markread&amp;what=forum&amp;ReadAll=1">{#FORUMS_MARK_FORUMS_READ#}</a>
			</td>
		{/if}
		</tr>
	</table><br />
{/if}