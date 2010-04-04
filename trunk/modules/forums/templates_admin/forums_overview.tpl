{strip}
<div class="pageHeaderTitle" style="padding-top: 7px;">
  <div class="h_module"></div>
  <div class="HeaderTitle"><h2>{#ModName#}</h2></div>
  <div class="HeaderText">&nbsp;</div>
</div><br />

{include file="$source/forum_topnav.tpl"}

{if !$categories}
  <strong>{#NoCats#}!</strong><br />
{/if}

{if count($errors)}
  {foreach from=$errors item=error}
    <li>{$error}</li><br />
  {/foreach}
{/if}<br />

<div class="infobox">
  <a href="javascript:void(0);" onclick="window.open('index.php?do=modules&action=modedit&mod=forums&moduleaction=addcategory&cp={$sess}&id={$forum->id}&pop=1','fo','width=820,height=600,scrollbars=yes,left=0,top=0')">&raquo;&nbsp;{#CatNew#}</a>
</div><br />

{if $categories}
<form action="index.php?do=modules&action=modedit&mod=forums&moduleaction=1&cp={$sess}&sub=save&what=position" method="post">
<table width="100%"  border="0" cellspacing="1" cellpadding="8" class="tableborder">

  <tr class="tableheader">
    <td colspan="3">{#Descr#}</td>
    <td>{#Posi#}</td>
    <td width="1%" colspan="5">{#Actions#}</td>
  </tr>

  {foreach from=$categories item=category}
    <tr nowrap class="second">
      <td colspan="3"><h4 class="forum">{$category->title}</h4><br />
        {$category->comment}
      </td>

      <td align="center"><input type="hidden" name="c_id[]" value="{$category->id}" />
        <input type="text" name="c_position[{$category->id}]" size="4" maxlength="3" value="{$category->position}" />
      </td>

      <td>
        <a title="{#EditCateg#}" href="javascript:void(0);" onclick="window.open('index.php?do=modules&action=modedit&mod=forums&moduleaction=edit_category&cp={$sess}&id={$category->id}&pop=1','fo','width=820,height=600,scrollbars=yes,left=0,top=0')"><img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a>
      </td>

      <td>&nbsp;</td>

      <td>
        <a title="{#NewForum#}" href="javascript:void(0);" onclick="window.open('index.php?do=modules&action=modedit&mod=forums&moduleaction=addforum&amp;id={$category->id}&pop=1','fo','width=820,height=600,scrollbars=yes,left=0,top=0')"><img src="{$tpl_dir}/images/icon_add.gif" alt="" border="0" /></a>
      </td>

      <td>&nbsp;</td>

      <td>
        <a title="{#DelCateg#}" onclick="return confirm('{#DelCategC#}')" href="index.php?do=modules&action=modedit&mod=forums&moduleaction=delcategory&amp;id={$category->id}&cp={$sess}"><img src="{$tpl_dir}/images/icon_18.gif" alt="" border="0" /></a>
      </td>
    </tr>

    {if count($category->forums)}
      {foreach from=$category->forums item=forum}
        <tr class="first">
          <td><strong>{$forum->visible_title} </strong>
              <div style="padding-left:10px">
                <small>{$forum->comment|truncate:'100'}</small>
              </div>
            </td>

            <td width="10%" nowrap align="center">
              {if $forum->status == 1}
                {$langadmin.forum_status_closed}
                {else}
                {$langadmin.forum_status_open}
              {/if}
            </td>

            <td width="10%" align="center">{if $forum->active == 1}{$langadmin.active}{else}{$langadmin.inactive}{/if}</td>

            <td width="10%" align="center">
              <input type="hidden" name="f_id[]" value="{$forum->id}" />
              <input type="text" name="f_position[{$forum->id}]" value="{$forum->position}" size="4" maxlength="4" />
            </td>

            <td>
              <a title="{#EditForum#}" href="javascript:void(0);" onclick="window.open('index.php?do=modules&action=modedit&mod=forums&moduleaction=edit_forum&cp={$sess}&id={$forum->id}&pop=1','fo','width=820,height=600,scrollbars=yes,left=0,top=0')"><img src="{$tpl_dir}/images/icon_edit.gif" alt="" border="0" /></a>
            </td>

            <td>
              {if $forum->status == 0}
                <a title="{#CloseForum#}" href="index.php?do=modules&action=modedit&mod=forums&moduleaction=closeforum&cp={$sess}&id={$forum->id}"><img src="{$tpl_dir}/images/icon_unlock.gif" alt="" border="0" /></a>
              {else}
                <a title="{#OpenForum#}" href="index.php?do=modules&action=modedit&mod=forums&moduleaction=openforum&cp={$sess}&id={$forum->id}"><img src="{$tpl_dir}/images/icon_lock.gif" alt="" border="0" /></a>
              {/if}
            </td>

            <td>
              <a title="{#CatNew#}" href="javascript:void(0);" onclick="window.open('index.php?do=modules&action=modedit&mod=forums&moduleaction=addcategory&cp={$sess}&id={$forum->id}&pop=1','fo','width=820,height=600,scrollbars=yes,left=0,top=0')"><img src="{$tpl_dir}/images/icon_6.gif" alt="" border="0" /></a>
            </td>

            <td>
              <a title="{#IncMods#}" href="javascript:void(0);" onclick="window.open('index.php?do=modules&action=modedit&mod=forums&moduleaction=mods&id={$forum->id}&cp={$sess}&pop=1','fo','width=820,height=600,scrollbars=yes,left=0,top=0')"><img src="{$tpl_dir}/images/icon_22.gif" alt="" border="0" /></a>
            </td>

            <td>
              <a title="{#DelForum#}" onclick="return confirm('{#DelForumC#}')" href="index.php?do=modules&action=modedit&mod=forums&moduleaction=delete_forum&id={$forum->id}&cp={$sess}"><img src="{$tpl_dir}/images/icon_18.gif" alt="" border="0" /></a>
            </td>
        </tr>

        {foreach from=$forum->categories item=sub_category}
          <tr>
            <td class="first">
              - - <a class="link" href="index.php?do=modules&action=modedit&mod=forums&moduleaction=1&cp={$sess}&id={$forum->id}">{$sub_category->title}</a>
            </td>

            <td colspan="9" class="first">{$sub_category->comment}</td>
          </tr>
        {/foreach}

      {/foreach}
    {/if}
  {/foreach}

  <tr>
    <td colspan="9" class="second">
      <input name="subaction" type="hidden" id="subaction" value="{$smarty.request.action}">
      <input name="what" type="hidden" id="what" value="{$smarty.request.what}">
      <input name="id" type="hidden" id="id" value="{$smarty.request.id}">
      <input name="area" type="hidden" id="area" value="{$smarty.request.area}"><input accesskey="s" class="button" type="submit" value="{#Save#}" />
    </td>
  </tr>
</table>
</form>
{/if}
{/strip}