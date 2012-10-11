<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
{if $smarty.request.moduleaction != "addforum"}
    <div class="HeaderTitle"><h2>{#FORUMS_HEADER_EDIT_FORUM#}</h2></div>
{else}
    <div class="HeaderTitle"><h2>{#FORUMS_HEADER_NEW_FORUM#}</h2></div>
{/if}
    <div class="HeaderText">&nbsp;</div>
</div><br />
<form action="index.php?do=modules&action=modedit&mod=forums&moduleaction=addforum&id={$smarty.request.id}&pop=1&save=1" method="post">
	<input type="hidden" name="f_id" value="{$forum->id}" />
	<input type="hidden" name="c_id" value="{$forum->category_id|default:$smarty.get.id}" />
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr>
			<td colspan="2" class="tableheader">{#FORUMS_FEATURES_FORUM#}</td>
		</tr>
			{if count($errors)}
		<tr>
			<td colspan="2">
				{foreach from=$errors item=error}
					<li>{$error}</li>
				{/foreach}
			</td>
		</tr>
			{/if}
		<tr>
			<td width="40%" class="first"><strong>{#FORUMS_NAME_FORUM#}</strong></td>
			<td class="second">
				<input type="text" name="title" value="{$smarty.post.title|default:$forum->title}" size="50" maxlength="200" />
		    </td>
		</tr>
		<tr>
			<td width="40%" valign="top" class="first"><strong>{#FORUMS_DESCR_FORUM#}</strong></td>
			<td class="second">
				<textarea name="comment" cols="50" rows="5">{$smarty.post.comment|default:$forum->comment}</textarea>
		    </td>
		</tr>
		<tr>
		{if $smarty.request.moduleaction != "addforum"}
		<tr>
			<td width="40%" valign="top" class="first"><strong>{#FORUMS_GROUP_PERM#}</strong><br />
				<small>
					{#FORUMS_GROUP_PERM_INF#}
				</small>
			</td>
			<td class="second">
				{foreach from=$groups item=group}		
					{if @in_array($group->ugroup, $forum->group_id) || @in_array($group->ugroup, $smarty.post.group_id)}
					    <a href="javascript:;" onclick="window.open('index.php?do=modules&action=modedit&mod=forums&moduleaction=permissions&cp={$sess}&g_id={$group->ugroup}&amp;f_id={$forum->id}&pop=1','','left=0,top=0,scrollbars=yes,width=550,height=600');">{$group->groupname}</a><br />
						<input type="hidden" name="group_id[]" value="{$group->ugroup}" />
					{/if}
				{/foreach}
			</td>
		</tr>
		{/if}
		<tr>
			<td width="40%" class="first"><strong>{#FORUMS_FORUM_ACTIVE#}</strong><br />
				<small>
					{#FORUMS_FORUM_DEACTIVE_INF#}
				</small>
			</td>
			<td class="second">
				<select name="active">
					<option value="1" {if $forum->active == 1 || $smarty.request.moduleaction == "addforum"}selected="selected"{/if}>{#FORUMS_YES#}</option>
					<option value="0" {if $forum->active == 0 && $smarty.request.moduleaction != "addforum"}selected="selected"{/if}>{#FORUMS_NO#}</option>
				</select>
			</td>
		</tr>
		<tr>
			<td width="40%" class="first"><strong>{#FORUMS_FORUM_STATUS#}</strong><br />
				<small>
					{#FORUMS_FORUM_CLOSED_INF#}
				</small>
			</td>
			<td class="second">
				<select name="status">
					<option value="0" {if $forum->status == 0}selected="selected"{/if}>{#FORUMS_FORUM_OPENED#}</option>
					<option value="1" {if $forum->status == 1}selected="selected"{/if}>{#FORUMS_FORUM_CLOSED#}</option>
				</select>
			</td>
		</tr>
		<tr>
			<td width="40%" class="first"><strong>{#FORUMS_FN_EMAIL_NEW_TOPICS#}</strong><br />
				<small>
					{#FORUMS_FN_TOPICS_INF#}
				</small>
			</td>
			<td class="second">
				<input name="topic_emails" type="text" id="topic_emails" value="{$forum->topic_emails|escape:"htmlall"}" size="50">
			</td>
		</tr>
		<tr>
			<td width="40%" class="first"><strong>{#FORUMS_FN_EMAIL_NEW_POST#}</strong><br />
				<small>
					{#FORUMS_FN_POST_INF#}
				</small>
			</td>
			<td class="second">
				<input name="post_emails" type="text" id="post_emails" value="{$forum->post_emails|escape:"htmlall"}" size="50">
			</td>
		</tr>
		<tr>
			<td width="40%" class="first"><strong>{#FORUMS_MODERATED#}</strong><br />
				<small>
					{#FORUMS_MODERATED_INF#}
				</small>
			</td>
			<td class="second">
				<input name="moderated" type="checkbox" value="1" {if $forum->moderated==1}checked="checked"{/if} />
			</td>
		</tr>
		<tr>
			<td width="40%" class="first"><strong>{#FORUMS_MODERATED_POST#}</strong><br />
				<small>
					{#FORUMS_MODERATED_POST_INF#}
				</small>
			</td>
			<td class="second">
				<input name="moderated_posts" type="checkbox" value="1" {if $forum->moderated_posts==1}checked="checked"{/if} />
			</td>
		</tr>
		<tr>
			<td width="40%" class="first"><strong>{#FORUMS_FORUM_PASS_ACCESS#}</strong><br />
				<small>
					{#FORUMS_FORUM_PROTECT_INF#}
				</small>
			</td>
			<td class="second">
				<input type="text" name="password" value="{$forum->password_raw}" />
			</td>
		</tr>
		<tr>
			<td colspan="2" class="thirdrow">
			{if $smarty.request.moduleaction != "addforum"}
				<input accesskey="s"  class="button" type="submit" value="{#FORUMS_BUTTON_SAVE#}" />
			{else}
				<input accesskey="s"  class="button" type="submit" value="{#FORUMS_BUTTON_ADD#}" />	
			{/if}	
			</td>
		</tr>
	</table>
</form>