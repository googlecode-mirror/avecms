<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>{#MAIN_PAGE_TITLE#} - {*#SUB_TITLE#*} ({$smarty.session.user_name|escape})</title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1251" />
<meta name="robots" content="noindex, nofollow" />
<meta http-equiv="pragma" content="no-cache" />
<meta name="generator" content="" />
<meta name="Expires" content="Mon, 06 Jan 1990 00:00:01 GMT" />
<link href="{$tpl_dir}/css/style.css" rel="stylesheet" type="text/css" />
<link href="{$tpl_dir}/js/jquery/css/mbTooltip.css" rel="stylesheet" type="text/css" media="screen" />
<script type="text/javascript" src="{$tpl_dir}/js/jquery/jquery.js"></script>
<script type="text/javascript" src="{$tpl_dir}/js/jquery/plugin/jquery.timers.js"></script>
<script type="text/javascript" src="{$tpl_dir}/js/jquery/plugin/jquery.dropshadow.js"></script>
<script type="text/javascript" src="{$tpl_dir}/js/jquery/plugin/mbTooltip.js"></script>
<script type="text/javascript" src="{$tpl_dir}/js/cpcode.js"></script>
</head>

<body>
	<table width="100%" height="100%" cellspacing="0" cellpadding="0" border="0">
		<tr>
			<td width="100%" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td id="tableheader_main">
							<div id="noticeAreaLogin">
								<a href="index.php"><strong>{#MAIN_PAGE_TITLE#}</strong><br />{#MAIN_LINK_HOME#}</a>
							</div>

							<div id="noticeAreaProfileSection">
								<div>{#MAIN_USER_ONLINE#} <strong style="color:#fff;">{$smarty.session.user_name|escape}</strong></div>
								<div><a onClick="return confirm('{#MAIN_LOGOUT_CONFIRM#}')" href="admin.php?do=logout">{#MAIN_LINK_LOGOUT#}</a></div>
							</div>

							<div id="noticeAreaReturnToSite">
								<a target="_blank" href="../index.php?module=login&action=wys_adm&sub=off"><strong>{#MAIN_LINK_SITE#}</strong></a><br />
								<a target="_blank" href="../index.php?module=login&action=wys_adm&sub=on">{#MAIN_LINK_SITE_GO#}</a>
							</div>

							<div class="noticeAreaHelp">
								<a target="_blank" id="noticeHelpIcon" href="http://www.avecms.ru/index.php?help={$smarty.get.do|escape|default:'main'}&action={$smarty.get.action|escape|default:'no'}&mod={$smarty.get.mod|escape|default:'no'}&moduleaction={$smarty.get.moduleaction|escape|default:'no'}" title="Помощь по данному разделу.">&nbsp;<br />&nbsp;</a>
							</div>
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td height="100%" width="100%" valign="top">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					{if $smarty.request.do != ''}
						<tr>
							<td valign="top" height="30">
								<br /><br />
								<div id="mainSectionLinks" style="height:30px;">
									<ul>
										{$navi}
									</ul>
								</div>
							</td>
						</tr>
					{/if}

					<tr>
						<td valign="top" id="content" height="100%">
							{$content}
						</td>
					</tr>
				</table>
			</td>
		</tr>

		<tr>
			<td width="100%" valign="bottom">
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
					<tr>
						<td id="tablebottom">{$smarty.const.APP_INFO}</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
</body>
</html>