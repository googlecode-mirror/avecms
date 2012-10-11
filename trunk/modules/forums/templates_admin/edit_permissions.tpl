<div class="pageHeaderTitle" style="padding-top: 7px;">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#FORUMS_HEADER_PERM_FORUM#}</h2></div>
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
		<th colspan="2" class="tableheader">{#FORUMS_HEADER_PERM_FORUMS#}</th>
	</tr>
	<tr>
		<td width="60%" class="first">{#FORUMS_PERM_VIEW_FORUM#}</td>
		<td class="second">
			<input type="radio" name="can_see" value="1" {if $permissions[0] == 1 || $permissions[0] == ""}checked="checked"{/if} /> {#FORUMS_YES#}
			<input type="radio" name="can_see" value="0" {if $permissions[0] == 0 && $permissions[0] != ""}checked="checked"{/if} /> {#FORUMS_NO#}
		</td>
	</tr>
	<tr>
		<td class="first">{#FORUMS_PERM_VIEW_FORUM_OTHERS#}</td>
		<td class="second">
			<input type="radio" name="can_see_topic" value="1" {if $permissions[1] == 1 || $permissions[1] == ""}checked="checked"{/if} /> {#FORUMS_YES#}
			<input type="radio" name="can_see_topic" value="0" {if $permissions[1] == 0 && $permissions[1] != ""}checked="checked"{/if} /> {#FORUMS_NO#}
		</td>
	</tr>
	<tr>
		<td class="first">{#FORUMS_PERM_DOWNLOAD_ATTACHMENT#}</td>
		<td class="second">
			<input type="radio" name="can_download_attachment" value="1" {if $permissions[4] == 1 || $permissions[4] == ""}checked="checked"{/if} /> {#FORUMS_YES#}
			<input type="radio" name="can_download_attachment" value="0" {if $permissions[4] == 0 && $permissions[4] != ""}checked="checked"{/if} /> {#FORUMS_NO#}
		</td>
	</tr>
	<tr>
		<th colspan="2" class="tableheader">{#FORUMS_HEADER_PERM_MSG_POSTS#}</th>
	</tr>
	<tr>
		<td class="first">{#FORUMS_PERM_CREATE_TOPICS#}</td>
		<td class="second">
			<input type="radio" name="can_create_topic" value="1" {if $permissions[5] == 1 || $permissions[5] == ""}checked="checked"{/if} /> {#FORUMS_YES#}
			<input type="radio" name="can_create_topic" value="0" {if $permissions[5] == 0 && $permissions[5] != ""}checked="checked"{/if} /> {#FORUMS_NO#}
		</td>
	</tr>
	<tr>
		<td class="first">{#FORUMS_PERM_CAN_REPLY_OWN_TOPICS#}</td>
		<td class="second">
			<input type="radio" name="can_reply_own_topic" value="1" {if $permissions[6] == 1 || $permissions[6] == ""}checked="checked"{/if} /> {#FORUMS_YES#}
			<input type="radio" name="can_reply_own_topic" value="0" {if $permissions[6] == 0 && $permissions[6] != ""}checked="checked"{/if} /> {#FORUMS_NO#}
		</td>
	</tr>
	<tr>
		<td class="first">{#FORUMS_PERM_CAN_REPLY_OTHER_TOPICS#}</td>
		<td class="second">
			<input type="radio" name="can_reply_other_topic" value="1" {if $permissions[7] == 1 || $permissions[7] == ""}checked="checked"{/if} /> {#FORUMS_YES#}
			<input type="radio" name="can_reply_other_topic" value="0" {if $permissions[7] == 0 && $permissions[7] != ""}checked="checked"{/if} /> {#FORUMS_NO#}
		</td>
	</tr>
{if $smarty.get.g_id!=2}
	<tr>
		<td class="first">{#FORUMS_PERM_CAN_POST_ATTACHMENTS#}</td>
		<td class="second">
			<input type="radio" name="can_upload_attachment" value="1" {if $permissions[8] == 1 || $permissions[8] == ""}checked="checked"{/if} /> {#FORUMS_YES#}
			<input type="radio" name="can_upload_attachment" value="0" {if $permissions[8] == 0 && $permissions[8] != ""}checked="checked"{/if} /> {#FORUMS_NO#}
		</td>
	</tr>
	<tr>
		<td class="first">{#FORUMS_PERM_CAN_VOTE_TOPICS#}</td>
		<td class="second">
			<input type="radio" name="can_rate_topic" value="1" {if $permissions[9] == 1 || $permissions[9] == ""}checked="checked"{/if} /> {#FORUMS_YES#}
			<input type="radio" name="can_rate_topic" value="0" {if $permissions[9] == 0 && $permissions[9] != ""}checked="checked"{/if} /> {#FORUMS_NO#}
		</td>
	</tr>
	<tr>
		<th colspan="2" class="tableheader">{#FORUMS_HEADER_PERM_MSG_TOPIC#}</th>
	</tr>
	<tr>
		<td class="first">{#FORUMS_PERM_CAN_EDIT_OWN_POSTS#}</td>
		<td class="second">
			<input type="radio" name="can_edit_own_post" value="1" {if $permissions[10] == 1 || $permissions[10] == ""}checked="checked"{/if} /> {#FORUMS_YES#}
			<input type="radio" name="can_edit_own_post" value="0" {if $permissions[10] == 0 && $permissions[10] != ""}checked="checked"{/if} /> {#FORUMS_NO#}
		</td>
	</tr>
	<tr>
		<td class="first">{#FORUMS_PERM_CAN_DEL_OWN_POSTS#}</td>
		<td class="second">
			<input type="radio" name="can_delete_own_post" value="1" {if $permissions[11] == 1 && $permissions[11] != ""}checked="checked"{/if} /> {#FORUMS_YES#}
			<input type="radio" name="can_delete_own_post" value="0" {if $permissions[11] == 0 || $permissions[11] == ""}checked="checked"{/if} /> {#FORUMS_NO#}
		</td>
	</tr>
	<tr>
	    <td class="first">{#FORUMS_PERM_CAN_EDIT_OTHER_POSTS#}</td>
	    <td class="second">
			<input type="radio" name="can_edit_other_post" value="1" {if $permissions[16] == 1 && $permissions[16] != ""}checked="checked"{/if} /> {#FORUMS_YES#}
			<input type="radio" name="can_edit_other_post" value="0" {if $permissions[16] == 0 || $permissions[16] == ""}checked="checked"{/if} /> {#FORUMS_NO#}
		</td>
    </tr>
	<tr>
		<td class="first">{#FORUMS_PERM_CAN_DEL_OTHER_POSTS#}</td>
		<td class="second">
			<input type="radio" name="can_delete_other_post" value="1" {if $permissions[15] == 1 && $permissions[15] != ""}checked="checked"{/if} /> {#FORUMS_YES#}
			<input type="radio" name="can_delete_other_post" value="0" {if $permissions[15] == 0 || $permissions[15] == ""}checked="checked"{/if} /> {#FORUMS_NO#}
		</td>
    </tr>
	<tr>
		<td class="first">{#FORUMS_PERM_CAN_MOVE_OWN_TOPICS#}</td>
		<td class="second">
			<input type="radio" name="can_move_own_topic" value="1" {if $permissions[12] == 1 && $permissions[12] != ""}checked="checked"{/if} /> {#FORUMS_YES#}
			<input type="radio" name="can_move_own_topic" value="0" {if $permissions[12] == 0 || $permissions[12] == ""}checked="checked"{/if} /> {#FORUMS_NO#}
		</td>
	</tr>
	<tr>
		<td class="first">{#FORUMS_PERM_CAN_OPEN_CLOSE_OWN_TOPICS#}</td>
		<td class="second">
			<input type="radio" name="can_close_open_own_topic" value="1" {if $permissions[13] == 1 && $permissions[13] != ""}checked="checked"{/if} /> {#FORUMS_YES#}
			<input type="radio" name="can_close_open_own_topic" value="0" {if $permissions[13] == 0 || $permissions[13] == ""}checked="checked"{/if} /> {#FORUMS_NO#}
		</td>
	</tr>
	<tr>
		<td class="first">{#FORUMS_PERM_CAN_DEL_OWN_TOPICS#}</td>
		<td class="second">
			<input type="radio" name="can_delete_own_topic" value="1" {if $permissions[14] == 1 && $permissions[14] != ""}checked="checked"{/if} /> {#FORUMS_YES#}
			<input type="radio" name="can_delete_own_topic" value="0" {if $permissions[14] == 0 || $permissions[14] == ""}checked="checked"{/if} /> {#FORUMS_NO#}
		</td>
	</tr>	
	<tr>
		<td class="first">{#FORUMS_PERM_CAN_OPEN_TOPICS#}</td>
		<td class="second">
			<input type="radio" name="can_open_topic" value="1" {if $permissions[17] == 1 && $permissions[17] != ""}checked="checked"{/if} /> {#FORUMS_YES#}
			<input type="radio" name="can_open_topic" value="0" {if $permissions[17] == 0 || $permissions[17] == ""}checked="checked"{/if} /> {#FORUMS_NO#}
		</td>
	</tr>
	<tr>
		<td class="first">{#FORUMS_PERM_CAN_CLOSE_TOPIC#}</td>
		<td class="second">
			<input type="radio" name="can_close_topic" value="1" {if $permissions[18] == 1 && $permissions[18] != ""}checked="checked"{/if} /> {#FORUMS_YES#}
			<input type="radio" name="can_close_topic" value="0" {if $permissions[18] == 0 || $permissions[18] == ""}checked="checked"{/if} /> {#FORUMS_NO#}
		</td>
	</tr>
	<tr>
		<th colspan="2" class="tableheader">{#FORUMS_HEADER_PERM_CHANGES#}</th>
	</tr>
	<tr>
		<td class="first">{#FORUMS_PERM_CAN_CHANGE_TOPIC_TYPE#}</td>
		<td class="second">
			<input type="radio" name="can_change_topic_type" value="1" {if $permissions[19] == 1 && $permissions[19] != ""}checked="checked"{/if} /> {#FORUMS_YES#}
			<input type="radio" name="can_change_topic_type" value="0" {if $permissions[19] == 0 || $permissions[19] == ""}checked="checked"{/if} /> {#FORUMS_NO#}
		</td>
	</tr>
	<tr>
		<td class="first">{#FORUMS_PERM_CAN_MOVE_OTHER_TOPICS#}</td>
		<td class="second">
			<input type="radio" name="can_move_topic" value="1" {if $permissions[20] == 1 && $permissions[20] != ""}checked="checked"{/if} /> {#FORUMS_YES#}
			<input type="radio" name="can_move_topic" value="0" {if $permissions[20] == 0 || $permissions[20] == ""}checked="checked"{/if} /> {#FORUMS_NO#}
		</td>
	</tr>
	<tr>
		<td class="first">{#FORUMS_PERM_CAN_DEL_OTHER_TOPICS#}</td>
		<td class="second">
			<input type="radio" name="can_delete_topic" value="1" {if $permissions[21] == 1 && $permissions[21] != ""}checked="checked"{/if} /> {#FORUMS_YES#}
			<input type="radio" name="can_delete_topic" value="0" {if $permissions[21] == 0 || $permissions[21] == ""}checked="checked"{/if} /> {#FORUMS_NO#}
		</td>
	</tr>
{/if}
	<tr>
		<th colspan="2" class="selectrow">
			<input name="settoall" type="checkbox" id="settoall" value="1">
			{#FORUMS_PERM_SET_TO_ALL_GROUPS#}<br>
			<input class="button" type="submit" value="{#FORUMS_BUTTON_SAVE#}" />
	  </th>
	</tr>
</table>
</form>