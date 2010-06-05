{include file="$inc_path/userpanel_forums.tpl"}
{include file="$inc_path/header_sthreads.tpl"}


{* wenn eintraege vorhanden sind *}
{if count($categories)}
{* die liste der kategorien durchgehen *}
{foreach from=$categories item=categorie}

{include file="$inc_path/categs.tpl"}
<br />
{/foreach}

{$stats_user}
<br />
<br />

<table width="100"  border="0" align="center" cellpadding="3" cellspacing="1" class="forum_tableborder">
  <tr>
    <td nowrap="nowrap" class="forum_info_main"><img src="{$forum_images}statusicons/forum_new.gif" alt="{$lang.forum_new_messages}" hspace="2"  class="absmiddle" /> {#NewMessages#}</td>
    <td nowrap="nowrap" class="forum_info_main"><img src="{$forum_images}statusicons/forum_old.gif" alt="{$lang.forum_old_messages}" hspace="2"  class="absmiddle" />{#NoNewMessages#}</td>
    <td nowrap="nowrap" class="forum_info_main"><img src="{$forum_images}statusicons/forum_old_lock.gif" alt="{$lang.forum_closed}" hspace="2" class="absmiddle" />{#ForumClosed#} </td>
  </tr>
</table>

{* keine kategorien vorhanden *} {else} <strong>{$lang.f_emptyforum}</strong> {/if}