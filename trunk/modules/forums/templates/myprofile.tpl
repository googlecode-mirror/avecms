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
	{$r.BenutzerName|stripslashes}
	{else}
	<input name="BenutzerName" type="text" id="BenutzerName" value="{$r.BenutzerName|stripslashes}" size="40">
	{if $changenick_once==1}Kann nur 1 x geändert werden!{/if}
	{/if}

	</td>
    </tr>
  <tr>
    <td width="200" class="forum_post_first">{#PR_Profile#} {#ShowPublic#}</td>
    <td colspan="2" class="forum_post_second"><label>
      <input name="ZeigeProfil" type="checkbox" id="ZeigeProfil" value="1" {if $r.ZeigeProfil==1}checked="checked"{/if}>
    </label></td>
    </tr>
  <tr>
    <td class="forum_post_first">{#PR_Invisble#}</td>
    <td colspan="2" class="forum_post_second"><input name="Unsichtbar" type="checkbox" id="Unsichtbar" value="1" {if $r.Unsichtbar==1}checked="checked"{/if}></td>
    </tr>
  <tr>
    <td class="forum_post_first">{#PR_RMails#}</td>
    <td colspan="2" class="forum_post_second"><input name="Emailempfang" type="checkbox" id="Emailempfang" value="1" {if $r.Emailempfang==1}checked="checked"{/if}></td>
    </tr>
	 <tr>
    <td class="forum_post_first">{#PR_RecievePn#}</td>
    <td colspan="2" class="forum_post_second"><input name="Pnempfang" type="checkbox" id="Pnempfang" value="1" {if $r.Pnempfang==1}checked="checked"{/if}></td>
    </tr>

  <tr>
    <td width="200" class="forum_post_first"> {#PR_RMail#}</td>
    <td width="200" class="forum_post_second"><input name="Email" type="text" id="Email" value="{$r.Email|stripslashes}" size="40"></td>
    <td class="forum_post_second">
      <input name="Email_show" type="checkbox" id="Email_show" value="1" {if $r.Email_show==1}checked="checked"{/if}>
    {#ShowPublic#} {#Attention#}	</td>
  </tr>
  <tr>
    <td width="200" class="forum_post_first">{#PR_icq#}</td>
    <td width="200" class="forum_post_second"><input name="Icq" type="text" id="Icq" value="{$r.Icq|stripslashes}" size="40"></td>
    <td class="forum_post_second"><input name="Icq_show" type="checkbox" id="Icq_show" value="1" {if $r.Icq_show==1}checked="checked"{/if}>
{#ShowPublic#}</td>
  </tr>
  <tr>
    <td width="200" class="forum_post_first">{#PR_aim#}</td>
    <td width="200" class="forum_post_second"><input name="Aim" type="text" id="Aim" value="{$r.Aim|stripslashes}" size="40"></td>
    <td class="forum_post_second"><input name="Aim_show" type="checkbox" id="Aim_show" value="1" {if $r.Aim_show==1}checked="checked"{/if}>
{#ShowPublic#}</td>
  </tr>
  <tr>
    <td class="forum_post_first">{#PR_skype#}</td>
    <td class="forum_post_second"><input name="Skype" type="text" id="Skype" value="{$r.Skype|stripslashes}" size="40"></td>
    <td class="forum_post_second"><input name="Skype_show" type="checkbox" id="Skype_show" value="1" {if $r.Skype_show==1}checked="checked"{/if}>
{#ShowPublic#}</td>
  </tr>
  <tr>
    <td class="forum_post_first">{#PR_birth#}</td>
    <td class="forum_post_second"><input name="GeburtsTag" type="text" id="GeburtsTag" value="{$r.GeburtsTag}" size="10" maxlength="10"></td>
    <td class="forum_post_second"><input name="GeburtsTag_show" type="checkbox" id="GeburtsTag_show" value="1" {if $r.GeburtsTag_show==1}checked="checked"{/if}>
{#ShowPublic#}</td>
  </tr>
  <tr>
    <td class="forum_post_first">{#PR_web#}</td>
    <td class="forum_post_second"><input name="Webseite" type="text" id="Webseite" value="{$r.Webseite|stripslashes}" size="40"></td>
    <td class="forum_post_second"><input name="Webseite_show" type="checkbox" id="Webseite_show" value="1" {if $r.Webseite_show==1}checked="checked"{/if}>
{#ShowPublic#}</td>
  </tr>
  <tr>
    <td class="forum_post_first">{#PR_int#}</td>
    <td class="forum_post_second">
      <textarea name="Interessen" cols="38" rows="5" id="Interessen">{$r.Interessen|stripslashes}</textarea> </td>
    <td class="forum_post_second"><label><input name="Interessen_show" type="checkbox" id="Interessen_show" value="1" {if $r.Interessen_show==1}checked="checked"{/if}>{#ShowPublic#}</label></td>
  </tr>
  <tr>
    <td class="forum_post_first">{#PR_sig#}</td>
    <td class="forum_post_second"><textarea name="Signatur" cols="38" rows="5" id="Signatur">{$r.Signatur|stripslashes}</textarea></td>
    <td class="forum_post_second"><label><input name="Signatur_show" type="checkbox" id="Signatur_show" value="1" {if $r.Signatur_show==1}checked="checked"{/if}>{#ShowPublic#}</label></td>
  </tr>
  <tr>
    <td class="forum_post_first">{#PR_gender#}</td>
    <td colspan="2" class="forum_post_second">
    <label><input type="radio" name="Geschlecht" value="male" {if $r.Geschlecht=='male'}checked{/if}>{#Male#}</label>
    <label><input type="radio" name="Geschlecht" value="female" {if $r.Geschlecht=='female'}checked{/if}>{#Female#}</label></td>
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
	<input name="AvatarStandard" type="radio" value="0" {if $r.AvatarStandard=='0'}checked="checked"{/if} />
	{#Yes#}
    <input name="AvatarStandard" type="radio" value="1" {if $r.AvatarStandard=='1'}checked="checked"{/if} />
    {#No#} </td>
    </tr>
  <tr>
    <td class="forum_post_first">{#PR_avatar#}</td>
    <td class="forum_post_second" colspan="2"><table border="0" cellspacing="1" cellpadding="4">
      <tr>
        {if $r.OwnAvatar}<td valign="top">{#PR_StdAvatar#}<br />{$r.OwnAvatar} </td>{/if}
        {if $r.Avatar}<td valign="top">{#PR_OwnAvatar#}<br /><img src="modules/forums/avatars/{$r.Avatar}" alt="" /></td>{/if}      </tr>

    </table>
	<input name="doupdate" type="hidden" id="doupdate" value="1">      </td>
  </tr>
  {if $r.Avatar}
  <tr>
  <td class="forum_post_first">{#PR_DelAvatar#}</td>
  <td class="forum_post_second" colspan="2"><input name="DelAvatar" type="checkbox" id="DelAvatar" value="1" /></td>
  </tr>
  {/if}
  {if $avatar_upload==1}
  <tr>
    <td class="forum_post_first">{#PR_NewOwnAvatar#}</td>
    <td class="forum_post_second">
      <input type="file" name="file" />	  </td>
    <td class="forum_post_second">Max. {$avatar_width} x {$avatar_height} Pixel bei {$avatar_size} Kb. </td>
  </tr>
  {/if}
</table>
<br />
<input  type="submit" class="button" value="{#PR_send#}">
</form>
