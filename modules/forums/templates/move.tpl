<p class="forum_navi"> {$navigation} &raquo; <a href="{$backlink}">{$item->title|stripslashes}</a></p>
<table width="100%"  border="0" cellpadding="5" cellspacing="1" class="forum_tableborder">
  <tr>
    <td class="forum_header_bolder">{#MoveMsg#}</td>
  </tr>
  <tr>
    <td class="forum_info_main"><strong><a href="{$backlink}">{$item->title|stripslashes}</a></strong>&nbsp;{$lang.f_lbl_moveitem}</td>
  </tr>
  <tr>
    <td class="forum_info_meta">
	<form action="index.php?module=forums&show=move&amp;action=commit" method="post">

<select name="dest">
{if $smarty.get.item eq "c"}
<option value="0"></option>
{/if}
	  {foreach from=$categories_dropdown item=category name=cdd}
	  <optgroup label="{$category->title}">
		{foreach from=$category->forums item=forum_dropdown name=fdd}
	  {if $forum_dropdown->category_id == 0}
	<option style="font-weight: bold; font-style: italic;" value="{$forum_dropdown->id}" {if $smarty.get.fid == $forum_dropdown->id} selected="selected" {/if}>
	  {$forum_dropdown->visible_title}
	  </option>
	  {else}
	  <option value="{$forum_dropdown->id}" {if $smarty.get.fid == $forum_dropdown->id} selected="selected" {/if}>
	   {$forum_dropdown->visible_title}
	  </option>
	  {/if}
		{/foreach}
		</optgroup>
	  {/foreach}
</select>
<input type="submit" class="button" value="{#ButtonGo#}" />
  <input type="hidden" name="item" value="{$smarty.get.item}" />
  <input type="hidden" name="toid" value="{$smarty.get.toid}" />
  <input type="hidden" name="fid" value="{$smarty.get.fid}" />
</form>

	</td>
  </tr>
</table>