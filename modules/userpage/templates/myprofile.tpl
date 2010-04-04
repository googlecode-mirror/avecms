{strip}

<br />

{include file="$inc_path/userpanel_forums.tpl"}

{include file="$inc_path/header_sthreads.tpl"}

<form method="post" action="index.php?module=userpage&action=change" enctype="multipart/form-data">

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

<div class="mod_userpage_border_myprofile" align="center">

<div class="mod_userpage_header"><strong>{#Userdata#}</strong></div>

<div class="mod_userpage_content">



<table width="100%" border="0" cellpadding="4" cellspacing="1">

  <tr>

    <td width="200" class="mod_userpage_first">{#PR_Customer#}</td>

    <td colspan="2" class="mod_userpage_second">{$smarty.session.user_id}</td>

    </tr>

  <tr>

    <td width="200" class="mod_userpage_first">{#PR_UserName#}</td>

    <td colspan="2" class="mod_userpage_second">

	{if $changenick=='no'}

	{$r.BenutzerName|stripslashes}

	{else}

	<input name="BenutzerName" type="text" id="BenutzerName" value="{$r.BenutzerName|stripslashes}" size="40">

	{if $changenick_once==1}Kann nur 1 x geändert werden!{/if}

	{/if}



	</td>

    </tr>

  <tr>

    <td width="200" class="mod_userpage_first">{#PR_Profile#} {#ShowPublic#}</td>

    <td colspan="2" class="mod_userpage_second"><label>

      <input name="ZeigeProfil" type="checkbox" id="ZeigeProfil" value="1" {if $r.ZeigeProfil==1}checked="checked"{/if}>

    </label></td>

    </tr>

  <tr>

    <td class="mod_userpage_first">{#PR_Invisble#}</td>

    <td colspan="2" class="mod_userpage_second"><input name="Unsichtbar" type="checkbox" id="Unsichtbar" value="1" {if $r.Unsichtbar==1}checked="checked"{/if}></td>

    </tr>

  <tr>

    <td class="mod_userpage_first">{#PR_RMails#}</td>

    <td colspan="2" class="mod_userpage_second"><input name="Emailempfang" type="checkbox" id="Emailempfang" value="1" {if $r.Emailempfang==1}checked="checked"{/if}></td>

    </tr>

	 <tr>

    <td class="mod_userpage_first">{#PR_RecievePn#}</td>

    <td colspan="2" class="mod_userpage_second"><input name="Pnempfang" type="checkbox" id="Pnempfang" value="1" {if $r.Pnempfang==1}checked="checked"{/if}></td>

    </tr>



  <tr>

    <td width="200" class="mod_userpage_first"> {#PR_RMail#}</td>

    <td colspan="2" width="200" class="mod_userpage_second"><input name="Email" type="text" id="Email" value="{$r.Email|stripslashes}" size="40"></td>

  </tr>



    {if $show_geschlecht==1}

  <tr>

    <td class="mod_userpage_first">{#PR_gender#}</td>

    <td class="mod_userpage_second">

    <label><input type="radio" name="Geschlecht" value="male" {if $r.Geschlecht=='male'}checked{/if}>{#Male#}</label>

    <label><input type="radio" name="Geschlecht" value="female" {if $r.Geschlecht=='female'}checked{/if}>{#Female#}</label></td>

    </tr>

  {/if}

  </table>

  </div>

  </div>

    <br />

<div class="mod_userpage_border_myprofile" align="center">

<div class="mod_userpage_header"><strong>{#Profile#}</strong></div>

<div class="mod_userpage_content">



<table width="100%" border="0" cellpadding="4" cellspacing="1">

  <tr>

    <td width="200" class="mod_userpage_first">{#PR_icq#}</td>

    <td width="200" class="mod_userpage_second"><input name="Icq" type="text" id="Icq" value="{$r.Icq|stripslashes}" size="40"></td>

  </tr>

  <tr>

    <td width="200" class="mod_userpage_first">{#PR_aim#}</td>

    <td width="200" class="mod_userpage_second"><input name="Aim" type="text" id="Aim" value="{$r.Aim|stripslashes}" size="40"></td>

  </tr>

  <tr>

    <td class="mod_userpage_first">{#PR_skype#}</td>

    <td class="mod_userpage_second"><input name="Skype" type="text" id="Skype" value="{$r.Skype|stripslashes}" size="40"></td>

  </tr>

  {if $show_geburtstag==1}

  <tr>

    <td class="mod_userpage_first">{#PR_birth#}</td>

    <td class="mod_userpage_second"><input name="GeburtsTag" type="text" id="GeburtsTag" value="{$r.GeburtsTag}" size="10" maxlength="10">

  </tr>

  {/if}

  {if $show_webseite==1}

  <tr>

    <td class="mod_userpage_first">{#PR_web#}</td>

    <td class="mod_userpage_second"><input name="Webseite" type="text" id="Webseite" value="{$r.Webseite|stripslashes}" size="40"></td>

  </tr>

   {/if}

  {if $show_interessen==1}

  <tr>

    <td class="mod_userpage_first">{#PR_int#}</td>

    <td class="mod_userpage_second">

      <textarea name="Interessen" cols="38" rows="5" id="Interessen">{$r.Interessen|stripslashes}</textarea> </td>

  </tr>

  {/if}

  {if $show_signatur==1}

  <tr>

    <td class="mod_userpage_first">{#PR_sig#}</td>

    <td class="mod_userpage_second"><textarea name="Signatur" cols="38" rows="5" id="Signatur">{$r.Signatur|stripslashes}</textarea></td>

  </tr>

  {/if}



    {foreach from=$felder item=item}

  <tr>

  	<td class="mod_userpage_first">{$item->title}</td>

	<td class="mod_userpage_second">{$item->wert|stripslashes}</td>

  </tr>

  {/foreach}



  </table>

  </div>

  </div>



  {if $show_avatar==1}

  <br />

<div class="mod_userpage_border_myprofile" align="center">

<div class="mod_userpage_header"><strong>{#Avatar#}</strong></div>

<div class="mod_userpage_content">



<table width="100%" border="0" cellpadding="4" cellspacing="1">

{if $sys_avatars==1}

  <tr>

    <td class="mod_userpage_first">{#PR_SysAvatar#}</td>

    <td class="mod_userpage_second">{$prefabAvatars}</td>

  </tr>

 {/if}

  <tr>

    <td class="mod_userpage_first">{#PR_OwnAvatarUse#}</td>

    <td class="mod_userpage_second">

	<input name="AvatarStandard" type="radio" value="0" {if $r.AvatarStandard=='0'}checked="checked"{/if} />

	{#Yes#}

    <input name="AvatarStandard" type="radio" value="1" {if $r.AvatarStandard=='1'}checked="checked"{/if} />

    {#No#} </td>

    </tr>

  <tr>

    <td class="mod_userpage_first">{#PR_avatar#}</td>

    <td class="mod_userpage_second"><table border="0" cellspacing="1" cellpadding="4">

      <tr>

        {if $r.OwnAvatar}<td valign="top">{#PR_StdAvatar#}<br />{$r.OwnAvatar} </td>{/if}

        {if $r.Avatar}<td valign="top">{#PR_OwnAvatar#}<br /><img src="modules/forums/avatars/{$r.Avatar}" alt="" /></td>{/if}      </tr>



    </table>

	<input name="doupdate" type="hidden" id="doupdate" value="1">      </td>

  </tr>

  {if $r.Avatar}

  <tr>

  <td class="mod_userpage_first">{#PR_DelAvatar#}</td>

  <td class="mod_userpage_second"><input name="DelAvatar" type="checkbox" id="DelAvatar" value="1" /></td>

  </tr>

  {/if}

  {if $avatar_upload==1}

  <tr>

    <td class="mod_userpage_first">{#PR_NewOwnAvatar#}</td>

    <td class="mod_userpage_second">

      <input type="file" name="file" />	  </td>

    <td class="mod_userpage_second">Max. {$avatar_width} x {$avatar_height} Pixel bei {$avatar_size} Kb. </td>

  </tr>

  {/if}

 {/if}



</table>

</div>

</div>

<br />

<input  type="submit" class="button" value="{#PR_send#}">

</form>

{/strip}