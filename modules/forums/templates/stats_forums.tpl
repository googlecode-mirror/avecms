<table width="100%" border="0" cellpadding="5" cellspacing="1" class="forum_tableborder">
	<tr>
		<td colspan="2" class="forum_header">
			<strong>{#FORUMS_STATS_FORUM#}</strong>
		</td>
	</tr>
	<tr>
		<td class="forum_info_icon"><img src="{$forum_images}forum/stats.gif" alt="" /></td>
		<td class="forum_info_meta">
			<table width="100%" border="0" cellspacing="1" cellpadding="0">
				<tr>
					<td width="100">{#FORUMS_STATS_THREADS#}</td>
					<td width="120">{$num_threads}</td>
					<td width="160">{#FORUMS_NEWEST_MEMBER#}</td>
					<td>
						<a class="forum_links_small" href="index.php?module=forums&show=userprofile&user_id={$row_user->UserId}"> {$row_user->user_name}</a>
					</td>
				</tr>
				<tr>
					<td>{#FORUMS_STATS_POSTS#}</td>
					<td>{$num_posts}</td>
					<td>{#FORUMS_LAST_THREAD#}:</td>
					<td>
						<a class="forum_links_small" href="index.php?module=forums&amp;show=showtopic&amp;toid={$LastPost->topic_id}&amp;pp=15&amp;page={$LastPost->page}#pid_{$LastPost->id}"> {$LastPost->TopicName} </a>,&nbsp;
					{if $LastPost->datum|date_format:'%d.%m.%Y' == $smarty.now|date_format:'%d.%m.%Y'}
						{#FORUMS_TODAY#}&nbsp;{$LastPost->datum|date_format:'%H:%M'}
					{else}
						{$LastPost->datum|date_format:'%d.%m.%Y %H:%M'}
					{/if}
					</td>
				</tr>
				  <tr>
					<td>{#FORUMS_STATSMEMBERS#}</td>
					<td>{$num_members}</td>
					<td>{#FORUMS_NEWEST_POSTS#}</td>
					<td>
						<a class="forum_links_small" href="index.php?module=forums&amp;show=last24">{#FORUMS_NEWEST_POSTS_SHOW#}</a>
					</td>
				  </tr>
			</table> 
		</td>
	</tr>
	<tr>
		<td colspan="2" class="forum_header">
			<strong>{#FORUMS_STATS_USER#}</strong>
		</td>
	</tr>
	<tr>
		<td class="forum_info_icon">&nbsp;</td>
		<td class="forum_info_meta">
			<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<tr>
					<td>
						{#FORUMS_USER_ONLINE#}&nbsp;{$num_user}&nbsp;({#FORUMS_GOSTS_ONLINE#} {$num_gosts})<br />
						<span class="forum_small">
					{foreach from=$loggeduser item=lu name=lu}
						{if $lu->show_profile==1}
							<a class="{if $lu->user_group==1}{else}forum_links_small{/if}" href="index.php?module=forums&show=userprofile&user_id={$lu->uid}">{$lu->uname}</a>
						{else}
							<span style="font-style:italic">{$lu->uname}</span>
						{/if}
						{if !$smarty.foreach.lu.last}, {/if}
					{/foreach}
						</span>
						<br />
						 {#FORUMS_GUESTS_ONLINE#} {$num_guests}
					</td>
				</tr>
			</table>
		</td>
	</tr>
</table>