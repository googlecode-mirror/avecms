<div class="pageHeaderTitle">
<div class="h_module"></div>
    <div class="HeaderTitle"><h2>{#Perm_GroupsAll#}</h2></div>
    <div class="HeaderText">&nbsp;</div>
</div><br />
<form method="post" action="index.php?do=modules&action=modedit&mod=forums&moduleaction=group_perms&cp={$sess}&pop=1&group={$smarty.request.group}&save=1">
  <table width="100%" border="0" cellpadding="8" cellspacing="1" class="tableborder">
    <tr>
        <td colspan="2" class="tableheader">{#Rights#}</td>
    </tr>
    <tr>
		<td width="280" class="first">{#R_OwnAvatar#}</td>
		<td class="second"><input name="perm[]" type="checkbox" value="own_avatar" {if $smarty.request.group=='2'}disabled{else}{if in_array('own_avatar',$Perms)}checked {/if}{/if}></td>
    </tr>
    <tr>
        <td width="280" class="first">{#R_PN#}</td>
        <td class="second"><input name="perm[]" type="checkbox" value="canpn" {if $smarty.request.group=='2'}disabled{else}{if in_array('canpn',$Perms)}checked {/if}{/if}></td>
    </tr>
	<tr>
        <td width="280" class="first">{#R_SeeForums#}</td>
        <td class="second"><input name="perm[]" type="checkbox" value="accessforums" {if in_array('accessforums',$Perms)}checked {/if}></td>
    </tr>
	<tr>
        <td width="280" class="first">{#R_Search#}</td>
        <td class="second"><input name="perm[]" type="checkbox" value="cansearch" {if in_array('cansearch',$Perms)}checked {/if}></td>
    </tr>
	<tr>
        <td width="280" class="first">{#R_Last24#}</td>
        <td class="second"><input name="perm[]" type="checkbox" value="last24" {if in_array('last24',$Perms)}checked {/if}></td>
    </tr>
	<tr>
        <td width="280" class="first">{#R_Profile#}</td>
        <td class="second"><input name="perm[]" type="checkbox" value="userprofile" {if in_array('userprofile',$Perms)}checked {/if}></td>
    </tr>
	<tr>
        <td width="280" class="first">{#R_Changenick#}</td>
        <td class="second"><input name="perm[]" type="checkbox" value="changenick" {if $smarty.request.group=='2'}disabled{else}{if in_array('changenick',$Perms)}checked {/if}{/if}></td>
    </tr>
	<tr>
	    <td colspan="2" class="tableheader">{#R_SettingsOther#}</td>
	</tr>
	<tr>
	    <td width="280" class="first">{#R_Mas#}</td>
	    <td class="second"><input name="max_avatar_bytes" type="text" id="max_avatar_bytes" value="{$row->max_avatar_bytes}" size="5" maxlength="3"></td>
	</tr>
	<tr>
	    <td width="280" class="first">{#R_Amh#}</td>
	    <td class="second"><input name="max_avatar_height" type="text" id="max_avatar_height" value="{$row->max_avatar_height}" size="5" maxlength="3"></td>
	</tr>
	<tr>
	    <td width="280" class="first">{#R_Amw#}</td>
	    <td class="second"><input name="max_avatar_width" type="text" id="max_avatar_width" value="{$row->max_avatar_width}" size="5" maxlength="3"></td>
	</tr>
	<tr>
	    <td width="280" class="first">{#R_UploadAvatar#} </td>
	    <td class="second"><label>
	    <input name="upload_avatar" type="radio" value="1" {if $row->upload_avatar==1}checked{/if}>{#Yes#}
	    <input name="upload_avatar" type="radio" value="0" {if $row->upload_avatar==0}checked{/if}>{#No#} 
		</label></td>
	</tr>
	<tr>
	    <td width="280" class="first">{#R_MaxPn#}</td>
	    <td class="second"><input name="max_pn" type="text" id="max_pn" value="{$row->max_pn}" size="5" maxlength="3"></td>
	</tr>
	<tr>
	    <td width="280" class="first">{#R_MaxPnLength#}</td>
	    <td class="second"><input name="max_lenght_pn" type="text" id="max_lenght_pn" value="{$row->max_lenght_pn}" size="5" maxlength="5"></td>
	</tr>
	<tr>
	    <td width="280" class="first">{#R_MaxLengthPosts#}</td>
	    <td class="second"><input name="max_lenght_post" type="text" id="max_lenght_post" value="{$row->max_lenght_post}" size="5" maxlength="5"></td>
	</tr>
	<tr>
	    <td width="280" class="first">{#R_MaxAttachments#}</td>
	    <td class="second"><input name="max_attachments" type="text" id="max_attachments" value="{$row->max_attachments}" size="5" maxlength="2"></td>
	</tr>
	<tr>
	    <td width="280" class="first">{#R_MaxEditTime#}</td>
	    <td class="second"><input name="max_edit_period" type="text" id="max_edit_period" value="{$row->max_edit_period}" size="5" maxlength="4">{#R_Days#}</td>
	</tr>
	<tr>
	    <td class="second" colspan="2"><input type="submit" class="button" value="{#Save#}"></td>
	</tr>
  </table>
</form>