{include file="$inc_path/userpanel_forums.tpl"}
{include file="$inc_path/header_sthreads.tpl"}

<p>
	<table width="100%"  border="0" cellspacing="0" cellpadding="0">
		<tr>
			<td>
				<a class="forum_links_navi" href="index.php?module=forums">{#FORUMS_PAGE_NAME_FORUMS#}</a> {#FORUMS_FORUM_SEP#}{#FORUMS_POSTS_FROM#} <a class="forum_links_navi" href="index.php?module=forums&amp;show=userprofile&amp;user_id={$smarty.request.user_id}">{$poster->Poster}</a><strong> ({$post_count})</strong>
			</td>
    		<td>
    			<div align="right">
					{$pages}
					<form method="get">
						<select name="pp">
							{section name=pps loop=76 step=5 start=15}
								<option value="{$smarty.section.pps.index}" {if $smarty.request.pp == $smarty.section.pps.index}selected="selected"{/if}>
									{$smarty.section.pps.index} {#FORUMS_ON_PAGE#}
								</option>
							{/section}
						</select>
						<input type="submit" class="button" value="{#FORUMS_BUTTON_GO#}">
						<input type="hidden" name="module" value="forums" />
						<input type="hidden" name="show" value="userpostings" />
						<input type="hidden" name="user_id" value="{$smarty.request.user_id}" />
					</form>
				</div>
			</td>
		</tr>
	</table>
</p><br />

{foreach from=$matches item=post name=post}
	<table width="100%" border="0" cellpadding="4" cellspacing="1" class="forum_tableborder">
		<tr>
			<td class="forum_header_bolder">
				<strong>{#FORUMS_SHOW_POSTS_THREAD#}</strong>
				{if $post->flink=='no'}
					{$post->topic_title|truncate:10}
				{else}
					<a class="forum_links_cat" style="text-decoration:underline" href="index.php?module=forums&amp;show=showtopic&amp;toid={$post->topic_id}&amp;fid={$post->forum_id}">{$post->topic_title|stripslashes}</a>
				{/if}
			</td>
		</tr>
		<tr>
			<td width="75%" valign="top" class="forum_post_second">
				{if $post->title != ""}
					<strong>{$post->title}</strong><br />
				{/if}
				{$post->message}
			</td>
		</tr>
		<tr>
			<td class="lastthreads_first">
				<div align="right">
					{if $post->datum|date_format:'%d.%m.%Y' == $smarty.now|date_format:'%d.%m.%Y'}
						{#Today#},&nbsp;{$post->datum|date_format:$smarty.config.FORUMS_DATE_FORMAT_TIME_THREAD|pretty_date}
					{else}
						{$post->datum|date_format:$smarty.config.FORUMS_DATE_FORMAT_TIME_THREAD|pretty_date}
					{/if}
					{if $post->flink=='no'}
					{else}
						&nbsp;|&nbsp;{#FORUMS_PAGE_NAME_FORUMS#}:
						<a href="index.php?module=forums&show=showforum&fid={$post->forum_id}">{$post->forum_title}</a>
					{/if}
				</div>
			</td>
		</tr>
	</table><br />
{/foreach}

<table width="100%"  border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<div align="right">
				{$pages}
				<form method="get">
					<select name="pp">
						{section name=pps loop=76 step=5 start=15}
							<option value="{$smarty.section.pps.index}" {if $smarty.request.pp == $smarty.section.pps.index}selected="selected"{/if}>{$smarty.section.pps.index} {#FORUMS_ON_PAGE#}</option>
						{/section}
					</select>
					<input type="submit" class="button" value="{#FORUMS_BUTTON_GO#}">
					<input type="hidden" name="module" value="forums" />
					<input type="hidden" name="show" value="userpostings" />
					<input type="hidden" name="user_id" value="{$smarty.request.user_id}" />
				</form>
			</div>
		</td>
	</tr>
</table>