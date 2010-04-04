
{strip}
{include file="$inc_path/userpanel_forums.tpl"}
{include file="$inc_path/header_sthreads.tpl"}

{if $smarty.session.user_group != 2}
<p align="center"> <a href="index.php?module=forums&amp;show=myabos">{#ShowAbos#} </a>
&nbsp;|&nbsp; <a href="index.php?module=forums&amp;show=myabos&amp;forum_id={$forum->id}">{#ShowAbosHere#}</a>
{if count($topics)}
&nbsp;|&nbsp; <a href="index.php?module=forums&show=markread&amp;what=forum&amp;forum_id={$forum->id}">{#MarkThreadsRead#} </a> {/if} </p>
{/if}


{include file="$inc_path/tree.tpl"}



<p>{$pages} </p>


{* wenn kategorien vorhanden sind *}
{if count($categories)}
{* die liste der kategorien durchgehen *}

{foreach from=$categories item=categorie}
{include file="$inc_path/categs.tpl"}
<br />
{/foreach}
{/if}

{* kann ein user neuen topic anlegen? *}
{if $forum->permissions.5}
<p style="padding: 2px"> <a class="forum_links" href="index.php?module=forums&amp;show=newtopic&amp;fid={$smarty.get.fid}"> <img border="0" src="{$forum_images}forum/newtopic.gif" alt="{$lang.f_newthema}" /> </a> </p>
{/if}
{if count($topics)}
<table width="100%" border="0" cellpadding="0" cellspacing="1" class="forum_tableborder">
  {assign var=announce_header value=true}
  {assign var=sticky_header value=true}
  {assign var=default_header value=true}
  {foreach from=$topics item=topic name=topic_loop}
  {if $topic.type == TOPIC_TYPE_ANNOUNCE && $announce_header}
  {assign var=announce_header value=false}
  <tr>
    <td colspan="8" class="forum_header_bolder"> {#Announcements#} </td>
  </tr>
  <tr>
    <th colspan="2" class="forum_header ">&nbsp;</th>
    <td class="forum_header"><a href="{$sort_by_theme_link}" class="forum_head"> {#Topic#} </a></td>
    <td align="center" class="forum_header "><a href="{$sort_by_reply_link}" class="forum_head"> {#Replies#} </a></td>
    <td align="center" class="forum_header "><a href="{$sort_by_author_link}" class="forum_head"> {#Author#} </a></td>
    <td align="center" class="forum_header "><a href="{$sort_by_hits_link}" class="forum_head"> {#Hits#} </a></td>
    <td align="center" class="forum_header "><a href="{$sort_by_rating_link}" class="forum_head"> {#Voting#} </a></td>
    <td align="center" nowrap="nowrap" class="forum_header "><a href="{$sort_by_lastpost_link}" class="forum_head"> {#LastThread#} </a></td>
  </tr>
  {elseif $topic.type == TOPIC_TYPE_STICKY && $sticky_header}
  {assign var=sticky_header value=false}
  <tr>
    <td colspan="8" class="forum_header_bolder"> {#TopicsH#}</td>
  </tr>
  <tr>
    <th colspan="2" class="forum_header "></th>
    <td class="forum_header "><a href="{$sort_by_theme_link}" class="forum_head"> {#Topic#} </a></td>
    <td align="center" class="forum_header "><a href="{$sort_by_reply_link}" class="forum_head"> {#Replies#} </a></td>
    <td align="center" class="forum_header "><a href="{$sort_by_author_link}" class="forum_head"> {#Author#} </a></td>
    <td align="center" class="forum_header "><a href="{$sort_by_hits_link}" class="forum_head"> {#Hits#} </a></td>
    <td align="center" class="forum_header "><a href="{$sort_by_rating_link}" class="forum_head"> {#Voting#} </a></td>
    <td align="center" nowrap="nowrap" class="forum_header "><a href="{$sort_by_lastpost_link}" class="forum_head"> {#LastThread#} </a></td>
  </tr>
  {elseif $topic.type == TOPIC_TYPE_NONE && $default_header}
  {assign var=default_header value=false}
  <tr>
    <td colspan="8" class="forum_header_bolder"> {#Topics#}</td>
  </tr>
  <tr>
    <th colspan="2" class="forum_header "></th>
    <td class="forum_header "><a href="{$sort_by_theme_link}" class="forum_head"> {#Topic#} </a></td>
    <td align="center" nowrap="nowrap" class="forum_header "><a href="{$sort_by_reply_link}" class="forum_head">{#Replies#}</a></td>
    <td align="center" nowrap="nowrap" class="forum_header"><a href="{$sort_by_author_link}" class="forum_head"> {#Author#} </a></td>
    <td align="center" nowrap="nowrap" class="forum_header"><a href="{$sort_by_hits_link}" class="forum_head"> {#Hits#} </a></td>
    <td align="center" nowrap="nowrap" class="forum_header"><a href="{$sort_by_rating_link}" class="forum_head"> {#Voting#} </a></td>
    <td align="center" nowrap="nowrap" class="forum_header"><a href="{$sort_by_lastpost_link}" class="forum_head">{#LastThread#}</a></td>
  </tr>
  {/if}
  <tr>
    <td width="10%" class="forum_info_icon">
	{if $topic.opened != 1}
		<img src="{$forum_images}statusicons/must_moderate.gif" alt="{$lang.f_munlock}" border="0" />
	{else}
		{$topic.statusicon}
     {/if}	</td>
    <td width="10%" align="center" class="forum_info_icon">&nbsp; {get_post_icon icon=$topic.posticon theme=$theme}&nbsp; </td>
    <td width="50%" class="forum_info_meta">

	<a class="forum_links" href="index.php?module=forums&amp;show=showtopic&amp;toid={$topic.id}&amp;fid={$forum->id}">{$topic.title|truncate:65:'...'}</a>&nbsp;
	{section name=topic_navigation loop=$topic.navigation_page+1 start=1 max=10}
    	{if $smarty.section.topic_navigation.first}
		<br />
Seite: <a class="forum_links_smaller" href="index.php?module=forums&amp;show=showtopic&amp;toid={$topic.id}&amp;pp=15&amp;page={$smarty.section.topic_navigation.index}&amp;fid={$smarty.get.fid}">{$smarty.section.topic_navigation.index}</a>
{elseif $smarty.section.topic_navigation.last}
<a class="forum_links_smaller" href="index.php?module=forums&amp;show=showtopic&amp;toid={$topic.id}&amp;pp=15&amp;page={$smarty.section.topic_navigation.index}&amp;fid={$smarty.get.fid}">{$smarty.section.topic_navigation.index}</a>
{else}
<a class="forum_links_smaller" href="index.php?module=forums&amp;show=showtopic&amp;toid={$topic.id}&amp;pp=15&amp;page={$smarty.section.topic_navigation.index}&amp;fid={$smarty.get.fid}">{$smarty.section.topic_navigation.index}</a>
	 {/if}&nbsp;
	{/section}

      {if $topic.navigation_page > 10}
      ... <a class="forum_links_smaller" href="index.php?module=forums&amp;show=showtopic&amp;toid={$topic.id}&amp;pp=15&amp;page={$topic.navigation_page}"> {$lang.forum_links_last_page} </a>&nbsp;)
      {elseif $topic.navigation_page > 0}
      &nbsp;
    {/if} </td>
    <td align="center" class="forum_info_meta" style="cursor:pointer" onclick="window.open('index.php?module=forums&amp;show=showposter&amp;tid={$topic.id}&amp;pop=1&amp;theme_folder={$theme_folder}', 'Poster', 'toolbar=no,scrollbars=yes,resizable=yes,width=400,height=400')">	{if ($topic.replies-1) == 0}
        -
    {else} <a href="javascript:;" class="forum_links_small" onclick="window.open('index.php?module=forums&amp;show=showposter&amp;tid={$topic.id}&amp;pop=1&amp;theme_folder={$theme_folder}', 'Poster', 'toolbar=no,scrollbars=yes,resizable=yes,width=400,height=400')">{$topic.replies-1}</a>{/if}</td>
    <td align="center" class="forum_info_main"> {if $topic.Registriert < 2}
        {#Guest#}
        {else} <a class="forum_links_small" href="{$topic.autorlink}">{$topic.autor}</a> {/if} </td>
    <td align="center" class="forum_info_meta"> {$topic.views} </td>
    <td align="center" class="forum_info_main"> {if $topic.rating}<img src="{$forum_images}forum/{$topic.rating}.gif" alt="{$lang.f_prating}" />{else}&nbsp;{/if} </td>
    <td class="forum_info_meta">
	<div align="right" style="white-space:nowrap">

{if $topic.lastposter->datum|date_format:'%d.%m.%Y' == $smarty.now|date_format:'%d.%m.%Y'}
{#Today#},&nbsp;{$topic.lastposter->datum|date_format:'%H:%M'}
{else}
{$topic.lastposter->datum|date_format:$config_vars.DateFormatLastPost}
{/if}
<br />
 {$topic.lastposter->link}
 <a class="forum_links_small" href="index.php?module=forums&amp;show=showtopic&amp;toid={$topic.id}&amp;pp=15&amp;page={$topic.next_page}#pid_{$topic.lastposter->id}"><img class="absmiddle" src="{$forum_images}forum/post_latest.gif" border="0" alt="{$lang.f_latest_post}"></a> </div></td>
  </tr>
  {/foreach}
  <tr>
    <td colspan="8" class="forum_header">
	<table width="100%" cellpadding="2">
        <tr>
          <td><form action="index.php?module=forums&amp;show=showforum&amp;fid={$smarty.get.fid}" method="post">
              <input type="hidden" name="unit" value="d" />
              <input type="hidden" name="fid" value="{$smarty.get.fid}" />
              <select name="period">
                <option value="1" {if $smarty.post.period == 1 || $smarty.get.period == 1}selected{/if}> {#ShowLastSelectDay#}</option>
                <option value="2" {if $smarty.post.period == 2 || $smarty.get.period == 2}selected{/if}> {#ShowLastSelect#} 2 {#ShowLastSelectDays#} </option>
                <option value="5" {if $smarty.post.period == 5 || $smarty.get.period == 5}selected{/if}> {#ShowLastSelect#} 5 {#ShowLastSelectDays#} </option>
                <option value="10" {if $smarty.post.period == 10 || $smarty.get.period == 10}selected{/if}> {#ShowLastSelect#} 10 {#ShowLastSelectDays#} </option>
                <option value="20" {if $smarty.post.period == 20 || $smarty.get.period == 20}selected{/if}> {#ShowLastSelect#} 20 {#ShowLastSelectDays#} </option>
                <option value="30" {if $smarty.post.period == 30 || $smarty.get.period == 30}selected{/if}> {#ShowLastSelect#} 30 {#ShowLastSelectDays#} </option>
                <option value="40" {if $smarty.post.period == 40 || $smarty.get.period == 40}selected{/if}> {#ShowLastSelect#} 40 {#ShowLastSelectDays#} </option>
                <option value="50" {if $smarty.post.period == 50 || $smarty.get.period == 50}selected{/if}> {#ShowLastSelect#} 50 {#ShowLastSelectDays#} </option>
                <option value="100" {if $smarty.post.period == 100 || $smarty.get.period == 100}selected{/if}>{#ShowLastSelect#} 100 {#ShowLastSelectDays#} </option>
                <option value="365" {if $smarty.post.period == 365 || $smarty.get.period == 365}selected{/if}>{#ShowLastSelect#} 365 {#ShowLastSelectDays#}</option>
              </select>
              <select name="sort">
                <option value="desc" {if $smarty.post.sort == 'desc' || $smarty.get.sort == 'desc'}selected{/if}>

                {#Desc#}

                </option>
                <option value="asc" {if $smarty.post.sort == 'asc' || $smarty.get.sort == 'asc'}selected{/if}>

                {#Asc#}

                </option>
              </select>
              <input type="submit" class="button" value="{#Show#}" />
            </form></td>
        </tr>
      </table></td>
  </tr>
</table>
{/if} <br />

{if $smarty.session.user_group != 2}
<p align="center"> <a href="index.php?module=forums&amp;show=myabos">{#ShowAbos#} </a>
&nbsp;|&nbsp; <a href="index.php?module=forums&amp;show=myabos&amp;forum_id={$forum->id}">{#ShowAbosHere#}</a>
{if count($topics)}
&nbsp;|&nbsp; <a href="index.php?module=forums&amp;show=markread&amp;what=forum&amp;forum_id={$forum->id}">{#MarkThreadsRead#} </a> {/if} </p>
{/if}


<p> {$pages} </p>
<p></p>
<table width="100%"  border="0" cellpadding="4" cellspacing="1">
  <tr valign="top">
    <td><table width="350" border="0" cellpadding="4" cellspacing="0" class="forum_tableborder">
        <tr>
          <td class="forum_header_bolder">{#ModsIn#}</td>
        </tr>
        <tr>
          <td class="forum_info_meta">{if $get_mods}
            {$get_mods}
            {else}
            {#NoMods#}
            {/if}</td>
        </tr>
      </table>
      <br />
      {include file="$inc_path/statusicons.tpl"}

    </td>
    <td>
	<div align="right">
        <table width="320" border="0" cellpadding="4" cellspacing="0" class="forum_tableborder">
          <tr>
            <td class="forum_header_bolder">{#GoTo#}</td>
          </tr>
          <tr>
            <td nowrap="nowrap" class="forum_info_meta">
			{include file="$inc_path/selector.tpl"}			</td>
          </tr>
        </table>
        <br />
        <table width="320" border="0" cellpadding="2" cellspacing="0">
          <tr>
            <td><div align="right" class="forum_info_meta"> {if $forum->permissions.4 == 1}
                {#Perm_DowloadAttachments#} <br />
                {else}
                {#Perm_DowloadAttachmentsNo#} <br />
                {/if}
                {if $forum->permissions.5 == 1}
                {#Perm_NewTopic#} <br />
                {else}
                {#Perm_NewTopicNo#} <br />
                {/if}
                {if $forum->permissions.7 == 1}
                {#Perm_ReplyTopics#} <br />
                {else}
                {/if}
                {if $forum->permissions.10 == 1}
                 {#Perm_EditThreads#} <br />
                {/if} </div></td>
          </tr>
        </table>
        <br />
      </div></td>
  </tr>
</table>
</p>
{/strip}