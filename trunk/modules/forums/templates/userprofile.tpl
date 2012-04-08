
{include file="$inc_path/userpanel_forums.tpl"}
{include file="$inc_path/header_sthreads.tpl"}
{if $public==1}

<form method="post" action="index.php?module=userpage&amp;action=show&amp;uid={$smarty.get.user_id}">
<table width="100%" border="0" cellpadding="5" cellspacing="1" class="forum_tableborder">
  <tr>
    <td colspan="2" class="forum_header"><strong>{#PR_userprofile_from#} &#8222;{$user->BenutzerName}&#8220;</strong></td>
  </tr>
  <tr>
    <td width="200" class="forum_post_first">{#PR_onlinestatus#}</td>
    <td class="forum_post_second">{$user->OnlineStatus}</td>
  </tr>

   <tr>
     <td class="forum_post_first">{#IgnoreList#}</td>
     <td class="forum_post_second">
	 {if $Ignored=='1'}
	 {#IsInIgnore#}<a href="index.php?module=forums&amp;show=ignorelist&amp;remove={$smarty.get.user_id}"><strong>{#RemoveIgnore#}</strong></a>
	 {else}
	 <a href="index.php?module=forums&amp;show=ignorelist&amp;insert={$smarty.get.user_id}"><strong>{#InsertIgnore#}</strong></a>
	 {/if}
	 </td>
   </tr>
   {if $user->Pnempfang==1}
   <tr>
    <td width="200" class="forum_post_first">{#PN_SendPn#}</td>
    <td class="forum_post_second"><a href="index.php?module=forums&show=pn&action=new&to={cpencode val=$user->BenutzerName}"><strong>{#UserSendPn#}</strong></a></td>
  </tr>
  {/if}
  <tr>
    <td width="200" class="forum_post_first">{#PR_reged#}</td>
    <td class="forum_post_second">{$user->reg_time|date_format:$TIME_FORMAT|pretty_date}&nbsp;</td>
  </tr>
  {if $user->avatar}
  <tr>
    <td width="200" class="forum_post_first">{#PR_avatar#}</td>
    <td class="forum_post_second">{$user->avatar}</td>
  </tr>
  {/if}
  <tr>
    <td width="200" class="forum_post_first">{#PR_group#}</td>
    <td class="forum_post_second">{$user->GruppenName}</td>
  </tr>
  {if $user->postings > 0}
  <tr>
    <td width="200" class="forum_post_first">{#ThreadViewPosts#}</td>
    <td class="forum_post_second">
	{$user->postings} - <a href="index.php?module=forums&amp;show=userpostings&amp;user_id={$user->BenutzerId}"><strong>{#ShowAllPostings#}</strong></a></td>
  </tr>
  {/if}
  {if $user->Interessen_show==1 && $user->Interessen}
  <tr>
    <td width="200" class="forum_post_first">{#PR_int#}</td>
    <td class="forum_post_second">{$user->Interessen}</td>
  </tr>
  {/if}
   {if $user->Signatur_show==1 && $user->Signatur}
  <tr>
    <td width="200" class="forum_post_first">{#PR_sig#}</td>
    <td class="forum_post_second">{$user->Signatur}</td>
  </tr>
  {/if}
  {if $user->Webseite_show==1 && $user->Webseite}
  <tr>
    <td width="200" class="forum_post_first">{#PR_webO#}</td>
    <td class="forum_post_second"><a href="{$user->Webseite|escape:html|stripslashes}" target="_blank"><strong>{$user->Webseite|escape:html|stripslashes}</strong></a></td>
  </tr>
  {/if}

   {if $user->Email_show==1}
  <tr>
    <td width="200" class="forum_post_first">{#PR_RMailO#}</td>
    <td class="forum_post_second">{$user->email|escape:html|stripslashes}</td>
  </tr>
  {/if}

  {if $user->GeburtsTag_show && $user->GeburtsTag}
    <tr>
    <td width="200" class="forum_post_first">{#PR_birthO#}</td>
    <td class="forum_post_second">{$user->GeburtsTag|escape:html|stripslashes}</td>
  </tr>
  {/if}

  {if $user->Icq_show==1 && $user->Icq}
  <tr>
    <td width="200" class="forum_post_first">{#PR_icq#}</td>
    <td class="forum_post_second">{$user->Icq|escape:html|stripslashes}</td>
  </tr>
  {/if}
  {if $user->Skype_show==1 && $user->Skype}
  <tr>
    <td class="forum_post_first">{#PR_skype#}</td>
    <td class="forum_post_second">{$user->Skype|escape:html|stripslashes}</td>
  </tr>
  {/if}
  {if $user->Aim_show==1 && $user->Aim}
  <tr>
    <td class="forum_post_first">{#PR_aim#}</td>
    <td class="forum_post_second">{$user->Aim|escape:html|stripslashes}</td>
  </tr>
  {/if}
  {if $user->Emailempfang==1 && $smarty.session.user_id}
   <tr>
    <td colspan="2" class="forum_header"><strong>{#PR_sendmail#}</strong></td>
  </tr>
   <tr>
    <td class="forum_post_first">{#PR_mailsubject#}</td>
    <td class="forum_post_second"><input name="Betreff" type="text" id="Betreff" size="40" /></td>
  </tr>
   <tr>
     <td class="forum_post_first">{#PR_mailtext#}</td>
     <td class="forum_post_second"><textarea name="Nachricht" cols="40" rows="6" id="Nachricht"></textarea></td>
   </tr>
   <tr>
     <td class="forum_post_first">&nbsp;</td>
     <td class="forum_post_second"><input type="submit" class="button" value="{#PR_bsend#}" />
      <input name="SendMail" type="hidden" id="SendMail" value="1" />
      <input name="ToUser" type="hidden" id="ToUser" value="{$smarty.get.user_id}" /></td>
   </tr>
  {/if}
</table>
</form>
{else}
{#NoPublicProfile#}
{/if}