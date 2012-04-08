<!--<link href="../../../templates/cp/css/forum.css" rel="stylesheet" type="text/css" />-->
<table width="100%" border="0" cellpadding="5" cellspacing="1" class="forum_tableborder">
  <tr>
    <td colspan="2" class="forum_header"><strong>Статистика форума </strong></td>
  </tr>
  <tr>
    <td class="forum_info_icon"><img src="{$forum_images}forum/stats.gif" alt="" /></td>
    <td class="forum_info_meta">

<table width="100%" border="0" cellspacing="1" cellpadding="0">
  <tr>
    <td width="100">{#StatsThreads#}</td>
    <td width="120">{$num_threads}</td>
    <td width="160">{#NewestMember#}</td>
    <td><a class="forum_links_small" href="index.php?module=userpage&amp;action=show&amp;uid={$row_user->UserId}"> {$row_user->user_name} </a></td>
  </tr>
  <tr>
    <td>{#StatsPosts#}</td>
    <td>{$num_posts}</td>
    <td>{#LastThread#}:</td>
    <td>
<a class="forum_links_small" href="index.php?module=forums&amp;show=showtopic&amp;toid={$LastPost->topic_id}&amp;pp=15&amp;page={$LastPost->page}#pid_{$LastPost->id}"> {$LastPost->TopicName} </a>,&nbsp;
{if $LastPost->datum|date_format:'%d.%m.%Y' == $smarty.now|date_format:'%d.%m.%Y'}
{#Today#}&nbsp;{$LastPost->datum|date_format:'%H:%M'}
{else}
{$LastPost->datum|date_format:'%d.%m.%Y %H:%M'}
{/if}</td>
  </tr>
  <tr>
    <td>{#Statsmembers#}</td>
    <td>{$num_members} </td>
    <td>{#NewestPosts#}</td>
    <td><a class="forum_links_small" href="index.php?module=forums&amp;show=last24"> {#NewestPostsShow#} </a></td>
  </tr>
</table> </td>
  </tr>
  <tr>
    <td colspan="2" class="forum_header"><strong>Пользователи на сайте </strong></td>
  </tr>
  <tr>
    <td class="forum_info_icon">&nbsp;</td>
    <td class="forum_info_meta">

	<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <tr>
    <td>
	{#UserOnline#}&nbsp;
	{$num_user}&nbsp;
	({#GostsOnline#} {$num_gosts})<br />
	<span class="forum_small">
	{foreach from=$loggeduser item=lu name=lu}
	{if $lu->ZeigeProfil==1}<a class="{if $lu->user_group==1}{else}forum_links_small{/if}" href="index.php?module=userpage&amp;action=show&amp;uid={$lu->uid}">{$lu->uname}</a>
	{else}<span style="font-style:italic">{$lu->uname}</span>{/if}
	{if !$smarty.foreach.lu.last}, {/if}
	{/foreach}
	</span>
	<br />
	 {#GuestsOnline#} {$num_guests}

	 </td>
  </tr>
</table>

	</td>
  </tr>
</table>