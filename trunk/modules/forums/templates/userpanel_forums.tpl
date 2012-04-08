<script language="javascript" src="modules/forums/js/common.js"></script>

{if $smarty.request.print!=1}
	<table width="100%"  border="0" cellpadding="4" cellspacing="1" class="forum_tableborder">
		<tr>
			<td valign="top" class="forum_info_main">
				{if $smarty.session.user_group == 2}
					{#FRegMessage#}
				{else}
					<strong>{#WelcomeStart#} {$smarty.session.forum_user_name},</strong><br />
					{#WelcomeMessage#}
				{/if}
{*
				<br /><br />
				{include file="$inc_path/search.tpl"}
*}
			</td>
			<td valign="top" nowrap="nowrap" class="forum_frame" style="padding: 8px;">
				{if $smarty.session.user_group != 2}
					<table width="100%" border="0" cellspacing="0" cellpadding="1">
						<tr>
							<td width="180" nowrap="nowrap"><img src="{$forum_images}forum/arrow.gif" alt="" border="0" class="absmiddle" /><a onclick="return confirm(\'{#LogoutC#}\');" href="index.php?module=login&amp;action=logout">{#Logout#}</a></td>
							<td width="180" nowrap="nowrap"><img src="{$forum_images}forum/arrow.gif" alt="" border="0" class="absmiddle" /><a href="index.php?module=forums&amp;show=pn">{#PN_Name#}</a></td>
							<td nowrap="nowrap"><img src="{$forum_images}forum/arrow.gif" alt="" border="0" class="absmiddle" /><a href="index.php?module=userpage&amp;action=change">{#MyProfilePublic#}</a></td>
						</tr>
						<tr>
							<td width="180" nowrap="nowrap"><img src="{$forum_images}forum/arrow.gif" alt="" border="0" class="absmiddle" /><a href="index.php?module=login&amp;action=profile">{#MyProfile#}</a></td>
							<td width="180" nowrap="nowrap"><img src="{$forum_images}forum/arrow.gif" alt="" border="0" class="absmiddle" /><a href="index.php?module=forums&amp;show=ignorelist&amp;action=showlist">{#IgnoreList#}</a> </td>
							<td nowrap="nowrap"><img src="{$forum_images}forum/arrow.gif" alt="" border="0" class="absmiddle" /><a href="index.php?module=forums&amp;show=myabos">{#ShowAbos#}</a></td>
						</tr>
					</table>
					<div style="padding:1px">
						<img src="{$forum_images}forum/arrow.gif" alt="" border="0" class="absmiddle" /><a href="index.php?module=forums&amp;show=pn">{#PN_Name#}:</a><a href="#"></a> новые: {if $PNunreaded != 0}<span class="forum_pn_unread">{$PNunreaded}</span>{else}{$PNunreaded}{/if} | прочитанные: {$PNreaded}
					</div>
				{else}
					<form action="index.php" method="post" name="login">
						<table width="100"  border="0" cellpadding="2" cellspacing="1">
							<tr>
								<td width="1%" nowrap="nowrap"><strong><label for="l_kname">{#LOgin#}</label></strong></td>
								<td width="1%" nowrap="nowrap"><input name="user_login" type="text" size="15" /></td>
								<td width="1%" nowrap="nowrap">&nbsp;</td>
							</tr>
							<tr>
								<td width="1%" nowrap="nowrap"><strong>{#Pass#}</strong></td>
								<td width="1%" nowrap="nowrap"><input name="user_pass" type="password" size="15" /></td>
								<td width="1%" nowrap="nowrap"><input name="Submit" type="submit" class="button" value="{#Login#}" />
									<input name="do" type="hidden" value="login" />
									<input name="module" value="login" type="hidden" />
									<input name="action" value="login" type="hidden" />
									<input name="redir" type="hidden" value="{$redir}" />
									<input name="SaveLogin" value="1" type="hidden" />
								</td>
							</tr>
						</table>
						<a title="{#ReminderInfo#}" href="index.php?module=login&amp;action=passwordreminder">{#FLostPass#}</a>
						&nbsp;|&nbsp;
						<a title="{#Info#}" href="index.php?module=login&amp;action=register">{#FReg#}</a>
					</form>
				{/if}
			</td>
		</tr>
	</table><br />
{/if}