{include file="$inc_path/userpanel_forums.tpl"}
{include file="$inc_path/header_sthreads.tpl"}
<form method="post" action="index.php?module=forums&show=publicprofile" enctype="multipart/form-data">
{if $errors}
  <table width="100%" border="0" cellpadding="10" cellspacing="1" class="forum_tableborder">
    <tr>
      <td class="forum_info_meta">
	  <h2>{#PR_errors#}</h2>
	  <ul>
{foreach from=$errors item=e}
	  <li>{$e}</li>
{/foreach}
	  </ul>
	  </td>
    </tr>
  </table>
 <br />
{/if}
<table width="100%" border="0" cellpadding="4" cellspacing="1" class="forum_tableborder">
  <tr>
    <td width="200" class="forum_post_first">{#PR_Customer#}</td>
    <td colspan="2" class="forum_post_second">{$smarty.session.user_id}</td>
    </tr>
  <tr>
    <td width="200" class="forum_post_first">{#PR_UserName#}</td>
    <td colspan="2" class="forum_post_second">
	{if $changenick=='no'}
	{$r.uname|stripslashes}
	{else}
	<input name="uname" type="text" id="uname" value="{$r.uname|stripslashes}" size="40">
	{if $changenick_once==1}Kann nur 1 x geдndert werden!{/if}
	{/if}
	</td>
    </tr>
  <tr>
    <td width="200" class="forum_post_first">{#PR_Profile#} {#ShowPublic#}</td>
    <td colspan="2" class="forum_post_second"><label>
      <input name="show_profile" type="checkbox" id="show_profile" value="1" {if $r.show_profile==1}checked="checked"{/if}>
    </label></td>
    </tr>
  <tr>
    <td class="forum_post_first">{#PR_Invisble#}</td>
    <td colspan="2" class="forum_post_second"><input name="invisible" type="checkbox" id="invisible" value="1" {if $r.invisible==1}checked="checked"{/if}></td>
    </tr>
  <tr>
    <td class="forum_post_first">{#PR_RMails#}</td>
    <td colspan="2" class="forum_post_second"><input name="email_receipt" type="checkbox" id="email_receipt" value="1" {if $r.email_receipt==1}checked="checked"{/if}></td>
    </tr>
	 <tr>
    <td class="forum_post_first">{#PR_RecievePn#}</td>
    <td colspan="2" class="forum_post_second"><input name="pn_receipt" type="checkbox" id="pn_receipt" value="1" {if $r.pn_receipt==1}checked="checked"{/if}></td>
    </tr>
  <tr>
    <td width="200" class="forum_post_first"> {#PR_RMail#}</td>
    <td width="200" class="forum_post_second"><input name="email" type="text" id="email" value="{$r.email|stripslashes}" size="40"></td>
    <td class="forum_post_second"><input name="email_show" type="checkbox" id="email_show" value="1" {if $r.email_show==1}checked="checked"{/if}>{#ShowPublic#} {#Attention#}</td>
  </tr>
  <tr>
    <td width="200" class="forum_post_first">{#PR_icq#}</td>
    <td width="200" class="forum_post_second"><input name="icq" type="text" id="icq" value="{$r.icq|stripslashes}" size="40"></td>
    <td class="forum_post_second"><input name="icq_show" type="checkbox" id="icq_show" value="1" {if $r.icq_show==1}checked="checked"{/if}>{#ShowPublic#}</td>
  </tr>
  <tr>
    <td width="200" class="forum_post_first">{#PR_aim#}</td>
    <td width="200" class="forum_post_second"><input name="aim" type="text" id="aim" value="{$r.aim|stripslashes}" size="40"></td>
    <td class="forum_post_second"><input name="aim_show" type="checkbox" id="aim_show" value="1" {if $r.aim_show==1}checked="checked"{/if}>{#ShowPublic#}</td>
  </tr>
  <tr>
    <td class="forum_post_first">{#PR_skype#}</td>
    <td class="forum_post_second"><input name="skype" type="text" id="skype" value="{$r.skype|stripslashes}" size="40"></td>
    <td class="forum_post_second"><input name="skype_show" type="checkbox" id="skype_show" value="1" {if $r.skype_show==1}checked="checked"{/if}>{#ShowPublic#}</td>
  </tr>
  <tr>
    <td class="forum_post_first">{#PR_birth#}</td>
    <td class="forum_post_second"><input name="birthday" type="text" id="birthday" value="{$r.birthday}" size="10" maxlength="10"></td>
    <td class="forum_post_second"><input name="birthday_show" type="checkbox" id="birthday_show" value="1" {if $r.birthday_show==1}checked="checked"{/if}>{#ShowPublic#}</td>
  </tr>
  <tr>
    <td class="forum_post_first">{#PR_web#}</td>
    <td class="forum_post_second"><input name="web_site" type="text" id="web_site" value="{$r.web_site|stripslashes}" size="40"></td>
    <td class="forum_post_second"><input name="web_site_show" type="checkbox" id="web_site_show" value="1" {if $r.web_site_show==1}checked="checked"{/if}>{#ShowPublic#}</td>
  </tr>
  <tr>
    <td class="forum_post_first">{#PR_int#}</td>
    <td class="forum_post_second"><textarea name="interests" cols="38" rows="5" id="interests">{$r.interests|stripslashes}</textarea> </td>
    <td class="forum_post_second"><label><input name="interests_show" type="checkbox" id="interests_show" value="1" {if $r.interests_show==1}checked="checked"{/if}>{#ShowPublic#}</label></td>
  </tr>
  <tr>
    <td class="forum_post_first">{#PR_sig#}</td>
    <td class="forum_post_second"><textarea name="signature" cols="38" rows="5" id="signature">{$r.signature|stripslashes}</textarea></td>
    <td class="forum_post_second"><label><input name="signature_show" type="checkbox" id="signature_show" value="1" {if $r.signature_show==1}checked="checked"{/if}>{#ShowPublic#}</label></td>
  </tr>
  <tr>
    <td class="forum_post_first">{#PR_gender#}</td>
    <td colspan="2" class="forum_post_second">
    <label><input type="radio" name="gender" value="male" {if $r.gender=='male'}checked{/if}>{#Male#}</label>
    <label><input type="radio" name="gender" value="female" {if $r.gender=='female'}checked{/if}>{#Female#}</label></td>
   </tr>
{if $sys_avatars==1}
  <tr>
    <td class="forum_post_first">{#PR_SysAvatar#}</td>
    <td colspan="2" class="forum_post_second">{$prefabAvatars}</td>
  </tr>
 {/if}
  <tr>
    <td class="forum_post_first">{#PR_OwnAvatarUse#}</td>
    <td colspan="2" class="forum_post_second">
		<input name="avatar_default" type="radio" value="1" {if $r.avatar_default=='1'}checked="checked"{/if} />{#Yes#}
		<input name="avatar_default" type="radio" value="0" {if $r.avatar_default=='0'}checked="checked"{/if} />{#No#} 
	</td>
  </tr>
  <tr>
    <td class="forum_post_first">{#PR_avatar#}</td>
    <td class="forum_post_second" colspan="2">
		<table border="0" cellspacing="1" cellpadding="4">
			<tr>
			{if $r.OwnAvatar}
				<td valign="top">{#PR_StdAvatar#}<br />{$r.OwnAvatar} </td>
			{/if}
			{if $r.avatar}
				<td valign="top">{#PR_OwnAvatar#}<br /><img src="{$smarty.const.UPLOAD_AVATAR_DIR}/{$r.avatar}" alt="" /></td>
			{/if}      
			</tr>
		</table>
			<input name="doupdate" type="hidden" id="doupdate" value="1">      </td>
  </tr>
{if $r.avatar}
  <tr>
    <td class="forum_post_first">{#PR_DelAvatar#}</td>
	<td class="forum_post_second" colspan="2"><input name="del_avatar" type="checkbox" id="del_avatar" value="1" /></td>
  </tr>
{/if}
{if $avatar_upload==1}
  <tr>
    <td class="forum_post_first">{#PR_NewOwnAvatar#}</td>
    <td class="forum_post_second"><input type="file" name="file" /></td>
    <td class="forum_post_second">Max. {$avatar_width} x {$avatar_height} Pixel bei {$avatar_size} Kb. </td>
  </tr>
{/if}
</table>
	<br />
	<input  type="submit" class="button" value="{#PR_send#}">
</form>