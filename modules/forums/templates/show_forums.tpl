{include file="$inc_path/userpanel_forums.tpl"}
{include file="$inc_path/header_sthreads.tpl"}

{* Если доступны категории *}
{if count($categories)}
	{foreach from=$categories item=categorie}
		{include file="$inc_path/categs.tpl"}<br />
	{/foreach}

{$stats_user}
<br />

<table width="100"  border="0" align="center" cellpadding="3" cellspacing="1" class="forum_tableborder">
	<tr>
		<td nowrap="nowrap" class="forum_info_main"><img src="{$forum_images}statusicons/forum_new.gif" alt="" hspace="2"  class="absmiddle" /> {#FORUMS_NEW_MESSAGES#}</td>
		<td nowrap="nowrap" class="forum_info_main"><img src="{$forum_images}statusicons/forum_old.gif" alt="" hspace="2"  class="absmiddle" />{#FORUMS_NO_NEW_MESSAGES#}</td>
		<td nowrap="nowrap" class="forum_info_main"><img src="{$forum_images}statusicons/forum_old_lock.gif" alt="" hspace="2" class="absmiddle" />{#FORUMS_FORUM_CLOSED#}</td>
	</tr>
</table>

{* Нет доступных категорий *} 
{else} 
	<strong>{#FORUMS_FORUM_EMPTY_FORUM#}</strong> 
{/if}