<div class="pageHeaderTitle">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#FORUMS_PERM_GROUPS_ALL#} <span style="color: #000;">&nbsp;&gt;&nbsp;{$row_group->user_group_name}</span></h2></div>
    <div class="HeaderText">&nbsp;</div>
</div><br />
<form method="post" action="index.php?do=modules&action=modedit&mod=forums&moduleaction=group_perms&cp={$sess}&pop=1&group={$smarty.request.group}&save=1">
  <table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
    <tr>
        <td colspan="2" class="tableheader">{#FORUMS_HEADER_PERM#}</td>
    </tr>
    <tr>
		<td width="280" class="first">{#FORUMS_PERM_G_OWN_AVATAR#}</td>
		<td class="second"><input name="perm[]" type="checkbox" value="own_avatar" {if $smarty.request.group=='2'}disabled{else}{if in_array('own_avatar',$Perms)}checked {/if}{/if}></td>
    </tr>
    <tr>
        <td width="280" class="first">{#FORUMS_PERM_G_PN#}</td>
        <td class="second"><input name="perm[]" type="checkbox" value="canpn" {if $smarty.request.group=='2'}disabled{else}{if in_array('canpn',$Perms)}checked {/if}{/if}></td>
    </tr>
	<tr>
        <td width="280" class="first">{#FORUMS_PERM_G_ACCESS_FORUMS#}</td>
        <td class="second"><input name="perm[]" type="checkbox" value="accessforums" {if in_array('accessforums',$Perms)}checked {/if}></td>
    </tr>
	<tr>
        <td width="280" class="first">{#FORUMS_PERM_G_CAN_SEARCH#}</td>
        <td class="second"><input name="perm[]" type="checkbox" value="cansearch" {if in_array('cansearch',$Perms)}checked {/if}></td>
    </tr>
	<tr>
        <td width="280" class="first">{#FORUMS_PERM_G_LAST24#}</td>
        <td class="second"><input name="perm[]" type="checkbox" value="last24" {if in_array('last24',$Perms)}checked {/if}></td>
    </tr>
	<tr>
        <td width="280" class="first">{#FORUMS_PERM_G_PROFILE#}</td>
        <td class="second"><input name="perm[]" type="checkbox" value="userprofile" {if in_array('userprofile',$Perms)}checked {/if}></td>
    </tr>
	<tr>
        <td width="280" class="first">{#FORUMS_PERM_G_CHANGE_NICK#}</td>
        <td class="second"><input name="perm[]" type="checkbox" value="changenick" {if $smarty.request.group=='2'}disabled{else}{if in_array('changenick',$Perms)}checked {/if}{/if}></td>
    </tr>
	<tr>
	    <td colspan="2" class="tableheader">{#FORUMS_PERM_G_SETTINGS_OTHER#}</td>
	</tr>
	<tr>
	    <td width="280" class="first">{#FORUMS_PERM_G_MAX_AVATAR_BYTES#}</td>
	    <td class="second"><input name="max_avatar_bytes" type="text" id="max_avatar_bytes" value="{$row->max_avatar_bytes}" size="5" maxlength="3" {if $smarty.request.group=='2'}disabled{/if}></td>
	</tr>
	<tr>
	    <td width="280" class="first">{#FORUMS_PERM_G_MAX_AVATAR_HEIGHT#}</td>
	    <td class="second"><input name="max_avatar_height" type="text" id="max_avatar_height" value="{$row->max_avatar_height}" size="5" maxlength="3" {if $smarty.request.group=='2'}disabled{/if}></td>
	</tr>
	<tr>
	    <td width="280" class="first">{#FORUMS_PERM_G_MAX_AVATAR_WIDTH#}</td>
	    <td class="second"><input name="max_avatar_width" type="text" id="max_avatar_width" value="{$row->max_avatar_width}" size="5" maxlength="3" {if $smarty.request.group=='2'}disabled{/if}></td>
	</tr>
	<tr>
	    <td width="280" class="first">{#FORUMS_PERM_G_UPLOAD_AVATAR#} </td>
	    <td class="second"><label>
	    <input name="upload_avatar" type="radio" value="1" {if $row->upload_avatar==1}checked{/if} {if $smarty.request.group=='2'}disabled{/if}>{#Yes#}
	    <input name="upload_avatar" type="radio" value="0" {if $row->upload_avatar==0}checked{/if} {if $smarty.request.group=='2'}disabled{/if}>{#No#} 
		</label></td>
	</tr>
	<tr>
	    <td width="280" class="first">{#FORUMS_PERM_G_MAX_PN#}</td>
	    <td class="second"><input name="max_pn" type="text" id="max_pn" value="{$row->max_pn}" size="5" maxlength="3" {if $smarty.request.group=='2'}disabled{/if}></td>
	</tr>
	<tr>
	    <td width="280" class="first">{#FORUMS_PERM_G_MAX_PN_LENGTH#}</td>
	    <td class="second"><input name="max_lenght_pn" type="text" id="max_lenght_pn" value="{$row->max_lenght_pn}" size="5" maxlength="5" {if $smarty.request.group=='2'}disabled{/if}></td>
	</tr>
	<tr>
	    <td width="280" class="first">{#FORUMS_PERM_G_MAX_LENGTH_POSTS#}</td>
	    <td class="second"><input name="max_lenght_post" type="text" id="max_lenght_post" value="{$row->max_lenght_post}" size="5" maxlength="5"></td>
	</tr>
	<tr>
	    <td width="280" class="first">{#FORUMS_PERM_G_MAX_ATTACHMENTS#}</td>
	    <td class="second"><input name="max_attachments" type="text" id="max_attachments" value="{$row->max_attachments}" size="5" maxlength="2"></td>
	</tr>
	<tr>
	    <td width="280" class="first">{#FORUMS_PERM_G_MAX_EDIT_TIME#}</td>
	    <td class="second"><input name="max_edit_period" type="text" id="max_edit_period" value="{$row->max_edit_period}" size="5" maxlength="4" {if $smarty.request.group=='2'}disabled{/if}>&nbsp;{#FORUMS_PERM_G_DAYS#}</td>
	</tr>
	<tr>
	    <td class="second" colspan="2"><input type="submit" class="button" value="{#FORUMS_BUTTON_SAVE#}"></td>
	</tr>
  </table>
</form>