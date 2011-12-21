{include file="$inc_path/userpanel_forums.tpl"}
{include file="$inc_path/header_sthreads.tpl"}
<p class="forum_navi"> {$navigation} </p>
<form action="index.php" method="get">
  <input type="hidden" name="module" value="forums" />
  <input type="hidden" name="show" value="search" />
  <input name="theme_folder" type="hidden" id="theme_folder" value="{$theme_folder}" />
  <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td><table width="100%" border="0" cellpadding="3" cellspacing="1" class="forum_tableborder">
          <tr>
            <td class="forum_header_bolder"> <strong>{#SearchKey#} </strong></td>
            <td class="forum_header_bolder"> <strong>{#SearchUser#} </strong></td>
          </tr>
          <tr>
            <td valign="top" class="forum_info_main"><table border="0" cellspacing="1" cellpadding="1">
              <tr>
                <td>Фраза</td>
                <td><input type="text" name="pattern" size="50" /></td>
              </tr>
              <tr>
                <td>Тип темы</td>
                <td><select name="type">
                  <option value="-1">{#AllTypes#}</option>
                  <option value="1">{#StickThread#}</option>
                  <option value="2">{#Announcement#}</option>
                </select></td>
              </tr>
            </table>
            </td>
            <td valign="top" class="forum_info_main"><input type="text" name="user_name" size="30" />
              <p>
                <input type="radio" name="user_opt" value="1" checked="checked" />
                {#SearchExact#}<br />
                <input type="radio" name="user_opt" value="0" />
                {#SearchSnippet#} </p></td>
          </tr>
        </table></td>
    </tr>
    <tr>
      <td><br />
        <table width="100%" border="0" cellpadding="3" cellspacing="1" class="forum_tableborder">
          <tr>
            <td colspan="4" valign="top" class="forum_header_bolder"><strong>{#SearchOptions#}</strong></td>
          </tr>
          <tr>
            <td valign="top" class="forum_header">{#SearchInForums#} </td>
            <td valign="top" class="forum_header">{#SearchInContent#}</td>
            <td valign="top" class="forum_header">{#SearchDate#} </td>
            <td valign="top" class="forum_header">{#SearchSort#} </td>
          </tr>
          <tr>
            <td valign="top" class="forum_info_main">
                <select name="search_in_forums[]" size="5" id="search_in_forums" multiple="multiple">
                  <option value="0" {if !$smarty.request.search_in_forums}selected{/if}>{#SearchInAllForums#}</option>


								{foreach from=$forums_dropdown item=forum_dropdown}
									{if $forum_dropdown->category_id == 0}


                  <option style="font-weight: bold; font-style: italic;" value="{$forum_dropdown->id}" {if $smarty.get.fid == $forum_dropdown->id} selected="selected" {/if}> {$forum_dropdown->visible_title} </option>


									{else}


                  <option value="{$forum_dropdown->id}" {if $smarty.get.fid == $forum_dropdown->id} selected="selected" {/if}> {$forum_dropdown->visible_title} </option>


									{/if}
								{/foreach}


                </select>
           </td>
            <td valign="top" class="forum_info_main">
              <input type="radio" name="search_post" value="1" checked="checked" />
{#SearchJInContent#}<br />
<input type="radio" name="search_post" value="0" />
{#SearchJInTitle#} </td>
            <td valign="top" class="forum_info_main"> <p>

                  <select name="date">
                    <option value="0">{#AnyDate#}</option>
                    <option value="1" {if $smarty.post.period == 1}selected{/if}>{#DateYesterday#}</option>
                    <option value="7" {if $smarty.post.period == 2}selected{/if}>{#DateLastweek#}</option>
                    <option value="14" {if $smarty.post.period == 5}selected{/if}>{#DateLast2week#}</option>
                    <option value="30" {if $smarty.post.period == 10}selected{/if}>{#DateLastMonth#}</option>
                    <option value="90" {if $smarty.post.period == 20}selected{/if}>{#DateLast3Month#}</option>
                    <option value="180" {if $smarty.post.period == 30}selected{/if}>{#DateLast6Month#}</option>
                    <option value="365" {if $smarty.post.period == 40}selected{/if}>{#DateLastYear#}</option>
                  </select></p>
                <p>
                  <input type="radio" name="b4after" value="0" checked="checked" />
  {#SearchNewer#}<br />
  <input type="radio" name="b4after" value="1" />
  {#SearchOlder#} </p></td>
            <td valign="top" class="forum_info_main"> <p>
                  <select name="search_sort">
                    <option value="1">{#SearchByTopic#}</option>
                    <option value="2">{#SearchByPosts#}</option>
                    <option value="3">{#SearchByAuthor#}</option>
                    <option value="4">{#SearchByForums#}</option>
                    <option value="5">{#SearchByHits#}</option>
                    <option value="6">{#SearchByDate#}</option>
                  </select></p>
                <p>
                  <input type="radio" name="ascdesc" value="ASC" />
  {#SearchSortAsc#}<br />
  <input type="radio" name="ascdesc" value="DESC" checked="checked" />
  {#SearchSortDesc#} </p></td>
          </tr>
        </table></td>
    </tr>
  </table>
  <p align="center">
    <input type="submit" class="button" value="{#StartSearch#}" />
  </p>
</form>