<script language="javascript" src="modules/forums/js/common.js"></script>

{if $smarty.request.print!=1}
	<table width="100%"  border="0" cellpadding="4" cellspacing="1" class="forum_tableborder">
		<tr>
			<td valign="top" class="forum_info_main">
				{if $smarty.session.user_group == 2}
					{#FORUMS_FORUM_REG_MESSAGE#}
				{else}
					<strong>{#FORUMS_WELCOME_START#} {$smarty.session.forum_user_name},</strong><br />
					{#FORUMS_WELCOME_MESSAGE#}
				{/if}
			</td>
			<td valign="top" nowrap="nowrap" class="forum_frame" style="padding: 8px;">
				{if $smarty.session.user_group != 2}
					<table width="100%" border="0" cellspacing="0" cellpadding="1">
						<tr>
							<td width="180" nowrap="nowrap">
								<img src="{$forum_images}forum/arrow.gif" alt="" border="0" class="absmiddle" /><a onclick="return confirm('{#FORUMS_LOGOUT_CONFIRM#}');" href="index.php?module=login&amp;action=logout">{#FORUMS_BUTTON_LOGOUT#}</a>
							</td>
							<td width="180" nowrap="nowrap">
								<img src="{$forum_images}forum/arrow.gif" alt="" border="0" class="absmiddle" /><a href="index.php?module=forums&amp;show=pn">{#FORUMS_PN_NAME#}</a>
							</td>
							<td nowrap="nowrap">
								<img src="{$forum_images}forum/arrow.gif" alt="" border="0" class="absmiddle" /><a href="index.php?module=forums&amp;show=publicprofile">{#FORUMS_MY_PROFILE_PUBLIC#}</a>
							</td>
						</tr>
						<tr>
							<td width="180" nowrap="nowrap">
								<img src="{$forum_images}forum/arrow.gif" alt="" border="0" class="absmiddle" /><a href="index.php?module=login&amp;action=profile">{#FORUMS_MY_PROFILE#}</a>
							</td>
							<td width="180" nowrap="nowrap">
								<img src="{$forum_images}forum/arrow.gif" alt="" border="0" class="absmiddle" /><a href="index.php?module=forums&amp;show=ignorelist&amp;action=showlist">{#FORUMS_IGNORE_LIST#}</a>
							</td>
							<td nowrap="nowrap">
								<img src="{$forum_images}forum/arrow.gif" alt="" border="0" class="absmiddle" /><a href="index.php?module=forums&amp;show=myabos">{#FORUMS_SHOW_ABOS#}</a>
							</td>
						</tr>
					</table>
					<div style="padding:1px">
						<img src="{$forum_images}forum/arrow.gif" alt="" border="0" class="absmiddle" />
						<a href="index.php?module=forums&amp;show=pn">{#FORUMS_PN_NAME#}:</a>
						<a href="#"></a> {#FORUMS_PN_NEW_2#} 
						{if $PNunreaded != 0}
							<span class="forum_pn_unread">{$PNunreaded}</span>
						{else}
							{$PNunreaded}
						{/if} 
							| {#FORUMS_PN_READED#} {$PNreaded}
					</div>
				{else}
					<form action="index.php" method="post" name="login">
						<table width="100"  border="0" cellpadding="2" cellspacing="1">
							<tr>
								<td width="1%" nowrap="nowrap">
									<strong><label for="l_kname">{#FORUMS_LOGIN#}</label></strong>
								</td>
								<td width="1%" nowrap="nowrap">
									<input name="user_login" type="text" size="15" />
								</td>
								<td width="1%" nowrap="nowrap">
									&nbsp;
								</td>
							</tr>
							<tr>
								<td width="1%" nowrap="nowrap">
									<strong>{#FORUMS_PASS#}</strong>
								</td>
								<td width="1%" nowrap="nowrap">
									<input name="user_pass" type="password" size="15" />
								</td>
								<td width="1%" nowrap="nowrap">
									<input name="Submit" type="submit" class="button" value="{#FORUMS_BUTTON_LOGIN#}" />
									<input name="do" type="hidden" value="login" />
									<input name="module" value="login" type="hidden" />
									<input name="action" value="login" type="hidden" />
									<input name="redir" type="hidden" value="{$redir}" />
									<input name="SaveLogin" value="1" type="hidden" />
								</td>
							</tr>
						</table>
						<a title="{#FORUMS_REMINDER_INFO#}" href="index.php?module=login&amp;action=passwordreminder">{#FORUMS_FORUM_LOST_PASS#}</a>
						&nbsp;|&nbsp;
						<a title="{#FORUMS_INFO#}" href="index.php?module=login&amp;action=register">{#FORUMS_FORUM_REG#}</a>
					</form>
				{/if}
			</td>
		</tr>
	</table>
	<br />
{/if}