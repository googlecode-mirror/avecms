<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
{if $smarty.request.moduleaction != "addforum"}
    <div class="HeaderTitle"><h2>{#EditForumHeader#}</h2></div>
{else}
    <div class="HeaderTitle"><h2>{#NewForum#}</h2></div>
{/if}
    <div class="HeaderText">&nbsp;</div>
</div><br />
<form action="index.php?do=modules&action=modedit&mod=forums&moduleaction=addforum&id={$smarty.request.id}&pop=1&save=1" method="post">
	<input type="hidden" name="f_id" value="{$forum->id}" />
	<input type="hidden" name="c_id" value="{$forum->category_id|default:$smarty.get.id}" />
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
		<tr>
		<td colspan="2" class="tableheader">{#ForumsSet#}</td>
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
				<td width="40%" class="first"><strong>{#Title#}</strong></td>
				<td class="second">
					<input type="text" name="title" value="{$smarty.post.title|default:$forum->title}" size="50" maxlength="200" />
			  </td>
			</tr>
			<tr>
				<td width="40%" valign="top" class="first"><strong>{#Fdescr#}</strong></td>
				<td class="second">
					<textarea name="comment" cols="50" rows="5">{$smarty.post.comment|default:$forum->comment}</textarea>
			  </td>
			</tr>
		{if $smarty.request.moduleaction != "addforum"}
			<tr>
				<td width="40%" valign="top" class="first"><strong>{#GroupPerm#}</strong><br />
					<small>
						{#GroupPermInf#}
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
				<td width="40%" class="first"><strong>{#Factive#}</strong><br />
					<small>
						{#FdeacInf#}
					</small>
				</td>
				<td class="second">
					<select name="active">
						<option value="1" {if $forum->active == 1 || $smarty.request.moduleaction == "addforum"}selected="selected"{/if}>{#Yes#}</option>
						<option value="0" {if $forum->active == 0 && $smarty.request.moduleaction != "addforum"}selected="selected"{/if}>{#No#}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td width="40%" class="first"><strong>{#Fstatus#}</strong><br />
					<small>
						{#FclosedInf#}
					</small>
				</td>
				<td class="second">
					<select name="status">
						<option value="0" {if $forum->status == 0}selected="selected"{/if}>{#Opened#}</option>
						<option value="1" {if $forum->status == 1}selected="selected"{/if}>{#Closed#}</option>
					</select>
				</td>
			</tr>
			<tr>
				<td width="40%" class="first"><strong>{#FnEmails#}</strong><br />
					<small>
						{#FnotiInf#}
					</small>
				</td>
				<td class="second"><input name="topic_emails" type="text" id="topic_emails" value="{$forum->topic_emails|escape:"htmlall"}" size="50"></td>
			</tr>
			<tr>
				<td width="40%" class="first"><strong>{#FnEmails2#}</strong><br />
					<small>
						{#FnotiEmailInf#}
					</small>
				</td>
				<td class="second"><input name="post_emails" type="text" id="post_emails" value="{$forum->post_emails|escape:"htmlall"}" size="50"></td>
			</tr>
			<tr>
				<td width="40%" class="first"><strong>{#FisMod#}</strong><br />
					<small>
						{#FmodsInf#}
					</small>
				</td>
				<td class="second">
					<input name="moderated" type="checkbox" value="1" {if $forum->moderated==1}checked="checked"{/if} />
				</td>
			</tr>
			<tr>
				<td width="40%" class="first"><strong>{#FpostsMod#}</strong><br />
					<small>
						{#FmodsInf2#}
					</small>
				</td>
				<td class="second">
					<input name="moderated_posts" type="checkbox" value="1" {if $forum->moderated_posts==1}checked="checked"{/if} />
				</td>
			</tr>
			<tr>
				<td width="40%" class="first"><strong>{#Fpass#}</strong><br />
					<small>
						{#FprotectInf#}
					</small>
				</td>
				<td class="second">
					<input type="text" name="password" value="{$forum->password_raw}" />
				</td>
			</tr>
			<tr>
				<td colspan="2" class="thirdrow">
					<input accesskey="s"  class="button" type="submit" value="{#Save#}" />
				</td>
			</tr>
	</table>
</form>