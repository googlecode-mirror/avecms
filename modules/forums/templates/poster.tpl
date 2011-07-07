<table width="100%" border="0" cellpadding="4" cellspacing="1" class="forum_tableborder">
	<tr class="forum_header_bolder">
		<td class="theader"><strong>{$lang.f_header_author}</strong></td>
		<td class="theader"><strong>{$lang.f_header_posts}</strong></td>
	</tr>
	{foreach from=$poster item=post}
		<tr class="{cycle name='lp' values='forum_post_second,forum_post_first'}">
			<td><a target="_blank" href="index.php?p=user&amp;id={$post->uid}">{$post->uname}</a></td>
			<td>{$post->ucount}</td>
		</tr>
	{/foreach}
</table>