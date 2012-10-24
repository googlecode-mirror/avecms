{include file="$inc_path/userpanel_forums.tpl"}
{include file="$inc_path/header_sthreads.tpl"}

<form method="post" action="index.php?module=forums&show=publicprofile" enctype="multipart/form-data">
{if $errors}
	<table width="100%" border="0" cellpadding="10" cellspacing="1" class="forum_tableborder">
		<tr>
			<td class="forum_info_meta">
			<h2>{#FORUMS_PR_ERRORS#}</h2>
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
		<td width="200" class="forum_post_first">{#FORUMS_PR_ID_USERNAME#}</td>
		<td colspan="2" class="forum_post_second">{$smarty.session.user_id}</td>
    </tr>
	<tr>
		<td width="200" class="forum_post_first">{#FORUMS_PR_USER_NAME#}</td>
		<td colspan="2" class="forum_post_second">
	{if $changenick=='no'}
		{$r.uname|stripslashes}
	{else}
		<input name="uname" type="text" id="uname" value="{$r.uname|stripslashes}" size="40">
		{if $changenick_once==1}
			{#FORUMS_PN_CHANGENICK_ONCE#}
		{/if}
	{/if}
		</td>
    </tr>
	<tr>
		<td width="200" class="forum_post_first">{#FORUMS_PR_PROFILE#} {#FORUMS_SHOW_PUBLIC#}</td>
		<td colspan="2" class="forum_post_second">
			<label><input name="show_profile" type="checkbox" id="show_profile" value="1" {if $r.show_profile==1}checked="checked"{/if}></label>
		</td>
    </tr>
	<tr>
		<td class="forum_post_first">{#FORUMS_PR_INVISBLE#}</td>
		<td colspan="2" class="forum_post_second">
			<input name="invisible" type="checkbox" id="invisible" value="1" {if $r.invisible==1}checked="checked"{/if}>
		</td>
    </tr>
	<tr>
		<td class="forum_post_first">{#FORUMS_PR_EMAIL_RECEIPT#}</td>
		<td colspan="2" class="forum_post_second">
			<input name="email_receipt" type="checkbox" id="email_receipt" value="1" {if $r.email_receipt==1}checked="checked"{/if}>
		</td>
    </tr>
	<tr>
		<td class="forum_post_first">{#FORUMS_PR_PN_RECEIPT#}</td>
		<td colspan="2" class="forum_post_second">
			<input name="pn_receipt" type="checkbox" id="pn_receipt" value="1" {if $r.pn_receipt==1}checked="checked"{/if}>
		</td>
    </tr>
	<tr>
		<td width="200" class="forum_post_first"> {#FORUMS_PR_NOTIFY_EMAIL#}</td>
		<td width="200" class="forum_post_second">
			<input name="email" type="text" id="email" value="{$r.email|stripslashes}" size="40">
		</td>
		<td class="forum_post_second">
			<input name="email_show" type="checkbox" id="email_show" value="1" {if $r.email_show==1}checked="checked"{/if}>{#FORUMS_SHOW_PUBLIC#} {#FORUMS_ATTENTION#}
		</td>
	</tr>
	<tr>
		<td width="200" class="forum_post_first">{#FORUMS_PR_ICQ#}</td>
		<td width="200" class="forum_post_second">
			<input name="icq" type="text" id="icq" value="{$r.icq|stripslashes}" size="40">
		</td>
		<td class="forum_post_second">
			<input name="icq_show" type="checkbox" id="icq_show" value="1" {if $r.icq_show==1}checked="checked"{/if}>{#FORUMS_SHOW_PUBLIC#}
		</td>
	</tr>
	<tr>
		<td width="200" class="forum_post_first">{#FORUMS_PR_AIM#}</td>
		<td width="200" class="forum_post_second">
			<input name="aim" type="text" id="aim" value="{$r.aim|stripslashes}" size="40">
		</td>
		<td class="forum_post_second">
			<input name="aim_show" type="checkbox" id="aim_show" value="1" {if $r.aim_show==1}checked="checked"{/if}>{#FORUMS_SHOW_PUBLIC#}
		</td>
	</tr>
	<tr>
		<td class="forum_post_first">{#FORUMS_PR_SKYPE#}</td>
		<td class="forum_post_second">
			<input name="skype" type="text" id="skype" value="{$r.skype|stripslashes}" size="40">
		</td>
		<td class="forum_post_second">
			<input name="skype_show" type="checkbox" id="skype_show" value="1" {if $r.skype_show==1}checked="checked"{/if}>{#FORUMS_SHOW_PUBLIC#}
		</td>
	</tr>
	<tr>
		<td class="forum_post_first">{#FORUMS_PR_BIRTHDAY_2#}</td>
		<td class="forum_post_second">
			<input name="birthday" type="text" id="birthday" value="{$r.birthday}" size="10" maxlength="10">
		</td>
		<td class="forum_post_second">
			<input name="birthday_show" type="checkbox" id="birthday_show" value="1" {if $r.birthday_show==1}checked="checked"{/if}>{#FORUMS_SHOW_PUBLIC#}
		</td>
	</tr>
	<tr>
		<td class="forum_post_first">{#FORUMS_PR_WEB_SITE#}</td>
		<td class="forum_post_second">
			<input name="web_site" type="text" id="web_site" value="{$r.web_site|stripslashes}" size="40">
		</td>
		<td class="forum_post_second">
			<input name="web_site_show" type="checkbox" id="web_site_show" value="1" {if $r.web_site_show==1}checked="checked"{/if}>{#FORUMS_SHOW_PUBLIC#}
		</td>
	</tr>
	<tr>
		<td class="forum_post_first">{#FORUMS_PR_INTERESTS#}</td>
		<td class="forum_post_second">
			<textarea name="interests" cols="38" rows="5" id="interests">{$r.interests|stripslashes}</textarea>
		</td>
		<td class="forum_post_second">
			<label><input name="interests_show" type="checkbox" id="interests_show" value="1" {if $r.interests_show==1}checked="checked"{/if}>{#FORUMS_SHOW_PUBLIC#}</label>
		</td>
	</tr>
	<tr>
		<td class="forum_post_first">{#FORUMS_PR_SIGNATURE#}</td>
		<td class="forum_post_second">
			<textarea name="signature" cols="38" rows="5" id="signature">{$r.signature|stripslashes}</textarea>
		</td>
		<td class="forum_post_second">
			<label><input name="signature_show" type="checkbox" id="signature_show" value="1" {if $r.signature_show==1}checked="checked"{/if}>{#FORUMS_SHOW_PUBLIC#}</label>
		</td>
	</tr>
	<tr>
		<td class="forum_post_first">{#FORUMS_PR_GENDER#}</td>
		<td colspan="2" class="forum_post_second">
			<label><input type="radio" name="gender" value="male" {if $r.gender=='male'}checked{/if}>{#FORUMS_MALE#}</label>
			<label><input type="radio" name="gender" value="female" {if $r.gender=='female'}checked{/if}>{#FORUMS_FEMALE#}</label>
		</td>
	</tr>
{if $sys_avatars==1}
	<tr>
		<td class="forum_post_first">{#FORUMS_PR_SYS_AVATAR#}</td>
		<td colspan="2" class="forum_post_second">{$prefabAvatars}</td>
	</tr>
{/if}
	<tr>
		<td class="forum_post_first">{#FORUMS_PR_OWN_AVATAR_USE#}</td>
		<td colspan="2" class="forum_post_second">
			<input name="avatar_default" type="radio" value="1" {if $r.avatar_default=='1'}checked="checked"{/if} />{#FORUMS_YES#}
			<input name="avatar_default" type="radio" value="0" {if $r.avatar_default=='0'}checked="checked"{/if} />{#FORUMS_NO#} 
		</td>
	</tr>
	<tr>
		<td class="forum_post_first">{#FORUMS_PR_AVATAR#}</td>
		<td class="forum_post_second" colspan="2">
			<table border="0" cellspacing="1" cellpadding="4">
				<tr>
				{if $r.OwnAvatar}
					<td valign="top">{#FORUMS_PR_DEFAULT_AVATAR#}<br />{$r.OwnAvatar} </td>
				{/if}
				{if $r.avatar}
					<td valign="top">{#FORUMS_PR_OWN_AVATAR#}<br /><img src="{$smarty.const.UPLOAD_AVATAR_DIR}/{$r.avatar}" alt="" /></td>
				{/if}      
				</tr>
			</table>
			<input name="doupdate" type="hidden" id="doupdate" value="1">
		</td>
	</tr>
{if $r.avatar}
	<tr>
		<td class="forum_post_first">{#FORUMS_PR_DEL_AVATAR#}</td>
		<td class="forum_post_second" colspan="2">
			<input name="del_avatar" type="checkbox" id="del_avatar" value="1" />
		</td>
	</tr>
{/if}
{if $avatar_upload==1}
	<tr>
		<td class="forum_post_first">{#FORUMS_PR_NEW_OWN_AVATAR#}</td>
		<td class="forum_post_second">
			<input type="file" name="file" />
		</td>
		<td class="forum_post_second">
			{#FORUMS_PR_NEW_OWN_AVATAR_MAX#} {$avatar_width} x {$avatar_height} {#FORUMS_PR_NEW_OWN_AVATAR_PIX#} {$avatar_size} {#FORUMS_PR_NEW_OWN_AVATAR_KB#}
		</td>
	</tr>
{/if}
</table>
	<br />
	<input  type="submit" class="button" value="{#FORUMS_PR_BUTTON_SEND#}">
</form>