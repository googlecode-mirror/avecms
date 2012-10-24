{include file="$inc_path/userpanel_forums.tpl"}
{include file="$inc_path/header_sthreads.tpl"}
<p class="forum_navi">{$navigation}</p>
<form action="index.php" method="get">
	<input type="hidden" name="module" value="forums" />
	<input type="hidden" name="show" value="search" />
	<input name="theme_folder" type="hidden" id="theme_folder" value="{$theme_folder}" />
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
		<tr>
			<td>
				<table width="100%" border="0" cellpadding="3" cellspacing="1" class="forum_tableborder">
					<tr>
						<td class="forum_header_bolder"> <strong>{#FORUMS_SEARCH_KEY#}</strong></td>
						<td class="forum_header_bolder"> <strong>{#FORUMS_SEARCH_USER#}</strong></td>
					</tr>
					<tr>
						<td valign="top" class="forum_info_main">
							<table border="0" cellspacing="1" cellpadding="1">
								<tr>
									<td>{#FORUMS_KEY_WORD#}</td>
									<td><input type="text" name="pattern" size="50" /></td>
								</tr>
								<tr>
									<td>{#FORUMS_THEME_TYPE#}</td>
									<td>
										<select name="type">
											<option value="-1">{#FORUMS_ALL_TYPES#}</option>
											<option value="1">{#FORUMS_STICK_THREAD#}</option>
											<option value="2">{#FORUMS_ANNOUNCEMENT#}</option>
										</select>
									</td>
								</tr>
							</table>
						</td>
						<td valign="top" class="forum_info_main">
							<input type="text" name="user_name" size="30" />
							<p>
							<input type="radio" name="user_opt" value="1" checked="checked" />
							{#FORUMS_SEARCH_EXACT#}<br />
							<input type="radio" name="user_opt" value="0" />
							{#FORUMS_SEARCH_SNIPPET#}
							</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
		<tr>
			<td><br />
				<table width="100%" border="0" cellpadding="3" cellspacing="1" class="forum_tableborder">
					<tr>
						<td colspan="4" valign="top" class="forum_header_bolder">
							<strong>{#FORUMS_SEARCH_OPTIONS#}</strong>
						</td>
					</tr>
					<tr>
						<td valign="top" class="forum_header">{#FORUMS_SEARCH_IN_FORUMS#} </td>
						<td valign="top" class="forum_header">{#FORUMS_SEARCH_IN_CONTENT#}</td>
						<td valign="top" class="forum_header">{#FORUMS_SEARCH_DATE#}</td>
						<td valign="top" class="forum_header">{#FORUMS_SEARCH_SORT#}</td>
					</tr>
					<tr>
						<td valign="top" class="forum_info_main">
							<select name="search_in_forums[]" size="5" id="search_in_forums" multiple="multiple">
								<option value="0" {if !$smarty.request.search_in_forums}selected{/if}>{#FORUMS_SEARCH_IN_ALL_FORUMS#}</option>
							{foreach from=$forums_dropdown item=forum_dropdown}
							{if $forum_dropdown->category_id == 0}
								<option style="font-weight: bold; font-style: italic;" value="{$forum_dropdown->id}" {if $smarty.get.fid == $forum_dropdown->id} selected="selected" {/if}>{$forum_dropdown->visible_title}</option>
							{else}
								<option value="{$forum_dropdown->id}" {if $smarty.get.fid == $forum_dropdown->id} selected="selected" {/if}> {$forum_dropdown->visible_title}</option>
							{/if}
							{/foreach}
							</select>
						</td>
						<td valign="top" class="forum_info_main">
							<input type="radio" name="search_post" value="1" checked="checked" />{#FORUMS_SEARCH_JIN_CONTENT#}<br />
							<input type="radio" name="search_post" value="0" />{#FORUMS_SEARCH_JIN_TITLE#}
						</td>
						<td valign="top" class="forum_info_main"> 
							<p>
							<select name="date">
								<option value="0">{#FORUMS_SEARCH_ANY_DATE#}</option>
								<option value="1" {if $smarty.post.period == 1}selected{/if}>{#FORUMS_SEARCH_DATE_YESTERDAY#}</option>
								<option value="7" {if $smarty.post.period == 2}selected{/if}>{#FORUMS_SEARCH_DATE_LAST_WEEK#}</option>
								<option value="14" {if $smarty.post.period == 5}selected{/if}>{#FORUMS_SEARCH_DATE_LAST_2_WEEK#}</option>
								<option value="30" {if $smarty.post.period == 10}selected{/if}>{#FORUMS_SEARCH_DATE_LAST_MONTH#}</option>
								<option value="90" {if $smarty.post.period == 20}selected{/if}>{#FORUMS_SEARCH_DATE_LAST_3_MONTH#}</option>
								<option value="180" {if $smarty.post.period == 30}selected{/if}>{#FORUMS_SEARCH_DATE_LAST_6_MONTH#}</option>
								<option value="365" {if $smarty.post.period == 40}selected{/if}>{#FORUMS_SEARCH_DATE_LAST_YEAR#}</option>
							</select>
							</p>
							<p>
								<input type="radio" name="b4after" value="0" checked="checked" />{#FORUMS_SEARCH_NEWER#}<br />
								<input type="radio" name="b4after" value="1" />{#FORUMS_SEARCH_OLDER#}
							</p>
						</td>
						<td valign="top" class="forum_info_main">
							<p>
							<select name="search_sort">
								<option value="1">{#FORUMS_SEARCH_BY_TOPIC#}</option>
								<option value="2">{#FORUMS_SEARCH_BY_POSTS#}</option>
								<option value="3">{#FORUMS_SEARCH_By_AUTHOR#}</option>
								<option value="4">{#FORUMS_SEARCH_BY_FORUMS#}</option>
								<option value="5">{#FORUMS_SEARCH_BY_HITS#}</option>
								<option value="6">{#FORUMS_SEARCH_BY_DATE#}</option>
							</select>
							</p>
							<p>
								<input type="radio" name="ascdesc" value="ASC" />{#FORUMS_SEARCH_SORT_ASC#}<br />
								<input type="radio" name="ascdesc" value="DESC" checked="checked" />{#FORUMS_SEARCH_SORT_DESC#}
							</p>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
	<p align="center">
		<input type="submit" class="button" value="{#FORUMS_START_SEARCH#}" />
	</p>
</form>