{include file="$inc_path/userpanel_forums.tpl"}
{include file="$inc_path/header_sthreads.tpl"}

<h1>{#Users#}<br />
  <br />
</h1>
<table width="100%" border="0" cellpadding="4" cellspacing="1" class="forum_tableborder">

  <tr>
    <td class="forum_header"><strong><a href="{$Link_NameSort}" class="forum_head">{#UsersUsername#}{$img_name}</a></strong></td>
    <td align="center" class="forum_header"><strong>{#UsersPN#}</strong></td>
    <td align="center" class="forum_header"><strong>{#UsersWeb#}</strong></td>
    <td width="150" align="center" class="forum_header"><strong><a href="{$Link_RegSort}" class="forum_head">{#UsersReg#}{$img_reg}</a></strong></td>
    <td width="100" align="center" class="forum_header"><strong>{#UseresSearch#}</strong></td>
    <td width="100" align="center" class="forum_header"><strong><a href="{$Link_PostSort}" class="forum_head">{#UsersPosts#}{$img_post}</a></strong></td>
  </tr>
  {foreach from=$user item=u}
  <tr class="{cycle name='d' values='forum_post_first,forum_post_second'}">
    <td>
	{$u->UserLink}	</td>
    <td align="center">
	{if $u->UserPN==''}
	&nbsp;
	{else}
	<a href="{$u->UserPN}">{#UsersPNNew#}</a>
	{/if}	</td>
    <td align="center">
	{if $u->UserWeb==''}
	&nbsp;
	{else}
	<a target="_blank" href="{$u->UserWeb}">{#UsersWeb#}</a>
	{/if}	</td>
    <td align="center">{$u->Registriert|date_format:'%d.%m.%Y'}</td>
    <td align="center">
	{if $u->Posts >= 1}
	<a href="index.php?module=forums&amp;show=userpostings&amp;user_id={$u->BenutzerId}">{#UsersPosts#}</a>
	{else}
	&nbsp;
	{/if}
	</td>
    <td align="center">{$u->Posts}</td>
  </tr>
  {/foreach}
</table>
<p>
{if $pages}
{$pages}
{else}
&nbsp;
{/if}
</p>
