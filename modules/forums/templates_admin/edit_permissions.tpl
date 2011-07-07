<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#ModName#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div><br />

{if count($errors)}
<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<tr>
		<td colspan="2" class="second">
			{foreach from=$errors item=error}
				<li>{$error}</li>
			{/foreach}
	  </td>
	</tr>
</table>
{/if}
<form action="index.php?do=modules&action=modedit&mod=forums&moduleaction=permissions&cp={$sess}&g_id={$smarty.request.g_id}&f_id={$smarty.get.f_id}&pop=1&sub=save" method="post">
	<input type="hidden" name="f_id" value="{$smarty.get.f_id}" />
	<input type="hidden" name="g_id" value="{$smarty.request.g_id}" />
	<table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
	<tr>
		<th colspan="2" class="tableheader">{#Perm_ForumsRights#}</th>
	</tr>
	<tr>
		<td width="60%" class="first">{#Perm_viewForum#}</td>
		<td class="second">
			<input type="radio" name="can_see" value="1" {if $permissions[0] == 1 || $permissions[0] == ""}checked="checked"{/if} /> {#Yes#}
			<input type="radio" name="can_see" value="0" {if $permissions[0] == 0 && $permissions[0] != ""}checked="checked"{/if} /> {#No#}
		</td>
	</tr>
	<tr>
		<td class="first">{#Perm_viewTopicOthers#}</td>
		<td class="second">
			<input type="radio" name="can_see_topic" value="1" {if $permissions[1] == 1 || $permissions[1] == ""}checked="checked"{/if} /> {#Yes#}
			<input type="radio" name="can_see_topic" value="0" {if $permissions[1] == 0 && $permissions[1] != ""}checked="checked"{/if} /> {#No#}
		</td>
	</tr>
	<tr>
		<td class="first">{#Perm_downloadAttachments#}</td>
		<td class="second">
			<input type="radio" name="can_download_attachment" value="1" {if $permissions[4] == 1 || $permissions[4] == ""}checked="checked"{/if} /> {#Yes#}
			<input type="radio" name="can_download_attachment" value="0" {if $permissions[4] == 0 && $permissions[4] != ""}checked="checked"{/if} /> {#No#}
		</td>
	</tr>
	<tr>
		<th colspan="2" class="tableheader">{#Perm_PostsRights#}</th>
	</tr>
	<tr>
		<td class="first">{#Perm_createTopics#}</td>
		<td class="second">
			<input type="radio" name="can_create_topic" value="1" {if $permissions[5] == 1 || $permissions[5] == ""}checked="checked"{/if} /> {#Yes#}
			<input type="radio" name="can_create_topic" value="0" {if $permissions[5] == 0 && $permissions[5] != ""}checked="checked"{/if} /> {#No#}
		</td>
	</tr>
	<tr>
		<td class="first">{#Perm_canReplyOwnTopics#}</td>
		<td class="second">
			<input type="radio" name="can_reply_own_topic" value="1" {if $permissions[6] == 1 || $permissions[6] == ""}checked="checked"{/if} /> {#Yes#}
			<input type="radio" name="can_reply_own_topic" value="0" {if $permissions[6] == 0 && $permissions[6] != ""}checked="checked"{/if} /> {#No#}
		</td>
	</tr>
	<tr>
		<td class="first">{#Perm_canReplyOtherTopics#}</td>
		<td class="second">
			<input type="radio" name="can_reply_other_topic" value="1" {if $permissions[7] == 1 || $permissions[7] == ""}checked="checked"{/if} /> {#Yes#}
			<input type="radio" name="can_reply_other_topic" value="0" {if $permissions[7] == 0 && $permissions[7] != ""}checked="checked"{/if} /> {#No#}
		</td>
	</tr>

{if $smarty.get.g_id!=2}

	<tr>
		<td class="first">{#Perm_canPostAttachments#}</td>
		<td class="second">
			<input type="radio" name="can_upload_attachment" value="1" {if $permissions[8] == 1 || $permissions[8] == ""}checked="checked"{/if} /> {#Yes#}
			<input type="radio" name="can_upload_attachment" value="0" {if $permissions[8] == 0 && $permissions[8] != ""}checked="checked"{/if} /> {#No#}
		</td>
	</tr>

	<tr>
		<td class="first">{#Perm_canVoteTopics#}</td>
		<td class="second">
			<input type="radio" name="can_rate_topic" value="1" {if $permissions[9] == 1 || $permissions[9] == ""}checked="checked"{/if} /> {#Yes#}
			<input type="radio" name="can_rate_topic" value="0" {if $permissions[9] == 0 && $permissions[9] != ""}checked="checked"{/if} /> {#No#}
		</td>
	</tr>



	<tr>
		<th colspan="2" class="tableheader">{#Perm_TopicRights#}</th>
	</tr>
	<tr>
		<td class="first">{#Perm_canEditOwnPosts#}</td>
		<td class="second">
			<input type="radio" name="can_edit_own_post" value="1" {if $permissions[10] == 1 || $permissions[10] == ""}checked="checked"{/if} /> {#Yes#}
			<input type="radio" name="can_edit_own_post" value="0" {if $permissions[10] == 0 && $permissions[10] != ""}checked="checked"{/if} /> {#No#}
		</td>
	</tr>
	<tr>
		<td class="first">{#Perm_canDeleteOwnPosts#}</td>
		<td class="second">
			<input type="radio" name="can_delete_own_post" value="1" {if $permissions[11] == 1 && $permissions[11] != ""}checked="checked"{/if} /> {#Yes#}
			<input type="radio" name="can_delete_own_post" value="0" {if $permissions[11] == 0 || $permissions[11] == ""}checked="checked"{/if} /> {#No#}
		</td>
	</tr>
	<tr>
	  <td class="first">{#Perm_canEditOtherPosts#}</td>
	  <td class="second">
	  <input type="radio" name="can_edit_other_post" value="1" {if $permissions[16] == 1 && $permissions[16] != ""}checked="checked"{/if} /> {#Yes#}
	<input type="radio" name="can_edit_other_post" value="0" {if $permissions[16] == 0 || $permissions[16] == ""}checked="checked"{/if} /> {#No#}

	  </td>
    </tr>
	<tr>
	  <td class="first">{#Perm_canDeleteOtherPosts#}</td>
	  <td class="second">
	  <input type="radio" name="can_delete_other_post" value="1" {if $permissions[15] == 1 && $permissions[15] != ""}checked="checked"{/if} /> {#Yes#}
	<input type="radio" name="can_delete_other_post" value="0" {if $permissions[15] == 0 || $permissions[15] == ""}checked="checked"{/if} /> {#No#}

	  </td>
    </tr>
	<tr>
		<td class="first">{#Perm_canMoveOwnTopics#}</td>
		<td class="second">
			<input type="radio" name="can_move_own_topic" value="1" {if $permissions[12] == 1 && $permissions[12] != ""}checked="checked"{/if} /> {#Yes#}
			<input type="radio" name="can_move_own_topic" value="0" {if $permissions[12] == 0 || $permissions[12] == ""}checked="checked"{/if} /> {#No#}
		</td>
	</tr>
	<tr>
		<td class="first">{#Perm_canOpenCloseOwnTopics#}</td>
		<td class="second">
			<input type="radio" name="can_close_open_own_topic" value="1" {if $permissions[13] == 1 && $permissions[13] != ""}checked="checked"{/if} /> {#Yes#}
			<input type="radio" name="can_close_open_own_topic" value="0" {if $permissions[13] == 0 || $permissions[13] == ""}checked="checked"{/if} /> {#No#}
		</td>
	</tr>
	<tr>
		<td class="first">{#Perm_canDeleteOwnTopics#}</td>
		<td class="second">
			<input type="radio" name="can_delete_own_topic" value="1" {if $permissions[14] == 1 && $permissions[14] != ""}checked="checked"{/if} /> {#Yes#}
			<input type="radio" name="can_delete_own_topic" value="0" {if $permissions[14] == 0 || $permissions[14] == ""}checked="checked"{/if} /> {#No#}
		</td>
	</tr>

	
	<tr>
		<td class="first">{#Perm_canOpenTopics#}</td>
		<td class="second">
			<input type="radio" name="can_open_topic" value="1" {if $permissions[17] == 1 && $permissions[17] != ""}checked="checked"{/if} /> {#Yes#}
			<input type="radio" name="can_open_topic" value="0" {if $permissions[17] == 0 || $permissions[17] == ""}checked="checked"{/if} /> {#No#}
		</td>
	</tr>
	
		<tr>
		<td class="first">{#Perm_canCloseTopic#}</td>
		<td class="second">
			<input type="radio" name="can_close_topic" value="1" {if $permissions[18] == 1 && $permissions[18] != ""}checked="checked"{/if} /> {#Yes#}
			<input type="radio" name="can_close_topic" value="0" {if $permissions[18] == 0 || $permissions[18] == ""}checked="checked"{/if} /> {#No#}
		</td>
	</tr>
	
	<tr>
	<th colspan="2" class="tableheader">{#Perm_Modifications#}</th>
	</tr>
	
	<tr>
		<td class="first">{#Perm_canChangeTopicType#}</td>
		<td class="second">
			<input type="radio" name="can_change_topic_type" value="1" {if $permissions[19] == 1 && $permissions[19] != ""}checked="checked"{/if} /> {#Yes#}
			<input type="radio" name="can_change_topic_type" value="0" {if $permissions[19] == 0 || $permissions[19] == ""}checked="checked"{/if} /> {#No#}
		</td>
	</tr>
	
	
	
		<tr>
		<td class="first">{#Perm_canMoveOtherTopics#}</td>
		<td class="second">
			<input type="radio" name="can_move_topic" value="1" {if $permissions[20] == 1 && $permissions[20] != ""}checked="checked"{/if} /> {#Yes#}
			<input type="radio" name="can_move_topic" value="0" {if $permissions[20] == 0 || $permissions[20] == ""}checked="checked"{/if} /> {#No#}
		</td>
	</tr>
	
		<tr>
		<td class="first">{#Perm_canDeleteOtherTopics#}</td>
		<td class="second">
			<input type="radio" name="can_delete_topic" value="1" {if $permissions[21] == 1 && $permissions[21] != ""}checked="checked"{/if} /> {#Yes#}
			<input type="radio" name="can_delete_topic" value="0" {if $permissions[21] == 0 || $permissions[21] == ""}checked="checked"{/if} /> {#No#}
		</td>
	</tr>
{/if}

	
	<tr>
		<th colspan="2" class="selectrow">
			<input name="settoall" type="checkbox" id="settoall" value="1">
			{#Perm_SetToAllGroups#}<br>
			<input class="button" type="submit" value="{#Save#}" />
	  </th>
	</tr>
</table>
</form>

