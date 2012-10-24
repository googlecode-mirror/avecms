{include file="$inc_path/userpanel_forums.tpl"}
{include file="$inc_path/header_sthreads.tpl"}

<strong>{#FORUMS_SHOW_LAST_24#}</strong>
<br /><br />
<table width="100%" border="0" cellpadding="0" cellspacing="1" class="forum_tableborder">
	<tr>
		<td class="forum_header" width="30px">&nbsp;</td>
		<td class="forum_header" width="30px">&nbsp;</td>
		<td class="forum_header">{#FORUMS_TOPIC#}</td>
		<td class="forum_header" align="center" width="40px">{#FORUMS_REPLIES#}</td>
		<td class="forum_header" align="center">{#FORUMS_AUTHOR#}</td>
		<td class="forum_header" align="center" width="40px">{#FORUMS_HITS#}</td>
		<td class="forum_header" align="center" width="40px">{#FORUMS_VOTING#}</td>
	</tr>
    {foreach from=$matches item=topic}
	<tr>
		<td class="forum_info_icon">{$topic.statusicon}</td>
		<td class="forum_info_icon">{get_post_icon icon=$topic.posticon theme=$theme}&nbsp;</td>
		<td class="forum_info_meta">
			<a class="forum_links" href="{$topic.link}&amp;high={$smarty.get.pattern}">{$topic.title|stripslashes}</a><br />
			{#FORUMS_PAGE_NAME_FORUMS#}: <a href="{$topic.forumslink}">{$topic.f_title}</a>
		</td>
		<td class="forum_info_meta" align="center">
		{if $topic.replies-1 == 0}
			&nbsp;-&nbsp;
		{else}
			<a href="javascript:;" class="forum_links_small" onclick="window.open('index.php?module=forums&amp;show=showposter&amp;tid={$topic.id}&amp;pop=1&amp;cp_theme={$cp_theme}', 'Poster', 'toolbar=no,scrollbars=yes,resizable=yes,width=400,height=400')">{$topic.replies-1}</a>
		{/if}
		</td>
		<td class="forum_info_main" align="center"><a href="{$topic.autorlink}">{$topic.autor}</a></td>
		<td class="forum_info_meta" align="center">
		{if $topic.views}
			{$topic.views}
		{else}
			&nbsp;
		{/if}
		</td>
		<td class="forum_info_meta" align="center">
		{if $topic.rating}
			<img src="{$forum_images}forum/{$topic.rating}.gif" alt="" />
		{else}
			&nbsp;
		{/if}
		</td>
	</tr>
    {/foreach}
</table>